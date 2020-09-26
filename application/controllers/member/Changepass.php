<?php
if(!defined('BASEPATH'))
    exit('No direct scrip access allowed');

/*
 * login Register controller for Frontend
 * 
 * this controller user for login, register, logout, forgot password, reset password
 * @author trilok
 */

class Changepass extends CI_Controller{

    public function __construct() {
        parent::__construct();
		$this->User->checkUserPermission();
        $this->lang->load('admin/dashboard', 'english');
        $this->lang->load('admin/profile', 'english');
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
            'content_block' => 'member/changepass'
        );
        $this->parser->parse('front/layout/column-1' , $data);
    }
	

    public function changePassword() {
        
        $this->load->library('template');
        $siteUrl = site_url();
        $post = $this->input->post();
        
        //get logged user info
        $loggedUser = $this->session->userdata('cranesmart_member_session');
        $account_id = $loggedUser['id'];

        //check for foem validation
        $this->load->library('form_validation');
        $this->form_validation->set_rules('opw', 'Old Password', 'required|xss_clean');     
        $this->form_validation->set_rules('npw', 'New Password', 'required|xss_clean');     
        $this->form_validation->set_rules('cpw', 'Confirm New Password', 'required|xss_clean|matches[npw]');     
        if ($this->form_validation->run() == FALSE) {
            
            $this->index();
            
        } 
        else {
            
            // check old password valid or not
            $chk_old_pwd = $this->db->get_where('users',array('id'=>$account_id,'password'=>do_hash($post['opw'])))->num_rows();

            if(!$chk_old_pwd)
            {
                $this->Az->redirect('member/changepass', 'system_message_error',lang('OLD_PASSWORD_FAILED'));   
            }

            $data = array(
            'password' => do_hash($post['npw']),
            'decode_password' =>$post['npw'],
            'updated' => date('Y-m-d h:i:s')
            );
            
            $this->db->where('id',$account_id);
            $this->db->update('users',$data);

            $this->Az->redirect('member/changepass', 'system_message_error',lang('PASSWORD_UPDATE_SUCCESSFULLY'));
            
             
        }
        
    }
	
}
/* End of file login.php */
/* Location: ./application/controllers/login.php */