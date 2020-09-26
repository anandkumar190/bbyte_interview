<?php
if(!defined('BASEPATH'))
    exit('No direct scrip access allowed');

/*
 * login Register controller for Frontend
 * 
 * this controller user for login, register, logout, forgot password, reset password
 * @author trilok
 */

class Register extends CI_Controller
{

    public function __construct() {
        parent::__construct();
        //load language
        $this->load->model('Register_model');
        #$this->lang->load('admin/dashboard', 'english');
        $this->lang->load('admin/member', 'english');
        $this->lang->load('front/message', 'english');
		$this->lang->load('front/recharge', 'english');
    }
	
	public function index(){
		
		$post = $this->input->get();
		$referral_id = isset($post['referral_id']) ? $post['referral_id'] : '';
		
		$referral_user_name = '';
		if($referral_id)
		{
			$get_referral_name = $this->db->get_where('users',array('role_id'=>2,'user_code'=>$referral_id))->row_array();
			$referral_user_name = isset($get_referral_name['name']) ? $get_referral_name['name'] : '';
		}
		
		$siteUrl = base_url();
		$data = array(
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'site_url' => $siteUrl,
            'referral_id' => $referral_id,
            'referral_user_name' => $referral_user_name,
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getsystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'content_block' => 'register'
        );
        $this->parser->parse('front/layout/column-2' , $data);
    }

    public function auth()
    {
        //check for foem validation
        $post = $this->input->post();
        $response = array();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Name', 'required|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'required|xss_clean|valid_email');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required|xss_clean|min_length[10]|max_length[10]');
        $this->form_validation->set_rules('password', 'Password', 'required|xss_clean');
        
        if ($this->form_validation->run() == FALSE) {
           $response = array(
            'status' => 0,
            'msg' => validation_errors()
           );
        }
        else
        {
            $chk_email_mobile =$this->db->query("SELECT * FROM tbl_users WHERE email = '$post[email]' or mobile = '$post[mobile]'")->num_rows();
            if($chk_email_mobile)           
            {
                $response = array(
                    'status' => 0,
                    'msg' => '<p>Sorry ! Email or Mobile already registered.</p>'
                   );
            }
            else
            {
                $status = $this->Register_model->sendOTP($post);
                         
                if($status == true)
                {   
                    $response = array(
                        'status' => 1,
                        'msg' => 'We have sent an OTP on your mobile no., please verify.'
                       );
                }
                else
                {
                    $response = array(
                        'status' => 0,
                        'msg' => lang('COMMON_ERROR')
                       );
                }
            }
            
        }
        echo json_encode($response);
    
    }

    public function otpAuth()
    {
        //check for foem validation
        $post = $this->input->post();
        $response = array();
        $this->load->library('form_validation');
       
        $this->form_validation->set_rules('otp_code', 'OTP Code', 'required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
           $response = array(
            'status' => 0,
            'msg' => validation_errors()
           );
        }
        else
        {
            $chk_email_mobile =$this->db->get_where('users_otp',array('otp_code'=>$post['otp_code'],'status'=>0))->num_rows();
            if($chk_email_mobile)           
            {
                $get_otp_data =$this->db->get_where('users_otp',array('otp_code'=>$post['otp_code'],'status'=>0))->row_array();
                $post_data = isset($get_otp_data['json_post_data']) ? json_decode($get_otp_data['json_post_data']) : array();

                if(!$post_data)
                {
                    $response = array(
                        'status' => 0,
                        'msg' => lang('MEMBER_ERROR')
                       );
                }
                else
                {

                    $email = trim(strtolower($post_data->email));
                    $mobile = $post_data->mobile;

                    $chk_user_email_mobile =$this->db->query("SELECT * FROM tbl_users WHERE email = '$email' or mobile = '$mobile'")->num_rows();
                    if($chk_user_email_mobile)           
                    {
                        $response = array(
                            'status' => 0,
                            'msg' => '<p>Sorry ! Email or Mobile already registered.</p>'
                           );
                    }
                    else
                    {
                        $status = $this->Register_model->registerMember($post);
                                 
                        if($status == true)
                        {
                            $get_user_data =$this->db->select('users.*')->join('users','users.mobile = users_otp.mobile')->get_where('users_otp',array('otp_code'=>$post['otp_code']))->row_array();
        					$this->session->set_userdata('cranesmart_member_session',$get_user_data);
                            $response = array(
                                'status' => 1,
                                'msg' => lang('MEMBER_SAVED')
                               );
                        }
                        else
                        {
                            $response = array(
                                'status' => 0,
                                'msg' => lang('MEMBER_ERROR')
                               );
                        }
                    }
                }
                
            }
            else
            {
                $response = array(
                    'status' => 0,
                    'msg' => '<p>Sorry ! OTP Code not valid.</p>'
                   );
            }
            
        }
        echo json_encode($response);
    
    }
	
	public function userAuth()
    {
        //check for foem validation
        $post = $this->input->post();
        log_message('debug', 'Front Register Post Data - '.json_encode($post));	
        $response = array();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Name', 'required|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'required|xss_clean|valid_email');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required|xss_clean|min_length[10]|max_length[10]');
        $this->form_validation->set_rules('password', 'Password', 'required|xss_clean');
        $this->form_validation->set_rules('referral_id', 'Referral ID', 'required|xss_clean|min_length[10]|max_length[10]');
        
        if ($this->form_validation->run() == FALSE) {
           $this->index();
        }
        else
        {
            
            $referral_id = $post['referral_id'];
            
            // check member id valid or not
            $chk_member = $this->db->get_where('users',array('role_id'=>2,'user_code'=>$referral_id))->num_rows();
            
            $chk_email_mobile =$this->db->query("SELECT * FROM tbl_users WHERE email = '$post[email]' or mobile = '$post[mobile]'")->num_rows();
            
            if($chk_email_mobile)           
            {
				log_message('debug', 'Front Register Mobile or  Email Already Exits');	
                if($post['is_referal_link']){
                    $this->Az->redirect('register?referral_id='.$post['referral_id'], 'system_message_error',lang('EMAIL_MOBILE_ALREDY_ERROR'));
                }   
                else
                {
                    $this->Az->redirect('register', 'system_message_error',lang('EMAIL_MOBILE_ALREDY_ERROR'));
                }
            }
            elseif(!$chk_member)           
            {
                log_message('debug', 'Front Register Referral Not Exits');	
                if($post['is_referal_link']){
                    $this->Az->redirect('register?referral_id='.$post['referral_id'], 'system_message_error',lang('REFERRAL_ID_ERROR'));
                }   
                else
                {
                    $this->Az->redirect('register', 'system_message_error',lang('REFERRAL_ID_ERROR'));
                }
            }
            else
            {
                log_message('debug', 'Front Register OTP Send Success.');	
                $status = $this->Register_model->referralRegisterSendOTP($post);
                         
                if($status)
                {  
					$this->Az->redirect('register/userOTPAuth/'.$status, 'system_message_error',lang('REGISTER_OTP_SEND_SUCCESS'));   
                    
                }
                else
                {
					$this->Az->redirect('register', 'system_message_error',lang('COMMON_ERROR'));   
                    
                }
            }
            
        }
        
    
    }
	
	public function userOTPAuth($otp_code = ''){
		
		$chk_otp = $this->db->get_where('users_otp',array('encrypt_otp_code'=>$otp_code,'status'=>0))->num_rows();
		if(!$chk_otp)
		{
			$this->Az->redirect('register', 'system_message_error',lang('COMMON_ERROR'));   
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
            'content_block' => 'register-otp'
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
                $post_data = isset($get_otp_data['json_post_data']) ? json_decode($get_otp_data['json_post_data']) : array();

                if(!$post_data)
                {
                    $this->Az->redirect('login', 'system_message_error',lang('COMMON_ERROR'));   
                }
                else
                {
                    $email = trim(strtolower($post_data->email));
                    $mobile = $post_data->mobile;

                    $chk_user_email_mobile =$this->db->query("SELECT * FROM tbl_users WHERE email = '$email' or mobile = '$mobile'")->num_rows();
                    if($chk_user_email_mobile)           
                    {
                        $this->Az->redirect('register', 'system_message_error',lang('EMAIL_MOBILE_ALREDY_ERROR'));   
                    }
                    else
                    {
                        $status = $this->Register_model->registerMember($post);
                                 
                        if($status == true)
                        {
        					$this->Az->redirect('login', 'system_message_error',lang('REGISTER_SUCCESS'));   
                            
                        }
                        else
                        {
                            $this->Az->redirect('login', 'system_message_error',lang('COMMON_ERROR'));   
                        }
                    }
                }
                
            }
            else
            {
				$this->Az->redirect('register/userOTPAuth/'.$encode_otp_code, 'system_message_error',lang('OTP_ERROR'));   
                
            }
            
        }
        echo json_encode($response);
    
    }
    
    public function sms_chk()
    {
        $otp_code = rand(1111,9999);
        $encrypt_otp_code = do_hash($otp_code);
        $mobile = '8104758957';
		$output = '';
        $sms = sprintf(lang('REGISTER_OPT_SEND_SMS'),$otp_code);
        //echo $api_url = SMS_API_URL.'authkey='.SMS_API_AUTH_KEY.'&mobiles=91'.$mobile.'&message='.urlencode($sms).'&sender='.SMS_API_SENDERID.'&route=4&country=0';
        
        echo $api_url = SMS_API_URL.'authkey='.SMS_AUTH_KEY.'&mobiles='.$mobile.'&message='.urlencode($sms).'&sender='.SMS_SENDER_ID.'&route=4&country=0';
    }

   
}
