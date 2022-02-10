<?php
defined('BASEPATH') or exit('No direct script access allowed');

class InitController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('AppModel');

        if (!$this->session->userdata('userId')) {
            redirect('AppController/LoginView');
            exit;
        }
    }

    public function index()
    {
        $data['mgroups'] = $this->AppModel->FindMenuGroupBySession();
        $data['menus'] = $this->AppModel->FindMenuBySession();

        $this->load->view('layout/Header');
        $this->load->view('layout/Sidebar', $data);
        $this->load->view('init/index');
        $this->load->view('layout/Bottom');
        $this->load->view('layout/Footer');
        $this->load->view('layout/SidebarScript');
        $this->load->view('global/GlobalFunctions');
    }

}
