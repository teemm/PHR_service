<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require 'base.php';
class Home extends Base {
	public function __construct(){
		parent::__construct();
	}

	public function index(){
		$_GET['menu_id'] = 40;

		$this->content();
	}

	public function content(){
		try {
			$content_id = $this->input->get('content_id');
			$menu_id = $this->input->get('menu_id');

			if (!$content_id && !$menu_id) {
				parent::load_dynamic_view(NULL);
				return;
			}

			$this->load->model('Content_model');

			if (!is_empty($content_id)){
				$contents = $this->Content_model->get_web_contents($content_id, NULL, CONTENT_STATUS_ACTIVE, CONTENT_TYPE_DYNAMIC);
				if (!is_empty($contents)) {
					parent::load_dynamic_view($contents[0]);
				} else {
					parent::load_dynamic_view(NULL);
				}
			} else {
				$contents = $this->Content_model->get_web_contents(NULL, $menu_id, CONTENT_STATUS_ACTIVE, NULL);
				if (count($contents) == 1){
					if ($contents[0]['content_type_id'] == CONTENT_TYPE_STATIC){
						parent::load_view($contents[0]['static_page_name']);
					}
					if ($contents[0]['content_type_id'] == CONTENT_TYPE_DYNAMIC){
						parent::load_dynamic_view($contents[0]);
					}
				} else if (count($contents) > 1) {
					parent::load_multi_content_dynamic_view(array('data' => $contents),
						http_url('/home/content?menu_id='.$menu_id));
				} else {
					parent::load_multi_content_dynamic_view(NULL, http_url('/home/content?menu_id='.$menu_id));
				}
			}
		}
		catch(Exception $ex){
			$_GET['menu_id'] = VACANCIES_MENU_ID;
			$this->content();
		}
	}

	public function lang(){
		$id = $this->input->get('id');
		switch ($id) {
			case '1':
				$this->input->set_cookie(array(
					'name'   => 'lang',
					'value'  => 'ka',
					'expire' => 10 * 365 * 24 * 60 * 60,
					'path'   => '/',
				));
				break;

			case '2':
				$this->input->set_cookie(array(
					'name'   => 'lang',
					'value'  => 'en',
					'expire' => 10 * 365 * 24 * 60 * 60,
					'path'   => '/',
				));
				break;

			default:
				$this->input->set_cookie(array(
					'name'   => 'lang',
					'value'  => 'ka',
					'expire' => 10 * 365 * 24 * 60 * 60,
					'path'   => '/',
				));
				break;
		}


		redirect($_SERVER["HTTP_REFERER"]);
	}


	public function search() {
		$text = $this->input->get('text');

		if ($text) {
			if (strlen($text) > 2) {
				$text = htmlentities($text);
				// $text = $this->security->xss_clean($text);
				$lang = get_language($this);
				$query = $this->db->query('SELECT'.' c.id, c.title_'.$lang.' title, c.short_desc_'.$lang.' "short_desc", image, create_time '
					.' FROM phr_content c '
					.' INNER JOIN phr_menu_content mc ON mc.content_id=c.id ' // AND mc.menu_id =c.id'.NEWS_MENU_ID //single menu content
					.' INNER JOIN phr_menu m ON m.id = mc.menu_id '
					.' WHERE c.content_status_id ='.CONTENT_STATUS_ACTIVE
					.' AND (c.desc_ka LIKE "%'.$text.'%"'
					.' OR c.desc_en LIKE "%'.$text.'%"'
					.' ) GROUP BY c.id '
					.' ORDER BY c.create_time '
				);

				$result = $query->result_array();

				$this->loadSearch($result, $lang, $text);
			} else {
				redirect($_SERVER["HTTP_REFERER"]);
			}
		} else {
			redirect($_SERVER["HTTP_REFERER"]);
		}
	}


	private function loadSearch($queryResult, $lang, $text) {
		if ($queryResult) {
			$this->lang->load('multi_content', $lang);

			$data['contents'] = $queryResult;
			$data['page_links'] = '';
			$content = $this->load->view('multi_content', $data, true);
		} else {
			$this->lang->load('posts/fail', $lang);

			$data['text'] = $text;
			$content = $this->load->view('posts/fail', $data, true);;
		}

		$this->lang->load('layout', $lang);
		$this->lang->load('search', $lang);

		$menu = $this->getMenu();
		$resc = $this->getRescources();
		$title = array(
			'0' => '<li class="linked-page"><a href="/">'.lang('home').'</a></li>',
			'1' => '</li><li><span>'.htmlentities($text).'</span></li>'
		);

		$images = $this->getSliderImages();

		$this->load->view('layout', array('content' => $content, 'menuH' => $menu['header'], 'menuF' => $menu['footer'], 
			'news_feed' => $resc['news_feed'], 'title' => $title, 'images' => $images));
	}


	public function map() {
		$lang = get_language($this);
        $menu_q = $this->db->query('SELECT DISTINCT m.id, m.parent_id, m.menu_type_id type, m.desc_'.$lang.' text, '
            .' SUM(CASE WHEN mc.id IS NOT NULL AND c.content_status_id='.CONTENT_STATUS_ACTIVE.' THEN 1 ELSE 0 END) redirectable, c.url '
            .' FROM phr_menu m '
            .' LEFT JOIN phr_menu_content mc ON mc.menu_id=m.id '
            .' LEFT JOIN phr_content c ON c.id=mc.content_id AND c.content_status_id='.CONTENT_STATUS_ACTIVE
            .' WHERE m.menu_type_id='.MENU_TYPE_HEADER
            .' GROUP BY m.id '
            .' ORDER BY m.id ');
            
        $menu = $menu_q->result_array();
        $menu = $this->linkToChildren($menu, NULL, NULL);

        $data['menus'] = $menu;

        $this->lang->load('map', $lang);
        $title = array(
			'0' => '<li class="linked-page"><a href="/">'.lang('home').'</a></li>',
			'1' => '</li><li><span>'.lang('map').'</span></li>'
		);

		parent::load_view('map', $data, $title);
	}


	public function contact() {
		if (is_post()) {
			$lang = get_language($this);
			$this->lang->load('contact', $lang);
			$this->config->set_item('language', $lang);

			$config = array(
				array(
					'field'   => 'from', 
					'label'   => lang('from'), 
					'rules'   => 'required|min_length[2]|max_length[30]|valid_email'
				),
				array(
					'field'   => 'subject', 
					'label'   => lang('subject'), 
					'rules'   => 'required|min_length[2]|max_length[30]'
				),   
				array(
					'field'   => 'message', 
					'label'   => lang('message'), 
					'rules'   => 'required'
				)
			);

			$this->load->library('form_validation');
			$this->form_validation->set_rules($config);

			$_GET['menu_id'] = CONTACT_MENU_ID;

			if ($this->form_validation->run() == FALSE) {
				// $this->lang->load('posts/fail',$lang);
				$data['alert'] = $this->load->view('posts/contact-fail', '', true);
				parent::load_view('contact', $data);
			} else {
				// Save data to database
				$this->savePostData();

				// Show success page
				parent::load_view('posts/success');
			}
		} else {
			header("Location: ".site_url().'home/content?menu_id='.CONTACT_MENU_ID);
			die();
		}
	}


	private function savePostData() {
		try {
			$this->db->trans_begin();

			$contact_model = array(
				'from' => $this->input->post('from'),
				'subject' => $this->input->post('subject'),
				'message' => $this->input->post('message'),
				'create_time' => get_server_time('%Y-%m-%d %H:%M:%S'),
				'update_time' => get_server_time('%Y-%m-%d %H:%M:%S'),
				'send_status' => 0,
			);

			if ($this->sendToEmail($contact_model)) {
				$contact_model['send_status'] = 1;
			}

			$this->load->model('Contact_model');
			$this->Contact_model->save($contact_model);

			$this->db->trans_commit();
		}
		catch (Exception $ex) {
			$this->db->trans_rollback();
		}
	}


	private function sendToEmail($data = null) {
		if (!$data) return;

		$to = SEND_TO_EMAIL_ADDRESS;
		$cc = SEND_CC_EMAIL_ADDRESS;
		$subject = 'New message for PHR';
		$message = "გამოგზავნის დრო - ".$data['create_time']."\r\n\r\n"
			."ავტორი - ".$data['from']."\r\n"
			."Subject - ".$data['subject']."\r\n"
			."ტექსტი - ".$data['message'];

		$this->load->library('email');

		$this->email->from('info@phr.ge', 'PHR contact info');
		$this->email->to($to); 
		$this->email->cc($cc); 
		$this->email->bcc(''); 

		$this->email->subject($subject);
		$this->email->message($message);	

		return $this->email->send();
	}
}