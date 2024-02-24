<?php
/**
 * @module MASTER TRANSPORTIR
 * @author  RAKHMAT WIJAYANTO
 * @created at 17 OKTOBER 2017
 * @modified at 17 OKTOBER 2017
 */
class perhitungan_harga_non_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table1 = "TRANS_HITUNG_HARGA_NR"; //nama table setelah mom_

    private function _key($key) { //unit ID
        if (!is_array($key)) {
            $key = array('IDTRANS' => $key);
        }
        return $key;
    }

    public function data($key = '') {
        $this->db->select("a.*, p.NAMA_PEMASOK AS PEMASOK, m4.LEVEL4 AS PEMBANGKIT, s.NAME_SETTING AS STATUS "); 

        $this->db->join('MASTER_PEMASOK p', 'p.KODE_PEMASOK = a.KODE_PEMASOK','left');
        $this->db->join('MASTER_LEVEL4 m4', 'm4.SLOC = a.SLOC','left');
        $this->db->join('MASTER_LEVEL3 m3', 'm3.STORE_SLOC = m4.STORE_SLOC','left');
        $this->db->join('MASTER_LEVEL2 m2', 'm2.PLANT = m3.PLANT','left');
        $this->db->join('MASTER_LEVEL1 m1', 'm1.COCODE = m2.COCODE','left');
        $this->db->join('MASTER_REGIONAL r', 'r.ID_REGIONAL = m1.ID_REGIONAL','left');
        $this->db->join('DATA_SETTING s', "s.VALUE_SETTING = a.STATUS_APPROVE AND s.KEY_SETTING='STATUS_APPROVE_HARGA_NR' ",'left');

        $this->db->from($this->_table1." a");
        if (!empty($key) || is_array($key))
        $this->db->where_condition($this->_key($key));


        if ($_POST['ID_REGIONAL'] !='') {
            $this->db->where('r.ID_REGIONAL',$_POST['ID_REGIONAL']);
        }
        if ($_POST['COCODE'] !='') {
            $this->db->where("m1.COCODE",$_POST['COCODE']);
        }
        if ($_POST['PLANT'] !='') {
            $this->db->where("m2.PLANT",$_POST['PLANT']);
        }
        if ($_POST['STORE_SLOC'] !='') {
            $this->db->where("m3.STORE_SLOC",$_POST['STORE_SLOC']);
        }
        if ($_POST['SLOC'] !='') {
            $this->db->where("a.SLOC",$_POST['SLOC']);
        }
        if ($_POST['ID_PEMASOK'] !='') {
            $this->db->where("a.KODE_PEMASOK",$_POST['ID_PEMASOK']);
        }
        if ($_POST['STATUS'] !='') {
            $this->db->where("a.STATUS_APPROVE",$_POST['STATUS']);   
        }        
        if ($_POST['BULAN'] !='') {
            $this->db->where("DATE_FORMAT(a.TGLAWAL, '%m')=",$_POST['BULAN']);
        }
        if ($_POST['TAHUN'] !='') {
            $this->db->where("DATE_FORMAT(a.TGLAWAL, '%Y')=",$_POST['TAHUN']);
        }

        if (($this->session->userdata('roles_id') == 34) && ($this->laccess->otoritas('approve'))){
            $this->db->where("a.STATUS_APPROVE NOT IN ('0','9')");
        }

        // $kata_kunci = $this->laccess->ai($this->input->post('kata_kunci'));
        // if ($kata_kunci){
        //     $this->db->where(" (PERIODE LIKE '%$kata_kunci%' OR LEVEL4 LIKE '%$kata_kunci%') ");   
        // }

        // $this->db->group_by('a.NOPJBBM');
        // $this->db->group_by('a.PERIODE');
        $this->db->group_by('a.IDGROUP');


        $this->db->order_by('a.PERIODE DESC');
        $this->db->order_by('a.TGLAKHIR DESC');
        $this->db->order_by('a.KODE_PEMASOK ASC');
        $this->db->order_by('a.TGLINSERT DESC');

        $rest = $this->db;
        $this->db->close();
        return $rest;
    }

    public function data_pencarian($key = '') {
        $this->db->select("a.*, p.NAMA_PEMASOK AS PEMASOK, h.PERIODE, h.IDGROUP "); 
        $this->db->from("TRANS_HITUNG_HARGA h");
        $this->db->join('DATA_KONTRAK_PEMASOK a', 'a.NOPJBBM_KONTRAK_PEMASOK = h.NOPJBBM','left');
        $this->db->join('MASTER_PEMASOK p', 'p.ID_PEMASOK = a.ID_PEMASOK','left');
        $this->db->where("(p.KODE_PEMASOK ='002' OR p.KODE_PEMASOK ='003' )"); 
        $this->db->where("(h.STATUS_APPROVE IN ('2','11') )"); 

        $kata_kunci = $this->laccess->ai($this->input->post('kata_kunci'));
        if ($kata_kunci){
            $this->db->where("(a.NOPJBBM_KONTRAK_PEMASOK LIKE '%$kata_kunci%' OR p.NAMA_PEMASOK LIKE '%$kata_kunci%' OR h.PERIODE LIKE '%$kata_kunci%' OR a.JUDUL_KONTRAK_PEMASOK LIKE '%$kata_kunci%')");
        }

        $this->db->order_by('a.PERIODE_AWAL_KONTRAK_PEMASOK DESC');
        $this->db->order_by('h.PERIODE DESC');
        $this->db->group_by('h.IDGROUP');

        $rest = $this->db;
        $this->db->close();
        return $rest;
    }

    public function save_as_new($data) {
        $this->db->trans_begin();
        $this->db->set_id($this->_table1, 'ID_PERHITUNGAN', 'no_prefix', 3);
        $this->db->insert($this->_table1, $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $rest = FALSE;
        } else {
            $this->db->trans_commit();
            $rest = TRUE;
        }

        $this->db->close();
        return $rest;
    }

    public function save($data, $key) {
        $this->db->trans_begin();

        $this->db->update($this->_table1, $data, $this->_key($key));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $rest = FALSE;
        } else {
            $this->db->trans_commit();
            $rest = TRUE;
        }
        $this->db->close();
        return $rest;
    }

    public function update_file($data, $key) {
        $this->db->trans_begin();

        $this->db->update($this->_table1, $data, array('IDGROUP' => $key));     

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $rest = FALSE;
        } else {
            $this->db->trans_commit();
            $rest = TRUE;
        }
        $this->db->close();
        return $rest;
    }        

    public function delete($key) {
        $this->db->trans_begin();

        $this->db->delete($this->_table1, $this->_key($key));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $rest = FALSE;
        } else {
            $this->db->trans_commit();
            $rest = TRUE;
        }
        $this->db->close();
        return $rest;
    }

    public function data_table($module = '', $limit = 20, $offset = 1) {
    	$filter = array();
        $kata_kunci = $this->laccess->ai($this->input->post('kata_kunci'));

        if (!empty($kata_kunci))
            $filter["(NAMA_PEMASOK LIKE '%{$kata_kunci}%' OR PERIODE LIKE '%{$kata_kunci}%' OR NOPJBBM LIKE '%{$kata_kunci}%' OR CREATE_BY LIKE '%{$kata_kunci}%'OR APPROVE_BY LIKE '%{$kata_kunci}%')"] = NULL;
        // $total = $this->data($filter)->count_all_results();
        $total = $this->data($filter)->get();
        $total = $total->num_rows();

    	$this->db->limit($limit, ($offset * $limit) - $limit);
        $record = $this->data($filter)->get();
    	$no=(($offset-1) * $limit) +1;
        $rows = array();

        foreach ($record->result() as $row) {
            $id = $row->IDTRANS;
            $aksi = '';
            $status = '';

            if ($row->KODE_PEMASOK==001){ //pertamina
                // if (($row->STATUS_APPROVE>=8) && ($row->STATUS_APPROVE<=12)){
                //     $aksi = anchor(null, '<i class="icon-zoom-in" title="Lihat Data Koreksi"></i>', array('class' => 'btn transparant', 'id' => 'button-view-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/view_pertamina_lihat_koreksi/' . $id)));                
                // } else {
                    $aksi = anchor(null, '<i class="icon-zoom-in" title="Lihat Data"></i>', array('class' => 'btn transparant', 'id' => 'button-view-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/view_pertamina/' . $id)));                                         
                // }
            } else {
                // if (($row->STATUS_APPROVE>=8) && ($row->STATUS_APPROVE<=12)){
                //     $aksi = anchor(null, '<i class="icon-zoom-in" title="Lihat Data Koreksi"></i>', array('class' => 'btn transparant', 'id' => 'button-view-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/view_akr_kpm_lihat_koreksi/' . $id)));
                // } else {
                    $aksi = anchor(null, '<i class="icon-zoom-in" title="Lihat Data"></i>', array('class' => 'btn transparant', 'id' => 'button-view-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/view_akr_kpm/' . $id)));                                        
                // }  

                // if (($row->STATUS_APPROVE==2) && ($row->KODE_PEMASOK==002)){ //kpm
                if ($row->KODE_PEMASOK==002){ //kpm
                    $aksi.= anchor(null, '<i class="icon-print" title="Cetak Form Harga BBM"></i>', array('class' => 'btn transparant', 'id' => 'button-cetakkpm-' . $id, 'onclick' => 'load_pdf(this.id)', 'data-source' => base_url($module . '/export_pdf_kpm'), 'id-group' => $row->IDGROUP));                
                }   

                // if (($row->STATUS_APPROVE==2) && ($row->KODE_PEMASOK==003)){ //akr
                if ($row->KODE_PEMASOK==003){ //akr
                    $aksi.= anchor(null, '<i class="icon-print" title="Cetak Form Harga BBM"></i>', array('class' => 'btn transparant', 'id' => 'button-cetakakr-' . $id, 'onclick' => 'load_pdf(this.id)', 'data-source' => base_url($module . '/export_pdf_akr'), 'id-group' => $row->IDGROUP));                
                }

                $val = $row->TGLAWAL.'~'.$row->PEMASOK.'~'.$row->NOPJBBM.'~CIF';
                if (($row->STATUS_APPROVE==2) && ($row->KODE_PEMASOK==002)){ //kpm                
                    $aksi.= anchor(null, '<i class="icon-upload-alt" title="Upload Form Harga BBM"></i>', array('class' => 'btn transparant', 'id' => 'button-uploadkpm-' . $id, 'val'=> $val, 'nama-file'=> $row->PATH_FILE_UPLOAD, 'onclick' => 'load_upload(this.id)', 'data-source' => base_url($module . '/export_pdf_kpm'), 'id-group' => $row->IDGROUP));                
                }   

                if (($row->STATUS_APPROVE==2) && ($row->KODE_PEMASOK==003)){ //akr                
                    $aksi.= anchor(null, '<i class="icon-upload-alt" title="Upload Form Harga BBM"></i>', array('class' => 'btn transparant', 'id' => 'button-uploadakr-' . $id, 'val'=> $val, 'nama-file'=> $row->PATH_FILE_UPLOAD, 'onclick' => 'load_upload(this.id)', 'data-source' => base_url($module . '/export_pdf_akr'), 'id-group' => $row->IDGROUP));                
                }                  
            }          

            //kirim
            if (($this->session->userdata('roles_id') == 20) && ($this->laccess->otoritas('add')) && ($row->CREATE_BY==$this->session->userdata('user_name'))){
                //perttamina
                if ($row->KODE_PEMASOK==001){
                    //kirim
                    if ($row->STATUS_APPROVE==0){

                       //edit
                        if ($this->laccess->otoritas('edit')) {
                            // if ($row->PERUBAHAN == 0){
                                $aksi .= anchor(null, '<i class="icon-edit" title="Edit Data"></i>', array('class' => 'btn transparant', 'id' => 'button-edit-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/add/' . $id)));
                            // }
                        }

                        $status.= anchor(null, '<i class="icon-share" title="Kirim Data"></i>', array('class' => 'btn transparant', 'id' => 'button-kirim-' . $id, 'onclick' => 'setKirimData(this.id)', 'data-source' => base_url($module . '/kirim/' . $id)));
                        
                    } else if (($row->STATUS_APPROVE==8)&&($row->IS_KOREKSI==0)){
                        // if ($this->laccess->otoritas('edit')) {
                        //     // if ($row->PERUBAHAN == 0){
                        //         $aksi .= anchor(null, '<i class="icon-edit" title="Add Data Koreksi"></i>', array('class' => 'btn transparant', 'id' => 'button-koreksi-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/add_koreksi/' . $id)));
                        //     // }
                        // }
                    } else if ($row->STATUS_APPROVE==9){

                       //edit koreksi
                        // if ($this->laccess->otoritas('edit')) {
                        //         $aksi .= anchor(null, '<i class="icon-edit" title="Edit Data Koreksi"></i>', array('class' => 'btn transparant', 'id' => 'button-edit-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/edit_koreksi/' . $id)));
                        // }

                        // $status.= anchor(null, '<i class="icon-share" title="Kirim Data Koreksi"></i>', array('class' => 'btn transparant', 'id' => 'button-kirim-' . $id, 'onclick' => 'setKirimDataKoreksi(this.id)', 'data-source' => base_url($module . '/kirim/' . $id)));
                    }

                } else { //akr kpm
                    //kirim
                    if ($row->STATUS_APPROVE==0){
                        //edit
                        if ($this->laccess->otoritas('edit')) {
                            // if ($row->PERUBAHAN == 0){
                                $aksi .= anchor(null, '<i class="icon-edit" title="Edit Data"></i>', array('class' => 'btn transparant', 'id' => 'button-edit-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/add_akr_kpm/' . $id)));
                            // }
                        }

                        $status.= anchor(null, '<i class="icon-share" title="Kirim Data"></i>', array('class' => 'btn transparant', 'id' => 'button-kirim-' . $id, 'onclick' => 'setKirimData(this.id)', 'data-source' => base_url($module . '/kirim/' . $id)));   

                    } else if (($row->STATUS_APPROVE==8)&&($row->IS_KOREKSI==0)){
                        // if ($this->laccess->otoritas('edit')) {
                        //     // if ($row->PERUBAHAN == 0){
                        //         $aksi .= anchor(null, '<i class="icon-edit" title="Add Data Koreksi"></i>', array('class' => 'btn transparant', 'id' => 'button-koreksi-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/add_akr_kpm_koreksi/' . $id)));
                        //     // }
                        // }
                    } else if ($row->STATUS_APPROVE==9){


                       //edit koreksi
                        // if ($this->laccess->otoritas('edit')) {
                        //         $aksi .= anchor(null, '<i class="icon-edit" title="Edit Data Koreksi"></i>', array('class' => 'btn transparant', 'id' => 'button-edit-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/edit_koreksi_akr_kpm/' . $id)));
                        // }

                        // $status.= anchor(null, '<i class="icon-share" title="Kirim Data Koreksi"></i>', array('class' => 'btn transparant', 'id' => 'button-kirim-' . $id, 'onclick' => 'setKirimDataKoreksi(this.id)', 'data-source' => base_url($module . '/kirim/' . $id)));
                    }

                }
            }


            //approve
            if (($this->session->userdata('roles_id') == 34) && ($this->laccess->otoritas('approve'))){
                if ($row->KODE_PEMASOK==001){
                    if ($row->STATUS_APPROVE==1){
                        $status.= anchor(null, '<i class="icon-external-link" title="Approve / Tolak Data"></i>', array('class' => 'btn transparant', 'id' => 'button-approve-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/view_pertamina_approve/' . $id)));
                    // } else if (($row->STATUS_APPROVE==2) || ($row->STATUS_APPROVE==11)){
                    //     $status.= anchor(null, '<i class="icon-paste" title="Koreksi Data"></i>', array('class' => 'btn transparant', 'id' => 'button-koreksi-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/view_pertamina_approve_koreksi/' . $id)));
                    // } else if ($row->STATUS_APPROVE==10){
                    //     $status.= anchor(null, '<i class="icon-external-link" title="Approve / Tolak Data Koreksi"></i>', array('class' => 'btn transparant', 'id' => 'button-approvekoreksi-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/view_pertamina_approve_koreksi_hasil/' . $id)));
                    }
                } else {
                    if ($row->STATUS_APPROVE==1){
                        $status.= anchor(null, '<i class="icon-external-link" title="Approve / Tolak Data"></i>', array('class' => 'btn transparant', 'id' => 'button-approve-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/view_akr_kpm_approve/' . $id)));
                    // } else if (($row->STATUS_APPROVE==2) || ($row->STATUS_APPROVE==11)){
                    //     $status.= anchor(null, '<i class="icon-paste" title="Koreksi Data"></i>', array('class' => 'btn transparant', 'id' => 'button-koreksi-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/view_akr_kpm_approve_koreksi/' . $id)));
                    // } else if ($row->STATUS_APPROVE==10){
                    //     $status.= anchor(null, '<i class="icon-external-link" title="Approve / Tolak Data Koreksi"></i>', array('class' => 'btn transparant', 'id' => 'button-approvekoreksi-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/view_akr_kpm_approve_koreksi_hasil/' . $id)));
                    }
                }



                // if ($row->STATUS_APPROVE==1){
                //     if ($row->KODE_PEMASOK==001){
                //         $status.= anchor(null, '<i class="icon-external-link" title="Approve / Tolak Data"></i>', array('class' => 'btn transparant', 'id' => 'button-approve-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/view_pertamina_approve/' . $id)));
                //     } else {
                //         $status.= anchor(null, '<i class="icon-external-link" title="Approve / Tolak Data"></i>', array('class' => 'btn transparant', 'id' => 'button-approve-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/view_akr_kpm_approve/' . $id)));
                //     }
                // } else if ($row->STATUS_APPROVE==2){
                //     if ($row->KODE_PEMASOK==001){
                //         $status.= anchor(null, '<i class="icon-edit" title="Koreksi Data"></i>', array('class' => 'btn transparant', 'id' => 'button-koreksi-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/view_pertamina_approve_koreksi/' . $id)));
                //     } else {
                //         $status.= anchor(null, '<i class="icon-edit" title="Koreksi Data"></i>', array('class' => 'btn transparant', 'id' => 'button-koreksi-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/view_akr_kpm_approve_koreksi/' . $id)));
                //     }
                // }
            }

            $get_update = $this->get_last_update($row->IDTRANS);
            if (count($get_update)){
                $up_by = $get_update[0]['UPDATE_BY'];
                $up_date = $get_update[0]['UPDATE_DATE'];
            } else {
                $up_by = '';
                $up_date = '';
            }
            
            $rows[$no] = array(
                'NO' => $no++,
                'BLTH' => $row->TGLAWAL,
                'PEMASOK' => $row->PEMASOK,
                // 'PEMBANGKIT' => $row->PEMBANGKIT, 
                'NOPJBBM' => $row->NOPJBBM,                
                'CREATE_BY' => $row->CREATE_BY,
                'TGLINSERT' => $row->TGLINSERT,
                'APPROVE_BY' => $up_by,  //$row->APPROVE_BY,
                'APPROVE_DATE' => $up_date, //$row->APPROVE_DATE,
                'STATUS' => $row->STATUS,
                'aksi' => $aksi.'  '.$status
            );
        }

        // print_r($this->db->last_query()); die;

        return array('total' => $total, 'rows' => $rows);
    }

    public function data_table_pencarian($module = '', $limit = 20, $offset = 1) {
        $filter = array();
        // $kata_kunci = $this->laccess->ai($this->input->post('kata_kunci'));

        // if (!empty($kata_kunci))
            // $filter["a.NOPJBBM_KONTRAK_PEMASOK LIKE '%{$kata_kunci}%' OR p.NAMA_PEMASOK LIKE '%{$kata_kunci}%' OR a.JUDUL_KONTRAK_PEMASOK LIKE '%{$kata_kunci}%'"] = NULL;

        // $total = $this->data_pencarian($filter)->count_all_results();
        $total = $this->data_pencarian($filter)->get();
        $total = $total->num_rows();

        $this->db->limit($limit, ($offset * $limit) - $limit);
        $record = $this->data_pencarian($filter)->get();
        $no=(($offset-1) * $limit) +1;
        $rows = array();

        foreach ($record->result() as $row) {
            // $id = $row->NOPJBBM_KONTRAK_PEMASOK;
            $id = $row->IDGROUP;
            $aksi = '';

            // if ($row->KODE_PEMASOK==001){ //pertamina
            //     $aksi .= anchor(null, '<i class="icon-file-alt" title="Lihat Data"></i>', array('class' => 'btn transparant', 'id' => 'button-edit-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/view_pertamina/' . $id)));    
            // }
            

            // $aksi = anchor(null, '<i class="icon-edit"></i>', array('class' => 'btn transparant', 'id' => 'button-edit-' . $id, 'onclick' => 'load_form_modal(this.id)', 'data-source' => base_url($module . '/edit/' . $id)));
            // $aksi .= anchor(null, '<i class="icon-trash"></i>', array('class' => 'btn transparant', 'id' => 'button-delete-' . $id, 'onclick' => 'delete_row(this.id)', 'data-source' => base_url($module . '/delete/' . $id)));

            $aksi .= anchor(null, '<i class="icon-check" title="Pilih Kontrak"></i>', array('class' => 'btn transparant', 'id' => ''. $id, 'onclick' => 'pilih_kontrak(this.id)', 'data-source' => base_url($module . '/edit/' . $id)));

            $rows[$no] = array(
                'NO' => $no++,
                'PEMASOK' => $row->PEMASOK,
                'NOPJBBM_KONTRAK_PEMASOK' => $row->NOPJBBM_KONTRAK_PEMASOK,
                // 'TGL_KONTRAK_PEMASOK' => $row->TGL_KONTRAK_PEMASOK,
                'JUDUL_KONTRAK_PEMASOK' => $row->JUDUL_KONTRAK_PEMASOK,
                'PERIODE' => $row->PERIODE,
                'PERIODE_AWAL_KONTRAK_PEMASOK' => $row->PERIODE_AWAL_KONTRAK_PEMASOK,
                'PERIODE_AKHIR_KONTRAK_PEMASOK' => $row->PERIODE_AKHIR_KONTRAK_PEMASOK,
                'aksi' => $aksi
            );
        }

        // print_r($this->db->last_query()); die;

        return array('total' => $total, 'rows' => $rows);
    }

    public function options_pemasok($default = '--Pilih Pemasok--') {
        $this->db->from('MASTER_PEMASOK');
        $this->db->where('IS_HARGA','1');
        $this->db->order_by('NAMA_PEMASOK DESC');

        $option = array();
        $list = $this->db->get(); 

        if (!empty($default)) {
            $option[''] = $default;
        }

        foreach ($list->result() as $row) {
            $option[$row->KODE_PEMASOK] = $row->NAMA_PEMASOK;
        }
        $this->db->close();
        return $option;    
    }

    public function options_type($default = '--Pilih Type Pemasok--') {
        $option = array();
        // $option = ['PERTAMINA', 'NON PERTAMINA'];
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

    public function options_reg_array($default = '--Pilih Regional--', $key = 'all') {
        $option = array();
        
        $this->db->from('MASTER_REGIONAL');
        $this->db->where('IS_AKTIF_REGIONAL','1');
        if ($key != 'all'){
            $this->db->where('ID_REGIONAL',$key);
        }   
        $list = $this->db->get(); 

        if ($list->num_rows() > 0) 
        {
            return $list->result_array();
        } 
        else 
        {
            return array();
        }
    }

    public function options_reg($default = '--Pilih Regional--', $key = 'all') {
        $option = array();
        
        $this->db->from('MASTER_REGIONAL');
        $this->db->where('IS_AKTIF_REGIONAL','1');
        if ($key != 'all'){
            $this->db->where('ID_REGIONAL',$key);
        }   
        $list = $this->db->get(); 

        // if ($list->num_rows() > 0) 
        // {
        //     return $list->result_array();
        // } 
        // else 
        // {
        //     return array();
        // }
        
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
        $option = array();

        $option[''] = '--Pilih Tahun--';
        $option[$year - 1] = $year - 1;
        $option[$year] = $year;
        $option[$year + 1] = $year + 1;

        return $option;
    }

    public function options_jns_kurs() {
        $option = array();

        $option[''] = '--Pilih Referensi Kurs--';
        $option['0'] = 'JISDOR';
        $option['1'] = 'KTBI';

        return $option;
    }

    public function options_status() {
        $this->db->from('DATA_SETTING');
        $this->db->where('KEY_SETTING','STATUS_APPROVE_HARGA_NR');
        $this->db->order_by("NAME_SETTING ASC");
        
        $list = $this->db->get(); 
        $option = array();
        $option[''] = '-- Semua --';

        foreach ($list->result() as $row) {
            $option[$row->VALUE_SETTING] = $row->NAME_SETTING;
        }
        $this->db->close();
        return $option;    
    }

    public function options_isidentil() {
        $this->db->from('DATA_SETTING');
        $this->db->where('KEY_SETTING','SKEMA_ISIDENTIL');
        $this->db->order_by("NAME_SETTING ASC");
        
        $list = $this->db->get(); 
        $option = array();
        $option[''] = '--Pilih Jenis--';

        foreach ($list->result() as $row) {
            $option[$row->VALUE_SETTING] = $row->NAME_SETTING;
        }
        $this->db->close();
        return $option;    
    }
    
    public function options_tembusan() {
        $this->db->from('MASTER_TEMBUSAN'); 
        $this->db->order_by("URUTAN ASC");
        $this->db->order_by("NAMA ASC");
        
        $list = $this->db->get(); 
        $this->db->close();

        return $list->result();
        // $option = array();
        // $option[''] = '-- Semua --';

        // foreach ($list->result() as $row) {
        //     $option[$row->VALUE_SETTING] = $row->NAME_SETTING;
        // }
        // $this->db->close();
        // return $option;    
    }   

    public function generate_mops($tgl1,$tgl2){
        $sql = "SELECT * FROM ( 
                SELECT a.TGL_KURS,b.MIDHSD_MOPS as midhsd,b.MIDMFO_MOPS as midmfo,a.KTBI FROM KURS a
                LEFT JOIN MOPS_EXCEL b on a.TGL_KURS = b.TGL_MOPS
                UNION
                SELECT b.TGL_MOPS,b.MIDHSD_MOPS as midhsd,b.MIDMFO_MOPS as midmfo,a.KTBI FROM KURS a
                RIGHT JOIN MOPS_EXCEL b on a.TGL_KURS = b.TGL_MOPS
                ) X
                WHERE TGL_KURS BETWEEN '$tgl1' and '$tgl2' 
                ORDER BY TGL_KURS ASC";

        $result = $this->db->query($sql)->result_array();  
        return $result;      
    }

    public function generate_lowhsd($tgl1,$tgl2){
        $sql = "SELECT * FROM ( 
                SELECT a.TGL_KURS,b.LOWHSD_MOPS as lowhsd,a.KTBI FROM KURS a
                LEFT JOIN MOPS_EXCEL b on a.TGL_KURS = b.TGL_MOPS
                UNION
                SELECT b.TGL_MOPS,b.LOWHSD_MOPS as lowhsd,a.KTBI FROM KURS a
                RIGHT JOIN MOPS_EXCEL b on a.TGL_KURS = b.TGL_MOPS
                ) X
                WHERE TGL_KURS BETWEEN '$tgl1' and '$tgl2'
                ORDER BY TGL_KURS ASC";

        $result = $this->db->query($sql)->result_array();  
        return $result;      
    }
    

    function avg_mid_hsd($tgl1,$tgl2){
        $sql = "SELECT ROUND(AVG(MIDHSD_MOPS),2) AS MIDHSD_MOPS FROM MOPS_EXCEL 
                WHERE TGL_MOPS >= '$tgl1' and TGL_MOPS <= '$tgl2' AND MIDHSD_MOPS != '' ";

        $result = $this->db->query($sql)->row();  
        return $result;  
    }

    function avg_mid_mfo($tgl1,$tgl2){
        $sql = "SELECT ROUND(AVG(MIDMFO_MOPS),2) AS MIDMFO_MOPS FROM MOPS_EXCEL 
                WHERE TGL_MOPS >= '$tgl1' and TGL_MOPS <= '$tgl2' AND MIDMFO_MOPS != '' ";

        $result = $this->db->query($sql)->row();  
        return $result;  
    }

    function avg_ktbi($tgl1,$tgl2){
        $sql = "SELECT ROUND(AVG(KTBI),2) AS KTBI FROM KURS 
                WHERE TGL_KURS >= '$tgl1' and TGL_KURS <= '$tgl2' AND KTBI != '' ";

        $result = $this->db->query($sql)->row();  
        return $result;  
    }

    function avg_low_hsd($tgl1,$tgl2){
        $sql = "SELECT ROUND(AVG(LOWHSD_MOPS),2) AS LOWHSD_MOPS FROM MOPS_EXCEL 
                WHERE TGL_MOPS >= '$tgl1' and TGL_MOPS <= '$tgl2' AND LOWHSD_MOPS != '' ";

        $result = $this->db->query($sql)->row();  
        return $result;  
    }

    public function get_detailXXX(){ 
        $id = $_POST['vid'];
        $q = "  SELECT 
                a.ID_KONTRAK_PEMASOK, a.ID_PEMASOK, a.NOPJBBM_KONTRAK_PEMASOK, a.JUDUL_KONTRAK_PEMASOK,
                p.KODE_PEMASOK, p.NAMA_PEMASOK AS PEMASOK,
                d.SLOC, m4.LEVEL4, m3.STORE_SLOC, m3.LEVEL3, m2.PLANT, m2.LEVEL2, m1.COCODE, m1.LEVEL1, r.ID_REGIONAL, r.NAMA_REGIONAL,
                h.ALPHA_HSD, h.SULFUR_HSD, h.KONVERSI_HSD, h.ONGKOS_ANGKUT, h.TIPE_ALPHA, h.IDTRANS, h.IDKOREKSI,
                h.JNS_KURS, a.SKEMA_ISIDENTIL 
                FROM TRANS_HITUNG_HARGA h
                LEFT JOIN DATA_KONTRAK_PEMASOK a ON a.NOPJBBM_KONTRAK_PEMASOK=h.NOPJBBM
                LEFT JOIN MASTER_PEMASOK p ON p.ID_PEMASOK = a.ID_PEMASOK
                LEFT JOIN DATA_KONTRAK_PEMASOK_PEMBANGKIT d ON d.ID_KONTRAK_PEMASOK = a.ID_KONTRAK_PEMASOK
                LEFT JOIN MASTER_LEVEL4 m4 ON m4.SLOC = d.SLOC
                LEFT JOIN MASTER_LEVEL3 m3 ON m3.STORE_SLOC = m4.STORE_SLOC
                LEFT JOIN MASTER_LEVEL2 m2 ON m2.PLANT = m3.PLANT
                LEFT JOIN MASTER_LEVEL1 m1 ON m1.COCODE = m2.COCODE
                LEFT JOIN MASTER_REGIONAL r ON r.ID_REGIONAL = m1.ID_REGIONAL
                -- LEFT JOIN TRANS_HITUNG_HARGA h ON h.NOPJBBM = a.NOPJBBM_KONTRAK_PEMASOK AND h.SLOC=d.SLOC
                WHERE h.KODE_PEMASOK IN ('002','003')
                AND h.IDGROUP=(SELECT IDGROUP FROM TRANS_HITUNG_HARGA WHERE NOPJBBM='$id' ORDER BY PERIODE DESC LIMIT 1) ";

        $query = $this->db->query($q)->result();
        $this->db->close();
        return $query;
    }

    public function get_detail(){ 
        $id = $_POST['vid'];
        $TGLAWAL = $_POST['TGLAWAL'];
        $q = "  SELECT 
                a.ID_KONTRAK_PEMASOK, a.ID_PEMASOK, a.NOPJBBM_KONTRAK_PEMASOK, a.JUDUL_KONTRAK_PEMASOK,
                p.KODE_PEMASOK, p.NAMA_PEMASOK AS PEMASOK,
                d.SLOC, m4.LEVEL4, m3.STORE_SLOC, m3.LEVEL3, m2.PLANT, m2.LEVEL2, m1.COCODE, m1.LEVEL1, r.ID_REGIONAL, r.NAMA_REGIONAL,
                h.ALPHA_HSD, h.SULFUR_HSD, h.KONVERSI_HSD, h.ONGKOS_ANGKUT, h.TIPE_ALPHA, h.IDTRANS, h.IDKOREKSI,
                h.JNS_KURS, a.SKEMA_ISIDENTIL 
                FROM DATA_KONTRAK_PEMASOK a
                LEFT JOIN MASTER_PEMASOK p ON p.ID_PEMASOK = a.ID_PEMASOK
                LEFT JOIN DATA_KONTRAK_PEMASOK_PEMBANGKIT d ON d.ID_KONTRAK_PEMASOK = a.ID_KONTRAK_PEMASOK
                LEFT JOIN MASTER_LEVEL4 m4 ON m4.SLOC = d.SLOC
                LEFT JOIN MASTER_LEVEL3 m3 ON m3.STORE_SLOC = m4.STORE_SLOC
                LEFT JOIN MASTER_LEVEL2 m2 ON m2.PLANT = m3.PLANT
                LEFT JOIN MASTER_LEVEL1 m1 ON m1.COCODE = m2.COCODE
                LEFT JOIN MASTER_REGIONAL r ON r.ID_REGIONAL = m1.ID_REGIONAL
                LEFT JOIN TRANS_HITUNG_HARGA h ON h.NOPJBBM = a.NOPJBBM_KONTRAK_PEMASOK AND h.SLOC=d.SLOC
                WHERE p.KODE_PEMASOK IN ('002','003') 
                AND h.SLOC NOT IN (select SLOC from TRANS_HITUNG_HARGA_NR nr where nr.TGLAWAL='$TGLAWAL' and nr.NOPJBBM=h.NOPJBBM and nr.STATUS_APPROVE!='3') 
                AND h.IDGROUP='$id' ORDER BY d.ID_PP ";

        // print_r($q); die;
        $query = $this->db->query($q)->result();
        $this->db->close();
        return $query;
    }

    public function get_detail_edit(){ 
        $id = $_POST['vid'];
        
        $q = "SELECT 
                a.ID_KONTRAK_PEMASOK, a.ID_PEMASOK, a.NOPJBBM_KONTRAK_PEMASOK, a.JUDUL_KONTRAK_PEMASOK,
                p.KODE_PEMASOK, p.NAMA_PEMASOK AS PEMASOK,
                d.SLOC, m4.LEVEL4, m3.STORE_SLOC, m3.LEVEL3, m2.PLANT, m2.LEVEL2, m1.COCODE, m1.LEVEL1, r.ID_REGIONAL, r.NAMA_REGIONAL,
                h.ALPHA_HSD, h.SULFUR_HSD, h.KONVERSI_HSD, h.ONGKOS_ANGKUT, h.TIPE_ALPHA, h.IDTRANS, h.IDKOREKSI,
                h.JNS_KURS, a.SKEMA_ISIDENTIL  
                FROM DATA_KONTRAK_PEMASOK a
                LEFT JOIN MASTER_PEMASOK p ON p.ID_PEMASOK = a.ID_PEMASOK
                LEFT JOIN DATA_KONTRAK_PEMASOK_PEMBANGKIT d ON d.ID_KONTRAK_PEMASOK = a.ID_KONTRAK_PEMASOK
                LEFT JOIN MASTER_LEVEL4 m4 ON m4.SLOC = d.SLOC
                LEFT JOIN MASTER_LEVEL3 m3 ON m3.STORE_SLOC = m4.STORE_SLOC
                LEFT JOIN MASTER_LEVEL2 m2 ON m2.PLANT = m3.PLANT
                LEFT JOIN MASTER_LEVEL1 m1 ON m1.COCODE = m2.COCODE
                LEFT JOIN MASTER_REGIONAL r ON r.ID_REGIONAL = m1.ID_REGIONAL
                LEFT JOIN TRANS_HITUNG_HARGA_NR h ON h.NOPJBBM = a.NOPJBBM_KONTRAK_PEMASOK AND h.SLOC=d.SLOC
                WHERE p.KODE_PEMASOK IN ('002','003')                
                AND h.IDGROUP='$id' ORDER BY d.ID_PP ";

        // print_r($q); die;

        $query = $this->db->query($q)->result();
        $this->db->close();
        return $query;
    }

    public function get_detail_edit_nr(){ 
        $IDGROUP = $_POST['IDGROUP'];
        $PIDGROUP = $_POST['PIDGROUP'];
        $TGLAWAL = $_POST['TGLAWAL'];
        
        $q = "SELECT 
                h.SLOC, m4.LEVEL4, m3.STORE_SLOC, m3.LEVEL3, m2.PLANT, m2.LEVEL2, m1.COCODE, m1.LEVEL1, r.ID_REGIONAL, r.NAMA_REGIONAL,
                h.ALPHA_HSD, h.SULFUR_HSD, h.KONVERSI_HSD, h.ONGKOS_ANGKUT, h.TIPE_ALPHA, h.IDTRANS, h.IDKOREKSI, h.JNS_KURS, h.KODE_PEMASOK  
                FROM TRANS_HITUNG_HARGA h
                LEFT JOIN MASTER_LEVEL4 m4 ON m4.SLOC = h.SLOC
                LEFT JOIN MASTER_LEVEL3 m3 ON m3.STORE_SLOC = m4.STORE_SLOC
                LEFT JOIN MASTER_LEVEL2 m2 ON m2.PLANT = m3.PLANT
                LEFT JOIN MASTER_LEVEL1 m1 ON m1.COCODE = m2.COCODE
                LEFT JOIN MASTER_REGIONAL r ON r.ID_REGIONAL = m1.ID_REGIONAL                
                WHERE h.KODE_PEMASOK IN ('002','003')
                AND h.IDGROUP='$PIDGROUP' AND 
                h.SLOC NOT IN (SELECT nr.SLOC FROM TRANS_HITUNG_HARGA_NR nr WHERE nr.IDGROUP='$IDGROUP' ) 
                AND h.SLOC NOT IN (select nr.SLOC from TRANS_HITUNG_HARGA_NR nr where nr.TGLAWAL='$TGLAWAL' and nr.NOPJBBM=h.NOPJBBM and nr.IDGROUP!=h.IDGROUP and nr.STATUS_APPROVE!='3')";

        // print_r($q); die;

        $query = $this->db->query($q)->result();
        $this->db->close();
        return $query;
    }

    public function cek_akr_kpm($id){ 
        $q = "SELECT * FROM TRANS_HITUNG_HARGA_NR WHERE IDTRANS='$id' AND NOPJBBM <>'' ";

        $query = $this->db->query($q)->result();
        $this->db->close();
        return $query;
    }

    public function get_akr_kpm($IDGROUP){ 
        $q = "SELECT * FROM TRANS_HITUNG_HARGA_NR WHERE IDGROUP='$IDGROUP' ORDER BY TGLINSERT ASC ";

        $query = $this->db->query($q)->result();
        $this->db->close();
        return $query;
    }

    public function call_hitung_harga($createby, $tglawal, $tglakhir, $alpha=0, $sulfur_hsd=0 ,$sulfur_mfo=0,$konversi_hsd=0, $konversi_mfo=0, $pemasok, $oat=0, $sloc='', $no_pjbbm='', $periode='',$vket='',$avg_mops=0,$jns_kurs=0){

        $query = "call temp_average_nr('$createby', '$tglawal', '$tglakhir', '$alpha', '$sulfur_hsd', '$sulfur_mfo', '$konversi_hsd', '$konversi_mfo', '$pemasok', '$oat', '$sloc', '$no_pjbbm', '$periode','$vket','$avg_mops','$jns_kurs')";

        // print_r($query); die;
        
        
        $data = $this->db->query($query);
        $res = $data->result();

        $data->next_result(); // Dump the extra resultset.
        $data->free_result(); // Does what it says.

        // return $data->result();
        $this->db->close();
        return $res;
    }

    public function call_hitung_harga_pertamina_ulang($createby, $tglawal, $tglakhir, $alpha=0, $sulfur_hsd=0 ,$sulfur_mfo=0,$konversi_hsd=0, $konversi_mfo=0, $pemasok, $oat=0, $sloc='', $no_pjbbm='', $vidtrans='', $periode='',$vket='',$avg_mops=0,$jns_kurs=0){

        $query = "call edit_average_nr('$createby', '$tglawal', '$tglakhir', '$alpha', '$sulfur_hsd', '$sulfur_mfo', '$konversi_hsd', '$konversi_mfo', '$pemasok', '$oat', '$sloc', '$no_pjbbm', '$vidtrans', '$periode','$vket','$avg_mops','$jns_kurs')";

        // print_r($query); die;
        
        $data = $this->db->query($query);
        $res = $data->result();

        $data->next_result(); // Dump the extra resultset.
        $data->free_result(); // Does what it says.

        // return $data->result();
        $this->db->close();
        return $res;
    }

    public function call_hitung_harga_arr($createby, $tglposting, $idtrans, $sloc, $kurs='0' ,$skema=0){
        $query = "call temp_average_nr('$createby', '$tglposting', '$idtrans', '$sloc', '$kurs', '$skema')";

        // print_r($query); die;
        
        $data = $this->db->query($query);
        $res = $data->result_array();

        $data->next_result(); // Dump the extra resultset.
        $data->free_result(); // Does what it says.

        // return $data->result();
        $this->db->close();
        return $res;
    }

    public function call_hitung_harga_arr_ulang($createby, $tglposting, $idtrans, $sloc, $kurs='0', $skema=0, $idgroup=''){
        $query = "call edit_average_nr('$createby', '$tglposting', '$idtrans', '$sloc', '$kurs', '$skema', '$idgroup' )";

        // print_r($query); die;
        
        $data = $this->db->query($query);
        $res = $data->result_array();

        $data->next_result(); // Dump the extra resultset.
        $data->free_result(); // Does what it says.

        // return $data->result();
        $this->db->close();
        return $res;
    }

    public function get_hitung_harga_edit($IDGROUP=''){
        $q = " SELECT a.*, m4.LEVEL4 FROM TRANS_HITUNG_HARGA_NR a 
               LEFT JOIN MASTER_LEVEL4 m4 ON m4.SLOC=a.SLOC
               WHERE a.IDGROUP='$IDGROUP' ";

        $query = $this->db->query($q)->result_array();
        $this->db->close();
        return $query;
    }

    public function get_hitung_harga_pertamina_edit($IDTRANS=''){
        $q = " SELECT a.*, m4.LEVEL4 FROM TRANS_HITUNG_HARGA_NR a 
               LEFT JOIN MASTER_LEVEL4 m4 ON m4.SLOC=a.SLOC
               WHERE a.IDTRANS='$IDTRANS' ";

        $query = $this->db->query($q)->result();
        $this->db->close();
        return $query;
    }

    public function call_mops_kurs($vidtrans=''){
        $query = "call temp_mops_kurs_nr('$vidtrans')";

        // print_r($query); die;
        
        $data = $this->db->query($query);
        $res = $data->result_array();

        $data->next_result(); // Dump the extra resultset.
        $data->free_result(); // Does what it says.

        // return $data->result();
        $this->db->close();
        return $res;
    }

    public function get_mops_kurs_edit($vidtrans=''){
        $q = " SELECT * FROM TRANS_MOPS_NR  
               WHERE IDTRANS='$vidtrans' ";

        $query = $this->db->query($q)->result_array();
        $this->db->close();
        return $query;
    }

    public function get_mops_kurs_ulang($vidtrans=''){
        $q = " SELECT * FROM TEMP_EDIT_MOPS_NR  
               WHERE IDTRANS_EDIT='$vidtrans' 
               ORDER BY DATE ASC ";

        $query = $this->db->query($q)->result_array();
        $this->db->close();
        return $query;
    }

    public function call_simpan_data($vidtrans='',$vidgroup='',$vidkoreksi='',$vstatus='',$path_file=''){
        $query = "call save_mops_hitung_nr('$vidtrans','$vidgroup','$vidkoreksi','$vstatus','$path_file')";

        // print_r($query); die;
        
        $data = $this->db->query($query);
        // $res = $data->result_array();
        $res = $data->result();

        $data->next_result(); // Dump the extra resultset.
        $data->free_result(); // Does what it says.

        // return $data->result();
        $this->db->close();
        return $res;
    }

    public function call_simpan_data_edit($vidtrans='',$vidtrans_edit='',$vidgroup='',$idkoreksi='',$path_file='' ){
        $query = "call save_edit_mops_hitung_nr('$vidtrans','$vidtrans_edit','$vidgroup','$idkoreksi','$path_file')";

        // print_r($query); die;
        
        $data = $this->db->query($query);
        $res = $data->result_array();

        $data->next_result(); // Dump the extra resultset.
        $data->free_result(); // Does what it says.

        // return $data->result();
        $this->db->close();
        return $res;
    }

    public function call_kirim_data($p_trans='', $p_status='', $p_by_user='', $p_ket='', $p_idkoreksi=''){
        $query = "CALL PROSES_HITUNG_HARGA_NR('$p_trans', '$p_status', '$p_by_user','$p_ket','$p_idkoreksi'); ";

        // print_r($query); die;
        
        $data = $this->db->query($query);
        $res = $data->result();

        $data->next_result(); // Dump the extra resultset.
        $data->free_result(); // Does what it says.

        // return $data->result();
        $this->db->close();
        return $res;
    }

    public function get_data_setting(){ 
        $q = "SELECT * FROM DATA_SETTING WHERE KEY_SETTING='VARIABEL_HITUNG' OR KEY_SETTING='KONSTANTA_HITUNG' ORDER BY NAME_SETTING ASC";

        $query = $this->db->query($q)->result();
        $this->db->close();
        return $query;
    }

    public function cek_periode_pertamina($PERIODE='',$vidtrans=''){ 
        if ($vidtrans){ //edit
            $set_where = "AND h.IDTRANS<>'$vidtrans' ";
        } else { //baru
            $set_where = "";
        }

        $q = "SELECT p.NAMA_PEMASOK FROM TRANS_HITUNG_HARGA_NR h
              LEFT JOIN MASTER_PEMASOK p ON p.KODE_PEMASOK=h.KODE_PEMASOK
              WHERE h.PERIODE='$PERIODE' AND h.KODE_PEMASOK='001' AND h.STATUS_APPROVE<>'3' 
              AND h.STATUS_APPROVE NOT IN('3','12') ".$set_where;

        $query = $this->db->query($q);
        
        if ($query->num_rows() > 0) {
            $pemasok = $query->result_array();
            $rest = $pemasok[0]['NAMA_PEMASOK'];
        } else {
            $rest = FALSE;
        }

        $this->db->close();
        return $rest;
    }    

    public function cek_periode_akr_kpm($PERIODE='', $NOPJBBM='',$vidtrans=''){ 
        if ($vidtrans){ //edit
            $set_where = "SELECT h.PERIODE 
                          FROM TRANS_HITUNG_HARGA_NR h
                          WHERE h.KODE_PEMASOK <>'001' AND h.NOPJBBM='$NOPJBBM'AND h.IDTRANS='$vidtrans' AND h.STATUS_APPROVE NOT IN('3','12') ";
        } else { //baru
            $set_where = "";
        }

        $q = "SELECT CONCAT(p.NAMA_PEMASOK,' <br>NOPJBBBM ',h.NOPJBBM) AS NAMA_PEMASOK, h.PERIODE, h.NOPJBBM 
              FROM TRANS_HITUNG_HARGA_NR h
              LEFT JOIN MASTER_PEMASOK p ON p.KODE_PEMASOK=h.KODE_PEMASOK
              WHERE h.KODE_PEMASOK <>'001' AND h.PERIODE='$PERIODE' AND h.NOPJBBM='$NOPJBBM' AND h.STATUS_APPROVE NOT IN('3','12') ";

        // print_r($set_where); die;

        $query = $this->db->query($q);
        
        if ($query->num_rows() > 0) {
            $pemasok = $query->result_array();
            $rest = $pemasok[0]['NAMA_PEMASOK'];

            if ($vidtrans){
                $query = $this->db->query($set_where);
                if ($query->num_rows() > 0) {
                    $cek_lagi = $query->result_array();
                    $cek_periode = $cek_lagi[0]['PERIODE'];
                    if ($PERIODE==$cek_periode){
                        $rest = FALSE;
                    }
                }
            }
        } else {
            $rest = FALSE;
        }

        $this->db->close();
        return $rest;
    }  

    public function get_id_trans($IDGROUP){ 
        $q = "SELECT IDTRANS FROM TRANS_HITUNG_HARGA_NR WHERE IDGROUP='$IDGROUP' ORDER BY TGLINSERT ASC";

        $query = $this->db->query($q)->result_array();
        $this->db->close();
        return $query;
    }

    public function set_notif_tolak($username){        
        $q = "UPDATE TRANS_HITUNG_HARGA_NR SET IS_TOLAK='0' WHERE  CREATE_BY='$username' ";

        $query = $this->db->query($q);
        $this->db->close();
        return $query;        
    }

    public function get_last_update($id){ 
        $q = "SELECT * FROM HISTO_TR_HARGA_NR WHERE IDTRANS='$id' ORDER BY UPDATE_DATE DESC LIMIT 1";
        $query = $this->db->query($q)->result_array();
        $this->db->close();
        return $query;
    }

    public function set_hapus_nr($IDGROUP){ 
        $query = "CALL hapus_hitung_nr('$IDGROUP'); ";

        // print_r($query); die;
        
        $data = $this->db->query($query);
        $res = $data->result();

        $data->next_result(); // Dump the extra resultset.
        $data->free_result(); // Does what it says.

        // return $data->result();
        $this->db->close();
        return $res;
    }  

    public function get_setting_param($jns=''){
        $sql = "SELECT * FROM SETTING_CETAK_HARGA 
                WHERE JENIS = '$jns' LIMIT 1";

                // print_r($sql); die;

        $result = $this->db->query($sql)->row();  
        return $result;  
    }    

    public function get_tgl_kontrak($id=''){
        // $id='066-1.PJ/040/DIR/2007';
        $sql = "SELECT * FROM DATA_KONTRAK_PEMASOK WHERE NOPJBBM_KONTRAK_PEMASOK='$id'";                
        $val = $this->db->query($sql)->row();  

        if ($val){
            $result = $val->PERIODE_AWAL_KONTRAK_PEMASOK;
        } else {
            $result = '-';
        }
        return $result;  
    }        

    public function get_level1() {
        $q = "CALL GET_UNIT_LV1();";
        $query = $this->db->query($q)->result();
        $this->db->close();
        return $query;        
    }  

    public function get_unit($id) {
        $q = "CALL GET_UNIT('$id');";
        $query = $this->db->query($q)->result();
        $this->db->close();
        return $query;        
    }    

}

/* End of file unit_model.php */
/* Location: ./application/modules/unit/models/unit_model.php */