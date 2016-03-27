<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//menu
require 'base.php';
class Video extends Base {
    public function __construct() {
        parent::__construct();
        parent::block_unauthorized();
    }
          
    public function get_videos() {
        try {
            $start = $this->input->post('start');
            $limit = $this->input->post('limit');

            $start = 0;
            $limit = 75;
            
            $query = 'SELECT v.id, v.token '
                .' FROM phr_video v '
                .' ORDER BY v.id '
                .' DESC ';
                
            $totalCount = count($this->db->query($query)->result_array());
            $result = $this->db->query($query.' LIMIT '.$start.','.$limit)->result_array();
            
            $this->output->set_content_type('application/json')->set_output(json_encode(array('data' => $result, 'totalCount' => $totalCount, 'success' => true )));
        }
        catch (Exception $ex) {
            $this->output->set_content_type('application/json')->set_output(json_encode(array('msg' => $ex->getMessage(), 'success' => false)));
        }
    }
    
    public function get_video() {
        try {
            $id = $this->input->post('video_id');
            
            $query = 'SELECT v.id, v.token '
                .' FROM phr_video v '
                .' WHERE 1=1 '
                .(!is_empty($id) ? ' AND v.id = '.$id : '');
            
            $result = $this->db->query($query)->first_row('array');
            $this->output->set_content_type('application/json')->set_output(json_encode(array('data' => $result, 'success' => true )));
        }
        catch (Exception $ex) {
            $this->output->set_content_type('application/json')->set_output(json_encode(array('msg' => $ex->getMessage(), 'success' => false)));
        }
    }
    
    public function save_video() {
        try {
            $this->db->trans_begin();

            $post = $this->translate();
            
            $video_model = array(
                'id' => $post['video_id'],
                'token' => $post['token']
            );
            
            $this->load->model('Video_model');
            $video_id = $this->Video_model->save($video_model);

            // var_dump($video_id);

            // throw new Exception('asd');
            
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
            $this->load->model('Video_model');
            if ($this->Video_model->deleteVideo($id)) {
                $this->output->set_content_type('text/javascript')->set_output(json_encode(array('success' => true)));
            } else {
                $this->output->set_content_type('text/javascript')->set_output(json_encode(array('msg' => '', 'success'=>false)));
            }
        }
    }


    private function translate() {
        $result['video_id'] = $this->input->post('video_id');
        $result['token'] = $this->input->post('txtToken-inputEl');

        return $result;
    }


    private function uploadImage($file) {
        if ($file['size'] > 0) {
            $config['upload_path'] = 'assets/uploads/contents';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['overwrite'] = false;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('userfile')) {
                $upload_data = $this->upload->data();
                return 'assets/uploads/contents/' . $upload_data['file_name'];
            } else {
                return null;
            }
        }
        return null;
    }


    private function getOldData($content_id) {
        if ($content_id) {
            $query = $this->db->query('SELECT'.' c.image, c.create_time '
                .' FROM phr_content c '
                .' WHERE c.id='.$content_id
                .' LIMIT 1 '
            );

            $data = $query->result_array();

            if (isset($data[0])) {
                return $data[0];
            }
        }
        return null;
    }
}
