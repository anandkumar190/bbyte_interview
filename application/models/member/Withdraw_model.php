<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * Model used for setup default message and resize image
 * 
 * This one used for defined some methods accross all site.
 * this one used for show system message, errors.
 * this one used for image resizing
 * @author trilok
 */

require_once BASEPATH . '/core/Model.php';

class Withdraw_model extends CI_Model {

    public function __construct() {
        parent::__construct();
		$this->lang->load('front_common' , 'english');
        $this->lang->load('email', 'english');
        $this->lang->load('front/message', 'english');
    }

    public function save_kyc_data($post,$front_document_path,$back_document_path,$pancard_document_path,$account_id = 0,$pending_status)
    {       
        if($pending_status)
		{
			$data = array(    
				'account_holder_name'               =>  $post['account_name'],
				'account_number'               =>  $post['account_number'],
				'ifsc'               =>  $post['ifsc'],
				'bank_name'               =>  $post['bank_name'],
				'updated'            =>  date('Y-m-d H:i:s')
			);
			if($front_document_path)
			{
				$data['front_document'] = $front_document_path;
			}
			if($back_document_path)
			{
				$data['back_document'] = $back_document_path;
			}
			if($pancard_document_path)
			{
				$data['pancard_document'] = $pancard_document_path;
			}
			
			$this->db->where('member_id',$account_id);
			$this->db->where('status',2);
			$this->db->update('member_kyc_detail',$data);
		}	
		else
		{
			$data = array(    
				'member_id'            =>  $account_id,      
				'account_holder_name'               =>  $post['account_name'],
				'account_number'               =>  $post['account_number'],
				'ifsc'               =>  $post['ifsc'],
				'bank_name'               =>  $post['bank_name'],
				'front_document'           =>  $front_document_path,
				'back_document'           =>  $back_document_path,
				'pancard_document'           =>  $pancard_document_path,
				'status'           =>  2,
				'created'            =>  date('Y-m-d H:i:s')
			);

			$this->db->insert('member_kyc_detail',$data);
			
			$this->db->where('id',$account_id);
			$this->db->update('users',array('kyc_status'=>2));
		}
		
		// get account detail
		$get_user_data = $this->db->select('mobile')->get_where('users',array('id'=>$account_id))->row_array();
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
		
		return true;
    }
	
	public function generateFundRequest($post)
	{
		// get binary income percentage
		$get_direct_percentage = $this->db->get_where('master_setting',array('id'=>1))->row_array();
		$service_tax_percentage = isset($get_direct_percentage['service_tax']) ? $get_direct_percentage['service_tax'] : 0 ;
		
		$loggedUser = $this->User->getLoggedUser('cranesmart_member_session');
		$account_id = $loggedUser['id'];
		
		$amount = $post['amount'];
		
		// generate request id
		$request_id = time().rand(111,333);
		
		//get member wallet_balance
		$get_member_status = $this->db->select('wallet_balance')->get_where('users',array('id'=>$account_id))->row_array();
		$before_wallet_balance = isset($get_member_status['wallet_balance']) ? $get_member_status['wallet_balance'] : 0 ;
		
		$service_amount = round((($service_tax_percentage/100)*$amount),2);
		
		$transfer_amount = $amount - $service_amount;
		
		$after_wallet_balance = $before_wallet_balance - $amount;
		
		$tokenData = array(
			'request_id' => $request_id,
			'member_id' => $account_id,
			'request_amount' => $amount,
			'before_wallet_balance' => $before_wallet_balance,
			'service_amount' => $service_amount,
			'transfer_amount' => $transfer_amount,
			'after_wallet_balance' => $after_wallet_balance,
			'status' => 1,
			'created' => date('Y-m-d H:i:s'),
		);
		$this->db->insert('member_fund_request',$tokenData);
		
		// update member wallet
		$after_balance = $before_wallet_balance - $amount;
		$wallet_data = array(
			'member_id'           => $account_id,    
			'before_balance'      => $before_wallet_balance,
			'amount'              => $amount,  
			'after_balance'       => $after_balance,      
			'status'              => 1,
			'type'                => 2,      
			'wallet_type'		  => 1,
			'created'             => date('Y-m-d H:i:s'),      
			'credited_by'         => $account_id,
			'description'         => 'Fund Request #'.$request_id.' Wallet Deducation' 
		);

		$this->db->insert('member_wallet',$wallet_data);
		
		// update member current wallet balance
		$this->db->where('id',$account_id);
		$this->db->update('users',array('wallet_balance'=>$after_balance));
		
		
		return true;
	}
	
	public function walletTransferAuth($wallet_balance,$transfer_amount,$member_id)
	{
		$loggedUser = $this->User->getLoggedUser('codunitemlm_member');
		$account_id = $loggedUser['id'];
		
		// get member user code
		$get_member_code = $this->db->select('user_code')->get_where('users',array('id'=>$member_id))->row_array();
		$member_code = isset($get_member_code['user_code']) ? $get_member_code['user_code'] : '' ;
		
		$after_balance = $wallet_balance - $transfer_amount;
		$walletData = array(
			'member_id' => $account_id,
			'type' => 2,
			'before_balance' => $wallet_balance,
			'affect_amount' => $transfer_amount,
			'after_balance' => $after_balance,
			'to_member_id' => $member_id,
			'description' => 'Transfer Amount to Member #'.$member_code,
			'created' => date('Y-m-d H:i:s')
		);
		$this->db->insert('member_wallet',$walletData);
		
		// update member current wallet balance
		$this->db->where('id',$account_id);
		$this->db->update('users',array('wallet_balance'=>$after_balance,'updated' => date('Y-m-d H:i:s')));
		
		
		// get member user code
		$get_member_code = $this->db->select('user_code')->get_where('users',array('id'=>$account_id))->row_array();
		$account_member_code = isset($get_member_code['user_code']) ? $get_member_code['user_code'] : '' ;
		
		// get account topup wallet balance
		$member_account_detail = $this->db->select('topup_wallet_balance')->get_where('users',array('id'=>$member_id))->row_array();
		$member_topup_wallet_balance = isset($member_account_detail['topup_wallet_balance']) ? $member_account_detail['topup_wallet_balance'] : 0 ;
		
		$after_balance = $member_topup_wallet_balance + $transfer_amount;
		$walletData = array(
			'member_id' => $member_id,
			'type' => 1,
			'before_balance' => $member_topup_wallet_balance,
			'affect_amount' => $transfer_amount,
			'after_balance' => $after_balance,
			'from_member_id' => $account_id,
			'description' => 'Receive Amount from Member #'.$account_member_code,
			'created' => date('Y-m-d H:i:s'),
			'created_by' => $account_id
		);
		$this->db->insert('member_topup_wallet',$walletData);
		
		// update member current wallet balance
		$this->db->where('id',$member_id);
		$this->db->update('users',array('topup_wallet_balance'=>$after_balance,'updated' => date('Y-m-d H:i:s')));
		
		
		
		return true;
	}
	
	public function save_withdrawal_active_request($post,$account_id)
	{
		$response = array();
		$api_url = DMR_API_URL.'DMRREGISTRATIONCHECK.aspx?memberid='.DMR_MEMBERID.'&pin='.DMR_API_PIN.'&Moblie='.$post['mobile'];
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $api_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);		
		$output = curl_exec($ch); 
		curl_close($ch);

		log_message('debug', 'Withdrawal Active Registration Check API Response - '.$output);

		$responseData = json_decode($output);

		// save api response
		$apiData = array(
			'user_id' => $account_id,
			'mobile' => $post['mobile'],
			'api_response' => $output,
			'api_url' => $api_url,
			'status' => 1,
			'is_dmr' => 1,
			'created' => date('Y-m-d H:i:s')
		);
		$this->db->insert('api_response',$apiData);

		if($responseData->statuscode != 'Success')
		{
			$api_url = DMR_API_URL.'DMRREGISTRATION.aspx?memberid='.DMR_MEMBERID.'&pin='.DMR_API_PIN.'&FirstName='.$post['first_name'].'&LastName='.$post['last_name'].'&emailid='.$post['email'].'&pincode='.$post['zipcode'].'&Moblie='.$post['mobile'];
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $api_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);		
			$output = curl_exec($ch); 
			curl_close($ch);

			log_message('debug', 'Withdrawal Active Registration API Response - '.$output);
			// save api response
			$apiData = array(
				'user_id' => $account_id,
				'mobile' => $post['mobile'],
				'api_response' => $output,
				'api_url' => $api_url,
				'status' => 1,
				'is_dmr' => 1,
				'created' => date('Y-m-d H:i:s')
			);
			$this->db->insert('api_response',$apiData);

			$responseData = json_decode($output);
			if($responseData->statuscode == 'Success')
			{
				$api_customer_id = $responseData->data->id;
				$data = array(
					'user_id' => $account_id,
					'first_name' => $post['first_name'],
					'last_name' => $post['last_name'],
					'email' => $post['email'],
					'mobile' => $post['mobile'],
					'zip_code' => $post['zipcode'],
					'api_response' => $output,
					'api_customer_id' => $api_customer_id,
					'status' => 1,
					'created' => date('Y-m-d H:i:s')
				);
				$this->db->insert('user_withdrawal_request',$data);

				// update DMR ID and Zip Code
				$this->db->where('id',$account_id);
				$this->db->update('users',array('zip_code'=>$post['zipcode'],'dmr_customer_id'=>$api_customer_id));
				$response = array(
					'status' => 1,
					'msg' => 'Success'
				);
			}
			else
			{
				$response = array(
					'status' => 0,
					'msg' => $responseData->status
				);
			}
		}
		elseif($responseData->statuscode == 'Success')
		{
			$api_customer_id = $responseData->data->id;
			$data = array(
				'user_id' => $account_id,
				'first_name' => $post['first_name'],
				'last_name' => $post['last_name'],
				'email' => $post['email'],
				'mobile' => $post['mobile'],
				'zip_code' => $post['zipcode'],
				'api_response' => $output,
				'api_customer_id' => $api_customer_id,
				'status' => 1,
				'created' => date('Y-m-d H:i:s')
			);
			$this->db->insert('user_withdrawal_request',$data);

			// update DMR ID and Zip Code
			$this->db->where('id',$account_id);
			$this->db->update('users',array('zip_code'=>$post['zipcode'],'dmr_customer_id'=>$api_customer_id));
			$response = array(
				'status' => 1,
				'msg' => 'Success'
			);
		}
		else
		{
			$response = array(
				'status' => 0,
				'msg' => $responseData->status
			);
		}

		return $response;

		
	}


	public function save_benificary($post,$account_id)
	{
		$memberDetail = $this->db->select('mobile,dmr_customer_id')->get_where('users',array('id'=>$account_id))->row_array();

		$response = array();
		$api_url = DMR_API_URL.'DMRBENIFICARY.aspx?MemberId='.DMR_MEMBERID.'&AccountholderName='.urlencode($post['account_holder_name']).'&BankName='.urlencode($post['bank_name']).'&Accountnumber='.urlencode($post['account_number']).'&AccountIfsc='.urlencode($post['ifsc']).'&CustomerMobile='.$memberDetail['mobile'].'&CustomerID='.$memberDetail['dmr_customer_id'];

		log_message('debug', 'Benificary Add API URL - '.$api_url);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $api_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);		
		$output = curl_exec($ch); 
		curl_close($ch);

		log_message('debug', 'Benificary Add API Response - '.$output);

		$responseData = json_decode($output);

		// save api response
		$apiData = array(
			'user_id' => $account_id,
			'mobile' => $memberDetail['mobile'],
			'api_response' => $output,
			'api_url' => $api_url,
			'status' => 1,
			'is_dmr' => 1,
			'created' => date('Y-m-d H:i:s')
		);
		$this->db->insert('api_response',$apiData);

		if($responseData->statuscode == 'Success')
		{
			
				$api_ban_id = $responseData->data->BenID;
				$data = array(
					'user_id' => $account_id,
					'account_holder_name' => $post['account_holder_name'],
					'bank_name' => $post['bank_name'],
					'account_no' => $post['account_number'],
					'ifsc' => $post['ifsc'],
					'api_response' => $output,
					'api_ban_id' => $api_ban_id,
					'encode_ban_id' => do_hash(time().$api_ban_id),
					'status' => 2,
					'created' => date('Y-m-d H:i:s')
				);
				$this->db->insert('user_benificary',$data);
				$response = array(
					'status' => 1,
					'msg' => 'Success'
				);
			
		}
		else
		{
			$data = array(
				'user_id' => $account_id,
				'account_holder_name' => $post['account_holder_name'],
				'bank_name' => $post['bank_name'],
				'account_no' => $post['account_number'],
				'ifsc' => $post['ifsc'],
				'api_response' => $output,
				'encode_ban_id' => '',
				'status' => 3,
				'created' => date('Y-m-d H:i:s')
			);
			$this->db->insert('user_benificary',$data);
			$response = array(
				'status' => 0,
				'msg' => $responseData->status
			);
		}

		return $response;

		
	}


	public function save_fund_transfer_request($post,$account_id)
	{
		$accountDetail = $this->db->select('wallet_balance,mobile')->get_where('users',array('id'=>$account_id))->row_array();
		$wallet_balance = $accountDetail['wallet_balance'];
		$mobile = $accountDetail['mobile'];

		$response = array();

		// get benificary id
		$get_benificary_id = $this->db->get_where('user_benificary',array('user_id'=>$account_id,'encode_ban_id'=>$post['transfer_to'],'status'=>2))->row_array();
		$to_ben_id = isset($get_benificary_id['id']) ? $get_benificary_id['id'] : 0 ;
		
		

		$transaction_id = time().rand(1111,9999);

		$encode_transaction_id = do_hash($transaction_id);

		// get fund transfer percentage
		$get_fund_transfer_charge = $this->db->get_where('master_setting',array('id'=>1))->row_array();
		$fund_transfer_charge = isset($get_fund_transfer_charge['fund_transfer_charge']) ? $get_fund_transfer_charge['fund_transfer_charge'] : 0 ;

		$total_wallet_deduct = $post['amount'];
		$charge_amount = 0;
		if($fund_transfer_charge)
		{
			$charge_amount = round(($fund_transfer_charge/100)*$post['amount'],2);
			$total_wallet_deduct = $charge_amount + $post['amount'];
		}

		$after_wallet_balance = $wallet_balance - $total_wallet_deduct;

		$data = array(
			'user_id' => $account_id,
			'to_ben_id' => $to_ben_id,
			'before_wallet_balance' => $wallet_balance,
			'transfer_amount' => $post['amount'],
			'transfer_charge_percentage' => $fund_transfer_charge,
			'transfer_charge_amount' => $charge_amount,
			'total_wallet_charge' => $total_wallet_deduct,
			'after_wallet_balance' => $after_wallet_balance,
			'transaction_id' => $transaction_id,
			'encode_transaction_id' => $encode_transaction_id,
			'status' => 1,
			'created' => date('Y-m-d H:i:s')
		);
		$this->db->insert('user_fund_transfer',$data);

		// send OTP
		$otp_code = rand(111111,999999);
        $encrypt_otp_code = do_hash($otp_code);
        $output = '';
		if($mobile)
		{
		
	        $sms = sprintf(lang('FUND_TRANSFER_OPT_SEND_SMS'),$otp_code);
	        
	        //$api_url = SMS_API_URL.'authkey='.SMS_AUTH_KEY.'&mobiles='.$mobile.'&message='.urlencode($sms).'&sender='.SMS_SENDER_ID.'&route=4&country=0';
	        
	        $api_url = SMS_API_URL.'receiver='.$mobile.'&sms='.urlencode($sms);
	        
	        $ch = curl_init();
	        curl_setopt($ch, CURLOPT_URL, $api_url);
	        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
	        $output = curl_exec($ch); 
	        curl_close($ch);
    	}
        $otp_data = array(
            'otp_code' => $otp_code,
            'encrypt_otp_code' => $encrypt_otp_code,
            'mobile' => $mobile,
            'status' => 0,
            'is_fund_transfer' => 1,
            'encode_transaction_id' => $encode_transaction_id,
            'api_response' => $output,
            'json_post_data' => json_encode($post),
            'created' => date('Y-m-d H:i:s')
        );
        $this->db->insert('users_otp',$otp_data);

        
        // send OTP on Email
        $message = 'Dear User,
        You are trying to transfer fund on Cranes Mart, Your OTP is : '.$otp_code.'
        If you have any issue please contact us.
        Thanks
        Cranesmart Team
        ';
        $subject = 'Cranesmart Fund Transfer OTP';
        $lang = 'OTP_EMAIL';
        $to = strtolower(trim($accountDetail['email']));
        $this->User->sendEmail($to,$message,$subject,$lang);


		$response = array(
			'status' => 1,
			'msg' => 'Success',
			'encode_transaction_id' => $encode_transaction_id
		);
			
		
		return $response;

		
	}

	public function transfer_fund($get_transfer_data,$account_id,$encode_transaction_id)
	{

		$to_ben_id = $get_transfer_data['to_ben_id'];
		$transfer_amount = $get_transfer_data['transfer_amount'];
		$transaction_id = $get_transfer_data['transaction_id'];
		$total_wallet_charge = $get_transfer_data['total_wallet_charge'];
		

		

		// get benificary id 
		$get_benificary_id = $this->db->select('api_ban_id,account_holder_name')->get_where('user_benificary',array('id'=>$to_ben_id,'status'=>2))->row_array();
		$api_ban_id = isset($get_benificary_id['api_ban_id']) ? $get_benificary_id['api_ban_id'] : 0 ;
		$account_holder_name = isset($get_benificary_id['account_holder_name']) ? $get_benificary_id['account_holder_name'] : '' ;

		$memberDetail = $this->db->select('mobile,dmr_customer_id,wallet_balance')->get_where('users',array('id'=>$account_id))->row_array();

		$response = array();
		$api_url = DMR_API_URL.'TransferBenificary.aspx?memberid='.DMR_MEMBERID.'&pin='.DMR_API_PIN.'&CustomerID='.$memberDetail['dmr_customer_id'].'&BID='.$api_ban_id.'&Amount='.$transfer_amount.'&TransID='.$transaction_id.'&Paytype=IMPS';

		log_message('debug', 'Transfer Fund API URL - '.$api_url);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $api_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);		
		$output = curl_exec($ch); 
		curl_close($ch);

		/*$output = '{"statuscode":"Request accepted","status":"pending","data":{"BID":4838,"Msrno":103289,"CustomerMobile":"8104758957","AccountholderName":"Sonu Jangid","BankName":"ICICI","Accountnumber":"023501546776","AccountIfsc":"ICIC0000235","AddDate":"2020-04-28T20:05:39","CustomerID":5646,"Amount":10.0,"ChargeAmount":8.6,"TransID":"7779158792937765","OperatorID":"DE_002","RefRanceID":"Request accepted"}}';*/

		log_message('debug', 'Transfer Fund API Response - '.$output);

		$responseData = json_decode($output);

		// save api response
		$apiData = array(
			'user_id' => $account_id,
			'mobile' => $memberDetail['mobile'],
			'api_response' => $output,
			'api_url' => $api_url,
			'status' => 1,
			'is_dmr' => 1,
			'created' => date('Y-m-d H:i:s')
		);
		$this->db->insert('api_response',$apiData);

		$mobile = $memberDetail['mobile'];

		if(isset($responseData->status) && strtolower($responseData->status) == 'success')
		{
			
			$after_balance = $memberDetail['wallet_balance'] - $total_wallet_charge;    

			$wallet_data = array(
				'member_id'           => $account_id,    
				'before_balance'      => $memberDetail['wallet_balance'],
				'amount'              => $total_wallet_charge,  
				'after_balance'       => $after_balance,      
				'status'              => 1,
				'type'                => 2,      
				'created'             => date('Y-m-d H:i:s'),      
				'description'         => 'Fund Transfer #'.$transaction_id.' Amount Deducted.'
			);

			$this->db->insert('member_wallet',$wallet_data);

			$user_wallet = array(
				'wallet_balance'=>$after_balance,        
			);    
			$this->db->where('id',$account_id);
			$this->db->update('users',$user_wallet);

			log_message('debug', 'Transfer Fund Wallet Deduction Completed.');

			// update fund transfer status
			$fundData = array(
				'api_response' => $output,
				'status' => 3,
				'otp_status' => 1,
				'updated' => date('Y-m-d H:i:s')
			);
			$this->db->where('user_id',$account_id);
			$this->db->where('encode_transaction_id',$encode_transaction_id);
			$this->db->update('user_fund_transfer',$fundData);

			log_message('debug', 'Transfer Fund Succes Status Updated.');

			// send SMS
			if($mobile)
			{
			
		        $sms = sprintf(lang('FUND_TRANSFER_SUCCESS_SMS'),$transaction_id,$account_holder_name);
		        
		        //$api_url = SMS_API_URL.'authkey='.SMS_AUTH_KEY.'&mobiles='.$mobile.'&message='.urlencode($sms).'&sender='.SMS_SENDER_ID.'&route=4&country=0';
		        
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
				'msg' => 'Success'
			);
			
		}
		elseif(isset($responseData->status) && strtolower($responseData->status) == 'pending')
		{
			$after_balance = $memberDetail['wallet_balance'] - $total_wallet_charge;    

			$wallet_data = array(
				'member_id'           => $account_id,    
				'before_balance'      => $memberDetail['wallet_balance'],
				'amount'              => $total_wallet_charge,  
				'after_balance'       => $after_balance,      
				'status'              => 1,
				'type'                => 2,      
				'created'             => date('Y-m-d H:i:s'),      
				'description'         => 'Fund Transfer #'.$transaction_id.' Amount Deducted.'
			);

			$this->db->insert('member_wallet',$wallet_data);

			$user_wallet = array(
				'wallet_balance'=>$after_balance,        
			);    
			$this->db->where('id',$account_id);
			$this->db->update('users',$user_wallet);

			log_message('debug', 'Transfer Fund Wallet Deduction Completed.');

			// update fund transfer status
			$fundData = array(
				'api_response' => $output,
				'status' => 2,
				'otp_status' => 1,
				'updated' => date('Y-m-d H:i:s')
			);
			$this->db->where('user_id',$account_id);
			$this->db->where('encode_transaction_id',$encode_transaction_id);
			$this->db->update('user_fund_transfer',$fundData);

			log_message('debug', 'Transfer Fund Pending Status Updated.');

			// send SMS
			if($mobile)
			{
			
		        $sms = sprintf(lang('FUND_TRANSFER_PENDING_SMS'),$transaction_id);
		        
		        //$api_url = SMS_API_URL.'authkey='.SMS_AUTH_KEY.'&mobiles='.$mobile.'&message='.urlencode($sms).'&sender='.SMS_SENDER_ID.'&route=4&country=0';
		        
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
				'status' => 2,
				'msg' => 'Success'
			);
		}
		else
		{
			// update fund transfer status
			$fundData = array(
				'api_response' => $output,
				'status' => 4,
				'otp_status' => 1,
				'updated' => date('Y-m-d H:i:s')
			);
			$this->db->where('user_id',$account_id);
			$this->db->where('encode_transaction_id',$encode_transaction_id);
			$this->db->update('user_fund_transfer',$fundData);

			log_message('debug', 'Transfer Fund Failed Status Updated.');

			// send SMS
			if($mobile)
			{
			
		        $sms = sprintf(lang('FUND_TRANSFER_FAILED_SMS'),$transaction_id);
		        
		        //$api_url = SMS_API_URL.'authkey='.SMS_AUTH_KEY.'&mobiles='.$mobile.'&message='.urlencode($sms).'&sender='.SMS_SENDER_ID.'&route=4&country=0';
		        
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
				'status' => 0,
				'msg' => 'Success'
			);
		}

		return $response;

		
	}
	
	

}


/* end of file: az.php */
/* Location: ./application/models/az.php */