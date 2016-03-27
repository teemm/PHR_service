<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//admin
require 'base.php';
class Home extends Base {
    public function __construct(){
        parent::__construct();
        parent::block_unauthorized();
    }
    
    public function index(){
        parent::load_view('admin/home/index');
    }
    
}
