<?php

class File_model extends CI_Model {
    var $id = null;
    var $name = null;
    var $path = null;
    var $type = null;
    var $create_time = null;
    
    public function __construct() {
        parent::__construct();
    }
    
    private function empty_model() {
        $this->id = null;
        $this->name = null;
        $this->path = null;
        $this->type = null;
        $this->create_time = null;
    }
    
    public function save($param){
        $this->empty_model();
        
        if (!is_empty($param['id'])) {$this->id = $param['id'];}
        if (!is_empty($param['name'])) {$this->name = $param['name'];}
        if (!is_empty($param['path'])) {$this->path = $param['path'];}
        if (!is_empty($param['type'])) {$this->type = $param['type'];}
        if (!is_empty($param['create_time'])) {$this->create_time = $param['create_time'];}
        
        if (!is_empty($this->id)){
            $this->db->where('id', $this->id);
            $this->db->update('file', $this);
            return $this->id;
        }  else {
            $this->db->insert('file', $this);
            return $this->db->insert_id();
        }
    }
    
    function get($id, $name) {
        $array = array();
        if (!is_empty($id)){
            $array['id'] = $id;
        }
        if (!is_empty($name)){
            $array['name'] = $name;
        }
        if (is_empty($array)){
            return NULL;
        }
        $query = $this->db->get_where('file', $array);
        return $query->first_row('array');
    }
    
    function delete($id) {
        $this->db->delete('file', array('id' => $id));
    }
    
}
