<?php
if(!defined('BASEPATH'))
    exit('No direct scrip access allowed');

/*
 * login Register controller for Frontend
 * 
 * this controller user for login, register, logout, forgot password, reset password
 * @author trilok
 */

class Cron extends CI_Controller
{

    public function __construct() {
        parent::__construct();
        
        $this->lang->load('front/message', 'english');
        
    }

    public function rechargeCallback()
    {
		log_message('debug', 'Recharge Call Back API Called.');	
        $post = $this->input->get();
		log_message('debug', 'Recharge Call Back API GET Data - '.json_encode($post));	
        if($post)
		{
			$mytxid = $post['mytxid'];
			$txid = $post['txid'];
			$optxid = $post['optxid'];
			$mobileno = $post['mobileno'];
			$api_status = strtolower($post['status']);
			
			// check recharge status
			$recharge_status = $this->db->get_where('recharge_history',array('txid'=>$txid,'status'=>1))->num_rows();
			if($recharge_status)
			{
				$status = 0;
				if($api_status == 'success')
				{
					$status = 2;
				}
				elseif($api_status == 'failed')
				{
					$status = 3;
				}
				elseif($api_status == 'pending')
				{
					$status = 1;
				}
				
				if($txid)
				{
					// update status
					$this->db->where('txid',$txid);
					$this->db->update('recharge_history',array('operator_ref'=>$optxid,'status'=>$status));

					// refund payment into wallet
					if($status == 3)
					{
						// get member id and amount
						$get_recharge_data = $this->db->get_where('recharge_history',array('txid'=>$txid))->row_array();
						$member_id = isset($get_recharge_data['member_id']) ? $get_recharge_data['member_id'] : 0 ;
						$amount = isset($get_recharge_data['amount']) ? $get_recharge_data['amount'] : 0 ;
						$recharge_display_id = isset($get_recharge_data['recharge_display_id']) ? $get_recharge_data['recharge_display_id'] : '' ;
						if($member_id)
						{
							$before_balance = $this->db->get_where('users',array('id'=>$member_id))->row_array();
							$type = 1;
							
							$after_balance = $before_balance['wallet_balance'] + $amount;    
							
							$wallet_data = array(
								'member_id'           => $member_id,    
								'before_balance'      => $before_balance['wallet_balance'],
								'amount'              => $amount,  
								'after_balance'       => $after_balance,      
								'status'              => 1,
								'type'                => $type,      
								'created'             => date('Y-m-d H:i:s'),      
								'credited_by'         => 1,
								'description'         => 'Recharge Refund #'.$recharge_display_id.' Credited'
					        );

					        $this->db->insert('member_wallet',$wallet_data);

					        $user_wallet = array(
								'wallet_balance'=>$after_balance,        
					        );    

					        $this->db->where('id',$member_id);
					        $this->db->update('users',$user_wallet); 
						}
					}
					elseif($status == 2)
					{
						// get member id and amount
						$get_recharge_data = $this->db->select('recharge_history.*,recharge_type.type as type_title')->join('recharge_type','recharge_type.id = recharge_history.recharge_type')->get_where('recharge_history',array('recharge_history.txid'=>$txid))->row_array();
						$member_id = isset($get_recharge_data['member_id']) ? $get_recharge_data['member_id'] : 0 ;
						$amount = isset($get_recharge_data['amount']) ? $get_recharge_data['amount'] : 0 ;
						$recharge_display_id = isset($get_recharge_data['type_title']) ? $get_recharge_data['type_title'] : '' ;
						$recharge_id = isset($get_recharge_data['recharge_display_id']) ? $get_recharge_data['recharge_display_id'] : '' ;
						if($member_id)
						{
							// add 100% CM Points
							$this->User->recharge_cm_points_add($member_id,$amount,$recharge_display_id,$recharge_id);
						}
					}
				}
				
				log_message('debug', 'Recharge Call Back API '.$api_status.' Status Updated.');	
			}
			else
			{
				log_message('debug', 'Recharge Call Back API Recharge #'.$txid.' Status Already Updated.');	
			}
		}
		log_message('debug', 'Recharge Call Back API Stop.');
		echo json_encode(array('status'=>1,'msg'=>'success'));
		
    }
    
    public function dmtCallback()
    {
		log_message('debug', 'DMT Call Back API Called.');	
        $post = $this->input->get();
		log_message('debug', 'DMT Call Back API GET Data - '.json_encode($post));	
        if($post)
		{
			$mytxid = $post['mytxid'];
			$txid = $post['txid'];
			$optxid = $post['optxid'];
			$mobileno = $post['mobileno'];
			$api_status = strtolower($post['status']);
			
			// check recharge status
			$recharge_status = $this->db->get_where('user_fund_transfer',array('transaction_id'=>$txid,'status'=>2))->num_rows();
			if($recharge_status)
			{
				$status = 0;
				if($api_status == 'success')
				{
					$status = 3;
				}
				elseif($api_status == 'failed')
				{
					$status = 4;
				}
				elseif($api_status == 'pending')
				{
					$status = 2;
				}
				
				if($txid)
				{
					// update fund transfer status
					$fundData = array(
						'status' => $status,
						'updated' => date('Y-m-d H:i:s')
					);
					$this->db->where('transaction_id',$txid);
					$this->db->update('user_fund_transfer',$fundData);

					// refund payment into wallet
					if($status == 4)
					{
						// get member id and amount
						$get_recharge_data = $this->db->get_where('user_fund_transfer',array('transaction_id'=>$txid))->row_array();
						$member_id = isset($get_recharge_data['user_id']) ? $get_recharge_data['user_id'] : 0 ;
						$amount = isset($get_recharge_data['transfer_amount']) ? $get_recharge_data['transfer_amount'] : 0 ;
						$total_wallet_charge = isset($get_recharge_data['total_wallet_charge']) ? $get_recharge_data['total_wallet_charge'] : 0 ;
						$transaction_id = isset($get_recharge_data['transaction_id']) ? $get_recharge_data['transaction_id'] : '' ;
						$mobile = '';
						if($member_id)
						{
							$before_balance = $this->db->get_where('users',array('id'=>$member_id))->row_array();
							$type = 1;
							
							$after_balance = $before_balance['wallet_balance'] + $total_wallet_charge;    
							$mobile = $before_balance['mobile'];
							
							$wallet_data = array(
								'member_id'           => $member_id,    
								'before_balance'      => $before_balance['wallet_balance'],
								'amount'              => $total_wallet_charge,  
								'after_balance'       => $after_balance,      
								'status'              => 1,
								'type'                => $type,      
								'created'             => date('Y-m-d H:i:s'),      
								'credited_by'         => 1,
								'description'         => 'Fund Request #'.$transaction_id.' Refund Credited'
					        );

					        $this->db->insert('member_wallet',$wallet_data);

					        $user_wallet = array(
								'wallet_balance'=>$after_balance,        
					        );    

					        $this->db->where('id',$member_id);
					        $this->db->update('users',$user_wallet); 
						}

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

					}
					elseif($status == 3)
					{
						// get member id and amount
						$get_recharge_data = $this->db->select('user_fund_transfer.*,user_benificary.account_holder_name')->join('user_benificary','user_benificary.id = user_fund_transfer.to_ben_id')->get_where('user_fund_transfer',array('user_fund_transfer.transaction_id'=>$txid))->row_array();
						$member_id = isset($get_recharge_data['user_id']) ? $get_recharge_data['user_id'] : 0 ;
						$amount = isset($get_recharge_data['transfer_amount']) ? $get_recharge_data['transfer_amount'] : 0 ;
						$transaction_id = isset($get_recharge_data['transaction_id']) ? $get_recharge_data['transaction_id'] : '' ;
						$account_holder_name = isset($get_recharge_data['account_holder_name']) ? $get_recharge_data['account_holder_name'] : '' ;

						$before_balance = $this->db->get_where('users',array('id'=>$member_id))->row_array();
						$mobile = $before_balance['mobile'];

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
					}
				}
				
				log_message('debug', 'DMT Call Back API '.$api_status.' Status Updated.');	
			}
			else
			{
				log_message('debug', 'DMT Call Back API Fund Request #'.$txid.' Status Already Updated.');	
			}
		}
		log_message('debug', 'DMT Call Back API Stop.');
		echo json_encode(array('status'=>1,'msg'=>'success'));
		
    }
	
	public function manual_generate_income()
	{
		// get member list
		$memberList = $this->db->get('member_investment')->result_array();
		if($memberList)
		{
			foreach($memberList as $list)
			{
				$member_id = $list['member_id'];
				// get user code
				$get_member_data = $this->db->get_where('users',array('id'=>$member_id))->row_array();
				$user_code = isset($get_member_data['user_code']) ? $get_member_data['user_code'] : '' ;
				$package_amount = 1400;
				$package_id = 3;
				if($package_id == 3)
				{
					// get binary income percentage
					$get_direct_percentage = $this->db->get_where('master_setting',array('id'=>1))->row_array();
					$tds_percentage = isset($get_direct_percentage['tds']) ? $get_direct_percentage['tds'] : 0 ;
					$service_tax_percentage = 0;
					
					$binary_amount = $package_amount;
					log_message('debug', 'Member #'.$user_code.' Level Income Start');
					// generate level income
					$level_member_id = $member_id;
					$level_title = array('Zero','First','Second','Third','Fourth','Fifth','Six','Seven','Eight','Nine','Ten','Eleven','Twelve','Thirteen','Fourteen','Fifteen','Sixteen','Seventeen','Eighteen','Nineteen','Twenty','Twenty One');
					for($level = 1; $level <=21; $level++){
						
						$log_title = isset($level_title[$level]) ? $level_title[$level] : '';
						
						$level_member_id = $this->User->generate_level_income($level_member_id,$binary_amount,$user_code,$tds_percentage,$service_tax_percentage,$level,$member_id,$log_title);
					}
					
					log_message('debug', 'Member #'.$user_code.' Level Income End');
				}
				
			}
		}
		die('success');
	}

    
   
}
