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

class Register_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->lang->load('front/message', 'english');
    }


    public function sendOTP($post)
    {
    	$otp_code = $this->User->generate_unique_otp();
        $encrypt_otp_code = do_hash($otp_code);
        $mobile = $post['mobile'];
		$output = '';
        $sms = sprintf(lang('REGISTER_OPT_SEND_SMS'),$otp_code);
        
        //$api_url = SMS_API_URL.'authkey='.SMS_API_AUTH_KEY.'&mobiles=91'.$mobile.'&message='.urlencode($sms).'&sender='.SMS_API_SENDERID.'&route=4&country=0';
        
        //$api_url = SMS_API_URL.'authkey='.SMS_AUTH_KEY.'&mobiles='.$mobile.'&message='.urlencode($sms).'&sender='.SMS_SENDER_ID.'&route=4&country=0';
        
        $api_url = SMS_API_URL.'receiver='.$mobile.'&sms='.urlencode($sms);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        $output = curl_exec($ch); 
        curl_close($ch);
        $otp_data = array(
            'otp_code' => $otp_code,
            'encrypt_otp_code' => $encrypt_otp_code,
            'mobile' => $mobile,
            'status' => 0,
            'api_response' => $output,
            'json_post_data' => json_encode($post),
            'created' => date('Y-m-d H:i:s')
        );
        $this->db->insert('users_otp',$otp_data);
        
        // send OTP on Email
        $message = 'Dear User,
        You are trying to register on Cranes Mart, Your OTP is : '.$otp_code.'
        If you have any issue please contact us.
        Thanks
        Cranesmart Team
        ';
        $subject = 'Cranesmart Registration OTP';
        $lang = 'OTP_EMAIL';
        $to = strtolower(trim($post['email']));
        $this->User->sendEmail($to,$message,$subject,$lang);
        
        return true;
    }
	
	public function referralRegisterSendOTP($post)
    {
    	$otp_code = $this->User->generate_unique_otp();
        $encrypt_otp_code = do_hash($otp_code);
        $mobile = $post['mobile'];
		$output = '';
        $sms = sprintf(lang('REGISTER_OPT_SEND_SMS'),$otp_code);
        
        //$api_url = SMS_API_URL.'authkey='.SMS_API_AUTH_KEY.'&mobiles=91'.$mobile.'&message='.urlencode($sms).'&sender='.SMS_API_SENDERID.'&route=4&country=0';
        
        //$api_url = SMS_API_URL.'authkey='.SMS_AUTH_KEY.'&mobiles='.$mobile.'&message='.urlencode($sms).'&sender='.SMS_SENDER_ID.'&route=4&country=0';
        
        $api_url = SMS_API_URL.'receiver='.$mobile.'&sms='.urlencode($sms);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        $output = curl_exec($ch); 
        curl_close($ch);
        $otp_data = array(
            'otp_code' => $otp_code,
            'encrypt_otp_code' => $encrypt_otp_code,
            'mobile' => $mobile,
            'status' => 0,
            'api_response' => $output,
            'json_post_data' => json_encode($post),
            'created' => date('Y-m-d H:i:s')
        );
        $this->db->insert('users_otp',$otp_data);
        
        // send OTP on Email
        $message = 'Dear User,
        You are trying to register on Cranes Mart, Your OTP is : '.$otp_code.'
        If you have any issue please contact us.
        Thanks
        Cranesmart Team
        ';
        $subject = 'Cranesmart Registration OTP';
        $lang = 'OTP_EMAIL';
        $to = strtolower(trim($post['email']));
        $this->User->sendEmail($to,$message,$subject,$lang);
        
        return $encrypt_otp_code;
    }

    public function registerMember($post)
    {
    	$get_otp_data =$this->db->get_where('users_otp',array('otp_code'=>$post['otp_code'],'status'=>0))->row_array();
    	$post_data = isset($get_otp_data['json_post_data']) ? json_decode($get_otp_data['json_post_data']) : array();
    	if($post_data)
    	{     
            
            $user_display_id = $this->User->generate_unique_member_id();
            
    		$data = array(
    			'role_id' => 2,
                'user_code'          =>  $user_display_id,      
                'name' => $post_data->name,
    			'username' => $user_display_id,
    			'password' => do_hash($post_data->password),
    			'decode_password' => $post_data->password,
    			'email' => trim(strtolower($post_data->email)),
    			'mobile' => $post_data->mobile,
    			'is_active' => 1,
    			'is_verified'=>1,
                'wallet_balance'=>0,
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
			
			$referral_id = trim($post_data->referral_id);
			
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
            
    	}
    	$this->db->where('id',$get_otp_data['id']);
    	$this->db->update('users_otp',array('status'=>1));

        $output = '';
        $mobile = $post_data->mobile;
        $sms = sprintf(lang('SIGNUP_SUCCESS_SMS'),$user_display_id);
        
        //$api_url = SMS_API_URL.'authkey='.SMS_API_AUTH_KEY.'&mobiles=91'.$mobile.'&message='.urlencode($sms).'&sender='.SMS_API_SENDERID.'&route=4&country=0';
        
        //$api_url = SMS_API_URL.'authkey='.SMS_AUTH_KEY.'&mobiles='.$mobile.'&message='.urlencode($sms).'&sender='.SMS_SENDER_ID.'&route=4&country=0';
        
        $api_url = SMS_API_URL.'receiver='.$mobile.'&sms='.urlencode($sms);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        $output = curl_exec($ch); 
        curl_close($ch);
    	return true;
    }
	
	
	public function sendForgotOTP($post)
    {
    	$otp_code = $this->User->generate_unique_otp();
        $encrypt_otp_code = do_hash($otp_code);
        $mobile = $post['mobile'];
		$output = '';
        $sms = sprintf(lang('FORGOT_OPT_SEND_SMS'),$otp_code);
        //$api_url = SMS_API_URL.'authkey='.SMS_API_AUTH_KEY.'&mobiles=91'.$mobile.'&message='.urlencode($sms).'&sender='.SMS_API_SENDERID.'&route=4&country=0';
        
        //$api_url = SMS_API_URL.'authkey='.SMS_AUTH_KEY.'&mobiles='.$mobile.'&message='.urlencode($sms).'&sender='.SMS_SENDER_ID.'&route=4&country=0';
        
        $api_url = SMS_API_URL.'receiver='.$mobile.'&sms='.urlencode($sms);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        $output = curl_exec($ch); 
        curl_close($ch);
        $otp_data = array(
            'otp_code' => $otp_code,
            'encrypt_otp_code' => $encrypt_otp_code,
            'mobile' => $mobile,
            'status' => 0,
            'api_response' => $output,
            'json_post_data' => json_encode($post),
            'created' => date('Y-m-d H:i:s')
        );
        $this->db->insert('users_otp',$otp_data);
        
         // send OTP on Email
        $message = 'Dear User,
        You are trying to update your password on Cranes Mart, Your OTP is : '.$otp_code.'
        If you have any issue please contact us.
        Thanks
        Cranesmart Team
        ';
        $subject = 'Cranesmart Registration OTP';
        $lang = 'OTP_EMAIL';
        $to = strtolower(trim($post['email']));
        $this->User->sendEmail($to,$message,$subject,$lang);
        
        return $encrypt_otp_code;
    }
	
	
	
}


/* end of file: az.php */
/* Location: ./application/models/az.php */