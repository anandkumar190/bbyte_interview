<?php
if(!defined('BASEPATH'))
    exit('No direct scrip access allowed');

/*
 * login Register controller for Frontend
 * 
 * this controller user for login, register, logout, forgot password, reset password
 * @author trilok
 */

class Dashboard extends CI_Controller{

    public function __construct() {
        parent::__construct();
        if(empty($_SESSION['cranesmart_staff']) || empty($_SESSION['cranesmart_staff']['id']) || $_SESSION['cranesmart_staff']['role_id'] != 6){
            redirect(base_url('admin/login'));
            exit();
        }
    }
	
	public function index(){
		$siteUrl = base_url();
		$data = array(
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
		    'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getsystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'site_url' => $siteUrl,
            'content_block' => 'dashboard'
        );
        $this->parser->parse('staff/layout/column-1' , $data);
    }

    public function logout() {
        $this->session->sess_destroy();
        unset($_SESSION);
        $this->Az->redirect('admin/Login', 'system_message_error', lang('LOGOUT_SUCCESS'));
    }
}
