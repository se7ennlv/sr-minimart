<?php

class ReportModel extends CI_Model
{
    public function FindAllItemDailySales($fDate, $tDate)
    {
        $condition = "CONVERT(DATE, TranCreatedAt) BETWEEN '$fDate' AND '$tDate' ";

        $this->db->select('TranCreatedAt, TranDocNo, TranCustID, TranCustName, TranTotalAmount, TranDiscMoney, (TranTotalPaid - TranChangeAmount) AS Cash, TranTotalCredit, TranPaymentCode, TranCreatedBy');
        $this->db->where($condition, "", FALSE);
        $this->db->where('TranIsVoid', 0);
        $query = $this->db->get('Transactions');

        return $query->result();
    }

    public function FindAllItemSale()
    {
        $fromDate = $this->input->post('fromDate');
        $toDate = $this->input->post('toDate');
        $condition = "CONVERT(DATE, TranCreatedAt) BETWEEN '{$fromDate}' AND '{$toDate}' ";

        $this->db->where($condition, "", FALSE);
        $this->db->where('TranIsVoid', 0);
        $query = $this->db->get('Transactions');

        return $query->result();
    }

    public function FindAllItemDetailSale()
    {
        $fromDate = $this->input->post('fromDate');
        $toDate = $this->input->post('toDate');
        $condition = "CONVERT(DATE, DSCreatedAt) BETWEEN '{$fromDate}' AND '{$toDate}'";

        $this->db->where($condition, "", FALSE);
        $query = $this->db->get('DetailSales');

        return $query->result();
    }

    public function FindAllVoidedItem($fDate, $tDate)
    {
        $condition = "CONVERT(DATE, TranCreatedAt) BETWEEN '{$fDate}' AND '{$tDate}'";

        $this->db->where($condition, "", FALSE);
        $this->db->where('TranIsVoid', 1);
        $query = $this->db->get('Transactions');

        return $query->result();
    }

    public function FindAllCredit($fDate, $tDate, $pgroup)
    {
        if ($pgroup == '0') {
            $sql = "SELECT TranCustID, TranCustName, Dept, Positions, SUM(TranAfterDisc) AS [TotalCredit]
            FROM Transactions
            INNER JOIN Employees ON TranCustID = EmpCode
            WHERE TranIsPaid = 0 AND CONVERT(DATE, TranCreatedAt) BETWEEN '{$fDate}' AND '{$tDate}' 
            GROUP BY TranCustID, TranCustName, Dept, Positions ";
        } else {
            $sql = "SELECT TranCustID, TranCustName, Dept, Positions, SUM(TranAfterDisc) AS [TotalCredit]
            FROM Transactions
            INNER JOIN Employees ON TranCustID = EmpCode
            WHERE TranIsPaid = 0 AND CONVERT(DATE, TranCreatedAt) BETWEEN '{$fDate}' AND '{$tDate}' AND PayCode = '{$pgroup}'
            GROUP BY TranCustID, TranCustName, Dept, Positions ";
        }


        $query = $this->db->query($sql);

        return $query->result();
    }

    public function FindAllSalDeduct($fDate, $tDate)
    {
        $sql = "SELECT TranCustID, TranCustName, Dept, Positions, SUM(TranAfterDisc) AS [TotalCredit]
                FROM Transactions
                INNER JOIN Employees ON TranCustID = EmpCode
                WHERE TranIsPaid = 1 AND TranPaymentCode = 'SALDEDUCT' AND CONVERT(DATE, TranCreatedAt) BETWEEN '{$fDate}' AND '{$tDate}'
                GROUP BY TranCustID, TranCustName, Dept, Positions
                ";

        $query = $this->db->query($sql);

        return $query->result();
    }

    public function FindAllItemSaleByGroup($fDate, $tDate)
    {
        $sql = "SELECT ItemGroupName, ItemCode, ItemName, DSItemPrice, SUM(DSItemQty) AS [Qty], (DSItemPrice * SUM(DSItemQty)) AS [Amount]
                FROM DetailSales
                INNER JOIN Items item ON DSItemID = item.ItemID
                INNER JOIN ItemGroups grp ON item.ItemGroupID = grp.ItemGroupID
                WHERE CONVERT(DATE, DSCreatedAt) BETWEEN '{$fDate}' AND '{$tDate}'
                GROUP BY ItemGroupName, ItemCode, ItemName, DSItemPrice
                ";
        $query = $this->db->query($sql);

        return $query->result();
    }

    public function FindTransData($docNo)
    {
        $this->db->select("TranDocNo, TranCreatedAt, TranCreatedBy, TranCustID +'-'+TranCustName AS TranCustName, TranTotalAmount, TranDiscPercent, TranPaymentCode, TranAfterDisc");
        $this->db->where('TranDocNo', $docNo);
        $query = $this->db->get('Transactions');

        return $query->row();
    }

    public function FindDetailSalesData($docNo)
    {
        $this->db->where('DSDocNo', $docNo);
        $query = $this->db->get('DetailSales');

        return $query->result();
    }

    public function FindTotalAmount()
    {
        $fDate = $this->input->post('fromDate');
        $tDate = $this->input->post('toDate');
        $whereStr = "";

        if (!empty($fDate) && !empty($tDate)) {
            $whereStr = "CONVERT(DATE, TranCreatedAt) BETWEEN '{$fDate}' AND '{$tDate}'";
        } else {
            $whereStr = "CONVERT(DATE, TranCreatedAt) = CONVERT(DATE, GETDATE())";
        }

        $sql = "SELECT SUM(TranAfterDisc) AS [TotalAmount]
                FROM Transactions 
                WHERE {$whereStr}
            ";
        $query = $this->db->query($sql);

        return $query->row();
    }

    public function FindTotalInvoice()
    {
        $fDate = $this->input->post('fromDate');
        $tDate = $this->input->post('toDate');
        $whereStr = "";

        if (!empty($fDate) && !empty($tDate)) {
            $whereStr = "CONVERT(DATE, TranCreatedAt) BETWEEN '{$fDate}' AND '{$tDate}'";
        } else {
            $whereStr = "CONVERT(DATE, TranCreatedAt) = CONVERT(DATE, GETDATE())";
        }

        $sql = "SELECT COUNT(*) AS [TotalInvoice]
                FROM Transactions 
                WHERE {$whereStr}
            ";
        $query = $this->db->query($sql);

        return $query->row();
    }

    public function FindCreditBalance()
    {
        $fDate = $this->input->post('fromDate');
        $tDate = $this->input->post('toDate');
        $whereStr = "";

        if (!empty($fDate) && !empty($tDate)) {
            $whereStr = "CONVERT(DATE, TranCreatedAt) BETWEEN '{$fDate}' AND '{$tDate}' AND TranPaymentCode = 'CREDIT' ";
        } else {
            $whereStr = "CONVERT(DATE, TranCreatedAt) = CONVERT(DATE, GETDATE()) AND TranPaymentCode = 'CREDIT'";
        }

        $sql = "SELECT SUM(TranAfterDisc) AS [CreditBlance]
                FROM Transactions 
                WHERE {$whereStr}
            ";
        $query = $this->db->query($sql);

        return $query->row();
    }

    public function FindItemBestSeller()
    {
        $fDate = $this->input->post('fromDate');
        $tDate = $this->input->post('toDate');
        $whereStr = "";

        if (!empty($fDate) && !empty($tDate)) {
            $whereStr = "CONVERT(DATE, DSCreatedAt) BETWEEN '{$fDate}' AND '{$tDate}'";
        } else {
            $whereStr = "CONVERT(DATE, DSCreatedAt) = CONVERT(DATE, GETDATE())";
        }

        $sql = "SELECT TOP(10) ItemName, SUM(DSItemQty) AS [TotalQty]
                FROM DetailSales
                INNER JOIN Items item ON DSItemID = item.ItemID
                INNER JOIN ItemGroups grp ON item.ItemGroupID = grp.ItemGroupID
                WHERE {$whereStr}
                GROUP BY ItemName
                ORDER BY SUM(DSItemQty) DESC ";
        $query = $this->db->query($sql);

        return $query->result();
    }

    public function FindGroupBestSeller()
    {
        $fDate = $this->input->post('fromDate');
        $tDate = $this->input->post('toDate');
        $whereStr = "";

        if (!empty($fDate) && !empty($tDate)) {
            $whereStr = "CONVERT(DATE, DSCreatedAt) BETWEEN '{$fDate}' AND '{$tDate}'";
        } else {
            $whereStr = "CONVERT(DATE, DSCreatedAt) = CONVERT(DATE, GETDATE())";
        }

        $sql = "SELECT TOP(5) ItemGroupName, SUM(DSTotalPrice) AS [TotalPrice]
                FROM DetailSales
                INNER JOIN Items item ON DSItemID = item.ItemID
                INNER JOIN ItemGroups grp ON item.ItemGroupID = grp.ItemGroupID
                WHERE {$whereStr}
                GROUP BY ItemGroupName 
                ";
        $query = $this->db->query($sql);

        return $query->result();
    }

    public function FindLastInvoice()
    {
        $this->db->select("TranDocNo, TranPaymentCode, TranCreatedBy, FORMAT(TranCreatedAt, 'yyyy-MM-dd H:m:s') AS [CreatedAt]");
        $this->db->where('TranIsVoid', 0);
        $this->db->limit(5);
        $this->db->order_by('TranID', 'desc');
        $query = $this->db->get('Transactions');

        return $query->result();
    }

    public function ExecuteVoidItem($docNo)
    {
        $data = array(
            'TranIsVoid' => 1,
            'TranUpdatedAt' => date('Y-m-d H:i:s'),
            'TranUpdatedBy' => $this->session->userdata('username')
        );

        $this->db->where('TranDocNo', $docNo);
        $this->db->update('Transactions', $data);

        if ($this->db->affected_rows() > 0) {
            $this->output->set_content_type('application/json')->set_output(json_encode(array("status" => "success", "message" => 'Voided.')));
        }
    }
}
