<?php

/**
 * @module MASTER
 * @author  CF
 * @created at 17 November 2017
 * @modified at 17 November 2017
 */
class monitoring_job_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table1 = "MONITORING_JOB"; 

    private function _key($key) { 
        if (!is_array($key)) {
            $key = array('ID_MONITORING' => $key);
        }
        return $key;
    }

    public function data($key = '') {
        $this->db->select('*');
        $this->db->from($this->_table1);

        if (!empty($key) || is_array($key))
            $this->db->where_condition($this->_key($key));

        if ($_POST['STATUS'] !='') {
            $this->db->where("STATUS",$_POST['STATUS']);   
        }
        $this->db->order_by('CD_DATE', 'ASC');
        return $this->db;
    }

    public function data_table($module = '', $limit = 20, $offset = 1) {
		$filter = array();
        
        $total = $this->data()->count_all_results();
       
		$this->db->limit($limit, ($offset * $limit) - $limit);
        $record = $this->data($filter)->get();
        
        $rows = array();
        
        $no=(($offset-1) * $limit) +1;

        foreach ($record->result() as $row) {
            $aksi = '';
            $status = ($row->STATUS == 1) ? 'Berhasil' : 'Gagal';
            $rows[$no] = array(
                'NO' => $no,
                'TIPE_JOB' => $row->TIPE_JOB,
                'PESAN' => $row->PESAN,
                'CD_DATE' => $row->CD_DATE,
                'STATUS' => $status
            );
            $no++;
        }
        return array('total' => $total, 'rows' => $rows);
    }

    public function options_tipe_job() {
        $options = array();
        $options[''] = '--Pilih Tipe Job --';
        $options['EMAIL_APPROVE'] = 'Email Approve';
        $options['EMAIL_KIRIM'] = 'Email Kirim';
        $options['KURS_KTBI'] = 'Kurs KTBI';

        return $options;
    }

    public function options_status_job() {
        $options = array();
        $options[''] = '--Pilih Status Job --';
        $options['1'] = 'Berhasil';
        $options['2'] = 'Gagal';

        return $options;
    }

    public function get_data_email() {
        $query = "SELECT TIPE_JOB,MAX(CD_DATE) AS CD_DATE, PESAN ,STATUS
                    FROM MONITORING_JOB
                    WHERE TIPE_JOB NOT IN ('KURS_JISDOR','KURS_KTBI','MAX_PEMAKAIAN','KOMP_ALPHA')
                    GROUP BY TIPE_JOB
                    ORDER BY TIPE_JOB";
        $sql = $this->db->query($query);

        return $sql->result_array();
    }

    public function get_kurs_ktbi() {
        $last_update = "";
        $arr = array();
        $q1 = "SELECT COUNT(*) AS EXIST FROM MONITORING_JOB
                WHERE DATE_FORMAT(CD_DATE,'%Y-%m-%d') = DATE_FORMAT(NOW(),'%Y-%m-%d')
                AND TIPE_JOB IN ('KURS_KTBI')";
        
        $sql1 = $this->db->query($q1)->row();
        if($sql1->EXIST > 0) {
            $query =   "SELECT * FROM MONITORING_JOB 
                        WHERE DATE_FORMAT(CD_DATE,'%Y-%m-%d') = DATE_FORMAT(NOW(),'%Y-%m-%d')
                        AND TIPE_JOB IN ('KURS_KTBI')";
        } else {
            $last_update = "Last Update : ";
            $date = date('Y-m-d', strtotime('-1 day'));
            $query =   "SELECT * FROM MONITORING_JOB 
                        WHERE DATE_FORMAT(CD_DATE,'%Y-%m-%d') = DATE_FORMAT('$date','%Y-%m-%d')
                        AND TIPE_JOB IN ('KURS_KTBI')";
        }
        $sql = $this->db->query($query)->result_array();

        if($sql[0]['STATUS'] == 2) {
            $arr['TIPE_JOB'] = $sql[1]['TIPE_JOB'];
            $arr['PESAN'] = $sql[1]['PESAN'];
            $arr['CD_DATE'] = $last_update.$sql[1]['CD_DATE'];
            $arr['STATUS'] = $sql[1]['STATUS'];
        } else {
            $arr['TIPE_JOB'] = $sql[0]['TIPE_JOB'];
            $arr['PESAN'] = $sql[0]['PESAN'];
            $arr['CD_DATE'] = $last_update.$sql[0]['CD_DATE'];
            $arr['STATUS'] = $sql[0]['STATUS'];
        }

        return $arr;
    }

    public function get_kurs_jisdor() {
        $last_update = "";
        $arr = array();
        $q1 = "SELECT COUNT(*) AS EXIST FROM MONITORING_JOB
                WHERE DATE_FORMAT(CD_DATE,'%Y-%m-%d') = DATE_FORMAT(NOW(),'%Y-%m-%d')
                AND TIPE_JOB IN ('KURS_JISDOR')";
        
        $sql1 = $this->db->query($q1)->row();
        if($sql1->EXIST > 0) {
            $query =   "SELECT * FROM MONITORING_JOB 
                        WHERE DATE_FORMAT(CD_DATE,'%Y-%m-%d') = DATE_FORMAT(NOW(),'%Y-%m-%d')
                        AND TIPE_JOB IN ('KURS_JISDOR')";
        } else {
            $last_update = "Last Update : ";
            $date = date('Y-m-d', strtotime('-1 day'));
            $query =   "SELECT * FROM MONITORING_JOB 
                        WHERE DATE_FORMAT(CD_DATE,'%Y-%m-%d') = DATE_FORMAT('$date','%Y-%m-%d')
                        AND TIPE_JOB IN ('KURS_JISDOR')";
        }
        $sql = $this->db->query($query)->result_array();

        if($sql[0]['STATUS'] == 2) {
            $arr['TIPE_JOB'] = $sql[1]['TIPE_JOB'];
            $arr['PESAN'] = $sql[1]['PESAN'];
            $arr['CD_DATE'] = $last_update.$sql[1]['CD_DATE'];
            $arr['STATUS'] = $sql[1]['STATUS'];
        } else {
            $arr['TIPE_JOB'] = $sql[0]['TIPE_JOB'];
            $arr['PESAN'] = $sql[0]['PESAN'];
            $arr['CD_DATE'] = $last_update.$sql[0]['CD_DATE'];
            $arr['STATUS'] = $sql[0]['STATUS'];
        }

        return $arr;
    }

    public function get_data() {
        $query = "SELECT 
                    TIPE_JOB, MAX(CD_DATE) AS CD_DATE, PESAN ,STATUS
                    FROM MONITORING_JOB
                    WHERE TIPE_JOB IN ('MAX_PEMAKAIAN','KOMP_ALPHA')
                    GROUP BY TIPE_JOB
                    ORDER BY TIPE_JOB";

        $sql = $this->db->query($query);
        return $sql->result_array();
    }
}

/* End of file master_level1_model.php */
/* Location: ./application/modules/unit/models/master_level1_model.php */