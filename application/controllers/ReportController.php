<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ReportController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ReportModel');
        $this->load->model('UserModel');
        $this->load->model('ServiceModel');
    }


    //============================ views render ==========================//
    public function ItemSaleView()
    {
        $this->load->view('reports/ItemSalesView');
        $this->load->view('global/InvoiceModal');
    }

    public function ItemDetailSaleView()
    {
        $this->load->view('reports/ItemDetailSaleView');
    }

    public function ItemSaleByGroupView()
    {
        $this->load->view('reports/ItemSaleByGroupView');
    }

    public function CreditView()
    {
        $data['pgroups'] = $this->ServiceModel->FindAllPayGroups();
        $this->load->view('reports/CreditView', $data);
    }

    public function SalDeductView()
    {
        $this->load->view('reports/SalDeductView');
    }

    public function VoideItemView()
    {
        $this->load->view('reports/VoidedItemView');
    }

    public function GraphView()
    {
        $this->load->view('reports/GraphView');
    }


    //=============================== data list ==============================//
    public function FetchAllItemDailySales($fDate, $tDate)
    {
        $data = $this->ReportModel->FindAllItemDailySales($fDate, $tDate);
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function FetchAllItemDetailSale()
    {
        $data['docs'] = $this->ReportModel->FindAllItemSale();
        $data['datas'] = $this->ReportModel->FindAllItemDetailSale();
        $data['fDate'] = $this->input->post('fromDate');
        $data['tDate'] = $this->input->post('toDate');

        $this->load->view('reports/ItemDetailSaleList', $data);
    }

    public function FetchAllVoidedItem($fDate, $tDate)
    {
        $data = $this->ReportModel->FindAllVoidedItem($fDate, $tDate);
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function FetchAllCredit($fDate, $tDate, $pgroup)
    {
        $data = $this->ReportModel->FindAllCredit($fDate, $tDate, $pgroup);
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function FetchAllSalDeduct($fDate, $tDate)
    {
        $data = $this->ReportModel->FindAllSalDeduct($fDate, $tDate);
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function FetchAllItemSaleByGroup($fDate, $tDate)
    {
        $data = $this->ReportModel->FindAllItemSaleByGroup($fDate, $tDate);
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function FetchBillData($docNo)
    {
        $data['trans'] = $this->ReportModel->FindTransData($docNo);
        $data['dts'] = $this->ReportModel->FindDetailSalesData($docNo);

        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function FetchSummaryReport()
    {
        $data['amt'] = $this->ReportModel->FindTotalAmount();
        $data['inv'] = $this->ReportModel->FindTotalInvoice();
        $data['credit'] = $this->ReportModel->FindCreditBalance();
        $data['bestItem'] = $this->ReportModel->FindItemBestSeller();
        $data['bestGroup'] = $this->ReportModel->FindGroupBestSeller();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function FetchLastInvoice()
    {
        $data = $this->ReportModel->FindLastInvoice();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }


    //=============================== transactions ==============================//
    public function InitVoidItem($tranId)
    {
        $this->ReportModel->ExecuteVoidItem($tranId);
    }
}
