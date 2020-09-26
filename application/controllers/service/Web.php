<?php
ob_start();
if(!defined('BASEPATH'))
    exit('No direct scrip access allowed');

/*
 * login Register controller for Frontend
 * 
 * this controller user for login, register, logout, forgot password, reset password
 * @author trilok
 */

class Web extends CI_Controller{

    public function __construct() {
        parent::__construct();
        //load language
		$this->lang->load('admin/api', 'english');
		$this->load->model('admin/Api_model');	
		
    }

    public function version()
	{
		$data = array();
		$country_data = array();
		// get country list
		$country_list = $this->db->get('api_version')->row_array();
		$response = array(
			'oldVersion' => $country_list['old_version'],
			'newVersion' => $country_list['new_version']
		);
				
		
		echo json_encode(array($response));
	}
	
	
	public function loginAuth(){
		
		$response = array();
		$post = $this->input->post();
		log_message('debug', 'Login API Post Data - '.json_encode($post));	
		$this->load->library('form_validation');
		//$this->form_validation->set_data($this->input->get());
		$this->form_validation->set_rules('username', 'Username', 'required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE)
		{
			$response = array(
				'status' => 0,
				'message' => lang('LOGIN_VALID_FAILED')
			);
		}
		else
		{
			$password = do_hash($post['password']);
			$username = $post['username'];
            // check user credential
			$chk_user_credential =$this->db->query("SELECT * FROM tbl_users WHERE (username = '$username' or mobile = '$username' or email = '$username') and password = '$password' and role_id = 2")->num_rows();
            if(!$chk_user_credential)
            {
				$response = array(
					'status' => 0,
					'message' => lang('LOGIN_FAILED')
				);
                
            }
			else
			{
				$get_user_data =$this->db->query("SELECT * FROM tbl_users WHERE (username = '$username' or mobile = '$username'  or email = '$username') and password = '$password' and role_id = 2")->row_array();
				$is_active = isset($get_user_data['is_active']) ? $get_user_data['is_active'] : 0 ;
				if(!$is_active)
				{
					$response = array(
						'status' => 0,
						'message' => lang('PROFILE_ACTIVE_ERROR')
					);
				}
				else
				{
					$response = array(
						'status' => 1,
						'message' => 'Success',
						'userID' => $get_user_data['id'],
						'name' => $get_user_data['name'],
						'email' => $get_user_data['email'],
						'mobile' => $get_user_data['mobile'],
					);
				}
			}
			
		}
		log_message('debug', 'Login API Response - '.json_encode($response));	
		echo json_encode($response);
		
    }
	
	public function userRegAuth()
	{
		$response = array();
		$post = $this->input->post();
		log_message('debug', 'User Register API Post Data - '.json_encode($post));	
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Name', 'required|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'required|xss_clean|valid_email');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required|xss_clean|min_length[10]|max_length[10]');
        $this->form_validation->set_rules('password', 'Password', 'required|xss_clean');
        $this->form_validation->set_rules('referral_id', 'Referral ID', 'required|xss_clean|min_length[10]|max_length[10]');
        if ($this->form_validation->run() == FALSE)
		{
			$response = array(
				'status' => 0,
				'message' => lang('LOGIN_VALID_FAILED')
			);
		}
		else
		{
			$referral_id = $post['referral_id'];
            
            // check member id valid or not
            $chk_member = $this->db->get_where('users',array('role_id'=>2,'user_code'=>$referral_id))->num_rows();

			$chk_email_mobile =$this->db->query("SELECT * FROM tbl_users WHERE email = '$post[email]' or mobile = '$post[mobile]'")->num_rows();
			if($chk_email_mobile)
			{
				$response = array(
					'status' => 0,
					'message' => lang('MEMBER_MOBILE_ALREDY_EXITS')
				);
			}
			elseif(!$chk_member)           
            {
            	$response = array(
					'status' => 0,
					'message' => lang('MEMBER_MOBILE_ALREDY_EXITS')
				);
            }
			else
			{
				$status = $this->Api_model->sendRegisterOTP($post);
				$response = array(
					'status' => 1,
					'message' => 'Success'
				);
			}
		}
		log_message('debug', 'User Register API Response - '.json_encode($response));	
		echo json_encode($response);
	}

	public function registerOTPAuth(){
		
		$response = array();
		$post = $this->input->post();
		log_message('debug', 'Register OTP API Post Data - '.json_encode($post));	
		$this->load->library('form_validation');
		//$this->form_validation->set_data($this->input->get());
		$this->form_validation->set_rules('otp', 'OTP', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE)
		{
			$response = array(
				'status' => 0,
				'message' => lang('LOGIN_VALID_FAILED')
			);
		}
		else
		{
			$chk_email_mobile =$this->db->get_where('users_otp',array('otp_code'=>$post['otp'],'status'=>0))->num_rows();
            if($chk_email_mobile)           
            {
				$get_otp_data =$this->db->get_where('users_otp',array('otp_code'=>$post['otp'],'status'=>0))->row_array();

				$post_data = (array) json_decode($get_otp_data['json_post_data']);

				$this->db->where('id',$get_otp_data['id']);
				$this->db->update('users_otp',array('status'=>1));

				$user_display_id = $this->User->generate_unique_member_id();

				$data = array(
					'role_id' => 2,
					'user_code'          =>  $user_display_id,      
					'name' => $post_data['name'],
					'username' => $user_display_id,
					'password' => do_hash($post_data['password']),
					'decode_password' => $post_data['password'],
					'email' => trim(strtolower($post_data['email'])),
					'mobile' => $post_data['mobile'],
					'is_active' => 1,
					'is_verified'=>1,
					'wallet_balance'=>0,
					'is_api_user' => 1,
					'created' => date('Y-m-d H:i:s')
				);
				$this->db->insert('users',$data);
				$member_id = $this->db->insert_id();
				
				// update cm points wallet
				$before_balance = 0;
				// get default package cm points
				$get_cm_points = $this->db->get_where('package',array('id'=>1))->row_array();
				$cm_points = isset($get_cm_points['cm_points']) ? $get_cm_points['cm_points'] : 0;
				$after_balance = $cm_points + $before_balance;
				
				$wallet_data = array(
					'member_id'           => $member_id,    
					'before_balance'      => $before_balance,
					'amount'              => $cm_points,  
					'after_balance'       => $after_balance,      
					'status'              => 1,
					'type'                => 1,      
					'wallet_type'		  => 2,
					'created'             => date('Y-m-d H:i:s'),      
					'credited_by'         => $member_id,
					'description'         => 'Registration Free Bonus Points'
	            );
				$this->db->insert('member_wallet',$wallet_data);

	            $user_wallet = array(
					'cm_points'=>$after_balance,        
	            );    

	            $this->db->where('id',$member_id);
	            $this->db->update('users',$user_wallet); 
				
				$referral_id = isset($post_data['referral_id']) ? trim($post_data['referral_id']) : '';
				
				$parent_id = 1;
				$reffrel_id = 1;
				$referal_current_package_id = 1;
				
				if($referral_id)
				{
					// check member id valid or not
					$chk_member = $this->db->get_where('users',array('role_id'=>2,'user_code'=>$referral_id))->num_rows();
					if($chk_member)
					{
						$get_member_id = $this->db->select('id,current_package_id')->get_where('users',array('role_id'=>2,'user_code'=>$referral_id))->row_array();
						$parent_id = isset($get_member_id['id']) ? $get_member_id['id'] : 0 ;
						$reffrel_id = isset($get_member_id['id']) ? $get_member_id['id'] : 0 ;
						$referal_current_package_id = isset($get_member_id['current_package_id']) ? $get_member_id['current_package_id'] : 0 ;
					}
					
				}
				
				// save member tree
				$tree_data = array(
					'member_id' => $member_id,
					'parent_id' => $parent_id,
					'reffrel_id'=> $reffrel_id,
					'position'  => 'L',
					'created'   => date('Y-m-d H:i:s')     
				);
				$this->db->insert('member_tree',$tree_data);
				
				// get default package cm points
				$get_cm_points = $this->db->get_where('package',array('id'=>$referal_current_package_id))->row_array();
				$refer_cm_points = isset($get_cm_points['refer_cm_points']) ? $get_cm_points['refer_cm_points'] : 0;
				
				// update referal cm wallet
				// get referal before balance
				$get_before_balance = $this->db->get_where('users',array('id'=>$reffrel_id))->row_array();
				$before_balance = isset($get_before_balance['cm_points']) ? $get_before_balance['cm_points'] : 0 ;
				$after_balance = $refer_cm_points + $before_balance;
				$wallet_data = array(
					'member_id'           => $reffrel_id,    
					'before_balance'      => $before_balance,
					'amount'              => $refer_cm_points,  
					'after_balance'       => $after_balance,      
					'status'              => 1,
					'type'                => 1,      
					'wallet_type'		  => 2,
					'created'             => date('Y-m-d H:i:s'),      
					'credited_by'         => $member_id,
					'description'         => 'Registration Referal Free Bonus Points'
	            );
				$this->db->insert('member_wallet',$wallet_data);

	            $user_wallet = array(
					'cm_points'=>$after_balance,        
	            );    

	            $this->db->where('id',$reffrel_id);
	            $this->db->update('users',$user_wallet);

	            $output = '';
		        $mobile = $post_data['mobile'];
		        $sms = sprintf(lang('SIGNUP_SUCCESS_SMS'),$user_display_id);
		        
		        $api_url = SMS_API_URL.'receiver='.$mobile.'&sms='.urlencode($sms);

		        $ch = curl_init();
		        curl_setopt($ch, CURLOPT_URL, $api_url);
		        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
		        $output = curl_exec($ch); 
		        curl_close($ch);

		        $response = array(
					'status' => 1,
					'message' => 'Success'
				);
				
            }
            else
            {
            	$response = array(
					'status' => 0,
					'message' => lang('OTP_ERROR')
				);
				
            }
			
		}
		log_message('debug', 'Register OTP API Response - '.json_encode($response));	
		echo json_encode($response);
		
    }

	public function forgotAuth(){
		
		$response = array();
		$post = $this->input->post();
		log_message('debug', 'Forgot API Post Data - '.json_encode($post));	
		$this->load->library('form_validation');
		//$this->form_validation->set_data($this->input->get());
		$this->form_validation->set_rules('mobile', 'Mobile', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE)
		{
			$response = array(
				'status' => 0,
				'message' => lang('LOGIN_VALID_FAILED')
			);
		}
		else
		{
			$username = $post['mobile'];
			$chk_email_mobile =$this->db->query("SELECT * FROM tbl_users WHERE (username = '$username' or mobile = '$username' or email = '$username') and role_id = 2")->num_rows();
            if(!$chk_email_mobile)           
            {
				$response = array(
					'status' => 0,
					'message' => lang('FORGOT_ERROR')
				);
            }
            else
            {
                $get_user_data =$this->db->query("SELECT * FROM tbl_users WHERE (username = '$username' or mobile = '$username'  or email = '$username') and role_id = 2")->row_array();
				if($get_user_data['is_active'] == 0)
				{
					$response = array(
						'status' => 0,
						'message' => lang('ACCOUNT_ACTIVE_ERROR')
					);
				}
				else
				{
					$post = array();
					$post['mobile'] = $get_user_data['mobile'];
					$post['userID'] = $get_user_data['id'];
					$status = $this->Api_model->sendForgotOTP($post);
					$response = array(
						'status' => 1,
						'message' => lang('REGISTER_OTP_SEND_SUCCESS')
					);
					
				}
                         
            }
			
		}
		log_message('debug', 'Forgot API Response - '.json_encode($response));	
		echo json_encode($response);
		
    }

    public function forgotOTPAuth(){
		
		$response = array();
		$post = $this->input->post();
		log_message('debug', 'Forgot OTP API Post Data - '.json_encode($post));	
		$this->load->library('form_validation');
		//$this->form_validation->set_data($this->input->get());
		$this->form_validation->set_rules('otp', 'OTP', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE)
		{
			$response = array(
				'status' => 0,
				'message' => lang('LOGIN_VALID_FAILED')
			);
		}
		else
		{
			$chk_email_mobile =$this->db->get_where('users_otp',array('otp_code'=>$post['otp'],'status'=>0))->num_rows();
            if($chk_email_mobile)           
            {
				$get_otp_data =$this->db->get_where('users_otp',array('otp_code'=>$post['otp'],'status'=>0))->row_array();

				$post_data = (array) json_decode($get_otp_data['json_post_data']);

				$this->db->where('id',$get_otp_data['id']);
				$this->db->update('users_otp',array('status'=>1));
				$response = array(
					'status' => 1,
					'message' => lang('FORGOT_OTP_VERIFY_SUCCESS'),
					'userID' => $post_data['userID']
				);
				
            }
            else
            {
            	$response = array(
					'status' => 0,
					'message' => lang('OTP_ERROR')
				);
				
            }
			
		}
		log_message('debug', 'Forgot OTP API Response - '.json_encode($response));	
		echo json_encode($response);
		
    }

    public function updatePasswordAuth(){
		
		$response = array();
		$post = $this->input->post();
		log_message('debug', 'Update Password API Post Data - '.json_encode($post));	
		$this->load->library('form_validation');
		//$this->form_validation->set_data($this->input->get());
		$this->form_validation->set_rules('userID', 'User ID', 'required|xss_clean');
		$this->form_validation->set_rules('password', 'New Password', 'required|xss_clean');
        $this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|xss_clean|matches[password]');
		if ($this->form_validation->run() == FALSE)
		{
			$response = array(
				'status' => 0,
				'message' => lang('LOGIN_VALID_FAILED')
			);
		}
		else
		{
			$this->db->where('id',$post['userID']);
			$this->db->update('users',array('password'=>do_hash($post['password']),'decode_password'=>$post['password']));
			$response = array(
				'status' => 1,
				'message' => lang('PASSWORD_UPDATE_SUCCESS')
			);
			
		}
		log_message('debug', 'Update Password API Response - '.json_encode($response));	
		echo json_encode($response);
		
    }

    public function operatorList()
    {
        /*
		Type - Prepaid, Postpaid for Mobile
		Type - DTH
		Type - Datacard
		Type - Landline
		Type - Electricity
    	*/
    	$post = $this->input->post();
    	
		log_message('debug', 'Get Operator List API Post Data - '.json_encode($_POST));	
		
		$type = isset($post['type']) ? $post['type'] : '';
    	$response = array();
		$operator = $this->db->get_where('operator',array('type'=>$type))->result_array();
		
		$data = array();
		if($operator)
		{
			foreach ($operator as $key => $value) {
				$data[$key]['name'] = $value['operator_name'];
				$data[$key]['code'] = $value['operator_code'];
			}
		}

		$response = array(
			'status' => 1,
			'message' => 'Success',
			'data' => $data
		);
		log_message('debug', 'Get Operator List API Response - '.json_encode($response));	
		echo json_encode($response);
    }


    public function circleList()
    {
    	$response = array();
		$operator = $this->db->get('circle')->result_array();
		
		$data = array();
		if($operator)
		{
			foreach ($operator as $key => $value) {
				$data[$key]['name'] = $value['circle_name'];
				$data[$key]['code'] = $value['circle_code'];
			}
		}

		$response = array(
			'status' => 1,
			'message' => 'Success',
			'data' => $data
		);
		echo json_encode($response);
    }


    public function getElectricityOperatorForm()
	{
		$post = $this->input->post();
		log_message('debug', 'Electricity Biller Form API Post Data - '.json_encode($post));	
		$operator_code = isset($post['code']) ? $post['code'] : '';
		$response = $this->User->getElectricityOperatorDetail($operator_code);
		log_message('debug', 'Electricity Biller Form API Response - '.json_encode($response));	
		echo json_encode($response);
	}

	public function getElectricityBillerDetail()
	{
		$post = $this->input->post();
		log_message('debug', 'Electricity Biller Detail API Post Data - '.json_encode($post));	
		$account_number = isset($post['account_number']) ? $post['account_number'] : '';
		$operator_code = isset($post['code']) ? $post['code'] : '';
		$userID = isset($post['userID']) ? $post['userID'] : 0;
		$response = $this->User->getElectricityOperatorBillerDetail($operator_code,$account_number,$userID);
		log_message('debug', 'Electricity Biller Detail API Response - '.json_encode($response));	
		echo json_encode($response);

	}

    function maximumCheck($num)
	{
		if ($num < 1)
		{
			$this->form_validation->set_message(
							'maximumCheck',
							'The %s field must be grater than 10'
						);
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}


    public function rechargeAuth(){
		
		$response = array();
		$post = $this->input->post();
		log_message('debug', 'Recharge API Post Data - '.json_encode($post));	
		$this->load->library('form_validation');
		$this->form_validation->set_rules('userID', 'User ID', 'required|xss_clean');
		$this->form_validation->set_rules('type', 'Type', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			$response = array(
				'status' => 0,
				'message' => lang('LOGIN_VALID_FAILED')
			);
		}
		else
		{
		    
			$userID = $post['userID'];
			$type = $post['type'];
			/* Type = 1 for Mobile */
			/* Type = 2 for DTH */
			/* Type = 3 for Datacard */
			/* Type = 5 for Landline */
			/* Type = 7 for Electricity */
			if($post['type'] == 1)
			{
				$this->load->library('form_validation');
				$this->form_validation->set_rules('mobile', 'Mobile Number', 'required|numeric|max_length[12]|xss_clean');
				$this->form_validation->set_rules('rechargeType', 'Recharge Type', 'required');
				$this->form_validation->set_rules('operator', 'Operator', 'required');
		        $this->form_validation->set_rules('circle', 'Circle', 'required');
		        $this->form_validation->set_rules('amount', 'Amount', 'required|numeric|callback_maximumCheck');
				if ($this->form_validation->run() == FALSE)
				{
					$response = array(
						'status' => 0,
						'message' => lang('LOGIN_VALID_FAILED')
					);
				}
				else
				{
					if($post['rechargeType'] == 2 && (!isset($post['acnumber']) || $post['acnumber'] == ''))
					{
						$response = array(
							'status' => 0,
							'message' => lang('LOGIN_VALID_FAILED')
						);
					}
					else
					{
						
						// check user valid or not
						$chk_user = $this->db->get_where('users',array('id'=>$userID))->num_rows();
						if($chk_user)
						{
							$chk_wallet_balance = $this->db->get_where('users',array('id'=>$userID))->row_array();

				            if($chk_wallet_balance['wallet_balance'] < $post['amount']){

								$response = array(
									'status' => 0,
									'message' => lang('WALLET_ERROR')
								);
							}
							else
							{
								// send recharge OTP
								$status = $this->Api_model->sendRechargeOTP($post,$userID);
								$response = array(
									'status' => 1,
									'message' => lang('RECHARGE_OTP_SEND_SUCCESS')
								);
								
							}
						}  
						else
						{
							$response = array(
								'status' => 0,
								'message' => lang('USER_ID_ERROR')
							);
						}
					}
				}
			}
			elseif($post['type'] == 2)
			{
				$this->load->library('form_validation');
				$this->form_validation->set_rules('operator', 'Operator', 'required');
		        $this->form_validation->set_rules('circle', 'Circle', 'required');
				$this->form_validation->set_rules('cardNumber', 'Card Number', 'required|xss_clean');
		        $this->form_validation->set_rules('amount', 'Amount', 'required|numeric|callback_maximumCheck');
				if ($this->form_validation->run() == FALSE)
				{
					$response = array(
						'status' => 0,
						'message' => lang('LOGIN_VALID_FAILED')
					);
				}
				else
				{
					// check user valid or not
					$chk_user = $this->db->get_where('users',array('id'=>$userID))->num_rows();
					if($chk_user)
					{
						$chk_wallet_balance = $this->db->get_where('users',array('id'=>$userID))->row_array();

			            if($chk_wallet_balance['wallet_balance'] < $post['amount']){

							$response = array(
								'status' => 0,
								'message' => lang('WALLET_ERROR')
							);
						}
						else
						{
							// send recharge OTP
							$status = $this->Api_model->sendRechargeOTP($post,$userID);
							$response = array(
								'status' => 1,
								'message' => lang('RECHARGE_OTP_SEND_SUCCESS')
							);
							
						}
					}  
					else
					{
						$response = array(
							'status' => 0,
							'message' => lang('USER_ID_ERROR')
						);
					}
				}
			}
			elseif($post['type'] == 3)
			{
				$this->load->library('form_validation');
				$this->form_validation->set_rules('operator', 'Operator', 'required');
		        $this->form_validation->set_rules('circle', 'Circle', 'required');
				$this->form_validation->set_rules('cardNumber', 'Card Number', 'required|xss_clean');
		        $this->form_validation->set_rules('amount', 'Amount', 'required|numeric|callback_maximumCheck');
		        $this->form_validation->set_rules('rechargeType', 'Recharge Type', 'required');
				if ($this->form_validation->run() == FALSE)
				{
					$response = array(
						'status' => 0,
						'message' => lang('LOGIN_VALID_FAILED')
					);
				}
				else
				{
					// check user valid or not
					$chk_user = $this->db->get_where('users',array('id'=>$userID))->num_rows();
					if($chk_user)
					{
						$chk_wallet_balance = $this->db->get_where('users',array('id'=>$userID))->row_array();

			            if($chk_wallet_balance['wallet_balance'] < $post['amount']){

							$response = array(
								'status' => 0,
								'message' => lang('WALLET_ERROR')
							);
						}
						else
						{
							// send recharge OTP
							$status = $this->Api_model->sendRechargeOTP($post,$userID);
							$response = array(
								'status' => 1,
								'message' => lang('RECHARGE_OTP_SEND_SUCCESS')
							);
							
						}
					}  
					else
					{
						$response = array(
							'status' => 0,
							'message' => lang('USER_ID_ERROR')
						);
					}
				}
			}
			elseif($post['type'] == 5)
			{
				$this->load->library('form_validation');
				$this->form_validation->set_rules('operator', 'Operator', 'required');
		        $this->form_validation->set_rules('circle', 'Circle', 'required');
				$this->form_validation->set_rules('number', 'Telephone Number', 'required|xss_clean');
		        $this->form_validation->set_rules('amount', 'Amount', 'required|numeric|callback_maximumCheck');
		        if ($this->form_validation->run() == FALSE)
				{
					$response = array(
						'status' => 0,
						'message' => lang('LOGIN_VALID_FAILED')
					);
				}
				else
				{
					// check user valid or not
					$chk_user = $this->db->get_where('users',array('id'=>$userID))->num_rows();
					if($chk_user)
					{
						$chk_wallet_balance = $this->db->get_where('users',array('id'=>$userID))->row_array();

			            if($chk_wallet_balance['wallet_balance'] < $post['amount']){

							$response = array(
								'status' => 0,
								'message' => lang('WALLET_ERROR')
							);
						}
						else
						{
							// send recharge OTP
							$status = $this->Api_model->sendRechargeOTP($post,$userID);
							$response = array(
								'status' => 1,
								'message' => lang('RECHARGE_OTP_SEND_SUCCESS')
							);
							
						}
					}  
					else
					{
						$response = array(
							'status' => 0,
							'message' => lang('USER_ID_ERROR')
						);
					}
				}
			}
			elseif($post['type'] == 7)
			{
				$this->load->library('form_validation');
				$this->form_validation->set_rules('operator', 'Operator', 'required');
		        $this->form_validation->set_rules('account_number', 'Account Number', 'required');
		        $this->form_validation->set_rules('customer_name', 'Customer Number', 'required');
		        $this->form_validation->set_rules('reference_id', 'Reference ID', 'required');
				$this->form_validation->set_rules('amount', 'Amount', 'required|numeric|callback_maximumCheck');
		        if ($this->form_validation->run() == FALSE)
				{
					$response = array(
						'status' => 0,
						'message' => lang('LOGIN_VALID_FAILED')
					);
				}
				else
				{
					// check user valid or not
					$chk_user = $this->db->get_where('users',array('id'=>$userID))->num_rows();
					if($chk_user)
					{
						$chk_wallet_balance = $this->db->get_where('users',array('id'=>$userID))->row_array();
						$mobile = $chk_wallet_balance['mobile'];

			            if($chk_wallet_balance['wallet_balance'] < $post['amount']){

							$response = array(
								'status' => 0,
								'message' => lang('WALLET_ERROR')
							);
						}
						else
						{
							// send recharge OTP
							$status = $this->Api_model->sendRechargeOTP($post,$userID);
							$response = array(
								'status' => 1,
								'message' => lang('RECHARGE_OTP_SEND_SUCCESS')
							);

							
						}
					}  
					else
					{
						$response = array(
							'status' => 0,
							'message' => lang('USER_ID_ERROR')
						);
					}
				}
			}
			
		}
		log_message('debug', 'Recharge API Response - '.json_encode($response));	
		echo json_encode($response);
		
    }

    public function rechargeOTPAuth(){
		
		$response = array();
		$post = $this->input->post();
		log_message('debug', 'Recharge OTP API Post Data - '.json_encode($post));	
		$this->load->library('form_validation');
		$this->form_validation->set_rules('userID', 'User ID', 'required|xss_clean');
		$this->form_validation->set_rules('otp', 'OTP', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE)
		{
			$response = array(
				'status' => 0,
				'message' => lang('LOGIN_VALID_FAILED')
			);
		}
		else
		{
			$userID = $post['userID'];
			$encrypt_otp_code = do_hash($post['otp']);
			// check user valid or not
			$chk_user = $this->db->get_where('users',array('id'=>$userID))->num_rows();
			if($chk_user)
			{
				$chk_email_mobile = $this->db->get_where('recharge_otp',array('userID'=>$userID,'encrypt_otp_code'=>$encrypt_otp_code,'status'=>0))->num_rows();
	            if($chk_email_mobile)           
	            {
					$get_otp_data = $this->db->get_where('recharge_otp',array('userID'=>$userID,'encrypt_otp_code'=>$encrypt_otp_code,'status'=>0))->row_array();

					$post_data = (array) json_decode($get_otp_data['json_post_data']);

					$this->db->where('id',$get_otp_data['id']);
					$this->db->update('recharge_otp',array('status'=>1));

					$type = $post_data['type'];
					if($post_data['type'] == 1)
					{
						
						if($post_data['rechargeType'] == 2 && (!isset($post_data['acnumber']) || $post_data['acnumber'] == ''))
						{
							$response = array(
								'status' => 0,
								'message' => lang('LOGIN_VALID_FAILED')
							);
						}
						else
						{
							
							
							$chk_wallet_balance = $this->db->get_where('users',array('id'=>$userID))->row_array();

				            if($chk_wallet_balance['wallet_balance'] < $post_data['amount']){

								$response = array(
									'status' => 0,
									'message' => lang('WALLET_ERROR')
								);
							}
							else
							{
								// generate recharge unique id
					            $recharge_unique_id = rand(1111,9999).time();

								$data = array(
									'member_id'          => $userID,
									'recharge_type'      => $type,
									'recharge_subtype'   => $post_data['rechargeType'],
									'recharge_display_id'=> $recharge_unique_id,
									'mobile'             => $post_data['mobile'],
									'account_number'     => isset($post_data['acnumber']) ? $post_data['acnumber'] : '',
									'operator_code'      => $post_data['operator'],
									'circle_code'        => $post_data['circle'],
									'amount'             => $post_data['amount'],
									'status'         	 => 1,
									'is_from_app'		 =>	1,
									'created'            => date('Y-m-d H:i:s')                  
								);

								$this->db->insert('recharge_history',$data);
								$recharge_id = $this->db->insert_id();

					            if($post_data['rechargeType'] == 1){
									$mobile = $post_data['mobile'];
									$operator_code = $post_data['operator'];
									$circle_code = $post_data['circle'];
									$amount = $post_data['amount'];
									// call recharge API
									$api_response = $this->User->prepaid_rechage_api($mobile,$operator_code,$circle_code,$amount,$recharge_unique_id,$userID);
								}
								elseif($post_data['rechargeType'] == 2){
									$mobile = $post_data['mobile'];
									$operator_code = $post_data['operator'];
									$circle_code = $post_data['circle'];
									$amount = $post_data['amount'];
									$account = $post_data['acnumber'];
									// call recharge API
									$api_response = $this->User->postpaid_rechage_api($mobile,$operator_code,$circle_code,$amount,$account,$recharge_unique_id,$userID);
								}

					            if(isset($api_response['status']) && ($api_response['status'] == 1 || $api_response['status'] == 2))
								{
									$before_balance = $this->db->get_where('users',array('id'=>$userID))->row_array();

									$after_balance = $before_balance['wallet_balance'] - $post_data['amount'];    

									$wallet_data = array(
										'member_id'           => $userID,    
										'before_balance'      => $before_balance['wallet_balance'],
										'amount'              => $post_data['amount'],  
										'after_balance'       => $after_balance,      
										'status'              => 1,
										'type'                => 2,      
										'created'             => date('Y-m-d H:i:s'),      
										'description'         => 'Recharge #'.$recharge_unique_id.' Amount Deducted.'
									);

									$this->db->insert('member_wallet',$wallet_data);

									$user_wallet = array(
										'wallet_balance'=>$after_balance,        
									);    
									$this->db->where('id',$userID);
									$this->db->update('users',$user_wallet);
									if($api_response['status'] == 1){
										// update recharge status
										$this->db->where('id',$recharge_id);
										$this->db->where('recharge_display_id',$recharge_unique_id);
										$this->db->update('recharge_history',array('txid'=>$api_response['txid'],'operator_ref'=>$api_response['operator_ref'],'api_response_id'=>$api_response['api_response_id']));
										
										$response = array(
											'status' => 1,
											'message' => lang('RECHARGE_PENDING')
										);
										
									}
									else
									{
										// update recharge status
										$this->db->where('id',$recharge_id);
										$this->db->where('recharge_display_id',$recharge_unique_id);
										$this->db->update('recharge_history',array('status'=>2,'txid'=>$api_response['txid'],'operator_ref'=>$api_response['operator_ref'],'api_response_id'=>$api_response['api_response_id']));
										
										// add 100% CM Points
										$this->User->recharge_cm_points_add($userID,$post_data['amount'],'Mobile',$recharge_unique_id);
										
										$response = array(
											'status' => 1,
											'message' => lang('RECHARGE_SUCCESS')
										);

									}
								}
								else
								{
									// update recharge status
									$this->db->where('id',$recharge_id);
									$this->db->where('recharge_display_id',$recharge_unique_id);
									$this->db->update('recharge_history',array('status'=>3));
									
									$response = array(
										'status' => 0,
										'message' => lang('RECHARGE_FAILED')
									);
								}
							}
							
						}
						
					}
					elseif($post_data['type'] == 2)
					{
						
						
						$chk_wallet_balance = $this->db->get_where('users',array('id'=>$userID))->row_array();

			            if($chk_wallet_balance['wallet_balance'] < $post_data['amount']){

							$response = array(
								'status' => 0,
								'message' => lang('WALLET_ERROR')
							);
						}
						else
						{
							// generate recharge unique id
				            $recharge_unique_id = rand(1111,9999).time();

							$data = array(
								'member_id'          => $userID,
								'recharge_type'      => $type,
								'recharge_display_id'=> $recharge_unique_id,
								'mobile'             => $post_data['cardNumber'],
								'account_number'     => isset($post_data['acnumber']) ? $post_data['acnumber'] : '',
								'operator_code'      => $post_data['operator'],
								'circle_code'        => $post_data['circle'],
								'amount'             => $post_data['amount'],
								'status'         	 => 1,
								'created'            => date('Y-m-d H:i:s')                  
							);

							$this->db->insert('recharge_history',$data);
							$recharge_id = $this->db->insert_id();

				            
							$mobile = $post_data['cardNumber'];
							$operator_code = $post_data['operator'];
							$circle_code = $post_data['circle'];
							$amount = $post_data['amount'];
							// call recharge API
							$api_response = $this->User->prepaid_rechage_api($mobile,$operator_code,$circle_code,$amount,$recharge_unique_id,$userID);

				            if(isset($api_response['status']) && ($api_response['status'] == 1 || $api_response['status'] == 2))
							{
								$before_balance = $this->db->get_where('users',array('id'=>$userID))->row_array();

								$after_balance = $before_balance['wallet_balance'] - $post_data['amount'];    

								$wallet_data = array(
									'member_id'           => $userID,    
									'before_balance'      => $before_balance['wallet_balance'],
									'amount'              => $post_data['amount'],  
									'after_balance'       => $after_balance,      
									'status'              => 1,
									'type'                => 2,      
									'created'             => date('Y-m-d H:i:s'),      
									'description'         => 'Recharge #'.$recharge_unique_id.' Amount Deducted.'
								);

								$this->db->insert('member_wallet',$wallet_data);

								$user_wallet = array(
									'wallet_balance'=>$after_balance,        
								);    
								$this->db->where('id',$userID);
								$this->db->update('users',$user_wallet);
								if($api_response['status'] == 1){
									// update recharge status
									$this->db->where('id',$recharge_id);
									$this->db->where('recharge_display_id',$recharge_unique_id);
									$this->db->update('recharge_history',array('txid'=>$api_response['txid'],'operator_ref'=>$api_response['operator_ref'],'api_response_id'=>$api_response['api_response_id']));
									
									$response = array(
										'status' => 1,
										'message' => lang('RECHARGE_PENDING')
									);
									
								}
								else
								{
									// update recharge status
									$this->db->where('id',$recharge_id);
									$this->db->where('recharge_display_id',$recharge_unique_id);
									$this->db->update('recharge_history',array('status'=>2,'txid'=>$api_response['txid'],'operator_ref'=>$api_response['operator_ref'],'api_response_id'=>$api_response['api_response_id']));
									
									// add 100% CM Points
									$this->User->recharge_cm_points_add($userID,$post_data['amount'],'Mobile');
									
									$response = array(
										'status' => 1,
										'message' => lang('RECHARGE_SUCCESS')
									);

								}
							}
							else
							{
								// update recharge status
								$this->db->where('id',$recharge_id);
								$this->db->where('recharge_display_id',$recharge_unique_id);
								$this->db->update('recharge_history',array('status'=>3));
								
								$response = array(
									'status' => 0,
									'message' => lang('RECHARGE_FAILED')
								);
							}
						}
						
					}
					elseif($post_data['type'] == 3)
					{
						
							
						$chk_wallet_balance = $this->db->get_where('users',array('id'=>$userID))->row_array();

			            if($chk_wallet_balance['wallet_balance'] < $post_data['amount']){

							$response = array(
								'status' => 0,
								'message' => lang('WALLET_ERROR')
							);
						}
						else
						{
							// generate recharge unique id
				            $recharge_unique_id = rand(1111,9999).time();

							$data = array(
								'member_id'          => $userID,
								'recharge_type'      => $type,
								'recharge_subtype'   => $post_data['rechargeType'],
								'recharge_display_id'=> $recharge_unique_id,
								'mobile'             => $post_data['cardNumber'],
								'account_number'     => isset($post_data['acnumber']) ? $post_data['acnumber'] : '',
								'operator_code'      => $post_data['operator'],
								'circle_code'        => $post_data['circle'],
								'amount'             => $post_data['amount'],
								'status'         	 => 1,
								'created'            => date('Y-m-d H:i:s')                  
							);

							$this->db->insert('recharge_history',$data);
							$recharge_id = $this->db->insert_id();

				            
							$mobile = $post_data['cardNumber'];
							$operator_code = $post_data['operator'];
							$circle_code = $post_data['circle'];
							$amount = $post_data['amount'];
							// call recharge API
							$api_response = $this->User->prepaid_rechage_api($mobile,$operator_code,$circle_code,$amount,$recharge_unique_id,$userID);

				            if(isset($api_response['status']) && ($api_response['status'] == 1 || $api_response['status'] == 2))
							{
								$before_balance = $this->db->get_where('users',array('id'=>$userID))->row_array();

								$after_balance = $before_balance['wallet_balance'] - $post_data['amount'];    

								$wallet_data = array(
									'member_id'           => $userID,    
									'before_balance'      => $before_balance['wallet_balance'],
									'amount'              => $post_data['amount'],  
									'after_balance'       => $after_balance,      
									'status'              => 1,
									'type'                => 2,      
									'created'             => date('Y-m-d H:i:s'),      
									'description'         => 'Recharge #'.$recharge_unique_id.' Amount Deducted.'
								);

								$this->db->insert('member_wallet',$wallet_data);

								$user_wallet = array(
									'wallet_balance'=>$after_balance,        
								);    
								$this->db->where('id',$userID);
								$this->db->update('users',$user_wallet);
								if($api_response['status'] == 1){
									// update recharge status
									$this->db->where('id',$recharge_id);
									$this->db->where('recharge_display_id',$recharge_unique_id);
									$this->db->update('recharge_history',array('txid'=>$api_response['txid'],'operator_ref'=>$api_response['operator_ref'],'api_response_id'=>$api_response['api_response_id']));
									
									$response = array(
										'status' => 1,
										'message' => lang('RECHARGE_PENDING')
									);
									
								}
								else
								{
									// update recharge status
									$this->db->where('id',$recharge_id);
									$this->db->where('recharge_display_id',$recharge_unique_id);
									$this->db->update('recharge_history',array('status'=>2,'txid'=>$api_response['txid'],'operator_ref'=>$api_response['operator_ref'],'api_response_id'=>$api_response['api_response_id']));
									
									// add 100% CM Points
									$this->User->recharge_cm_points_add($userID,$post_data['amount'],'Mobile');
									
									$response = array(
										'status' => 1,
										'message' => lang('RECHARGE_SUCCESS')
									);

								}
							}
							else
							{
								// update recharge status
								$this->db->where('id',$recharge_id);
								$this->db->where('recharge_display_id',$recharge_unique_id);
								$this->db->update('recharge_history',array('status'=>3));
								
								$response = array(
									'status' => 0,
									'message' => lang('RECHARGE_FAILED')
								);
							}
						}
							
					}
					elseif($post_data['type'] == 5)
					{
						
							
						$chk_wallet_balance = $this->db->get_where('users',array('id'=>$userID))->row_array();

			            if($chk_wallet_balance['wallet_balance'] < $post_data['amount']){

							$response = array(
								'status' => 0,
								'message' => lang('WALLET_ERROR')
							);
						}
						else
						{
							// generate recharge unique id
				            $recharge_unique_id = rand(1111,9999).time();

							$data = array(
								'member_id'          => $userID,
								'recharge_type'      => $type,
								'recharge_display_id'=> $recharge_unique_id,
								'mobile'             => $post_data['number'],
								'account_number'     => isset($post_data['acnumber']) ? $post_data['acnumber'] : '',
								'operator_code'      => $post_data['operator'],
								'circle_code'        => $post_data['circle'],
								'amount'             => $post_data['amount'],
								'status'         	 => 1,
								'created'            => date('Y-m-d H:i:s')                  
							);

							$this->db->insert('recharge_history',$data);
							$recharge_id = $this->db->insert_id();

				            
							$mobile = $post_data['number'];
							$operator_code = $post_data['operator'];
							$circle_code = $post_data['circle'];
							$amount = $post_data['amount'];
							// call recharge API
							$api_response = $this->User->prepaid_rechage_api($mobile,$operator_code,$circle_code,$amount,$recharge_unique_id,$userID);

				            if(isset($api_response['status']) && ($api_response['status'] == 1 || $api_response['status'] == 2))
							{
								$before_balance = $this->db->get_where('users',array('id'=>$userID))->row_array();

								$after_balance = $before_balance['wallet_balance'] - $post_data['amount'];    

								$wallet_data = array(
									'member_id'           => $userID,    
									'before_balance'      => $before_balance['wallet_balance'],
									'amount'              => $post_data['amount'],  
									'after_balance'       => $after_balance,      
									'status'              => 1,
									'type'                => 2,      
									'created'             => date('Y-m-d H:i:s'),      
									'description'         => 'Recharge #'.$recharge_unique_id.' Amount Deducted.'
								);

								$this->db->insert('member_wallet',$wallet_data);

								$user_wallet = array(
									'wallet_balance'=>$after_balance,        
								);    
								$this->db->where('id',$userID);
								$this->db->update('users',$user_wallet);
								if($api_response['status'] == 1){
									// update recharge status
									$this->db->where('id',$recharge_id);
									$this->db->where('recharge_display_id',$recharge_unique_id);
									$this->db->update('recharge_history',array('txid'=>$api_response['txid'],'operator_ref'=>$api_response['operator_ref'],'api_response_id'=>$api_response['api_response_id']));
									
									$response = array(
										'status' => 1,
										'message' => lang('RECHARGE_PENDING')
									);
									
								}
								else
								{
									// update recharge status
									$this->db->where('id',$recharge_id);
									$this->db->where('recharge_display_id',$recharge_unique_id);
									$this->db->update('recharge_history',array('status'=>2,'txid'=>$api_response['txid'],'operator_ref'=>$api_response['operator_ref'],'api_response_id'=>$api_response['api_response_id']));
									
									// add 100% CM Points
									$this->User->recharge_cm_points_add($userID,$post_data['amount'],'Mobile');
									
									$response = array(
										'status' => 1,
										'message' => lang('RECHARGE_SUCCESS')
									);

								}
							}
							else
							{
								// update recharge status
								$this->db->where('id',$recharge_id);
								$this->db->where('recharge_display_id',$recharge_unique_id);
								$this->db->update('recharge_history',array('status'=>3));
								
								$response = array(
									'status' => 0,
									'message' => lang('RECHARGE_FAILED')
								);
							}
						}
							
						
					}
					elseif($post_data['type'] == 7)
					{
						
						$chk_wallet_balance = $this->db->get_where('users',array('id'=>$userID))->row_array();
						$mobile = $chk_wallet_balance['mobile'];

			            if($chk_wallet_balance['wallet_balance'] < $post_data['amount']){

							$response = array(
								'status' => 0,
								'message' => lang('WALLET_ERROR')
							);
						}
						else
						{
							// generate recharge unique id
				            $recharge_unique_id = rand(1111,9999).time();

							$data = array(
								'member_id'          => $userID,
								'recharge_type'      => $type,
								'recharge_display_id'=> $recharge_unique_id,
								'mobile'             => $mobile,
								'account_number'     => isset($post_data['account_number']) ? $post_data['account_number'] : '',
								'operator_code'      => $post_data['operator'],
								'amount'             => $post_data['amount'],
								'status'         	 => 1,
								'reference_id'             => $post_data['reference_id'],
								'customer_name'             => $post_data['customer_name'],
								'created'            => date('Y-m-d H:i:s')           
							);

							$this->db->insert('recharge_history',$data);
							$recharge_id = $this->db->insert_id();

				            
							$account_number = $post_data['account_number'];
							$operator_code = $post_data['operator'];
							$amount = $post_data['amount'];
							$reference_id = $post_data['reference_id'];
							// call recharge API
							$api_response = $this->User->electricity_rechage_api($account_number,$operator_code,$amount,$reference_id,$recharge_unique_id,$userID,$mobile);

				            if(isset($api_response['status']) && ($api_response['status'] == 1 || $api_response['status'] == 2))
							{
								$before_balance = $this->db->get_where('users',array('id'=>$userID))->row_array();

								$after_balance = $before_balance['wallet_balance'] - $post_data['amount'];    

								$wallet_data = array(
									'member_id'           => $userID,    
									'before_balance'      => $before_balance['wallet_balance'],
									'amount'              => $post_data['amount'],  
									'after_balance'       => $after_balance,      
									'status'              => 1,
									'type'                => 2,      
									'created'             => date('Y-m-d H:i:s'),      
									'description'         => 'Recharge #'.$recharge_unique_id.' Amount Deducted.'
								);

								$this->db->insert('member_wallet',$wallet_data);

								$user_wallet = array(
									'wallet_balance'=>$after_balance,        
								);    
								$this->db->where('id',$userID);
								$this->db->update('users',$user_wallet);
								if($api_response['status'] == 1){
									// update recharge status
									$this->db->where('id',$recharge_id);
									$this->db->where('recharge_display_id',$recharge_unique_id);
									$this->db->update('recharge_history',array('txid'=>$api_response['txid'],'operator_ref'=>$api_response['operator_ref'],'api_response_id'=>$api_response['api_response_id']));
									
									$response = array(
										'status' => 1,
										'message' => lang('RECHARGE_PENDING')
									);
									
								}
								else
								{
									// update recharge status
									$this->db->where('id',$recharge_id);
									$this->db->where('recharge_display_id',$recharge_unique_id);
									$this->db->update('recharge_history',array('status'=>2,'txid'=>$api_response['txid'],'operator_ref'=>$api_response['operator_ref'],'api_response_id'=>$api_response['api_response_id']));
									
									// add 100% CM Points
									$this->User->recharge_cm_points_add($userID,$post_data['amount'],'Mobile');
									
									$response = array(
										'status' => 1,
										'message' => lang('RECHARGE_SUCCESS')
									);

								}
							}
							else
							{
								// update recharge status
								$this->db->where('id',$recharge_id);
								$this->db->where('recharge_display_id',$recharge_unique_id);
								$this->db->update('recharge_history',array('status'=>3));
								
								$response = array(
									'status' => 0,
									'message' => lang('RECHARGE_FAILED')
								);
							}
						}
							
					}
					
	            }
	            else
	            {
	            	$response = array(
						'status' => 0,
						'message' => lang('OTP_ERROR')
					);
					
	            }
	        }
	        else
			{
				$response = array(
					'status' => 0,
					'message' => lang('USER_ID_ERROR')
				);
			}
			
		}
		log_message('debug', 'Recharge OTP API Response - '.json_encode($response));	
		echo json_encode($response);
		
    }

    public function userWalletDetail()
    {
    	$post = $this->input->post();
		log_message('debug', 'Wallet Detail API Get Data - '.json_encode($post));	
		$userID = isset($post['userID']) ? $post['userID'] : 0;
    	$response = array();
		// check user valid or not
		$chk_user = $this->db->get_where('users',array('id'=>$userID))->num_rows();
		if($chk_user)
		{
			$wallet_data = $this->db->select('users.wallet_balance,users.cm_points,package.package_name')->join('package','package.id = users.current_package_id','left')->get_where('users',array('users.id'=>$userID))->row_array();
			$response = array(
				'status' => 1,
				'message' => 'Success',
				'data' => array(
					'premium_wallet_balance' => $wallet_data['wallet_balance'],
					'cm_points' => $wallet_data['cm_points'],
					'package' => $wallet_data['package_name'],
				)
			);	
		}
		else
		{
			$response = array(
				'status' => 0,
				'message' => lang('USER_ID_ERROR')
			);
		}
		log_message('debug', 'Wallet Detail API Response - '.json_encode($response));	
		echo json_encode($response);
    }


    public function getPremiumWalletHistory()
    {
    	$post = $this->input->post();
		log_message('debug', 'Premium Wallet History API Get Data - '.json_encode($post));	
		$userID = isset($post['userID']) ? $post['userID'] : 0;
    	$response = array();
		// check user valid or not
		$chk_user = $this->db->get_where('users',array('id'=>$userID))->num_rows();
		if($chk_user)
		{
			$historyList = $this->db->order_by('created','desc')->get_where('member_wallet',array('member_id'=>$userID,'wallet_type'=>1))->result_array();

			$data = array();
			if($historyList)
			{
				foreach ($historyList as $key => $list) {
					
					$data[$key]['before_balance'] = $list['before_balance'];
					$data[$key]['amount'] = $list['amount'];
					$data[$key]['type'] = $list['type'];
					$data[$key]['after_balance'] = $list['after_balance'];
					$data[$key]['datetime'] = date('d-M-Y H:i:s',strtotime($list['created']));
					$data[$key]['description'] = $list['description'];
				}
			}

			$response = array(
				'status' => 1,
				'message' => 'Success',
				'data' => $data
			);	
		}
		else
		{
			$response = array(
				'status' => 0,
				'message' => lang('USER_ID_ERROR')
			);
		}
		log_message('debug', 'Premium Wallet History API Response - '.json_encode($response));	
		echo json_encode($response);
    }


    public function getPointHistory()
    {
    	$post = $this->input->post();
		log_message('debug', 'CM Point History API Get Data - '.json_encode($post));	
		$userID = isset($post['userID']) ? $post['userID'] : 0;
    	$response = array();
		// check user valid or not
		$chk_user = $this->db->get_where('users',array('id'=>$userID))->num_rows();
		if($chk_user)
		{
			$historyList = $this->db->order_by('created','desc')->get_where('member_wallet',array('member_id'=>$userID,'wallet_type'=>2))->result_array();

			$data = array();
			if($historyList)
			{
				foreach ($historyList as $key => $list) {
					
					$data[$key]['before_balance'] = $list['before_balance'];
					$data[$key]['points'] = $list['amount'];
					$data[$key]['type'] = $list['type'];
					$data[$key]['after_balance'] = $list['after_balance'];
					$data[$key]['datetime'] = date('d-M-Y H:i:s',strtotime($list['created']));
					$data[$key]['description'] = $list['description'];
				}
			}

			$response = array(
				'status' => 1,
				'message' => 'Success',
				'data' => $data
			);	
		}
		else
		{
			$response = array(
				'status' => 0,
				'message' => lang('USER_ID_ERROR')
			);
		}
		log_message('debug', 'CM Point History API Response - '.json_encode($response));	
		echo json_encode($response);
    }


    public function getRechargeHistory()
    {
    	$post = $this->input->post();
		log_message('debug', 'Recharge History API Get Data - '.json_encode($post));	
		$userID = isset($post['userID']) ? $post['userID'] : 0;
    	$response = array();
		// check user valid or not
		$chk_user = $this->db->get_where('users',array('id'=>$userID))->num_rows();
		if($chk_user)
		{
			$historyList = $this->db->order_by('created','desc')->get_where('recharge_history',array('member_id'=>$userID))->result_array();

			$data = array();
			if($historyList)
			{
				foreach ($historyList as $key => $list) {
					
					$operator = $this->db->get_where('operator',array('operator_code'=>$list['operator_code']))->row_array();
                      
                    $recharge_type = $this->db->get_where('recharge_type',array('id'=>$list['recharge_type']))->row_array();

					$data[$key]['order_id'] = $list['recharge_display_id'];
					$data[$key]['description'] = "Recharge of ".$operator['operator_name']." ".$recharge_type['type']." ".$list['mobile'];
					$data[$key]['datetime'] = date('d-M-Y H:i:s',strtotime($list['created']));
					$data[$key]['status'] = $list['status'];
					
				}
			}

			$response = array(
				'status' => 1,
				'message' => 'Success',
				'data' => $data
			);	
		}
		else
		{
			$response = array(
				'status' => 0,
				'message' => lang('USER_ID_ERROR')
			);
		}
		log_message('debug', 'Recharge History API Response - '.json_encode($response));	
		echo json_encode($response);
    }
    
    public function getReferralLink(){
		
		$response = array();
		$post = $this->input->post();
		log_message('debug', 'Get Refferal API Post Data - '.json_encode($post));	
		$this->load->library('form_validation');
		//$this->form_validation->set_data($this->input->get());
		$this->form_validation->set_rules('userID', 'User ID', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE)
		{
			$response = array(
				'status' => 0,
				'message' => lang('LOGIN_VALID_FAILED')
			);
		}
		else
		{
			$userID = $post['userID'];
			// check user valid or not
			$chk_user = $this->db->get_where('users',array('id'=>$userID))->num_rows();
			if($chk_user)
			{
				$userData = $this->db->get_where('users',array('id'=>$userID))->row_array();
				$response = array(
					'status' => 1,
					'message' => 'Success',
					'data' => base_url('register?referral_id='.$userData['user_code'])
				);	
			}
			else
			{
				$response = array(
					'status' => 0,
					'message' => lang('USER_ID_ERROR')
				);
			}
			
		}
		log_message('debug', 'Get Refferal API Response - '.json_encode($response));	
		echo json_encode($response);
		
    }

    public function getPackageList(){
		
		$response = array();
		$post = $this->input->post();
		log_message('debug', 'Get Package API Post Data - '.json_encode($post));	
		$this->load->library('form_validation');
		//$this->form_validation->set_data($this->input->get());
		$this->form_validation->set_rules('userID', 'User ID', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE)
		{
			$response = array(
				'status' => 0,
				'message' => lang('LOGIN_VALID_FAILED')
			);
		}
		else
		{
			$userID = $post['userID'];
			// check user valid or not
			$chk_user = $this->db->get_where('users',array('id'=>$userID))->num_rows();
			if($chk_user)
			{
				$packageList = $this->db->order_by('order_no','asc')->get_where('package',array('id >'=>1))->result_array();
				$member_current_package = $this->User->get_member_current_package($userID);
		        if($member_current_package == 2)
		        {
		        	unset($packageList[0]);
		        	unset($packageList[2]);
		        }
		        elseif($member_current_package == 3)
		        {
		        	unset($packageList[0]);
		        	unset($packageList[1]);
		        	unset($packageList[2]);
		        }
		        elseif($member_current_package == 4)
		        {
		        	unset($packageList[1]);
		        	unset($packageList[2]);
		        }
		        elseif($member_current_package == 1)
		        {
		        	unset($packageList[1]);
		        }


		        $packageData = array();
		        if($packageList)
		        {
		        	foreach($packageList as $key=>$list)
		        	{
		        		$packageData[$key]['package_id'] = $list['id'];
		        		$packageData[$key]['package_name'] = $list['package_name'];
		        		$packageData[$key]['package_amount'] = $list['package_amount'];
		        		$packageData[$key]['cm_points'] = $list['cm_points'];
		        		$packageData[$key]['refer_cm_points'] = $list['refer_cm_points'];
		        		$packageData[$key]['cashback'] = $list['cashback'];
		        	}
		        }

				$response = array(
					'status' => 1,
					'message' => 'Success',
					'data' => $packageData
				);	
			}
			else
			{
				$response = array(
					'status' => 0,
					'message' => lang('USER_ID_ERROR')
				);
			}
			
		}
		log_message('debug', 'Get Package API Response - '.json_encode($response));	
		echo json_encode($response);
		
    }

    public function generateHash(){
		
		$response = array();
		$hash = '';
		$post = $this->input->post();
		log_message('debug', 'Generate Hash API Post Data - '.json_encode($post));	
		$this->load->library('form_validation');
		//$this->form_validation->set_data($this->input->get());
		$this->form_validation->set_rules('userID', 'User ID', 'required|xss_clean');
		$this->form_validation->set_rules('amount', 'Amount', 'required|xss_clean|numeric');
		if ($this->form_validation->run() == FALSE)
		{
			$response = array(
				'status' => 0,
				'message' => lang('LOGIN_VALID_FAILED')
			);
		}
		else
		{
			$userID = $post['userID'];
			$siteUrl = base_url();
			// check user valid or not
			$chk_user = $this->db->get_where('users',array('id'=>$userID))->num_rows();
			if($chk_user)
			{
				if($post['amount'] < 1)
				{
					$response = array(
						'status' => 0,
						'message' => 'Sorry ! Amount is not valid.'
					);
				}
				else
				{
					$chk_wallet_balance =$this->db->get_where('users',array('id'=>$userID))->row_array();
					$amount = $post['amount'];
					
					  $action = '';
					  
					  $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
					  
					
					$key=PAYU_MERCHANT_KEY;
                    $productinfo='Cranesmart Wallet Topup';
                    $firstname=$chk_wallet_balance['name'];
                    $email=$chk_wallet_balance['email'];
                    $salt=PAYU_MERCHANT_SALT;
                    
                    $hashSeq = $key.'|'.$txnid.'|'.$amount.'|'.$productinfo.'|'.$firstname.'|'.$email.'|||||||||||'.$salt;
                    
                    $hash = hash("sha512", $hashSeq);
					
					// save payment request data
					$paymentRequestData = array(
						'userID' => $userID,
						'orderID' => $txnid,
						'payment_request_id' => '',
						'amount' => $amount,
						'status' => 1,
						'api_response' => '',
						'is_from_app' => 1,
						'posted' => date('Y-m-d H:i:s')
					);
					$this->db->insert('payment_request',$paymentRequestData);
					$response = array(
						'status' => 1,
						'message' => 'Success',
						'data' => $hash,
						'txnid' => $txnid
					);
				}
			}
			else
			{
				$response = array(
					'status' => 0,
					'message' => lang('USER_ID_ERROR')
				);
			}
			
		}
		log_message('debug', 'Generate Hash API Response - '.json_encode($response));	
		//echo json_encode($response);
		echo $hash;
		
    }
    
    /*public function paymentResponseAuth(){
		
		$response = array();
		$post = $this->input->post();
		log_message('debug', 'Payment Response Auth API Post Data - '.json_encode($post));	
		$this->load->library('form_validation');
		//$this->form_validation->set_data($this->input->get());
		$this->form_validation->set_rules('userID', 'User ID', 'required|xss_clean');
		$this->form_validation->set_rules('amount', 'Amount', 'required|xss_clean|numeric');
		$this->form_validation->set_rules('status', 'Status', 'required|xss_clean');
		$this->form_validation->set_rules('txnid', 'Txnid', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE)
		{
			$response = array(
				'status' => 0,
				'message' => lang('LOGIN_VALID_FAILED')
			);
		}
		else
		{
			$userID = $post['userID'];
			$txnid = $post['txnid'];
			$amount = $post['amount'];
			$status = $post['status'];
			$siteUrl = base_url();
			// check user valid or not
			$chk_user = $this->db->get_where('users',array('id'=>$userID))->num_rows();
			if($chk_user)
			{
				// check transaction id already used or not
			    $chk_txn_id = $this->db->get_where('payment_request',array('orderID'=>$post["txnid"],'status >'=>1))->num_rows();
			    if($chk_txn_id)
			    {
			    	$response = array(
						'status' => 0,
						'message' => 'Sorry ! Your transaction ID already updated.'
					);
					
			    }
			    else
			    {
			    	// save payment request data
					$paymentRequestData = array(
						'userID' => $userID,
						'orderID' => $txnid,
						'payment_request_id' => '',
						'amount' => $amount,
						'status' => 1,
						'api_response' => '',
						'is_from_app' => 1,
						'posted' => date('Y-m-d H:i:s')
					);
					$this->db->insert('payment_request',$paymentRequestData);

					if(strtolower($status) == 'success')
					{
					    $this->db->where('userID',$userID);
						$this->db->where('orderID',$post["txnid"]);
						$this->db->update('payment_request',array('status'=>2,'payment_request_id'=>$post["txnid"]));
						
						// get order detail
						$get_order_detail = $this->db->get_where('payment_request',array('userID'=>$userID,'orderID'=>$post["txnid"]))->row_array();
						$amount = isset($get_order_detail['amount']) ? $get_order_detail['amount'] : 0;
						
						$before_balance = $this->db->get_where('users',array('id'=>$userID))->row_array();
						
						$after_balance = $before_balance['wallet_balance'] + $amount;    
						
						$type = 1;
						
						$wallet_data = array(
							'member_id'           => $userID,    
							'before_balance'      => $before_balance['wallet_balance'],
							'amount'              => $amount,  
							'after_balance'       => $after_balance,      
							'status'              => 1,
							'type'                => $type,      
							'created'             => date('Y-m-d H:i:s'),      
							'credited_by'         => $userID,
							'description'         => 'Topup Credited #'.$post["txnid"]
				        );

				        $this->db->insert('member_wallet',$wallet_data);

				        $user_wallet = array(
							'wallet_balance'=>$after_balance,        
				        );    

				        $this->db->where('id',$userID);
				        $this->db->update('users',$user_wallet); 

						$response = array(
							'status' => 1,
							'message' => 'Congratulations ! Your premium wallet received INR '.$amount.' /- Topup.'
						);
					}
					elseif(strtolower($status) == 'failed')
					{
						$this->db->where('userID',$userID);
						$this->db->where('orderID',$post["txnid"]);
						$this->db->update('payment_request',array('status'=>3));

						$response = array(
							'status' => 1,
							'message' => 'Your transaction got failed, please try again.'
						);
					}
					
			    }
			    
			}
			else
			{
				$response = array(
					'status' => 0,
					'message' => lang('USER_ID_ERROR')
				);
			}
			
		}
		log_message('debug', 'Payment Response Auth API Response - '.json_encode($response));	
		echo json_encode($response);
		
    }*/

    public function paymentSuccessAuth(){
		
		$response = array();
		$post = $this->input->post();
		log_message('debug', 'Payment Success Auth API Post Data - '.json_encode($post));	
		$this->load->library('form_validation');
		//$this->form_validation->set_data($this->input->get());
		$this->form_validation->set_rules('userID', 'User ID', 'required|xss_clean');
		$this->form_validation->set_rules('amount', 'Amount', 'required|xss_clean|numeric');
		$this->form_validation->set_rules('status', 'Status', 'required|xss_clean');
		$this->form_validation->set_rules('txnid', 'Txnid', 'required|xss_clean');
		$this->form_validation->set_rules('hash', 'Hash', 'required|xss_clean');
		$this->form_validation->set_rules('firstname', 'Firstname', 'required|xss_clean');
		$this->form_validation->set_rules('key', 'Key', 'required|xss_clean');
		$this->form_validation->set_rules('productinfo', 'Product Info', 'required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE)
		{
			$response = array(
				'status' => 0,
				'message' => lang('LOGIN_VALID_FAILED')
			);
		}
		else
		{
			$userID = $post['userID'];
			$siteUrl = base_url();
			// check user valid or not
			$chk_user = $this->db->get_where('users',array('id'=>$userID))->num_rows();
			if($chk_user)
			{
				/*$chk_txn_id = $this->db->get_where('payment_request',array('userID'=>$userID,'orderID'=>$post["txnid"]))->num_rows();
			    if(!$chk_txn_id)
			    {
					$response = array(
						'status' => 0,
						'message' => 'Sorry ! Your transaction ID not Valid.'
					);
			    }
			    else
			    {*/
			    	// check transaction id already used or not
				   /* $chk_txn_id = $this->db->get_where('payment_request',array('orderID'=>$post["txnid"],'status >'=>1))->num_rows();
				    if($chk_txn_id)
				    {
				    	$response = array(
							'status' => 0,
							'message' => 'Sorry ! Your transaction ID already updated.'
						);
						
				    }
				    else
				    {*/
				    	$status=$post["status"];
						$firstname=$post["firstname"];
						$amount=$post["amount"];
						$txnid=$post["txnid"];
						$posted_hash=$post["hash"];
						$key=$post["key"];
						$productinfo=$post["productinfo"];
						$email=$post["email"];
						$salt=PAYU_MERCHANT_SALT;
						$retHashSeq = $salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
						$hash = hash("sha512", $retHashSeq);
						
						if ($hash != $posted_hash)
						{
							$response = array(
								'status' => 0,
								'message' => 'Sorry ! Your transaction got failed, please try again.'
							);
						}
						else
						{
                            
                            // save payment request data
        					$paymentRequestData = array(
        						'userID' => $userID,
        						'orderID' => $post["txnid"],
        						'payment_request_id' => $post["txnid"],
        						'amount' => $amount,
        						'status' => 2,
        						'api_response' => '',
        						'is_from_app' => 1,
        						'posted' => date('Y-m-d H:i:s')
        					);
        					$this->db->insert('payment_request',$paymentRequestData);
                            
						    /*$this->db->where('userID',$userID);
							$this->db->where('orderID',$post["txnid"]);
							$this->db->update('payment_request',array('status'=>2,'payment_request_id'=>$post["txnid"]));*/
							
							// get order detail
							$get_order_detail = $this->db->get_where('payment_request',array('userID'=>$userID,'orderID'=>$post["txnid"]))->row_array();
							$amount = isset($get_order_detail['amount']) ? $get_order_detail['amount'] : 0;
							
							$before_balance = $this->db->get_where('users',array('id'=>$userID))->row_array();
							
							$after_balance = $before_balance['wallet_balance'] + $amount;    
							
							$type = 1;
							
							$wallet_data = array(
								'member_id'           => $userID,    
								'before_balance'      => $before_balance['wallet_balance'],
								'amount'              => $amount,  
								'after_balance'       => $after_balance,      
								'status'              => 1,
								'type'                => $type,      
								'created'             => date('Y-m-d H:i:s'),      
								'credited_by'         => $userID,
								'description'         => 'Topup Credited #'.$post["txnid"]
					        );

					        $this->db->insert('member_wallet',$wallet_data);

					        $user_wallet = array(
								'wallet_balance'=>$after_balance,        
					        );    

					        $this->db->where('id',$userID);
					        $this->db->update('users',$user_wallet); 

							$response = array(
								'status' => 1,
								'message' => 'Congratulations ! Your premium wallet received INR '.$amount.' /- Topup.'
							);
						}
				//    }
			   // }


			}
			else
			{
				$response = array(
					'status' => 0,
					'message' => lang('USER_ID_ERROR')
				);
			}
			
		}
		log_message('debug', 'Payment Success Auth API Response - '.json_encode($response));	
		echo json_encode($response);
		
    }

    public function paymentFailedAuth(){
		
		$response = array();
		$post = $this->input->post();
		log_message('debug', 'Payment Failed Auth API Post Data - '.json_encode($post));	
		$this->load->library('form_validation');
		//$this->form_validation->set_data($this->input->get());
		$this->form_validation->set_rules('userID', 'User ID', 'required|xss_clean');
		$this->form_validation->set_rules('amount', 'Amount', 'required|xss_clean|numeric');
		$this->form_validation->set_rules('status', 'Status', 'required|xss_clean');
		$this->form_validation->set_rules('txnid', 'Txnid', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE)
		{
			$response = array(
				'status' => 0,
				'message' => lang('LOGIN_VALID_FAILED')
			);
		}
		else
		{
			$userID = $post['userID'];
			$siteUrl = base_url();
			// check user valid or not
			$chk_user = $this->db->get_where('users',array('id'=>$userID))->num_rows();
			if($chk_user)
			{
				/*$chk_txn_id = $this->db->get_where('payment_request',array('userID'=>$userID,'orderID'=>$post["txnid"]))->num_rows();
			    if(!$chk_txn_id)
			    {
					$response = array(
						'status' => 0,
						'message' => 'Sorry ! Your transaction ID not Valid.'
					);
			    }
			    else
			    {*/
			    	// check transaction id already used or not
				   /* $chk_txn_id = $this->db->get_where('payment_request',array('orderID'=>$post["txnid"],'status >'=>1))->num_rows();
				    if($chk_txn_id)
				    {
				    	$response = array(
							'status' => 0,
							'message' => 'Sorry ! Your transaction ID already updated.'
						);
						
				    }
				    else
				    {*/
				        // save payment request data
        					$paymentRequestData = array(
        						'userID' => $userID,
        						'orderID' => $post["txnid"],
        						'payment_request_id' => $post["txnid"],
        						'amount' => $post['amount'],
        						'status' => 3,
        						'api_response' => '',
        						'is_from_app' => 1,
        						'posted' => date('Y-m-d H:i:s')
        					);
        					$this->db->insert('payment_request',$paymentRequestData);
				    	/*$this->db->where('userID',$userID);
						$this->db->where('orderID',$post["txnid"]);
						$this->db->update('payment_request',array('status'=>3));*/

						$response = array(
							'status' => 1,
							'message' => 'Your transaction got failed, please try again.'
						);
						
				  //  }
			    //}


			}
			else
			{
				$response = array(
					'status' => 0,
					'message' => lang('USER_ID_ERROR')
				);
			}
			
		}
		log_message('debug', 'Payment Failed Auth API Response - '.json_encode($response));	
		echo json_encode($response);
		
    }
    
    public function getUserData(){
		
		$response = array();
		$post = $this->input->post();
		log_message('debug', 'Get User Data API Post Data - '.json_encode($post));	
		$this->load->library('form_validation');
		//$this->form_validation->set_data($this->input->get());
		$this->form_validation->set_rules('userID', 'User ID', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE)
		{
			$response = array(
				'status' => 0,
				'message' => lang('LOGIN_VALID_FAILED')
			);
		}
		else
		{
			$userID = $post['userID'];
			$siteUrl = base_url();
			// check user valid or not
			$chk_user = $this->db->get_where('users',array('id'=>$userID))->num_rows();
			if($chk_user)
			{
				$userData = $this->db->get_where('users',array('id'=>$userID))->row_array();
				$response = array(
					'status' => 1,
					'message' => 'Success',
					'data' => array(
						'name' => $userData['name'],
						'email' => $userData['email'],
						'mobile' => $userData['mobile'],
						'photo' => ($userData['photo']) ? base_url($userData['photo']) : ''
					)
				);
				
			}
			else
			{
				$response = array(
					'status' => 0,
					'message' => lang('USER_ID_ERROR')
				);
			}
			
		}
		log_message('debug', 'Get User Data API Response - '.json_encode($response));	
		echo json_encode($response);
		
    }


    public function updateUserData(){
// 		echo "<pre>";
// 	print_r($this->input->post());
// 	echo "<pre>";
// 	print_r($_FILES);
// 	die;
		$response = array();
		$post = $this->input->post();

    	log_message('debug', 'Update User Data API Post Data - '.json_encode($post));	
		$this->load->library('form_validation');
		//$this->form_validation->set_data($this->input->get());
		$this->form_validation->set_rules('userID', 'User ID', 'required|xss_clean');
		$this->form_validation->set_rules('name', 'Name', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE)
		{
			$response = array(
				'status' => 0,
				'message' => lang('LOGIN_VALID_FAILED')
			);
		}
		else
		{
			$userID = $post['userID'];
			$siteUrl = base_url();
			// check user valid or not
			$chk_user = $this->db->get_where('users',array('id'=>$userID))->num_rows();
			if($chk_user)
			{
				// update user data
				$updateData = array(
					'name' => $post['name']
				);
				if(isset($post['photo']) && !empty($post['photo']))
				{
                    $encodedData = $post['photo'];
                    if(strpos($post['photo'], ' ')){
                        $encodedData = str_replace(' ','+', $post['photo']);
                    }
                    $profile = base64_decode($encodedData);
                    $file_name = time().rand(1111,9999).'.jpg';
				// 	$profile_img_name = base_url('media/user_profile/'.$file_name);
					$profile_img_name = FILE_UPLOAD_SERVER_PATH.$file_name;
                    $path = 'media/member/';
                    if (!is_dir($path)) {
                        mkdir($path, 0777, true);
                    }
                    $targetDir = $path.$file_name;
                    if(file_put_contents($targetDir, $profile)){
                        $updateData['photo'] = $targetDir;
                    }
				}
				$this->db->where('id',$userID);
				$this->db->update('users',$updateData);
				$userData = $this->db->get_where('users',array('id'=>$userID))->row_array();
				$response = array(
					'status' => 1,
					'message' => 'Success',
					'data' => array(
						'name' => $userData['name'],
						'email' => $userData['email'],
						'mobile' => $userData['mobile'],
						'photo' => !empty($userData['photo']) ? base_url($userData['photo']) : ''
					)
				);
				
			}
			else
			{
				$response = array(
					'status' => 0,
					'message' => lang('USER_ID_ERROR')
				);
			}
			
		}
		log_message('debug', 'Update User Data API Response - '.json_encode($response));	
		echo json_encode($response);
		
    }
    
    public function getCountryList()
    {
    	$response = array();
		$operator = $this->db->get('countries')->result_array();
		
		$data = array();
		if($operator)
		{
			foreach ($operator as $key => $value) {
				$data[$key]['countryID'] = $value['id'];
				$data[$key]['countryCode'] = $value['sortname'];
				$data[$key]['name'] = $value['name'];
				
			}
		}

		$response = array(
			'status' => 1,
			'message' => 'Success',
			'data' => $data
		);
		echo json_encode($response);
    }

    public function getStateList(){
		
		$response = array();
		$post = $this->input->post();
		log_message('debug', 'Get State List API Post Data - '.json_encode($post));	
		$this->load->library('form_validation');
		//$this->form_validation->set_data($this->input->get());
		$this->form_validation->set_rules('countryCode', 'Country Code', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE)
		{
			$response = array(
				'status' => 0,
				'message' => lang('LOGIN_VALID_FAILED')
			);
		}
		else
		{
			$operator = $this->db->get_where('states',array('country_code_char2'=>$post['countryCode']))->result_array();
		
			$data = array();
			if($operator)
			{
				foreach ($operator as $key => $value) {
					$data[$key]['stateID'] = $value['id'];
					$data[$key]['name'] = $value['name'];
					
				}
			}
			$response = array(
				'status' => 1,
				'message' => 'Success',
				'data' => $data
			);
			
		}
		log_message('debug', 'Get State List API Response - '.json_encode($response));	
		echo json_encode($response);
		
    }
    
    public function getUserAddressData(){
		
		$response = array();
		$post = $this->input->post();
		log_message('debug', 'Get User Address Data API Post Data - '.json_encode($post));	
		$this->load->library('form_validation');
		//$this->form_validation->set_data($this->input->get());
		$this->form_validation->set_rules('userID', 'User ID', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE)
		{
			$response = array(
				'status' => 0,
				'message' => lang('LOGIN_VALID_FAILED')
			);
		}
		else
		{
			$userID = $post['userID'];
			$siteUrl = base_url();
			// check user valid or not
			$chk_user = $this->db->get_where('users',array('id'=>$userID))->num_rows();
			if($chk_user)
			{
				$userData = $this->db->select('user_address.*,countries.name as country_name,states.name as state_name')->join('countries','countries.id = user_address.country','left')->join('states','states.id = user_address.state','left')->get_where('user_address',array('user_address.userID'=>$userID))->row_array();

				$data = array();
				if($userData)
				{
					$data = array(
						'name' => $userData['name'],
						'phoneNumber' => $userData['phone_number'],
						'address_1' => $userData['address_1'],
						'address_2' => $userData['address_2'],
						'city' => $userData['city'],
						'country' => $userData['country_name'],
						'state' => $userData['state_name'],
						'zipCode' => $userData['zip_code'],
					);
				}

				$response = array(
					'status' => 1,
					'message' => 'Success',
					'data' => $data
				);
				
			}
			else
			{
				$response = array(
					'status' => 0,
					'message' => lang('USER_ID_ERROR')
				);
			}
			
		}
		log_message('debug', 'Get User Address API Response - '.json_encode($response));	
		echo json_encode($response);
		
    }
    
    public function updateUserAddress(){
		
		$response = array();
		$post = $this->input->post();
		log_message('debug', 'Update User Address API Post Data - '.json_encode($post));	
		$this->load->library('form_validation');
		//$this->form_validation->set_data($this->input->get());
		$this->form_validation->set_rules('userID', 'User ID', 'required|xss_clean');
		$this->form_validation->set_rules('name', 'Name', 'required|xss_clean');
		$this->form_validation->set_rules('phoneNumber', 'phoneNumber', 'required|xss_clean');
		$this->form_validation->set_rules('address_1', 'address_1', 'required|xss_clean');
		$this->form_validation->set_rules('address_2', 'address_2', 'xss_clean');
		$this->form_validation->set_rules('city', 'City', 'required|xss_clean');
		$this->form_validation->set_rules('countryID', 'Country', 'required|xss_clean');
		$this->form_validation->set_rules('stateID', 'State', 'required|xss_clean');
		$this->form_validation->set_rules('zipCode', 'Zip Code', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE)
		{
			$response = array(
				'status' => 0,
				'message' => lang('LOGIN_VALID_FAILED')
			);
		}
		else
		{
			$userID = $post['userID'];
			$siteUrl = base_url();
			// check user valid or not
			$chk_user = $this->db->get_where('users',array('id'=>$userID))->num_rows();
			if($chk_user)
			{
				$chk_user_address = $this->db->get_where('user_address',array('userID'=>$userID))->num_rows();
				if($chk_user_address)
				{
					$get_add_id = $this->db->select('id')->get_where('user_address',array('userID'=>$userID))->row_array();
					$addID = isset($get_add_id['id']) ? $get_add_id['id'] : 0 ;
					// update user data
					$updateData = array(
						'name' => $post['name'],
						'phone_number' => $post['phoneNumber'],
						'address_1' => $post['address_1'],
						'address_2' => $post['address_2'],
						'city' => $post['city'],
						'country' => $post['countryID'],
						'state' => $post['stateID'],
						'zip_code' => $post['zipCode'],
						'updated' => date('Y-m-d H:i:s')
					);
					$this->db->where('id',$addID);
					$this->db->update('user_address',$updateData);
				}
				else
				{
					// update user data
					$updateData = array(
						'userID' => $userID,
						'name' => $post['name'],
						'phone_number' => $post['phoneNumber'],
						'address_1' => $post['address_1'],
						'address_2' => $post['address_2'],
						'city' => $post['city'],
						'country' => $post['countryID'],
						'state' => $post['stateID'],
						'zip_code' => $post['zipCode'],
						'created' => date('Y-m-d H:i:s')
					);
					$this->db->insert('user_address',$updateData);
				}
				$response = array(
					'status' => 1,
					'message' => 'Success'
				);
				
			}
			else
			{
				$response = array(
					'status' => 0,
					'message' => lang('USER_ID_ERROR')
				);
			}
			
		}
		log_message('debug', 'Update User Address API Response - '.json_encode($response));	
		echo json_encode($response);
		
    }
    
    public function kycAuth(){
		
		$response = array();
		$post = $this->input->post();
		log_message('debug', 'KYC Auth API Post Data - '.json_encode($post));	
		$this->load->library('form_validation');
		//$this->form_validation->set_data($this->input->get());
		$this->form_validation->set_rules('userID', 'User ID', 'required|xss_clean');
		$this->form_validation->set_rules('accountName', 'Account Name', 'required|xss_clean');
		$this->form_validation->set_rules('accountNumber', 'Account Number', 'required|xss_clean');
		$this->form_validation->set_rules('ifsc', 'IFSC', 'required|xss_clean');
		$this->form_validation->set_rules('bankName', 'Bank Name', 'required|xss_clean');
		$this->form_validation->set_rules('adharFront', 'Adhar Back', 'required|xss_clean');
		$this->form_validation->set_rules('adharBack', 'Adhar Back', 'required|xss_clean');
		$this->form_validation->set_rules('pancard', 'Pancard', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE)
		{
			$response = array(
				'status' => 0,
				'message' => lang('LOGIN_VALID_FAILED')
			);
		}
		else
		{
			$userID = $post['userID'];
			$siteUrl = base_url();
			// check user valid or not
			$chk_user = $this->db->get_where('users',array('id'=>$userID))->num_rows();
			if($chk_user)
			{
				$adhar_front_img = '';
				if(isset($post['adharFront']) && $post['adharFront'])
				{
					$profile = isset($post['adharFront']) ? $post['adharFront'] : '';
					$file_name = time().rand(1111,9999).'.jpg';
					//$profile_img_name = base_url('media/user_profile/'.$file_name);
					$profile_img_name = KYC_FILE_UPLOAD_SERVER_PATH.$file_name;
					
					$img_data = base64_decode($profile);
					file_put_contents($profile_img_name, $img_data);
					$adhar_front_img = 'media/kyc_document/'.$file_name;

				}
				$adhar_back_img = '';
				if(isset($post['adharBack']) && $post['adharBack'])
				{
					$profile = isset($post['adharBack']) ? $post['adharBack'] : '';
					$file_name = time().rand(1111,9999).'.jpg';
					//$profile_img_name = base_url('media/user_profile/'.$file_name);
					$profile_img_name = KYC_FILE_UPLOAD_SERVER_PATH.$file_name;
					
					$img_data = base64_decode($profile);
					file_put_contents($profile_img_name, $img_data);
					$adhar_back_img = 'media/kyc_document/'.$file_name;

				}
				$pancard_img = '';
				if(isset($post['pancard']) && $post['pancard'])
				{
					$profile = isset($post['pancard']) ? $post['pancard'] : '';
					$file_name = time().rand(1111,9999).'.jpg';
					//$profile_img_name = base_url('media/user_profile/'.$file_name);
					$profile_img_name = KYC_FILE_UPLOAD_SERVER_PATH.$file_name;
					
					$img_data = base64_decode($profile);
					file_put_contents($profile_img_name, $img_data);
					$pancard_img = 'media/kyc_document/'.$file_name;

				}

				$data = array(    
					'member_id'            =>  $userID,      
					'account_holder_name'  =>  $post['accountName'],
					'account_number'   =>  $post['accountNumber'],
					'ifsc'               =>  $post['ifsc'],
					'bank_name'               =>  $post['bankName'],
					'front_document'           =>  $adhar_front_img,
					'back_document'           =>  $adhar_back_img,
					'pancard_document'           =>  $pancard_img,
					'status'           =>  2,
					'created'            =>  date('Y-m-d H:i:s')
				);

				$this->db->insert('member_kyc_detail',$data);
				
				$this->db->where('id',$userID);
				$this->db->update('users',array('kyc_status'=>2));

				// get account detail
				$get_user_data = $this->db->select('mobile')->get_where('users',array('id'=>$userID))->row_array();
				$mobile = isset($get_user_data['mobile']) ? $get_user_data['mobile'] : '';
				if($mobile)
				{
					$output = '';
			        $sms = 'Thank you for submitting KYC Documents. You will be notified by sms or mail within 2 working days.';
			        
			        $api_url = SMS_API_URL.'receiver='.$mobile.'&sms='.urlencode($sms);
			        
			        $ch = curl_init();
			        curl_setopt($ch, CURLOPT_URL, $api_url);
			        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
			        $output = curl_exec($ch); 
			        curl_close($ch);
				}

				$response = array(
					'status' => 1,
					'message' => 'Success'
				);
				
			}
			else
			{
				$response = array(
					'status' => 0,
					'message' => lang('USER_ID_ERROR')
				);
			}
			
		}
		log_message('debug', 'KYC Auth API Response - '.json_encode($response));	
		echo json_encode($response);
		
    }
	
	public function getUserKycDetails(){

        $response = array("status"=>0);
        $post = $this->input->post();
        log_message('debug', 'Get User Kyc Details API Post Data - '.json_encode($post));
        $this->load->library('form_validation');
        //$this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('userID', 'User ID', 'required|xss_clean');
        if ($this->form_validation->run() == FALSE)
        {
            $response['message'] = lang('LOGIN_VALID_FAILED');
        }else{
            // check user valid or not
            $response['message'] = lang('USER_ID_ERROR');
            $chk_user = $this->db->get_where('users',array('id'=>$post['userID']))->num_rows();
            if(!empty($chk_user))
            {
                $response['status'] = 1;
                $response['message'] = 'Success';
                $response['data'] = array();
                $query = $this->db->get_where('member_kyc_detail', array('member_id'=>$post['userID']));
                if($query->num_rows() > 0)
                {
                    $row = $query->row_array();
                    $status = 'Pending';
                    if($row['status']==3){
                        $status = 'Approved';
                    }elseif ($row['status']==3){
                        $status = 'Rejected';
                    }
                    $response['data'] = array(
                        'ac_holder_name' => $row['account_holder_name'],
                        'ac_no' => $row['account_number'],
                        'ifsc' => $row['ifsc'],
                        'bank_name' => $row['bank_name'],
                        'aadhar_front' => base_url($row['front_document']),
                        'aadhar_back' => base_url($row['back_document']),
                        'pan_card' => base_url($row['pancard_document']),
                        'status' => $status
                    );
                }
            }

        }
        log_message('debug', 'Get User KYC Details Response - '.json_encode($response));
        echo json_encode($response);
    }

    public function getPackage(){
        $response = array("status"=>0);
        $post = $this->input->post();
        log_message('debug', 'Get User Package Details API Post Data - '.json_encode($post));
        $this->load->library('form_validation');
        //$this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('userID', 'User ID', 'required|xss_clean');
        if ($this->form_validation->run() == FALSE)
        {
            $response['message'] = lang('LOGIN_VALID_FAILED');
        }else{
            // check user valid or not
            $response['message'] = lang('USER_ID_ERROR');
            $chk_user = $this->db->get_where('users', array('id'=>$post['userID']));
            if(!empty($chk_user->num_rows()))
            {
                $userDet = $chk_user->row_array();
                $response['status'] = 1;
                $response['message'] = 'Success';
                if($userDet['current_package_id'] == 1){
                    $this->db->where('id !=', 1);
                    $this->db->where('id !=', 4);
                }elseif ($userDet['current_package_id'] == 2){
                    $this->db->where('id', 4);
                }
                $query = $this->db->get('tbl_package');
                if($query->num_rows() > 0)
                {
                    if($userDet['current_package_id'] != 3) {
                        $data = array();
                        foreach ($query->result_array() as $row) {
                            $data[] = array(
                                "id" => $row['id'],
                                "package_id" => $row['package_display_id'],
                                "package_name" => $row['package_name'],
                                "package_amount" => $row['package_amount'],
                                "cm_points" => $row['cm_points'],
                                "refer_cm_points" => $row['refer_cm_points'],
                                "cashback" => $row['cashback'],
                            );
                        }
                        $response['data'] = $data;
                    }
                    if($userDet['current_package_id'] == 3){
                        $response['message'] = 'You have already buy Premium package';
                    }
                }
            }

        }
        log_message('debug', 'Get User Packge Details Response - '.json_encode($response));
        echo json_encode($response);
    }
    
    public function updateUserCurrentPackage(){
        $response = array("status"=>0);
        $post = $this->input->post();
        log_message('debug', 'User Package Update API Post Data - '.json_encode($post));
        $this->load->library('form_validation');
        //$this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('userID', 'User ID', 'required|xss_clean');
        $this->form_validation->set_rules('packageID', 'Package ID', 'required|xss_clean');
        if ($this->form_validation->run() == FALSE)
        {
            $response['message'] = lang('LOGIN_VALID_FAILED');
        }else{
			
			
            // check user valid or not
            $response['message'] = lang('USER_ID_ERROR');
            $packageDet = $this->db->get_where('tbl_package', array('id'=>$post['packageID']))->row_array();
            $chk_user = $this->db->get_where('users', array('id'=>$post['userID']));
            if(!empty($chk_user->num_rows()))
            {
                $chk_wallet_balance =$this->db->get_where('users',array('id'=>$post['userID']))->row_array();
		        $wallet_balance = isset($chk_wallet_balance['wallet_balance']) ? $chk_wallet_balance['wallet_balance'] : 0;
		        
		        $get_package_amount = $this->db->get_where('package',array('id'=>$post['packageID']))->row_array();
		        $package_amount = isset($get_package_amount['package_amount']) ? $get_package_amount['package_amount'] : 0 ;
		        if($wallet_balance < $package_amount)
		        {
                    $response['status'] = 0;
				    $response['message'] = 'Sorry ! Insufficient balance in your account.';
		        }
		        else
		        {
		            $this->User->upgrade_member_package($post['userID'],$post['packageID']);
				    $response['status'] = 1;
				    $response['message'] = 'Successfully buy '.$packageDet['package_name'];
		        }
                
            }

        }
        log_message('debug', 'User Package Update Response - '.json_encode($response));
        echo json_encode($response);
    }
    
    public function saveHelpSupport(){
		$response = array("status"=>0, "message"=>'error');
		$post = $this->input->post();

// 		log_message('debug', 'Save Help Support API Post Data - '.json_encode($post));
// 		$this->load->library('form_validation');
// 		$this->form_validation->set_data($this->input->post());
// 		$this->form_validation->set_rules('contact_no', 'Contact No', 'required|xss_clean');
// 		$this->form_validation->set_rules('email', 'Email', 'required|xss_clean');
// 		$this->form_validation->set_rules('description', 'Description', 'required|xss_clean');
		$userID = $post['userID']; 
		$chk_user = $this->db->get_where('users',array('id'=>$userID))->num_rows();
		if(!empty($chk_user)){
			$data = array(
				"contact_no" => $post['contact_no'],
				"email" => $post['email'],
				"description" => $post['description'],
			);

			if(!empty($_FILES['document']['name'])) {
				$path = 'media/support/';
				if (!is_dir($path)) {
					mkdir($path, 0777, true);
				}

				$tempFile = $_FILES['document']['tmp_name'];
				$temp = 	$_FILES['document']['name'];
				$path_parts = pathinfo($temp);
				$fileName = uniqid().'.'.$path_parts['extension'];
				$targetFile = $path.$fileName ;
				if(move_uploaded_file($tempFile, $targetFile)){
					$data['file'] = $targetFile;
				}
			}
// 			echo "<pre>";
//         	print_r($data);
// 			echo "<pre>";
//         	print_r($post);
//         	die;
			if($this->db->insert('tbl_help_support', $data)){
				$response['status'] = 1;
				$response['message'] = 'success';
			}
		}
// 		log_message('debug', 'Save Help Support Response - '.json_encode($response));
		echo json_encode($response);
		exit();
	}
    
    public function getUserDirectDownline(){
		
		$response = array();
		$post = $this->input->post();
		log_message('debug', 'Get User Direct Downline API Post Data - '.json_encode($post));	
		$this->load->library('form_validation');
		//$this->form_validation->set_data($this->input->get());
		$this->form_validation->set_rules('userID', 'User ID', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE)
		{
			$response = array(
				'status' => 0,
				'message' => lang('LOGIN_VALID_FAILED')
			);
		}
		else
		{
			$userID = $post['userID'];
			$siteUrl = base_url();
			// check user valid or not
			$chk_user = $this->db->get_where('users',array('id'=>$userID))->num_rows();
			if($chk_user)
			{
				// get member direct downline
				$directDownlineList = $this->User->get_member_direct_downline($userID);
				
				$data = array();
				if($directDownlineList)
				{
					foreach($directDownlineList as $key=>$list){
						
						$data[$key]['memberID'] = $list['memberID'];
						$data[$key]['name'] = $list['name'];
						$data[$key]['user_code'] = $list['user_code'];
						$data[$key]['email'] = $list['email'];
						$data[$key]['mobile'] = $list['mobile'];
						$data[$key]['level'] = $list['level'];
						$data[$key]['membership'] = $this->User->get_user_membership_type($list['memberID']);
					}
				}

				$response = array(
					'status' => 1,
					'message' => 'Success',
					'data' => $data
				);
				
			}
			else
			{
				$response = array(
					'status' => 0,
					'message' => lang('USER_ID_ERROR')
				);
			}
			
		}
		log_message('debug', 'Get User Direct Downline API Response - '.json_encode($response));	
		echo json_encode($response);
		
    }
    
    public function getUserDirectActiveDownline(){
		
		$response = array();
		$post = $this->input->post();
		log_message('debug', 'Get User Direct Active Downline API Post Data - '.json_encode($post));	
		$this->load->library('form_validation');
		//$this->form_validation->set_data($this->input->get());
		$this->form_validation->set_rules('userID', 'User ID', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE)
		{
			$response = array(
				'status' => 0,
				'message' => lang('LOGIN_VALID_FAILED')
			);
		}
		else
		{
			$userID = $post['userID'];
			$siteUrl = base_url();
			// check user valid or not
			$chk_user = $this->db->get_where('users',array('id'=>$userID))->num_rows();
			if($chk_user)
			{
				// get member direct downline
				$directDownlineList = $this->User->get_member_direct_active_downline($userID);
				
				$data = array();
				if($directDownlineList)
				{
					foreach($directDownlineList as $key=>$list){
						
						$data[$key]['memberID'] = $list['memberID'];
						$data[$key]['name'] = $list['name'];
						$data[$key]['user_code'] = $list['user_code'];
						$data[$key]['email'] = $list['email'];
						$data[$key]['mobile'] = $list['mobile'];
						$data[$key]['level'] = $list['level'];
						$data[$key]['membership'] = $this->User->get_user_membership_type($list['memberID']);
					}
				}

				$response = array(
					'status' => 1,
					'message' => 'Success',
					'data' => $data
				);
				
			}
			else
			{
				$response = array(
					'status' => 0,
					'message' => lang('USER_ID_ERROR')
				);
			}
			
		}
		log_message('debug', 'Get User Direct Active Downline API Response - '.json_encode($response));	
		echo json_encode($response);
		
    }
	
	public function getUserDirectDeactiveDownline(){
		
		$response = array();
		$post = $this->input->post();
		log_message('debug', 'Get User Direct Deactive Downline API Post Data - '.json_encode($post));	
		$this->load->library('form_validation');
		//$this->form_validation->set_data($this->input->get());
		$this->form_validation->set_rules('userID', 'User ID', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE)
		{
			$response = array(
				'status' => 0,
				'message' => lang('LOGIN_VALID_FAILED')
			);
		}
		else
		{
			$userID = $post['userID'];
			$siteUrl = base_url();
			// check user valid or not
			$chk_user = $this->db->get_where('users',array('id'=>$userID))->num_rows();
			if($chk_user)
			{
				// get member direct downline
				$directDownlineList = $this->User->get_member_direct_deactive_downline($userID);
				
				$data = array();
				if($directDownlineList)
				{
					foreach($directDownlineList as $key=>$list){
						
						$data[$key]['memberID'] = $list['memberID'];
						$data[$key]['name'] = $list['name'];
						$data[$key]['user_code'] = $list['user_code'];
						$data[$key]['email'] = $list['email'];
						$data[$key]['mobile'] = $list['mobile'];
						$data[$key]['level'] = $list['level'];
						$data[$key]['membership'] = $this->User->get_user_membership_type($list['memberID']);
					}
				}

				$response = array(
					'status' => 1,
					'message' => 'Success',
					'data' => $data
				);
				
			}
			else
			{
				$response = array(
					'status' => 0,
					'message' => lang('USER_ID_ERROR')
				);
			}
			
		}
		log_message('debug', 'Get User Direct Deactive Downline API Response - '.json_encode($response));	
		echo json_encode($response);
		
    }
	
	public function getUserTotalDownline(){
		
		$response = array();
		$post = $this->input->post();
		log_message('debug', 'Get User Total Downline API Post Data - '.json_encode($post));	
		$this->load->library('form_validation');
		//$this->form_validation->set_data($this->input->get());
		$this->form_validation->set_rules('userID', 'User ID', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE)
		{
			$response = array(
				'status' => 0,
				'message' => lang('LOGIN_VALID_FAILED')
			);
		}
		else
		{
			$userID = $post['userID'];
			$siteUrl = base_url();
			// check user valid or not
			$chk_user = $this->db->get_where('users',array('id'=>$userID))->num_rows();
			if($chk_user)
			{
				// get member direct downline
				$directDownlineList = $this->User->get_member_total_downline_member($userID);
				
				$data = array();
				if($directDownlineList)
				{
					foreach($directDownlineList as $key=>$list){
						
						$data[$key]['memberID'] = $list['memberID'];
						$data[$key]['name'] = $list['name'];
						$data[$key]['user_code'] = $list['user_code'];
						$data[$key]['email'] = $list['email'];
						$data[$key]['mobile'] = $list['mobile'];
						$data[$key]['level'] = $list['level'];
						$data[$key]['membership'] = $this->User->get_user_membership_type($list['memberID']);
					}
				}

				$response = array(
					'status' => 1,
					'message' => 'Success',
					'data' => $data
				);
				
			}
			else
			{
				$response = array(
					'status' => 0,
					'message' => lang('USER_ID_ERROR')
				);
			}
			
		}
		log_message('debug', 'Get User Total Downline API Response - '.json_encode($response));	
		echo json_encode($response);
		
    }
	
	public function getUserTotalActiveDownline(){
		
		$response = array();
		$post = $this->input->post();
		log_message('debug', 'Get User Total Active Downline API Post Data - '.json_encode($post));	
		$this->load->library('form_validation');
		//$this->form_validation->set_data($this->input->get());
		$this->form_validation->set_rules('userID', 'User ID', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE)
		{
			$response = array(
				'status' => 0,
				'message' => lang('LOGIN_VALID_FAILED')
			);
		}
		else
		{
			$userID = $post['userID'];
			$siteUrl = base_url();
			// check user valid or not
			$chk_user = $this->db->get_where('users',array('id'=>$userID))->num_rows();
			if($chk_user)
			{
				// get member direct downline
				$directDownlineList = $this->User->get_member_total_downline_member($userID);
				if($directDownlineList)
				{
					foreach($directDownlineList as $key=>$list)
					{
						if($list['paid_status'] == 0)
						{
							unset($directDownlineList[$key]);
						}
					}
				}
				$data = array();
				if($directDownlineList)
				{
					foreach($directDownlineList as $key=>$list){
						
						$data[$key]['memberID'] = $list['memberID'];
						$data[$key]['name'] = $list['name'];
						$data[$key]['user_code'] = $list['user_code'];
						$data[$key]['email'] = $list['email'];
						$data[$key]['mobile'] = $list['mobile'];
						$data[$key]['level'] = $list['level'];
						$data[$key]['membership'] = $this->User->get_user_membership_type($list['memberID']);
					}
				}

				$response = array(
					'status' => 1,
					'message' => 'Success',
					'data' => $data
				);
				
			}
			else
			{
				$response = array(
					'status' => 0,
					'message' => lang('USER_ID_ERROR')
				);
			}
			
		}
		log_message('debug', 'Get User Total Active Downline API Response - '.json_encode($response));	
		echo json_encode($response);
		
    }
	
	public function getUserTotalDeactiveDownline(){
		
		$response = array();
		$post = $this->input->post();
		log_message('debug', 'Get User Total Deactive Downline API Post Data - '.json_encode($post));	
		$this->load->library('form_validation');
		//$this->form_validation->set_data($this->input->get());
		$this->form_validation->set_rules('userID', 'User ID', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE)
		{
			$response = array(
				'status' => 0,
				'message' => lang('LOGIN_VALID_FAILED')
			);
		}
		else
		{
			$userID = $post['userID'];
			$siteUrl = base_url();
			// check user valid or not
			$chk_user = $this->db->get_where('users',array('id'=>$userID))->num_rows();
			if($chk_user)
			{
				// get member direct downline
				$directDownlineList = $this->User->get_member_total_downline_member($userID);
				if($directDownlineList)
				{
					foreach($directDownlineList as $key=>$list)
					{
						if($list['paid_status'] == 1)
						{
							unset($directDownlineList[$key]);
						}
					}
				}
				$data = array();
				if($directDownlineList)
				{
					foreach($directDownlineList as $key=>$list){
						
						$data[$key]['memberID'] = $list['memberID'];
						$data[$key]['name'] = $list['name'];
						$data[$key]['user_code'] = $list['user_code'];
						$data[$key]['email'] = $list['email'];
						$data[$key]['mobile'] = $list['mobile'];
						$data[$key]['level'] = $list['level'];
						$data[$key]['membership'] = $this->User->get_user_membership_type($list['memberID']);
					}
				}

				$response = array(
					'status' => 1,
					'message' => 'Success',
					'data' => $data
				);
				
			}
			else
			{
				$response = array(
					'status' => 0,
					'message' => lang('USER_ID_ERROR')
				);
			}
			
		}
		log_message('debug', 'Get User Total Deactive Downline API Response - '.json_encode($response));	
		echo json_encode($response);
		
    }
    
    /*public function rechargeList()
    {
        $rechargeList = $this->db->query("SELECT * FROM (SELECT a.member_id,SUM(a.amount) as total_amount FROM tbl_recharge_history as a WHERE a.created LIKE '%2020-06-24%' AND a.is_from_app = 1 AND a.status = 2 GROUP BY a.member_id) as x ORDER BY x.total_amount DESC")->result_array();
        if($rechargeList)
        {
            foreach($rechargeList as $list)
            {
                $account_id = $list['member_id'];
                $total_amount = $list['total_amount'];
                $before_balance = $this->db->get_where('users',array('id'=>$account_id))->row_array();
        		$type = 1;
        		
        		$after_balance = $before_balance['wallet_balance'] + $total_amount;    
        		
        		$wallet_data = array(
        			'member_id'           => $account_id,    
        			'before_balance'      => $before_balance['wallet_balance'],
        			'amount'              => $total_amount,  
        			'after_balance'       => $after_balance,      
        			'status'              => 1,
        			'type'                => $type,      
        			'created'             => date('Y-m-d H:i:s'),      
        			'credited_by'         => 1,
        			'description'         => 'All Recharge Refund of 24-06-2020'
                );
        
                $this->db->insert('member_wallet',$wallet_data);
        
                $user_wallet = array(
        			'wallet_balance'=>$after_balance,        
                );    
        
                $this->db->where('id',$account_id);
                $this->db->update('users',$user_wallet); 
            }
        }
        die('success');
        echo "<pre>";
        print_r($rechargeList);
        die;
    }*/
	
}


/* End of file login.php */
/* Location: ./application/controllers/login.php */