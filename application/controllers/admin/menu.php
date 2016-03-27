<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//menu
require 'base.php';
class Menu extends Base {
    public function __construct() {
        parent::__construct();
        parent::block_unauthorized();
    }
    
    public function get_menus() {
        try {
            $query = 'SELECT m.id, m.parent_id, mt.name menu_type, m.desc_ka title_ka, m.desc_en title_en, m.desc_ru title_ru FROM phr_menu m '
                .' INNER JOIN phr_menu_type mt ON mt.id=m.menu_type_id ';
            
            $result = $this->db->query($query)->result_array();
            
            $this->output->set_content_type('application/json')->set_output(json_encode(array('data' => $result, 'success'=>true)));
        }
        catch (Exception $ex) {
            $this->output->set_content_type('application/json')->set_output(json_encode(array('msg' => $ex->getMessage(), 'success' => false)));
        }
    }
    
    public function get_menu() {
        try {
            $menu_id = $this->input->post('menu_id');
            
            $query = 'SELECT m.id, m.parent_id, m.menu_type_id, m.desc_ka, m.desc_en FROM phr_menu m '
                .' WHERE m.id=?';
            
            $result = $this->db->query($query, array($menu_id))->row();
            
            $this->output->set_content_type('application/json')->set_output(json_encode(array('data' => $result, 'success' => true)));
        }
        catch (Exception $ex) {
            $this->output->set_content_type('application/json')->set_output(json_encode(array('msg' => $ex->getMessage(), 'success'=>false)));
        }
    }
    
    public function save_menu() {
        try {
            $this->db->trans_begin();
            
            $menu_model = array(
                'id' => $this->input->post('menu_id'),
                'parent_id' => $this->input->post('parent_menu_id'),
                'menu_type_id' => $this->input->post('menu_type_id'),
                'desc_ka' => $this->input->post('title_ka'),
                'desc_en' => $this->input->post('title_en'),
                'desc_ru' => null
            );

            $this->load->model('Menu_model');
            $this->Menu_model->save($menu_model);
            
            $this->db->trans_commit();
            $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true)));
        }
        catch (Exception $ex) {
            $this->db->trans_rollback();
            $this->output->set_content_type('application/json')->set_output(json_encode(array('msg' => $ex->getMessage(), 'success'=>false)));
        }
    }


    public function delete() {
        $id = $this->input->post('id');

        if ($id) {
            $this->load->model('Menu_model');
            if ($this->Menu_model->deleteMenu($id)) {
                $this->output->set_content_type('text/javascript')->set_output(json_encode(array('success' => true)));
            } else {
                $this->output->set_content_type('text/javascript')->set_output(json_encode(array('msg' => '', 'success'=>false)));
            }
        }
    }
    
}
