<?php
if(!defined('BASEPATH'))
    exit('No direct scrip access allowed');

/*
 * login Register controller for Frontend
 * 
 * this controller user for login, register, logout, forgot password, reset password
 * @author trilok
 */

class Login extends CI_Controller
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
            'content_block' => 'login'
        );
        $this->parser->parse('front/layout/column-2' , $data);
    }

    public function auth()
    {
        //check for foem validation
        $post = $this->input->post();
        $response = array();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Email or Mobile', 'required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
           $response = array(
            'status' => 0,
            'msg' => validation_errors()
           );
        }
        else
        {
			$username = $post['username'];
			$password = do_hash($post['password']);
            $chk_email_mobile =$this->db->query("SELECT * FROM tbl_users WHERE (username = '$username' or mobile = '$username' or email = '$username') and password = '$password' and role_id = 2")->num_rows();
            if(!$chk_email_mobile)           
            {
                $response = array(
                    'status' => 0,
                    'msg' => '<p>Sorry ! Username or Password is Wrong.</p>'
                   );
            }
            else
            {
                $get_user_data =$this->db->query("SELECT * FROM tbl_users WHERE (username = '$username' or mobile = '$username'  or email = '$username') and password = '$password' and role_id = 2")->row_array();
				if($get_user_data['is_active'] == 0)
				{
					$response = array(
						'status' => 0,
						'msg' => '<p>Sorry ! Your account is not activated, please contact to administrator.</p>'
					   );
				}
				elseif($get_user_data['is_verified'] == 0)
				{
					$response = array(
						'status' => 0,
						'msg' => '<p>Sorry ! Your account is not verified, please contact to administrator.</p>'
					   );
				}
				else
				{
					$user_ip_address = $_SERVER['REMOTE_ADDR'];
					// update cart temp data
					$this->db->where('ip',$user_ip_address);
					$this->db->update('cart_temp_data',array('user_id'=>$get_user_data['id']));
					
					unset($get_user_data['password']);
                    unset($get_user_data['decode_password']);
                    unset($get_user_data['wallet_balance']);
                    unset($get_user_data['cm_points']);
					
					$this->session->set_userdata('cranesmart_member_session',$get_user_data);
					$response = array(
                        'status' => 1,
                        'msg' => 'Your are logged successfully.'
                       );
				}
                         
            }
            
        }
        echo json_encode($response);
    
    }
	
	public function userAuth()
    {
        //check for foem validation
        $post = $this->input->post();
        $response = array();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Email or Mobile', 'required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'required|xss_clean');
        $this->form_validation->set_rules('redirect', 'redirect', 'xss_clean');
        
        if ($this->form_validation->run() == FALSE) {
           $this->index();
        }
        else
        {
			$redirect = $post['redirect'];
			$username = $post['username'];
			$password = do_hash($post['password']);
			
		
			
            $chk_email_mobile =$this->db->query("SELECT * FROM tbl_users WHERE (username = '$username' or mobile = '$username' or email = '$username') and password = '$password' and role_id = 2")->num_rows();
            if(!$chk_email_mobile)           
            {
				if($redirect)
					$this->Az->redirect('login?redirect='.$redirect, 'system_message_error',lang('LOGIN_FAILED'));   
				else
					$this->Az->redirect('login', 'system_message_error',lang('LOGIN_FAILED'));   
            }
            else
            {
                $get_user_data =$this->db->query("SELECT * FROM tbl_users WHERE (username = '$username' or mobile = '$username'  or email = '$username') and password = '$password' and role_id = 2")->row_array();
				if($get_user_data['is_active'] == 0)
				{
					if($redirect)
						$this->Az->redirect('login?redirect='.$redirect, 'system_message_error',lang('LOGIN_ACTIVE_FAILED'));   
					else
						$this->Az->redirect('login', 'system_message_error',lang('LOGIN_ACTIVE_FAILED'));   
					
				}
				elseif($get_user_data['is_verified'] == 0)
				{
					if($redirect)
						$this->Az->redirect('login?redirect='.$redirect, 'system_message_error',lang('LOGIN_VERIFY_FAILED'));   
					else
						$this->Az->redirect('login', 'system_message_error',lang('LOGIN_VERIFY_FAILED'));   
					
				}
				else
				{
				    
				    unset($get_user_data['password']);
                    unset($get_user_data['decode_password']);
                    unset($get_user_data['wallet_balance']);
                    unset($get_user_data['cm_points']);
					$this->session->set_userdata('cranesmart_member_session',$get_user_data);
					if($redirect)
						$this->Az->redirect($redirect, 'system_message_error','');   
					else
						$this->Az->redirect('member/profile', 'system_message_error','');   
					
				}
                         
            }
			
        }
        
    
    }

    
   
}
