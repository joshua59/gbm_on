<?php
	
	/**
		 * @module Master Tangki
	*/
class coq_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}
	
	private $_table1 = "TRANS_COQ"; //nama table setelah mom_
	private $_table2 = "TRANS_COQ_RESULT"; //nama table setelah mom_
	private $_table3 = "TRANS_COQ_PEMBANGKIT"; //nama table setelah mom_
	private $_table4 = "M_USER";
    private $_table5 = "ROLES";
	
	private function _key($key) { //unit ID
		if (!is_array($key)) {
			$key = array('ID_TRANS' => $key);
		}
		return $key;
	}

	public function data($data) {
		$p_cari    = $data['p_cari'];
		$p_pemasok = $data['p_pemasok'];
		$p_depo    = $data['p_depo'];
		$p_user    = $data['p_user'];
		$p_status  = $data['p_status'];
		$p_kode    = $this->session->userdata('kode_level');
		$q 		   = "CALL lap_coq('','','','$p_pemasok','','','$p_cari','$p_status','','$p_depo','$p_user')";
		$query 	   = $this->db->query($q);

        $this->db->close();
        $list 	   = $query->result_array();

		return $list;
	}

	public function data_edit($id) {
		$q = "CALL lap_coq('','','','','','','','','$id','','')";
		$query = $this->db->query($q)->row();
        $this->db->close();
        
        return $query;
	}

	public function dataEdit($key=''){
		$this->db->from($this->_table1);
		
		if (!empty($key) || is_array($key))
        $this->db->where_condition($this->_key($key));
		
		return $this->db;
	}
	
	public function save_as_new($data) {
		$this->db->trans_begin();
		$this->db->insert($this->_table1, $data);
		
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return FALSE;
		} else {
			$this->db->trans_commit();
			return TRUE;
		}
	}

	public function save_as_new_file($data_file,$id) {
        $this->db->trans_begin();
        $this->db->insert('TRANS_COQ_DOC', $data_file);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function update_file($data_file,$id) {
    	$this->db->trans_begin();
    	$this->db->where('ID_TRANS',$id);
    	$this->db->update('TRANS_COQ_DOC',$data_file);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
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

	public function kirim($data, $key) {
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

	public function update_review($data, $key) {
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

	public function delete($key) {		
		$this->db->trans_begin();				
		$this->db->delete($this->_table1, $this->_key($key));
		$this->db->delete($this->_table2, $this->_key($key));
		$this->db->delete($this->_table3, $this->_key($key));
		
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return FALSE;
			} else {
			$this->db->trans_commit();
			return TRUE;
		}
	}

	public function delete_document($key) {
        $this->db->trans_begin();

        $this->db->where("ID_TRANS",$key);  
        $this->db->delete('TRANS_COQ_DOC');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

	public function delete_all($key) {		
		$this->db->trans_begin();				
		$this->db->delete($this->_table2, $this->_key($key));
		$this->db->delete($this->_table3, $this->_key($key));
		
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return FALSE;
			} else {
			$this->db->trans_commit();
			return TRUE;
		}
	}

	public function options_status($default = '--Pilih Status --') {
        $this->db->from('DATA_SETTING');
        $this->db->where('KEY_SETTING','STATUS_REVIEW');
        $this->db->order_by('VALUE_SETTING','ASC');

        $option = array();
        $list = $this->db->get();

        if (!empty($default)) {
            $option[''] = $default;
        }

        foreach ($list->result() as $row) {
            $option[$row->VALUE_SETTING] = $row->NAME_SETTING;
        }
        $this->db->close();
        return $option;
    }

	public function options_pemasok($default = '--Pilih Pemasok--') {
        $this->db->from('MASTER_PEMASOK');
        $this->db->where('ISAKTIF_PEMASOK','1');
        $this->db->order_by('NAMA_PEMASOK','ASC');

        $option = array();
        $list = $this->db->get();

        if (!empty($default)) {
            $option[''] = $default;
        }

        foreach ($list->result() as $row) {
            $option[$row->ID_PEMASOK] = $row->NAMA_PEMASOK;
        }
        $this->db->close();
        return $option;
    }

    public function options_depo($default = '--Pilih Depo--',$id,$jenis) {
        $this->db->from('MASTER_DEPO');
        $this->db->where('ISAKTIF_DEPO','1');
        $this->db->where('ID_PEMASOK',$id);
        $this->db->order_by('NAMA_DEPO','ASC');

        if ($jenis==0){
	        $rest = $this->db->get()->result(); 
	    } else {
	        $option = array();
	        $list = $this->db->get(); 

	        if (!empty($default)) {
	            $option[''] = $default;
	        }

	        foreach ($list->result() as $row) {
	            $option[$row->ID_DEPO] = $row->NAMA_DEPO;
	        }
	        $rest = $option;    
	    }
	    $this->db->close();
	    return $rest;
    }

    public function depo_options($default = '--Pilih Depo--',$id) {
        $this->db->from('MASTER_DEPO');
        $this->db->where('ISAKTIF_DEPO','1');
        $this->db->where('ID_PEMASOK',$id);
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
	
	public function get_level($lv='', $key=''){ 

		switch ($lv) {
			case "R":
				$q = "SELECT  E.ID_REGIONAL, E.NAMA_REGIONAL 
				FROM MASTER_REGIONAL E
				WHERE ID_REGIONAL='$key' ORDER BY E.NAMA_REGIONAL ";
				break;
			case "0":
				$q = "SELECT  E.ID_REGIONAL, E.NAMA_REGIONAL 
				FROM MASTER_REGIONAL E
				WHERE ID_REGIONAL='$key' ORDER BY E.NAMA_REGIONAL ";
				break;
			case "1":
				$q = "SELECT D.COCODE, D.LEVEL1, E.ID_REGIONAL, E.NAMA_REGIONAL 
				FROM MASTER_LEVEL1 D 
				LEFT JOIN MASTER_REGIONAL E ON E.ID_REGIONAL=D.ID_REGIONAL
				WHERE COCODE='$key' ORDER BY E.NAMA_REGIONAL ";
				break;
			case "2":
				$q = "SELECT C.PLANT, C.LEVEL2,  D.COCODE,  D.LEVEL1, E.ID_REGIONAL, E.NAMA_REGIONAL
				FROM MASTER_LEVEL2 C 
				LEFT JOIN MASTER_LEVEL1 D ON D.COCODE=C.COCODE 
				LEFT JOIN MASTER_REGIONAL E ON E.ID_REGIONAL=D.ID_REGIONAL
				WHERE PLANT='$key' ORDER BY C.LEVEL2 ";
				break;
			case "3":
				$q = "SELECT B.STORE_SLOC, B.LEVEL3, C.PLANT, C.LEVEL2,  D.COCODE,  D.LEVEL1, E.ID_REGIONAL, E.NAMA_REGIONAL
				FROM MASTER_LEVEL3 B
				LEFT JOIN MASTER_LEVEL2 C ON C.PLANT=B.PLANT 
				LEFT JOIN MASTER_LEVEL1 D ON D.COCODE=C.COCODE 
				LEFT JOIN MASTER_REGIONAL E ON E.ID_REGIONAL=D.ID_REGIONAL
				WHERE STORE_SLOC='$key' ORDER BY B.LEVEL3 ";
				break;
			case "4":
				$q = "SELECT A.SLOC, A.LEVEL4, B.STORE_SLOC, B.LEVEL3, C.PLANT, C.LEVEL2,  D.COCODE,  D.LEVEL1, E.ID_REGIONAL, E.NAMA_REGIONAL
				FROM MASTER_LEVEL4 A
				LEFT JOIN MASTER_LEVEL3 B ON B.STORE_SLOC=A.STORE_SLOC 
				LEFT JOIN MASTER_LEVEL2 C ON C.PLANT=B.PLANT 
				LEFT JOIN MASTER_LEVEL1 D ON D.COCODE=C.COCODE 
				LEFT JOIN MASTER_REGIONAL E ON E.ID_REGIONAL=D.ID_REGIONAL
				WHERE SLOC='$key' ORDER BY A.LEVEL4 ";
				break;
			case "5":
				$q = "SELECT a.LEVEL3, a.STORE_SLOC
				FROM MASTER_LEVEL3 a
				INNER JOIN MASTER_LEVEL2 b ON a.PLANT = b.PLANT
				INNER JOIN MASTER_LEVEL4 c ON a.STORE_SLOC = c.STORE_SLOC AND a.PLANT = c.PLANT
				WHERE c.STATUS_LVL2=1 AND a.PLANT = '$key' 
				ORDER BY a.LEVEL3 ";
				break;

		} 
		$query = $this->db->query($q)->result();
		return $query;
	}

	public function options_reg($default = '--Pilih Regional--', $key = 'all') {
	    $option = array();

	    $this->db->from('MASTER_REGIONAL');
	    $this->db->where('IS_AKTIF_REGIONAL','1');
	    if ($key != 'all'){
	        $this->db->where('ID_REGIONAL',$key);
	    } 
	    $this->db->order_by('NAMA_REGIONAL');  

	    $list = $this->db->get(); 

	    if (!empty($default)) {
	        $option[''] = $default;
	    }

	    foreach ($list->result() as $row) {
	        $option[$row->ID_REGIONAL] = $row->NAMA_REGIONAL;
	    }
	    $this->db->close();
	    return $option;
	}

	public function options_lv1($default = '--Pilih Level 1--', $key = 'all', $jenis=0) {
	    $this->db->from('MASTER_LEVEL1');
	    $this->db->where('IS_AKTIF_LVL1','1');
	    if ($key != 'all'){
	        $this->db->where('ID_REGIONAL',$key);
	    }    
	    $this->db->order_by('LEVEL1'); 

	    if ($jenis==0){
	        $rest = $this->db->get()->result(); 
	    } else {
	        $option = array();
	        $list = $this->db->get(); 

	        if (!empty($default)) {
	            $option[''] = $default;
	        }

	        foreach ($list->result() as $row) {
	            $option[$row->COCODE] = $row->LEVEL1;
	        }
	        $rest = $option;    
	    }
	    $this->db->close();
	    return $rest;
	}

	public function options_lv2($default = '--Pilih Level 2--', $key = 'all', $jenis=0) {
	    $this->db->from('MASTER_LEVEL2');
	    $this->db->where('IS_AKTIF_LVL2','1');
	    
	    if ($key != 'all'){
	        $this->db->where('COCODE',$key);
	    }   
	    $this->db->order_by('LEVEL2'); 

	    if ($jenis==0){
	        $rest = $this->db->get()->result(); 
	    } else {
	        $option = array();
	        $list = $this->db->get(); 

	        if (!empty($default)) {
	            $option[''] = $default;
	        }

	        foreach ($list->result() as $row) {
	            $option[$row->PLANT] = $row->LEVEL2;
	        }
	        $rest = $option;    
	    }
	    $this->db->close();
	    return $rest;
	}

	public function options_lv3($default = '--Pilih Level 3--', $key = 'all', $jenis=0) {
	    $this->db->from('MASTER_LEVEL3');
	    $this->db->where('IS_AKTIF_LVL3','1');
	    if ($key != 'all'){
	        $this->db->where('PLANT',$key);
	    }    
	    $this->db->order_by('LEVEL3'); 

	    if ($jenis==0){
	        $rest = $this->db->get()->result(); 
	    } else {
	        $option = array();
	        $list = $this->db->get(); 

	        if (!empty($default)) {
	            $option[''] = $default;
	        }

	        foreach ($list->result() as $row) {
	            $option[$row->STORE_SLOC] = $row->LEVEL3;
	        }
	        $rest = $option;    
	    }
	    $this->db->close();
	    return $rest;
	}

	public function options_lv4($default = '--Pilih Pembangkit--', $key = 'all', $jenis=0) {
	    $this->db->from('MASTER_LEVEL4');
	    $this->db->where('IS_AKTIF_LVL4','1');
	    if ($key != 'all'){
	        $this->db->where('STORE_SLOC',$key);
	    }    
	    $this->db->order_by('LEVEL4'); 

	    if ($jenis==0){
	        $rest = $this->db->get()->result(); 
	    } else {
	        $option = array();
	        $list = $this->db->get(); 

	        if (!empty($default)) {
	            $option[''] = $default;
	        }

	        foreach ($list->result() as $row) {
	            $option[$row->SLOC] = $row->LEVEL4;
	        }
	        $rest = $option;    
	    }
	    $this->db->close();
	    return $rest;
	}

	public function options_pembangkit($data){

		$option = array();
		// $p_leveluser = $this->session->userdata('level_user');
		// $p_kode = $this->session->userdata('kode_level');
		// $q = "CALL get_pembangkit('$p_leveluser','')";
		$q = "SELECT * FROM MASTER_LEVEL4 WHERE IS_AKTIF_LVL4 = 1 ORDER BY LEVEL4";
        $query = $this->db->query($q);
        $this->db->close();
        $list = $query->result();
        foreach ($list as $row) {
        	$option[$row->SLOC] = $row->LEVEL4;
        }

        return $option;

    }

    public function get_depo_by_pemasok($default = '--Pilih Depo--', $key = 'all', $jenis=0) {
        $this->db->from('MASTER_DEPO');
        $this->db->where('ISAKTIF_DEPO','1');
        
	    if ($key != 'all'){
	        $this->db->where('ID_PEMASOK',$key);
	    }    
	    $this->db->order_by('NAMA_DEPO','ASC');

	    if ($jenis==0){
	        $rest = $this->db->get()->result(); 
	    } else {
	        $option = array();
	        $list = $this->db->get(); 

	        if (!empty($default)) {
	            $option[''] = $default;
	        }

	        foreach ($list->result() as $row) {
	            $option[$row->ID_DEPO] = $row->NAMA_DEPO;
	        }
	        $rest = $option;    
	    }
	    $this->db->close();
	    return $rest;
	}

	public function options_jenis_bahan_bakar($default = '-- Pilih Jenis Bahan Bakar --'){

		$option = array();
		
        $query = $this->db->query("
        	SELECT * FROM (
	        	SELECT ID_JNS_BHN_BKR,NAMA_JNS_BHN_BKR FROM M_JNS_BHN_BKR
				WHERE ID_JNS_BHN_BKR NOT IN (004,005,003)
				UNION ALL
				SELECT KODE_JNS_BHN_BKR AS ID_JNS_BHN_BKR,NAMA_JNS_BHN_BKR FROM M_GROUP_JNS_BBM
        	) A 
        	ORDER BY A.NAMA_JNS_BHN_BKR ASC
        	
    	")->result();
        $option[''] = $default;
        foreach ($query as $row) {
	            $option[$row->ID_JNS_BHN_BKR] = $row->NAMA_JNS_BHN_BKR;
        }
        $rest = $option; 
        return $rest;
    }

    public function get_table_by_idversion($jenis_bbm,$id_version){

		$this->db->select('A.*,B.*');
        $this->db->from('MASTER_COQ A');
        $this->db->join('MASTER_PARAMETER B','A.PRMETER_MCOQ = B.ID_PARAMETER','INNER');
        $this->db->where('A.IS_AKTIF',1);
        if($jenis_bbm == 301 || $jenis_bbm == 302 || $jenis_bbm == 303 || $jenis_bbm == 304) {
        	$this->db->where('A.ID_KOMPONEN_BBM',$jenis_bbm);
        	$this->db->where('A.ID_VERSION',$id_version);
        } else {
        	$this->db->where('A.ID_JNS_BHN_BKR',$jenis_bbm);
        	$this->db->where('A.ID_VERSION',$id_version);
        }
        
        $result = $this->db->get();
        return $result->result_array();

    }

    public function get_last_id($username) {
    	$query = "SELECT MAX(ID_TRANS) AS ID_TRANS FROM TRANS_COQ WHERE CD_BY = '$username' ORDER BY CD_DATE DESC";
    	$result = $this->db->query($query)->row();
    	return $result->ID_TRANS;
    }

    public function get_pembangkit_by_trxid($data){

    	$id = $data['id'];
		$q = "CALL lap_coq_detail('$id','','','','','')";
		$query = $this->db->query($q);
        $this->db->close();
        $list = $query->result_array();

		return $list;
    }

    public function get_array_sloc($id){
    	$option = array();

		$q = "CALL lap_coq_detail('$id','','','','','')";
		$query = $this->db->query($q);
        $this->db->close();

        $list = $query->result_array();
        
        foreach ($list as $value) {
            array_push($option,$value['SLOC']);
        }
        
        return $option;

    }

    public function get_result_by_trxid($id){

		$q = "CALL lap_coq_result('$id')";
		$query = $this->db->query($q);
        $this->db->close();
        $list = $query->result_array();

		return $list;
    }

    public function get_status($id) {
    	$query = $this->db->query("SELECT STATUS FROM MASTER_PARAMETER_NILAI WHERE ID_NILAI = $id")->row();
    	return $query->STATUS;
    }

    public function get_penampilan_visual($default = '-- Pilih Jenis --') {

    	$this->db->from('DATA_SETTING');
        $this->db->where('KEY_SETTING','PRMETER_VISUAL');

        $option = array();
        $list = $this->db->get();

        if (!empty($default)) {
            $option[''] = $default;
        }

        foreach ($list->result() as $row) {
            $option[$row->VALUE_SETTING] = $row->NAME_SETTING;
        }
        $this->db->close();
        return $option;

    }

    public function get_korosi_tembaga($default = '-- Pilih Jenis --') {
    	
    	$this->db->from('DATA_SETTING');
        $this->db->where('KEY_SETTING','PRMETER_KOROSI');

        $option = array();
        $list = $this->db->get();

        if (!empty($default)) {
            $option[''] = $default;
        }

        foreach ($list->result() as $row) {
            $option[$row->VALUE_SETTING] = $row->NAME_SETTING;
        }
        $this->db->close();
        return $option;
    }

    function get_unit() {
        $data = $this->session->userdata("kode_level");
        $sql = "SELECT r.ID_REGIONAL, r.NAMA_REGIONAL, m1.COCODE, m1.LEVEL1, m2.PLANT, m2.LEVEL2, m3.STORE_SLOC, m3.LEVEL3, 
                m4.SLOC, m4.LEVEL4
                FROM MASTER_LEVEL4 m4
                LEFT JOIN MASTER_LEVEL3 m3 ON m3.STORE_SLOC = m4.STORE_SLOC
                LEFT JOIN MASTER_LEVEL2 m2 ON m2.PLANT = m3.PLANT
                LEFT JOIN MASTER_LEVEL1 m1 ON m1.COCODE = m2.COCODE
                LEFT JOIN MASTER_REGIONAL r ON r.ID_REGIONAL = m1.ID_REGIONAL
                WHERE r.ID_REGIONAL=$data OR m1.COCODE=$data OR m2.PLANT=$data OR m3.STORE_SLOC=$data OR m4.SLOC=$data
                LIMIT 1";
        $list = $this->db->query($sql)->result_array();
        return $list;

    }

    public function get_namalevel($id) {

    	$user_id = $this->session->userdata('user_id');
    	$q = "SELECT
				CASE 
					WHEN a.LEVEL_USER = '0' THEN 'PUSAT'
					WHEN a.LEVEL_USER = 'R' THEN 
					(SELECT c.NAMA_REGIONAL FROM MASTER_REGIONAL c WHERE c.ID_REGIONAL = a.KODE_LEVEL)
					WHEN a.LEVEL_USER = '1' THEN 
					(SELECT c.LEVEL1 FROM MASTER_LEVEL1 c WHERE c.COCODE = a.KODE_LEVEL)
					WHEN a.LEVEL_USER = '2' THEN 
					(SELECT c.LEVEL2 FROM MASTER_LEVEL2 c WHERE c.PLANT = a.KODE_LEVEL)
					WHEN a.LEVEL_USER = '3' THEN 
					(SELECT c.LEVEL3 FROM MASTER_LEVEL3 c WHERE c.PLANT = a.KODE_LEVEL)
					WHEN a.LEVEL_USER = '4' THEN 
					(SELECT c.LEVEL4 FROM MASTER_LEVEL4 c WHERE c.SLOC = a.KODE_LEVEL) 
				END as NAMA_UNIT 
			FROM M_USER a
			WHERE a.ID_USER = $user_id;";
		$query = $this->db->query($q)->row();

		return $query->NAMA_UNIT;
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

    public function get_idlevel() {

    	$user_id = $this->session->userdata('user_id');
    	$q = "SELECT
				CASE 
					WHEN a.LEVEL_USER = '0' THEN '00'
					WHEN a.LEVEL_USER = 'R' THEN 
					(SELECT c.ID_REGIONAL FROM MASTER_REGIONAL c WHERE c.ID_REGIONAL = a.KODE_LEVEL)
					WHEN a.LEVEL_USER = '1' THEN 
					(SELECT c.COCODE FROM MASTER_LEVEL1 c WHERE c.COCODE = a.KODE_LEVEL)
					WHEN a.LEVEL_USER = '2' THEN 
					(SELECT c.PLANT FROM MASTER_LEVEL2 c WHERE c.PLANT = a.KODE_LEVEL)
					WHEN a.LEVEL_USER = '3' THEN 
					(SELECT c.STORE_SLOC FROM MASTER_LEVEL3 c WHERE c.PLANT = a.KODE_LEVEL)
					WHEN a.LEVEL_USER = '4' THEN 
					(SELECT c.SLOC FROM MASTER_LEVEL4 c WHERE c.SLOC = a.KODE_LEVEL) 
				END as ID_SURVEYOR 
			FROM M_USER a
			WHERE a.ID_USER = $user_id;";
		$query = $this->db->query($q)->row();

		return $query->ID_SURVEYOR;
    }

    public function get_tgl_version($tgl1,$bbm,$no_report) {

		$table  = "MASTER_VCOQ"; 

    	$param1 = "DITETAPKAN"; 	$param2 = "NO_VERSION"; 
    	$param3 = "TGL_VERSION"; 	$param4 = "ID_VERSION"; 
    	$key1   = "ID_JNS_BHN_BKR"; $key2	= "KODE_JNS_BHN_BKR";

    	$param = "DITETAPKAN,NO_VERSION,TGL_VERSION,ID_VERSION";

		$key = ($bbm == 301 || $bbm == 302 || $bbm == 303 || $bbm == 304) ? $key2 : $key1;

		$sql = "SELECT $param3 FROM $table WHERE $key = $bbm ORDER BY $param3 DESC LIMIT 1";
		$query = $this->db->query($sql)->row();
    	@$tgl_version = $query->TGL_VERSION;

    	$SQL2 = "SELECT $param FROM MASTER_VCOQ WHERE $key = $bbm ORDER BY TGL_VERSION DESC LIMIT 1";
    	$SQL3 = "SELECT $param FROM MASTER_VCOQ WHERE $key = $bbm AND TGL_VERSION < '$tgl1' ORDER BY TGL_VERSION DESC LIMIT 1";

    	$SQL4 = ($tgl1 > $tgl_version) ? $SQL2 : $SQL3;
    	$q = $this->db->query($SQL4)->result();

    	return $q;
		
    }

    public function isExists2Key($bbm,$report_no) {

    	$query = "SELECT COUNT(*) AS TOTAL FROM (
    				SELECT ID_JNS_BHN_BKR AS ID_BBM,NO_REPORT FROM $this->_table1 WHERE ID_JNS_BHN_BKR != 004
    			  	UNION ALL
    			  	SELECT ID_KOMPONEN_BBM AS ID_BBM,NO_REPORT FROM $this->_table1 WHERE ID_KOMPONEN_BBM != ''

    			  ) B
    			  WHERE B.ID_BBM = $bbm AND B.NO_REPORT = '$report_no'";
    	$sql = $this->db->query($query)->row();
    	
    	if($sql->TOTAL > 0) {
    		return true;
    	} else {
    		return false;
    	}
    }

   
    public function get_tgl_version_by_id($id) {

    	$q = "SELECT * FROM MASTER_VCOQ WHERE ID_VERSION = $id";
    	$query = $this->db->query($q)->row();
    	return $query;
    	
    }

    function get_result($id) {
    	$sql = "SELECT COUNT(RESUME) AS TOTAL FROM TRANS_COQ_RESULT WHERE ID_TRANS = $id AND RESUME = 1";
    	$query = $this->db->query($sql)->row();

    	if($query->TOTAL > 0) {
    		return true;
    	} else {
    		return false;
    	}
    }

    public function insert_batch_sloc($id,$sloc) {

    	$array = array();
    	foreach($sloc as $key) {

	        $data = array(
	            'SLOC' => $key,
	            'ID_TRANS' => $id,
	        );
	        array_push($array,$data);
	    }

    	$this->db->trans_begin();
    	$this->db->insert_batch('TRANS_COQ_PEMBANGKIT', $array);

    	if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return FALSE;
		} else {
			$this->db->trans_commit();
			return TRUE;
		}
    }

    public function insert_batch_result($id,$result_save,$resume,$id_mcoq) {

    	$array = array();
    	foreach ($result_save as $key => $value) {

            $result = ($value == '-' || $value == null || $value == '') ? '-' : $value;
            $data['ID_MCOQ']   = $id_mcoq[$key];
            $data['ID_TRANS']  = $id;
            $data['RESULT']    = $result;
            $data['RESUME']    = $resume[$key];
            $data['CD_BY']     = $this->session->userdata('user_name');
            $data['CD_DATE']   = date('Y-m-d');

           array_push($array,$data);
            
        }
      
    	$this->db->trans_begin();
    	$this->db->insert_batch('TRANS_COQ_RESULT', $array);

    	if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return FALSE;
		} else {
			$this->db->trans_commit();
			return TRUE;
		}
    }

    public function update_result($data, $key) {
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

	public function get_status_kirim($id) {
		$q = $this->db->query("SELECT STATUS_REVIEW FROM TRANS_COQ WHERE ID_TRANS = $id")->row();

		return $q->STATUS_REVIEW;
	}

	public function update_batch($array) {

		$this->db->trans_begin();

		$this->db->update_batch($this->_table1, $array, 'ID_TRANS');

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return FALSE;
		} else {
			$this->db->trans_commit();
			return TRUE;
		}


	}
	
}
	
/* End of file unit_model.php */
/* Location: ./application/modules/unit/models/unit_model.php */