<?php 

class tangki_model extends CI_Model{
    public function __construct(){
        parent::__construct();
    }

    public function dashboard(){
        $sql   = "CALL lap_tangki_tera ('Regional','06');";
        $query = $this->db->query($sql);

        return $query->result();
    }

    public function fetch(){
        $vlevel= $data['vlevel'];
        $vlevelid = $data['vlevelid'];

        $sql   = "CALL lap_tangki_tera ('$vlevel','$vlevelid');";
        $query = $this->db->query($sql);

        return $query->result();
    }

    public function mget_grafik($data){
        $vlevel = $data['VLEVEL'];
        $vlevelid = $data['VLEVELID'];

        $sql = "CALL lap_tangki_tera ('$vlevel','$vlevelid')";
        $query = $this->db->query($sql);
            
        return $query->result();
    }
}
