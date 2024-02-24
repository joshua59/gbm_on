<?php 

class grafik_user_model extends CI_Model{
    
    public function __construct(){
        parent::__construct();
    }

    public function mget_grafik($bln,$thn){

        $array = [];
        $arr1 = [];

        $level_user = $this->session->userdata('level_user');
        $kode_level = $this->session->userdata('kode_level');

        $sql = "CALL GRAFIK_USER('$bln','$thn','$level_user','$kode_level')";

        $query = $this->db->query($sql)->result_array();

        foreach($query as $value) 
        {
            //array untuk menampung value yang akan ditampilkan pada grafik

            $array['name'] = $value['LEVEL_USER'];
            $array['data'] = [(int)$value["log_count"]];

            array_push($arr1,$array);

        }

        return $arr1;
    }

    // Change


    public function get_table($bln,$thn){

        $array = array();
        $level_user = $this->session->userdata('level_user');
        $kode_level = $this->session->userdata('kode_level');
        if($level_user == 0) {
            $kode_level = '';
        }
        $sql = "CALL GRAFIK_USER('$bln','$thn','$level_user','$kode_level')";
        $query = $this->db->query($sql);
        $this->db->close();
        
        return $query->result_array();
    }

    public function get_grafik_detail($bln,$thn,$name){
        $level_user = $this->session->userdata('level_user');
        $kode_level = $this->session->userdata('kode_level');
        $k = array();
        $sql = "CALL GRAFIK_USER_DETAIL('$bln','$thn','$level_user','$kode_level','$name')";
        $query = $this->db->query($sql)->result_array();
        $this->db->close();
        foreach ($query as $key) {
           $data = array(
                        'username' => $key['USERNAME'],
                        'total' => $key['TOTAL'],
                        'nama_regional' => $key['NAMA_REGIONAL'],
                        'level1' => $key['LEVEL1'],
                        'level2' => $key['LEVEL2'],
                        'level3' => $key['LEVEL3'],
                        'level4' => $key['LEVEL4']
                    );
           array_push($k,$data);
        }

        return $k;
    }

    function next_result()
    {
         if (is_object($this->conn_id))
         {
             return mysqli_next_result($this->conn_id);
         }
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

    public function exportList() {
        $bulan = "09";
        $tahun = "2019";
        $kode_level = $this->session->userdata('kode_level');
        $level_user = $this->session->userdata('level_user');
        
        $sql = "call GRAFIK_JML_USER('$bulan','$tahun' ,'$kode_level','$level_user')"; 
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}
