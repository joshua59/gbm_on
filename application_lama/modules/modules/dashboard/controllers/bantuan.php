<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class bantuan extends MX_Controller
{
  private $_title = 'Bantuan';
  private $_limit = 10;
  private $_module = 'dashboard/bantuan';
  private $_urlgetfile = "";
  private $_url_movefile = "";  

  function __construct()
  {
    parent::__construct();

        // Protection
        hprotection::login();

        /* Load Global Model */
        $this->load->model('setting_app_model','tbl_get');
        $this->_url_movefile = $this->laccess->url_serverfile()."move";
        $this->_urlgetfile = $this->laccess->url_serverfile()."geturl";        
  }

  public function index() {
    // Load Modules
    $this->laccess->update_log();
    $this->load->module("template/asset");

    // Memanggil plugin JS Crud    
    $this->asset->set_plugin(array('crud'));
    $this->asset->set_plugin(array('highchart'));
    $this->asset->set_plugin(array('jquery'));
    $this->asset->set_plugin(array('bootstrap-rakhmat'));
    $this->asset->set_plugin(array('font-awesome'));
    // $this->asset->set_plugin(array('bootstrap-rakhmat', 'font-awesome'));

    // $data = $this->get_level_user(); 
    
    $data["url_getfile"] = $this->_urlgetfile;
    $data['default'] = $this->tbl_get->data_upload();

    $data['page_title'] = '<i class="icon-laptop"></i> ' . $this->_title;
    $data['page_content'] = $this->_module . '/main';
    $data['data_sources'] = base_url($this->_module . '/load');
    echo Modules::run("template/admin", $data);
}

public function get_data_faq(){
    $data = $this->tbl_get->get_faq($data);
    echo json_encode($data);
}

}

/* End of file wilayah.php */
/* Location: ./application/modules/wilayah/controllers/wilayah.php */

