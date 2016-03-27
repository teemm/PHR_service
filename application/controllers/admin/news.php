<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//menu
require 'base.php';
class News extends Base {
    public function __construct() {
        parent::__construct();
        parent::block_unauthorized();
    }
          
    public function get_contents() {
        try {
            $start = $this->input->post('start');
            $limit = $this->input->post('limit');

            $query = 'SELECT c.id, cs.name content_status_name, '.'c.title_ka, c.title_en, c.create_time '
                .' FROM phr_content c '
                .' INNER JOIN phr_menu_content mc ON mc.content_id=c.id AND mc.menu_id ='.NEWS_MENU_ID
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
                .' c.title_ka, c.title_en, c.short_desc_ka, c.short_desc_en, c.desc_ka, c.desc_en '
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
            
            $config['upload_path'] = 'assets/uploads/news';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['overwrite'] = false;

            $this->load->library('upload', $config);

            // if we upload file there is 2 opportunity. (1) we are updating or (2) we are inserting
            // if (1) there will be content_id setted and we can replace old one with new image
            // and if (2) we will just insert image with new file
            // else if upload failed we have 2 opportunity again. (1) we are updating and we want old image
            // or (2) upload failed and we should rollback insertion
            if ($this->upload->do_upload('userfile')) {
                // Status: image upload completed
                $upload_data = $this->upload->data();
                $img_path = 'assets/uploads/news/' . $upload_data['file_name'];
                // Insert or update news in database
                $this->save_content_to_database($img_path);
            } else {
                // Status: image upload failed
                // (1) we are updating news and want to leave old image
                // or (2) we want default image
                $this->save_content_to_database();
            }
            $this->db->trans_commit();
            $this->output->set_content_type('text/javascript')->set_output(json_encode(array('success' => true)));
        }
        catch (Exception $ex) {
            $this->db->trans_rollback();
            $this->output->set_content_type('text/javascript')->set_output(json_encode(array('msg' => $ex->getMessage(), 'success'=>false)));
        }
    }


    private function save_content_to_database($img_path = NULL) {
        $menu_id = NEWS_MENU_ID;
        $content_id = $this->input->post('content_id');

        $content_model = array(
            'id' => $content_id,
            'content_status_id' => $this->input->post('cmbContentStatus-inputEl'),
            'content_type_id' => CONTENT_TYPE_DYNAMIC,
            'static_page_name' => NULL,
            'url' => NULL,
            'order' => NULL,
            'title_ka' => $this->input->post('txtContentTitle_ka-inputEl'),
            'title_en' => $this->input->post('txtContentTitle_en-inputEl'),
            'title_ru' => null,
            'short_desc_ka' => $this->input->post('txtShortDesc_ka-inputEl'),
            'short_desc_en' => $this->input->post('txtShortDesc_en-inputEl'),
            'short_desc_ru' => null,
            'desc_ka' => $this->input->post('txtDesc_ka-inputEl'),
            'desc_en' => $this->input->post('txtDesc_en-inputEl'),
            'desc_ru' => null,
            'image' => $img_path,
            'create_time' => get_server_time('%Y-%m-%d %H:%M:%S')
        );

        if ($content_id) {
            // we are updating
            $old_entry = $this->getOldEntry($content_id);
            $old_img = $old_entry['image'];
            $content_model['create_time'] = $old_entry['create_time'];
            if ($img_path) {
                // we have to replace old image with new image and delete old one
                $this->deleteImage($old_img);
                // don't touch $content_model['image'] because there already is new image path
            } else {
                // we have to copy old image link and update news
                $content_model['image'] = $old_img;
            }
        } else {
            // we are inserting
            if (!$img_path) {
                // we have to insert new news with default image
                $content_model['image'] = 'assets/uploads/news/default.png';
            }
            // else we don't change anything and insert news with new image
        }

        $this->load->model('Menu_Content_model');
        // If new content is created...
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
    }


    private function getOldEntry($id) {
        $query = $this->db->query('SELECT image, create_time FROM phr_content  WHERE id='.$id);
        $result = $query->result_array();
        return $result[0];
    }


    private function deleteImage($img_path) {
        if (!$img_path) return;
        $file_path = FCPATH.$img_path;
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }

}
