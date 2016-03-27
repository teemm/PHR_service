<?php

class Content_model extends CI_Model {
    var $id = null;
    var $content_status_id = null;
    var $content_type_id = null;
    var $order = null;
    var $static_page_name = null;
    var $title_ka = null;
    var $title_en = null;
    var $title_ru = null;
    var $short_desc_ka = null;
    var $short_desc_en = null;
    var $short_desc_ru = null;
    var $desc_ka = null;
    var $desc_en = null;
    var $desc_ru = null;
    var $image = null;
    var $create_time = null;
    
    public function __construct() {
        parent::__construct();
    }
    
    private function empty_model() {
        $this->id = null;
        $this->content_status_id = null;
        $this->content_type_id = null;
        $this->order = NULL;
        $this->static_page_name = null;
        $this->title_ka = null;
        $this->title_en = null;
        $this->title_ru = null;
        $this->short_desc_ka = null;
        $this->short_desc_en = null;
        $this->short_desc_ru = null;
        $this->desc_ka = null;
        $this->desc_en = null;
        $this->desc_ru = null;
        $this->image = null;
        $this->create_time = null;
    }
    
    public function save($param){
        $this->empty_model();
        
        if (!is_empty($param['id'])) {$this->id = $param['id'];}
        if (!is_empty($param['content_status_id'])) {$this->content_status_id = $param['content_status_id'];}
        if (!is_empty($param['content_type_id'])) {$this->content_type_id = $param['content_type_id'];}
        if (!is_empty($param['static_page_name'])) {$this->static_page_name = $param['static_page_name'];}
        if (!is_empty($param['url'])) {$this->url = $param['url'];}
        if (!is_empty($param['order'])) {$this->order = $param['order'];}
        if (!is_empty($param['title_ka'])) {$this->title_ka = $param['title_ka'];}
        if (!is_empty($param['title_en'])) {$this->title_en = $param['title_en'];}
        if (!is_empty($param['title_ru'])) {$this->title_ru = $param['title_ru'];}
        if (!is_empty($param['short_desc_ka'])) {$this->short_desc_ka = $param['short_desc_ka'];}
        if (!is_empty($param['short_desc_en'])) {$this->short_desc_en = $param['short_desc_en'];}
        if (!is_empty($param['short_desc_ru'])) {$this->short_desc_ru = $param['short_desc_ru'];}
        if (!is_empty($param['desc_ka'])) {$this->desc_ka = $param['desc_ka'];}
        if (!is_empty($param['desc_en'])) {$this->desc_en = $param['desc_en'];}
        if (!is_empty($param['desc_ru'])) {$this->desc_ru = $param['desc_ru'];}
        if (!is_empty($param['image'])) {$this->image = $param['image'];}
        if (!is_empty($param['create_time'])) {$this->create_time = $param['create_time'];}

        if (!is_empty($this->id)){
            $this->db->where('id', $this->id);
            $this->db->update('content', $this);
            return $this->id;
        }  else {
            if (!$this->db->insert('content', $this)) {
                if (!is_empty($this->image) && file_exists(FCPATH.$this->image))
                    unlink(FCPATH.$this->image);
            }
            return $this->db->insert_id();
        }
    }
    
    function count($menu_id, $content_status_id, $content_type_id){
        $query = $this->db->query('SELECT COUNT(mc.id) content_count '
            .' FROM phr_menu_content mc '
            .' INNER JOIN phr_content c ON c.id=mc.content_id '
            .' WHERE 1=1 '
            .(!is_empty($menu_id) ? ' AND mc.menu_id='.$menu_id : '')
            .(!is_empty($content_status_id) ? ' AND c.content_status_id='.$content_status_id : '')
            .(!is_empty($content_type_id) ? ' AND c.content_type_id='.$content_type_id : ''));
        $content_count = $query->first_row('array');
        return $content_count;
    }
    
    function get_web_contents($content_id, $menu_id, $content_status_id, $content_type_id) {
        $lang = get_language($this);
        $query = $this->db->query('SELECT c.id, mc.menu_id, c.content_status_id, c.content_type_id, c.order, c.static_page_name, '
            .' c.title_'.$lang.' title, c.short_desc_'.$lang.' short_desc, c.desc_'.$lang.' "desc", c.image, c.create_time '
            .' FROM phr_content c '
            .' INNER JOIN phr_menu_content mc ON mc.content_id=c.id '
            .' WHERE 1=1 '
            .(!is_empty($content_id) ? ' AND c.id='.$this->db->escape($content_id) : '')
            .(!is_empty($menu_id) ? ' AND mc.menu_id='.$this->db->escape($menu_id) : '')
            .(!is_empty($content_status_id) ? ' AND c.content_status_id='.$content_status_id : '')
            .(!is_empty($content_type_id) ? ' AND c.content_type_id='.$content_type_id : '')
            .' ORDER BY create_time DESC ');

        return $query->result_array();
    }

    function get_news_feed($menu_id, $content_status_id) {
        $lang = get_language($this);
        $query = $this->db->query('SELECT '.'c.id, c.title_'.$lang.' title, c.short_desc_'.$lang.' short_desc, c.image, c.create_time '
            .' FROM phr_content c '
            .' INNER JOIN phr_menu_content mc ON mc.content_id=c.id '
            .' WHERE 1=1 '
            .(!is_empty($menu_id) ? ' AND mc.menu_id='.$this->db->escape($menu_id) : '')
            .(!is_empty($content_status_id) ? ' AND c.content_status_id='.$content_status_id : '')
            .' ORDER BY create_time DESC '
            .' LIMIT 4 ');

        return $query->result_array();
    }
    
    function get($id) {
        $array = array();
        if (!is_empty($id)){
            $array['id'] = $id;
        }
        if (is_empty($array)){
            return NULL;
        }
        $query = $this->db->get_where('content', $array);
        return $query->first_row('array');
    }
    
    // depreciated ???
    function delete($id) {
        $this->db->delete('content', array('id' => $id));
    }


    public function deleteContent($id) {
        $query = $this->db->query('SELECT '.'c.id, c.image FROM phr_content c '
            .' WHERE c.id='.$this->db->escape($id)
            .' LIMIT 1 ');
        $result = $query->result_array();

        if ($result) {
            $image = FCPATH.$result[0]['image'];
            $image = realpath($image);

            if ($image) {
                if (!is_dir($image)) unlink($image);
            }

            return $this->db->delete('content', array('id' => $id));
        }
        return false;
    }
}
