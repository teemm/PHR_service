<?php

class System_User_model extends CI_Model {
    var $id = null;
    var $user_name = null;
    var $password = null;
    
    public function __construct() {
        parent::__construct();
    }
    
    private function empty_model() {
        $this->id = null;
        $this->user_name = null;
        $this->password = null;
    }
    
    public function save($param){
        try{
            $this->empty_model();
            
            if (!is_empty($param['id'])) {$this->id = $param['id'];}
            if (!is_empty($param['user_name'])) {$this->user_name = $param['user_name'];}
            if (!is_empty($param['password'])) {$this->password = $param['password'];}

            if (!is_empty($this->id)){
                if (!$this->password){
                    $_model = array(
                        'id'=>$this->id,
                        'user_name'=>$this->user_name
                    );
                }else{
                    $_model = array(
                        'id'=>$this->id,
                        'user_name'=>$this->user_name,
                        'password'=>$this->password
                    );
                }
                $this->db->where('id', $_model['id']);
                $this->db->update('system_user', $_model);
                return $this->id;
            }  else {
                $this->db->insert('system_user', $this);
                return $this->db->insert_id();
            }
            
        }
        catch (Exception $ex) {
            throw new Exception($ex->getMessage());
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
        $query = $this->db->get_where('system_user', $array);

        return $query->first_row('array');
    }
    
    function get_login_system_user($user_name, $password) {
        $query = $this->db->get_where('system_user',
                array('user_name' => $user_name, 'password' => $password));

        return $query->first_row('array');
    }
    
    function delete($id) {
        $query = $this->db->delete('system_user', array('id' => $id));
    }
}
