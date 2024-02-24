<?php

/**
 * penerimaan bbm model
 * @author stelin
 */
class realisasi_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * get data model
     * @param  array  $data passing from controller
     * @return object
     */
    public function rekapNominasi($data)
    {
        $BULAN                = $data['bulan'];
        $TAHUN                = $data['tahun'];
        $VLEVEL_REGIONAL      = $data['idregional'];
        $VLEVELID             = $data['vlevelid'];
        $cari                 = $this->laccess->ai($data['cari']);

        $sql = "CALL lap_rekap_nominasi('$BULAN','$TAHUN','$VLEVEL_REGIONAL','$VLEVELID', '$cari');";

        $query = $this->db->query($sql);

        return $query->result();
    }

    public function getDetilNominasi($data)
    {
        $kdunit = $data['kd_unit'];
        $bulan  = $data['bulan'];

        $sql   = "CALL lap_detail_nominasi('$bulan', '$kdunit')";
        $query = $this->db->query($sql);

        return $query->result();
    }

    public function getJadwal($data)
    {
      $kd_sloc = $data['kd_sloc'];
      $bulan  = $data['bulan'];

      $sql   = "CALL lap_jadwal_nominasi('$bulan', '$kd_sloc')";
      $query = $this->db->query($sql);

      return $query->result();
    }
}
