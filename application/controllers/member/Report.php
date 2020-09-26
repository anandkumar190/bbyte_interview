<?php
if(!defined('BASEPATH'))
    exit('No direct scrip access allowed');

/*
 * login Register controller for Frontend
 * 
 * this controller user for login, register, logout, forgot password, reset password
 * @author trilok
 */

class Report extends CI_Controller{

    public function __construct() {
        parent::__construct();
		$this->User->checkUserPermission();
        $this->lang->load('admin/dashboard', 'english');
		$this->lang->load('admin/profile', 'english');
        $this->lang->load('front_common', 'english');
    }
	
	
	public function index(){
		$loggedUser = $this->session->userdata('cranesmart_member_session');
        
        $recharge = $this->db->select('level_income.*,users.user_code,users.name')->order_by('created','desc')->join('users','users.id = level_income.paid_from_member_id')->get_where('level_income',array('paid_to_member_id'=>$loggedUser['id']))->result_array();
		
		// get direct income percentage
		$get_direct_percentage = $this->db->get_where('master_setting',array('id'=>1))->row_array();
		$tds_percentage = isset($get_direct_percentage['tds']) ? $get_direct_percentage['tds'] : 0 ;
		$service_tax_percentage = isset($get_direct_percentage['service_tax']) ? $get_direct_percentage['service_tax'] : 0 ;

		$siteUrl = base_url();
		$data = array(
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'site_url' => $siteUrl,
            'recharge' => $recharge,
			'tds_percentage'  => $tds_percentage,
			'service_tax_percentage'  => $service_tax_percentage,			
			'level_num'  => 0,			
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getsystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'content_block' => 'member/level-income-report'
        );
        $this->parser->parse('front/layout/column-1' , $data);
    }
	
	public function levelAuth() {
        
        $siteUrl = site_url();
        $post = $this->input->post();
        
        $loggedUser = $this->session->userdata('cranesmart_member_session');

        //check for foem validation
        $this->load->library('form_validation');
        $this->form_validation->set_rules('level_num', 'Level', 'required|xss_clean');     
        if ($this->form_validation->run() == FALSE) {
            
            $this->index();
            
        } 
        else {
            
			$level_num = $post['level_num'];
			if($level_num == 0)
			{
				$recharge = $this->db->select('level_income.*,users.user_code,users.name')->order_by('created','desc')->join('users','users.id = level_income.paid_from_member_id')->get_where('level_income',array('paid_to_member_id'=>$loggedUser['id']))->result_array();
			}
			else
			{
				$recharge = $this->db->select('level_income.*,users.user_code,users.name')->order_by('created','desc')->join('users','users.id = level_income.paid_from_member_id')->get_where('level_income',array('paid_to_member_id'=>$loggedUser['id'],'level_num'=>$level_num))->result_array();
			}
		
			// get direct income percentage
			$get_direct_percentage = $this->db->get_where('master_setting',array('id'=>1))->row_array();
			$tds_percentage = isset($get_direct_percentage['tds']) ? $get_direct_percentage['tds'] : 0 ;
			$service_tax_percentage = isset($get_direct_percentage['service_tax']) ? $get_direct_percentage['service_tax'] : 0 ;

			$siteUrl = base_url();
			$data = array(
				'meta_title' => lang('SITE_NAME'),
				'meta_keywords' => lang('SITE_NAME'),
				'meta_description' => lang('SITE_NAME'),
				'site_url' => $siteUrl,
				'recharge' => $recharge,
				'tds_percentage'  => $tds_percentage,
				'service_tax_percentage'  => $service_tax_percentage,			
				'level_num'  => $level_num,			
				'system_message' => $this->Az->getSystemMessageError(),
				'system_info' => $this->Az->getsystemMessageInfo(),
				'system_warning' => $this->Az->getSystemMessageWarning(),
				'content_block' => 'member/level-income-report'
			);
			$this->parser->parse('front/layout/column-1' , $data);
            
             
        }
        
    }
	
	
}
/* End of file login.php */
/* Location: ./application/controllers/login.php */