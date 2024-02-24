<?php
	
	/**
		 * @module Master Tangki
	*/
class verifikasi_coq_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}
	
	private $_table1 = "TRANS_COQ"; //nama table setelah mom_
	private $_table2 = "TRANS_COQ_RESULT"; //nama table setelah mom_
	private $_table3 = "TRANS_COQ_PEMBANGKIT"; //nama table setelah mom_
	private $_table4 = "M_USER";
    private $_table5 = "ROLES";
    private $_table6 = "TRANS_COQ_LOG";
	
	private function _key($key) { //unit ID
		if (!is_array($key)) {
			$key = array('ID_TRANS' => $key);
		}
		return $key;
	}

	public function data($data) {

		$p_jnsbbm 	 = $data['p_jnsbbm'];
        $p_pemasok   = $data['p_pemasok'];
        $p_depo      = $data['p_depo'];
		$p_tgl 		 = $data['p_tgl'];
		$p_tgl_akhir = $data['p_tgl_akhir'];
		$p_cari 	 = $data['p_cari'];
        
		$sql	     = "CALL lap_coq_verifikasi('$p_jnsbbm','$p_pemasok','$p_depo','$p_tgl','$p_tgl_akhir','$p_cari')";
		$query 		 = $this->db->query($sql);
        $this->db->close();
        $list 		 = $query->result_array();

		return $list;
	}

	public function get_data($id) {
	
		$sql	     = "CALL lap_coq('','','','','','','','','$id','','')";
		$query 		 = $this->db->query($sql);
        $this->db->close();
        $list 		 = $query->row();

		return $list;
	}

	function get_unit($id) {
        $sql = "SELECT r.ID_REGIONAL, r.NAMA_REGIONAL, m1.COCODE, m1.LEVEL1, m2.PLANT, m2.LEVEL2, m3.STORE_SLOC, m3.LEVEL3, 
                m4.SLOC, m4.LEVEL4
                FROM MASTER_LEVEL4 m4
                LEFT JOIN MASTER_LEVEL3 m3 ON m3.STORE_SLOC = m4.STORE_SLOC
                LEFT JOIN MASTER_LEVEL2 m2 ON m2.PLANT = m3.PLANT
                LEFT JOIN MASTER_LEVEL1 m1 ON m1.COCODE = m2.COCODE
                LEFT JOIN MASTER_REGIONAL r ON r.ID_REGIONAL = m1.ID_REGIONAL
                WHERE r.ID_REGIONAL = $id OR m1.COCODE = $id OR m2.PLANT = $id OR m3.STORE_SLOC = $id OR m4.SLOC = $id
                LIMIT 1";
        $list = $this->db->query($sql)->result_array();
        return $list;

    } 

	public function get_result_by_trxid($id){

		$q = "CALL lap_coq_result('$id')";
		$query = $this->db->query($q);
        $this->db->close();
        $list = $query->result_array();

		return $list;
    }

	public function options_jenis_bahan_bakar($default = '-- Pilih Jenis Bahan Bakar --'){

		$option = array();
		$option[''] = $default;
		$sql = "
        	SELECT * FROM (
	        	SELECT ID_JNS_BHN_BKR,NAMA_JNS_BHN_BKR FROM M_JNS_BHN_BKR
				WHERE ID_JNS_BHN_BKR NOT IN (004,005,003)
				UNION ALL
				SELECT KODE_JNS_BHN_BKR AS ID_JNS_BHN_BKR,NAMA_JNS_BHN_BKR FROM M_GROUP_JNS_BBM
        	) A 
        	ORDER BY A.NAMA_JNS_BHN_BKR ASC
    	";
        $list = $this->db->query($sql);
        
        foreach ($list->result() as $row) {
            $option[$row->ID_JNS_BHN_BKR] = $row->NAMA_JNS_BHN_BKR;
        }
        $this->db->close();
        return $option;
    }

    public function options_depo($default = '--Pilih Depo--') {
        $this->db->from('MASTER_DEPO');
        $this->db->where('ISAKTIF_DEPO','1');
        $this->db->order_by('NAMA_DEPO','ASC');

        $option = array();
        $list = $this->db->get();

        if (!empty($default)) {
            $option[''] = $default;
        }

        foreach ($list->result() as $row) {
            $option[$row->ID_DEPO] = $row->NAMA_DEPO;
        }
        $this->db->close();
        return $option;
    }

    public function options_review($default = '-- Pilih Status Review --') {
        $option = array();

        $this->db->from('DATA_SETTING');
        $this->db->where('KEY_SETTING','STATUS_REVIEW');
                
        $list = $this->db->get();
        
        $option[''] = $default;

        foreach ($list->result() as $row) {
            $option[$row->VALUE_SETTING] = $row->NAME_SETTING;
        }
        $this->db->close();
        return $option;
    }

    function get_one($field, $table, $where, $params)
    {
        $this->db->select($field);
        $this->db->from($table);
        $this->db->where($where, $params);
        $res = $this->db->get();
        if($res->num_rows()>0) {
            $row = $res->row();
            return $row;
        } else {
            return '';
        }   
    }

    public function get_pembangkit_by_trxid($id){

		$q = "CALL lap_coq_detail('$id','','','','','')";
		$query = $this->db->query($q);
        $this->db->close();
        $list = $query->result_array();
       
		return $list;
    }

         
    public function save($data, $key) {
        $this->db->trans_begin();

        $this->db->update($this->_table1, $data, $this->_key($key));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function save_as_new($data) {
        $this->db->trans_begin();
        $this->db->insert($this->_table6, $data);
        
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function get_nama($level,$kode) {

        if($level == '0') {
            $nama_level = 'PUSAT';
        } else {
            if($level == 'R') {
                $q = $this->db->query("SELECT NAMA_REGIONAL FROM MASTER_REGIONAL WHERE ID_REGIONAL = $kode")->row();
                $nama_level = $q->NAMA_REGIONAL;
            } else if($level == '1') {
                $q = $this->db->query("SELECT LEVEL1 FROM MASTER_LEVEL1 WHERE COCODE = $kode")->row();
                $nama_level = $q->LEVEL1;
            } else if($level == '2') {
                $q = $this->db->query("SELECT LEVEL2 FROM MASTER_LEVEL2 WHERE PLANT = $kode")->row();
                $nama_level = $q->LEVEL2;
            } else if($level == '3') {
                $q = $this->db->query("SELECT LEVEL3 FROM MASTER_LEVEL3 WHERE STORE_SLOC = $kode")->row();
                $nama_level = $q->LEVEL3;
            } else if($level == '4') {
                $q = $this->db->query("SELECT LEVEL4 FROM MASTER_LEVEL4 WHERE SLOC = $kode")->row();
                $nama_level = $q->LEVEL4;
            }
        }

        return $nama_level;
    }
}
