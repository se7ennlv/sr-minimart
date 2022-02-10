<?php

class ServiceModel extends CI_Model
{
    //======================== fetching =============================//
    public function FindAllPayGroups()
    {
        $query = $this->db->get('PayGroups');
        return $query->result();
    }
    
 }
