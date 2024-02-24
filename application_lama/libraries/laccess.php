<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class laccess {

    public function __construct() {
        $CI = &get_instance();
        $CI->load->library('session');
    }

    private $role;

    private function otoritas_data($key) {
        $CI = &get_instance();
        $CI->db->from('M_OTORITAS_MENU a');
        $CI->db->join('M_MENU b', 'a.MENU_ID = b.MENU_ID');
        $CI->db->where_condition($key);
        return $CI->db->get();
    }

    public function check($list_modul = array()) {
        $CI = &get_instance();

        $roles_id = $CI->session->userdata('roles_id');
        

        if (count($list_modul) == 0) {
            $segment1 = $CI->uri->segment(1);
            $segment2 = $CI->uri->segment(2);

            $url = $segment1;
            if ($segment2)
                $url .= '/' . $segment2;

            $roles = $this->otoritas_data(array('a.ROLES_ID' => $roles_id, "b.MENU_URL = '" . strtolower($url) . "'" => null));
            
            if ($roles->num_rows() > 0) {
                $otoritas = $roles->row();
                $this->role[$url] = array(
                    'view' => $otoritas->IS_VIEW,
                    'add' => $otoritas->IS_ADD,
                    'edit' => $otoritas->IS_EDIT,
                    'delete' => $otoritas->IS_DELETE,
                    'approve' => $otoritas->IS_APPROVE
                );
                // $this->update_log(strtolower($url));
            } else {
                redirect('dashboard');
                exit;
            }
        } else {
            foreach ($list_modul as $list) {
                $url = $list;

                $roles = $this->otoritas_data(array('a.ROLES_ID' => $roles_id, 'b.MENU_URL' => $url));
                if ($roles->num_rows() > 0) {
                    $otoritas = $roles->row();
                    $this->role[$url] = array(
                       'view' => $otoritas->IS_VIEW,
                        'add' => $otoritas->IS_ADD,
                        'edit' => $otoritas->IS_EDIT,
                        'delete' => $otoritas->IS_DELETE,
                        'approve' => $otoritas->IS_APPROVE
                    );
                }
            }
        }
    }

    public function otoritas($id = '', $redirect = false, $modul = '') {
        $CI = &get_instance();

        if (!empty($id)) {

            if (empty($modul)) {
                $segment1 = $CI->uri->segment(1);
                $segment2 = $CI->uri->segment(2);
                $url = $segment1;
                if ($segment2)
                    $url .= '/' . $segment2;
            } else {
                $url = $modul;
            }
            
            if (isset($this->role[$url][$id]) && $this->role[$url][$id] == 't') {
                $otoritas = true;
            } else {
                $otoritas = false;
            }
        } else {
            $otoritas = false;
        }

        if ($otoritas) {
            return true;
        } else {
            if ($redirect) {
                $this->redirect();
            } else {
                return false;
            }
        }
    }

    public function redirect() {
        redirect('dashboard');
    }

    public function update_log(){
        $CI = &get_instance();
        $segment1 = $CI->uri->segment(1);
        $segment2 = $CI->uri->segment(2);

        $url = $segment1;
        if ($segment2)
            $url .= '/' . $segment2;

        $url = strtolower($url);

        $tdate = date("mdY_His");
        $token_id = md5($CI->session->userdata('session_id').$userId.$tdate.rand(1000,9999));
        
        $data = array(
                 'TOKEN' => $token_id,
                 'USERNAME' => $CI->session->userdata('user_name'),
                 'LOG_DATE' => '1', //$this->session->userdata('log_date'),
                 'IP_ADDRESS' => $CI->session->userdata('ip_address'),
                 'USER_AGENT' => $CI->session->userdata('xuser_agent'),
                 'PLATFORM' => $CI->session->userdata('xplatform'),
                 'ID_SESSION' => $CI->session->userdata('x_session'), //$CI->session->userdata('session_id'),
                 'LOGGED' => '2', 
                 'KET' => 'Akses menu '.$url,
                 );

        // $CI->db->insert('M_USER_LOG', $data);

        $query = "call SAVE_USER_LOG(
            '".$data['TOKEN']."',
            '".$data['USERNAME']."',
            '".$data['LOG_DATE']."',
            '".$data['IP_ADDRESS']."',
            '".$data['USER_AGENT']."',
            '".$data['PLATFORM']."',
            '".$data['ID_SESSION']."',
            '".$data['LOGGED']."',
            '".$data['KET']."')";
        
        $data = $CI->db->query($query);
        $res = $data->result();

        // $data->next_result(); // Dump the extra resultset.
        // $data->free_result(); // Does what it says.

        // return $data->result();
        $CI->db->close();

        if ($res[0]->RCDB == 'RC00'){
            $login_message = 'User sudah login di perangkat lain'; //$res[0]->PESANDB;
            // $CI->session->sess_destroy();
            $CI->session->set_flashdata('login_message', $login_message);
            redirect('login/relogin');
        } 
    }


    public function setRp($rp){
        $x = str_replace('.','',$rp);
        $x = str_replace(',','.',$x);
        return $x;
    }

    public function setTgl($tgl){
        $x = str_replace('-','',$tgl);
        return $x;
    }

    public function ai($data){
        // $q = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
        $q = stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES)));
        return $q;
    }

    public function is_prod(){
        return false;
    }

    public function url_serverfile(){
        return "http://10.1.18.201:8888/";
    }

    public function get_file_prod($modul='', $nama_file=''){
        $rest = '';
        if (($nama_file) && ($this->is_prod())){
            $exec = "curl '".$this->url_serverfile()."geturl?callback=jQuery110203035839018245421_1522737324950&modul=".$modul."&filename=".$nama_file."&_=1522737324951'";
            $cari = shell_exec($exec); 
            $ada = 'window';  
            if (strpos($cari, $ada) !== false) {
                $rest = 'Berhasil';
            } 
        } 
        return $rest;
    }

    public function post_file_prod($modul='', $nama_file=''){
        $rest = '';
        if (($nama_file) && ($this->is_prod())){

            $url = $this->url_serverfile()."move";

            $fields = array(
                'filename' => urlencode($nama_file),
                'modul' => urlencode($modul)
            );

            $fields_string = '';
            //url-ify the data for the POST
            foreach($fields as $key=>$value) {
                $fields_string .= $key.'='.$value.'&'; 
            }
            rtrim($fields_string, '&');

            //open connection
            $ch = curl_init();

            //set the url, number of POST vars, POST data
            curl_setopt($ch,CURLOPT_URL, $url);
            curl_setopt($ch,CURLOPT_POST, count($fields));
            curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

            //execute post
            $result = curl_exec($ch);

            //close connection
            curl_close($ch);

            if ($result==1){
                $rest = '';
            } else {
                $rest = 'Gagal upload file ke server, code : 201 ';
            }
        } 
        return $rest;
    }


    public function version($key) {
        $CI = &get_instance();
        $sql = "SELECT VALUE_SETTING FROM DATA_SETTING WHERE KEY_SETTING = 'GBM_VERSION'";
        $q = $CI->db->query($sql)->row();
        return $q->VALUE_SETTING;
    }

}
