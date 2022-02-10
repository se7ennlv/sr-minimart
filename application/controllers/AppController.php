<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AppController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('AppModel');
        $this->load->model('UserModel');
    }

    public function LoginView()
    {
        $this->load->view('app/LoginView');
    }

    public function ExecuteLogin()
    {
        $username = $this->input->post('Username');
        $password = sha1($this->input->post('Password'));
        $data = $this->UserModel->LoginValid($username, $password);

        if (!empty($data)) {
            $setData = array(
                'userId' => $data->UserID,
                'empId' => $data->UserEmpID,
                'username' => $data->UserUsername,
                'userFname' => $data->UserFname,
                'userLName' => $data->UserLname,
                'userMgroupId' => $data->UserMenuGroupID,
                'userMenuId'  => $data->UserMenuID,
                //'userGranting'  => $data->UserActionGranting,
                'userCreatedAt' => $data->UserCreatedAt
            );

            $dataArray = array(
                'status' => 'success',
                'message' => 'Login Success',
                'IsSaleman' => $data->UserIsSaleman
            );

            $this->session->set_userdata($setData);
            $this->output->set_content_type('application/json')->set_output(json_encode($dataArray));
        } else {
            $this->output->set_content_type('application/json')->set_output(json_encode(array('status' => 'danger', 'message' => 'Incorrect username or password')));
            $array_items = array('userId' => '', 'userFname' => '', 'userLName' => '');
            $this->session->unset_userdata($array_items);
        }
    }

    public function CheckAccount($username, $password)
    {
        $pwd = sha1($password);
        $data = $this->UserModel->LoginValid($username, $pwd);
        
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function ExecuteLogout()
    {
        $this->session->unset_userdata('userId');
        redirect('AppController/LoginView', 'refresh');

        exit;
    }

    public function CreditLimitView()
    {
        $this->load->view('app/CreditLimitView');
    }

    public function FetchCreditLimitInfo()
    {
        $data = $this->AppModel->FindCreditLimitInfo();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function InitInserCreditLimit()
    {
        if ($this->AppModel->CheckCreditLimitInfo() <= 0) {
            $this->AppModel->ExecuteInsertCreditLimit();
        } else {
            $this->AppModel->ExecuteUpdateCreditLimit();
        }
    }
}
