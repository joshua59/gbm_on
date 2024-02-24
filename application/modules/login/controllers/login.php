<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * @package Login
 * @controller Login
 */
class login extends MX_Controller {
    public function __construct() {
        parent::__construct();
		
		$this->load->model('user_model');
        $this->load->library('user_agent');
        $this->load->library('session');  
    }

    public function index() {
        hprotection::login(false);
		$this->load->module("template/asset");
        $this->asset->set_plugin(array('crud'));
        $data['page_content'] = 'login/form';
        $data['form_action'] = base_url('login/run');
		$data['form_reset'] = base_url('login/reset_session');
        echo Modules::run("template/login", $data);
    }

    public function reset() {
        hprotection::login(false);
        $this->load->module("template/asset");
        $this->asset->set_plugin(array('crud'));
        $data['user_name_reset'] = $this->session->userdata('user_name_reset');
        $data['password_reset'] = $this->session->userdata('password_reset');
        $data['page_content'] = 'login/form_reset';
        $data['form_action'] = base_url('login/proses_password');
        echo Modules::run("template/login", $data);
    }

    public function proses_password() {
        $this->form_validation->set_rules('password_old', 'Password Lama', 'trim|required|max_length[30]|callback_password_check_db');
        $this->form_validation->set_rules('password_new1', 'Password Baru', 'trim|required|min_length[5]|max_length[30]|matches[password_new2]|callback_password_check[password_new1]');
        $this->form_validation->set_rules('password_new2', 'Konfirmasi Password Baru', 'trim|required|min_length[5]|max_length[30]|');
        $this->form_validation->set_message('matches', 'Kedua Password Baru tidak cocok.');

        if ($this->form_validation->run($this)) {
            $message = 'Proses ubah password gagal';
            $passBaru = md5($this->input->post('password_new1'));
            $id = $this->session->userdata('user_name_reset');
            $data_user = array();
            $data_user['PWD_USER'] = $passBaru;
            $data_user['UD_USER'] = date('Y-m-d');
            if ($this->user_model->set_ubah_password($data_user, $id)) {
                // $message = array(true, 'Proses Berhasil', 'Proses update data berhasil.', '');
                $message = 'Proses ubah password berhasil, silahkan login dengan user dan password baru anda';
                $this->session->set_flashdata('login_message', $message);
                redirect('login');
            } 
        } else {
            // $message = array(false, 'Proses gagal', validation_errors(), '');
            $message = validation_errors();
        }
        $this->session->set_flashdata('login_message', $message);
        redirect('login/reset');
        // echo json_encode($message, true);
    }

    public function run() {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        $login_status = false;
        $login_message = '';
        $ldap_cek = false;
        $ldap_user = '';
        if ($this->form_validation->run($this)) {
            if(isset($_POST['username']) && isset($_POST['password'])){
                
                $username = $this->input->post('username');
                $password = $this->input->post('password');

                $domain = strtolower(substr($username, 0, strrpos($username, "\\")));
                $username = substr($username, strrpos($username, "\\") + 1, strlen($username) - strrpos($username, "\\"));

                $adServer = "ldap://10.1.8.20";
                $ldap = ldap_connect($adServer);

                // $ldaprdn = 'pusat' . "\\" . $username;
                $ldaprdn = $domain . "\\" . $username;

                ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
                ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

                $bind = @ldap_bind($ldap, $ldaprdn, $password);
                if ($bind) {
                    $ldap_user = $username;
                    $ldap_cek = true;
                    $filter="(sAMAccountName=$username)";
                    // $filter = "(&(objectCategory=person)(sAMAccountName=*))";

                    $result = ldap_search($ldap,"DC=".$domain.",DC=corp,DC=pln,DC=co,DC=id",$filter);
                    // ldap_sort($ldap,$result,"sn");
                    $info = ldap_get_entries($ldap, $result);
                    // var_dump($info); die;

                    for ($i=0; $i<$info["count"]; $i++)
                    {
                        // if($info['count'] > 1)
                        //     break;

                        // echo "<p>".$i." You are accessing <strong> ". $info[$i]["sn"][0] .", " . $info[$i]["givenname"][0] ."</strong><br /> (" . $info[$i]["samaccountname"][0] .") email= ".$info[$i]["mail"][0]."  NIK= ".$info[$i]["employeenumber"][0]." </p>\n";
                        // echo '<pre>';
                        // // var_dump($info);
                        // echo '</pre>'; 
                        // echo '<br><br>';

                        $userDn = $info[$i]["distinguishedname"][0]; 
                        $ldap_user = $info[$i]["samaccountname"][0];
                        $ldap_nik = $info[$i]["employeenumber"][0];
                        $ldap_email = $info[$i]["mail"][0]; 
                    }
                    // echo '<br><br> TOTAL : '.$i;
                    @ldap_close($ldap);
                    // die;
                    //echo 'Authentication Succed';
                    if (!$ldap_user){
                        $ldap_user = $username;    
                    }
					$data_user = $this->user_model->dataldap($ldap_user, $ldap_email);
                } 
                else {
					$username = $this->input->post('username');
					$password = $this->input->post('password');
					$data_user = $this->user_model->data($username, $password);
                    $ldap_user ='';
                    //echo 'Authentication Failed';
                }
            }
            
			$login_message = 'Maaf, Username dan Password tidak sesuai.';  

            if ($data_user){
                if ($data_user->num_rows() > 0) {
                    $this->session->set_userdata('log_date', date("Y-m-d H:i:s"));
                    $user = $data_user->row();
    				if($user->RCDB=='RC01'){
    					$login_status = true;
                        $info_login = array(
                            'login_status' => TRUE,
                            'user_id' => $user->ID_USER,
                            'roles_id' => $user->ROLES_ID,
                            'user_name' => $user->USERNAME,
    						'level_user' => $user->LEVEL_USER,
    						'kode_level' =>$user->KODE_LEVEL,
                            'ldap_cek' =>$ldap_cek,
                            'ldap_user' =>$ldap_user,
                            'ldap_domain' =>$domain,
                            'ldap_password' =>$password,
                            'nama_user' => $user->NAMA_USER,
                            'in_berita' => 'Hide Berita',
                        );
    					$this->session->set_userdata($info_login);
                        $this->generateToken($user->USERNAME);
                    } else if ($user->RCDB=='RC99'){
                        $info = array(
                            'user_name_reset' => $username,
                            'password_reset' => $password,
                        );
                        $this->session->set_userdata($info);  
                        $this->session->set_flashdata('login_message', $user->PESANDB);

                        redirect('login/reset');                    

                    }else{
                       $login_message = $user->PESANDB; 
                    }
                } 
            } else {
                if ($ldap_user){
                    $login_message = 'Maaf, Username anda tidak terdaftar di sistem GBM, silahkan hubungi helpdesk untuk info lebih lanjut'; 
                } else if (empty($domain)){
                    $login_message = 'Maaf, Silahkan login dengan user email korporat anda.';  
                } else {
                    $login_message = 'Maaf, Username dan Password tidak sesuai.';    
                }
            }
        } else {
            $login_message = validation_errors();
        }

        if ($login_status) {
            redirect('dashboard');
        } else {
            $this->session->set_flashdata('login_message', $login_message);
            redirect('login');
        }
    }

    public function stop() {
        $tdate = date("mdY_His");
        $token_id = md5($this->session->userdata('session_id').$userId.$tdate.rand(1000,9999));
        $data = array(
                 'TOKEN' => $token_id,
                 'USERNAME' => $this->session->userdata('user_name'),
                 'LOG_DATE' => '1',//$this->session->userdata('log_date'),
                 'IP_ADDRESS' => $this->session->userdata('ip_address'),
                 'USER_AGENT' => $this->session->userdata('xuser_agent'),
                 'PLATFORM' => $this->session->userdata('xplatform'),
                 'ID_SESSION' => $this->session->userdata('x_session'), //$this->session->userdata('session_id'),
                 'LOGGED' => '0', 
                 'KET' => 'Logout',
                 );

        $rest = $this->user_model->save_token($data);

		$this->user_model->logout($this->session->userdata('user_id'));
        $this->session->sess_destroy();
        redirect('login');
    }

    public function generateToken($username){

        if ($this->agent->is_browser()){
            $agent = $this->agent->browser().' '.$this->agent->version();
        }
        elseif ($this->agent->is_robot()){
            $agent = $this->agent->robot();
        }
        elseif ($this->agent->is_mobile()){
            $agent = $this->agent->mobile();
        }
        else{
            $agent = 'Unidentified User Agent';
        }  

        $tdate = date("mdY_His");
        $token_id = md5($this->session->userdata('session_id').$userId.$tdate.rand(1000,9999));
        $x_session = md5($this->session->userdata('session_id').$userId.rand(10000,99999));
        $data = array(
                 'TOKEN' => $token_id,
                 'USERNAME' => $username,
                 'LOG_DATE' => '0',//$this->session->userdata('log_date'),
                 'IP_ADDRESS' => $this->session->userdata('ip_address'),
                 'USER_AGENT' => $agent,
                 'PLATFORM' => $this->agent->platform(),
                 'ID_SESSION' => $x_session, //$this->session->userdata('session_id'),
                 'LOGGED' => '1', 
                 'KET' => 'Login',
                 );

        // if (!$this->user_model->save_token($data)){
        //     $token_id = 'Gagal generate token';
        // }
        
        $rest = $this->user_model->save_token($data);

        $info = array(
            'xuser_agent' => $agent,
            'xplatform' => $this->agent->platform(),
            'token' => $token_id,
            'x_session' => $x_session, 
        );
        $this->session->set_userdata($info);

        return $token_id;
    }

    public function relogin() {
        if ($this->session->userdata('login_status') !== FALSE) {
            $this->session->sess_destroy();
            hprotection::login(false);
            $this->load->module("template/asset");
            $this->asset->set_plugin(array('crud'));
            $data['page_content'] = 'login/form_relogin';
            $data['form_action'] = base_url('login/run');
            $data['form_reset'] = base_url('login/reset_session');
            echo Modules::run("template/login", $data);
        } else {
            redirect('login');
        }         
    }

	public function reset_session(){
		$this->form_validation->set_rules('email', 'Email','required');
		if ($this->form_validation->run($this)) {
			$email = $this->input->post('email');
			$data_user = $this->user_model->reset($email);
			if ($data_user[0]->RCDB == 'RC00')
				$message = array(false, 'Proses Gagal', $data_user[0]->PESANDB, '');
			else
				$message = array(true, 'Proses Berhasil', $data_user[0]->PESANDB, '');
		}else {
            $message = array(false, 'Proses gagal', validation_errors(), '');
        }
		echo json_encode($message, true);
	}
	
}

/* End of file login.php */
/* Location: ./application/modules/login/controllers/login.php */
