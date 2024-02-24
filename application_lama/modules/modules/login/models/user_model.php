<?php

/**
 * @package Login
 * @modul User
 */
class user_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table1 = 'M_USER';

    private function _key($key) {
        if (!is_array($key)) {
            $key = array('ID_USER' => $key);
        }
        return $key;
    }

    public function data($user, $password) {
        $in_user = $this->laccess->ai($user);
        $in_password = $this->laccess->ai($password);

		$query = "call LOGIN('".$in_user."', '".$in_password."')";
		$data = $this->db->query($query);
		$this->db->close();

		return $data;
    }
	
	public function dataldap($email, $username) {
        $in_email = $this->laccess->ai($email);
        $in_username = $this->laccess->ai($username);

        $query = "call LOGIN_LDAP('".$in_email."', '".$in_username."')";
		$data = $this->db->query($query);
		$this->db->close();

		return $data;
    }
	
	public function logout($iduser){
        $in_iduser = $this->laccess->ai($iduser);
        
		$this->db->where("ID_USER", $in_iduser);
		$this->db->update($this->_table1, array("IS_LOGIN"=> "0"));
	}

	public function reset($email){
        $in_email = $this->laccess->ai($email);
		$query = "call RESET_SESSION('$in_email')";
		$data = $this->db->query($query);
		
		return $data->result();
	}
	
    public function encrypt($str) {
        return md5($str);
    }

    public function save_token($data) {
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
        
        $data = $this->db->query($query);
        $res = $data->result();

        // $data->next_result(); // Dump the extra resultset.
        // $data->free_result(); // Does what it says.

        // return $data->result();
        $this->db->close();
        return $res;
    }

    public function set_ubah_password($data, $key) {
        $key = array('USERNAME' => $key);
        $this->db->trans_begin();

        $this->db->update($this->_table1, $data, $key);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
}

/* End of file user.php */
/* Location: ./application/modules/login/models/user.php */