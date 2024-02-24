<?php
/**
 * @module ROLLBACK NOMINASI
 * @author  CF
 * @created at 27 AGUSTUS 2021
 * @modified at 27 AGUSTUS 2021
 */
class rollback_nominasi_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    
    private function _key($key) { //unit ID
        if (!is_array($key)) {
            $key = array('ID_PERMINTAAN' => $key);
        }
        return $key;
    }

    private function _key2($key) { //unit ID
        if (!is_array($key)) {
            $key = array('SLOC' => $key);
        }
        return $key;
    }


    private function _key3($key) { //unit ID
        if (!is_array($key)) {
            $key = array('ID_ROLLBACK' => $key);
        }
        return $key;
    }
   
    public function get_table($key = ''){
        $this->db->select("c.LEVEL4, JNS_TRANSAKSI, b.NAMA_JNS_BHN_BKR, NO_NOMINASI, TGL_MTS_NOMINASI, STATUS, ALASAN");
        $this->db->from('LOG_ROLLBACK_MUTASI_NOMINASI1 a');
        $this->db->join('M_JNS_BHN_BKR b ',' a.ID_JNS_BHN_BKR = b.ID_JNS_BHN_BKR');
        $this->db->join('MASTER_LEVEL4 c ',' a.SLOC = c.SLOC');

        if (!empty($key) || is_array($key))
            $this->db->where_condition($this->_key3($key));

        $this->db->order_by('a.CREATED_AT', 'DESC');

        return $this->db;
    }

    public function get_data_filter($sloc){
        $this->db->select("c.LEVEL4, JNS_TRANSAKSI, b.NAMA_JNS_BHN_BKR, NO_NOMINASI, TGL_MTS_NOMINASI, STATUS, ALASAN");
        $this->db->where('a.SLOC', $sloc);
        $this->db->from('LOG_ROLLBACK_MUTASI_NOMINASI1' . ' a');
        $this->db->join('M_JNS_BHN_BKR b ',' a.ID_JNS_BHN_BKR = b.ID_JNS_BHN_BKR');
        $this->db->join('MASTER_LEVEL4 c ',' a.SLOC = c.SLOC');
        $this->db->limit(30);
        
        $this->db->order_by('a.CREATED_AT', 'DESC');
        $res = $this->db->get();
        $result = $res->result_array();

        return $result;
    }

    public function data_table($module = '', $limit = 20, $offset = 1) {
        $filter = array();
        $kata_kunci = $this->laccess->ai($this->input->post('kata_kunci')); 

        if (!empty($kata_kunci))
            $filter["NO_NOMINASI LIKE '%{$kata_kunci}%'"] = NULL;

            $total = $this->get_table($filter)->count_all_results();
        
            $this->db->limit($limit, ($offset * $limit) - $limit);
            
        
            $record = $this->get_table($filter)->get();

            $no=(($offset-1) * $limit) +1;
            $rows = array();
            foreach ($record->result() as $row) {
                // $id = $row->ID_ROLLBACK;
                
                // if ($row->JNS_TRANSAKSI == 1) {
                //     $jenis = 'Nominasi';
                // }
                $rows[$no] = array(
                    'NO'               => $no,                
                    'LEVEL4'           => $row->LEVEL4,
                    'JNS_TRANSAKSI'    => $row->JNS_TRANSAKSI,
                    'NAMA_JNS_BHN_BKR' => $row->NAMA_JNS_BHN_BKR,
                    'NO_NOMINASI'      => $row->NO_NOMINASI,
                    'TGL_MTS_NOMINASI' => $row->TGL_MTS_NOMINASI,
                    'STATUS'           => $row->STATUS,
                    'ALASAN'           => $row->ALASAN,
                );
                $no++;
            }

        return array('total' => $total, 'rows' => $rows);
    }

    public function options_jenis_bahan_bakar($default = '--Pilih Jenis Bahan Bakar--') {
        $this->db->from('M_JNS_BHN_BKR');
        
        $option = array();
        $list = $this->db->get();
        
        if (!empty($default)) {
            $option[''] = $default;
        }
        
        foreach ($list->result() as $row) {
            $option[$row->ID_JNS_BHN_BKR] = $row->NAMA_JNS_BHN_BKR;
        }
        $this->db->close();
        return $option;
    }
    
    public function options_lv4($default = '--Pilih Pembangkit--', $key = 'all', $jenis=0) {
        $this->db->from('MASTER_LEVEL4');
        $this->db->where('IS_AKTIF_LVL4','1');
        if ($key != 'all'){
            $this->db->where('STORE_SLOC',$key);
        }    
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
    
    public function get_transaksi($sloc, $bbm, $jenis) {
        if($jenis == 1){
            $query = "SELECT * FROM MUTASI_NOMINASI WHERE SLOC = '$sloc' AND ID_JNS_BHN_BKR = '$bbm' AND (STATUS_APPROVE = '1' OR STATUS_APPROVE = '2' OR STATUS_APPROVE = '5' OR STATUS_APPROVE = '6')";           
        }
        
        $sql = $this->db->query($query);
        $list = $sql->result();
        if ($jenis==0){
            $rest = $list;
        } else {
            $option = array();
            foreach ($list as $row) {  
                if($jenis == 1) {
                    $option[$row->ID_PERMINTAAN] = $row->NO_NOMINASI; 
                }
            }
            $rest = $option;
        }
        
        $this->db->close();
        return $rest;  
    }

    public function get_detailtransaksi($idtrans,$jenis){

        if($jenis == 1){
            $query = "SELECT TGL_MTS_NOMINASI, NO_NOMINASI,
                CASE WHEN STATUS_APPROVE = 1 THEN 'Belum Disetujui'
                     WHEN STATUS_APPROVE = 2 THEN 'Disetujui'
                     WHEN STATUS_APPROVE = 5 THEN 'Belum Disetujui Closing'
                     WHEN STATUS_APPROVE = 6 THEN 'Disetujui Closing'
                END as STATUS_APPRO
                FROM MUTASI_NOMINASI
                WHERE ID_PERMINTAAN = '$idtrans'";
        } 

        $sql = $this->db->query($query);
        $list = $sql->row();
        
        $this->db->close();
        return $list;    
    }

    public function update_nominasi($sloc, $jenis,$bbm, $idtrans, $nominasi, $tgl, $status, $jnsrollback, $alasan) {
        $data['STATUS_APPROVE'] = 0;
        $data2 = $idtrans;
        $data1['SLOC'] = $sloc;
        $data1['JNS_TRANSAKSI'] = 'Nominasi';
        $data1['ID_JNS_BHN_BKR'] = $bbm;
        $data1['NO_NOMINASI'] = $nominasi;
        $data1['TGL_MTS_NOMINASI'] = $tgl;
        $data1['STATUS'] = 'Belum Kirim';
        $data1['JNS_ROLLBACK'] = $jnsrollback;
        $data1['CREATED_BY'] = $this->session->userdata('user_name');
        $data1['CREATED_AT'] = date("Y-m-d H:i:s");
        $data1['ALASAN'] = $alasan;

        $this->db->trans_begin();

        $this->db->insert('LOG_ROLLBACK_MUTASI_NOMINASI1', $data1);
        $this->db->update('MUTASI_NOMINASI', $data, $this->_key($data2));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function delete_nominasi($sloc, $jenis,$bbm, $idtrans, $nominasi, $tgl, $status, $jnsrollback, $alasan) {
        $data = $idtrans;
        $data2 = $sloc;
        $data1['SLOC'] = $sloc;
        $data1['JNS_TRANSAKSI'] = 'Nominasi';
        $data1['ID_JNS_BHN_BKR'] = $bbm;
        $data1['NO_NOMINASI'] = $nominasi;
        $data1['TGL_MTS_NOMINASI'] = $tgl;
        $data1['STATUS'] = 'Sukses Terhapus';
        $data1['JNS_ROLLBACK'] = $jnsrollback;
        $data1['CREATED_BY'] = $this->session->userdata('user_name');
        $data1['CREATED_AT'] = date("Y-m-d H:i:s");
        $data1['ALASAN'] = $alasan;

        $this->db->trans_begin();

        $this->db->insert('LOG_ROLLBACK_MUTASI_NOMINASI1', $data1);
        $this->db->delete('MUTASI_NOMINASI', $this->_key($data));
        $this->db->where('NO_NOMINASI', $nominasi);
        $this->db->where('SLOC', $sloc);
        $this->db->delete('MUTASI_NOMINASI_KIRIM', $this->_key2($data2));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    function options_jns_bhn_bkr($sloc) {
        $query = "SELECT b.ID_JNS_BHN_BKR,b.NAMA_JNS_BHN_BKR FROM MASTER_TANGKI a 
        LEFT JOIN M_JNS_BHN_BKR b ON a.ID_JNS_BHN_BKR = b.ID_JNS_BHN_BKR
        WHERE a.SLOC = '$sloc'";
        $list = $this->db->query($query);

        foreach ($list->result() as $row) {
            $option[$row->ID_JNS_BHN_BKR] = $row->NAMA_JNS_BHN_BKR;
        }
        return $option;
    }

    public function get_all($sloc){
        $query = "SELECT m4.SLOC,r.NAMA_REGIONAL,m1.LEVEL1,m2.LEVEL2,m3.LEVEL3,m4.LEVEL4
        FROM MASTER_LEVEL4 m4
        LEFT JOIN MASTER_LEVEL3 m3 ON m4.STORE_SLOC = m3.STORE_SLOC
        LEFT JOIN MASTER_LEVEL2 m2 ON m3.PLANT = m2.PLANT
        LEFT JOIN MASTER_LEVEL1 m1 ON m2.COCODE = m1.COCODE
        LEFT JOIN MASTER_REGIONAL r ON m1.ID_REGIONAL = r.ID_REGIONAL
        WHERE m4.SLOC = '$sloc'";

        $list = $this->db->query($query)->row();

        return $list;
    }



}

/* End of file unit_model.php */
/* Location: ./application/modules/unit/models/unit_model.php */