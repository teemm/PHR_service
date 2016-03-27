<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('http_url'))
{
    function http_url($url){
        if (isset($url)){
            return base_url().$url;
        } else {
            return base_url();
        }
    }
}

if ( ! function_exists('asset_url'))
{
    function asset_url($url){
        return http_url('assets'.$url);
    }
}

if ( ! function_exists('is_post'))
{
    function is_post() {
        return $_SERVER['REQUEST_METHOD'] == "POST";
    }
}

if ( ! function_exists('is_empty'))
{
    function is_empty($obj=NULL) {
        if (($obj==NULL || $obj=="") && $obj!==0){
            return TRUE;
        }
        return FALSE;
    }
}

if ( ! function_exists('set_session'))
{
    function set_session($ci, $name, $value){
        $ci->session->set_userdata($name, $value);
    }
}

if ( ! function_exists('get_session'))
{
    function get_session($ci, $name){
        $session = $ci->session->userdata($name);
        return $session;
    }
}

if ( ! function_exists('get_server_time'))
{
    function get_server_time($format){
        if (is_empty($format)){
            return time();
        }  else {
            return strftime($format, time());
        }
    }
}

if ( ! function_exists('get_language'))
{
    function get_language($ci){
        $lang = $ci->input->cookie('lang');
        if (is_empty($lang)){
            $ci->input->set_cookie(array(
                'name'   => 'lang',
                'value'  => 'ka',
                'expire' => 10 * 365 * 24 * 60 * 60,
                // 'domain' => 'my.domain.ge',
                'path'   => '/',
                //'secure' => TRUE
            ));
            $lang = 'ka';
        }
        return $lang;
    }
}