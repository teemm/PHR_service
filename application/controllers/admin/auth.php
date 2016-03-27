<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//admin
require 'base.php';
class Auth extends Base {
    public function __construct(){
        parent::__construct();
    }
    
    public function login(){
        try{
            if (is_post()){
                $validation_rules = array(
                    array('field'=>'user_name','rules'=>'required|system_user_validation')
                );

                $this->load->library('form_validation');
                if ($this->form_validation->validate_form('auth/login', $validation_rules, true)==true){
                    $post_data = array(
                       'user_name' => $this->input->post('user_name'),
                       'password' => md5($this->input->post('password'))
                    );
                    $this->load->model('System_User_model');
                    $system_user_model = $this->System_User_model->get_login_system_user($post_data['user_name'], $post_data['password']);
                    
                    set_session($this, 'system_user_id', $system_user_model['id']);
                    set_session($this, 'system_user_name', $system_user_model['user_name']);
                    
                    redirect('admin/home', 'location');
                }
                
            } else {
                set_session($this, 'system_user_id', NULL);
                set_session($this, 'system_user_name', NULL);
                
                parent::load_view('admin/auth/login');
            }
        }
        catch (Exception $ex) {
            parent::error($ex->getMessage());
        }
    }
    
    public function logout(){
        set_session($this, 'system_user_id', NULL);
        set_session($this, 'system_user_name', NULL);
        
        redirect('/admin/auth/login', 'location');
    }
    
}