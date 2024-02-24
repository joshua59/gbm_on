<?php

/**
 * @module MASTER
 * @author  CF
 * @created at 17 November 2017
 * @modified at 17 November 2017
 */
class kontrak_pemasok_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table1 = "DATA_KONTRAK_PEMASOK"; //nama table setelah mom_
    private $_table2 = "DOC_KONTRAK_PEMASOK"; //nama table setelah mom_

    private function _key($key) { //unit ID
        if (!is_array($key)) {
            $key = array('a.ID_KONTRAK_PEMASOK' => $key);
        }
        return $key;
    }

    public function data($key = '') {
        $path = ' ,(SELECT c.PATH_DOC_PEMASOK FROM DOC_KONTRAK_PEMASOK c WHERE c.ID_KONTRAK_PEMASOK = a.ID_KONTRAK_PEMASOK ORDER BY ID_DOC_PEMASOK DESC LIMIT 1) PATH_DOC_PEMASOK ';

        $perubahan = ' ,(SELECT COUNT(*) FROM ADENDUM_KONTRAK_PEMASOK b WHERE b.ID_KONTRAK_PEMASOK=a.ID_KONTRAK_PEMASOK) AS PERUBAHAN';

        $this->db->select('a.*, b.NAMA_PEMASOK '.$perubahan.$path);
        $this->db->from($this->_table1.' a');
        $this->db->join('MASTER_PEMASOK b', 'b.ID_PEMASOK = a.ID_PEMASOK','left');

        if (!empty($key) || is_array($key))
            $this->db->where_condition($this->_key($key));

        $this->db->order_by('a.CD_KONTRAK_PEMASOK DESC, ID_KONTRAK_PEMASOK DESC');

        return $this->db;
    }

    public function save_as_new($data,$nama_file) {
        $this->db->trans_begin();
        $id_kontrak = $this->db->set_id($this->_table1, 'ID_KONTRAK_PEMASOK', 'no_prefix', 5);
        $this->db->insert($this->_table1, $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
    
            $data_file['ID_KONTRAK_PEMASOK'] = $id_kontrak;
            $data_file['PATH_DOC_PEMASOK'] = $nama_file;
            $data_file['CD_DOC_PEMASOK'] = $data['CD_KONTRAK_PEMASOK'];
            $data_file['CD_BY_DOC_PEMASOK'] = $data['CD_BY_KONTRAK_PEMASOK'];
            $this->save_as_new_file($data_file);

            //jika jenis CIF
            if ($data['JENIS_KONTRAK_PEMASOK']==1){
                $SLOC = (string)$data['SLOC'];
                $var = explode(',',$SLOC);
                $arr_SLOC = array();
                $arr = array();
                
                foreach($var as &$row) {
                    $arr['ID_KONTRAK_PEMASOK'] = $id_kontrak;
                    $arr['SLOC'] = $row;

                    $arr_SLOC[] = $arr;
                }

                $this->db->delete('DATA_KONTRAK_PEMASOK_PEMBANGKIT', array('ID_KONTRAK_PEMASOK' => $id_kontrak));
                $this->db->insert_batch('DATA_KONTRAK_PEMASOK_PEMBANGKIT', $arr_SLOC);                
            }
                
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function save_as_new_file($data_file) {
        $this->db->trans_begin();
        $this->db->set_id('DOC_KONTRAK_PEMASOK', 'ID_DOC_PEMASOK', 'no_prefix', 5);
        $this->db->insert('DOC_KONTRAK_PEMASOK', $data_file);

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

        $this->db->update($this->_table1, $data, array('ID_KONTRAK_PEMASOK' => $key));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            //jika jenis CIF
            if ($data['JENIS_KONTRAK_PEMASOK']==1){
                $SLOC = (string)$data['SLOC'];
                $var = explode(',',$SLOC);
                $arr_SLOC = array();
                $arr = array();
                
                foreach($var as &$row) {
                    $arr['ID_KONTRAK_PEMASOK'] = $key;
                    $arr['SLOC'] = $row;

                    $arr_SLOC[] = $arr;
                }

                $this->db->delete('DATA_KONTRAK_PEMASOK_PEMBANGKIT', array('ID_KONTRAK_PEMASOK' => $key));
                $this->db->insert_batch('DATA_KONTRAK_PEMASOK_PEMBANGKIT', $arr_SLOC);                
            }

            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function delete($key) {
        $this->db->trans_begin();
        $this->db->where("ID_KONTRAK_PEMASOK",$key);

        $this->db->delete($this->_table1);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->delete('DATA_KONTRAK_PEMASOK_PEMBANGKIT', array('ID_KONTRAK_PEMASOK' => $key));
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    public function deleteDocumen($key) {
        $this->db->trans_begin();

        $this->db->where("ID_KONTRAK_PEMASOK",$key);  
        $this->db->delete($this->_table2);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function data_table($module = '', $limit = 20, $offset = 1) {
		$filter = array();
        $kata_kunci = $this->laccess->ai($this->input->post('kata_kunci'));

        if (!empty($kata_kunci))
            $filter["b.NAMA_PEMASOK LIKE '%{$kata_kunci}%' OR a.JUDUL_KONTRAK_PEMASOK LIKE '%{$kata_kunci}%' OR a.NOPJBBM_KONTRAK_PEMASOK LIKE '%{$kata_kunci}%'" ] = NULL;
        $total = $this->data($filter)->count_all_results();
		$this->db->limit($limit, ($offset * $limit) - $limit);
        $record = $this->data($filter)->get();
		$no=(($offset-1) * $limit) +1;
        $rows = array();
        foreach ($record->result() as $row) {
            $id = $row->ID_KONTRAK_PEMASOK;
            $aksi = '';

                $aksi = anchor(null, '<i class="icon-zoom-in" title="Lihat Kontrak"></i>', array('class' => 'btn transparant', 'id' => 'button-view-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/edit_view/' . $id)));

            if ($this->laccess->otoritas('edit')) {
                if ($row->PERUBAHAN == 0){
                    $aksi .= anchor(null, '<i class="icon-edit" title="Edit Kontrak"></i>', array('class' => 'btn transparant', 'id' => 'button-edit-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/edit/' . $id)));
                }
            }
            if ($this->laccess->otoritas('add')) {
                $aksi .= anchor(null, '<i class="icon-copy" title="Lihat Adendum"></i>', array('class' => 'btn transparant', 'id' => 'button-adendum-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/adendum/' . $id)));
            }
            if ($this->laccess->otoritas('delete')) {
                if ($row->PERUBAHAN == 0){
                    $aksi .= anchor(null, '<i class="icon-trash" title="Hapus Kontrak"></i>', array('class' => 'btn transparant', 'id' => 'button-delete-' . $id, 'onclick' => 'delete_row(this.id)', 'data-source' => base_url($module . '/delete/' . $id)));               
                }
            }
            
            $rows[$id.$no] = array(
                'NO' => $no,
                'NAMA_PEMASOK' => $row->NAMA_PEMASOK,
                'NOPJBBM_KONTRAK_PEMASOK' => $row->NOPJBBM_KONTRAK_PEMASOK,
                'TGL_KONTRAK_PEMASOK' => $row->TGL_KONTRAK_PEMASOK,
                'JUDUL_KONTRAK_PEMASOK' => $row->JUDUL_KONTRAK_PEMASOK,
                'PERIODE_AWAL_KONTRAK_PEMASOK' => $row->PERIODE_AWAL_KONTRAK_PEMASOK,
                'PERIODE_AKHIR_KONTRAK_PEMASOK' => $row->PERIODE_AKHIR_KONTRAK_PEMASOK,
                'PERUBAHAN' => $row->PERUBAHAN,
                // 'JENIS_KONTRAK_PEMASOK' => $row->JENIS_KONTRAK_PEMASOK,
                // 'VOLUME_KONTRAK_PEMASOK' => $row->VOLUME_KONTRAK_PEMASOK,
                // 'ALPHA_KONTRAK_PEMASOK' => $row->ALPHA_KONTRAK_PEMASOK,
                // 'RUPIAH_KONTRAK_PEMASOK' => $row->RUPIAH_KONTRAK_PEMASOK,
                // 'PENJAMIN_KONTRAK_PEMASOK' => $row->PENJAMIN_KONTRAK_PEMASOK,
                // 'NO_PENJAMIN_KONTRAK_PEMASOK' => $row->NO_PENJAMIN_KONTRAK_PEMASOK,
                // 'NOMINAL_JAMINAN_KONTRAK' => $row->NOMINAL_JAMINAN_KONTRAK,
                // 'TGL_BERAKHIR_JAMINAN_KONTRAK' => $row->TGL_BERAKHIR_JAMINAN_KONTRAK,
                // 'KET_KONTRAK_PEMASOK' => $row->KET_KONTRAK_PEMASOK,
                'aksi' => $aksi
            );
            $no++;
        }

        return array('total' => $total, 'rows' => $rows);
    }  

    public function options_jns_kontrak() {
        $option = array();
        $option[''] = '--Pilih Jenis--';
        $option['1'] = 'CIF';
        $option['2'] = 'FOB';
        return $option;
    }

    public function options_pemasok($default = '--Pilih Pemasok--', $key = 'all') {
        $option = array();

        $this->db->from('MASTER_PEMASOK');
        if ($key != 'all'){
            $this->db->where('ID_PEMASOK',$key);
        }   
        $this->db->order_by('REF_NAMA_TRANS, NAMA_PEMASOK');
        
        $list = $this->db->get(); 

        if (!empty($default)) {
            $option[''] = $default;
        }

        foreach ($list->result() as $row) {
            $option[$row->ID_PEMASOK] = $row->NAMA_PEMASOK;
        }
        return $option;
    }

    public function options_lv4($default = '--Pilih Pembangkit--', $key = 'all', $jenis=0) {
        $q="SELECT m4.*, m3.LEVEL3, CONCAT(TRIM(m4.LEVEL4),'  (',IFNULL(m3.LEVEL3, ' - '),')') AS LEVEL
            FROM MASTER_LEVEL4 m4
            LEFT JOIN MASTER_LEVEL3 m3 ON m3.STORE_SLOC = m4.STORE_SLOC
            ORDER BY m4.LEVEL4";

        $query = $this->db->query($q);
        $this->db->close();
        return $query->result(); 

        // $this->db->select("a.*, CONCAT(a.LEVEL4,' (',(SELECT LEVEL3 FROM MASTER_LEVEL3 b WHERE b.STORE_SLOC = a.STORE_SLOC LIMIT 1),')') AS LEVEL ");
        // $this->db->from("MASTER_LEVEL4 a");
        // $this->db->where("a.IS_AKTIF_LVL4","1");

        // if ($key != 'all'){
        //     $this->db->where("a.STORE_SLOC",$key);
        // }    
        // $this->db->order_by("a.LEVEL4"); 

        // if ($jenis==0){
        //     $rest = $this->db->get()->result(); 
        // } else {
        //     $option = array();
        //     $list = $this->db->get(); 

        //     if (!empty($default)) {
        //         $option[''] = $default;
        //     }

        //     foreach ($list->result() as $row) {
        //         $option[$row->SLOC] = $row->LEVEL4;
        //     }
        //     $rest = $option;    
        // }
        // $this->db->close();
        // return $rest;
    }

    public function options_jns_bhn_bkr($default = '--Pilih Jenis Bahan Bakar--') {
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
     
}

/* End of file master_level1_model.php */
/* Location: ./application/modules/unit/models/master_level1_model.php */