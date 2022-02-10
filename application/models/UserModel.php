
<?php

class UserModel extends CI_Model
{
	//======================== fetching =========================//
	public function FindAllUsers()
	{
		$this->db->select('*');
		$this->db->from('Users');
		$this->db->join('Departments', 'UserOrgID = OrgID');
		$this->db->where('UserIsActive', 1);
		$query = $this->db->get();

		return $query->result();
	}

	public function FindOneUserGranting()
	{
		$this->db->select('UserActionGranting');
		$this->db->where('UserID', $this->session->userdata('userId'));
		$query = $this->db->get('Users');
		
		return $query->row('UserActionGranting');
	}

	public function FindAllActionGranting()
	{
		$query = $this->db->get('ActionGranting');
		return $query->result();
	}


	//================================== operates ================================//
	public function ExecuteDeleteUser($UserID)
	{
		$data = array(
			'UserUpdatedAt' => date('Y-m-d H:i:s'),
			'UserIsActive' => 0
		);
		$this->db->where('UserEmpID', $UserID);
		$this->db->update('Users', $data);
	}

	public function LoginValid($usr, $pwd)
	{
		$this->db->where('UserUsername', $usr);
		$this->db->where('UserPassword', $pwd);
		$this->db->where('UserIsActive', 1);
		$query = $this->db->get('Users');

		return $query->row();
	}

	public function ExecuteInsertUser()
	{
		$data = array(
			'UserEmpID' => $this->input->post('UserEmpID'),
			'UserUsername' => $this->input->post('UserUsername'),
			'UserPassword' => sha1($this->input->post('UserPassword')),
			'UserFname' => $this->input->post('UserFname'),
			'UserLname' => $this->input->post('UserLname'),
			'UserOrgID' => $this->input->post('UserOrgID'),
			'UserMenuGroupID' => $this->input->post('mgroupId'),
			'UserMenuID' => $this->input->post('menuId'),
			'UserActionGranting' => $this->input->post('actions'),
			'UserIsSaleman' => $this->input->post('UserIsSaleman')
		);

		$this->db->insert('Users', $data);
		$this->output->set_content_type('application/json')->set_output(json_encode(array("status" => "success", "message" => 'Created.')));
	}

	public function ExecuteChangePass()
	{
		$data = array(
			'UserPassword' => sha1($this->input->post('NewPass')),
			'UserUpdatedAt' => date('Y-m-d H:i:s')
		);

		$this->db->where('UserID', $this->session->userdata('userId'));
		$this->db->update('Users', $data);

		$this->output->set_content_type('application/json')->set_output(json_encode(array("status" => "success", "message" => 'Password Changed.')));
	}
}
