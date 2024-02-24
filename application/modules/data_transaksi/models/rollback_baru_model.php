<?php
/**
 * @module TRANSAKSI
 * @author  CF
 * @created at 11 FEBRUARI 2019
 * @modified at 11 FEBRUARI 2019
 */
class rollback_baru_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    
    // private $_table1 = "VLOAD_LIST_PENERIMAAN_V2"; //nama table setelah 
    private $_table = "LOG_ROLLBACK";
    private $_table2 = "MUTASI_PENERIMAAN"; //nama table setelah 
    
    private function _key($key) { //unit ID
        if (!is_array($key)) {
            $key = array('ID_PERMINTAAN' => $key);
        }
        return $key;
    }

    private function _key2($key) { //unit ID
        if (!is_array($key)) {
            $key = array('ID_STOCKOPNAME' => $key);
        }
        return $key;
    } 

    private function _key3($key) { //unit ID
        if (!is_array($key)) {
            $key = array('ID_PEMAKAIAN' => $key);
        }
        return $key;
    }

    private function _key4($key) { //unit ID
        if (!is_array($key)) {
            $key = array('ID_PENERIMAAN' => $key);
        }
        return $key;
    }
   
    public function data($key = '') {
        $this->db->select('LEVEL4,ID_TRX,JNS_TRX,NAMA_JNS_BHN_BKR,KETERANGAN,a.TGL_PENGAKUAN,NO_NOMINASI,NO_STOCKOPNAME,NO_TUG,NO_MUTASI_TERIMA');
        $this->db->from($this->_table." a");
        $this->db->join('M_JNS_BHN_BKR b ',' a.ID_JNS_BHN_BKR = b.ID_JNS_BHN_BKR');
        $this->db->join('MASTER_LEVEL4 c ',' a.SLOC = c.SLOC');
        $this->db->join('LOG_ROLLBACK_STOCK_OPNAME d ',' a.ID_TRX = d.ID_STOCKOPNAME','LEFT');
        $this->db->join('LOG_ROLLBACK_MUTASI_PEMAKAIAN e ',' a.ID_TRX = e.ID_PEMAKAIAN','LEFT');
        $this->db->join('LOG_ROLLBACK_MUTASI_PENERIMAAN f ',' a.ID_TRX = f.ID_PENERIMAAN','LEFT');
        $this->db->join('LOG_ROLLBACK_MUTASI_NOMINASI g ',' a.ID_TRX = g.ID_PERMINTAAN','LEFT');

        $this->db->order_by('a.CD_DATE DESC');

        return $this->db;
    }

    public function data_table($module = '', $limit = 20, $offset = 1) {
        $filter = array();
        $kata_kunci = $this->laccess->ai($this->input->post('kata_kunci'));

        if (!empty($kata_kunci))
            $filter[$this->_table1 . ".NOMINAL LIKE '%{$kata_kunci}%' or JUAL LIKE '%{$kata_kunci}%' or KTBI LIKE '%{$kata_kunci}%' "] = NULL;
        $total = $this->data($filter)->count_all_results();
        $this->db->limit($limit, ($offset * $limit) - $limit);
        $record = $this->data($filter)->get();
        $no=(($offset-1) * $limit) +1;
        $rows = array();
        foreach ($record->result() as $row) {
            $id = $row->ID_ROLLBACK;
            if($row->JNS_TRX == 1){
                $jenis = 'STOCK OPNAME';
                $nama = $row->NO_STOCKOPNAME;
            } else if($row->JNS_TRX == 2){
                $jenis = 'PEMAKAIAN';
                $nama = $row->NO_TUG;
            } else if($row->JNS_TRX == 3){
                $jenis = 'NOMINASI';
                $nama = $row->NO_NOMINASI;
            } else if($row->JNS_TRX == 4){
                $jenis = 'PENERIMAAN';
                $nama = $row->NO_MUTASI_TERIMA;
            }
            $rows[$no] = array(
                'NO' => $no++,
                'LEVEL4' => $row->LEVEL4,
                'ID_TRX' => $nama,
                'JNS_TRX' => $jenis,
                'NAMA_JNS_BHN_BKR' => $row->NAMA_JNS_BHN_BKR,
                'TGL_PENGAKUAN' => $row->TGL_PENGAKUAN,
                'KETERANGAN' => $row->KETERANGAN,
            );
        }

        return array('total' => $total, 'rows' => $rows);
    }
    
    public function options_pemasok($key = '', $default = '--Pilih Pemasok--') {
        $option = array();
        $this->db->from('MASTER_PEMASOK');
        $this->db->order_by('REF_NAMA_TRANS, NAMA_PEMASOK');
        if ($key){
            $this->db->where('ID_PEMASOK',$key);    
        } else {
            if (!empty($default)) {
                $option[''] = $default;
            }            
        }
                
        $list = $this->db->get();
        
        foreach ($list->result() as $row) {
            $option[$row->ID_PEMASOK] = $row->NAMA_PEMASOK;
        }
        $this->db->close();
        return $option;
    }

    public function options_pemasok_by_sloc($default = '--Pilih Pemasok--', $key = '-') {
        $option = array();
        
        $option[''] = $default;
        // $option['00000000000000000013'] = 'PENGEMBALIAN';
        // $option['00000000000000000004'] = 'PT PERTAMINA (PERSERO)';
                
        $list = $this->db->query("call GET_PEMASOK('".$key."');");
            
        foreach ($list->result() as $row) {
            $option[$row->ID_PEMASOK] = $row->NAMA_PEMASOK;
        }
        $this->db->close();
        return $option;
    }      
    
    public function options_transpotir($default = '--Pilih Transportir--') {
        $this->db->from('MASTER_TRANSPORTIR');
        $this->db->order_by('REF_NAMA_TRANS, NAMA_TRANSPORTIR');
        
        $option = array();
        $list = $this->db->get();

        
        if (!empty($default)) {
            $option[''] = $default;
        }
        
        foreach ($list->result() as $row) {
            $option[$row->ID_TRANSPORTIR] = $row->NAMA_TRANSPORTIR;
        }
        $this->db->close();
        return $option;
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
    
    public function get_transaksi($sloc,$bbm,$jns) {
        if($jns == 1){
            $query = "SELECT * FROM STOCK_OPNAME WHERE SLOC = '$sloc' AND ID_JNS_BHN_BKR = '$bbm' AND STATUS_APPROVE_STOCKOPNAME IN (1,2,5,6) ORDER BY TGL_BA_STOCKOPNAME DESC";
           
        } else if($jns == 3) {
            $query = "SELECT * FROM MUTASI_NOMINASI WHERE SLOC = '$sloc' AND ID_JNS_BHN_BKR = '$bbm'";
        } else if($jns == 2) {
            $query = "SELECT * FROM MUTASI_PEMAKAIAN WHERE SLOC = '$sloc' AND ID_JNS_BHN_BKR = '$bbm'";
        } else if($jns == 4) {
            $query = "SELECT * FROM MUTASI_PENERIMAAN WHERE SLOC = '$sloc' AND ID_JNS_BHN_BKR = '$bbm'";
        }
        
        $sql = $this->db->query($query);
        $list = $sql->result();
        if ($jenis==0){
            $rest = $list;
        } else {
            $option = array();
            foreach ($list as $row) {  
                if($jns == 1) {
                    $option[$row->ID_STOCKOPNAME] = $row->NO_STOCKOPNAME; 
                } else if($jns == 3) {
                    $option[$row->ID_PERMINTAAN] = $row->NO_NOMINASI; 
                } else if($jns == 2) {
                    $option[$row->ID_PEMAKAIAN] = $row->NO_TUG; 
                } else if($jns == 4) {
                    $option[$row->ID_PENERIMAAN] = $row->NO_MUTASI_TERIMA; 
                }      
            }
            $rest = $option;
        }
        
        $this->db->close();
        return $rest;    
    }

    public function get_detailtransaksi($idtrans,$jenis){

        if($jenis == 1){
            $query = "SELECT TGL_BA_STOCKOPNAME,STATUS_APPROVE_STOCKOPNAME FROM STOCK_OPNAME WHERE ID_STOCKOPNAME= '$idtrans'";

        } else if($jenis == 3){
            $query = "SELECT TGL_MTS_NOMINASI,STATUS_APPROVE FROM MUTASI_NOMINASI WHERE ID_PERMINTAAN = '$idtrans'";
        } else if($jenis == 2){
            $query = "SELECT TGL_MUTASI_PENGAKUAN,STATUS_MUTASI_PEMAKAIAN FROM MUTASI_PEMAKAIAN WHERE ID_PEMAKAIAN = '$idtrans'";
        } else if($jenis == 4){
            $query = "SELECT TGL_PENGAKUAN,STATUS_MUTASI_TERIMA FROM MUTASI_PENERIMAAN WHERE ID_PENERIMAAN = '$idtrans'";
        }
        $sql = $this->db->query($query);
        $list = $sql->row();
        
        $this->db->close();
        return $list;    
    }

    public function get_transaksi_penerimaan($sloc,$bbm,$tgl,$no_trans){
        $q1 =  "SELECT * FROM (
                SELECT TGL_PENGAKUAN AS TGL FROM MUTASI_PENERIMAAN AS TGL 
                WHERE SLOC = '$sloc'
                AND STATUS_MUTASI_TERIMA IN (2,6)
                AND ID_JNS_BHN_BKR = '$bbm' AND TGL_PENGAKUAN > '$tgl' LIMIT 1
                UNION
                SELECT TGL_BA_STOCKOPNAME AS TGL FROM STOCK_OPNAME  
                WHERE SLOC = '$sloc' 
                AND STATUS_APPROVE_STOCKOPNAME IN (2,6)
                AND TGL_BA_STOCKOPNAME > '$tgl' LIMIT 1
            )
            c ORDER BY c.TGL ASC LIMIT 1";
        $row = $this->db->query($q1)->row();
        $new_tgl = $row->TGL;
        $query = "
                SELECT 'PEMAKAIAN' AS JNS_TRX_BACKDATE,a.ID_PEMAKAIAN AS ID_TRX,NO_TUG AS NO_TRX,
                a.TGL_MUTASI_PENGAKUAN AS TGL,b.LEVEL4,c.NAMA_JNS_BHN_BKR,
                a.STATUS_MUTASI_PEMAKAIAN AS STATUS,VOLUME_PEMAKAIAN AS JML
                FROM MUTASI_PEMAKAIAN a
                LEFT JOIN MASTER_LEVEL4 b ON a.SLOC = b.SLOC
                LEFT JOIN M_JNS_BHN_BKR c ON a.ID_JNS_BHN_BKR = c.ID_JNS_BHN_BKR
                WHERE a.SLOC = '$sloc'
                AND a.ID_JNS_BHN_BKR = '$bbm'
                AND a.STATUS_MUTASI_PEMAKAIAN IN (2,6) 
               ";
        if($new_tgl == ""){
            $query .= " AND a.TGL_MUTASI_PENGAKUAN > '$tgl'";
        } else {
            $query .= " AND a.TGL_MUTASI_PENGAKUAN > '$tgl' AND a.TGL_MUTASI_PENGAKUAN <= '$new_tgl'";
        }

        

        $result = $this->db->query($query)->result_array();

        return $result;
    }

    public function get_transaksi_pemakaian($sloc,$bbm,$tgl,$no_trans){
        $q1 =  "SELECT * FROM (
                SELECT TGL_PENGAKUAN AS TGL FROM MUTASI_PENERIMAAN AS TGL 
                WHERE SLOC = '$sloc'
                AND STATUS_MUTASI_TERIMA IN (2,6)
                AND ID_JNS_BHN_BKR = '$bbm' AND TGL_PENGAKUAN > '$tgl' LIMIT 1
                UNION
                SELECT TGL_BA_STOCKOPNAME AS TGL FROM STOCK_OPNAME  
                WHERE SLOC = '$sloc' 
                AND STATUS_APPROVE_STOCKOPNAME IN (2,6)
                AND TGL_BA_STOCKOPNAME > '$tgl' LIMIT 1
            )
            c ORDER BY c.TGL ASC LIMIT 1";
        $row = $this->db->query($q1)->row();
        $new_tgl = $row->TGL;
        $query = "
                SELECT 'PEMAKAIAN' AS JNS_TRX_BACKDATE,a.ID_PEMAKAIAN AS ID_TRX,NO_TUG AS NO_TRX,
                a.TGL_MUTASI_PENGAKUAN AS TGL,b.LEVEL4,c.NAMA_JNS_BHN_BKR,
                a.STATUS_MUTASI_PEMAKAIAN AS STATUS,VOLUME_PEMAKAIAN AS JML
                FROM MUTASI_PEMAKAIAN a
                LEFT JOIN MASTER_LEVEL4 b ON a.SLOC = b.SLOC
                LEFT JOIN M_JNS_BHN_BKR c ON a.ID_JNS_BHN_BKR = c.ID_JNS_BHN_BKR
                WHERE a.SLOC = '$sloc'
                AND a.ID_JNS_BHN_BKR = '$bbm'
                AND a.STATUS_MUTASI_PEMAKAIAN IN (2,6) 
               ";
        if($new_tgl == ""){
            $query .= " AND a.TGL_MUTASI_PENGAKUAN > '$tgl'";
        } else {
            $query .= " AND a.TGL_MUTASI_PENGAKUAN > '$tgl' AND a.TGL_MUTASI_PENGAKUAN <= '$new_tgl'";
        }

        

        $result = $this->db->query($query)->result_array();

        return $result;
    }

    public function get_transaksi_stockopname($sloc,$bbm,$tgl,$no_trans){
        
        $result = array();
        $q1 = "SELECT TGL_BA_STOCKOPNAME AS TGL FROM STOCK_OPNAME WHERE TGL_BA_STOCKOPNAME > '$tgl' AND SLOC = '$sloc' AND ID_JNS_BHN_BKR = '$bbm';";
        $q2 = "SELECT TGL_BA_STOCKOPNAME AS TGL FROM STOCK_OPNAME WHERE TGL_BA_STOCKOPNAME < '$tgl' AND SLOC = '$sloc' AND ID_JNS_BHN_BKR = '$bbm';";

        $exist = $this->db->query($q1)->num_rows();
        $exist2 = $this->db->query($q2)->num_rows();

        if($exist > 0) {
            if($exist2 > 0){
                $query = "CALL GET_BACKDATE_TRANS('$sloc','$bbm','$tgl');";
                $res = $this->db->query($query)->result_array();
            } else {
                $tgl2 = $this->db->query($q1)->row()->TGL;
                $query = "CALL GET_AFTERDATE_TRANS('$sloc','$bbm','$tgl','$tgl2');";

                $result = $this->db->query($query)->result_array();
            }
        } else {
            $result = array();
        }

        return $result;
    }

    public function get_transaksi_prev($sloc,$bbm,$tgl,$no_trans){

        $query = "CALL GET_BACKDATE_TRANS('$sloc','$bbm','$tgl');";
        $sql = $this->db->query($query);
        $list = $sql->result_array();
        
        $this->db->close();
        return $list;    
    }

    function get_data_array($arr) {

        $this->db->where('CREATE_BY','testbbm17');
        $this->db->delete('TEMP_ROLLBACK');

        if($arr[1] == 'PEMAKAIAN'){
            $data['ID_TRX'] = $this->get_idtrx_pemakaian($arr[0]);
        }
        if($arr[1] == 'PENERIMAAN'){
            $data['ID_TRX'] = $this->get_idtrx_penerimaan($arr[0]);
        }
        if($arr[1] == 'STOCKOPNAME'){
            $data['ID_TRX'] = $this->get_idtrx_stockopname($arr[0]);
        }

        $data['SLOC'] = $arr[2];
        $data['ID_JNS_BHN_BKR'] = $arr[3];
        $data['TGL_PENGAKUAN'] = $arr[4];
        $data['STATUS'] = 1;
        $data['JENIS_TRX'] = $arr[1];
        $data['CREATE_BY'] = 'testbbm17';

        $this->db->trans_begin();
        $this->db->insert('TEMP_ROLLBACK', $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
        return true;
    }

    public function update_nominasi($key) {
        $this->db->trans_begin();
        $data['STATUS_APPROVE'] = 0;
        $this->db->select('*');
        $this->db->from('MUTASI_NOMINASI');
        $this->db->where($this->_key($key));
        $res = $this->db->get();

        $this->db->insert('LOG_ROLLBACK_MUTASI_NOMINASI',$res->result_array());
        $this->db->update('MUTASI_NOMINASI', $data, $this->_key($key));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function update_stockopname($key) {
        $this->db->trans_begin();
        $data['STATUS_APPROVE_STOCKOPNAME'] = 0;
        $this->db->update('STOCK_OPNAME', $data, $this->_key2($key));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function update_pemakaian($key) {
        $this->db->trans_begin();
        $data['STATUS_MUTASI_PEMAKAIAN'] = 0;
        $this->db->update('MUTASI_PEMAKAIAN', $data, $this->_key3($key));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function update_penerimaan($key) {
        $this->db->trans_begin();
        $data['STATUS_MUTASI_TERIMA'] = 0;
        $this->db->update('MUTASI_PEMAKAIAN', $data, $this->_key4($key));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function delete_nominasi($key) {
        $this->db->trans_begin();

        $this->db->delete('MUTASI_NOMINASI', $this->_key($key));
        $this->db->delete('MUTASI_NOMINASI_KIRIM', $this->_key($key));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function delete_stockopname($key) {
        $this->db->trans_begin();

        $this->db->delete('STOCK_OPNAME', $this->_key2($key));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    public function delete_pemakaian($key) {
        $this->db->trans_begin();

        $this->db->delete('MUTASI_PEMAKAIAN', $this->_key3($key));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function delete_penerimaan($key) {
        $this->db->trans_begin();

        $this->db->delete('MUTASI_PEMAKAIAN', $this->_key4($key));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function get_temp_rollback(){
        $this->db->select('a.JENIS_TRX,a.ID_TRX,a.TGL_PENGAKUAN,b.LEVEL4,c.NAMA_JNS_BHN_BKR,d.NAME_SETTING AS STATUS');
        $this->db->from('TEMP_ROLLBACK a');
        $this->db->join('MASTER_LEVEL4 b','a.SLOC = b.SLOC','left');
        $this->db->join('M_JNS_BHN_BKR c','a.ID_JNS_BHN_BKR = c.ID_JNS_BHN_BKR','left');
        $this->db->join('DATA_SETTING d','a.STATUS = d.VALUE_SETTING AND KEY_SETTING = "STATUS_APPROVE"','left');

        $this->db->where('a.CREATE_BY','testbbm17');

        $res = $this->db->get();
        $result = $res->result_array();

        return $result;
    }

    public function save_stockopname_satu($data,$array,$jenis){

        $sloc = $array['SLOC'];
        $bbm = $array['ID_JNS_BHN_BKR'];
        $id_trans = $array['ID_TRANS'];
        $tgl = $array['TGL_BA'];

        $get_last_stock = "SELECT TGL_BA_STOCKOPNAME FROM STOCK_OPNAME 
                           WHERE DATE_FORMAT(TGL_BA_STOCKOPNAME,'%Y-%m-%d') > '$tgl' 
                           AND SLOC = '$sloc' AND ID_JNS_BHN_BKR = '$bbm' LIMIT 1;";

        $end_date = $this->db->query($get_last_stock)->row()->TGL_BA_STOCKOPNAME;

        $update = "UPDATE MUTASI_PEMAKAIAN
                   SET STATUS_MUTASI_PEMAKAIAN = 0
                   WHERE ID_PEMAKAIAN IN(".implode(",", $data).");";

        if($jenis == 'REVISI'){
            $delete = "UPDATE STOCK_OPNAME
                       SET STATUS_APPROVE_STOCKOPNAME = 0
                       WHERE ID_STOCKOPNAME = '$id_trans';";
        } else if($jenis == 'HAPUS') {
            $delete = "DELETE FROM STOCK_OPNAME 
                   WHERE ID_STOCKOPNAME = '$id_trans';";
        }
        
        $delete_rekap = "DELETE FROM REKAP_MUTASI_PERSEDIAAN 
                         WHERE TGL_MUTASI_PERSEDIAAN BETWEEN '$tgl' AND '$end_date'
                         AND SLOC='$sloc' AND ID_JNS_BHN_BKR= '$bbm';";

        $delete_komponen = "DELETE FROM KOMPONEN_HITUNG WHERE ID_STOCKOPNAME = '$id_trans';";

        $insert = "INSERT INTO LOG_ROLLBACK_MUTASI_PEMAKAIAN
                   SELECT * FROM MUTASI_PEMAKAIAN
                   WHERE ID_PEMAKAIAN IN(".implode(",", $data).");";

        $insert_stockopname = "INSERT INTO LOG_ROLLBACK_STOCK_OPNAME
                               SELECT * FROM STOCK_OPNAME
                               WHERE ID_STOCKOPNAME = '$id_trans';";

        $insert_rekap = "INSERT INTO LOG_ROLLBACK_REKAP_MUTASI_PERSEDIAAN
                         SELECT * FROM REKAP_MUTASI_PERSEDIAAN 
                         WHERE TGL_MUTASI_PERSEDIAAN BETWEEN '$tgl' AND '$end_date'
                         AND SLOC='$sloc' AND ID_JNS_BHN_BKR= '$bbm';";

        $insert_komponen = "INSERT INTO LOG_ROLLBACK_KOMPONEN_HITUNG
                            SELECT * FROM KOMPONEN_HITUNG WHERE ID_STOCKOPNAME = '$id_trans';";

        $this->db->trans_begin();
        
        $this->db->query($insert);
        $this->db->query($insert_stockopname);
        $this->db->query($insert_rekap);
        $this->db->query($insert_komponen);
        $this->db->query($update);
        $this->db->query($delete);
        $this->db->query($delete_rekap);
        $this->db->query($delete_komponen);
        
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }

    }

    public function save_stockopname_dua($data,$array,$jenis){
        $sloc = $array['SLOC'];
        $bbm = $array['ID_JNS_BHN_BKR'];
        $id_trans = $array['ID_TRANS'];
        $tgl = $array['TGL_BA'];
        $id = $data[0];
        $tgl_akhir = $data[4];

        if($jenis == 'REVISI'){
            $delete_stockopname = "UPDATE STOCK_OPNAME
                       SET STATUS_APPROVE_STOCKOPNAME = 0
                       WHERE ID_STOCKOPNAME = '$id_trans';";
        } else if($jenis == 'HAPUS') {
            $delete_stockopname = "DELETE FROM STOCK_OPNAME 
                   WHERE ID_STOCKOPNAME = '$id_trans';";
        }
        
        $insert_stockopname = "INSERT INTO LOG_ROLLBACK_STOCK_OPNAME
                               SELECT * FROM STOCK_OPNAME
                               WHERE ID_STOCKOPNAME = '$id_trans';";

        $delete_rekap       = "DELETE FROM REKAP_MUTASI_PERSEDIAAN 
                               WHERE DATE_FORMAT(TGL_MUTASI_PERSEDIAAN,'%Y%m%d')
                               BETWEEN '$tgl_akhir' AND DATE_FORMAT('$tgl','%Y%m%d')
                               AND SLOC='$sloc' AND ID_JNS_BHN_BKR= '$bbm';";

        $insert_rekap       = "INSERT INTO LOG_ROLLBACK_REKAP_MUTASI_PERSEDIAAN
                               SELECT * FROM REKAP_MUTASI_PERSEDIAAN 
                               WHERE DATE_FORMAT(TGL_MUTASI_PERSEDIAAN,'%Y%m%d') 
                               BETWEEN '$tgl_akhir' AND DATE_FORMAT('$tgl','%Y%m%d')
                               AND SLOC='$sloc' AND ID_JNS_BHN_BKR= '$bbm';";

        if($data[1] == "PEMAKAIAN") {
            $insert_komponen = "INSERT INTO LOG_ROLLBACK_KOMPONEN_HITUNG
                                SELECT * FROM KOMPONEN_HITUNG WHERE ID_PEMAKAIAN = '$id';";

            $delete_komponen = "DELETE FROM KOMPONEN_HITUNG WHERE ID_PEMAKAIAN = '$id';";
        } else if($data[1] == "PENERIMAAN"){
            $insert_komponen = "INSERT INTO LOG_ROLLBACK_KOMPONEN_HITUNG
                                SELECT * FROM KOMPONEN_HITUNG WHERE ID_PENERIMAAN = '$id';";

            $delete_komponen = "DELETE FROM KOMPONEN_HITUNG WHERE ID_PENERIMAAN = '$id';";
        } else if($data[1] == "STOCKOPNAME"){
            $insert_komponen = "INSERT INTO LOG_ROLLBACK_KOMPONEN_HITUNG
                                SELECT * FROM KOMPONEN_HITUNG WHERE ID_STOCKOPNAME = '$id';";

            $delete_komponen = "DELETE FROM KOMPONEN_HITUNG WHERE ID_STOCKOPNAME = '$id';";
        }

        $this->db->trans_begin();

        $this->db->query($insert_stockopname);
        $this->db->query($insert_rekap);
        $this->db->query($insert_komponen);
        $this->db->query($delete_stockopname);
        $this->db->query($delete_rekap);
        $this->db->query($delete_komponen);
        
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function save_stockopname_tiga($data1,$data,$array){
        $sloc = $array['SLOC'];
        $bbm = $array['ID_JNS_BHN_BKR'];
        $id_trans = $array['ID_TRANS'];
        $tgl = $array['TGL_BA'];
        $id = $data[0];
        $tgl_akhir = $data[4];
        $delete_stockopname = "DELETE FROM STOCK_OPNAME 
                               WHERE ID_STOCKOPNAME = '$id_trans';";

        $insert_stockopname = "INSERT INTO LOG_ROLLBACK_STOCK_OPNAME
                               SELECT * FROM STOCK_OPNAME
                               WHERE ID_STOCKOPNAME = '$id_trans';";

        $delete_rekap       = "DELETE FROM REKAP_MUTASI_PERSEDIAAN 
                               WHERE DATE_FORMAT(TGL_MUTASI_PERSEDIAAN,'%Y%m%d')
                               BETWEEN '$tgl_akhir' AND DATE_FORMAT('$tgl','%Y%m%d')
                               AND SLOC='$sloc' AND ID_JNS_BHN_BKR= '$bbm';";

        $insert_rekap       = "INSERT INTO LOG_ROLLBACK_REKAP_MUTASI_PERSEDIAAN
                               SELECT * FROM REKAP_MUTASI_PERSEDIAAN 
                               WHERE DATE_FORMAT(TGL_MUTASI_PERSEDIAAN,'%Y%m%d') 
                               BETWEEN '$tgl_akhir' AND DATE_FORMAT('$tgl','%Y%m%d')
                               AND SLOC='$sloc' AND ID_JNS_BHN_BKR= '$bbm';";

        if($data[1] == "PEMAKAIAN") {
            $insert_komponen = "INSERT INTO LOG_ROLLBACK_KOMPONEN_HITUNG
                                SELECT * FROM KOMPONEN_HITUNG WHERE ID_PEMAKAIAN = '$id';";

            $delete_komponen = "DELETE FROM KOMPONEN_HITUNG WHERE ID_PEMAKAIAN = '$id';";
        } else if($data[1] == "PENERIMAAN"){
            $insert_komponen = "INSERT INTO LOG_ROLLBACK_KOMPONEN_HITUNG
                                SELECT * FROM KOMPONEN_HITUNG WHERE ID_PENERIMAAN = '$id';";

            $delete_komponen = "DELETE FROM KOMPONEN_HITUNG WHERE ID_PENERIMAAN = '$id';";
        } else if($data[1] == "STOCKOPNAME"){
            $insert_komponen = "INSERT INTO LOG_ROLLBACK_KOMPONEN_HITUNG
                                SELECT * FROM KOMPONEN_HITUNG WHERE ID_STOCKOPNAME = '$id';";

            $delete_komponen = "DELETE FROM KOMPONEN_HITUNG WHERE ID_STOCKOPNAME = '$id';";
        }

        $update = "UPDATE MUTASI_PEMAKAIAN
                   SET STATUS_MUTASI_PEMAKAIAN = 0
                   WHERE ID_PEMAKAIAN IN(".implode(",", $data1).");";

        $insert = "INSERT INTO LOG_ROLLBACK_MUTASI_PEMAKAIAN
                   SELECT * FROM MUTASI_PEMAKAIAN
                   WHERE ID_PEMAKAIAN IN(".implode(",", $data1).");";

        $this->db->trans_begin();
        
        $this->db->query($insert);
        $this->db->query($insert_stockopname);
        $this->db->query($insert_rekap);
        $this->db->query($insert_komponen);
        $this->db->query($update);
        $this->db->query($delete_stockopname);
        $this->db->query($delete_rekap);
        $this->db->query($delete_komponen);
        
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }


    public function save_pemakaian_satu($data,$array){

        $sloc = $array['SLOC'];
        $bbm = $array['ID_JNS_BHN_BKR'];
        $id_trans = $array['ID_TRANS'];
        $tgl = $array['TGL_BA'];

        $get_last_stock = "SELECT TGL_BA_STOCKOPNAME FROM STOCK_OPNAME 
                           WHERE DATE_FORMAT(TGL_BA_STOCKOPNAME,'%Y-%m-%d') > '$tgl' 
                           AND SLOC = '$sloc' AND ID_JNS_BHN_BKR = '$bbm' LIMIT 1;";

        $end_date = $this->db->query($get_last_stock)->row()->TGL_BA_STOCKOPNAME;

        $update = "UPDATE MUTASI_PEMAKAIAN
                   SET STATUS_MUTASI_PEMAKAIAN = 0
                   WHERE ID_PEMAKAIAN IN(".implode(",", $data).");";

        $delete = "DELETE FROM MUTASI_PEMAKAIAN 
                   WHERE ID_PEMAKAIAN = '$id_trans';";

        $delete_rekap = "DELETE FROM REKAP_MUTASI_PERSEDIAAN 
                         WHERE TGL_MUTASI_PERSEDIAAN BETWEEN '$tgl' AND '$end_date'
                         AND SLOC='$sloc' AND ID_JNS_BHN_BKR= '$bbm';";

        $delete_komponen = "DELETE FROM KOMPONEN_HITUNG WHERE ID_STOCKOPNAME = '$id_trans';";

        $insert = "INSERT INTO LOG_ROLLBACK_MUTASI_PEMAKAIAN
                   SELECT * FROM MUTASI_PEMAKAIAN
                   WHERE ID_PEMAKAIAN IN(".implode(",", $data).");";

        $insert_pemakaian = "INSERT INTO LOG_ROLLBACK_MUTASI_PEMAKAIAN
                             SELECT * FROM MUTASI_PEMAKAIAN
                             WHERE ID_PEMAKAIAN = '$id_trans';";

        $insert_rekap = "INSERT INTO LOG_ROLLBACK_REKAP_MUTASI_PERSEDIAAN
                         SELECT * FROM REKAP_MUTASI_PERSEDIAAN 
                         WHERE TGL_MUTASI_PERSEDIAAN BETWEEN '$tgl' AND '$end_date'
                         AND SLOC='$sloc' AND ID_JNS_BHN_BKR= '$bbm';";

        $insert_komponen = "INSERT INTO LOG_ROLLBACK_KOMPONEN_HITUNG
                            SELECT * FROM KOMPONEN_HITUNG WHERE ID_STOCKOPNAME = '$id_trans';";

        $this->db->trans_begin();
        
        $this->db->query($insert);
        $this->db->query($insert_pemakaian);
        $this->db->query($insert_rekap);
        $this->db->query($insert_komponen);
        $this->db->query($update);
        $this->db->query($delete);
        $this->db->query($delete_rekap);
        $this->db->query($delete_komponen);
        
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }

    }

    public function save_pemakaian_dua($data,$array){
        $sloc = $array['SLOC'];
        $bbm = $array['ID_JNS_BHN_BKR'];
        $id_trans = $array['ID_TRANS'];
        $tgl = $array['TGL_BA'];
        $id = $data[0];
        $tgl_akhir = $data[4];
        $delete_pemakaian = "DELETE FROM MUTASI_PEMAKAIAN 
                               WHERE ID_PEMAKAIAN = '$id_trans';";

        $insert_pemakaian = "INSERT INTO LOG_ROLLBACK_MUTASI_PEMAKAIAN
                             SELECT * FROM MUTASI_PEMAKAIAN
                             WHERE ID_PEMAKAIAN = '$id_trans';";

        $delete_rekap       = "DELETE FROM REKAP_MUTASI_PERSEDIAAN 
                               WHERE DATE_FORMAT(TGL_MUTASI_PERSEDIAAN,'%Y%m%d')
                               BETWEEN '$tgl_akhir' AND DATE_FORMAT('$tgl','%Y%m%d')
                               AND SLOC='$sloc' AND ID_JNS_BHN_BKR= '$bbm';";

        $insert_rekap       = "INSERT INTO LOG_ROLLBACK_REKAP_MUTASI_PERSEDIAAN
                               SELECT * FROM REKAP_MUTASI_PERSEDIAAN 
                               WHERE DATE_FORMAT(TGL_MUTASI_PERSEDIAAN,'%Y%m%d') 
                               BETWEEN '$tgl_akhir' AND DATE_FORMAT('$tgl','%Y%m%d')
                               AND SLOC='$sloc' AND ID_JNS_BHN_BKR= '$bbm';";

        if($data[1] == "PEMAKAIAN") {
            $insert_komponen = "INSERT INTO LOG_ROLLBACK_KOMPONEN_HITUNG
                                SELECT * FROM KOMPONEN_HITUNG WHERE ID_PEMAKAIAN = '$id';";

            $delete_komponen = "DELETE FROM KOMPONEN_HITUNG WHERE ID_PEMAKAIAN = '$id';";
        } else if($data[1] == "PENERIMAAN"){
            $insert_komponen = "INSERT INTO LOG_ROLLBACK_KOMPONEN_HITUNG
                                SELECT * FROM KOMPONEN_HITUNG WHERE ID_PENERIMAAN = '$id';";

            $delete_komponen = "DELETE FROM KOMPONEN_HITUNG WHERE ID_PENERIMAAN = '$id';";
        } else if($data[1] == "STOCKOPNAME"){
            $insert_komponen = "INSERT INTO LOG_ROLLBACK_KOMPONEN_HITUNG
                                SELECT * FROM KOMPONEN_HITUNG WHERE ID_STOCKOPNAME = '$id';";

            $delete_komponen = "DELETE FROM KOMPONEN_HITUNG WHERE ID_STOCKOPNAME = '$id';";
        }

        $this->db->trans_begin();
        
        $this->db->query($insert_pemakaian);
        $this->db->query($insert_rekap);
        $this->db->query($insert_komponen);
        $this->db->query($delete_pemakaian);
        $this->db->query($delete_rekap);
        $this->db->query($delete_komponen);
        
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function save_pemakaian_tiga($data1,$data,$array){
        $sloc = $array['SLOC'];
        $bbm = $array['ID_JNS_BHN_BKR'];
        $id_trans = $array['ID_TRANS'];
        $tgl = $array['TGL_BA'];
        $id = $data[0];
        $tgl_akhir = $data[4];
        $delete_pemakaian =   "DELETE FROM MUTASI_PEMAKAIAN 
                               WHERE ID_PEMAKAIAN = '$id_trans';";

        $insert_pemakaian =   "INSERT INTO LOG_ROLLBACK_MUTASI_PEMAKAIAN
                               SELECT * FROM MUTASI_PEMAKAIAN
                               WHERE ID_PEMAKAIAN = '$id_trans';";

        $delete_rekap       = "DELETE FROM REKAP_MUTASI_PERSEDIAAN 
                               WHERE DATE_FORMAT(TGL_MUTASI_PERSEDIAAN,'%Y%m%d')
                               BETWEEN '$tgl_akhir' AND DATE_FORMAT('$tgl','%Y%m%d')
                               AND SLOC='$sloc' AND ID_JNS_BHN_BKR= '$bbm';";

        $insert_rekap       = "INSERT INTO LOG_ROLLBACK_REKAP_MUTASI_PERSEDIAAN
                               SELECT * FROM REKAP_MUTASI_PERSEDIAAN 
                               WHERE DATE_FORMAT(TGL_MUTASI_PERSEDIAAN,'%Y%m%d') 
                               BETWEEN '$tgl_akhir' AND DATE_FORMAT('$tgl','%Y%m%d')
                               AND SLOC='$sloc' AND ID_JNS_BHN_BKR= '$bbm';";

        if($data[1] == "PEMAKAIAN") {
            $insert_komponen = "INSERT INTO LOG_ROLLBACK_KOMPONEN_HITUNG
                                SELECT * FROM KOMPONEN_HITUNG WHERE ID_PEMAKAIAN = '$id';";

            $delete_komponen = "DELETE FROM KOMPONEN_HITUNG WHERE ID_PEMAKAIAN = '$id';";
        } else if($data[1] == "PENERIMAAN"){
            $insert_komponen = "INSERT INTO LOG_ROLLBACK_KOMPONEN_HITUNG
                                SELECT * FROM KOMPONEN_HITUNG WHERE ID_PENERIMAAN = '$id';";

            $delete_komponen = "DELETE FROM KOMPONEN_HITUNG WHERE ID_PENERIMAAN = '$id';";
        } else if($data[1] == "STOCKOPNAME"){
            $insert_komponen = "INSERT INTO LOG_ROLLBACK_KOMPONEN_HITUNG
                                SELECT * FROM KOMPONEN_HITUNG WHERE ID_STOCKOPNAME = '$id';";

            $delete_komponen = "DELETE FROM KOMPONEN_HITUNG WHERE ID_STOCKOPNAME = '$id';";
        }

        $update = "UPDATE MUTASI_PEMAKAIAN
                   SET STATUS_MUTASI_PEMAKAIAN = 0
                   WHERE ID_PEMAKAIAN IN(".implode(",", $data1).");";

        $insert = "INSERT INTO LOG_ROLLBACK_MUTASI_PEMAKAIAN
                   SELECT * FROM MUTASI_PEMAKAIAN
                   WHERE ID_PEMAKAIAN IN(".implode(",", $data1).");";

        $this->db->trans_begin();
        
        $this->db->query($insert);
        $this->db->query($insert_pemakaian);
        $this->db->query($insert_rekap);
        $this->db->query($insert_komponen);
        $this->db->query($update);
        $this->db->query($delete_pemakaian);
        $this->db->query($delete_rekap);
        $this->db->query($delete_komponen);
        
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function save_penerimaan_satu($data,$array){

        $sloc = $array['SLOC'];
        $bbm = $array['ID_JNS_BHN_BKR'];
        $id_trans = $array['ID_TRANS'];
        $tgl = $array['TGL_BA'];

        $get_last_stock = "SELECT TGL_BA_STOCKOPNAME FROM STOCK_OPNAME 
                           WHERE DATE_FORMAT(TGL_BA_STOCKOPNAME,'%Y-%m-%d') > '$tgl' 
                           AND SLOC = '$sloc' AND ID_JNS_BHN_BKR = '$bbm' LIMIT 1;";

        $end_date = $this->db->query($get_last_stock)->row()->TGL_BA_STOCKOPNAME;

        $update = "UPDATE MUTASI_PEMAKAIAN
                   SET STATUS_MUTASI_PEMAKAIAN = 0
                   WHERE ID_PEMAKAIAN IN(".implode(",", $data).");";

        $insert = "INSERT INTO LOG_ROLLBACK_MUTASI_PEMAKAIAN
                   SELECT * FROM MUTASI_PEMAKAIAN
                   WHERE ID_PEMAKAIAN IN(".implode(",", $data).");";

        $insert_penerimaan = "INSERT INTO LOG_ROLLBACK_MUTASI_PENERIMAAN
                             SELECT * FROM MUTASI_PENERIMAAN
                             WHERE ID_PENERIMAAN = '$id_trans';";

        $delete_penerimaan = "DELETE FROM MUTASI_PENERIMAAN
                              WHERE ID_PENERIMAAN = '$id_trans';";

        $delete_rekap = "DELETE FROM REKAP_MUTASI_PERSEDIAAN 
                         WHERE TGL_MUTASI_PERSEDIAAN BETWEEN '$tgl' AND '$end_date'
                         AND SLOC='$sloc' AND ID_JNS_BHN_BKR= '$bbm';";

        $delete_komponen = "DELETE FROM KOMPONEN_HITUNG WHERE ID_STOCKOPNAME = '$id_trans';";

        $insert_rekap = "INSERT INTO LOG_ROLLBACK_REKAP_MUTASI_PERSEDIAAN
                         SELECT * FROM REKAP_MUTASI_PERSEDIAAN 
                         WHERE TGL_MUTASI_PERSEDIAAN BETWEEN '$tgl' AND '$end_date'
                         AND SLOC='$sloc' AND ID_JNS_BHN_BKR= '$bbm';";

        $insert_komponen = "INSERT INTO LOG_ROLLBACK_KOMPONEN_HITUNG
                            SELECT * FROM KOMPONEN_HITUNG WHERE ID_STOCKOPNAME = '$id_trans';";

        $this->db->trans_begin();
        
        $this->db->query($insert);
        $this->db->query($insert_penerimaan);
        $this->db->query($insert_rekap);
        $this->db->query($insert_komponen);

        $this->db->query($update);
        $this->db->query($delete_penerimaan);
        $this->db->query($delete_rekap);
        $this->db->query($delete_komponen);
        
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }

    }

    public function save_penerimaan_dua($data,$array){
        $sloc = $array['SLOC'];
        $bbm = $array['ID_JNS_BHN_BKR'];
        $id_trans = $array['ID_TRANS'];
        $tgl = $array['TGL_BA'];
        $id = $data[0];
        $tgl_akhir = $data[4];

        $insert_penerimaan = "INSERT INTO LOG_ROLLBACK_MUTASI_PENERIMAAN
                             SELECT * FROM MUTASI_PENERIMAAN
                             WHERE ID_PENERIMAAN = '$id_trans';";

        $delete_penerimaan =   "DELETE FROM MUTASI_PENERIMAAN
                               WHERE ID_PENERIMAAN = '$id_trans';";

        $delete_rekap       = "DELETE FROM REKAP_MUTASI_PERSEDIAAN 
                               WHERE DATE_FORMAT(TGL_MUTASI_PERSEDIAAN,'%Y%m%d')
                               BETWEEN '$tgl_akhir' AND DATE_FORMAT('$tgl','%Y%m%d')
                               AND SLOC='$sloc' AND ID_JNS_BHN_BKR= '$bbm';";

        $insert_rekap       = "INSERT INTO LOG_ROLLBACK_REKAP_MUTASI_PERSEDIAAN
                               SELECT * FROM REKAP_MUTASI_PERSEDIAAN 
                               WHERE DATE_FORMAT(TGL_MUTASI_PERSEDIAAN,'%Y%m%d') 
                               BETWEEN '$tgl_akhir' AND DATE_FORMAT('$tgl','%Y%m%d')
                               AND SLOC='$sloc' AND ID_JNS_BHN_BKR= '$bbm';";

        if($data[1] == "PEMAKAIAN") {
            $insert_komponen = "INSERT INTO LOG_ROLLBACK_KOMPONEN_HITUNG
                                SELECT * FROM KOMPONEN_HITUNG WHERE ID_PEMAKAIAN = '$id';";

            $delete_komponen = "DELETE FROM KOMPONEN_HITUNG WHERE ID_PEMAKAIAN = '$id';";
        } else if($data[1] == "PENERIMAAN"){
            $insert_komponen = "INSERT INTO LOG_ROLLBACK_KOMPONEN_HITUNG
                                SELECT * FROM KOMPONEN_HITUNG WHERE ID_PENERIMAAN = '$id';";

            $delete_komponen = "DELETE FROM KOMPONEN_HITUNG WHERE ID_PENERIMAAN = '$id';";
        } else if($data[1] == "STOCKOPNAME"){
            $insert_komponen = "INSERT INTO LOG_ROLLBACK_KOMPONEN_HITUNG
                                SELECT * FROM KOMPONEN_HITUNG WHERE ID_STOCKOPNAME = '$id';";

            $delete_komponen = "DELETE FROM KOMPONEN_HITUNG WHERE ID_STOCKOPNAME = '$id';";
        }

        $this->db->trans_begin();
        
        $this->db->query($insert_penerimaan);
        $this->db->query($insert_rekap);
        $this->db->query($insert_komponen);
        $this->db->query($delete_penerimaan);
        $this->db->query($delete_rekap);
        $this->db->query($delete_komponen);
        
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function save_penerimaan_tiga($data1,$data,$array){

        $sloc = $array['SLOC'];
        $bbm = $array['ID_JNS_BHN_BKR'];
        $id_trans = $array['ID_TRANS'];
        $tgl = $array['TGL_BA'];
        $id = $data[0];
        $tgl_akhir = $data[4];
        
        $insert_penerimaan  = "INSERT INTO LOG_ROLLBACK_MUTASI_PENERIMAAN
                               SELECT * FROM MUTASI_PENERIMAAN
                               WHERE ID_PENERIMAAN = '$id_trans';";

        $delete_penerimaan  = "DELETE FROM MUTASI_PENERIMAAN
                               WHERE ID_PENERIMAAN = '$id_trans';";

        $delete_rekap       = "DELETE FROM REKAP_MUTASI_PERSEDIAAN 
                               WHERE DATE_FORMAT(TGL_MUTASI_PERSEDIAAN,'%Y%m%d')
                               BETWEEN '$tgl_akhir' AND DATE_FORMAT('$tgl','%Y%m%d')
                               AND SLOC='$sloc' AND ID_JNS_BHN_BKR= '$bbm';";

        $insert_rekap       = "INSERT INTO LOG_ROLLBACK_REKAP_MUTASI_PERSEDIAAN
                               SELECT * FROM REKAP_MUTASI_PERSEDIAAN 
                               WHERE DATE_FORMAT(TGL_MUTASI_PERSEDIAAN,'%Y%m%d') 
                               BETWEEN '$tgl_akhir' AND DATE_FORMAT('$tgl','%Y%m%d')
                               AND SLOC='$sloc' AND ID_JNS_BHN_BKR= '$bbm';";

        if($data[1] == "PEMAKAIAN") {
            $insert_komponen = "INSERT INTO LOG_ROLLBACK_KOMPONEN_HITUNG
                                SELECT * FROM KOMPONEN_HITUNG WHERE ID_PEMAKAIAN = '$id';";

            $delete_komponen = "DELETE FROM KOMPONEN_HITUNG WHERE ID_PEMAKAIAN = '$id';";
        } else if($data[1] == "PENERIMAAN"){
            $insert_komponen = "INSERT INTO LOG_ROLLBACK_KOMPONEN_HITUNG
                                SELECT * FROM KOMPONEN_HITUNG WHERE ID_PENERIMAAN = '$id';";

            $delete_komponen = "DELETE FROM KOMPONEN_HITUNG WHERE ID_PENERIMAAN = '$id';";
        } else if($data[1] == "STOCKOPNAME"){
            $insert_komponen = "INSERT INTO LOG_ROLLBACK_KOMPONEN_HITUNG
                                SELECT * FROM KOMPONEN_HITUNG WHERE ID_STOCKOPNAME = '$id';";

            $delete_komponen = "DELETE FROM KOMPONEN_HITUNG WHERE ID_STOCKOPNAME = '$id';";
        }

        $update = "UPDATE MUTASI_PEMAKAIAN
                   SET STATUS_MUTASI_PEMAKAIAN = 0
                   WHERE ID_PEMAKAIAN IN(".implode(",", $data1).");";

        $insert = "INSERT INTO LOG_ROLLBACK_MUTASI_PEMAKAIAN
                   SELECT * FROM MUTASI_PEMAKAIAN
                   WHERE ID_PEMAKAIAN IN(".implode(",", $data1).");";

        $this->db->trans_begin();
        
        $this->db->query($insert);
        $this->db->query($insert_penerimaan);
        $this->db->query($insert_rekap);
        $this->db->query($insert_komponen);
        $this->db->query($update);
        $this->db->query($delete_penerimaan);
        $this->db->query($delete_rekap);
        $this->db->query($delete_komponen);
        
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    // END

    function get_idtrx_pemakaian($id){
        $query = "SELECT NO_TUG FROM MUTASI_PEMAKAIAN WHERE ID_PEMAKAIAN = '$id'";
        $result = $this->db->query($query)->row()->NO_TUG;
        return $result;
    }

    function get_idtrx_stockopname($id){
        $query = "SELECT NO_STOCKOPNAME FROM STOCK_OPNAME WHERE ID_STOCKOPNAME = '$id'";
        $result = $this->db->query($query)->row()->NO_STOCKOPNAME;
        return $result;
    }

    function get_idtrx_penerimaan($id){
        $query = "SELECT NO_MUTASI_TERIMA FROM MUTASI_PENERIMAAN WHERE ID_PENERIMAAN = '$id'";
        $result = $this->db->query($query)->row()->NO_MUTASI_TERIMA;
        return $result;
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