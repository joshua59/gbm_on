<?php
/**
 * @module TRANSAKSI
 * @author  CF
 * @created at 11 FEBRUARI 2019
 * @modified at 11 FEBRUARI 2019
 */
class rollback_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    
    // private $_table1 = "VLOAD_LIST_PENERIMAAN_V2"; //nama table setelah 
    private $_table2 = "MUTASI_PENERIMAAN"; //nama table setelah 
    
    private function _key($key) { //unit ID
        $level_user = $this->session->userdata('level_user');
        $kode_level = $this->session->userdata('kode_level');
        if (!is_array($key)) {
            if ($level_user == '2')
            $key = array('TANGGAL' => $key, 'PLANT' => $kode_level);
            else if($level_user == '3')
            $key = array('TANGGAL' => $key, 'STORE_SLOC' => $kode_level);
            else
            $key = array('TANGGAL' => $key);
        }
        return $key;
    }
    
    private function _key_edit($key){
        if (!is_array($key)) {
            $key = array('ID_PENERIMAAN' => $key);
        }
        return $key;
    }
    
    public function data($key = ''){
        $this->db->select('a.*, sum(a.COUNT_VOLUME) as JML, sum(a.SUM_volume) as JML_VOLUME');
        
        // $this->db->from($this->_table1.' a' );
        if ($this->laccess->otoritas('add')){
            $this->db->from('VLOAD_LIST_PENERIMAAN_LV3 a' );
            } else {
            $this->db->from('VLOAD_LIST_PENERIMAAN_LV2 a' );
            // 001 Administrator
            // 20  DIVGBM_PUSAT_F1
            // 34  DIVGBM_PUSAT_F2
            // 26  HELPDESK
            $roles = $this->session->userdata('roles_id');

            if (($roles!='001') && ($roles!='20') && ($roles!='34') && ($roles!='26')){
                $this->db->where('a.STATUS_APPROVE !=','Belum Dikirim');
                $this->db->where('a.STATUS_APPROVE !=','Closing');
            }             
        }
        
        if ($_POST['ID_REGIONAL'] !='') {
            $this->db->where('ID_REGIONAL',$_POST['ID_REGIONAL']);
        }
        if ($_POST['COCODE'] !='') {
            $this->db->where("COCODE",$_POST['COCODE']);
        }
        if ($_POST['PLANT'] !='') {
            $this->db->where("PLANT",$_POST['PLANT']);
        }
        if ($_POST['STORE_SLOC'] !='') {
            $this->db->where("STORE_SLOC",$_POST['STORE_SLOC']);
        }
        if ($_POST['SLOC'] !='') {
            $this->db->where("SLOC",$_POST['SLOC']);
        }
        if ($_POST['BULAN'] !='') {
            $this->db->where("BL",$_POST['BULAN']);
        }
        if ($_POST['TAHUN'] !='') {
            $this->db->where("TH",$_POST['TAHUN']);
        }
        
        if (!empty($key) || is_array($key)){
            $this->db->where_condition($this->_key($key));
        }
        
        $this->db->group_by('ID_REGIONAL');
        $this->db->group_by('BLTH');
        if ($_POST['COCODE'] !='') {
            $this->db->group_by('COCODE');
        }
        if ($_POST['PLANT'] !='') {
            $this->db->group_by('PLANT');
        }
        if ($_POST['STORE_SLOC'] !='') {
            $this->db->group_by('STORE_SLOC');
        }
        
        if ($_POST['BULAN'] !='') {
            $this->db->group_by('BL'); 
        }
        if ($_POST['TAHUN'] !='') {
            $this->db->group_by('TH'); 
        }
        // if ($_POST['SLOC'] !='') {
        $this->db->group_by('SLOC');
        $this->db->group_by('a.STATUS_APPROVE');
        // }
        
        if ($_POST['ORDER_BY']=='BLTH'){
            $this->db->order_by('TH '.$_POST['ORDER_ASC']);
            $this->db->order_by('BL '.$_POST['ORDER_ASC']);
        } else {
            $this->db->order_by($_POST['ORDER_BY'].' '.$_POST['ORDER_ASC']);
        }

        $this->db->order_by('LEVEL4');
        
        $rest = $this->db;
        $this->db->close();
        return $rest;
    }

    public function data_input($key = ''){
        $this->db->select('a.*, mp.NAMA_PEMASOK, mt.NAMA_TRANSPORTIR, jb.NAMA_JNS_BHN_BKR, m4.LEVEL4 ');
        $this->db->from('MUTASI_PENERIMAAN a' );
        $this->db->join('MASTER_PEMASOK mp', 'mp.ID_PEMASOK = a.ID_PEMASOK','left');
        $this->db->join('MASTER_TRANSPORTIR mt', 'mt.ID_TRANSPORTIR = a.ID_TRANSPORTIR','left');
        $this->db->join('M_JNS_BHN_BKR jb', 'jb.ID_JNS_BHN_BKR = a.ID_JNS_BHN_BKR','left');
        $this->db->join('MASTER_LEVEL4 m4', 'm4.SLOC = a.SLOC','left');

        // $this->db->where('a.NO_MUTASI_TERIMA','004.OME');
        $this->db->where('a.IDGROUP',$_POST['IDGROUP_F']);
        $this->db->order_by('a.ID_PENERIMAAN');
        
        $rest = $this->db;
        $this->db->close();
        return $rest;
    }

    public function data_rekap($key = ''){
    
        $this->db->from('VLOAD_LIST_DETAIL_PENERIMAAN_V2' );
        
        if ($_POST['ID_REGIONAL'] !='') {
            $this->db->where('ID_REGIONAL',$_POST['ID_REGIONAL']);
        }
        if ($_POST['COCODE'] !='') {
            $this->db->where("COCODE",$_POST['COCODE']);
        }
        if ($_POST['PLANT'] !='') {
            $this->db->where("PLANT",$_POST['PLANT']);
        }
        if ($_POST['STORE_SLOC'] !='') {
            $this->db->where("STORE_SLOC",$_POST['STORE_SLOC']);
        }
        if ($_POST['SLOC'] !='') {
            $this->db->where("SLOC",$_POST['SLOC']);
        }
        if ($_POST['BULAN'] !='') {
            $this->db->where("BL",$_POST['BULAN']);
        }
        if ($_POST['TAHUN'] !='') {
            $this->db->where("TH",$_POST['TAHUN']);
        }

        if (($this->session->userdata('level_user') >= 2) && ($this->laccess->otoritas('add'))){
            $stat_kirim = $_POST['NF_STATUS'];
            if (!$stat_kirim){
                $stat_kirim = '0';
            }
            $this->db->where("KODE_STATUS",$stat_kirim); 
            // if ($_POST['NF_STATUS']){
            //     $this->db->where("KODE_STATUS","4"); 
            // } else {
            //     $this->db->where("KODE_STATUS","0"); 
            // }
            // $this->db->where("KODE_STATUS","0"); 
            $this->db->where("CREATED_BY",$this->session->userdata('user_name')); 
        } else if (($this->session->userdata('level_user') == 2) && ($this->laccess->otoritas('approve'))){
            $stat_kirim = $_POST['NF_STATUS'];
            if (!$stat_kirim){
                $stat_kirim = '0';
            }
            $this->db->where("KODE_STATUS",$stat_kirim);            
            // $this->db->where("KODE_STATUS","1");
            // if ($_POST['NF_STATUS']){
                // $this->db->where("KODE_STATUS","5"); 
            // } else {
                // $this->db->where("KODE_STATUS","1"); 
            // }    
        }

        if (!empty($key) || is_array($key)){
            $this->db->where_condition($this->_key($key));
        }
        
        $this->db->order_by($_POST['ORDER_BY_REKAP'].' '.$_POST['ORDER_ASC_REKAP']);
        
        $rest = $this->db;
        $this->db->close();
        return $rest;
    }
    
    public function data_edit($key){
        $q="SELECT a.*, m3.STORE_SLOC, m2.PLANT, m1.COCODE, r.ID_REGIONAL, 
        a.SLOC_KIRIM, m3k.STORE_SLOC AS STORE_SLOC_KIRIM, m2k.PLANT AS PLANT_KIRIM, m1k.COCODE AS COCODE_KIRIM, rk.ID_REGIONAL AS ID_REGIONAL_KIRIM,
        DATE_FORMAT(a.TGL_PENERIMAAN,'%d-%m-%Y') TGL_PENERIMAAN_EDIT, DATE_FORMAT(a.TGL_PENGAKUAN,'%d-%m-%Y') TGL_PENGAKUAN_EDIT 
        FROM MUTASI_PENERIMAAN a 
        LEFT JOIN MASTER_LEVEL4 m4 ON m4.SLOC = a.SLOC
        LEFT JOIN MASTER_LEVEL3 m3 ON m3.STORE_SLOC = m4.STORE_SLOC
        LEFT JOIN MASTER_LEVEL2 m2 ON m2.PLANT = m3.PLANT
        LEFT JOIN MASTER_LEVEL1 m1 ON m1.COCODE = m2.COCODE
        LEFT JOIN MASTER_REGIONAL r ON r.ID_REGIONAL = m1.ID_REGIONAL         
        LEFT JOIN MASTER_LEVEL4 m4k ON m4k.SLOC = a.SLOC_KIRIM
        LEFT JOIN MASTER_LEVEL3 m3k ON m3k.STORE_SLOC = m4k.STORE_SLOC
        LEFT JOIN MASTER_LEVEL2 m2k ON m2k.PLANT = m3k.PLANT
        LEFT JOIN MASTER_LEVEL1 m1k ON m1k.COCODE = m2k.COCODE
        LEFT JOIN MASTER_REGIONAL rk ON rk.ID_REGIONAL = m1k.ID_REGIONAL         
        WHERE a.ID_PENERIMAAN='$key' ";
        
        $query = $this->db->query($q);

        $this->db->close();
        return $query->result();
    }
    
    public function data_detail($key = ''){
        $this->db->select('a.*, b.STORE_SLOC, c.PLANT, d.COCODE, e.ID_REGIONAL');
        $this->db->from($this->_table2.' a');
        $this->db->join('MASTER_LEVEL4 f', 'f.SLOC = a.SLOC','left');
        $this->db->join('MASTER_LEVEL3 b', 'b.STORE_SLOC = f.STORE_SLOC','left');
        $this->db->join('MASTER_LEVEL2 c', 'c.PLANT = b.PLANT','left');
        $this->db->join('MASTER_LEVEL1 d', 'd.COCODE = c.COCODE','left');
        $this->db->join('MASTER_REGIONAL e', 'e.ID_REGIONAL = d.ID_REGIONAL','left');        
        
        if (!empty($key) || is_array($key))
        $this->db->where_condition($this->_key_edit($key));
        
        $rest = $this->db;
        $this->db->close();
        return $rest;
    }

    public function get_tug($id){
        $this->db->from('MUTASI_PEMAKAIAN');
        $this->db->where('ID_PEMAKAIAN',$id); 
        $query = $this->db->get();
        return $query->row();
    }    
    
    public function data_table($module = '', $limit = 20, $offset = 1) {
        $filter = array();
        $kata_kunci = $this->input->post('kata_kunci'); 
        
        if (!empty($kata_kunci))
        $filter["(a.LEVEL4 LIKE '%{$kata_kunci}%' OR a.BLTH LIKE '%{$kata_kunci}%' )"] = NULL;
        
        // $total = $this->data($filter)->count_all_results(); 
        $total = $this->data($filter)->get();
        $total = $total->num_rows();
    
        $this->db->limit($limit, ($offset * $limit) - $limit);
        $record = $this->data($filter)->get();
        $no=(($offset-1) * $limit) +1;
        $rows = array();
        $num = 1;
        foreach ($record->result() as $row) {
            // $count = $row->COUNT_VOLUME;
            // if ($count!=0) {
            $id = $row->TANGGAL.'|'.$row->SLOC.'|'.$num;
            $aksi = anchor(null, '<i class="icon-zoom-in" title="Lihat Detail Data"></i>', array('class' => 'btn transparant button-detail', 'id' => 'button-view-' . $id, 'onClick' => 'show_detail(\''.$id.'\')'));
            $rows[$num] = array(
            'NO' => $no,
            'BLTH' => $this->get_blth($row->BL,$row->TH),
            'LEVEL4' => $row->LEVEL4,
            //                    'STATUS' => $row->STATUS_APPROVE,
            'TOTAL_VOLUME' => number_format($row->SUM_VOLUME,2,',','.'),
            'COUNT' => number_format($row->COUNT_VOLUME,0,',','.'),
            'AKSI' => $aksi
            );

            $num++;
            $no++;
            // }
        }
        return array('total' => $total, 'rows' => $rows);
    }

    public function data_table_input($module = '', $limit = 20, $offset = 1) {
        $filter = array();
        $kata_kunci = $this->input->post('kata_kunci'); 
        
        // if (!empty($kata_kunci))
        // $filter["(a.LEVEL4 LIKE '%{$kata_kunci}%' OR a.BLTH LIKE '%{$kata_kunci}%' )"] = NULL;
        
        // $total = $this->data($filter)->count_all_results(); 
        $total = $this->data_input($filter)->get();
        $total = $total->num_rows();
    
        $this->db->limit($limit, ($offset * $limit) - $limit);
        $record = $this->data_input($filter)->get();
        $no=(($offset-1) * $limit) +1;
        $rows = array();
        $num = 1;

        foreach ($record->result() as $row) {
            $id = $row->ID_PENERIMAAN;

            $aksi = anchor(null, '<i class="icon-edit" title="Edit Data"></i>', array('class' => 'btn transparant', 'id' => 'button-edit-input-' . $id, 'onclick' => 'edit_data(this.id)', 'data-source' => base_url($module . '/get_data_edit/' . $id), 'data-id' => $no+60));            

            $rows[$no+60] = array(
                'NO_MUTASI_TERIMA' => $row->NO_MUTASI_TERIMA,
                'TGL_PENGAKUAN' => $row->TGL_PENGAKUAN,
                'NAMA_PEMASOK' => $row->NAMA_PEMASOK,
                'NAMA_TRANSPORTIR' => $row->NAMA_TRANSPORTIR,
                'LEVEL4' => $row->LEVEL4,
                'NAMA_JNS_BHN_BKR' => $row->NAMA_JNS_BHN_BKR,
                'VOL_TERIMA' => number_format($row->VOL_TERIMA,2,',','.'),
                'VOL_TERIMA_REAL' => number_format($row->VOL_TERIMA_REAL,2,',','.'),
                'CD_BY_MUTASI_TERIMA' => $row->CD_BY_MUTASI_TERIMA,
                'CD_DATE_MUTASI_TERIMA' => $row->CD_DATE_MUTASI_TERIMA,    
                'AKSI' => $aksi  
            );
            $no++;
        }


        return array('total' => $total, 'rows' => $rows);
    }

    public function data_table_rekap($module = '', $limit = 20, $offset = 1) {
        $filter = array();
        $kata_kunci = $this->laccess->ai($this->input->post('kata_kunci_rekap')); 
        
        if (!empty($kata_kunci))
        $filter["(LEVEL4 LIKE '%{$kata_kunci}%' OR NO_PENERIMAAN LIKE '%{$kata_kunci}%' OR NAMA_PEMASOK LIKE '%{$kata_kunci}%' OR NAMA_JNS_BHN_BKR LIKE '%{$kata_kunci}%')"] = NULL;
        
        $total = $this->data_rekap($filter)->get();
        $total = $total->num_rows();
    
        $this->db->limit($limit, ($offset * $limit) - $limit);
        $record = $this->data_rekap($filter)->get();
        $no=(($offset-1) * $limit) +1;
        $rows = array();
        // $num = 1;
        $pilih=0;
        foreach ($record->result() as $row) {
            $id = $row->ID_PENERIMAAN;
            $aksi = anchor(null, '<i class="icon-zoom-in" title="Lihat Detail Data"></i>', array('class' => 'btn transparant button-detail', 'id' => 'button-view-' . $id, 'onClick' => 'show_detail(\''.$id.'\')'));

            $ceklis = '<input type="checkbox" name="pilihan['.$pilih.']" id="pilihan" value="'.$id.'">
            <input type="hidden" id="idPenerimaan" name="idPenerimaan['.$pilih.']" value="'.$id.'">
            <input type="hidden" id="idSLOC" name="idSLOC['.$pilih.']" value="'.$row->SLOC.'">
            <input type="hidden" id="status" name="status['.$pilih.']" value="'.$row->STATUS.'">'; 

            if (($this->session->userdata('level_user') >= 2) && ($this->laccess->otoritas('add'))){
                if (($row->KODE_STATUS==0) || ($row->KODE_STATUS==4)){ //kirim dan kirim closing
                    $edit = anchor(null, '<i class="icon-edit" title="Edit Data"></i>', array('class' => 'btn transparant', 'id' => 'button-edit-rkp-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/edit/' . $id)));
                } else {
                    $edit = anchor(null, '<i class="icon-file-alt" title="Lihat Data"></i>', array('class' => 'btn transparant', 'id' => 'button-edit-rkp-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/edit_view/' . $id)));
                    $ceklis = '';
                }
            } else {
                $edit = anchor(null, '<i class="icon-file-alt" title="Lihat Data"></i>', array('class' => 'btn transparant', 'id' => 'button-edit-rkp-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/edit_view/' . $id)));
            }

            //aksi tolak
            if (($this->session->userdata('level_user') == 2) && ($this->laccess->otoritas('approve'))){
                if ($row->KODE_STATUS==1){
                    $edit.= anchor(null, '<i class="icon-remove" title="Tolak Data"></i>', array('class' => 'btn transparant', 'id' => 'button-tolak-rkp-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/tolak_view/' . $id)));
                }
            }

            $aksi = $edit;

            if ($row->IS_TOLAK){
                $set_status = $row->STATUS.'<span class="required">*</span>';
            } else {
                $set_status = $row->STATUS;
            }            

            $rows[$no] = array(
                //'NO' => $no,
                'BLTH' => $this->get_blth($row->BL,$row->TH),
                'PEMBANGKIT' => $row->LEVEL4,
                'NO PENERIMAAN' => $row->NO_PENERIMAAN,
                'TGL PENGAKUAN' => $row->TGL_PENGAKUAN,
                'NAMA PEMASOK' => $row->NAMA_PEMASOK,
                'NAMA TRANSPORTIR' => $row->NAMA_TRANSPORTIR,
                'NAMA JNS BHN BKR' => $row->NAMA_JNS_BHN_BKR,
                'VOL TERIMA (L)' => number_format($row->VOL_TERIMA,2,',','.'),
                'VOL TERIMA REAL (L)' => number_format($row->VOL_TERIMA_REAL,2,',','.'),
                'CREATED BY' => $row->CREATED_BY,
                'STATUS' => $set_status,
                'AKSI' => $aksi,
                'CHECK' => $ceklis
            );

            // $num++;
            $no++;
            $pilih++;
        }
        
        return array('total' => $total, 'rows' => $rows);
    }

    public function update_notif_tolak() {
        $this->db->trans_begin();

        $this->db->set('IS_TOLAK', '0');
        $this->db->where('CD_BY_MUTASI_TERIMA', $this->session->userdata('user_name'));
        $this->db->where('IS_TOLAK', '1');
        $this->db->update('MUTASI_PENERIMAAN');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }     
    
    public function getTableViewDetail(){
        
        $this->db->from('VLOAD_LIST_DETAIL_PENERIMAAN_V2');
        
        if ($_POST['TGL_PENGAKUAN'] !='') {
            $this->db->where("DATE_FORMAT(TGL_PENGAKUAN,'%m%Y')",$_POST['TGL_PENGAKUAN']);
        }
        if ($_POST['ID_REGIONAL'] !='') {
            $this->db->where('ID_REGIONAL',$_POST['ID_REGIONAL']);
        }
        if ($_POST['COCODE'] !='') {
            $this->db->where("COCODE",$_POST['COCODE']);
        }
        if ($_POST['PLANT'] !='') {
            $this->db->where("PLANT",$_POST['PLANT']);
        }
        if ($_POST['STORE_SLOC'] !='') {
            $this->db->where("STORE_SLOC",$_POST['STORE_SLOC']);
        }
        if ($_POST['SLOC']!='') {
            $this->db->where("SLOC",$_POST['SLOC']);
        }
        if ($_POST['BULAN'] !='') {
            $this->db->where("BL",$_POST['BULAN']);   
        }
        if ($_POST['TAHUN'] !='') {
            $this->db->where("TH",$_POST['TAHUN']);   
        }
        if ($_POST['STATUS'] !='') {
            $this->db->where("KODE_STATUS",$_POST['STATUS']);   
        }
        
        if (!$this->laccess->otoritas('add')){
            $roles = $this->session->userdata('roles_id');
            if (($roles!='001') && ($roles!='20') && ($roles!='34') && ($roles!='26')){
                $this->db->where("STATUS !=","Belum Dikirim"); 
                $this->db->where("STATUS !=","Closing");   
            }            
        }
        
        if ($_POST['KATA_KUNCI_DETAIL'] !=''){
            
            $filter="NO_PENERIMAAN LIKE '%".$_POST['KATA_KUNCI_DETAIL']."%' OR NAMA_PEMASOK LIKE '%".$_POST['KATA_KUNCI_DETAIL']."%' OR NAMA_TRANSPORTIR LIKE '%".$_POST['KATA_KUNCI_DETAIL']."%' OR NAMA_JNS_BHN_BKR LIKE '%".$_POST['KATA_KUNCI_DETAIL']."%' ";
            
            $this->db->where("(".$filter.")", NULL, FALSE);
        }
        
        $this->db->order_by($_POST['ORDER_BY_D'].' '.$_POST['ORDER_ASC_D']);
        
        $data = $this->db->get();

        $this->db->close();
        return $data->result();
    }
    
    public function saveDetailPenerimaan($idPenerimaan, $statusPenerimaan,$level_user,$kode_level,$user,$jumlah,$ket=''){
        // print_r("call SP_TEMP_PENERIMAAN('".$idPenerimaan."','".$statusPenerimaan."','".$level_user."','".$kode_level."','".$user."',".$jumlah.")"); die;
        // print_debug("call SP_TEMP_PENERIMAAN('".$idPenerimaan."','".$statusPenerimaan."','".$level_user."','".$kode_level."','".$user."',".$jumlah.")");

        // $q = "call PROSES_PENERIMAAN('".$idPenerimaan."','".$statusPenerimaan."','".$level_user."','".$kode_level."','".$user."',".$jumlah.",'".$ket."')";

        // print_r($q); die;

        $query = $this->db->query("call PROSES_PENERIMAAN('".$idPenerimaan."','".$statusPenerimaan."','".$level_user."','".$kode_level."','".$user."',".$jumlah.",'".$ket."')");
        // return $query->result();
        
        $res = $query->result();
        
        $query->next_result(); // Dump the extra resultset.
        $query->free_result(); // Does what it says.

        $this->db->close();
        return $res;
    }
    
    public function saveDetailClossing($sloc,$idPenerimaan,$level_user,$statusPenerimaan,$kode_level,$user_name,$jumlah){
        // print_debug("call SP_TEMP_CLOSSING('".$sloc."','".$idPenerimaan."','".$level_user."','".$statusPenerimaan."','".$kode_level."','".$user_name."',".$jumlah.")");
        // $q = "call PROSES_CLOSSING('".$sloc."','".$idPenerimaan."','".$level_user."','".$statusPenerimaan."','".$kode_level."','".$user_name."',".$jumlah.")";

        // print_r($q); die;

        $query = $this->db->query("call PROSES_CLOSSING('".$sloc."','".$idPenerimaan."','".$level_user."','".$statusPenerimaan."','".$kode_level."','".$user_name."',".$jumlah.")");
        // return $query->result();        

        $res = $query->result();
        
        $query->next_result(); // Dump the extra resultset.
        $query->free_result(); // Does what it says.

        $this->db->close();
        return $res;
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

    public function options_pemasok_non_pln($key = '', $default = '--Pilih Pemasok--') {
        $option = array();
        $this->db->from('MASTER_PEMASOK');
        $this->db->order_by('REF_NAMA_TRANS, NAMA_PEMASOK');
        $this->db->where('ID_PEMASOK <> ','00000000000000000010');
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
    
    public function options_jenis_penerimaan($default = '--Pilih Jenis Penerimaan--') {
        $this->db->from('DATA_SETTING');
        $this->db->where('KEY_SETTING','JENIS_PENERIMAAN');
        $this->db->order_by("NAME_SETTING ASC");
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

    public function options_jenis_penerimaan_byid($default = '--Pilih Jenis Penerimaan--', $key = 'all', $jenis=0) {
        $this->db->from('DATA_SETTING');
        $this->db->where('KEY_SETTING','JENIS_PENERIMAAN');
        $this->db->order_by("NAME_SETTING ASC");

        if ($key == '00000000000000000010'){ //pln
            $id = '1'; //  TUG3/4
        } else if ($key=='00000000000000000013'){ //pengembalian  
            $id = '3'; // TUG 10
        } else if ($key=='0'){ //pengembalian  
            $id = '0'; // kosong
        } else {
            $id = '2'; // DO
        }

        if ($key != 'all'){
            $this->db->where('VALUE_SETTING',$id);
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
                $option[$row->VALUE_SETTING] = $row->NAME_SETTING;
            }
            $rest = $option;    
        }
        $this->db->close();
        return $rest;
    }
    
    public function options_level($level_user,$kode_level) {
        $default = '--Pilih Level--';
        $query = $this->db->query("call LOAD_LEVEL4('".$level_user."','".$kode_level."')");
        $option = array();
        $list = $query;
        
        if (!empty($default)) {
            $option[''] = $default;
        }
        
        foreach ($list->result() as $row) {
            $option[$row->SLOC] = $row->LEVEL4;
        }
        $this->db->close();
        return $option;     
    }

    public function get_blth($bulan, $tahun){
        Switch ($bulan){
            case 1 : $bulan="Januari";
            Break;
            case 2 : $bulan="Februari";
            Break;
            case 3 : $bulan="Maret";
            Break;
            case 4 : $bulan="April";
            Break;
            case 5 : $bulan="Mei";
            Break;
            case 6 : $bulan="Juni";
            Break;
            case 7 : $bulan="Juli";
            Break;
            case 8 : $bulan="Agustus";
            Break;
            case 9 : $bulan="September";
            Break;
            case 10 : $bulan="Oktober";
            Break;
            case 11 : $bulan="November";
            Break;
            case 12 : $bulan="Desember";
            Break;
        }
        
        $tahun = substr($tahun,2);
        $bulan .= '-'.$tahun;
        
        return $bulan;
    }
    
    public function save($data){
        $sql = "CALL SAVE_PENERIMAAN ('"
        .$data['ID_TRANSPORTIR']."','"
        .$data['ID_PEMASOK']."','"
        .$data['SLOC']."','"
        .$data['TGL_PENGAKUAN']."','"
        .$data['TGL_MUTASI']."','"
        .$data['TGL_PENERIMAAN']."','"
        .$data['VALUE_SETTING']."',"
        .$data['VOL_PENERIMAAN'].","
        .$data['VOL_PENERIMAAN_REAL'].",'"
        .$data['KET_MUTASI_TERIMA']."','0','"
        .$data['CREATE_BY']."','"
        .$data['NO_PENERIMAAN']."','"
        .$data['ID_JNS_BHN_BKR']."',
        '".$data['IS_MIX']."',
        '".$data['ID_KOMPONEN']."',
        '".$data['PATH_FILE']."',
        '".$data['IDGROUP']."',
        '".$data['JNS_BIO']."',
        '".$data['SLOC_KIRIM']."')";
        
        $query = $this->db->query($sql);
        $this->db->close();
        return $query->result();
    }
    
    public function save_edit($data){
        $sql = "CALL EDIT_PENERIMAAN (
        '".$data['ID_PENERIMAAN']."',
        '".$data['STATUS']."',
        '".$data['LEVEL_USER']."',
        '".$data['KODE_LEVEL']."',
        '".$data['CREATE_BY']."',
        ".$data['VOL_PENERIMAAN'].",
        ".$data['VOL_PENERIMAAN_REAL'].",
        '".$data['ID_TRANSPORTIR']."',
        '".$data['ID_PEMASOK']."',
        '".$data['SLOC']."',
        '".$data['TGL_PENGAKUAN']."',
        '".$data['TGL_PENERIMAAN']."',
        '".$data['VALUE_SETTING']."',
        '".$data['KET_MUTASI_TERIMA']."',
        '".$data['ID_JNS_BHN_BKR']."',
        '".$data['NO_PENERIMAAN']."',
        '".$data['IS_MIX']."',
        '".$data['ID_KOMPONEN']."',
        '".$data['PATH_FILE']."',
        '".$data['IDGROUP']."',
        '".$data['JNS_BIO']."',
        '".$data['SLOC_KIRIM']."')";
        // echo $sql; die;
        $query = $this->db->query($sql);
        $this->db->close();
        return $query->result();
    }
         
    public function options_reg($default = '--Pilih Regional--', $key = 'all') {
        $option = array();
        
        $this->db->from('MASTER_REGIONAL');
        $this->db->where('IS_AKTIF_REGIONAL','1');
        if ($key != 'all'){
            $this->db->where('ID_REGIONAL',$key);
        }   
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
    
    public function options_bulan() {
        $option = array();
        $option[''] = '--Pilih Bulan--';
        $option['01'] = 'Januari';
        $option['02'] = 'Februari';
        $option['03'] = 'Maret';
        $option['04'] = 'April';
        $option['05'] = 'Mei';
        $option['06'] = 'Juni';
        $option['07'] = 'Juli';
        $option['08'] = 'Agustus';
        $option['09'] = 'September';
        $option['10'] = 'Oktober';
        $option['11'] = 'November';
        $option['12'] = 'Desember';
        return $option;
    }
    
    public function options_tahun() {
        $year = date("Y"); 
        
        $option[$year - 1] = $year - 1;
        $option[$year] = $year;
        $option[$year + 1] = $year + 1;
        
        return $option;
    }
    
    public function options_order() {
        $option = array();
        // $option[''] = '--Pilih--';
        $option['BLTH'] = 'BLTH';
        $option['LEVEL4'] = 'PEMBANGKIT';
        // $option['JML'] = 'JML';
        // $option['JML_VOLUME'] = 'JML_VOLUME';
        return $option;
    }
    
    public function options_order_d() {
        $option = array();
        // $option[''] = '--Pilih--';
        $option['TGL_PENGAKUAN'] = 'TGL PENGAKUAN';
        // $option['LEVEL4'] = 'PEMBANGKIT';
        $option['NO_PENERIMAAN'] = 'NO PENERIMAAN';
        $option['NAMA_PEMASOK'] = 'NAMA PEMASOK';
        $option['NAMA_TRANSPORTIR'] = 'NAMA TRANSPORTIR';
        $option['NAMA_JNS_BHN_BKR'] = 'JNS BHN BKR';
        return $option;
    }
    
    public function options_asc() {
        $option = array();
        // $option[''] = '--Pilih--';
        $option['ASC'] = 'ASC';
        $option['DESC'] = 'DESC';
        return $option;
    }
    
    public function get_level($lv='', $key=''){ 
        switch ($lv) {
            case "R":
            $q = "SELECT  E.ID_REGIONAL, E.NAMA_REGIONAL 
            FROM MASTER_REGIONAL E
            WHERE ID_REGIONAL='$key' ";
            break;
            case "0":
            $q = "SELECT  E.ID_REGIONAL, E.NAMA_REGIONAL 
            FROM MASTER_REGIONAL E
            WHERE ID_REGIONAL='$key' ";
            break;
            case "1":
            $q = "SELECT D.COCODE, D.LEVEL1, E.ID_REGIONAL, E.NAMA_REGIONAL 
            FROM MASTER_LEVEL1 D 
            LEFT JOIN MASTER_REGIONAL E ON E.ID_REGIONAL=D.ID_REGIONAL
            WHERE COCODE='$key' ";
            break;
            case "2":
            $q = "SELECT C.PLANT, C.LEVEL2,  D.COCODE,  D.LEVEL1, E.ID_REGIONAL, E.NAMA_REGIONAL
            FROM MASTER_LEVEL2 C 
            LEFT JOIN MASTER_LEVEL1 D ON D.COCODE=C.COCODE 
            LEFT JOIN MASTER_REGIONAL E ON E.ID_REGIONAL=D.ID_REGIONAL
            WHERE PLANT='$key' ";
            break;
            case "3":
            $q = "SELECT B.STORE_SLOC, B.LEVEL3, C.PLANT, C.LEVEL2,  D.COCODE,  D.LEVEL1, E.ID_REGIONAL, E.NAMA_REGIONAL
            FROM MASTER_LEVEL3 B
            LEFT JOIN MASTER_LEVEL2 C ON C.PLANT=B.PLANT 
            LEFT JOIN MASTER_LEVEL1 D ON D.COCODE=C.COCODE 
            LEFT JOIN MASTER_REGIONAL E ON E.ID_REGIONAL=D.ID_REGIONAL
            WHERE STORE_SLOC='$key' ";
            break;
            case "4":
            $q = "SELECT A.SLOC, A.LEVEL4, B.STORE_SLOC, B.LEVEL3, C.PLANT, C.LEVEL2,  D.COCODE,  D.LEVEL1, E.ID_REGIONAL, E.NAMA_REGIONAL
            FROM MASTER_LEVEL4 A
            LEFT JOIN MASTER_LEVEL3 B ON B.STORE_SLOC=A.STORE_SLOC 
            LEFT JOIN MASTER_LEVEL2 C ON C.PLANT=B.PLANT 
            LEFT JOIN MASTER_LEVEL1 D ON D.COCODE=C.COCODE 
            LEFT JOIN MASTER_REGIONAL E ON E.ID_REGIONAL=D.ID_REGIONAL
            WHERE SLOC='$key' ";
            break;
            case "5":
            $q = "SELECT a.LEVEL3, a.STORE_SLOC
            FROM MASTER_LEVEL3 a
            INNER JOIN MASTER_LEVEL2 b ON a.PLANT = b.PLANT
            INNER JOIN MASTER_LEVEL4 c ON a.STORE_SLOC = c.STORE_SLOC AND a.PLANT = c.PLANT
            WHERE c.STATUS_LVL2=1 AND a.PLANT = '$key' ";
            break;
        } 
        
        $query = $this->db->query($q)->result();
        $this->db->close();
        return $query;
    }
    
    public function options_status() {
        $this->db->from('DATA_SETTING');
        $this->db->where('KEY_SETTING','STATUS_APPROVE');
        $this->db->order_by("VALUE_SETTING ASC");
        
        $list = $this->db->get(); 
        $option = array();
        $option[''] = '-- Semua --';
        
        foreach ($list->result() as $row) {
            $option[$row->VALUE_SETTING] = $row->NAME_SETTING;
        }
        $this->db->close();
        return $option;    
    }
    
    public function get_sum_detail() {
        $SLOC = $_POST['SLOC'];
        $TGL_PENGAKUAN = $_POST['TGL_PENGAKUAN'];
        
        $q="SELECT 
        SLOC, date_format(TGL_PENGAKUAN,'%m%Y') AS TGL_PENGAKUAN_FORMAT, 
        sum( if( STATUS_MUTASI_TERIMA = '0', 1, 0 ) ) AS BELUM_KIRIM,  
        sum( if( STATUS_MUTASI_TERIMA = '1', 1, 0 ) ) AS BELUM_DISETUJUI, 
        sum( if( STATUS_MUTASI_TERIMA = '2', 1, 0 ) ) AS DISETUJUI,
        sum( if( STATUS_MUTASI_TERIMA = '3', 1, 0 ) ) AS DITOLAK,
        sum( if( STATUS_MUTASI_TERIMA = '4', 1, 0 ) ) AS CLOSING,
        sum( if( STATUS_MUTASI_TERIMA = '5', 1, 0 ) ) AS CLOSING_BELUM_DISETUJUI,
        sum( if( STATUS_MUTASI_TERIMA = '6', 1, 0 ) ) AS CLOSING_DISETUJUI,
        sum( if( STATUS_MUTASI_TERIMA = '7', 1, 0 ) ) AS CLOSING_DITOLAK,
        count(*) AS TOTAL 
        FROM  MUTASI_PENERIMAAN
        WHERE SLOC='$SLOC' AND date_format(TGL_PENGAKUAN,'%m%Y') = '$TGL_PENGAKUAN'     
        GROUP BY SLOC, TGL_PENGAKUAN_FORMAT ";
        
        $query = $this->db->query($q);
        $this->db->close();
        return $query->result();       
    }

    public function get_sum_volume() {        
        $IDGROUP = $_POST['IDGROUP'];

        $q="SELECT SUM(VOL_TERIMA) V_TERIMA, SUM(VOL_TERIMA_REAL) V_TERIMA_REAL 
            FROM MUTASI_PENERIMAAN WHERE IDGROUP='$IDGROUP' ";
        
        $query = $this->db->query($q);
        $this->db->close();
        return $query->result();       
    }    

    public function option_komponen($id = ''){
        $option = array();
        $list = $this->db->query("call LOAD_KOMPONEN_BBM('$id')");
        
        $option[''] = '-- Pilih Komponen BBM --';
        foreach ($list->result() as $row) {
            if ($row->RCDB == 'RC00'){
                $option[$row->ID_JNS_BHN_BKR] = $row->NAMA_JNS_BHN_BKR;
            }
        }
        $this->db->close();
        return $option;    
    }

    public function option_komponen_bio($id = '', $jenis=0){
        $list = $this->db->query("SELECT * FROM M_GROUP_JNS_BBM WHERE GROUPID_JNSBBM='$id' ")->result();
       
        if ($jenis==0){
            $rest = $list;
        } else {
            $option = array();
            $option[''] = '-- Pilih Komponen BIO --';
            foreach ($list as $row) {            
                $option[$row->KODE_JNS_BHN_BKR] = $row->NAMA_JNS_BHN_BKR; 
            }
            $rest = $option;
        }
        
        $this->db->close();
        return $rest;    
    }

}

/* End of file unit_model.php */
/* Location: ./application/modules/unit/models/unit_model.php */