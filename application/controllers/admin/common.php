<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//common
require 'base.php';
class Common extends Base {
    public function __construct(){
        parent::__construct();
        parent::block_unauthorized();
    }
    
    public function get_menu_sl() {
        try{
            // washale where nawili da daabrunebs yvela menus
            $query = $this->db->query('SELECT m.id value, m.desc_ka text FROM phr_menu m ');
            
            $result = $query->result_array();
            
            $this->output->set_content_type('application/json')->set_output(json_encode(array('data' => $result, 'success'=>true)));
        }
        catch (Exception $ex) {
            $this->output->set_content_type('application/json')->set_output(json_encode(array('msg' => $ex->getMessage(), 'success'=>false)));
        }
    }
    
    public function get_menu_type_sl() {
        try{
            $query = $this->db->query('SELECT mt.id value, mt.name text FROM phr_menu_type mt');
            
            $result = $query->result_array();
            
            $this->output->set_content_type('application/json')->set_output(json_encode(array('data' => $result, 'success'=>true)));
        }
        catch (Exception $ex) {
            $this->output->set_content_type('application/json')->set_output(json_encode(array('msg' => $ex->getMessage(), 'success'=>false)));
        }
    }

    public function get_content_status_sl() {
        try{
            $query = $this->db->query('SELECT cs.id value, cs.name text FROM phr_content_status cs');
            
            $result = $query->result_array();
            
            $this->output->set_content_type('application/json')->set_output(json_encode(array('data' => $result, 'success'=>true)));
        }
        catch (Exception $ex) {
            $this->output->set_content_type('application/json')->set_output(json_encode(array('msg' => $ex->getMessage(), 'success'=>false)));
        }
    }
    
    public function get_content_type_sl() {
        try{
            $query = $this->db->query('SELECT ct.id value, ct.name text FROM phr_content_type ct');
            
            $result = $query->result_array();
            
            $this->output->set_content_type('application/json')->set_output(json_encode(array('data' => $result, 'success'=>true)));
        }
        catch (Exception $ex) {
            $this->output->set_content_type('application/json')->set_output(json_encode(array('msg' => $ex->getMessage(), 'success'=>false)));
        }
    }

}
