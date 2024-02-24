<?php
/**
 * @module MASTER TRANSPORTIR
 * @author  RAKHMAT WIJAYANTO
 * @created at 17 OKTOBER 2017
 * @modified at 17 OKTOBER 2017
 */
class perhitungan_harga_bbm_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table1 = "TRANS_HITUNG_HARGA"; //nama table setelah mom_

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
        $this->db->join('DATA_SETTING s', "s.VALUE_SETTING = a.STATUS_APPROVE AND s.KEY_SETTING='STATUS_APPROVE' ",'left');

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
        
        $this->db->where("a.STATUS_APPROVE IN ('2','8','11') ");

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
        $this->db->select("a.*, p.NAMA_PEMASOK AS PEMASOK "); 
        $this->db->from("DATA_KONTRAK_PEMASOK a");
        $this->db->join('MASTER_PEMASOK p', 'p.ID_PEMASOK = a.ID_PEMASOK','left');
        $this->db->where("(p.KODE_PEMASOK ='002' OR p.KODE_PEMASOK ='003' )");

        $kata_kunci = $this->laccess->ai($this->input->post('kata_kunci'));
        if ($kata_kunci){
            $this->db->where("(a.NOPJBBM_KONTRAK_PEMASOK LIKE '%$kata_kunci%' OR p.NAMA_PEMASOK LIKE '%$kata_kunci%')");
        }

        // $this->db->order_by('TGLAWAL DESC');

        $rest = $this->db;
        $this->db->close();
        return $rest;
    }

    public function data_table($module = '', $limit = 20, $offset = 1) {
    	$filter = array();
        $kata_kunci = $this->laccess->ai($this->input->post('kata_kunci'));

        if (!empty($kata_kunci))
            $filter["NAMA_PEMASOK LIKE '%{$kata_kunci}%' OR LEVEL4 LIKE '%{$kata_kunci}%' "] = NULL;
        $total = $this->data($filter)->count_all_results();
    	$this->db->limit($limit, ($offset * $limit) - $limit);
        $record = $this->data($filter)->get();
    	$no=(($offset-1) * $limit) +1;
        $rows = array();

        foreach ($record->result() as $row) {
            $id = $row->IDTRANS;
            $aksi = '';
            $status = '';

            if ($row->KODE_PEMASOK==001){ //pertamina
                if (($row->STATUS_APPROVE>=8) && ($row->STATUS_APPROVE<=12)){
                    $aksi = anchor(null, '<i class="icon-zoom-in" title="Lihat Data Koreksi"></i>', array('class' => 'btn transparant', 'id' => 'button-view-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/view_pertamina_lihat_koreksi/' . $id)));                
                } else {
                    $aksi = anchor(null, '<i class="icon-zoom-in" title="Lihat Data"></i>', array('class' => 'btn transparant', 'id' => 'button-view-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/view_pertamina/' . $id)));
                }
            } else {
                if (($row->STATUS_APPROVE>=8) && ($row->STATUS_APPROVE<=12)){
                    $aksi = anchor(null, '<i class="icon-zoom-in" title="Lihat Data Koreksi"></i>', array('class' => 'btn transparant', 'id' => 'button-view-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/view_akr_kpm_lihat_koreksi/' . $id)));
                } else {
                    $aksi = anchor(null, '<i class="icon-zoom-in" title="Lihat Data"></i>', array('class' => 'btn transparant', 'id' => 'button-view-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/view_akr_kpm/' . $id)));                    
                }  
            }

            //kirim
            if (($this->session->userdata('roles_id') == 20) && ($this->laccess->otoritas('add'))){
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
                        if ($this->laccess->otoritas('edit')) {
                            // if ($row->PERUBAHAN == 0){
                                $aksi .= anchor(null, '<i class="icon-edit" title="Add Data Koreksi"></i>', array('class' => 'btn transparant', 'id' => 'button-koreksi-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/add_koreksi/' . $id)));
                            // }
                        }
                    } else if ($row->STATUS_APPROVE==9){
                        $status.= anchor(null, '<i class="icon-share" title="Kirim Data Koreksi"></i>', array('class' => 'btn transparant', 'id' => 'button-kirim-' . $id, 'onclick' => 'setKirimDataKoreksi(this.id)', 'data-source' => base_url($module . '/kirim/' . $id)));
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
                        if ($this->laccess->otoritas('edit')) {
                            // if ($row->PERUBAHAN == 0){
                                $aksi .= anchor(null, '<i class="icon-edit" title="Add Data Koreksi"></i>', array('class' => 'btn transparant', 'id' => 'button-koreksi-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/add_akr_kpm_koreksi/' . $id)));
                            // }
                        }
                    } else if ($row->STATUS_APPROVE==9){
                        $status.= anchor(null, '<i class="icon-share" title="Kirim Data Koreksi"></i>', array('class' => 'btn transparant', 'id' => 'button-kirim-' . $id, 'onclick' => 'setKirimDataKoreksi(this.id)', 'data-source' => base_url($module . '/kirim/' . $id)));
                    }

                }
            }

            //approve
            if (($this->session->userdata('roles_id') == 34) && ($this->laccess->otoritas('approve'))){
                if ($row->KODE_PEMASOK==001){
                    if ($row->STATUS_APPROVE==1){
                        $status.= anchor(null, '<i class="icon-external-link" title="Approve / Tolak Data"></i>', array('class' => 'btn transparant', 'id' => 'button-approve-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/view_pertamina_approve/' . $id)));
                    } else if (($row->STATUS_APPROVE==2) || ($row->STATUS_APPROVE==11)){
                        $status.= anchor(null, '<i class="icon-paste" title="Koreksi Data"></i>', array('class' => 'btn transparant', 'id' => 'button-koreksi-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/view_pertamina_approve_koreksi/' . $id)));
                    } else if ($row->STATUS_APPROVE==10){
                        $status.= anchor(null, '<i class="icon-external-link" title="Approve / Tolak Data Koreksi"></i>', array('class' => 'btn transparant', 'id' => 'button-approvekoreksi-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/view_pertamina_approve_koreksi_hasil/' . $id)));
                    }
                } else {
                    if ($row->STATUS_APPROVE==1){
                        $status.= anchor(null, '<i class="icon-external-link" title="Approve / Tolak Data"></i>', array('class' => 'btn transparant', 'id' => 'button-approve-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/view_akr_kpm_approve/' . $id)));
                    } else if (($row->STATUS_APPROVE==2) || ($row->STATUS_APPROVE==11)){
                        $status.= anchor(null, '<i class="icon-paste" title="Koreksi Data"></i>', array('class' => 'btn transparant', 'id' => 'button-koreksi-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/view_akr_kpm_approve_koreksi/' . $id)));
                    } else if ($row->STATUS_APPROVE==10){
                        $status.= anchor(null, '<i class="icon-external-link" title="Approve / Tolak Data Koreksi"></i>', array('class' => 'btn transparant', 'id' => 'button-approvekoreksi-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/view_akr_kpm_approve_koreksi_hasil/' . $id)));
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
            

            $rows[$no] = array(
                'NO' => $no++,
                'BLTH' => $row->PERIODE,
                'PEMASOK' => $row->PEMASOK,
                // 'PEMBANGKIT' => $row->PEMBANGKIT,
                'NOPJBBM' => $row->NOPJBBM,
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

        $total = $this->data_pencarian($filter)->count_all_results();
        $this->db->limit($limit, ($offset * $limit) - $limit);
        $record = $this->data_pencarian($filter)->get();
        $no=(($offset-1) * $limit) +1;
        $rows = array();

        foreach ($record->result() as $row) {
            $id = $row->ID_KONTRAK_PEMASOK;
            $aksi = '';

            // if ($row->KODE_PEMASOK==001){ //pertamina
            //     $aksi .= anchor(null, '<i class="icon-file-alt" title="Lihat Data"></i>', array('class' => 'btn transparant', 'id' => 'button-edit-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/view_pertamina/' . $id)));    
            // }
            

            // $aksi = anchor(null, '<i class="icon-edit"></i>', array('class' => 'btn transparant', 'id' => 'button-edit-' . $id, 'onclick' => 'load_form_modal(this.id)', 'data-source' => base_url($module . '/edit/' . $id)));
            // $aksi .= anchor(null, '<i class="icon-trash"></i>', array('class' => 'btn transparant', 'id' => 'button-delete-' . $id, 'onclick' => 'delete_row(this.id)', 'data-source' => base_url($module . '/delete/' . $id)));

            $aksi .= anchor(null, '<i class="icon-check" title="Pilih Kontrak"></i>', array('class' => 'btn transparant', 'id' => ''. $id, 'onclick' => 'pilih_kontrak(this.id)', 'vnopjbbbm' => $row->NOPJBBM_KONTRAK_PEMASOK));

            $rows[$no] = array(
                'NO' => $no++,
                'PEMASOK' => $row->PEMASOK,
                'NOPJBBM_KONTRAK_PEMASOK' => $row->NOPJBBM_KONTRAK_PEMASOK,
                // 'TGL_KONTRAK_PEMASOK' => $row->TGL_KONTRAK_PEMASOK,
                'JUDUL_KONTRAK_PEMASOK' => $row->JUDUL_KONTRAK_PEMASOK,
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

    public function get_hitung_harga_edit($periode=''){ 
        $cari = "";
        if ($_POST['ID_REGIONAL'] !='') {
            if ($_POST['ID_REGIONAL'] !='00'){
                $cari = " AND r.ID_REGIONAL='".$_POST['ID_REGIONAL']."' ";    
            }
        }
        if ($_POST['COCODE'] !='') {
            $cari = " AND m1.COCODE='".$_POST['COCODE']."' ";
        }
        if ($_POST['PLANT'] !='') {
            $cari = " AND m2.PLANT='".$_POST['PLANT']."' ";
        }
        if ($_POST['STORE_SLOC'] !='') {
            $cari = " AND m3.STORE_SLOC='".$_POST['STORE_SLOC']."' ";
        }
        if ($_POST['SLOC'] !='') {
            $cari = " AND m4.SLOC='".$_POST['SLOC']."' ";
        }

        $q = " SELECT a.*, m1.LEVEL1, m2.LEVEL2, m3.LEVEL3, m4.LEVEL4  
               FROM TRANS_HITUNG_HARGA a 
               LEFT JOIN MASTER_LEVEL4 m4 ON m4.SLOC=a.SLOC
               LEFT JOIN MASTER_LEVEL3 m3 ON m3.STORE_SLOC=m4.STORE_SLOC
               LEFT JOIN MASTER_LEVEL2 m2 ON m2.PLANT = m3.PLANT
               LEFT JOIN MASTER_LEVEL1 m1 ON m1.COCODE = m2.COCODE
               LEFT JOIN MASTER_REGIONAL r ON r.ID_REGIONAL = m1.ID_REGIONAL
               WHERE a.PERIODE='$periode' AND a.KODE_PEMASOK IN('002','003') 
               AND a.STATUS_APPROVE IN ('2','8','11') ".$cari;

        $query = $this->db->query($q)->result_array();
        $this->db->close();
        return $query;
    }

    public function get_hitung_harga_pertamina_edit($periode=''){
        $q = " SELECT a.*, m4.LEVEL4 FROM TRANS_HITUNG_HARGA a 
               LEFT JOIN MASTER_LEVEL4 m4 ON m4.SLOC=a.SLOC
               WHERE a.PERIODE='$periode' AND a.KODE_PEMASOK ='001' ";

        $query = $this->db->query($q)->result();
        $this->db->close();
        return $query;
    }

    public function get_mops_kurs_edit($vidtrans=''){
        $q = " SELECT * FROM TRANS_MOPS  
               WHERE IDTRANS='$vidtrans' ";

        $query = $this->db->query($q)->result_array();
        $this->db->close();
        return $query;
    }
}

/* End of file unit_model.php */
/* Location: ./application/modules/unit/models/unit_model.php */