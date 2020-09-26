<?php
if(!defined('BASEPATH'))
    exit('No direct scrip access allowed');

/*
 * login Register controller for Frontend
 * 
 * this controller user for login, register, logout, forgot password, reset password
 * @author trilok
 */

class Productdetail extends CI_Controller{

    public function __construct() {
        parent::__construct();
        $this->lang->load('admin/dashboard', 'english');
        $this->lang->load('front_common', 'english');
    }
	
	
	public function index(){
		
		$siteUrl = base_url();
		$data = array(
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'site_url' => $siteUrl,
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getsystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'content_block' => 'productdetail'
        );
        $this->parser->parse('front/layout/column-1' , $data);
    }
	
	
}
/* End of file login.php */
/* Location: ./application/controllers/login.php */