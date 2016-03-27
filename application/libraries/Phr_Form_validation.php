<?php

class Phr_Form_validation extends CI_Form_validation {
    public function __construct() {
        parent::__construct();
    }
    
    public function validate_form($url, $validation_rules=NULL) {
        if (isset($validation_rules)){
            $this->CI->form_validation->set_rules($validation_rules);
            if ($this->CI->form_validation->run()==false){
                $content = $this->CI->load->view($url,null,true);
                $this->CI->load->view('layout', array('content' => $content));
                return FALSE;
            }
        }
        return TRUE;
    }
    
    public function system_user_validation() {
        $post_data = array(
            'user_name' => $this->CI->input->post('user_name'),
            'password' => md5($this->CI->input->post('password'))
        );
        
        $query = $this->CI->db->query('SELECT id FROM phr_system_user WHERE user_name=? AND password=?', $post_data);
        $row = $query->row();
        
        if ($row==null || $row->id==NULL)
        {
            $this->CI->form_validation->set_message('system_user_validation','მომხმარებელი ვერ მოიძებნა');
            return FALSE;
        }
        
        return TRUE;
    }
}
