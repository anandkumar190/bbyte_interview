<?php
if(!defined('BASEPATH'))
    exit('No direct scrip access allowed');

/*
 * login Register controller for Frontend
 * 
 * this controller user for login, register, logout, forgot password, reset password
 * @author trilok
 */

class Login extends CI_Controller{

    public function __construct() {
        parent::__construct();
		
        //load language
        $this->lang->load('front_common' , 'english');
        $this->lang->load('front_login' , 'english');
		//load Model
		$this->load->model('admin/Login_model');
    }

    public function index($uname_prefix = '' , $username = ''){
		
    	$user = $this->session->userdata('cranesmart_admin');
		if($user)
		{
			redirect('admin/dashboard');
		}

		
		$siteUrl = base_url();
		$data = array(
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'site_url' => $siteUrl,
            'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getsystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'content_block' => 'admin/block/login'
        );
        $this->parser->parse('admin/layout/login' , $data);
    }
	public function loginAuth()
	{
		
		$post = $this->input->post();

		//check for foem validation
        $this->load->library('form_validation');		
        $this->form_validation->set_rules('username', 'Username', 'required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE) {
			$this->index();
			return false;
        }
		else
		{
			// check username or password
			$status = $this->Login_model->adminLoginAuthentication($post);
			if($status)
			{
				if($status['role_id'] == 1){
					$this->session->set_userdata('cranesmart_admin',$status);
					$this->Az->redirect('admin/dashboard');

				}elseif($status['role_id'] == 6){
                    $this->session->set_userdata('cranesmart_staff',$status);
                    $this->Az->redirect('staff/dashboard');

                }else{
					$this->Az->redirect('admin/login', 'system_message_error', lang('FRONT_LOGIN_ACCESS_DENIED'));
				}
			}

			else
			{
				$this->Az->redirect('admin/login', 'system_message_error', lang('FRONT_LOGIN_FAILED'));
			}
		}
		
		
	}
}


/* End of file login.php */
/* Location: ./application/controllers/login.php */