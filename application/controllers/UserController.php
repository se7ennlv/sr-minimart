<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('UserModel');
		$this->load->model('AppModel');
	}

	//======================== view render ========================//
	function UserView()
    {
        $this->load->view('users/UserView');
		$this->load->view('global/GlobalFunctions');
	}
	
	public function UserAddView()
	{
		$data['mgroups'] = $this->AppModel->FindAllMenuGroups();
		$data['menus'] = $this->AppModel->FindAllMenus();
		$data['actions'] = $this->UserModel->FindAllActionGranting();
		$data['depts'] = $this->AppModel->FindAllDept();
		$this->load->view('users/UserAdd', $data);

	}


	//========================== fetching ============================//
	public function FetchAllUsers()
    {
        $data = $this->UserModel->FindAllUsers();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }



	//============================= operates ===========================//
	public function InitInsertUser()
	{
		$this->UserModel->ExecuteInsertUser();
	}

	public function InitChangePass()
	{
		$this->UserModel->ExecuteChangePass();
	}

	public function InitDeleteUser($UserID)
	{
		$this->UserModel->ExecuteDeleteUser($UserID);
	}
	

}
