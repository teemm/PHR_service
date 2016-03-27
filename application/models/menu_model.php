<?php

class Menu_model extends CI_Model {
    var $id = null;
    var $parent_id = null;
    var $menu_type_id = null;
    var $desc_ka = null;
    var $desc_en = null;
    var $desc_ru = null;
    
    public function __construct() {
        parent::__construct();
    }
    
    private function empty_model() {
        $this->id = null;
        $this->parent_id = null;
        $this->menu_type_id = null;
        $this->desc_ka = null;
        $this->desc_en = null;
        $this->desc_ru = null;
    }
    
    public function save($param){
        $this->empty_model();
        
        if (!is_empty($param['id'])) {$this->id = $param['id'];}
        if (!is_empty($param['parent_id'])) {$this->parent_id = $param['parent_id'];}
        if (!is_empty($param['menu_type_id'])) {$this->menu_type_id = $param['menu_type_id'];}
        if (!is_empty($param['desc_ka'])) {$this->desc_ka = $param['desc_ka'];}
        if (!is_empty($param['desc_en'])) {$this->desc_en = $param['desc_en'];}
        if (!is_empty($param['desc_ru'])) {$this->desc_ru = $param['desc_ru'];}

        if (!is_empty($this->id)){
            $this->db->where('id', $this->id);
            $this->db->update('menu', $this);
            return $this->id;
        }  else {
            $this->db->insert('menu', $this);
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
        $query = $this->db->get_where('menu', $array);
        return $query->first_row('array');
    }
    
    function delete($id) {
        $this->db->delete('menu', array('id' => $id));
    }
    

    public function deleteMenu($id) {
        $query = $this->db->query('SELECT '.'c.id, mc.menu_id, c.image '
            .' FROM phr_content c '
            .' INNER JOIN phr_menu_content mc ON mc.content_id=c.id '
            .' WHERE 1=1 '
            .' AND mc.menu_id='.$this->db->escape($id)
        );
        $result = $query->result_array();

        if ($result) {
            foreach ($result as $content) {
                $image = FCPATH.$content['image'];
                $image = realpath($image);

                if ($image) {
                    if (!is_dir($image)) unlink($image);
                }

                $this->db->delete('content', array('id' => $content['id']));
            }

            return $this->db->delete('menu', array('id' => $id));
        } else {
            return $this->db->delete('menu', array('id' => $id));
        }
    }
}
