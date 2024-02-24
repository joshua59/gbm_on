<?php

/**
 * @module User Management
 */
class template_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table1 = "M_OTORITAS_MENU";
    private $_table2 = "M_MENU";
    private $_table = "SETTING";
    
    public function data_menu($key = '') {
        $this->db->from($this->_table1);
        $this->db->join($this->_table2, "{$this->_table2}.MENU_ID = {$this->_table1}.MENU_ID");
        $this->db->where_condition(array("{$this->_table1}.IS_VIEW" => 't'));
        $this->db->where_condition(array("{$this->_table1}.ROLES_ID" => $key));
        $this->db->order_by($this->_table2 . '.MENU_URUTAN');
        return $this->db;
    }
    
    public function parameter() {
        $this->db->from($this->_table);
        $param = $this->db->get();
        return $param;//->row();
    }

    public function get_notif_kirim() {
        $user = $this->session->userdata('user_name');
        $jenis = $_POST['jenis'];

        if (strtoupper($jenis)=='KIRIM'){
            $q="CALL GET_NOTIF_KIRIM ('$user') ";
        } else {
            $q="CALL GET_NOTIFIKASI ('$user') ";    
        }

        $query = $this->db->query($q)->result();
        $this->db->close();
        return $query;       
    }

    public function generate_id_kurs() {
        $query = $this->db->query('SELECT (MAX(ID_KURS) + 1) as ID_KURS FROM KURS')->row();
        $result = $query->ID_KURS;
        return $result;
    }

    public function save_as_new($data) {
        $this->db->trans_begin();

        $this->db->insert('KURS', $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function save_as_new_ktbi($data) {
        $this->db->trans_begin();

        $this->db->insert('KURS_KTBI', $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function save_log($data) {
        $this->db->trans_begin();

        $this->db->insert('KURS_LOG', $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function save_log_ktbi($data) {
        $this->db->trans_begin();

        $this->db->insert('KURS_KTBI_LOG', $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function set_aktif_komp_alpha() {
        $q = "select * from KOM_ALPHA 
        where  TGL_AWAL=DATE_FORMAT(now(),'%Y-%m-%d')
        order by TGL_AKHIR desc, IDTRANS desc limit 1";

        $rest = $this->db->query($q)->result_array();
        if ($rest){
            $id = $rest[0]['IDTRANS'];
            $NILAI_KONSTANTA_MFO = $rest[0]['NILAI_KONSTANTA_MFO'];
            $NILAI_KONSTANTA_HSD = $rest[0]['NILAI_KONSTANTA_HSD'];
            $VARIABEL_HITUNG = $rest[0]['VARIABEL_HITUNG'];     

            if ($id){
                $q = "update KOM_ALPHA set IS_AKTIF=0 where IS_AKTIF=1";
                $rest = $this->db->query($q);

                $q = "update KOM_ALPHA set IS_AKTIF=1 where IDTRANS='$id' ";
                $rest = $this->db->query($q);

                // update data setting
                $q = "update DATA_SETTING set VALUE_SETTING='$VARIABEL_HITUNG' where KEY_SETTING='VARIABEL_HITUNG' AND NAME_SETTING='Variabel hitung' ";
                $rest = $this->db->query($q);

                $q = "update DATA_SETTING set VALUE_SETTING='$NILAI_KONSTANTA_HSD' where KEY_SETTING='KONSTANTA_HITUNG' AND NAME_SETTING='Konstanta HSD' ";
                $rest = $this->db->query($q);

                $q = "update DATA_SETTING set VALUE_SETTING='$NILAI_KONSTANTA_MFO' where KEY_SETTING='KONSTANTA_HITUNG' AND NAME_SETTING='Konstanta MFO' ";
                $rest = $this->db->query($q);
            }
        }
        
        $this->db->close();
        return $rest;
    }

    public function set_max_pemakaian($blth='') {
        $q="CALL INSERT_MAX_PEMAKAIAN('$blth'); ";
        $query = $this->db->query($q)->result();
        $this->db->close();
        return $query;       
    }

    

    function check_tanggal($TGL_KURS){
        $query = $this->db->get_where('KURS', array('TGL_KURS' => $TGL_KURS));

        if ($query->num_rows() > 0)
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

    function check_tanggal_ktbi($TGL_KURS){
        $query = $this->db->get_where('KURS_KTBI', array('TGL_KURS' => $TGL_KURS));

        if ($query->num_rows() > 0)
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

    public function get_setting_smtp(){
        $this->db->from('SETTING_SMTP');
        $this->db->where('STATUS','1');
        $this->db->limit('1');
        $query = $this->db->get();
        return $query->row();
    }   

    public function get_email_kirim() {
        $q="CALL GET_EMAIL_KIRIM(); ";
        $query = $this->db->query($q)->result();
        $this->db->close();
        return $query;       
    }     

    public function get_email_kirim_detail($user) {
        $q="CALL GET_EMAIL_KIRIM_DETAIL('$user'); ";
        $query = $this->db->query($q)->result();
        $this->db->close();
        return $query;       
    }    

    public function get_email_kirim_ulang(){
        $q="select * FROM EMAIL_KIRIM_LOG_ERROR where DATE_FORMAT(CD_DATE,'%Y-%m-%d') = DATE_FORMAT(now(),'%Y-%m-%d') ";
        $query = $this->db->query($q)->result();
        $this->db->close();
        return $query;       
    }     

    public function get_email_approve(){
        $q="CALL GET_EMAIL_APPROVE(); ";
        $query = $this->db->query($q)->result();
        $this->db->close();
        return $query;       
    }     

    public function get_email_approve_detail($user){
        $q="CALL GET_EMAIL_APPROVE_DETAIL('$user'); ";
        $query = $this->db->query($q)->result();
        $this->db->close();
        return $query;       
    }  

    public function get_email_approve_ulang(){
        $q="select * FROM EMAIL_APPROVE_LOG_ERROR where DATE_FORMAT(CD_DATE,'%Y-%m-%d') = DATE_FORMAT(now(),'%Y-%m-%d') ";
        $query = $this->db->query($q)->result();
        $this->db->close();
        return $query;       
    }     

    public function get_email_gm(){
        $q="CALL GET_EMAIL_GM(); ";
        $query = $this->db->query($q)->result();
        $this->db->close();
        return $query;       
    }     

    public function get_email_gm_detail($user){
        $q="CALL GET_EMAIL_GM_DETAIL('$user'); ";
        $query = $this->db->query($q)->result();
        $this->db->close();
        return $query;       
    } 

    public function get_email_gm_update($user){
        $q="CALL GET_EMAIL_GM_UPDATE('$user'); ";
        $query = $this->db->query($q)->result();
        $this->db->close();
        return $query;       
    }     

    public function get_email_gm_ulang(){
        $q="select * FROM EMAIL_GM_LOG_ERROR where DATE_FORMAT(CD_DATE,'%Y-%m-%d') = DATE_FORMAT(now(),'%Y-%m-%d') ";
        $query = $this->db->query($q)->result();
        $this->db->close();
        return $query;       
    }    

    public function get_email_update_lv3(){
        $q="CALL GET_EMAIL_UPDATE_LV3(); ";
        $query = $this->db->query($q)->result();
        $this->db->close();
        return $query;       
    }     

    public function get_email_update_lv3_detail($user){
        $q="CALL GET_EMAIL_UPDATE_LV3_DETAIL('$user'); ";
        $query = $this->db->query($q)->result();
        $this->db->close();
        return $query;       
    } 

    public function get_email_update_lv3_ulang(){
        $q="select * FROM EMAIL_UPDATE_LV3_LOG_ERROR where DATE_FORMAT(CD_DATE,'%Y-%m-%d') = DATE_FORMAT(now(),'%Y-%m-%d') ";
        $query = $this->db->query($q)->result();
        $this->db->close();
        return $query;       
    }      

    public function get_email_update_lv2(){
        $q="CALL GET_EMAIL_UPDATE_LV2(); ";
        $query = $this->db->query($q)->result();
        $this->db->close();
        return $query;       
    }     

    public function get_email_update_lv2_detail($user){
        $q="CALL GET_EMAIL_UPDATE_LV2_DETAIL('$user'); ";
        $query = $this->db->query($q)->result();
        $this->db->close();
        return $query;       
    } 

    public function get_email_update_lv2_ulang(){
        $q="select * FROM EMAIL_UPDATE_LV2_LOG_ERROR where DATE_FORMAT(CD_DATE,'%Y-%m-%d') = DATE_FORMAT(now(),'%Y-%m-%d') ";
        $query = $this->db->query($q)->result();
        $this->db->close();
        return $query;       
    }  

    public function get_email_update_lv1(){
        $q="CALL GET_EMAIL_UPDATE_LV1(); ";
        $query = $this->db->query($q)->result();
        $this->db->close();
        return $query;       
    }     

    public function get_email_update_lv1_detail($user){
        $q="CALL GET_EMAIL_UPDATE_LV1_DETAIL('$user'); ";
        $query = $this->db->query($q)->result();
        $this->db->close();
        return $query;       
    } 

    public function get_email_update_lv1_detail_rekap($user){
        $q="CALL GET_EMAIL_UPDATE_LV1_DETAIL_REKAP('$user'); ";
        $query = $this->db->query($q)->result();
        $this->db->close();
        return $query;       
    }    

    public function get_email_update_lv1_ulang(){
        $q="select * FROM EMAIL_UPDATE_LV1_LOG_ERROR where DATE_FORMAT(CD_DATE,'%Y-%m-%d') = DATE_FORMAT(now(),'%Y-%m-%d') ";
        $query = $this->db->query($q)->result();
        $this->db->close();
        return $query;       
    }  
    
    public function get_email_kontrak_transportir_bln(){
        $q="CALL GET_EMAIL_KONTRAK_TRANSPORTIR_BLN(); ";
        $query = $this->db->query($q)->result();
        $this->db->close();
        return $query;       
    }     

    public function get_email_kontrak_transportir_hari(){
        $q="CALL GET_EMAIL_KONTRAK_TRANSPORTIR_HARI(); ";
        $query = $this->db->query($q)->result();
        $this->db->close();
        return $query;       
    }        

   public function get_email_kontrak_transportir_exp(){
        $q="CALL GET_EMAIL_KONTRAK_TRANSPORTIR_EXP(); ";
        $query = $this->db->query($q)->result();
        $this->db->close();
        return $query;       
    }      

    public function get_email_kontrak_transportir_exp_detail($user){
        $q="CALL GET_EMAIL_KONTRAK_TRANSPORTIR_EXP_DETAIL('$user'); ";
        $query = $this->db->query($q)->result();
        $this->db->close();
        return $query;       
    }     

   public function get_email_kontrak_transportir_notentry(){
        $q="CALL GET_EMAIL_KONTRAK_TRANSPORTIR_NOTENTRY(); ";
        $query = $this->db->query($q)->result();
        $this->db->close();
        return $query;       
    }     

    public function get_email_kontrak_transportir_ulang($JENIS=0){
        $q="select * FROM EMAIL_KONTRAK_TRANSPORTIR_LOG_ERROR where DATE_FORMAT(CD_DATE,'%Y-%m-%d') = DATE_FORMAT(now(),'%Y-%m-%d') AND JENIS='$JENIS' ";
        $query = $this->db->query($q)->result();
        $this->db->close();
        return $query;       
    } 

    public function get_email_verifikasi_coq(){
        $q="SELECT COUNT(*) FROM TRANS_COQ WHERE STATUS_REVIEW = 3";
        $query = $this->db->query($q)->result();
        $this->db->close();
        return $query;       
    } 


    // save log
    public function save_kirim_log($data) {
        $this->db->trans_begin();

        $this->db->insert('EMAIL_KIRIM_LOG', $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }   

    public function save_kirim_log_error($data) {
        $this->db->trans_begin();

        $this->db->insert('EMAIL_KIRIM_LOG_ERROR', $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }   

    public function save_approve_log($data) {
        $this->db->trans_begin();

        $this->db->insert('EMAIL_APPROVE_LOG', $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }   

    public function save_approve_log_error($data) {
        $this->db->trans_begin();

        $this->db->insert('EMAIL_APPROVE_LOG_ERROR', $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }         

    public function save_gm_log($data) {
        $this->db->trans_begin();

        $this->db->insert('EMAIL_GM_LOG', $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }   

    public function save_gm_log_error($data) {
        $this->db->trans_begin();

        $this->db->insert('EMAIL_GM_LOG_ERROR', $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }  

    public function save_update_lv3_log($data) {
        $this->db->trans_begin();

        $this->db->insert('EMAIL_UPDATE_LV3_LOG', $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }   

    public function save_update_lv3_log_error($data) {
        $this->db->trans_begin();

        $this->db->insert('EMAIL_UPDATE_LV3_LOG_ERROR', $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }     
    

    public function save_update_lv2_log($data) {
        $this->db->trans_begin();

        $this->db->insert('EMAIL_UPDATE_LV2_LOG', $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }   

    public function save_update_lv2_log_error($data) {
        $this->db->trans_begin();

        $this->db->insert('EMAIL_UPDATE_LV2_LOG_ERROR', $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    } 

    public function save_update_lv1_log($data) {
        $this->db->trans_begin();

        $this->db->insert('EMAIL_UPDATE_LV1_LOG', $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }    

    public function save_update_lv1_log_error($data) {
        $this->db->trans_begin();

        $this->db->insert('EMAIL_UPDATE_LV1_LOG_ERROR', $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    } 

    public function save_kontrak_transportir_log($data) {
        $this->db->trans_begin();

        $this->db->insert('EMAIL_KONTRAK_TRANSPORTIR_LOG', $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }     

    public function save_kontrak_transportir_log_error($data) {
        $this->db->trans_begin();

        $this->db->insert('EMAIL_KONTRAK_TRANSPORTIR_LOG_ERROR', $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }   

    // delete log
    public function delete_kirim_log_error($id){
        $this->db->where('ID_EMAIL', $id);
        $this->db->delete('EMAIL_KIRIM_LOG_ERROR');
    }

    public function delete_approve_log_error($id){
        $this->db->where('ID_EMAIL', $id);
        $this->db->delete('EMAIL_APPROVE_LOG_ERROR');
    }

    public function delete_gm_log_error($id){
        $this->db->where('ID_EMAIL', $id);
        $this->db->delete('EMAIL_GM_LOG_ERROR');
    }        

    public function delete_update_lv3_log_error($id){
        $this->db->where('ID_EMAIL', $id);
        $this->db->delete('EMAIL_UPDATE_LV3_LOG_ERROR');
    }      

    public function delete_update_lv2_log_error($id){
        $this->db->where('ID_EMAIL', $id);
        $this->db->delete('EMAIL_UPDATE_LV2_LOG_ERROR');
    }   

    public function delete_update_lv1_log_error($id){
        $this->db->where('ID_EMAIL', $id);
        $this->db->delete('EMAIL_UPDATE_LV1_LOG_ERROR');
    }         

    public function delete_kontrak_transportir_log_error($id){
        $this->db->where('ID_EMAIL', $id);
        $this->db->delete('EMAIL_KONTRAK_TRANSPORTIR_LOG_ERROR');
    }   

    public function kirim_email_persediaan($vlvlid, $vlvl){
        $query = "CALL kirim_email_persediaan('$vlvlid', '$vlvl');"; 
        $sql = $this->db->query($query)->result_array();
        return $sql;
    }

    public function insert_pemakaian() {
        $thbl = date('Ym', strtotime('-1 months'));
        $q = "CALL INSERT_PEMAKAIAN('$thbl')";
        $query = $this->db->query($q)->row();
        $this->db->close();
        return $query;       
    } 

    public function save_as_new_monjob($data) {
        $this->db->trans_begin();

        $this->db->insert($this->_table3, $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function get_level2(){
        $query = "SELECT u.USERNAME, u.NAMA_USER,
        u.EMAIL_USER, d.ROLES_NAMA, 
        r.ID_REGIONAL, r.NAMA_REGIONAL, 
        m1.COCODE, m1.LEVEL1, 
        m2.PLANT, m2.LEVEL2, 
        m3.STORE_SLOC, m3.LEVEL3, 
        m4.SLOC ,m4.LEVEL4 
        FROM MASTER_LEVEL4 m4
        INNER JOIN MASTER_LEVEL3 m3 ON m4.STORE_SLOC = m3.STORE_SLOC
        INNER JOIN MASTER_LEVEL2 m2 ON m3.PLANT = m2.PLANT 
        INNER JOIN MASTER_LEVEL1 m1 ON m2.COCODE = m1.COCODE 
        INNER JOIN MASTER_REGIONAL r ON m1.ID_REGIONAL = r.ID_REGIONAL
        INNER JOIN M_USER u ON u.LEVEL_USER= '2' AND u.KODE_LEVEL= m2.PLANT AND u.ISAKTIF_USER='1'
        INNER JOIN ROLES d ON d.ROLES_ID=u.ROLES_ID 
        -- WHERE u.USERNAME = 'yudhaasman' AND u.USERNAME = 'testbbm17'
        WHERE u.USERNAME = 'testbbm17'
        GROUP BY COCODE, USERNAME  
        ORDER BY LEVEL1, LEVEL2, LEVEL3, LEVEL4;";

        $sql = $this->db->query($query)->result();
        return $sql;
    }

    public function get_level(){
        $query = "SELECT * FROM (SELECT USERNAME,EMAIL_USER ,
            'Level 3' AS lvl,
            KODE_LEVEL AS code,
            m3.LEVEL3 AS NAMA
            FROM M_USER a
            INNER JOIN MASTER_LEVEL3 m3 ON a.KODE_LEVEL = m3.STORE_SLOC AND LEVEL_USER = 3
            WHERE ROLES_ID IN (08)
            UNION ALL
            SELECT USERNAME,EMAIL_USER ,
            'Level 2' AS lvl,
            KODE_LEVEL AS code,
            m2.LEVEL2 AS NAMA
            FROM M_USER a
            INNER JOIN MASTER_LEVEL3 m3 ON a.KODE_LEVEL = m3.PLANT AND LEVEL_USER = 2
            INNER JOIN MASTER_LEVEL2 m2 ON m3.PLANT = m2.PLANT
            WHERE ROLES_ID IN (30)
            GROUP BY USERNAME ,EMAIL_USER) TBL WHERE TBL.USERNAME = 'yudhakitlog'";

        $sql = $this->db->query($query)->result();
        return $sql;
    }

}

/* End of file tm_menu.php */
/* Location: ./application/modules/user_management/models/tm_menu.php */