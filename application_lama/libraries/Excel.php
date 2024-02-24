<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');  
  
require_once FCPATH . 'assets/plugin/phpexcel/PHPExcel.php';
  
class Excel extends PHPExcel {
    public function __construct() {
        parent::__construct();
    }
}