<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Base extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }
    
    protected function get_menu(){
        $lang = get_language($this);
        $menu_q = $this->db->query('SELECT DISTINCT m.id, m.parent_id, m.menu_type_id type, m.desc_'.$lang.' text, '
            .' SUM(CASE WHEN mc.id IS NOT NULL AND c.content_status_id='.CONTENT_STATUS_ACTIVE.' THEN 1 ELSE 0 END) redirectable, c.url '
            .' FROM phr_menu m '
            .' LEFT JOIN phr_menu_content mc ON mc.menu_id=m.id '
            .' LEFT JOIN phr_content c ON c.id=mc.content_id AND c.content_status_id='.CONTENT_STATUS_ACTIVE
            .' GROUP BY m.id '
            .' ORDER BY m.id ');
            
        $menu = $menu_q->result_array();

        // Links all parents to children. returns NULL if there is no item in DB
        $menu = $this->linkToChildren($menu, NULL, NULL);
        $menu = $this->split_menu_data($menu);
        
        return $menu;
    }
    
    protected function render_menu($active_id, $data) {
        $tree = '';

        foreach ($data as $key => $value) {
            $tree .= '<li';
            if (array_key_exists('right', $value)) {
                if ($value['right'] === true) $tree .= ' class="right"';
            }
            $tree .= '><a';
            if ($value['url']){
                $tree .= ' href="'.$value['url'].'" >' . $value['text'];
            } elseif ($value['redirectable']){
                $tree .= ' href="'.http_url('home/content?menu_id='.$value['id']).'" >' . $value['text'];
            } else {
                $tree .= ' href="#" >' . $value['text'];
            }
            $tree .= '</a>';

            if ($value['children']) {
                $tree .= '<ul>';
                $tree .= $this->render_menu($active_id, $value['children'], $tree);
                $tree .= '</ul>';
            }

            $tree .= '</li>';
        }

        return $tree;
    }
    
    protected function load_view($url, $data = null, $title = null){
        $lang = get_language($this);
        $this->lang->load('layout', $lang);
        $this->lang->load($url, $lang);
        $this->config->set_item('language', $lang);

        $content = ( $this->load->view($url, $data, true) );
        $menu = $this->getMenu();
        $resc = $this->getRescources();
        if ($title) {
            $resc['title'] = $title;
        } else {
            $resc['title'] = null;
        }
        $this->load->view('layout', array('content' => $content, 'menuH' => $menu['header'], 'menuF' => $menu['footer'], 
            'news_feed' => $resc['news_feed'], 'title' => $resc['title'], 'images' => $resc['images']));
    }
    
    protected function load_dynamic_view($data){
        $lang = get_language($this);
        $this->lang->load('layout', $lang);

        if ($data) {
            $content = $this->load->view('content', $data, true);
        } else {
            $content = '';
        }
        $menu = $this->getMenu();
        $resc = $this->getRescources();
        $this->load->view('layout', array('content' => $content, 'menuH' => $menu['header'], 'menuF' => $menu['footer'], 
            'news_feed' => $resc['news_feed'], 'title' => $resc['title'], 'images' => $resc['images']));
    }
    
    protected function load_multi_content_dynamic_view($data, $page_link_url){
        $lang = get_language($this);
        $this->lang->load('layout', $lang);
        $this->lang->load('multi_content', $lang);

        if ($data) {
            $no_page = !is_empty($this->input->get('per_page')) ? $this->input->get('per_page') : 1;
            $count = count($data['data']);
            $data['contents'] = array_slice($data['data'], ATTRIBUTE_NO_DISPLAY_DYNAMIC_CONTENT * ($no_page - 1), ATTRIBUTE_NO_DISPLAY_DYNAMIC_CONTENT);
            $data['page_links'] = $this->render_page_links($page_link_url, $count, ATTRIBUTE_NO_DISPLAY_DYNAMIC_CONTENT);

            $content = $this->load->view('multi_content', $data, true);
        } else {
            $content = '';
        }
        
        $menu = $this->getMenu();
        $resc = $this->getRescources();
        $this->load->view('layout', array('content' => $content, 'menuH' => $menu['header'], 'menuF' => $menu['footer'], 
            'news_feed' => $resc['news_feed'], 'title' => $resc['title'], 'images' => $resc['images']));
    }
    
    protected function block_unauthorized(){
        if (is_empty(get_session($this, 'system_user_id'))){
            if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                exit(json_encode(array('msg' => $this->Sys_Message_model->get_message(SYS_MESSAGE_TYPE_UNAUTHORIZED), 'success'=>false)));
            } else {
                redirect('auth/logout', 'location');
            }
        }
    }

    protected function render_page_links($url, $total_rows, $per_page) {
        $this->load->library('pagination');
        $config['base_url'] = $url;
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['page_query_string'] = TRUE;
        $config['use_page_numbers'] = TRUE;
        $this->pagination->initialize($config);
        return $this->pagination->create_links();
    }

    protected function getMenu() {
        $menu_data = $this->get_menu();

        if ($menu_data['header']) {
            $menu_id = $this->input->get('menu_id');
            
            if ($menu_data['header']) {
                $count = count($menu_data['header']) - 1;
                $reversed = 3;
                for ($i = $count; $i >= 0; $i--) {
                    if ($reversed > 0) {
                        $menu_data['header'][$i]['right'] = true;
                        $reversed--;
                    } else {
                        $menu_data['header'][$i]['right'] = false;
                    }
                }
            }

            $result['header'] = '<ul class="menuH">'.$this->render_menu($menu_id, $menu_data['header']).'</ul>';
        } else {
            $result['header'] = 'There is no header menu in your database.';
        }
        if ($menu_data['footer']) {
            $result['footer'] = '<ul class="menuF">'.$this->render_menu(NULL, $menu_data['footer']).'</ul>';
        } else {
            $result['footer'] = 'There is no footer menu in your database.';
        }

        return $result;
    }

    protected function linkToChildren($menu, $parent_id) {
        if (!$menu || count($menu)==0)
            return NULL;

        $result = array();

        foreach ($menu as $key => $value) {
            if ($value['parent_id'] == $parent_id) {
                unset($menu[$key]);
                $value['children'] = $this->linkToChildren($menu, $value['id']);
                array_push($result, $value);
            }
        }

        if (count($result) == 0)
            return NULL;
        return $result;
    }

    protected function split_menu_data($merged_menu) {
        $footer_menu = array();
        foreach ($merged_menu as $key => $value) {
            if ($value['type'] == MENU_TYPE_FOOTER) {
                array_push($footer_menu, $value);
                unset($merged_menu[$key]);
            }
        }
        $result['header'] = $merged_menu;
        $result['footer'] = $footer_menu;

        return $result;
    }

    protected function getRescources() {
        // get news_feed
        if (!isset($this->Content_model)) {
            $this->load->model('Content_model');
        }
        $result['news_feed'] = $this->Content_model->get_news_feed(BLOGS_MENU_ID, CONTENT_STATUS_ACTIVE);

        // content title path
        $result['title'] = $this->getTitle();

        // slider images
        $result['images'] = $this->getSliderImages();

        return $result;
    }

    protected function getTitle() {
        $content_id = $this->input->get('content_id');
        $menu_id = $this->input->get('menu_id');

        $lang = get_language($this);
        $this->lang->load('search', $lang);

        $query = $this->db->query('SELECT '.' m.desc_'.$lang.' menu_title, mc.menu_id menu_id, p.desc_'.$lang.' parent_name, p.id parent_id, '
            .' c.title_'.$lang.' content_title, c.id content_id '
            .' FROM phr_content c '
            .' INNER JOIN phr_menu_content mc ON mc.content_id=c.id '
            .' INNER JOIN phr_menu m ON m.id = mc.menu_id '
            .' LEFT JOIN phr_menu p ON m.parent_id = p.id '
            .' WHERE 1=1 '
            .(!is_empty($content_id) ? ' AND c.id='.$this->db->escape($content_id) : '')
            .(!is_empty($menu_id) ? ' AND m.id='.$this->db->escape($menu_id) : '')
        );

        $result = $query->result_array();
        if (count($result) < 1)
            return array();
        $info = $result[0];

        $result = array();

        if ($info['content_id']) {
            if (count($result) == 0) 
                $anchor = '<li><span>'.$info['content_title'].'</span></li>';
            else
                $anchor = '<li class="linked-page"><a href="/home/content?content_id='.$info['content_id'].'">'.$info['content_title'].'</a></li>';

            if ($content_id) array_push($result, $anchor);
        }
        if ($info['menu_id']) {
            if (count($result) == 0) 
                $anchor = '<li><span>'.$info['menu_title'].'</span></li>';
            else
                $anchor = '<li class="linked-page"><a href="/home/content?menu_id='.$info['menu_id'].'">'.$info['menu_title'].'</a></li>';

            array_push($result, $anchor);
        }
        if ($info['parent_id']) {
            $anchor = '<li class="linked-page"><a href="/home/content?menu_id='.$info['parent_id'].'">'.$info['parent_name'].'</a></li>';
            array_push($result, $anchor);
        }
        if (count($result) == 0)
            array_push($result, '<li><span>'.lang('home').'</span></li>');
        else
            array_push($result, '<li class="linked-page"><a href="/">'.lang('home').'</a></li>');

        return array_reverse($result);
    }


    protected function getSliderImages() {
        $path = FCPATH.'assets/uploads/homepage';

        $imgDir = site_url().'assets/uploads/';

        $scan = scandir($path);
        $result = array();

        foreach ($scan as $child) {
            if ($child == '.' || $child == '..') continue;

            $info = pathinfo($path.'\\'.$child);
            if (isset($info['extension'])) {
                $ext = $info['extension'];
            } else {
                $ext = '';
            }
            
            $name = $info['basename'];
            $name= str_replace('\\', '/', $name);

            if ($ext == 'jpg' || $ext == 'png' || $ext == 'bmp' || $ext == 'jpeg') {
                $imgPath = $imgDir.$name;
                array_push($result, $imgPath);
            }
        }

        return $result;
    }

}