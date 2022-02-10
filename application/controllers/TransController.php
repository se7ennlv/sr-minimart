<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TransController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('ItemModel');
		$this->load->model('EmpModel');
		$this->load->model('TransModel');
	}

	public function ShopView()
	{
		$data['groups'] = $this->ItemModel->FindAllItemGroups();
		$emps['emps'] = $this->EmpModel->FindAllEmps();

		$this->load->view('layout/Header');
		$this->load->view('shop/index', $data);
		$this->load->view('shop/NumeralModal');
		$this->load->view('shop/PaymentModal');
		$this->load->view('shop/EmpModal', $emps);
		$this->load->view('shop/LastInvoice');
		$this->load->view('shop/ShopScript');
		$this->load->view('global/InvoiceModal');
		$this->load->view('global/GlobalFunctions');
		$this->load->view('layout/Footer');
	}

	public function FetchDocNo()
	{
		$data = $this->TransModel->FindDocNo();
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function FetchAllPaymentTypes()
	{
		$data = $this->TransModel->FindAllPaymentType();
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function InitInsertTrans()
	{
		$this->TransModel->ExecuteInsertTrans();
	}

	public function InitInsertDetailSales()
	{
		$this->TransModel->ExecuteInsertDetailSales();
	}

	public function ExecuteOpenCashDW()
	{
		$this->load->view('services/OpenCashDW');
	}
}
