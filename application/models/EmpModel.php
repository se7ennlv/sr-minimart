<?php

class EmpModel extends CI_Model
{
    public function FindOneEmp($empId)
    {
        $this->db->where('EmpCode', $empId);
        $query = $this->db->get('Employees');

        return $query->row();
    }

    public function FindAllEmps()
    {
        $query = $this->db->get('Employees');
        return $query->result();
    }

    public function FindOneCredit($empId)
    {
        $sql = "SELECT
                    ISNULL(SUM(TranAfterDisc), 0) AS [CreditBalance],
                    (SELECT OptValue FROM Options WHERE OptCode = 'CREDIT') AS [CreditLimited]
                FROM Transactions
                WHERE TranCustID = '{$empId}' AND TranIsPaid = 0 AND  TranIsVoid = 0";
        $query = $this->db->query($sql);

        return $query->row();
    }
    
 }
