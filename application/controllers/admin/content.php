<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//menu
require 'base.php';
class Content extends Base {
    public function __construct() {
        parent::__construct();
        parent::block_unauthorized();
    }
          
    public function get_contents() {
        try {
            $start = $this->input->post('start');
            $limit = $this->input->post('limit');
            
            $query = 'SELECT c.id, c.id "content_id", m.desc_en menu_title, cs.name content_status_name, ct.name content_type_name, '
                .' c.order, c.static_page_name, c.url, c.title_ka, c.short_desc_ka '
                .' FROM phr_content c '
                .' INNER JOIN phr_menu_content mc ON mc.content_id=c.id '
                .' INNER JOIN phr_menu m ON m.id = mc.menu_id '
                .' INNER JOIN phr_content_status cs ON cs.id = c.content_status_id '
                .' INNER JOIN phr_content_type ct ON ct.id = c.content_type_id '
                .' GROUP BY c.id '
                .' ORDER BY c.create_time '
                .' DESC ';
                
            $totalCount = count($this->db->query($query)->result_array());
            $result = $this->db->query($query.' LIMIT '.$start.','.$limit)->result_array();
            
            $this->output->set_content_type('application/json')->set_output(json_encode(array('data' => $result, 'totalCount' => $totalCount, 'success' => true )));
        }
        catch (Exception $ex) {
            $this->output->set_content_type('application/json')->set_output(json_encode(array('msg' => $ex->getMessage(), 'success' => false)));
        }
    }
    
    public function get_content() {
        try {
            $id = $this->input->post('content_id');
            
            $query = 'SELECT c.id, mc.menu_id, c.content_status_id, c.content_type_id, c.static_page_name, c.url, '
                .' c.title_ka, c.title_en, c.short_desc_ka, c.short_desc_en, '
                .' c.desc_ka, c.desc_en '
                .' FROM phr_content c '
                .' INNER JOIN phr_menu_content mc ON mc.content_id=c.id '
                .' WHERE 1=1 '
                .(!is_empty($id) ? ' AND c.id = '.$id : '');
            
            $result = $this->db->query($query)->first_row('array');
            $this->output->set_content_type('application/json')->set_output(json_encode(array('data' => $result, 'success' => true )));
        }
        catch (Exception $ex) {
            $this->output->set_content_type('application/json')->set_output(json_encode(array('msg' => $ex->getMessage(), 'success' => false)));
        }
    }
    
    public function save_content() {
        try {
            $this->db->trans_begin();

            $post = $this->translate();

            $old_data = $this->getOldData($post['content_id']);

            $image_path = 'assets/uploads/contents/default.png';
            $create_time = get_server_time('%Y-%m-%d %H:%M:%S');

            if ($old_data) {
                $image_path = $old_data['image'];
                $create_time = $old_data['create_time'];
            }

            $file = $_FILES['userfile'];
            $new_image = $this->uploadImage($file);
            if ($new_image) {
                $image_path = $new_image;
            }

            $menu_id = $post['menu_id'];
            
            $content_model = array(
                'id' => $post['content_id'],
                'content_status_id' => $post['content_status_id'],
                'content_type_id' => $post['content_type_id'],
                'static_page_name' => $post['static_page_name'],
                'url' => $post['url'],
                'order' => $post['order'],
                'title_ka' => $post['content_title_ka'],
                'title_en' => $post['content_title_en'],
                'title_ru' => $post['content_title_ru'],
                'short_desc_ka' => $post['short_desc_ka'],
                'short_desc_en' => $post['short_desc_en'],
                'short_desc_ru' => $post['short_desc_ru'],
                'desc_ka' => $post['desc_ka'],
                'desc_en' => $post['desc_en'],
                'desc_ru' => $post['desc_ru'],
                'image' => $image_path,
                'create_time' => $create_time
            );
            
            $this->load->model('Menu_Content_model');
            //If new content is created...
            if (is_empty($content_model['id'])){
                //check if this menu has non-dynamic content, if yes then throw exception
                $_last_content = $this->Menu_Content_model->get_last($menu_id);
                if (!is_empty($_last_content) && ($_last_content['content_type_id'] != CONTENT_TYPE_DYNAMIC || 
                    $content_model['content_type_id'] != CONTENT_TYPE_DYNAMIC)){
                    throw new Exception($this->System_Message_model->get_system_error_msg(SYSTEM_MESSAGE_TYPE_MENU_HAS_CONTENT));
                }
            }
            $this->load->model('Content_model');
            $content_id = $this->Content_model->save($content_model);
            
            $menu_content_model = $this->Menu_Content_model->get(NULL, NULL, $content_id);
            
            if (!is_empty($menu_content_model)){
                $menu_content_model['menu_id'] = $menu_id;
            } else {
                $menu_content_model = array(
                    'id' => NULL,
                    'menu_id' => $menu_id,
                    'content_id' => $content_id
                );
            }
            $this->Menu_Content_model->save($menu_content_model);
            
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
            $this->load->model('Content_model');
            if ($this->Content_model->deleteContent($id)) {
                $this->output->set_content_type('text/javascript')->set_output(json_encode(array('success' => true)));
            } else {
                $this->output->set_content_type('text/javascript')->set_output(json_encode(array('msg' => '', 'success'=>false)));
            }
        }
    }


    private function translate() {
        $result['menu_id'] = $this->input->post('cmbMenu-inputEl');
        $result['content_id'] = $this->input->post('content_id');
        $result['content_status_id'] = $this->input->post('cmbContentStatus-inputEl');
        $result['content_type_id'] = $this->input->post('cmbContentType-inputEl');
        $result['static_page_name'] = $this->input->post('txtStaticPageName-inputEl');
        $result['url'] = $this->input->post('txtURL-inputEl');
        $result['order'] = null;
        $result['content_title_ka'] = $this->input->post('txtContentTitle_ka-inputEl');
        $result['content_title_en'] = $this->input->post('txtContentTitle_en-inputEl');
        $result['content_title_ru'] = null;
        $result['short_desc_ka'] = $this->input->post('txtShortDesc_ka-inputEl');
        $result['short_desc_en'] = $this->input->post('txtShortDesc_en-inputEl');
        $result['short_desc_ru'] = null;
        $result['desc_ka'] = $this->input->post('txtDesc_ka-inputEl');
        $result['desc_en'] = $this->input->post('txtDesc_en-inputEl');
        $result['desc_ru'] = null;

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