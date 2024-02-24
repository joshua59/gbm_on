<?php
	
	
class dashboard_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}
	
	private $_table1 = "ate";
	private $_table2 = "m_mapping_taksonomi";
	private $_table3 = "jawab_ate";
	private $_table4 = "taks_ate";
	private $_table6 = "penanggung_jawab_taksonomi";
	private $_table5 = "lampiran_ate";
	private $_tbluser = "user";
	private $_tbllog = "log_ate";
	private $_tbl_taksonomi="taksonomi";
	private $_tbl_maps_taks="mapp_taks";
	
	
    public function get_berita() {
        // $cari = $this->laccess->ai($this->input->post('kata_kunci'));

        $this->db->from("BERITA");
        $this->db->where("POSTING","1");
        $this->db->order_by("URUTAN ASC");

        $query = $this->db->get();
        $this->db->close();
        return $query->result();  
    }

}	