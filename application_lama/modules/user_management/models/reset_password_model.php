<?php

/**
 * @module MASTER
 * @author  CF
 * @created at 17 November 2017
 * @modified at 17 November 2017
 */
class reset_password_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table1 = "M_USER";
    private $_table2 = "MASTER_LEVEL3 ";
    private $_table3 = "MASTER_LEVEL2 ";
    private $_table4 = "MASTER_LEVEL1 ";
    private $_table5 = "MASTER_REGIONAL ";
    private $_table6 = "ROLES";
    private $_table7 = "RESET_PASSWORD";

    private function _key($key) { //unit ID
        if (!is_array($key)) {
            $key = array('ID_USER' => $key);
        }
        return $key;
    }

    private function _key2($key) { //unit ID
        if (!is_array($key)) {
            $key = array('USERNAME' => $key);
        }
        return $key;
    }

    public function data($data) {
        $this->db->select("*");
        $this->db->from($this->_table1);
        $this->db->where('IS_LDAP',0);
        if($data['p_cari'] != '') {
            $this->db->where('USERNAME', $data['p_cari']);
        }

        $ret = $this->db->get();
        
        $this->db->close();
        return $ret;
    }

    public function get_table(){
        $this->db->select('rp.ID_RESET,usr.USERNAME,usr.NAMA_USER,usr.EMAIL_USER,rl.ROLES_NAMA,rp.NAMA_PEMOHON,rp.UNIT_PEMOHON,rp.CREATED_AT');
        $this->db->from($this->_table7 . ' rp');
        $this->db->join($this->_table1 . ' usr', 'usr.USERNAME = rp.ID_USER', 'left');
        $this->db->join($this->_table6 . ' rl', 'rl.ROLES_ID = usr.ROLES_ID', 'left');
        $this->db->order_by('rp.CREATED_AT', 'DESC');

        return $this->db;
    }

    public function data_table($module = '', $limit = 20, $offset = 1) {

        $total = $this->get_table()->count_all_results();
        
		$this->db->limit($limit, ($offset * $limit) - $limit);
        
       
        $record = $this->get_table()->get();

		$no=(($offset-1) * $limit) +1;
        $rows = array();
        foreach ($record->result() as $row) {
            $id = $row->ID_RESET;
            
            $rows[$no] = array(
                'no' => $no,
                'username' => $row->USERNAME,
                'nama_user'  => $row->NAMA_USER,
                'email_user' => $row->EMAIL_USER,
                'role_nama'  => $row->ROLES_NAMA,
                // 'unit'  => $row->LEVEL_USER,
                'nama_pemohon'  => $row->NAMA_PEMOHON,
                'unit_pemohon'  => $row->UNIT_PEMOHON,
                'tgl_reset'  => $row->CREATED_AT,
            );
            $no++;
        }

        return array('total' => $total, 'rows' => $rows);
    }	 

    public function save_as_new($data) {
        $data2['PWD_USER'] = '18a3ce6c2acc09f838598ddfddf4ab93';
        $USERNAME = $data['USERNAME'];
        $data3['ID_USER'] = $USERNAME;
        $data3['NAMA_PEMOHON'] = $data['NAMA_PEMOHON'];
        $data3['UNIT_PEMOHON'] = $data['UNIT_PEMOHON'];
        $data3['CREATED_BY'] = $this->session->userdata('user_name');
        $data3['CREATED_AT'] = date("Y-m-d H:i:s");
        $this->db->trans_begin();
        $this->db->insert($this->_table7, $data3);
        $this->db->update($this->_table1,$data2,$this->_key2($USERNAME));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function find_user($username) {
        $this->db->select('usr.NAMA_USER, usr.KD_USER, usr.EMAIL_USER, rl.ROLES_NAMA, r.NAMA_REGIONAL, m1.LEVEL1, m2.LEVEL2, m3.LEVEL3, usr.IS_LDAP, usr.LEVEL_USER, usr.KODE_LEVEL');
        $this->db->from($this->_table1 . ' usr');
        $this->db->join($this->_table2 . ' m3', 'm3.STORE_SLOC = usr.KODE_LEVEL', 'left');
        $this->db->join($this->_table3 . ' m2', 'm2.PLANT = m3.PLANT OR m2.PLANT = usr.KODE_LEVEL', 'left');
        $this->db->join($this->_table4 . ' m1', 'm1.COCODE = m2.COCODE OR m1.COCODE = usr.KODE_LEVEL', 'left');
        $this->db->join($this->_table5 . ' r', 'r.ID_REGIONAL = m1.ID_REGIONAL OR r.ID_REGIONAL = usr.KODE_LEVEL', 'left');
        $this->db->join($this->_table6 . ' rl', 'rl.ROLES_ID = usr.ROLES_ID', 'left');
        $this->db->where('USERNAME',$username);
        $result = $this->db->get();
        return $result->row();
    } 
}
