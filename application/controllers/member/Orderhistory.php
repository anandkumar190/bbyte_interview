<?php
if(!defined('BASEPATH'))
    exit('No direct scrip access allowed');

/*
 * login Register controller for Frontend
 * 
 * this controller user for login, register, logout, forgot password, reset password
 * @author trilok
 */

class Orderhistory extends CI_Controller{

    public function __construct() {
        parent::__construct();
		$this->User->checkUserPermission();
        $this->lang->load('admin/dashboard', 'english');
        $this->lang->load('front_common', 'english');
    }
	
	
	public function index(){
		$loggedUser = $this->session->userdata('cranesmart_member_session');
        
        $recharge = $this->db->order_by('created','desc')->get_where('recharge_history',array('member_id'=>$loggedUser['id']))->result_array();

		$siteUrl = base_url();
		$data = array(
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'site_url' => $siteUrl,
            'recharge' => $recharge, 
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getsystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'content_block' => 'member/orderhistory'
        );
        $this->parser->parse('front/layout/column-1' , $data);
    }
	
	
}
/* End of file login.php */
/* Location: ./application/controllers/login.php */