<?php

class ItemModel extends CI_Model
{
	//================================================ Item groups ====================================//
	public function FindOneItemGroup($itemId)
	{
		$this->db->where('ItemGroupID', $itemId);
		$query = $this->db->get('ItemGroups');

		return $query->row();
	}

	public function FindAllItemGroups()
	{
		$query = $this->db->get('ItemGroups');
		return $query->result();
	}


	public function ExecuteInsertItemGroup()
	{
		$data = array(
			'ItemGroupName' => $this->input->post('ItemGroupName'),
			'ItemGroupLowStockAlert' => $this->input->post('ItemGroupLowStockAlert')
		);

		$this->db->insert('ItemGroups', $data);
		$this->output->set_content_type('application/json')->set_output(json_encode(array("status" => "success", "message" => 'Inserted.')));
	}

	public function ExecuteUpdateItemGroup()
	{
		$data = array(
			'ItemGroupName' => $this->input->post('ItemGroupName'),
			'ItemGroupLowStockAlert' => $this->input->post('ItemGroupLowStockAlert'),
			'ItemGroupUpdatedAt' => date('Y-m-d H:i:s')
		);

		$this->db->where('ItemGroupID', $this->input->post('ItemGroupID'));
		$this->db->update('ItemGroups', $data);
		$this->output->set_content_type('application/json')->set_output(json_encode(array("status" => "success", "message" => 'Updated.')));
	}

	public function ExecuteDeleteItemGroup($itemId)
	{
		$this->db->where('ItemGroupID', $itemId);
		$this->db->delete('ItemGroups');
		$this->output->set_content_type('application/json')->set_output(json_encode(array("status" => "success", "message" => 'Deleted.')));
	}
	//================================================ end ====================================//


	
	//================================================ items ====================================//
	public function FindOneItem($itemId)
	{
		$this->db->where('ItemID', $itemId);
		$query = $this->db->get('Items');

		return $query->row();
	}

	public function FindAllItems()
	{
		$this->db->select('*');
		$this->db->from('Items item');
		$this->db->join('ItemGroups group', 'group.ItemGroupID = item.ItemGroupID');
		$this->db->where('ItemIsActive', 1);
		$query = $this->db->get();

		return $query->result();
	}

	public function FindItemByItemGroup()
	{
		$groupId = $this->input->post('groupId');
		$itemData = trim($this->input->post('itemData'));

		$this->db->from('Items');

		if (!empty($groupId)) {
			$this->db->where('ItemGroupID', $groupId);

			if (!empty($itemData)) {
				$this->db->group_start();
				$this->db->like('ItemID', $itemData);
				$this->db->or_like('ItemBarcode', $itemData);
				$this->db->or_like('ItemName', $itemData);
				$this->db->group_end();
			}
		} else {
			$this->db->group_start();
			$this->db->like('ItemID', $itemData);
			$this->db->or_like('ItemBarcode', $itemData);
			$this->db->or_like('ItemName', $itemData);
			$this->db->group_end();
		}

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result();
		}else{
			return null;
		}
	}

	public function FindItemByBarcode()
	{
		$barcode = trim($this->input->post('barcode'));

		$this->db->where('ItemBarcode', $barcode);
		$query = $this->db->get('Items');

		if ($query->num_rows() > 0) {
			return $query->result();
		}else{
			return null;
		}
	}

	public function ExecuteInsertItem()
	{
		$data = array(
			'ItemBarcode' => $this->input->post('ItemBarcode'),
			'ItemCode' => $this->input->post('ItemCode'),
			'ItemName' => $this->input->post('ItemName'),
			'ItemCost' => $this->input->post('ItemCost'),
			'ItemPrice' => $this->input->post('ItemPrice'),
			'ItemGroupID' => $this->input->post('ItemGroupID'),
			'ItemStock' => $this->input->post('ItemStock'),
			'ItemCreatedAt' => date('Y-m-d H:i:s')
		);

		$this->db->insert('Items', $data);
		$this->output->set_content_type('application/json')->set_output(json_encode(array("status" => "success", "message" => 'Inserted')));
	}

	public function ExecuteUpdateItem()
	{
		$data = array(
			'ItemBarcode' => $this->input->post('ItemBarcode'),
			'ItemCode' => $this->input->post('ItemCode'),
			'ItemName' => $this->input->post('ItemName'),
			'ItemCost' => $this->input->post('ItemCost'),
			'ItemPrice' => $this->input->post('ItemPrice'),
			'ItemGroupID' => $this->input->post('ItemGroupID'),
			'ItemStock' => $this->input->post('ItemStock'),
			'ItemUpdatedAt' => date('Y-m-d H:i:s')
		);

		$this->db->where('ItemID', $this->input->post('ItemID'));
		$this->db->update('Items', $data);
		$this->output->set_content_type('application/json')->set_output(json_encode(array("status" => "success", "message" => 'Updated')));
	}

	public function ExecuteDeleteItem($itemId)
	{
		$data = array(
			'ItemIsActive' => 0,
			'ItemUpdatedAt' => date('Y-m-d H:i:s')
		);

		$this->db->where('ItemID', $itemId);
		$this->db->update('Items', $data);
		$this->output->set_content_type('application/json')->set_output(json_encode(array("status" => "success", "message" => 'Voided')));
	}
	//================================================ end ====================================//
}
