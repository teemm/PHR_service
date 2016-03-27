<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//menu
require 'base.php';
class File extends Base {
    public function __construct() {
        parent::__construct();
        parent::block_unauthorized();
    }
    
    public function get_files() {
        try {
            $start = $this->input->post('start');
            $limit = $this->input->post('limit');
            
            $query = 'SELECT f.id, f.name, f.path, f.type FROM phr_file f ';
            
            $totalCount = count($this->db->query($query)->result_array());
            $result = $this->db->query($query.' LIMIT '.$start.','.$limit)->result_array();
            
            $this->output->set_content_type('application/json')->set_output(json_encode(array('data' => $result, 'totalCount' => $totalCount, 'success' => true )));
        }
        catch (Exception $ex) {
            $this->output->set_content_type('application/json')->set_output(json_encode(array('msg' => $ex->getMessage(), 'success' => false)));
        }
    }
    
    public function upload_files() {
        try{
            $this->db->trans_begin();
            
            $config['upload_path'] = 'assets/uploads';
            $config['allowed_types'] = 'gif|jpg|png|pdf';
            $config['overwrite'] = true;
            
            $file_data = $_FILES['files'];
            
            $this->load->model('File_model');
            $file_count = count($file_data['name']);
            for ($i = 0; $i < $file_count; $i++){
                $file_model = array(
                    'id' => NULL,
                    'name' => $file_data['name'][$i],
                    'path' => '/assets/uploads/'.$file_data['name'][$i],
                    'type' => $file_data['type'][$i],
                    'create_time' => get_server_time('%Y-%m-%d %H:%M:%S')
                );
                $_file = $this->File_model->get(NULL, $file_model['name']);
                if (is_empty($_file)){
                    $this->File_model->save($file_model);
                }
            }
            
            $this->load->library('upload', $config);
            if ($this->upload->do_multi_upload('files')) {
                $this->db->trans_commit();
                $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true )));
            } else {
                throw new Exception($this->System_Message_model->get_system_error_msg(SYSTEM_MESSAGE_TYPE_FILE_UPLOAD_ERROR));
            }
            
        }
        catch (Exception $ex) {
            $this->db->trans_rollback();
            $this->output->set_content_type('application/json')->set_output(json_encode(array('msg' => $ex->getMessage(), 'success' => false)));
        }
    }
    
    public function delete_file() {
        try{
            $this->db->trans_begin();
            
            $id = $this->input->post('file_id');
            $this->load->model('File_model');
            
            $file_model = $this->File_model->get($id, NULL);
            
            $this->File_model->delete($id);
            
            //$this->load->helper('file');
            //delete_files(FCPATH.'/assets/uploa');
            if (file_exists(FCPATH.$file_model['path'])){
                unlink(FCPATH.$file_model['path']);
            }else{
                throw new Exception($this->System_Message_model->get_system_error_msg(SYSTEM_MESSAGE_TYPE_FILE_NOT_FOUND));
            }
            
            $this->db->trans_commit();
            $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true )));
        }
        catch (Exception $ex) {
            $this->db->trans_rollback();
            $this->output->set_content_type('application/json')->set_output(json_encode(array('msg' => $ex->getMessage(), 'success' => false)));
        }
    }
    
}
