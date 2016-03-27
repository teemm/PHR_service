<?php

class System_Message_model extends CI_Model {
    var $id = null;
    var $system_message_type_id = null;
    var $desc_ka = null;
    var $desc_en = null;
    var $desc_ru = null;
    
    public function __construct() {
        parent::__construct();
    }
    
    private function empty_model() {
        $this->id = null;
        $this->system_message_type_id = null;
        $this->desc_ka = null;
        $this->desc_en = null;
        $this->desc_ru = null;
    }
    
    public function save($param){
        $this->empty_model();
        
        if (!is_empty($param['id'])) {$this->id = $param['id'];}
        if (!is_empty($param['system_message_type_id'])) {$this->sys_message_type_id = $param['system_message_type_id'];}
        if (!is_empty($param['desc_ka'])) {$this->desc_ka = $param['desc_ka'];}
        if (!is_empty($param['desc_en'])) {$this->desc_ka = $param['desc_en'];}
        if (!is_empty($param['desc_ru'])) {$this->desc_ka = $param['desc_ru'];}

        if (!is_empty($this->id)){
            $this->db->where('id', $this->id);
            $this->db->update('system_message', $this);
            return $this->id;
        }  else {
            $this->db->insert('system_message', $this);
            return $this->db->insert_id();
        }
    }
    
    function get($id, $system_message_type_id) {
        $array = array();
        if (!is_empty($id)){
            $array['id'] = $id;
        }
        if (!is_empty($system_message_type_id)){
            $array['system_message_type_id'] = $system_message_type_id;
        }
        if (is_empty($array)){
            return NULL;
        }
        $query = $this->db->get_where('system_message', $array);
        return $query->first_row('array');
    }
    
    function get_system_error_msg($system_message_type_id) {
        $array = array();
        if (!is_empty($system_message_type_id)){
            $array['system_message_type_id'] = $system_message_type_id;
        }
        if (is_empty($array)){
            return NULL;
        }
        $query = $this->db->get_where('system_message', $array);
        $row = $query->first_row('array');
        if (!is_empty($row)){
            return $row['desc_ka'];
        }else{
            return NULL;
        }
    }
    
    function delete($id) {
        $this->db->delete('system_message', array('id' => $id));
    }
}
