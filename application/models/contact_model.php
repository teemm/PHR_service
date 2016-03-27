<?php

class Contact_model extends CI_Model {
    var $id = null;
    var $from = null;
    var $subject = null;
    var $message = null;
    var $create_time = null;
    var $update_time = null;
    var $send_status = null;
    
    public function __construct() {
        parent::__construct();
    }
    
    private function empty_model() {
        $this->id = null;
        $this->from = null;
        $this->subject = null;
        $this->message = null;
        $this->send_status = null;
    }
    
    public function save($param){
        $this->empty_model();
        
        if (!is_empty($param['from'])) {$this->from = $param['from'];}
        if (!is_empty($param['subject'])) {$this->subject = $param['subject'];}
        if (!is_empty($param['message'])) {$this->message = $param['message'];}
        if (!is_empty($param['create_time'])) {$this->create_time = $param['create_time'];}
        if (!is_empty($param['update_time'])) {$this->update_time = $param['update_time'];}
        if (!is_empty($param['send_status'])) {$this->send_status = $param['send_status'];}

        $this->db->insert('contact', $this);
        return $this->db->insert_id();
    }
    
    function get($id) {
        $array = array();
        if (!is_empty($id)){
            $array['id'] = $id;
        }
        if (is_empty($array)){
            return NULL;
        }
        $query = $this->db->get_where('menu', $array);
        return $query->first_row('array');
    }
    
    function delete($id) {
        $this->db->delete('menu', array('id' => $id));
    }
    
}
