<?php

/**
 * jumlah pembangkit model
 * @author stelin
 */
class jumlah_pembangkit_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * for testing only
     *
     * call lap_rekap_pembangkit
     * @return object
     */
    public function testPembangkit()
    {
        $sql = "call lap_rekap_pembangkit(
            'Regional',
            '04'
        )";

        $query = $this->db->query($sql);

        return $query->result();
    }

    /**
     * get result data pembangkit
     * @param  array  $data from controller
     * @return object
     */
    public function getDataPembangkit($data)
    {
        $regional = $data['regional'];
        $levelId  = $data['level'];
        $cari     = $this->laccess->ai($data['cari']);
        $sql      = "call lap_rekap_pembangkit(
        '$regional',
        '$levelId',
        '$cari'
        )";
        $query = $this->db->query($sql);

        return $query->result();
    }

    public function getDetilPembangkit($data)
    {
        $kdunit  = $data['kd_unit'];
        $sql     = "CALL lap_detail_pembangkit('$kdunit')";
        $query   = $this->db->query($sql);

        return $query->result();
    }

    public function getAllDetailPembangkit($data)
    {
        $kdunit  = $data['kd_unit'];
        $sql     = "CALL lap_all_pembangkit('$kdunit')";
        $query   = $this->db->query($sql);

        return $query->result();
    }
}