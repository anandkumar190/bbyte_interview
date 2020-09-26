<?php
if(!defined('BASEPATH'))
    exit('No direct scrip access allowed');

/*
 * login Register controller for Frontend
 * 
 * this controller user for login, register, logout, forgot password, reset password
 * @author trilok
 */

class Forgot extends CI_Controller
{

    public function __construct() {
        parent::__construct();
        //load language
        $this->load->model('Register_model');
        $this->lang->load('front/message', 'english');
    }
	
	public function index(){
		$get = $this->input->get();
		$redirect = isset($get['redirect']) ? $get['redirect'] : '';
		$siteUrl = base_url();
		$data = array(
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'site_url' => $siteUrl,
            'redirect' => $redirect,
            'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getsystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'content_block' => 'forgot'
        );
        $this->parser->parse('front/layout/column-2' , $data);
    }

	public function userAuth()
    {
        //check for foem validation
        $post = $this->input->post();
        $response = array();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Email or Mobile', 'required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
           $this->index();
        }
        else
        {
			$username = $post['username'];
			$chk_email_mobile =$this->db->query("SELECT * FROM tbl_users WHERE (username = '$username' or mobile = '$username' or email = '$username') and role_id = 2")->num_rows();
            if(!$chk_email_mobile)           
            {
				$this->Az->redirect('forgot', 'system_message_error',lang('FORGOT_FAILED'));   
            }
            else
            {
                $get_user_data =$this->db->query("SELECT * FROM tbl_users WHERE (username = '$username' or mobile = '$username'  or email = '$username') and role_id = 2")->row_array();
				if($get_user_data['is_active'] == 0)
				{
					$this->Az->redirect('forgot', 'system_message_error',lang('LOGIN_ACTIVE_FAILED'));   
				}
				elseif($get_user_data['is_verified'] == 0)
				{
					$this->Az->redirect('forgot', 'system_message_error',lang('LOGIN_VERIFY_FAILED'));   
				}
				else
				{
					$post = array();
					$post['mobile'] = $get_user_data['mobile'];
					$post['userID'] = $get_user_data['id'];
					$post['email'] = $get_user_data['email'];
					$status = $this->Register_model->sendForgotOTP($post);
					$this->Az->redirect('forgot/userOTPAuth/'.$status, 'system_message_error',lang('REGISTER_OTP_SEND_SUCCESS'));   
				}
                         
            }
			
        }
        
    
    }
	
	public function userOTPAuth($otp_code = ''){
		
		$chk_otp = $this->db->get_where('users_otp',array('encrypt_otp_code'=>$otp_code,'status'=>0))->num_rows();
		if(!$chk_otp)
		{
			$this->Az->redirect('forgot', 'system_message_error',lang('COMMON_ERROR'));   
		}
		
		$siteUrl = base_url();
		$data = array(
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'site_url' => $siteUrl,
            'encode_otp_code' => $otp_code,
            'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getsystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'content_block' => 'forgot-otp'
        );
        $this->parser->parse('front/layout/column-2' , $data);
    }
	
	public function userOTPAuthenticate()
    {
        //check for foem validation
        $post = $this->input->post();
        $response = array();
        $this->load->library('form_validation');
        $encode_otp_code = $post['encode_otp_code'];
        $this->form_validation->set_rules('otp_code', 'OTP Code', 'required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
           $this->userOTPAuth($encode_otp_code);
        }
        else
        {
            $chk_email_mobile =$this->db->get_where('users_otp',array('otp_code'=>$post['otp_code'],'status'=>0))->num_rows();
            if($chk_email_mobile)           
            {
				$get_otp_data =$this->db->get_where('users_otp',array('otp_code'=>$post['otp_code'],'status'=>0))->row_array();
				$this->db->where('id',$get_otp_data['id']);
				$this->db->update('users_otp',array('status'=>1));
				$this->Az->redirect('forgot/newPassword/'.$encode_otp_code, 'system_message_error',lang('FORGOT_OTP_VERIFY_SUCCESS'));   
            }
            else
            {
				$this->Az->redirect('forgot/userOTPAuth/'.$encode_otp_code, 'system_message_error',lang('OTP_ERROR'));   
                
            }
            
        }
        echo json_encode($response);
    
    }
	
	public function newPassword($otp_code = ''){
		
		$chk_otp = $this->db->get_where('users_otp',array('encrypt_otp_code'=>$otp_code,'status'=>1))->num_rows();
		if(!$chk_otp)
		{
			$this->Az->redirect('forgot', 'system_message_error',lang('COMMON_ERROR'));   
		}
		
		$siteUrl = base_url();
		$data = array(
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'site_url' => $siteUrl,
            'encode_otp_code' => $otp_code,
            'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getsystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'content_block' => 'update-password'
        );
        $this->parser->parse('front/layout/column-2' , $data);
    }
	
	public function updatePasswordAuth()
    {
        //check for foem validation
        $post = $this->input->post();
        $response = array();
        $this->load->library('form_validation');
        $encode_otp_code = $post['encode_otp_code'];
        $this->form_validation->set_rules('password', 'New Password', 'required|xss_clean');
        $this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|xss_clean|matches[password]');
        if ($this->form_validation->run() == FALSE) {
           $this->newPassword($encode_otp_code);
        }
        else
        {
            $chk_email_mobile = $this->db->get_where('users_otp',array('encrypt_otp_code'=>$encode_otp_code,'status'=>1))->num_rows();
            if($chk_email_mobile)           
            {
				$get_otp_data = $this->db->get_where('users_otp',array('encrypt_otp_code'=>$encode_otp_code,'status'=>1))->row_array();
				$post_data = (array) json_decode($get_otp_data['json_post_data']);
				
				if($post_data)
				{
					$this->db->where('id',$post_data['userID']);
					$this->db->update('users',array('password'=>do_hash($post['password']),'decode_password'=>$post['password']));
					$this->Az->redirect('login', 'system_message_error',lang('PASSWORD_UPDATE_SUCCESS'));   
				}
				else
				{
					$this->Az->redirect('forgot', 'system_message_error',lang('COMMON_ERROR'));   
				}
            }
            else
            {
				$this->Az->redirect('forgot', 'system_message_error',lang('COMMON_ERROR'));   
                
            }
            
        }
        echo json_encode($response);
    
    }

    
   
}
