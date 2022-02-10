<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ItemController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ItemModel');
    }

    //====================================== view render ====================================//
    function ItemGroupView()
    {
        $this->load->view('items/ItemGroupView');
        $this->load->view('global/GlobalFunctions');
    }

    function ItemView()
    {
        $data['groups'] = $this->ItemModel->FindAllItemGroups();
        $this->load->view('items/ItemView', $data);
        $this->load->view('global/GlobalFunctions');
    }




    //====================================== fetching ====================================//
    public function FetchOneItemGroup($itemGroupId)
    {
        $data = $this->ItemModel->FindOneItemGroup($itemGroupId);
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function FetchAllItemGroups()
    {
        $data = $this->ItemModel->FindAllItemGroups();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function FetchOneItem($itemId)
    {
        $data = $this->ItemModel->FindOneItem($itemId);
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function FetchAllItems()
    {
        $data = $this->ItemModel->FindAllItems();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function FetchItemByItemGroup()
    {
        $data = $this->ItemModel->FindItemByItemGroup();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function FetchItemByBarcode()
    {
        $data = $this->ItemModel->FindItemByBarcode();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }




    //====================================== operates ====================================//
    public function InitInsertItemGroup()
    {
        $this->ItemModel->ExecuteInsertItemGroup();
    }

    public function InitDeleteItemGroup($itemGroupId)
    {
        $this->ItemModel->ExecuteDeleteItemGroup($itemGroupId);
    }

    public function InitUpdateItemGroup()
    {
        $this->ItemModel->ExecuteUpdateItemGroup();
    }

    public function InitInsertItem()
    {
        $this->ItemModel->ExecuteInsertItem();
    }

    public function InitDeleteItem($itemId)
    {
        $this->ItemModel->ExecuteDeleteItem($itemId);
    }

    public function InitUpdateItem()
    {
        $this->ItemModel->ExecuteUpdateItem();
    }
}
