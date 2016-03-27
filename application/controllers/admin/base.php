<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//admin
class Base extends CI_Controller {
    public function __construct(){
        parent::__construct();
    }
    
    protected function load_view($url){
        $content = $this->load->view($url, null, true);
        $this->load->view('admin/layout', array('content' => $content));
    }
    
    protected function block_unauthorized(){
        if (is_empty(get_session($this, 'system_user_id'))){
            if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                exit(json_encode(array('msg' => $this->System_Message_model->get(NULL, SYSTEM_MESSAGE_TYPE_UNAUTHORIZED), 'success'=>false)));
            } else {
                redirect('admin/auth/logout', 'location');
            }
        }
    }

}
