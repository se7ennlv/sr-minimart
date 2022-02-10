<?php

class AppModel extends CI_Model
{
    public function FindAllMenuGroups()
    {
        $this->db->where('MGroupIsActive', 1);
        $this->db->order_by('MGroupOrderBy', 'asc');
        $query = $this->db->get('MenuGroups');
        return $query->result();
    }

    public function FindAllMenus()
    {
        $this->db->where('MenuIsActive', 1);
        $this->db->order_by('MenuOrderBy', 'asc');
        $query = $this->db->get('Menus');
        return $query->result();
    }

    public function FindMenuGroupBySession()
    {
        $this->db->select('*');
        $this->db->from('MenuGroups');
        $this->db->where('MGroupIsActive', 1);
        $this->db->where_in('MGroupID', $this->session->userdata('userMgroupId'), false);
        $this->db->order_by("MGroupOrderBy", "ASC");
        $qurey = $this->db->get();

        return $qurey->result();
    }

    public function FindMenuBySession()
    {
        $this->db->select('*');
        $this->db->from('Menus');
        $this->db->where('MenuIsActive', 1);
        $this->db->where_in('MenuID', $this->session->userdata('userMenuId'), false);
        $this->db->order_by("MenuOrderBy", "ASC");
        $qurey = $this->db->get();

        return $qurey->result();
    }

    public function CheckCreditLimitInfo()
    {
        $this->db->where('OptCode', 'CREDIT');
        $query = $this->db->get('Options');

        return $query->num_rows();
    }

    public function FindCreditLimitInfo()
    {
        $this->db->where('OptCode', 'CREDIT');
        $query = $this->db->get('Options');

        return $query->row();
    }

    public function ExecuteInsertCreditLimit()
    {
        $data = array(
            'OptCode' => 'CREDIT',
            'OptValue' => floatval(str_replace(',', '', $this->input->post('OptVal')))
        );

        $this->db->insert('Options', $data);
        $this->output->set_content_type('application/json')->set_output(json_encode(array("status" => "success", "message" => 'Save.')));
    }

    public function ExecuteUpdateCreditLimit()
    {
        $data = array(
            'OptValue' => floatval(str_replace(',', '', $this->input->post('OptVal')))
        );

        $this->db->where('OptCode', 'CREDIT');
        $this->db->update('Options', $data);
        $this->output->set_content_type('application/json')->set_output(json_encode(array("status" => "success", "message" => 'Updated.')));
    }

    public function FindAllDept()
    {
        $query = $this->db->get('Departments');
        return $query->result();
    }
}
