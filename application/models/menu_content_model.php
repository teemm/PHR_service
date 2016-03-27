<?php

class Menu_Content_model extends CI_Model {
    var $id = null;
    var $menu_id = null;
    var $content_id = null;
    
    public function __construct() {
        parent::__construct();
    }
    
    private function empty_model() {
        $this->id = null;
        $this->menu_id = null;
        $this->content_id = null;
    }
    
    public function save($param){
        $this->empty_model();
        
        if (!is_empty($param['id'])) {$this->id = $param['id'];}
        if (!is_empty($param['menu_id'])) {$this->menu_id = $param['menu_id'];}
        if (!is_empty($param['content_id'])) {$this->content_id = $param['content_id'];}

        if (!is_empty($this->id)){
            $this->db->where('id', $this->id);
            $this->db->update('menu_content', $this);
            return $this->id;
        }  else {
            $this->db->insert('menu_content', $this);
            return $this->db->insert_id();
        }
    }
    
    function get($id, $menu_id, $content_id) {
        $array = array();
        if (!is_empty($id)){
            $array['id'] = $id;
        }
        if (!is_empty($menu_id)){
            $array['menu_id'] = $menu_id;
        }
        if (!is_empty($content_id)){
            $array['content_id'] = $content_id;
        }
        if (is_empty($array)){
            return NULL;
        }
        $query = $this->db->get_where('menu_content', $array);
        return $query->first_row('array');
    }

    function get_last($menu_id) {
        $query = $this->db->query('SELECT mc.menu_id, c.id content_id, c.content_type_id, c.content_status_id '
            .' FROM phr_menu_content mc '
            .' INNER JOIN phr_content c ON c.id=mc.content_id '
            .' WHERE 1=1 '
            .(!is_empty($menu_id) ? ' AND mc.menu_id='.$menu_id : '')
            .' ORDER BY mc.id DESC'
            .' LIMIT 0, 1');
            
        return $query->first_row('array');
    }
    
    function delete($id) {
        $this->db->delete('menu_content', array('id' => $id));
    }
    
}
