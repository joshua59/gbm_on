<?php

class penerimaan_do_real_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function dashboard(){
        $sql   = "CALL lap_dashboard_penerimaan ('-','-','-','All',NULL)";
        $query = $this->db->query($sql);

        return $query->result();
    }

    public function fetchData($data){
        $bbm      = $data['jenis_bbm'];
        $tglAwal  = $data['tglAwal'];
        $tglAkhir = $data['tglAkhir'];
        $vlevel   = $data['vlevel'];
        $vlevelid = $data['vlevelid'];

        $sql    = "CALL lap_dashboard_penerimaan (
          '$bbm','$tglAwal','$tglAkhir','$vlevel','$vlevelid'
        )";
        $query = $this->db->query($sql);

        return $query->result();
    }

    public function get_detail($data){
        $bbm      = $data['jenis_bbm'];
        $tglAwal  = $data['tglAwal'];
        $tglAkhir = $data['tglAkhir'];
        $vlevel   = $data['vlevel'];
        $vlevelid = $data['vlevelid'];

        $sql    = "CALL lap_detail_do_real (
          '$bbm','$tglAwal','$tglAkhir','$vlevel','$vlevelid'
        )";
        $query = $this->db->query($sql);

        return $query->result();
    }

}
