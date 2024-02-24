<?php
/**
 * @module ROLLBACK NOMINASI
 * @author  CF
 * @created at 27 AGUSTUS 2021
 * @modified at 27 AGUSTUS 2021
 */
class rollback_data_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    
    private function _key($key) { //unit ID
        if (!is_array($key)) {
            $key = array('ID_PEMAKAIAN' => $key);
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
            $key = array('ID_PENERIMAAN' => $key);
        }
        return $key;
    }

    private function _key4($key) { //unit ID
        if (!is_array($key)) {
            $key = array('ID_ROLLBACK' => $key);
        }
        return $key;
    }

    private function _key5($key) { //unit ID
        if (!is_array($key)) {
            $key = array('ID_STOCKOPNAME' => $key);
        }
        return $key;
    }
   
    public function get_table($key = ''){
        $this->db->select("c.LEVEL4, JNS_TRANSAKSI, b.NAMA_JNS_BHN_BKR, NO_TUG, TGL_MUTASI_PENGAKUAN, STATUS, ALASAN");
        $this->db->from('LOG_ROLLBACK_MUTASI_PEMAKAIAN1' . ' a');
        $this->db->join('M_JNS_BHN_BKR b ',' a.ID_JNS_BHN_BKR = b.ID_JNS_BHN_BKR');
        $this->db->join('MASTER_LEVEL4 c ',' a.SLOC = c.SLOC');
        
        if (!empty($key) || is_array($key))
            $this->db->where_condition($this->_key4($key));

        $this->db->order_by('a.CREATED_AT', 'DESC');

        return $this->db;
    }

    public function get_data_filter($sloc){
        $this->db->select("c.LEVEL4, JNS_TRANSAKSI, b.NAMA_JNS_BHN_BKR, NO_TUG, TGL_MUTASI_PENGAKUAN, STATUS, ALASAN");
        $this->db->where('a.SLOC', $sloc);
        $this->db->from('LOG_ROLLBACK_MUTASI_PEMAKAIAN1' . ' a');
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
            $filter["NO_TUG LIKE '%{$kata_kunci}%'"] = NULL;

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
                $rows[] = array(
                    'NO'               => $no,
                    'LEVEL4'           => $row->LEVEL4,
                    'JNS_TRANSAKSI'    => $row->JNS_TRANSAKSI,
                    'NAMA_JNS_BHN_BKR' => $row->NAMA_JNS_BHN_BKR,
                    'NO_TUG'           => $row->NO_TUG,
                    'TGL_MUTASI_PENGAKUAN' => $row->TGL_MUTASI_PENGAKUAN,
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
            $query = "SELECT * FROM MUTASI_PEMAKAIAN WHERE SLOC = '$sloc' AND ID_JNS_BHN_BKR = '$bbm' AND (STATUS_MUTASI_PEMAKAIAN = '1' OR STATUS_MUTASI_PEMAKAIAN = '2' OR STATUS_MUTASI_PEMAKAIAN = '5' OR STATUS_MUTASI_PEMAKAIAN = '6')";           
        }
        
        $sql = $this->db->query($query);
        $list = $sql->result();
        if ($jenis==0){
            $rest = $list;
        } else {
            $option = array();
            foreach ($list as $row) {  
                if($jenis == 1) {
                    $option[$row->ID_PEMAKAIAN] = $row->NO_TUG; 
                }
            }
            $rest = $option;
        }
        
        $this->db->close();
        return $rest;  
    }

    public function get_detailtransaksi($idtrans,$jenis){

        if($jenis == 1){
            $query = "SELECT TGL_MUTASI_PENGAKUAN,NO_TUG,APPROVE_BY_MUTASI_PEMAKAIAN,APPROVE_DATE_MUTASI_PAKAI,
                CASE WHEN STATUS_MUTASI_PEMAKAIAN = 1 THEN 'Belum Disetujui'
                     WHEN STATUS_MUTASI_PEMAKAIAN = 2 THEN 'Disetujui'
                     WHEN STATUS_MUTASI_PEMAKAIAN = 5 THEN 'Belum Disetujui Closing'
                     WHEN STATUS_MUTASI_PEMAKAIAN = 6 THEN 'Disetujui Closing'
                END as STATUS_APPRO
                FROM MUTASI_PEMAKAIAN
                WHERE ID_PEMAKAIAN = '$idtrans'";
        } 

        $sql = $this->db->query($query);
        $list = $sql->row();
        
        $this->db->close();
        return $list;    
    }

    public function get_transaksi_prev($sloc,$bbm,$tgl,$no_trans){
        $before = date('Y-m-d', strtotime('-1 days', strtotime($tgl)));
        $query = "CALL GET_BACKDATE_TRANS_PEMAKAIAN('$sloc','$bbm','$tgl', '$before');";
        $sql = $this->db->query($query);
        $list = $sql->result_array();
        
        $this->db->close();
        return $list;    
    }

    public function update_pemakaian($sloc, $jenis,$bbm, $idtrans, $tug, $tgl, $status, $jnsrollback, $alasan) {
        $data['STATUS_MUTASI_PEMAKAIAN'] = 0;
        $data['TGL_KIRIM'] = NULL;
        $data2 = $idtrans;
        $data1['SLOC'] = $sloc;
        $data1['JNS_TRANSAKSI'] = 'Pemakaian';
        $data1['ID_JNS_BHN_BKR'] = $bbm;
        $data1['NO_TUG'] = $tug;
        $data1['TGL_MUTASI_PENGAKUAN'] = $tgl;
        $data1['STATUS'] = 'Belum Kirim';
        $data1['JNS_ROLLBACK'] = $jnsrollback;
        $data1['CREATED_BY'] = $this->session->userdata('user_name');
        $data1['CREATED_AT'] = date("Y-m-d H:i:s");
        $data1['ALASAN'] = $alasan;
        $data1['IS_ORI'] = 1;
        $data1['APPROVE_BY'] = '';
        $data1['APPROVE_DATE'] = '';

        $this->db->trans_begin();

        $this->db->insert('LOG_ROLLBACK_MUTASI_PEMAKAIAN1', $data1);
        $this->db->update('MUTASI_PEMAKAIAN', $data, $this->_key($data2));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function update_pemakaian_satu($sloc, $jenis,$bbm, $idtrans, $tug, $tgl, $status, $jnsrollback, $alasan, $approveby, $approvedate, $value) {
        $data['STATUS_MUTASI_PEMAKAIAN'] = 0;
        $data['TGL_KIRIM'] = NULL;
        $data['APPROVE_BY_MUTASI_PEMAKAIAN'] = NULL;
        $data['APPROVE_DATE_MUTASI_PAKAI'] = NULL;

        $data4['STATUS_MUTASI_PEMAKAIAN'] = 1;
        $data4['APPROVE_BY_MUTASI_PEMAKAIAN'] = NULL;
        $data4['APPROVE_DATE_MUTASI_PAKAI'] = NULL;

        $data2 = $idtrans;
        $data3 = $sloc;
        $data5 = $value[0];
        $data6 = $value[2];
        
        $data1[0]['SLOC'] = $sloc;
        $data1[0]['JNS_TRANSAKSI'] = 'Pemakaian';
        $data1[0]['ID_JNS_BHN_BKR'] = $bbm;
        $data1[0]['NO_TUG'] = $tug;
        $data1[0]['TGL_MUTASI_PENGAKUAN'] = $tgl;
        $data1[0]['STATUS'] = 'Belum Kirim';
        $data1[0]['JNS_ROLLBACK'] = $jnsrollback;
        $data1[0]['CREATED_BY'] = $this->session->userdata('user_name');
        $data1[0]['CREATED_AT'] = date("Y-m-d H:i:s");
        $data1[0]['ALASAN'] = $alasan;
        $data1[0]['IS_ORI'] = 1;
        $data1[0]['APPROVE_BY'] = $approveby;
        $data1[0]['APPROVE_DATE'] = $approvedate;

        $data1[1]['SLOC'] = $value[2];
        $data1[1]['JNS_TRANSAKSI'] = 'Pemakaian';
        $data1[1]['ID_JNS_BHN_BKR'] = $value[3];
        $data1[1]['NO_TUG'] = $value[5];
        $data1[1]['TGL_MUTASI_PENGAKUAN'] = $value[4];
        $data1[1]['STATUS'] = 'Belum Disetujui';
        $data1[1]['JNS_ROLLBACK'] = $jnsrollback;
        $data1[1]['CREATED_BY'] = $this->session->userdata('user_name');
        $data1[1]['CREATED_AT'] = date("Y-m-d H:i:s");
        $data1[1]['ALASAN'] = 'Bukan data Utama';
        $data1[1]['IS_ORI'] = 0;
        $data1[1]['APPROVE_BY'] = $value[6];
        $data1[1]['APPROVE_DATE'] = $value[7];

        $this->db->trans_begin();

        $this->db->insert_batch('LOG_ROLLBACK_MUTASI_PEMAKAIAN1', $data1);
        $this->db->update('MUTASI_PEMAKAIAN', $data, $this->_key($data2));
        $this->db->update('MUTASI_PEMAKAIAN', $data4, $this->_key($data5));
        $this->db->delete('KOMPONEN_HITUNG', $this->_key($data2));
        $this->db->delete('KOMPONEN_HITUNG', $this->_key($data5));
        $this->db->where('ID_JNS_BHN_BKR', $bbm);
        $this->db->where('TGL_MUTASI_PERSEDIAAN', $tgl);
        $this->db->delete('REKAP_MUTASI_PERSEDIAAN', $this->_key2($data3));
        $this->db->where('ID_JNS_BHN_BKR', $value[3]);
        $this->db->where('TGL_MUTASI_PERSEDIAAN', $value[4]);
        $this->db->delete('REKAP_MUTASI_PERSEDIAAN', $this->_key2($data6));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function update_pemakaian_dua($sloc, $jenis,$bbm, $idtrans, $tug, $tgl, $status, $jnsrollback, $alasan, $approveby, $approvedate, $value) {
        $data['STATUS_MUTASI_PEMAKAIAN'] = 0;
        $data['TGL_KIRIM'] = NULL;
        $data['APPROVE_BY_MUTASI_PEMAKAIAN'] = NULL;
        $data['APPROVE_DATE_MUTASI_PAKAI'] = NULL;

        $data4['STATUS_MUTASI_TERIMA'] = 1;
        $data4['APPROVEL_BY_MUTASI_TERIMA'] = NULL;
        $data4['APPROVEL_DATE_MUTASI_TERIMA'] = NULL;

        $data2 = $idtrans;
        $data3 = $sloc;
        $data5 = $value[0];
        $data6 = $value[2];
        
        $data1[0]['SLOC'] = $sloc;
        $data1[0]['JNS_TRANSAKSI'] = 'Pemakaian';
        $data1[0]['ID_JNS_BHN_BKR'] = $bbm;
        $data1[0]['NO_TUG'] = $tug;
        $data1[0]['TGL_MUTASI_PENGAKUAN'] = $tgl;
        $data1[0]['STATUS'] = 'Belum Kirim';
        $data1[0]['JNS_ROLLBACK'] = $jnsrollback;
        $data1[0]['CREATED_BY'] = $this->session->userdata('user_name');
        $data1[0]['CREATED_AT'] = date("Y-m-d H:i:s");
        $data1[0]['ALASAN'] = $alasan;
        $data1[0]['IS_ORI'] = 1;
        $data1[0]['APPROVE_BY'] = $approveby;
        $data1[0]['APPROVE_DATE'] = $approvedate;

        $data1[1]['SLOC'] = $value[2];
        $data1[1]['JNS_TRANSAKSI'] = 'Penerimaan';
        $data1[1]['ID_JNS_BHN_BKR'] = $value[3];
        $data1[1]['NO_TUG'] = $value[5];
        $data1[1]['TGL_MUTASI_PENGAKUAN'] = $value[4];
        $data1[1]['STATUS'] = 'Belum Disetujui';
        $data1[1]['JNS_ROLLBACK'] = $jnsrollback;
        $data1[1]['CREATED_BY'] = $this->session->userdata('user_name');
        $data1[1]['CREATED_AT'] = date("Y-m-d H:i:s");
        $data1[1]['ALASAN'] = 'Bukan data Utama';
        $data1[1]['IS_ORI'] = 0;
        $data1[1]['APPROVE_BY'] = $value[6];
        $data1[1]['APPROVE_DATE'] = $value[7];

        $this->db->trans_begin();

        $this->db->insert_batch('LOG_ROLLBACK_MUTASI_PEMAKAIAN1', $data1);
        $this->db->update('MUTASI_PEMAKAIAN', $data, $this->_key($data2));
        $this->db->update('MUTASI_PENERIMAAN', $data4, $this->_key3($data5));
        $this->db->delete('KOMPONEN_HITUNG', $this->_key($data2));
        $this->db->delete('KOMPONEN_HITUNG', $this->_key3($data5));
        $this->db->where('ID_JNS_BHN_BKR', $bbm);
        $this->db->where('TGL_MUTASI_PERSEDIAAN', $tgl);
        $this->db->delete('REKAP_MUTASI_PERSEDIAAN', $this->_key2($data3));
        $this->db->where('ID_JNS_BHN_BKR', $value[3]);
        $this->db->where('TGL_MUTASI_PERSEDIAAN', $value[4]);
        $this->db->delete('REKAP_MUTASI_PERSEDIAAN', $this->_key2($data6));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function update_pemakaian_tiga($sloc, $jenis,$bbm, $idtrans, $tug, $tgl, $status, $jnsrollback, $alasan, $approveby, $approvedate, $value) {
        $data['STATUS_MUTASI_PEMAKAIAN'] = 0;
        $data['TGL_KIRIM'] = NULL;
        $data['APPROVE_BY_MUTASI_PEMAKAIAN'] = NULL;
        $data['APPROVE_DATE_MUTASI_PAKAI'] = NULL;

        $data4['STATUS_APPROVE_STOCKOPNAME'] = 1;
        $data4['APPROVE_BY_STOCKOPNAME'] = NULL;
        $data4['APPROVE_DATE'] = NULL;

        $data2 = $idtrans;
        $data3 = $sloc;
        $data5 = $value[0];
        $data6 = $value[2];
        
        $data1[0]['SLOC'] = $sloc;
        $data1[0]['JNS_TRANSAKSI'] = 'Pemakaian';
        $data1[0]['ID_JNS_BHN_BKR'] = $bbm;
        $data1[0]['NO_TUG'] = $tug;
        $data1[0]['TGL_MUTASI_PENGAKUAN'] = $tgl;
        $data1[0]['STATUS'] = 'Belum Kirim';
        $data1[0]['JNS_ROLLBACK'] = $jnsrollback;
        $data1[0]['CREATED_BY'] = $this->session->userdata('user_name');
        $data1[0]['CREATED_AT'] = date("Y-m-d H:i:s");
        $data1[0]['ALASAN'] = $alasan;
        $data1[0]['IS_ORI'] = 1;
        $data1[0]['APPROVE_BY'] = $approveby;
        $data1[0]['APPROVE_DATE'] = $approvedate;

        $data1[1]['SLOC'] = $value[2];
        $data1[1]['JNS_TRANSAKSI'] = 'Stockopname';
        $data1[1]['ID_JNS_BHN_BKR'] = $value[3];
        $data1[1]['NO_TUG'] = $value[5];
        $data1[1]['TGL_MUTASI_PENGAKUAN'] = $value[4];
        $data1[1]['STATUS'] = 'Belum Disetujui';
        $data1[1]['JNS_ROLLBACK'] = $jnsrollback;
        $data1[1]['CREATED_BY'] = $this->session->userdata('user_name');
        $data1[1]['CREATED_AT'] = date("Y-m-d H:i:s");
        $data1[1]['ALASAN'] = 'Bukan Data Utama';
        $data1[1]['IS_ORI'] = 0;
        $data1[1]['APPROVE_BY'] = $value[6];
        $data1[1]['APPROVE_DATE'] = $value[7];


        $this->db->trans_begin();

        $this->db->insert_batch('LOG_ROLLBACK_MUTASI_PEMAKAIAN1', $data1);
        $this->db->update('MUTASI_PEMAKAIAN', $data, $this->_key($data2));
        $this->db->update('STOCK_OPNAME', $data4, $this->_key5($data5));
        $this->db->delete('KOMPONEN_HITUNG', $this->_key($data2));
        $this->db->delete('KOMPONEN_HITUNG', $this->_key5($data5));
        $this->db->where('ID_JNS_BHN_BKR', $bbm);
        $this->db->where('TGL_MUTASI_PERSEDIAAN', $tgl);
        $this->db->delete('REKAP_MUTASI_PERSEDIAAN', $this->_key2($data3));
        $this->db->where('ID_JNS_BHN_BKR', $value[3]);
        $this->db->where('TGL_MUTASI_PERSEDIAAN', $value[4]);
        $this->db->delete('REKAP_MUTASI_PERSEDIAAN', $this->_key2($data6));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function delete_pemakaian($sloc, $jenis,$bbm, $idtrans, $tug, $tgl, $status, $jnsrollback, $alasan) {
        $data2 = $idtrans;
        $data1['SLOC'] = $sloc;
        $data1['JNS_TRANSAKSI'] = 'Pemakaian';
        $data1['ID_JNS_BHN_BKR'] = $bbm;
        $data1['NO_TUG'] = $tug;
        $data1['TGL_MUTASI_PENGAKUAN'] = $tgl;
        $data1['STATUS'] = 'Sukses Terhapus';
        $data1['JNS_ROLLBACK'] = $jnsrollback;
        $data1['CREATED_BY'] = $this->session->userdata('user_name');
        $data1['CREATED_AT'] = date("Y-m-d H:i:s");
        $data1['ALASAN'] = $alasan;
        $data1['IS_ORI'] = 1;
        $data1['APPROVE_BY'] = '';
        $data1['APPROVE_DATE'] = '';

        $this->db->trans_begin();

        $this->db->insert('LOG_ROLLBACK_MUTASI_PEMAKAIAN1', $data1);
        $this->db->delete('MUTASI_PEMAKAIAN', $this->_key($data2));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function delete_pemakaian_satu($sloc, $jenis,$bbm, $idtrans, $tug, $tgl, $status, $jnsrollback, $alasan, $value) {
        $data3 = $idtrans;
        $data4 = $value[0];
        $data5 = $sloc;
        $data6 = $value[2];

        $data2['STATUS_MUTASI_PEMAKAIAN'] = 1;
        $data2['APPROVE_BY_MUTASI_PEMAKAIAN'] = NULL;
        $data2['APPROVE_DATE_MUTASI_PAKAI'] = NULL;

        $data1[0]['SLOC'] = $sloc;
        $data1[0]['JNS_TRANSAKSI'] = 'Pemakaian';
        $data1[0]['ID_JNS_BHN_BKR'] = $bbm;
        $data1[0]['NO_TUG'] = $tug;
        $data1[0]['TGL_MUTASI_PENGAKUAN'] = $tgl;
        $data1[0]['STATUS'] = 'Sukses Terhapus';
        $data1[0]['JNS_ROLLBACK'] = $jnsrollback;
        $data1[0]['CREATED_BY'] = $this->session->userdata('user_name');
        $data1[0]['CREATED_AT'] = date("Y-m-d H:i:s");
        $data1[0]['ALASAN'] = $alasan;
        $data1[0]['IS_ORI'] = 1;
        $data1[0]['APPROVE_BY'] = '';
        $data1[0]['APPROVE_DATE'] = '';

        $data1[1]['SLOC'] = $value[2];
        $data1[1]['JNS_TRANSAKSI'] = 'Pemakaian';
        $data1[1]['ID_JNS_BHN_BKR'] = $value[3];
        $data1[1]['NO_TUG'] = $value[5];
        $data1[1]['TGL_MUTASI_PENGAKUAN'] = $value[4];
        $data1[1]['STATUS'] = 'Belum Disetujui';
        $data1[1]['JNS_ROLLBACK'] = $jnsrollback;
        $data1[1]['CREATED_BY'] = $this->session->userdata('user_name');
        $data1[1]['CREATED_AT'] = date("Y-m-d H:i:s");
        $data1[1]['ALASAN'] = 'Bukan data Utama';
        $data1[1]['IS_ORI'] = 0;
        $data1[1]['APPROVE_BY'] = $value[6];
        $data1[1]['APPROVE_DATE'] = $value[7];

        $this->db->trans_begin();

        $this->db->insert_batch('LOG_ROLLBACK_MUTASI_PEMAKAIAN1', $data1);
        $this->db->delete('MUTASI_PEMAKAIAN', $this->_key($data3));
        $this->db->update('MUTASI_PEMAKAIAN', $data2, $this->_key($data4));
        $this->db->delete('KOMPONEN_HITUNG', $this->_key($data3));
        $this->db->delete('KOMPONEN_HITUNG', $this->_key($data4));
        $this->db->where('ID_JNS_BHN_BKR', $bbm);
        $this->db->where('TGL_MUTASI_PERSEDIAAN', $tgl);
        $this->db->delete('REKAP_MUTASI_PERSEDIAAN', $this->_key2($data5));
        $this->db->where('ID_JNS_BHN_BKR', $value[3]);
        $this->db->where('TGL_MUTASI_PERSEDIAAN', $value[4]);
        $this->db->delete('REKAP_MUTASI_PERSEDIAAN', $this->_key2($data6));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function delete_pemakaian_dua($sloc, $jenis,$bbm, $idtrans, $tug, $tgl, $status, $jnsrollback, $alasan, $value) {
        $data3 = $idtrans;
        $data4 = $value[0];
        $data5 = $sloc;
        $data6 = $value[2];

        $data2['STATUS_MUTASI_TERIMA'] = 1;
        $data2['APPROVEL_BY_MUTASI_TERIMA'] = NULL;
        $data2['APPROVEL_DATE_MUTASI_TERIMA'] = NULL;

        $data1[0]['SLOC'] = $sloc;
        $data1[0]['JNS_TRANSAKSI'] = 'Pemakaian';
        $data1[0]['ID_JNS_BHN_BKR'] = $bbm;
        $data1[0]['NO_TUG'] = $tug;
        $data1[0]['TGL_MUTASI_PENGAKUAN'] = $tgl;
        $data1[0]['STATUS'] = 'Sukses Terhapus';
        $data1[0]['JNS_ROLLBACK'] = $jnsrollback;
        $data1[0]['CREATED_BY'] = $this->session->userdata('user_name');
        $data1[0]['CREATED_AT'] = date("Y-m-d H:i:s");
        $data1[0]['ALASAN'] = $alasan;
        $data1[0]['IS_ORI'] = 1;
        $data1[0]['APPROVE_BY'] = '';
        $data1[0]['APPROVE_DATE'] = '';

        $data1[1]['SLOC'] = $value[2];
        $data1[1]['JNS_TRANSAKSI'] = 'Penerimaan';
        $data1[1]['ID_JNS_BHN_BKR'] = $value[3];
        $data1[1]['NO_TUG'] = $value[5];
        $data1[1]['TGL_MUTASI_PENGAKUAN'] = $value[4];
        $data1[1]['STATUS'] = 'Belum Disetujui';
        $data1[1]['JNS_ROLLBACK'] = $jnsrollback;
        $data1[1]['CREATED_BY'] = $this->session->userdata('user_name');
        $data1[1]['CREATED_AT'] = date("Y-m-d H:i:s");
        $data1[1]['ALASAN'] = 'Bukan data Utama';
        $data1[1]['IS_ORI'] = 0;
        $data1[1]['APPROVE_BY'] = $value[6];
        $data1[1]['APPROVE_DATE'] = $value[7];
        

        $this->db->trans_begin();

        $this->db->insert_batch('LOG_ROLLBACK_MUTASI_PEMAKAIAN1', $data1);
        $this->db->delete('MUTASI_PEMAKAIAN', $this->_key($data3));
        $this->db->update('MUTASI_PENERIMAAN', $data2, $this->_key3($data4));
        $this->db->delete('KOMPONEN_HITUNG', $this->_key($data3));
        $this->db->delete('KOMPONEN_HITUNG', $this->_key3($data4));
        $this->db->where('ID_JNS_BHN_BKR', $bbm);
        $this->db->where('TGL_MUTASI_PERSEDIAAN', $tgl);
        $this->db->delete('REKAP_MUTASI_PERSEDIAAN', $this->_key2($data5));
        $this->db->where('ID_JNS_BHN_BKR', $value[3]);
        $this->db->where('TGL_MUTASI_PERSEDIAAN', $value[4]);
        $this->db->delete('REKAP_MUTASI_PERSEDIAAN', $this->_key2($data6));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function delete_pemakaian_tiga($sloc, $jenis,$bbm, $idtrans, $tug, $tgl, $status, $jnsrollback, $alasan, $value) {
        $data3 = $idtrans;
        $data4 = $value[0];
        $data5 = $sloc;
        $data6 = $value[2];

        $data2['STATUS_APPROVE_STOCKOPNAME'] = 1;
        $data2['APPROVE_BY_STOCKOPNAME'] = NULL;
        $data2['APPROVE_DATE'] = NULL;

        $data1[0]['SLOC'] = $sloc;
        $data1[0]['JNS_TRANSAKSI'] = 'Pemakaian';
        $data1[0]['ID_JNS_BHN_BKR'] = $bbm;
        $data1[0]['NO_TUG'] = $tug;
        $data1[0]['TGL_MUTASI_PENGAKUAN'] = $tgl;
        $data1[0]['STATUS'] = 'Sukses Terhapus';
        $data1[0]['JNS_ROLLBACK'] = $jnsrollback;
        $data1[0]['CREATED_BY'] = $this->session->userdata('user_name');
        $data1[0]['CREATED_AT'] = date("Y-m-d H:i:s");
        $data1[0]['ALASAN'] = $alasan;
        $data1[0]['IS_ORI'] = 1;
        $data1[0]['APPROVE_BY'] = NULL;
        $data1[0]['APPROVE_DATE'] = NULL;

        $data1[1]['SLOC'] = $value[2];
        $data1[1]['JNS_TRANSAKSI'] = 'Stockopname';
        $data1[1]['ID_JNS_BHN_BKR'] = $value[3];
        $data1[1]['NO_TUG'] = $value[5];
        $data1[1]['TGL_MUTASI_PENGAKUAN'] = $value[4];
        $data1[1]['STATUS'] = 'Belum Disetujui';
        $data1[1]['JNS_ROLLBACK'] = $jnsrollback;
        $data1[1]['CREATED_BY'] = $this->session->userdata('user_name');
        $data1[1]['CREATED_AT'] = date("Y-m-d H:i:s");
        $data1[1]['ALASAN'] = 'Bukan Data Utama';
        $data1[1]['IS_ORI'] = 0;
        $data1[1]['APPROVE_BY'] = $value[6];
        $data1[1]['APPROVE_DATE'] = $value[7];

        $this->db->trans_begin();

        $this->db->insert_batch('LOG_ROLLBACK_MUTASI_PEMAKAIAN1', $data1);
        $this->db->delete('MUTASI_PEMAKAIAN', $this->_key($data3));
        $this->db->update('STOCK_OPNAME', $data2, $this->_key5($data4));
        $this->db->delete('KOMPONEN_HITUNG', $this->_key($data3));
        $this->db->delete('KOMPONEN_HITUNG', $this->_key5($data4));
        $this->db->where('ID_JNS_BHN_BKR', $bbm);
        $this->db->where('TGL_MUTASI_PERSEDIAAN', $tgl);
        $this->db->delete('REKAP_MUTASI_PERSEDIAAN', $this->_key2($data5));
        $this->db->where('ID_JNS_BHN_BKR', $value[3]);
        $this->db->where('TGL_MUTASI_PERSEDIAAN', $value[4]);
        $this->db->delete('REKAP_MUTASI_PERSEDIAAN', $this->_key2($data6));

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