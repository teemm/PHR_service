<?php

class Video_model extends CI_Model {
    var $id = null;
    var $token = null;
    
    public function __construct() {
        parent::__construct();
    }
    
    private function empty_model() {
        $this->id = null;
        $this->token = null;
    }
    
    public function save($param){
        $this->empty_model();
        
        if (!is_empty($param['id'])) {$this->id = $param['id'];}
        if (!is_empty($param['token'])) {$this->token = $param['token'];}

        if (!is_empty($this->id)){
            $this->db->where('id', $this->id);
            $this->db->update('video', $this);
            return $this->id;
        }  else {
            $this->db->insert('video', $this);
            return $this->db->insert_id();
        }
    }
    
    function get($id) {
        $array = array();
        if (!is_empty($id)){
            $array['id'] = $id;
        }
        if (is_empty($array)){
            return NULL;
        }
        $query = $this->db->get_where('video', $array);
        return $query->first_row('array');
    }
    
    // depreciated ???
    function delete($id) {
        $this->db->delete('video', array('id' => $id));
    }


    public function deleteVideo($id) {
        return $this->db->delete('video', array('id' => $id));
    }
}
