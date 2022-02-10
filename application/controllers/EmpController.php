<?php
defined('BASEPATH') or exit('No direct script access allowed');

class EmpController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('EmpModel');
    }

    public function FetchOneEmp($empId)
    {
        $data['empInfo'] = $this->EmpModel->FindOneEmp($empId);
        $data['credBlance'] = $this->EmpModel->FindOneCredit($empId);
        
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function FetchOneOverdue($empId, $newOverdue)
    {
        $data = $this->EmpModel->FindOneCredit($empId, $newOverdue);
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function FetchAllEmps()
    {
        $data = $this->EmpModel->FindAllEmps();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

   
}
