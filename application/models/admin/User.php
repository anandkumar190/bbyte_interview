<?php
if(!defined('BASEPATH'))
    exit('No direct script access allowed.');

/*
 * Model for manage users information.
 * 
 * This model used for manage user data.
 * this one used for authenticate users, get informations about users
 * @author trilok
 */


class User extends CI_Model{

    public function checkPermission($mode = 'cranesmart_admin', $is_front = false) {
        
        $user = $this->session->userdata($mode);
		$this->lang->load('front', 'english');
        if (!$user) {
            // Load language
            $currLang = $this->session->userdata('language');
            $this->lang->load('admin/dashboard', $currLang);
            $this->load->helper('language');

            if ($is_front === false) {
                $this->session->set_flashdata('message_error', lang('COMMON_ACCESS_DENIED'));
                redirect('admin/login');
            } else {
                $this->session->set_flashdata('system_message_error', lang('COMMON_ACCESS_DENIED'));
                redirect('admin/login');
            }
        }
 //only super admin can access admin panel
      /*  if($is_front === false && $user['id'] > 1){
            $this->az->redirect('', 'system_message_error', lang('COMMON_ACCESS_DENIED'));
        }*/

    }
	
	public function checkSellerPermission($mode = 'cranesmart_seller_session', $is_front = false) {
        
        $user = $this->session->userdata($mode);
		$this->lang->load('front', 'english');
        if (!$user) {
            // Load language
            $currLang = $this->session->userdata('language');
            $this->lang->load('admin/dashboard', $currLang);
            $this->load->helper('language');

            if ($is_front === false) {
                $this->session->set_flashdata('message_error', lang('COMMON_ACCESS_DENIED'));
                redirect('seller');
            } else {
                $this->session->set_flashdata('system_message_error', lang('COMMON_ACCESS_DENIED'));
                redirect('seller');
            }
        }
 //only super admin can access admin panel
      /*  if($is_front === false && $user['id'] > 1){
            $this->az->redirect('', 'system_message_error', lang('COMMON_ACCESS_DENIED'));
        }*/

    }
	
	public function checkUserPermission($mode = 'cranesmart_member_session', $is_front = false) {
        
        $user = $this->session->userdata($mode);
		$this->lang->load('front', 'english');
        if (!$user) {
            // Load language
            
            $this->load->helper('language');

            if ($is_front === false) {
                $this->session->set_flashdata('message_error', lang('COMMON_ACCESS_DENIED'));
                redirect('home');
            } else {
                $this->session->set_flashdata('system_message_error', lang('COMMON_ACCESS_DENIED'));
                redirect('home');
            }
        }
        $loggedUser = $this->session->userdata('cranesmart_member_session');
		$memberDetail = $this->db->get_where('users',array('id'=>$loggedUser['id'],'is_active'=>1))->num_rows();
		if(!$memberDetail)
		{
			$this->session->unset_userdata('cranesmart_member_session');
			$this->load->helper('language');
			$this->session->set_flashdata('message_error', lang('COMMON_ACCESS_DENIED'));
                redirect('home');
		}

    }



    
    public function getLoggedUser($sessionID = ''){
        
		$user = $this->session->userdata($sessionID);
		
        if(!$user){
	   		 redirect('admin/Login');
            return false;
        }
       if($user){
            $user = $this->db->get_where('users',array('id'=>$user['id']))->row_array();
            return $user;
        }

        

    }
	
	public function generate_unique_member_id()
	{
		$user_display_id = MEMBER_DISPLAY_ID;
		$this->load->helper('string');
		$user_display_number = random_string('numeric',6);
		$user_display_id.=$user_display_number;
		
		// check member id already registered or not
		$chk_member_id = $this->db->get_where('users',array('user_code'=>$user_display_id))->num_rows();
		if($chk_member_id)
		{
			$user_display_id = $this->generate_new_unique_member_id();
		}
		return $user_display_id;
	}
	
	public function generate_new_unique_member_id()
	{
		$user_display_id = MEMBER_DISPLAY_ID;
		$this->load->helper('string');
		$user_display_number = random_string('numeric',6);
		$user_display_id.=$user_display_number;
		
		// check member id already registered or not
		$chk_member_id = $this->db->get_where('users',array('user_code'=>$user_display_id))->num_rows();
		if($chk_member_id)
		{
			$user_display_id = $this->generate_new_unique_member_id();
		}
		return $user_display_id;
	}
	
	public function generate_unique_user_id()
	{
		$user_display_id = USER_DISPLAY_ID;
		$this->load->helper('string');
		$user_display_number = random_string('numeric',6);
		$user_display_id.=$user_display_number;
		
		// check member id already registered or not
		$chk_member_id = $this->db->get_where('users',array('user_code'=>$user_display_id))->num_rows();
		if($chk_member_id)
		{
			$user_display_id = $this->generate_new_unique_user_id();
		}
		return $user_display_id;
	}
	
	public function generate_new_unique_user_id()
	{
		$user_display_id = USER_DISPLAY_ID;
		$this->load->helper('string');
		$user_display_number = random_string('numeric',6);
		$user_display_id.=$user_display_number;
		
		// check member id already registered or not
		$chk_member_id = $this->db->get_where('users',array('user_code'=>$user_display_id))->num_rows();
		if($chk_member_id)
		{
			$user_display_id = $this->generate_new_unique_user_id();
		}
		return $user_display_id;
	}
	
	
	public function generate_unique_seller_id()
	{
		$user_display_id = SELLER_DISPLAY_ID;
		$this->load->helper('string');
		$user_display_number = random_string('numeric',6);
		$user_display_id.=$user_display_number;
		
		// check member id already registered or not
		$chk_member_id = $this->db->get_where('users',array('user_code'=>$user_display_id))->num_rows();
		if($chk_member_id)
		{
			$user_display_id = $this->generate_new_unique_seller_id();
		}
		return $user_display_id;
	}
	
	public function generate_new_unique_seller_id()
	{
		$user_display_id = SELLER_DISPLAY_ID;
		$this->load->helper('string');
		$user_display_number = random_string('numeric',6);
		$user_display_id.=$user_display_number;
		
		// check member id already registered or not
		$chk_member_id = $this->db->get_where('users',array('user_code'=>$user_display_id))->num_rows();
		if($chk_member_id)
		{
			$user_display_id = $this->generate_new_unique_seller_id();
		}
		return $user_display_id;
	}
	
	public function generate_unique_recharge_otp()
	{
		$this->load->helper('string');
		$user_display_number = random_string('numeric',4);
		$user_display_id = $user_display_number;
		
		// check member id already registered or not
		$chk_member_id = $this->db->get_where('recharge_otp',array('otp_code'=>$user_display_id))->num_rows();
		if($chk_member_id)
		{
			$user_display_id = $this->generate_unique_recharge_otp();
		}
		return $user_display_id;
	}
	
	public function getRechargeAPIBalance()
	{
		$url = 'https://paymyrecharge.in/api/balance.aspx?memberid='.RECHARGE_MEMBERID.'&pin='.RECHARGE_API_PIN;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);		
		$output = curl_exec($ch); 
		curl_close($ch);
		$api_response = array_filter(explode(',',$output));
		return isset($api_response[0]) ? $api_response[0] : 0 ;
	}
	
	public function prepaid_rechage_api($mobile,$operator_code,$circle_code,$amount,$recharge_unique_id,$account_id = 0)
	{
		$api_url = RECHARGE_API_URL.'memberid='.RECHARGE_MEMBERID.'&pin='.RECHARGE_API_PIN.'&number='.$mobile.'&operator='.$operator_code.'&circle='.$circle_code.'&amount='.$amount.'&usertx='.$recharge_unique_id;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $api_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);		
		$output = curl_exec($ch); 
		curl_close($ch);
		
		// save api response
		$apiData = array(
			'user_id' => $account_id,
			'mobile' => $mobile,
			'operator' => $operator_code,
			'circle' => $circle_code,
			'amount' => $amount,
			'recharge_id' => $recharge_unique_id,
			'account_no' => '',
			'api_response' => $output,
			'status' => 1,
			'created' => date('Y-m-d H:i:s')
		);
		$this->db->insert('api_response',$apiData);
		$api_response_id = $this->db->insert_id();
		
		$api_response = explode(',',$output);
		$recharge_status = isset($api_response[1]) ? strtolower($api_response[1]) : '';
		$txid = isset($api_response[0]) ? strtolower($api_response[0]) : '';
		$operator_ref = isset($api_response[3]) ? strtolower($api_response[3]) : '';
		$api_timestamp = isset($api_response[4]) ? strtolower($api_response[4]) : '';
		if($api_timestamp){
			$position = strpos($api_timestamp, 'M');
			$api_timestamp = substr($api_timestamp,0,$position+1);
		}
		$status = 0;
		if($recharge_status == '' || $recharge_status == 'failure')
		{
			$status = 3;
		}
		elseif($recharge_status == 'pending')
		{
			$status = 1;
		}
		elseif($recharge_status == 'success')
		{
			$status = 2;
		}
		
		return array(
			'status' => $status,
			'txid' => $txid,
			'operator_ref' => $operator_ref,
			'api_timestamp' => $api_timestamp,
			'api_response_id' => $api_response_id
		);
		
	}
	
	public function postpaid_rechage_api($mobile,$operator_code,$circle_code,$amount,$account,$recharge_unique_id,$account_id = 0)
	{
		$api_url = RECHARGE_API_URL.'memberid='.RECHARGE_MEMBERID.'&pin='.RECHARGE_API_PIN.'&number='.$mobile.'&operator='.$operator_code.'&circle='.$circle_code.'&amount='.$amount.'&account='.$account.'&usertx='.$recharge_unique_id;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $api_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);		
		$output = curl_exec($ch); 
		curl_close($ch);
		
		// save api response
		$apiData = array(
			'user_id' => $account_id,
			'mobile' => $mobile,
			'operator' => $operator_code,
			'circle' => $circle_code,
			'amount' => $amount,
			'recharge_id' => $recharge_unique_id,
			'account_no' => $account,
			'api_response' => $output,
			'status' => 1,
			'created' => date('Y-m-d H:i:s')
		);
		$this->db->insert('api_response',$apiData);
		$api_response_id = $this->db->insert_id();
		
		$api_response = explode(',',$output);
		$recharge_status = isset($api_response[1]) ? strtolower($api_response[1]) : '';
		$txid = isset($api_response[0]) ? strtolower($api_response[0]) : '';
		$operator_ref = isset($api_response[3]) ? strtolower($api_response[3]) : '';
		$api_timestamp = isset($api_response[4]) ? strtolower($api_response[4]) : '';
		if($api_timestamp){
			$position = strpos($api_timestamp, 'M');
			$api_timestamp = substr($api_timestamp,0,$position+1);
		}
		$status = 0;
		if($recharge_status == '' || $recharge_status == 'failure')
		{
			$status = 3;
		}
		elseif($recharge_status == 'pending')
		{
			$status = 1;
		}
		elseif($recharge_status == 'success')
		{
			$status = 2;
		}
		
		return array(
			'status' => $status,
			'txid' => $txid,
			'operator_ref' => $operator_ref,
			'api_timestamp' => $api_timestamp,
			'api_response_id' => $api_response_id
		);
	}
	
	
	public function getElectricityOperatorDetail($operator_code = '')
	{
		$url = ELECTRICITY_RECHARGE_FETCH_API_URL.'memberid='.RECHARGE_MEMBERID.'&pin='.RECHARGE_API_PIN.'&sp_key='.$operator_code;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);		
		$output = curl_exec($ch); 
		curl_close($ch);
		
		$api_response = explode('#',$output);
		
		$response = array();
		
		if(isset($api_response[0]) && $api_response[0])
		{
			$status_response = explode(',',$api_response[0]);
			
			if(isset($status_response[1]) && $status_response[1] == 'Success')
			{
				$billDetail = (array) json_decode($api_response[1]);
				if(isset($billDetail['data'][0]->params))
				{
					$billFieldDetail = (array) json_decode($billDetail['data'][0]->params);
					$response = array(
						'status' => 1,
						'msg' => 'Success',
						'fieldName' => $billFieldDetail[0]->name,
						'minLength' => $billFieldDetail[0]->MinLength,
						'maxLength' => $billFieldDetail[0]->MaxLength,
					);
				}
				else
				{
					$response = array(
						'status' => 0,
						'msg' => 'Operator is not activated.'
					);
				}
				
			}
			else
			{
				$response = array(
					'status' => 0,
					'msg' => 'Operator is not activated.'
				);
			}
			
		}
		else
		{
			$response = array(
				'status' => 0,
				'msg' => 'Operator is not activated.'
			);
		}
		
		return $response;
		
		
	}
	
	public function getElectricityOperatorBillerDetail($operator_code = '',$account_number = '',$account_id = 0)
	{
		if($account_id == 0)
		{
			$loggedUser = $this->session->userdata('cranesmart_member_session');
			$account_id = isset($loggedUser['id']) ? $loggedUser['id'] : 0;
		}
		if($account_id){
			// get user mobile
			$get_user_mobile = $this->db->select('mobile')->get_where('users',array('id'=>$account_id))->row_array();
			$mobile = isset($get_user_mobile['mobile']) ? $get_user_mobile['mobile'] : '';
			
			
			$url = ELECTRICITY_RECHARGE_FETCH_CUSTOMER_API_URL.'memberid='.RECHARGE_MEMBERID.'&pin='.RECHARGE_API_PIN.'&sp_key='.$operator_code.'&agentid='.$account_id.'&customer_mobile='.$mobile.'&servicenum='.$account_number;
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);		
			$output = curl_exec($ch); 
			curl_close($ch);
			
			$api_response = explode('#',$output);
		
			
			$response = array();
			
			if(isset($api_response[0]) && $api_response[0])
			{
				$status_response = explode(',',$api_response[0]);
				
				
				if(isset($status_response[1]) && $status_response[1] == 'Success')
				{
					$billDetail = (array) json_decode($api_response[1]);
					
					if(isset($billDetail['data']->dueamount))
					{
						$response = array(
							'status' => 1,
							'msg' => 'Success',
							'amount' => $billDetail['data']->dueamount,
							'customername' => $billDetail['data']->customername,
							'reference_id' => $billDetail['data']->reference_id,
						);
					}
					else
					{
						$response = array(
							'status' => 0,
							'msg' => 'Biller is not valid.'
						);
					}
					
				}
				else
				{
					$response = array(
						'status' => 0,
						'msg' => 'Biller is not valid.'
					);
				}
				
			}
			else
			{
				$response = array(
					'status' => 0,
					'msg' => 'Biller is not valid.'
				);
			}
		}
		else
		{
			$response = array(
				'status' => 0,
				'msg' => 'Please login for getting the biller detail.'
			);
		}
		
		return $response;
		
		
	}
	
	public function electricity_rechage_api($account_number,$operator_code,$amount,$reference_id,$recharge_unique_id,$account_id = 0,$mobile)
	{
		$api_url = ELECTRICITY_RECHARGE_API_URL.'memberid='.RECHARGE_MEMBERID.'&pin='.RECHARGE_API_PIN.'&number='.$account_number.'&operator='.$operator_code.'&circle=1&amount='.$amount.'&account='.$reference_id.'&usertx='.$recharge_unique_id.'&format=csv&CustomerMobile='.$mobile;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $api_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);		
		$output = curl_exec($ch); 
		curl_close($ch);
		
		// save api response
		$apiData = array(
			'user_id' => $account_id,
			'mobile' => $mobile,
			'operator' => $operator_code,
			'amount' => $amount,
			'recharge_id' => $recharge_unique_id,
			'account_no' => $account_number,
			'api_response' => $output,
			'status' => 1,
			'created' => date('Y-m-d H:i:s')
		);
		$this->db->insert('api_response',$apiData);
		$api_response_id = $this->db->insert_id();
		
		$api_response = explode(',',$output);
		$recharge_status = isset($api_response[1]) ? strtolower($api_response[1]) : '';
		$txid = isset($api_response[0]) ? strtolower($api_response[0]) : '';
		$operator_ref = isset($api_response[3]) ? strtolower($api_response[3]) : '';
		$api_timestamp = isset($api_response[4]) ? strtolower($api_response[4]) : '';
		
		$status = 0;
		if($recharge_status == '' || $recharge_status == 'failed')
		{
			$status = 3;
		}
		elseif($recharge_status == 'pending')
		{
			$status = 1;
		}
		elseif($recharge_status == 'success')
		{
			$status = 2;
		}
		
		return array(
			'status' => $status,
			'txid' => $txid,
			'operator_ref' => $operator_ref,
			'api_timestamp' => $api_timestamp,
			'api_response_id' => $api_response_id
		);
		
	}
	
	public function get_user_wallet_balance()
	{
		$loggedUser = $this->session->userdata('cranesmart_member_session');
        $account_id = $loggedUser['id'];
		// get wallet balance
		$get_wallet_balance = $this->db->select('wallet_balance')->get_where('users',array('id'=>$account_id))->row_array();
		return isset($get_wallet_balance['wallet_balance']) ? ($get_wallet_balance['wallet_balance']) ? $get_wallet_balance['wallet_balance'] : 0 : 0 ;
	}
	
	public function get_user_cm_poits_balance()
	{
		$loggedUser = $this->session->userdata('cranesmart_member_session');
        $account_id = $loggedUser['id'];
		// get wallet balance
		$get_wallet_balance = $this->db->select('cm_points')->get_where('users',array('id'=>$account_id))->row_array();
		return isset($get_wallet_balance['cm_points']) ? ($get_wallet_balance['cm_points']) ? $get_wallet_balance['cm_points'] : 0 : 0 ;
	}
	
	public function get_user_membership_type($account_id = 0)
	{
		if($account_id == 0)
		{
			$loggedUser = $this->session->userdata('cranesmart_member_session');
        	$account_id = $loggedUser['id'];
    	}
		// get wallet balance
		$get_wallet_balance = $this->db->select('package.package_name')->join('package','package.id = users.current_package_id')->get_where('users',array('users.id'=>$account_id))->row_array();
		return isset($get_wallet_balance['package_name']) ? ($get_wallet_balance['package_name']) ? $get_wallet_balance['package_name'] : 'Not Upgraded' : 'Not Upgraded' ;
	}
	
	public function get_member_current_package($account_id = 0)
	{
		if($account_id == 0)
		{
			$loggedUser = $this->session->userdata('cranesmart_member_session');
        	$account_id = $loggedUser['id'];
    	}
		// get wallet balance
		$get_wallet_balance = $this->db->select('users.current_package_id')->get_where('users',array('users.id'=>$account_id))->row_array();
		return isset($get_wallet_balance['current_package_id']) ? ($get_wallet_balance['current_package_id']) ? $get_wallet_balance['current_package_id'] : 0 : 0 ;
	}
	
	public function get_section_product_list($product_id_str = '')
	{
		$product_id = array_unique(array_filter(explode('|',$product_id_str)));
		$today_date = date('Y-m-d');
		$productList = array();
		if($product_id){
			// product list
			$productList = $this->db->where_in('id',$product_id)->get_where('products',array('status'=>1,'approve_status'=>2))->result_array();
			if($productList)
			{
				foreach($productList as $key=>$list)
				{
					// get product image
					$get_product_img = $this->db->select('image_path,file_name')->get_where('product_images',array('product_id'=>$list['id'],'is_base'=>1))->row_array();
					$product_img = isset($get_product_img['file_name']) ? 'media/product_images/thumbnail-180x180/'.$get_product_img['file_name'] : 'skin/front/images/product-default-img.png' ;
					
					$productList[$key]['product_img'] = $product_img;
					
					if($list['special_price'] && $list['special_price_to'] >= $today_date)
					{
						$productList[$key]['special_price_status'] = 1;
					}
					else
					{
						$productList[$key]['special_price_status'] = 0;
					}	
					
					
					
				}
			}
		}
		
		return $productList;
	}
	
	public function upgrade_member_package($account_id = 0,$package_id = 0)
	{
		$chk_wallet_balance =$this->db->get_where('users',array('id'=>$account_id))->row_array();
		$wallet_balance = isset($chk_wallet_balance['wallet_balance']) ? $chk_wallet_balance['wallet_balance'] : 0;
		$before_cm_balance = isset($chk_wallet_balance['cm_points']) ? $chk_wallet_balance['cm_points'] : 0;
		$user_code = isset($chk_wallet_balance['user_code']) ? $chk_wallet_balance['user_code'] : '';

		// get member current package id
		$member_current_package = $this->User->get_member_current_package();
		
		// get package amount
		$get_package_amount = $this->db->get_where('package',array('id'=>$package_id))->row_array();
		$package_amount = isset($get_package_amount['package_amount']) ? $get_package_amount['package_amount'] : 0 ;
		$package_cm_points = isset($get_package_amount['cm_points']) ? $get_package_amount['cm_points'] : 0 ;
		$package_name = isset($get_package_amount['package_name']) ? $get_package_amount['package_name'] : '' ;
		
		$before_balance = $wallet_balance;
		$deduct_amount = $package_amount;
		$after_balance = $before_balance - $deduct_amount;
		$wallet_data = array(
			'member_id'           => $account_id,    
			'before_balance'      => $before_balance,
			'amount'              => $deduct_amount,  
			'after_balance'       => $after_balance,      
			'status'              => 1,
			'type'                => 2,      
			'wallet_type'		  => 1,
			'created'             => date('Y-m-d H:i:s'),      
			'credited_by'         => $account_id,
			'description'         => 'Membership #'.$package_name.' Upgrade Wallet Deducation' 
		);

		$this->db->insert('member_wallet',$wallet_data);
		
		// update cm points wallet
		// get default package cm points
		$after_cm_balance = $package_cm_points + $before_cm_balance;
		
		$wallet_data = array(
			'member_id'           => $account_id,    
			'before_balance'      => $before_cm_balance,
			'amount'              => $package_cm_points,  
			'after_balance'       => $after_cm_balance,      
			'status'              => 1,
			'type'                => 1,      
			'wallet_type'		  => 2,
			'created'             => date('Y-m-d H:i:s'),      
			'credited_by'         => $account_id,
			'description'         => 'Membership #'.$package_name.' Upgrade Free Bonus Points'
		);
		$this->db->insert('member_wallet',$wallet_data);


		// save investment entry
		$data = array(
			'member_id' => $account_id,
			'package_id' => $package_id,
			'status' => 1,
			'created' => date('Y-m-d H:i:s')
		);
		$this->db->insert('member_investment',$data);
		$investment_id = $this->db->insert_id();

        $selected_package_id = $package_id;
        
		if($member_current_package == 2 && $package_id == 4)
		{
			$package_id = 3;
		}
		elseif($member_current_package == 4 && $package_id == 2)
		{
			$package_id = 3;
		}
		// update income status
		$userData = array(
			'wallet_balance'=>$after_balance,
			'cm_points'=>$after_cm_balance,
			'income_status' => 1,
			'current_package_id' => $package_id,
			'updated' => date('Y-m-d H:i:s')
		);
		$this->db->where('id',$account_id);
		$this->db->update('users',$userData);
		
		
		
		// check if package is preminum
		if($package_id > 1)
		{
			// get binary income percentage
			$get_direct_percentage = $this->db->get_where('master_setting',array('id'=>1))->row_array();
			$tds_percentage = isset($get_direct_percentage['tds']) ? $get_direct_percentage['tds'] : 0 ;
			//$service_tax_percentage = isset($get_direct_percentage['service_tax']) ? $get_direct_percentage['service_tax'] : 0 ;
			$service_tax_percentage = 0;
			
			$binary_amount = 1400;
			log_message('debug', 'Member #'.$user_code.' Level Income Start');
			// generate level income
			$level_member_id = $account_id;
			$level_title = array('Zero','First','Second','Third','Fourth','Fifth','Six','Seven','Eight','Nine','Ten','Eleven','Twelve','Thirteen','Fourteen','Fifteen','Sixteen','Seventeen','Eighteen','Nineteen','Twenty','Twenty One');
			
			$level = 1;
			$end_level = 21;
			if($selected_package_id == 2)
			{
				$end_level = 4;
			}
			elseif($selected_package_id == 4)
			{
				$level = 5;
				for($i = 1; $i <= 4; $i++)
				{
					// get member first level member
					$get_first_level_member = $this->db->select('member_tree.*')->get_where('member_tree',array('member_tree.member_id'=>$level_member_id))->row_array();
					$level_member_id = isset($get_first_level_member['reffrel_id']) ? $get_first_level_member['reffrel_id'] : 0;
				}
			}
			
			for($level; $level <=$end_level; $level++){
				
				$log_title = isset($level_title[$level]) ? $level_title[$level] : '';
				
				$level_member_id = $this->generate_level_income($level_member_id,$binary_amount,$user_code,$tds_percentage,$service_tax_percentage,$level,$account_id,$log_title);
			}
			
			log_message('debug', 'Member #'.$user_code.' Level Income End');
			
			// get member first level member
			$get_first_level_member = $this->db->select('users.user_code,users.is_active,users.income_status,users.current_package_id')->get_where('users',array('users.id'=>$account_id))->row_array();

			$first_level_member_code = isset($get_first_level_member['user_code']) ? $get_first_level_member['user_code'] : '';
			$first_level_member_active = isset($get_first_level_member['is_active']) ? $get_first_level_member['is_active'] : 0;
			$first_level_member_income_status = isset($get_first_level_member['income_status']) ? $get_first_level_member['income_status'] : 0;
			$current_package_id = isset($get_first_level_member['current_package_id']) ? $get_first_level_member['current_package_id'] : 0;
			$total_paid_member = $this->get_member_total_paid_member($account_id);
			if($first_level_member_active && $first_level_member_income_status && $current_package_id > 1)
			{
				$get_unpaid_data = array();
				if(($current_package_id == 2 || $current_package_id == 4) && $total_paid_member == 1)
				{
					// get unpaid record for this member
					$get_unpaid_data = $this->db->get_where('level_income',array('paid_to_member_id'=>$account_id,'level_num <'=>3,'is_paid'=>0))->result_array();
					
				}
				elseif(($current_package_id == 2 || $current_package_id == 4) && $total_paid_member > 1)
				{
					// get unpaid record for this member
					$get_unpaid_data = $this->db->get_where('level_income',array('paid_to_member_id'=>$account_id,'level_num <'=>5,'is_paid'=>0))->result_array();
				}
				elseif($current_package_id == 3 && $total_paid_member == 1)
				{
					// get unpaid record for this member
					$get_unpaid_data = $this->db->get_where('level_income',array('paid_to_member_id'=>$account_id,'level_num <'=>3,'is_paid'=>0))->result_array();
				}
				elseif($current_package_id == 3 && $total_paid_member < 3)
				{
					// get unpaid record for this member
					$get_unpaid_data = $this->db->get_where('level_income',array('paid_to_member_id'=>$account_id,'level_num <'=>5,'is_paid'=>0))->result_array();
				}
				elseif($current_package_id == 3 && $total_paid_member < 4)
				{
					// get unpaid record for this member
					$get_unpaid_data = $this->db->get_where('level_income',array('paid_to_member_id'=>$account_id,'level_num <'=>7,'is_paid'=>0))->result_array();
				}
				elseif($current_package_id == 3 && $total_paid_member < 5)
				{
					// get unpaid record for this member
					$get_unpaid_data = $this->db->get_where('level_income',array('paid_to_member_id'=>$account_id,'level_num <'=>9,'is_paid'=>0))->result_array();
				}
				elseif($current_package_id == 3 && $total_paid_member > 4)
				{
					// get unpaid record for this member
					$get_unpaid_data = $this->db->get_where('level_income',array('paid_to_member_id'=>$account_id,'level_num <'=>22,'is_paid'=>0))->result_array();
				}
				if($get_unpaid_data)
				{
					foreach ($get_unpaid_data as $pData) {
						
						$level_member_id = $pData['paid_to_member_id'];
        
		                $wallet_settle_amount = $pData['wallet_settle_amount'];
		                
		                $from_member_id = $pData['paid_from_member_id'];
		                
		                // get first level member wallet balance
						$first_member_wallet_balance = $this->db->get_where('users',array('id'=>$level_member_id))->row_array();
						$wallet_balance = isset($first_member_wallet_balance['wallet_balance']) ? $first_member_wallet_balance['wallet_balance'] : 0 ;
						
						
						$after_balance = $wallet_balance + $wallet_settle_amount;
						
						// get paid member id
						$get_member_user_code = $this->db->select('user_code')->get_where('users',array('id'=>$from_member_id))->row_array();
						$member_user_code = isset($get_member_user_code['user_code']) ? $get_member_user_code['user_code'] : '';
						
						$walletData = array(
							'member_id' => $level_member_id,
							'type' => 1,
							'before_balance' => $wallet_balance,
							'amount' => $wallet_settle_amount,
							'after_balance' => $after_balance,
							'is_income' => 1,
							'income_type' => 1,
							'description' => 'Level Income Settlement From Member #'.$member_user_code,
							'created' => date('Y-m-d H:i:s')
						);
						$this->db->insert('member_wallet',$walletData);
						
						// update member current wallet balance
						$this->db->where('id',$level_member_id);
						$this->db->update('users',array('wallet_balance'=>$after_balance));
						
						$this->db->where('id',$pData['id']);
						$this->db->update('level_income',array('is_paid'=>1));
					}
				}
			}
		}
		
		
		return true;
	}
	
	
	public function generate_level_income($member_id = 0, $binary_amount = 0,$user_code = '',$tds_percentage = 0,$service_tax_percentage = 0, $level = 0, $paid_from_member_id = 0, $log_title = '')
	{
		$first_level_member_id = 0;
		if($member_id && $level)
		{
			
			// get member first level member
			$get_first_level_member = $this->db->select('member_tree.*,users.user_code,users.is_active,users.income_status,users.current_package_id')->join('users','users.id = member_tree.reffrel_id')->get_where('member_tree',array('member_tree.member_id'=>$member_id))->row_array();
			$first_level_member_id = isset($get_first_level_member['reffrel_id']) ? $get_first_level_member['reffrel_id'] : 0;
			$first_level_member_code = isset($get_first_level_member['user_code']) ? $get_first_level_member['user_code'] : '';
			$first_level_member_active = isset($get_first_level_member['is_active']) ? $get_first_level_member['is_active'] : 0;
			$first_level_member_income_status = isset($get_first_level_member['income_status']) ? $get_first_level_member['income_status'] : 0;
			$current_package_id = isset($get_first_level_member['current_package_id']) ? $get_first_level_member['current_package_id'] : 0;
			if($first_level_member_id)
			{
				log_message('debug', 'Member #'.$user_code.' '.$log_title.' Level Member - #'.$first_level_member_code);
				// get member total paid member
				$total_paid_member = $this->get_member_total_paid_member($first_level_member_id);
				log_message('debug', 'Member #'.$user_code.' '.$log_title.' Level Member - #'.$first_level_member_code.' Total Paid Member - '.$total_paid_member);
				
				$level_status = 0;
				if($level == 1 || $level == 2)
				{
					$level_status = 1;
				}
				elseif(($level == 3 || $level == 4) && $total_paid_member > 1)
				{
					$level_status = 1;
				}
				elseif(($level == 5 || $level == 6) && $total_paid_member > 2)
				{
					$level_status = 1;
				}
				elseif(($level == 7 || $level == 8) && $total_paid_member > 3)
				{
					$level_status = 1;
				}
				elseif($level > 8 && $total_paid_member > 4)
				{
					$level_status = 1;
				}
				
				if($first_level_member_active && $first_level_member_income_status && $current_package_id > 1 && $level_status)
				{
					// get first level comission
					$get_first_level_comission = $this->db->get_where('level_master',array('id'=>$level))->row_array();
					$first_level_comission = isset($get_first_level_comission['comission']) ? $get_first_level_comission['comission'] : 0 ;
					log_message('debug', 'Member #'.$user_code.' '.$log_title.' Level Comission - '.$first_level_comission);
					
					// calculate first level - level amount
					$first_level_amount = round(($first_level_comission/100)*$binary_amount,2);
					log_message('debug', 'Member #'.$user_code.' '.$log_title.' Level Member Level Amount -'.$first_level_amount);
					// calculate TDS amount
					$first_tds_amount = 0;
					if($tds_percentage)
					{
						$first_tds_amount = round(($tds_percentage/100)*$first_level_amount,2);
					}
					log_message('debug', 'Member #'.$user_code.' '.$log_title.' Level Member TDS Amount -'.$first_tds_amount);
					// calculate TDS amount
					$first_service_tax_amount = 0;
					if($service_tax_percentage)
					{
						$first_service_tax_amount = round(($service_tax_percentage/100)*$first_level_amount,2);
					}
					log_message('debug', 'Member #'.$user_code.' '.$log_title.' Level Member Service Amount -'.$first_service_tax_amount);
					// calculate Total Tax amount
					$first_total_tax_amount = $first_tds_amount + $first_service_tax_amount;
					log_message('debug', 'Member #'.$user_code.' '.$log_title.' Level Member Total Tax -'.$first_total_tax_amount);
					// calculate Wallet Settlement amount
					$first_wallet_settle_amount = $first_level_amount - $first_total_tax_amount;
					log_message('debug', 'Member #'.$user_code.' '.$log_title.' Level Member Wallet Settlement Amount -'.$first_wallet_settle_amount);
					
					log_message('debug', 'Member #'.$user_code.' '.$log_title.' Level Member Wallet Paid Status - Yes');
					
					// save data into DB
					
					$incomeData = array(
						'paid_to_member_id' => $first_level_member_id,
						'paid_from_member_id' => $paid_from_member_id,
						'level_num' => $level,
						'level_comission' => $first_level_comission,
						'package_amount' => $binary_amount,
						'level_amount' => $first_level_amount,
						'tds_percentage' => $tds_percentage,
						'tds_amount' => $first_tds_amount,
						'service_tax_percentage' => $service_tax_percentage,
						'service_tax_amount' => $first_service_tax_amount,
						'total_tax_amount' => $first_total_tax_amount,
						'wallet_settle_amount' => $first_wallet_settle_amount,
						'is_paid' => 1,
						'created' => date('Y-m-d H:i:s')
					);
					$this->db->insert('level_income',$incomeData);
					
					// get first level member wallet balance
					$get_first_member_wallet_balance = $this->db->get_where('users',array('id'=>$first_level_member_id))->row_array();
					$first_wallet_balance = isset($get_first_member_wallet_balance['wallet_balance']) ? $get_first_member_wallet_balance['wallet_balance'] : 0 ;
					
					log_message('debug', 'Member #'.$user_code.' '.$log_title.' Level Member Wallet Balance -'.$first_wallet_balance);

					$first_after_balance = $first_wallet_balance + $first_wallet_settle_amount;
					
					// get paid member id
					$get_member_user_code = $this->db->select('user_code')->get_where('users',array('id'=>$paid_from_member_id))->row_array();
					$member_user_code = isset($get_member_user_code['user_code']) ? $get_member_user_code['user_code'] : '';
					
					log_message('debug', 'Member #'.$user_code.' '.$log_title.' Level Member After Wallet Balance -'.$first_after_balance);
					$walletData = array(
						'member_id' => $first_level_member_id,
						'type' => 1,
						'before_balance' => $first_wallet_balance,
						'amount' => $first_wallet_settle_amount,
						'after_balance' => $first_after_balance,
						'is_income' => 1,
						'income_type' => 1,
						'description' => 'Level Income Settlement From Member #'.$member_user_code,
						'created' => date('Y-m-d H:i:s')
					);
					$this->db->insert('member_wallet',$walletData);
					
					// update member current wallet balance
					$this->db->where('id',$first_level_member_id);
					$this->db->update('users',array('wallet_balance'=>$first_after_balance));
				}
				else
				{
					// get first level comission
					$get_first_level_comission = $this->db->get_where('level_master',array('id'=>$level))->row_array();
					$first_level_comission = isset($get_first_level_comission['comission']) ? $get_first_level_comission['comission'] : 0 ;
					log_message('debug', 'Member #'.$user_code.' First Level Comission - '.$first_level_comission);
					
					// calculate first level - level amount
					$first_level_amount = round(($first_level_comission/100)*$binary_amount,2);
					log_message('debug', 'Member #'.$user_code.' '.$log_title.' Level Member Level Amount -'.$first_level_amount);
					// calculate TDS amount
					$first_tds_amount = 0;
					if($tds_percentage)
					{
						$first_tds_amount = round(($tds_percentage/100)*$first_level_amount,2);
					}
					log_message('debug', 'Member #'.$user_code.' '.$log_title.' Level Member TDS Amount -'.$first_tds_amount);
					// calculate TDS amount
					$first_service_tax_amount = 0;
					if($service_tax_percentage)
					{
						$first_service_tax_amount = round(($service_tax_percentage/100)*$first_level_amount,2);
					}
					log_message('debug', 'Member #'.$user_code.' '.$log_title.' Level Member Service Amount -'.$first_service_tax_amount);
					// calculate Total Tax amount
					$first_total_tax_amount = $first_tds_amount + $first_service_tax_amount;
					log_message('debug', 'Member #'.$user_code.' '.$log_title.' Level Member Total Tax -'.$first_total_tax_amount);
					// calculate Wallet Settlement amount
					$first_wallet_settle_amount = $first_level_amount - $first_total_tax_amount;
					log_message('debug', 'Member #'.$user_code.' '.$log_title.' Level Member Wallet Settlement Amount -'.$first_wallet_settle_amount);
					
					log_message('debug', 'Member #'.$user_code.' '.$log_title.' Level Member Wallet Paid Status - No');
					
					// save data into DB
					
					$incomeData = array(
						'paid_to_member_id' => $first_level_member_id,
						'paid_from_member_id' => $paid_from_member_id,
						'level_num' => $level,
						'level_comission' => $first_level_comission,
						'package_amount' => $binary_amount,
						'level_amount' => $first_level_amount,
						'tds_percentage' => $tds_percentage,
						'tds_amount' => $first_tds_amount,
						'service_tax_percentage' => $service_tax_percentage,
						'service_tax_amount' => $first_service_tax_amount,
						'total_tax_amount' => $first_total_tax_amount,
						'wallet_settle_amount' => $first_wallet_settle_amount,
						'is_paid' => 0,
						'created' => date('Y-m-d H:i:s')
					);
					$this->db->insert('level_income',$incomeData);
					
				}
				
				// convert unpaid to paid for member
				if($first_level_member_active && $first_level_member_income_status && $current_package_id > 1)
				{
					$get_unpaid_data = array();
					if(($current_package_id == 2 || $current_package_id == 4) && $total_paid_member == 1)
					{
						// get unpaid record for this member
						$get_unpaid_data = $this->db->get_where('level_income',array('paid_to_member_id'=>$first_level_member_id,'level_num <'=>3,'is_paid'=>0))->result_array();
						
					}
					elseif(($current_package_id == 2 || $current_package_id == 4) && $total_paid_member > 1)
					{
						// get unpaid record for this member
						$get_unpaid_data = $this->db->get_where('level_income',array('paid_to_member_id'=>$first_level_member_id,'level_num <'=>5,'is_paid'=>0))->result_array();
					}
					elseif($current_package_id == 3 && $total_paid_member == 1)
					{
						// get unpaid record for this member
						$get_unpaid_data = $this->db->get_where('level_income',array('paid_to_member_id'=>$first_level_member_id,'level_num <'=>3,'is_paid'=>0))->result_array();
					}
					elseif($current_package_id == 3 && $total_paid_member < 3)
					{
						// get unpaid record for this member
						$get_unpaid_data = $this->db->get_where('level_income',array('paid_to_member_id'=>$first_level_member_id,'level_num <'=>5,'is_paid'=>0))->result_array();
					}
					elseif($current_package_id == 3 && $total_paid_member < 4)
					{
						// get unpaid record for this member
						$get_unpaid_data = $this->db->get_where('level_income',array('paid_to_member_id'=>$first_level_member_id,'level_num <'=>7,'is_paid'=>0))->result_array();
					}
					elseif($current_package_id == 3 && $total_paid_member < 5)
					{
						// get unpaid record for this member
						$get_unpaid_data = $this->db->get_where('level_income',array('paid_to_member_id'=>$first_level_member_id,'level_num <'=>9,'is_paid'=>0))->result_array();
					}
					elseif($current_package_id == 3 && $total_paid_member > 4)
					{
						// get unpaid record for this member
						$get_unpaid_data = $this->db->get_where('level_income',array('paid_to_member_id'=>$first_level_member_id,'level_num <'=>22,'is_paid'=>0))->result_array();
					}
					if($get_unpaid_data)
					{
						foreach ($get_unpaid_data as $pData) {
							
							$level_member_id = $pData['paid_to_member_id'];
            
			                $wallet_settle_amount = $pData['wallet_settle_amount'];
			                
			                $from_member_id = $pData['paid_from_member_id'];
			                
			                // get first level member wallet balance
							$first_member_wallet_balance = $this->db->get_where('users',array('id'=>$level_member_id))->row_array();
							$wallet_balance = isset($first_member_wallet_balance['wallet_balance']) ? $first_member_wallet_balance['wallet_balance'] : 0 ;
							
							
							$after_balance = $wallet_balance + $wallet_settle_amount;
							
							// get paid member id
							$get_member_user_code = $this->db->select('user_code')->get_where('users',array('id'=>$from_member_id))->row_array();
							$member_user_code = isset($get_member_user_code['user_code']) ? $get_member_user_code['user_code'] : '';
							
							$walletData = array(
								'member_id' => $level_member_id,
								'type' => 1,
								'before_balance' => $wallet_balance,
								'amount' => $wallet_settle_amount,
								'after_balance' => $after_balance,
								'is_income' => 1,
								'income_type' => 1,
								'description' => 'Level Income Settlement From Member #'.$member_user_code,
								'created' => date('Y-m-d H:i:s')
							);
							$this->db->insert('member_wallet',$walletData);
							
							// update member current wallet balance
							$this->db->where('id',$level_member_id);
							$this->db->update('users',array('wallet_balance'=>$after_balance));
							
							$this->db->where('id',$pData['id']);
							$this->db->update('level_income',array('is_paid'=>1));
						}
					}
				}
						
			}
		}
		return $first_level_member_id;
	}
	
	public function upgrade_member_package_manual($account_id = 0,$package_id = 0)
	{
		$chk_wallet_balance =$this->db->get_where('users',array('id'=>$account_id))->row_array();
		$wallet_balance = isset($chk_wallet_balance['wallet_balance']) ? $chk_wallet_balance['wallet_balance'] : 0;
		$before_cm_balance = isset($chk_wallet_balance['cm_points']) ? $chk_wallet_balance['cm_points'] : 0;
		$user_code = isset($chk_wallet_balance['user_code']) ? $chk_wallet_balance['user_code'] : '';
		
		$member_current_package = $this->User->get_member_current_package($account_id);

		// get package amount
		$get_package_amount = $this->db->get_where('package',array('id'=>$package_id))->row_array();
		$package_amount = isset($get_package_amount['package_amount']) ? $get_package_amount['package_amount'] : 0 ;
		$package_cm_points = isset($get_package_amount['cm_points']) ? $get_package_amount['cm_points'] : 0 ;
		$package_name = isset($get_package_amount['package_name']) ? $get_package_amount['package_name'] : '' ;
		
		// update cm points wallet
		// get default package cm points
		$after_cm_balance = $package_cm_points + $before_cm_balance;
		
		$wallet_data = array(
			'member_id'           => $account_id,    
			'before_balance'      => $before_cm_balance,
			'amount'              => $package_cm_points,  
			'after_balance'       => $after_cm_balance,      
			'status'              => 1,
			'type'                => 1,      
			'wallet_type'		  => 2,
			'created'             => date('Y-m-d H:i:s'),      
			'credited_by'         => 1,
			'description'         => 'Membership #'.$package_name.' Upgrade Free Bonus Points'
		);
		$this->db->insert('member_wallet',$wallet_data);

		// save investment entry
		$data = array(
			'member_id' => $account_id,
			'package_id' => $package_id,
			'status' => 1,
			'created' => date('Y-m-d H:i:s')
		);
		$this->db->insert('member_investment',$data);
		$investment_id = $this->db->insert_id();
        
        $selected_package_id = $package_id;
        
		if($member_current_package == 2 && $package_id == 4)
		{
			$package_id = 3;
		}
		elseif($member_current_package == 4 && $package_id == 2)
		{
			$package_id = 3;
		}

		// update income status
		$userData = array(
			'cm_points'=>$after_cm_balance,
			'income_status' => 1,
			'current_package_id' => $package_id,
			'updated' => date('Y-m-d H:i:s')
		);
		$this->db->where('id',$account_id);
		$this->db->update('users',$userData);
		
		

		// check if package is preminum
		if($package_id > 1)
		{
			// get binary income percentage
			$get_direct_percentage = $this->db->get_where('master_setting',array('id'=>1))->row_array();
			$tds_percentage = isset($get_direct_percentage['tds']) ? $get_direct_percentage['tds'] : 0 ;
			//$service_tax_percentage = isset($get_direct_percentage['service_tax']) ? $get_direct_percentage['service_tax'] : 0 ;
			$service_tax_percentage = 0;
			
			$binary_amount = 1400;
			log_message('debug', 'Member #'.$user_code.' Level Income Start');
			// generate level income
			$level_member_id = $account_id;
			$level_title = array('Zero','First','Second','Third','Fourth','Fifth','Six','Seven','Eight','Nine','Ten','Eleven','Twelve','Thirteen','Fourteen','Fifteen','Sixteen','Seventeen','Eighteen','Nineteen','Twenty','Twenty One');
			
			$level = 1;
			$end_level = 21;
			if($selected_package_id == 2)
			{
				$end_level = 4;
			}
			elseif($selected_package_id == 4)
			{
				$level = 5;
				for($i = 1; $i <= 4; $i++)
				{
					// get member first level member
					$get_first_level_member = $this->db->select('member_tree.*')->get_where('member_tree',array('member_tree.member_id'=>$level_member_id))->row_array();
					$level_member_id = isset($get_first_level_member['reffrel_id']) ? $get_first_level_member['reffrel_id'] : 0;
				}
			}
			
			for($level; $level <=$end_level; $level++){
				
				$log_title = isset($level_title[$level]) ? $level_title[$level] : '';
				
				$level_member_id = $this->generate_level_income($level_member_id,$binary_amount,$user_code,$tds_percentage,$service_tax_percentage,$level,$account_id,$log_title);
			}
			
			log_message('debug', 'Member #'.$user_code.' Level Income End');
			
			// get member first level member
			$get_first_level_member = $this->db->select('users.user_code,users.is_active,users.income_status,users.current_package_id')->get_where('users',array('users.id'=>$account_id))->row_array();

			$first_level_member_code = isset($get_first_level_member['user_code']) ? $get_first_level_member['user_code'] : '';
			$first_level_member_active = isset($get_first_level_member['is_active']) ? $get_first_level_member['is_active'] : 0;
			$first_level_member_income_status = isset($get_first_level_member['income_status']) ? $get_first_level_member['income_status'] : 0;
			$current_package_id = isset($get_first_level_member['current_package_id']) ? $get_first_level_member['current_package_id'] : 0;
			$total_paid_member = $this->get_member_total_paid_member($account_id);
			if($first_level_member_active && $first_level_member_income_status && $current_package_id > 1)
			{
				$get_unpaid_data = array();
				if(($current_package_id == 2 || $current_package_id == 4) && $total_paid_member == 1)
				{
					// get unpaid record for this member
					$get_unpaid_data = $this->db->get_where('level_income',array('paid_to_member_id'=>$account_id,'level_num <'=>3,'is_paid'=>0))->result_array();
					
				}
				elseif(($current_package_id == 2 || $current_package_id == 4) && $total_paid_member > 1)
				{
					// get unpaid record for this member
					$get_unpaid_data = $this->db->get_where('level_income',array('paid_to_member_id'=>$account_id,'level_num <'=>5,'is_paid'=>0))->result_array();
				}
				elseif($current_package_id == 3 && $total_paid_member == 1)
				{
					// get unpaid record for this member
					$get_unpaid_data = $this->db->get_where('level_income',array('paid_to_member_id'=>$account_id,'level_num <'=>3,'is_paid'=>0))->result_array();
				}
				elseif($current_package_id == 3 && $total_paid_member < 3)
				{
					// get unpaid record for this member
					$get_unpaid_data = $this->db->get_where('level_income',array('paid_to_member_id'=>$account_id,'level_num <'=>5,'is_paid'=>0))->result_array();
				}
				elseif($current_package_id == 3 && $total_paid_member < 4)
				{
					// get unpaid record for this member
					$get_unpaid_data = $this->db->get_where('level_income',array('paid_to_member_id'=>$account_id,'level_num <'=>7,'is_paid'=>0))->result_array();
				}
				elseif($current_package_id == 3 && $total_paid_member < 5)
				{
					// get unpaid record for this member
					$get_unpaid_data = $this->db->get_where('level_income',array('paid_to_member_id'=>$account_id,'level_num <'=>9,'is_paid'=>0))->result_array();
				}
				elseif($current_package_id == 3 && $total_paid_member > 4)
				{
					// get unpaid record for this member
					$get_unpaid_data = $this->db->get_where('level_income',array('paid_to_member_id'=>$account_id,'level_num <'=>22,'is_paid'=>0))->result_array();
				}
				if($get_unpaid_data)
				{
					foreach ($get_unpaid_data as $pData) {
						
						$level_member_id = $pData['paid_to_member_id'];
        
		                $wallet_settle_amount = $pData['wallet_settle_amount'];
		                
		                $from_member_id = $pData['paid_from_member_id'];
		                
		                // get first level member wallet balance
						$first_member_wallet_balance = $this->db->get_where('users',array('id'=>$level_member_id))->row_array();
						$wallet_balance = isset($first_member_wallet_balance['wallet_balance']) ? $first_member_wallet_balance['wallet_balance'] : 0 ;
						
						
						$after_balance = $wallet_balance + $wallet_settle_amount;
						
						// get paid member id
						$get_member_user_code = $this->db->select('user_code')->get_where('users',array('id'=>$from_member_id))->row_array();
						$member_user_code = isset($get_member_user_code['user_code']) ? $get_member_user_code['user_code'] : '';
						
						$walletData = array(
							'member_id' => $level_member_id,
							'type' => 1,
							'before_balance' => $wallet_balance,
							'amount' => $wallet_settle_amount,
							'after_balance' => $after_balance,
							'is_income' => 1,
							'income_type' => 1,
							'description' => 'Level Income Settlement From Member #'.$member_user_code,
							'created' => date('Y-m-d H:i:s')
						);
						$this->db->insert('member_wallet',$walletData);
						
						// update member current wallet balance
						$this->db->where('id',$level_member_id);
						$this->db->update('users',array('wallet_balance'=>$after_balance));
						
						$this->db->where('id',$pData['id']);
						$this->db->update('level_income',array('is_paid'=>1));
					}
				}
			}
		}
		
		return true;
	}
	
	public function get_member_direct_downline($account_id = 0, $level = 0)
	{
		$level++;
		// get parent members
		$get_parent_members = $this->db->select('users.id,users.user_code,users.name,users.email,users.mobile')->join('users','users.id = member_tree.member_id')->get_where('member_tree',array('member_tree.reffrel_id'=>$account_id))->result_array();
		$tree_response = array();
		if($get_parent_members)
		{
			foreach($get_parent_members as $key=>$list){
				
				$tree_response[$key]['memberID'] = $list['id'];
				$tree_response[$key]['name'] = $list['name'];
				$tree_response[$key]['user_code'] = $list['user_code'];
				$tree_response[$key]['email'] = $list['email'];
				$tree_response[$key]['mobile'] = $list['mobile'];
				$tree_response[$key]['level'] = $level;
				$tree_response[$key]['paid_status'] = $this->db->get_where('member_investment',array('member_id'=>$list['id'],'package_id >'=>1))->num_rows();
			}
		}
		
		return $tree_response;
	}
	
	public function get_member_direct_active_downline($account_id = 0, $level = 0)
	{
		$level++;
		// get parent members
		$get_parent_members = $this->db->select('users.id,users.user_code,users.name,users.email,users.mobile')->join('users','users.id = member_tree.member_id')->get_where('member_tree',array('member_tree.reffrel_id'=>$account_id))->result_array();
		$tree_response = array();
		if($get_parent_members)
		{
			foreach($get_parent_members as $key=>$list){
				
				$paid_status = $this->db->get_where('member_investment',array('member_id'=>$list['id'],'package_id >'=>1))->num_rows();
				if($paid_status){
					$tree_response[$key]['memberID'] = $list['id'];
					$tree_response[$key]['name'] = $list['name'];
					$tree_response[$key]['user_code'] = $list['user_code'];
					$tree_response[$key]['email'] = $list['email'];
					$tree_response[$key]['mobile'] = $list['mobile'];
					$tree_response[$key]['level'] = $level;
					$tree_response[$key]['paid_status'] = $paid_status;
				}
			}
		}
		
		return $tree_response;
	}
	
	public function get_member_direct_deactive_downline($account_id = 0, $level = 0)
	{
		$level++;
		// get parent members
		$get_parent_members = $this->db->select('users.id,users.user_code,users.name,users.email,users.mobile')->join('users','users.id = member_tree.member_id')->get_where('member_tree',array('member_tree.reffrel_id'=>$account_id))->result_array();
		$tree_response = array();
		if($get_parent_members)
		{
			foreach($get_parent_members as $key=>$list){
				
				$paid_status = $this->db->get_where('member_investment',array('member_id'=>$list['id'],'package_id >'=>1))->num_rows();
				if(!$paid_status){
					$tree_response[$key]['memberID'] = $list['id'];
					$tree_response[$key]['name'] = $list['name'];
					$tree_response[$key]['user_code'] = $list['user_code'];
					$tree_response[$key]['email'] = $list['email'];
					$tree_response[$key]['mobile'] = $list['mobile'];
					$tree_response[$key]['level'] = $level;
					$tree_response[$key]['paid_status'] = $paid_status;
				}
			}
		}
		
		return $tree_response;
	}
	
	public function get_member_total_downline_member($account_id = 0, $level = 0)
	{
		$level++;
		// get parent members
		$get_parent_members = $this->db->select('users.id,users.user_code,users.name,users.email,users.mobile')->join('users','users.id = member_tree.member_id')->get_where('member_tree',array('member_tree.reffrel_id'=>$account_id))->result_array();
		$key = 0;
		$top_level_member_id = array();
		if($get_parent_members)
		{
			foreach($get_parent_members as $list){
				
				$top_level_member_id[$key] = $list['id'];
				
				$tree_response[$key]['memberID'] = $list['id'];
				$tree_response[$key]['name'] = $list['name'];
				$tree_response[$key]['user_code'] = $list['user_code'];
				$tree_response[$key]['email'] = $list['email'];
				$tree_response[$key]['mobile'] = $list['mobile'];
				$tree_response[$key]['level'] = $level;
				$tree_response[$key]['paid_status'] = $this->db->get_where('member_investment',array('member_id'=>$list['id'],'package_id >'=>1))->num_rows();
				$key++;
				
			}
		}
		
		if($top_level_member_id)
		{
			$tree_response = $this->get_down_level_member($key,$level,$top_level_member_id,$tree_response);
		}
		
		return $tree_response;
	}
	
	public function get_down_level_member($key,$level,$top_level_member_id,$tree_response)
	{
		
		$level++;
		// get parent members
		$get_parent_members = $this->db->select('users.id,users.user_code,users.name,users.email,users.mobile')->join('users','users.id = member_tree.member_id')->where_in('member_tree.reffrel_id',$top_level_member_id)->get('member_tree')->result_array();
		
		$top_level_member_id = array();
		if($get_parent_members)
		{
			foreach($get_parent_members as $list){
				
				$top_level_member_id[$key] = $list['id'];
				
				$tree_response[$key]['memberID'] = $list['id'];
				$tree_response[$key]['name'] = $list['name'];
				$tree_response[$key]['user_code'] = $list['user_code'];
				$tree_response[$key]['email'] = $list['email'];
				$tree_response[$key]['mobile'] = $list['mobile'];
				$tree_response[$key]['level'] = $level;
				$tree_response[$key]['paid_status'] = $this->db->get_where('member_investment',array('member_id'=>$list['id'],'package_id >'=>1))->num_rows();
				$key++;
				
			}
		}
		if($top_level_member_id)
		{
			$tree_response = $this->get_down_level_member($key,$level,$top_level_member_id,$tree_response);
		}
		
		return $tree_response;
	}
	
	public function get_member_tree($account_id = 0, $level = 0)
	{
		$level++;
		// get parent members
		$get_parent_members = $this->db->select('users.id,users.user_code,users.name')->join('users','users.id = member_tree.member_id')->get_where('member_tree',array('member_tree.reffrel_id'=>$account_id))->result_array();
		$tree_response = array();
		if($get_parent_members)
		{
			foreach($get_parent_members as $key=>$list){
				
				$tree_response[$key]['memberID'] = $list['id'];
				$tree_response[$key]['name'] = $list['name'];
				$tree_response[$key]['code'] = $list['user_code'];
				$tree_response[$key]['level'] = $level;
				$tree_response[$key]['paid_status'] = $this->db->get_where('member_investment',array('member_id'=>$list['id'],'package_id >'=>1))->num_rows();
				$tree_response[$key]['total_paid'] = $this->get_paid_member($list['id']);
				$tree_response[$key]['total_unpaid'] = $this->get_unpaid_member($list['id']);
				$tree_response[$key]['total_downline'] = $this->get_member_total_downline($list['id']);
				$tree_response[$key]['total_downline_paid'] = $this->get_member_total_downline_paid($list['id']);
				$tree_response[$key]['total_downline_unpaid'] = $this->get_member_total_downline_unpaid($list['id']);
				$tree_response[$key]['child'] = $this->get_member_tree($list['id'],$level);
			}
		}
		
		return $tree_response;
	}
	
	public function get_paid_member($member_id = 0)
	{
		$total_left_member = 0;
		// get member left member level
		$get_left_member = $this->db->get_where('member_tree',array('parent_id'=>$member_id,'position'=>'L'))->result_array();
		
		if($get_left_member)
		{
			foreach($get_left_member as $pList)
			{
				$left_member_id = $pList['member_id'];
				// check member investment
				$chk_member_investment = $this->db->get_where('member_investment',array('member_id' => $left_member_id,'package_id >'=>1))->num_rows();
				if($chk_member_investment){
					$total_left_member++;
				}
			}
			//$total_left_member = $this->get_paid_member_down($left_member_id,$total_left_member);
			
		}
		
		
		return $total_left_member;
	}
	
	
	public function get_unpaid_member($member_id = 0)
	{
		$total_left_member = 0;
		// get member left member level
		$get_left_member = $this->db->get_where('member_tree',array('parent_id'=>$member_id,'position'=>'L'))->result_array();
		if($get_left_member)
		{
			foreach($get_left_member as $pList)
			{
				$left_member_id = $pList['member_id'];
				// check member investment
				$chk_member_investment = $this->db->get_where('users',array('id' => $left_member_id,'current_package_id <'=>2))->num_rows();
				if($chk_member_investment){
					$total_left_member++;
				}
			}
			//$total_left_member = $this->get_paid_member_down($left_member_id,$total_left_member);
			
		}
		
		
		return $total_left_member;
	}
	
	public function get_user_total_direct()
	{
		$loggedUser = $this->session->userdata('cranesmart_member_session');
        $account_id = $loggedUser['id'];
		$total_paid = $this->get_paid_member($account_id);
		$total_unpaid = $this->get_unpaid_member($account_id);
		return $total_paid + $total_unpaid;
	}
	
	public function get_user_total_paid_member()
	{
		$loggedUser = $this->session->userdata('cranesmart_member_session');
        $account_id = $loggedUser['id'];
		$total_paid = $this->get_paid_member($account_id);
		return $total_paid;
	}
	
	
	public function get_user_total_unpaid_member()
	{
		$loggedUser = $this->session->userdata('cranesmart_member_session');
        $account_id = $loggedUser['id'];
		$total_unpaid = $this->get_unpaid_member($account_id);
		return $total_unpaid;
	}
	
	public function get_user_total_downline()
	{
		$loggedUser = $this->session->userdata('cranesmart_member_session');
        $account_id = $loggedUser['id'];
		$total_downline = $this->get_member_total_downline($account_id);
		return $total_downline;
	}
	
	public function get_user_total_downline_paid()
	{
		$loggedUser = $this->session->userdata('cranesmart_member_session');
        $account_id = $loggedUser['id'];
		$total_paid = $this->get_member_total_downline_paid($account_id);
		return $total_paid;
	}
	
	public function get_user_total_downline_unpaid()
	{
		$loggedUser = $this->session->userdata('cranesmart_member_session');
        $account_id = $loggedUser['id'];
		$total_paid = $this->get_member_total_downline_unpaid($account_id);
		return $total_paid;
	}
	
	public function get_member_total_paid_member($account_id = 0)
	{
		$total_paid = $this->get_paid_member($account_id);
		return $total_paid;
	}
	
	public function get_member_total_downline($member_id = 0)
	{
		$total_left_member = 0;
		// get member left member level
		$get_left_member = $this->db->get_where('member_tree',array('parent_id'=>$member_id,'position'=>'L'))->result_array();
		if($get_left_member)
		{
			foreach($get_left_member as $list)
			{
				$left_member_id = $list['member_id'];
				$total_left_member++;
				$total_left_member = $this->get_member_total_downline_counting($left_member_id,$total_left_member);
			}
			
		}
		
		return $total_left_member;
	}
	
	public function get_member_total_downline_counting($member_id = 0,$total_left_member)
	{
		// get member left member level
		$get_left_member = $this->db->get_where('member_tree',array('parent_id'=>$member_id))->result_array();
		if($get_left_member)
		{
			foreach($get_left_member as $list)
			{
				$total_left_member++;
				
				$right_member_id = $list['member_id'];
				$total_left_member = $this->get_member_total_downline_counting($right_member_id,$total_left_member);
			}
		}
		return $total_left_member;
		
	}
	
	
	public function get_member_total_downline_paid($member_id = 0)
	{
		$total_left_member = 0;
		// get member left member level
		$get_left_member = $this->db->get_where('member_tree',array('parent_id'=>$member_id,'position'=>'L'))->result_array();
		if($get_left_member)
		{
			foreach($get_left_member as $list)
			{
				$left_member_id = $list['member_id'];
				// check member investment
				$chk_member_investment = $this->db->get_where('member_investment',array('member_id' => $left_member_id,'package_id >'=>1))->num_rows();
				if($chk_member_investment){
					$total_left_member++;
				}
				$total_left_member = $this->get_member_total_downline_paid_counting($left_member_id,$total_left_member);
			}
			
		}
		
		return $total_left_member;
	}
	
	public function get_member_total_downline_paid_counting($member_id = 0,$total_left_member)
	{
		// get member left member level
		$get_left_member = $this->db->get_where('member_tree',array('parent_id'=>$member_id))->result_array();
		if($get_left_member)
		{
			foreach($get_left_member as $list)
			{
				$right_member_id = $list['member_id'];
				// check member investment
				$chk_member_investment = $this->db->get_where('member_investment',array('member_id' => $right_member_id,'package_id >'=>1))->num_rows();
				if($chk_member_investment){
					$total_left_member++;
				}
				$total_left_member = $this->get_member_total_downline_paid_counting($right_member_id,$total_left_member);
			}
		}
		return $total_left_member;
		
	}
	
	public function get_member_total_downline_unpaid($member_id = 0)
	{
		$total_left_member = 0;
		// get member left member level
		$get_left_member = $this->db->get_where('member_tree',array('parent_id'=>$member_id,'position'=>'L'))->result_array();
		if($get_left_member)
		{
			foreach($get_left_member as $list)
			{
				$left_member_id = $list['member_id'];
				// check member investment
				$chk_member_investment = $this->db->get_where('member_investment',array('member_id' => $left_member_id,'package_id >'=>1))->num_rows();
				if(!$chk_member_investment){
					$total_left_member++;
				}
				$total_left_member = $this->get_member_total_downline_unpaid_counting($left_member_id,$total_left_member);
			}
			
		}
		
		return $total_left_member;
	}
	
	public function get_member_total_downline_unpaid_counting($member_id = 0,$total_left_member)
	{
		// get member left member level
		$get_left_member = $this->db->get_where('member_tree',array('parent_id'=>$member_id))->result_array();
		if($get_left_member)
		{
			foreach($get_left_member as $list)
			{
				$right_member_id = $list['member_id'];
				// check member investment
				$chk_member_investment = $this->db->get_where('member_investment',array('member_id' => $right_member_id,'package_id >'=>1))->num_rows();
				if(!$chk_member_investment){
					$total_left_member++;
				}
				$total_left_member = $this->get_member_total_downline_unpaid_counting($right_member_id,$total_left_member);
			}
		}
		return $total_left_member;
		
	}
	
	
	public function get_category_menu_list()
	{
		$categoryList = $this->db->order_by('order_number','asc')->get_where('category',array('parent_id'=>0,'status'=>1,'is_cranes_choice'=>0))->result_array();
		$parent_category_list = array();
		$j = 0;
		if($categoryList)
		{
			foreach($categoryList as $key=>$list)
			{
				$parent_category_list[$key]['id'] = $list['id'];
				$parent_category_list[$key]['title'] = $list['title'];
				$parent_category_list[$key]['slug'] = $list['slug'];
				$parent_category_list[$key]['menu_status'] = $list['menu_status'];
				$parent_category_list[$key]['status'] = $list['status'];
				$j++;
				$cat_id = $list['id'];
				$subCategoryList = $this->db->order_by('order_number','asc')->get_where('category',array('parent_id'=>$cat_id,'status'=>1,'is_cranes_choice'=>0))->result_array();
				if($subCategoryList)
				{
					foreach($subCategoryList as $subKey=>$subList)
					{
						
						$parent_category_list[$key]['subCat'][$subKey]['id'] = $subList['id'];
						$parent_category_list[$key]['subCat'][$subKey]['title'] = $subList['title'];
						$parent_category_list[$key]['subCat'][$subKey]['slug'] = $subList['slug'];
						$parent_category_list[$key]['subCat'][$subKey]['menu_status'] = $list['menu_status'];
						$parent_category_list[$key]['subCat'][$subKey]['status'] = $list['status'];
						$j++;
						$sub_cat_id = $subList['id'];
						$subSubCategoryList = $this->db->order_by('order_number','asc')->get_where('category',array('parent_id'=>$sub_cat_id,'status'=>1,'is_cranes_choice'=>0))->result_array();
						if($subSubCategoryList)
						{
							foreach($subSubCategoryList as $subSubKey=>$subSubList)
							{
								$parent_category_list[$key]['subCat'][$subKey]['subCat'][$subSubKey]['id'] = $subSubList['id'];
								$parent_category_list[$key]['subCat'][$subKey]['subCat'][$subSubKey]['title'] = $subSubList['title'];
								$parent_category_list[$key]['subCat'][$subKey]['subCat'][$subSubKey]['slug'] = $subSubList['slug'];
								$parent_category_list[$key]['subCat'][$subKey]['subCat'][$subSubKey]['menu_status'] = $list['menu_status'];
								$parent_category_list[$key]['subCat'][$subKey]['subCat'][$subSubKey]['status'] = $list['status'];
								$j++;
								$sub_sub_cat_id = $subSubList['id'];
								$subSubSubCategoryList = $this->db->order_by('order_number','asc')->get_where('category',array('parent_id'=>$sub_sub_cat_id,'status'=>1,'is_cranes_choice'=>0))->result_array();
								if($subSubSubCategoryList)
								{
									foreach($subSubSubCategoryList as $subSubSubKey=>$subSubSubList)
									{
										$sub_sub_sub_cat_id = $subSubSubList['id'];
										$parent_category_list[$key]['subCat'][$subKey]['subCat'][$subSubKey]['subCat'][$subSubSubKey]['id'] = $subSubSubList['id'];
										$parent_category_list[$key]['subCat'][$subKey]['subCat'][$subSubKey]['subCat'][$subSubSubKey]['title'] = $subSubSubList['title'];
										$parent_category_list[$key]['subCat'][$subKey]['subCat'][$subSubKey]['subCat'][$subSubSubKey]['slug'] = $subSubSubList['slug'];
										$parent_category_list[$key]['subCat'][$subKey]['subCat'][$subSubKey]['subCat'][$subSubSubKey]['menu_status'] = $list['menu_status'];
										$parent_category_list[$key]['subCat'][$subKey]['subCat'][$subSubKey]['subCat'][$subSubSubKey]['status'] = $list['status'];
										$j++;
									}
								}
							}
						}
					}
				}
			}
		}
		
		return $parent_category_list;
		
	}
	
	public function resize_pro_image($file_name = '')
	{
		if($file_name)
		{
			$this->load->library('image_lib');
	
			$config['image_library'] = 'gd2';
			$config['source_image'] = PRODUCT_IMAGE_FILE_PATH.$file_name;
			$config['new_image'] = PRODUCT_IMAGE_FILE_PATH.'thumbnail-70x70';
			$config['create_thumb'] = FALSE;
			$config['maintain_ratio'] = TRUE;
			$config['width']         = 70;
			$config['height']       = 70;
			$this->image_lib->initialize($config);
			$this->image_lib->resize();
			
			$config['image_library'] = 'gd2';
			$config['source_image'] = PRODUCT_IMAGE_FILE_PATH.$file_name;
			$config['new_image'] = PRODUCT_IMAGE_FILE_PATH.'thumbnail-180x180';
			$config['create_thumb'] = FALSE;
			$config['maintain_ratio'] = TRUE;
			$config['width']         = 180;
			$config['height']       = 180;
			$this->image_lib->initialize($config);
			$this->image_lib->resize();
			
			$config['image_library'] = 'gd2';
			$config['source_image'] = PRODUCT_IMAGE_FILE_PATH.$file_name;
			$config['new_image'] = PRODUCT_IMAGE_FILE_PATH.'thumbnail-400x400';
			$config['create_thumb'] = FALSE;
			$config['maintain_ratio'] = TRUE;
			$config['width']         = 400;
			$config['height']       = 400;
			$this->image_lib->initialize($config);
			$this->image_lib->resize();
		}
		return true;
	}
	
	public function get_cart_temp_data()
	{
		$today_date = date('Y-m-d');
		$loggedUser = $this->session->userdata('cranesmart_member_session');
		$account_id = isset($loggedUser['id']) ? $loggedUser['id'] : 0;
		if(!$account_id)
		{
			$loggedUser = $this->session->userdata('cranesmart_vendor_session');
			$account_id = isset($loggedUser['id']) ? $loggedUser['id'] : 0;
		}
		$user_ip_address = $_SERVER['REMOTE_ADDR'];
		if($account_id){
			$productList = $this->db->query("SELECT b.*,a.qty,a.id as temp_id,a.is_variation,a.variation_pro_id FROM tbl_cart_temp_data as a INNER JOIN tbl_products as b on b.id = a.product_id where a.user_id = '$account_id' AND b.status = 1 AND b.approve_status = 2")->result_array();
		}
		else
		{
			$productList = $this->db->query("SELECT b.*,a.qty,a.id as temp_id,a.is_variation,a.variation_pro_id FROM tbl_cart_temp_data as a INNER JOIN tbl_products as b on b.id = a.product_id where (a.user_id = '$account_id' or a.ip = '$user_ip_address') AND b.status = 1 AND b.approve_status = 2")->result_array();
		}
		
		if($productList)
		{
			foreach($productList as $key=>$list)
			{
				
				// get product image
				$get_product_img = $this->db->select('image_path,file_name')->get_where('product_images',array('product_id'=>$list['id'],'is_base'=>1))->row_array();
				$product_img = isset($get_product_img['file_name']) ? 'media/product_images/thumbnail-70x70/'.$get_product_img['file_name'] : 'skin/front/images/product-default-img.png' ;
				
				$productList[$key]['product_img'] = $product_img;
				
				if($list['special_price'] && $list['special_price_to'] >= $today_date)
				{
					$productList[$key]['price'] = $list['special_price'];
				}
				
				$productList[$key]['qty'] = $list['qty'];	
				$productList[$key]['temp_id'] = $list['temp_id'];	
			}
		}
		
		return $productList;
		
	}
	
	public function get_cart_qty_temp_data()
	{
		$today_date = date('Y-m-d');
		$loggedUser = $this->session->userdata('cranesmart_member_session');
		$account_id = isset($loggedUser['id']) ? $loggedUser['id'] : 0;
		if(!$account_id)
		{
			$loggedUser = $this->session->userdata('cranesmart_vendor_session');
			$account_id = isset($loggedUser['id']) ? $loggedUser['id'] : 0;
		}
		$user_ip_address = $_SERVER['REMOTE_ADDR'];
		if($account_id){
			$productList = $this->db->query("SELECT sum(a.qty) as total_qty FROM tbl_cart_temp_data as a where a.user_id = '$account_id'")->row_array();
		}
		else
		{
			$productList = $this->db->query("SELECT sum(a.qty) as total_qty FROM tbl_cart_temp_data as a where (a.user_id = '$account_id' or a.ip = '$user_ip_address')")->row_array();
		}
		return isset($productList['total_qty']) ? $productList['total_qty'] : 0 ;
		
	}
	
	public function get_logged_user_account_id()
	{
		$loggedUser = $this->session->userdata('cranesmart_member_session');
		$account_id = isset($loggedUser['id']) ? $loggedUser['id'] : 0;
		if(!$account_id)
		{
			$loggedUser = $this->session->userdata('cranesmart_vendor_session');
			$account_id = isset($loggedUser['id']) ? $loggedUser['id'] : 0;
		}
		return $account_id;
	}
	
	public function get_last_order_display_id()
	{
		// get last order display id
		$get_order_number = $this->db->select('order_number')->order_by('order_number','desc')->get('orders')->row_array();
		$order_number = isset($get_order_number['order_number']) ? $get_order_number['order_number'] + 1 : 1;
		
		$order_display_id = 'CRNO';
		if(strlen($order_number) == 1)
		{
			$order_display_id.='0000'.$order_number;
		}
		elseif(strlen($order_number) == 2)
		{
			$order_display_id.='000'.$order_number;
		}
		elseif(strlen($order_number) == 3)
		{
			$order_display_id.='00'.$order_number;
		}
		elseif(strlen($order_number) == 4)
		{
			$order_display_id.='0'.$order_number;
		}
		else
		{
			$order_display_id.=$order_number;
		}
		
		return array('order_display_id'=>$order_display_id,'order_number'=>$order_number);
		
	}
	
	public function get_last_invoice_display_id()
	{
		// get last order display id
		$get_order_number = $this->db->select('invoice_number')->order_by('invoice_number','desc')->get('order_invoice')->row_array();
		$invoice_number = isset($get_order_number['invoice_number']) ? $get_order_number['invoice_number'] + 1 : 1;
		
		$invoice_display_id = 'CRNI';
		if(strlen($invoice_number) == 1)
		{
			$invoice_display_id.='0000'.$invoice_number;
		}
		elseif(strlen($invoice_number) == 2)
		{
			$invoice_display_id.='000'.$invoice_number;
		}
		elseif(strlen($invoice_number) == 3)
		{
			$invoice_display_id.='00'.$invoice_number;
		}
		elseif(strlen($invoice_number) == 4)
		{
			$invoice_display_id.='0'.$invoice_number;
		}
		else
		{
			$invoice_display_id.=$invoice_number;
		}
		
		return array('invoice_display_id'=>$invoice_display_id,'invoice_number'=>$invoice_number);
		
	}
	
	public function get_category_sub_category_list($slug)
	{
		// check slug is valid or not
		$response = array();
		$chk_category = $this->db->get_where('category',array('slug'=>$slug,'status'=>1))->num_rows();
		if($chk_category)
		{
			$get_category_id = $this->db->get_where('category',array('slug'=>$slug,'status'=>1))->row_array();
			$i = 0;
			$response[$i] = $get_category_id['id'];
			// get sub category id
			$sub_category_list = $this->db->get_where('category',array('parent_id'=>$get_category_id['id'],'status'=>1))->result_array();
			if($sub_category_list)
			{
				foreach($sub_category_list as $list)
				{
					$i++;
					$response[$i] = $list['id'];
				}
			}
		}
		return $response;
	}
	
	
    public function get_customer_order_data($account_id = 0, $status = 0)
	{
		$orderList = array();
		if($status == 0){
			// get order list
			$orderList = $this->db->select('orders.*,user_address.name as add_name,user_address.phone_number,user_address.address_1,user_address.address_2,user_address.city,countries.name as country_name,order_status.title as status_title')->order_by('orders.created','desc')->join('user_address','user_address.id = orders.address_id')->join('countries','countries.id = user_address.country')->join('order_status','order_status.id = orders.status')->get_where('orders',array('orders.customer_id'=>$account_id))->result_array();
		}
		else{
			// get order list
			$orderList = $this->db->select('orders.*,user_address.name as add_name,user_address.phone_number,user_address.address_1,user_address.address_2,user_address.city,countries.name as country_name,order_status.title as status_title')->order_by('orders.created','desc')->join('user_address','user_address.id = orders.address_id')->join('countries','countries.id = user_address.country')->join('order_status','order_status.id = orders.status')->get_where('orders',array('orders.customer_id'=>$account_id,'orders.status'=>$status))->result_array();
		}
		
		if($orderList)
		{
			foreach($orderList as $key=>$list)
			{
				$order_id = $list['id'];
				$productList = $this->db->select('products.id,products.product_name,products.slug,order_item_summary.product_qty,order_item_summary.product_price,order_item_summary.product_total_price,order_item_summary.gross_amount')->join('products','products.id = order_item_summary.product_id')->get_where('order_item_summary',array('order_item_summary.order_id'=>$order_id,'order_item_summary.customer_id'=>$account_id))->result_array();
				
				if($productList)
				{
					foreach($productList as $prokey=>$prolist)
					{
						// get product image
						$get_product_img = $this->db->select('image_path')->get_where('product_images',array('product_id'=>$prolist['id'],'is_base'=>1))->row_array();
						$product_img = isset($get_product_img['image_path']) ? $get_product_img['image_path'] : 'skin/front/images/product-default-img.png' ;
						
						$productList[$prokey]['product_img'] = $product_img;
						
						
					}
				}
				
				$orderList[$key]['productInfo'] = $productList;
			}
		}
		
		return $orderList;
	}
	
	public function get_customer_current_order_data($account_id = 0,$encoded_order_id = '')
	{
		// get order list
		$orderList = $this->db->select('orders.*,user_address.name as add_name,user_address.phone_number,user_address.address_1,user_address.address_2,user_address.city,countries.name as country_name,order_status.title as status_title')->order_by('orders.created','desc')->join('user_address','user_address.id = orders.address_id')->join('countries','countries.id = user_address.country')->join('order_status','order_status.id = orders.status')->get_where('orders',array('orders.customer_id'=>$account_id,'orders.encoded_order_id'=>$encoded_order_id))->result_array();
		
		if($orderList)
		{
			foreach($orderList as $key=>$list)
			{
				$order_id = $list['id'];
				$productList = $this->db->select('products.id,products.product_name,products.slug,order_item_summary.product_qty,order_item_summary.product_price,order_item_summary.product_total_price,order_item_summary.gross_amount')->join('products','products.id = order_item_summary.product_id')->get_where('order_item_summary',array('order_item_summary.order_id'=>$order_id,'order_item_summary.customer_id'=>$account_id))->result_array();
				
				if($productList)
				{
					foreach($productList as $prokey=>$prolist)
					{
						// get product image
						$get_product_img = $this->db->select('image_path')->get_where('product_images',array('product_id'=>$prolist['id'],'is_base'=>1))->row_array();
						$product_img = isset($get_product_img['image_path']) ? $get_product_img['image_path'] : 'skin/front/images/product-default-img.png' ;
						
						$productList[$prokey]['product_img'] = $product_img;
						
						
					}
				}
				
				$orderList[$key]['productInfo'] = $productList;
			}
		}
		
		return $orderList;
	}
	


	public function get_seller_feedback_btn_status($encoded_order_id = '', $product_id = 0, $type = 1)
	{
		// get order id
		$get_order_id = $this->db->get_where('orders',array('encoded_order_id'=>$encoded_order_id))->row_array();
		$order_id = isset($get_order_id['id']) ? $get_order_id['id'] : 0 ;
		
		$account_id = $this->User->get_logged_user_account_id();
		
		// check seller feedback for account
		return $this->db->get_where('product_review',array('type'=>$type,'customer_id'=>$account_id,'order_id'=>$order_id,'product_id'=>$product_id))->num_rows();
		
	}
	
	public function sendEmail($to,$message,$subject,$lang = '')
	{
		
		$from = 'info@cranesmart.in';
		
		$this->lang->load('email', 'english');
		// send success email to student
		$siteName = 'Cranesmart';
		$emailTimeStamp = date('d-m-Y h:i:s');
		$emailTemplate = sprintf((string) lang($lang), site_url(), $siteName,$message,$emailTimeStamp);

		$configEmail = array(
		'mailtype' => 'html',
		);

		//send email to user
		$this->load->library('email');
		$this->email->initialize($configEmail);
		$this->email->from($from, $siteName);
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($emailTemplate);
		$this->email->send();
	}
	
	public function recharge_cm_points_add($member_id,$amount,$type,$recharge_id = '')
	{
		// get default package cm points
		$get_cm_points = $this->db->get_where('users',array('id'=>$member_id))->row_array();
		$cm_points = isset($get_cm_points['cm_points']) ? $get_cm_points['cm_points'] : 0;
		$wallet_balance = isset($get_cm_points['wallet_balance']) ? $get_cm_points['wallet_balance'] : 0 ;
		$user_code = isset($get_cm_points['user_code']) ? $get_cm_points['user_code'] : 0 ;
		$after_balance = $cm_points + $amount;

		$wallet_data = array(
			'member_id'           => $member_id,    
			'before_balance'      => $cm_points,
			'amount'              => $amount,  
			'after_balance'       => $after_balance,      
			'status'              => 1,
			'type'                => 1,      
			'wallet_type'		  => 2,
			'created'             => date('Y-m-d H:i:s'),      
			'credited_by'         => $member_id,
			'description'         => $type.' Recharge Free CM Points Credited.'
        );
		$this->db->insert('member_wallet',$wallet_data);

        $user_wallet = array(
			'cm_points'=>$after_balance,        
        );    

        $this->db->where('id',$member_id);
        $this->db->update('users',$user_wallet); 
        
        if($type == 'Mobile')
        {
        	log_message('debug', 'Recharge Income Distribute for Member #'.$user_code);
        	// distribute income
        	$income_percentage = 2.5;
        	$recharge_amount = $amount;
        	$income_amount = round((($income_percentage/100)*$recharge_amount),2);

        	log_message('debug', 'Recharge Income Distribute for Member #'.$user_code.' - Recharge Amount - '.$recharge_amount.' Income percentage ('.$income_percentage.'%) - Income Amount - '.$income_amount);

        	$rechargeData = array(
        		'paid_to_member_id' => $member_id,
        		'paid_from_member_id' => 1,
        		'recharge_id' => $recharge_id,
        		'recharge_amount' => $recharge_amount,
        		'income_percentage' => $income_percentage,
        		'income_amount' => $income_amount,
        		'is_paid' => 1,
        		'created' => date('Y-m-d H:i:s')
        	);
        	$this->db->insert('recharge_income',$rechargeData);

        	$after_balance = $wallet_balance + $income_amount;

        	$walletData = array(
				'member_id' => $member_id,
				'type' => 1,
				'before_balance' => $wallet_balance,
				'amount' => $income_amount,
				'after_balance' => $after_balance,
				'is_income' => 1,
				'income_type' => 2,
				'description' => 'Recharge #'.$recharge_id.' Income Settlement',
				'created' => date('Y-m-d H:i:s')
			);
			$this->db->insert('member_wallet',$walletData);
			
			// update member current wallet balance
			$this->db->where('id',$member_id);
			$this->db->update('users',array('wallet_balance'=>$after_balance));

			$level_member_id = $member_id;
			// distribute recharge level income
			for($level = 1; $level<=4; $level++)
			{
				$level_member_id = $this->generate_recharge_income($level,$level_member_id,$user_code,$recharge_amount,$member_id,$recharge_id);
			}
        }
        
        
        return true;
	}
	
	public function generate_recharge_income($level_num = 0, $member_id = 0, $master_member_code = '',$recharge_amount = 0,$from_member_id = 0,$recharge_id = '')
	{
		if($level_num && $member_id)
		{
			// get member first level member
			$get_first_level_member = $this->db->select('member_tree.*,users.user_code,users.is_active,users.income_status,users.wallet_balance')->join('users','users.id = member_tree.reffrel_id')->get_where('member_tree',array('member_tree.member_id'=>$member_id))->row_array();
			$first_level_member_id = isset($get_first_level_member['reffrel_id']) ? $get_first_level_member['reffrel_id'] : 0;
			$first_level_member_code = isset($get_first_level_member['user_code']) ? $get_first_level_member['user_code'] : '';
			$first_level_member_active = isset($get_first_level_member['is_active']) ? $get_first_level_member['is_active'] : 0;
			$first_level_member_income_status = isset($get_first_level_member['income_status']) ? $get_first_level_member['income_status'] : 0;
			$first_level_wallet_balance = isset($get_first_level_member['wallet_balance']) ? $get_first_level_member['wallet_balance'] : 0;
			if($first_level_member_id)
			{
				if($level_num == 1)
				{
					log_message('debug', 'Recharge Income Distribute for Member #'.$master_member_code.' First Level Member #'.$first_level_member_code);
				}
				elseif($level_num == 2)
				{
					log_message('debug', 'Recharge Income Distribute for Member #'.$master_member_code.' Second Level Member #'.$first_level_member_code);
				}
				elseif($level_num == 3)
				{
					log_message('debug', 'Recharge Income Distribute for Member #'.$master_member_code.' Third Level Member #'.$first_level_member_code);
				}
				elseif($level_num == 4)
				{
					log_message('debug', 'Recharge Income Distribute for Member #'.$master_member_code.' Fourth Level Member #'.$first_level_member_code);
				}
				if($first_level_member_active && $first_level_member_income_status)
				{
					log_message('debug', 'Recharge Income Distribute for Member #'.$master_member_code.' Level Member #'.$first_level_member_code.' is active and is upgraded.');
					// distribute income
					if($level_num == 1 || $level_num == 4)
					{
		        		$income_percentage = 0.20;
		        	}
		        	else
		        	{
		        		$income_percentage = 0.10;
		        	}
		        	
		        	$income_amount = round((($income_percentage/100)*$recharge_amount),2);

		        	log_message('debug', 'Recharge Income Distribute for Member #'.$master_member_code.' Level Member #'.$first_level_member_code.' - Recharge Amount - '.$recharge_amount.' Income percentage ('.$income_percentage.'%) - Income Amount - '.$income_amount);

		        	$rechargeData = array(
		        		'paid_to_member_id' => $first_level_member_id,
		        		'paid_from_member_id' => $from_member_id,
		        		'level_num' => $level_num,
		        		'recharge_id' => $recharge_id,
		        		'recharge_amount' => $recharge_amount,
		        		'income_percentage' => $income_percentage,
		        		'income_amount' => $income_amount,
		        		'is_paid' => 1,
		        		'created' => date('Y-m-d H:i:s')
		        	);
		        	$this->db->insert('recharge_income',$rechargeData);

		        	$after_balance = $first_level_wallet_balance + $income_amount;

		        	$walletData = array(
						'member_id' => $first_level_member_id,
						'type' => 1,
						'before_balance' => $first_level_wallet_balance,
						'amount' => $income_amount,
						'after_balance' => $after_balance,
						'is_income' => 1,
						'income_type' => 2,
						'description' => 'Recharge #'.$recharge_id.' Level Income Settlement',
						'created' => date('Y-m-d H:i:s')
					);
					$this->db->insert('member_wallet',$walletData);
					
					// update member current wallet balance
					$this->db->where('id',$first_level_member_id);
					$this->db->update('users',array('wallet_balance'=>$after_balance));
				}
				else
				{
					log_message('debug', 'Recharge Income Distribute for Member #'.$master_member_code.' Level Member #'.$first_level_member_code.' not active or not upgraded.');
					// distribute income
					if($level_num == 1 || $level_num == 4)
					{
		        		$income_percentage = 0.20;
		        	}
		        	else
		        	{
		        		$income_percentage = 0.10;
		        	}
		        	
		        	$income_amount = round((($income_percentage/100)*$recharge_amount),2);

		        	log_message('debug', 'Recharge Income Distribute for Member #'.$master_member_code.' Level Member #'.$first_level_member_code.' - Recharge Amount - '.$recharge_amount.' Income percentage ('.$income_percentage.'%) - Income Amount - '.$income_amount);

		        	$rechargeData = array(
		        		'paid_to_member_id' => $first_level_member_id,
		        		'paid_from_member_id' => $from_member_id,
		        		'level_num' => $level_num,
		        		'recharge_id' => $recharge_id,
		        		'recharge_amount' => $recharge_amount,
		        		'income_percentage' => $income_percentage,
		        		'income_amount' => $income_amount,
		        		'is_paid' => 0,
		        		'created' => date('Y-m-d H:i:s')
		        	);
		        	$this->db->insert('recharge_income',$rechargeData);
				}
			}
		}
		return $first_level_member_id;
	}
	
	public function get_user_dmr_customer_id()
	{
		$loggedUser = $this->session->userdata('cranesmart_member_session');
        $account_id = $loggedUser['id'];
		// get wallet balance
		$get_wallet_balance = $this->db->select('dmr_customer_id')->get_where('users',array('id'=>$account_id))->row_array();
		return isset($get_wallet_balance['dmr_customer_id']) ? ($get_wallet_balance['dmr_customer_id']) ? $get_wallet_balance['dmr_customer_id'] : '' : '' ;
	}
	
	public function get_user_kyc_status()
	{
		$loggedUser = $this->session->userdata('cranesmart_member_session');
        $account_id = $loggedUser['id'];
		// get wallet balance
		$get_wallet_balance = $this->db->select('kyc_status')->get_where('users',array('id'=>$account_id))->row_array();
		return isset($get_wallet_balance['kyc_status']) ? $get_wallet_balance['kyc_status'] : 0;
	}
	
	public function generate_unique_otp()
	{
		$otp_code = rand(1111,9999);
		$chk_otp = $this->db->get_where('users_otp',array('otp_code'=>$otp_code))->num_rows();
		if($chk_otp)
		{
			$otp_code = $this->generate_new_unique_otp();
		}
		return $otp_code;
	}
	
	public function generate_new_unique_otp()
	{
		$otp_code = rand(1111,9999);
		$chk_otp = $this->db->get_where('users_otp',array('otp_code'=>$otp_code))->num_rows();
		if($chk_otp)
		{
			$otp_code = $this->generate_new_unique_otp();
		}
		return $otp_code;
	}

}


/* end of file: user.php */
/* Location: ./application/models/admin/user.php */