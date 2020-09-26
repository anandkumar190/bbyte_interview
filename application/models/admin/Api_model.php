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

class Api_model extends CI_Model{

	public function __construct() {
        parent::__construct();
        $this->lang->load('admin/api', 'english');
    }
    
	public function sendForgotOTP($post)
    {
    	$otp_code = rand(1111,9999);
        $encrypt_otp_code = do_hash($otp_code);
        $mobile = $post['mobile'];
		$output = '';
        $sms = sprintf(lang('FORGOT_OPT_SEND_SMS'),$otp_code);
       // $api_url = SMS_API_URL.'authkey='.SMS_API_AUTH_KEY.'&mobiles=91'.$mobile.'&message='.urlencode($sms).'&sender='.SMS_API_SENDERID.'&route=4&country=0';

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
        return $encrypt_otp_code;
    }
    
    public function sendRechargeOTP($post,$userID)
    {
        $otp_code = $this->User->generate_unique_recharge_otp();
        $encrypt_otp_code = do_hash($otp_code);

        // get user mobile no
        $get_mobile = $this->db->select('mobile')->get_where('users',array('id'=>$userID))->row_array();

        $mobile = isset($get_mobile['mobile']) ? $get_mobile['mobile'] : '';
        $output = '';
        $sms = sprintf(lang('RECHARGE_OPT_SEND_SMS'),$otp_code);
        
        if($mobile)
        {
            $api_url = SMS_API_URL.'receiver='.$mobile.'&sms='.urlencode($sms);
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $api_url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
            $output = curl_exec($ch); 
            curl_close($ch);
            $otp_data = array(
                'userID' => $userID,
                'otp_code' => $otp_code,
                'encrypt_otp_code' => $encrypt_otp_code,
                'mobile' => $mobile,
                'status' => 0,
                'api_response' => $output,
                'json_post_data' => json_encode($post),
                'created' => date('Y-m-d H:i:s')
            );
            $this->db->insert('recharge_otp',$otp_data);
        }
        return $encrypt_otp_code;
    }
    
    public function sendRegisterOTP($post)
    {
        $otp_code = $this->User->generate_unique_otp();
        $encrypt_otp_code = do_hash($otp_code);
        $mobile = $post['mobile'];
        $output = '';
        $sms = sprintf(lang('REGISTER_OPT_SEND_SMS'),$otp_code);
        
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
	
}


/* end of file: user.php */
/* Location: ./application/models/admin/user.php */