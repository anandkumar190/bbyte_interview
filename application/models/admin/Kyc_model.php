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

class Kyc_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

	public function updateRequestAuth($requestID,$status)
	{
		$get_request_data = $this->db->get_where('member_kyc_detail',array('id'=>$requestID,'status'=>2))->row_array();
		$memberID = $get_request_data['member_id'];
		if($status == 1){
			// update request status
			$this->db->where('id',$requestID);
			$this->db->update('member_kyc_detail',array('status'=>3,'updated'=>date('Y-m-d H:i:s')));
			
			$this->db->where('id',$memberID);
			$this->db->update('users',array('kyc_status'=>3));
			
			// get user mobile number
			$get_user_mobile = $this->db->select('mobile')->get_where('users',array('id'=>$memberID))->row_array();
			$mobile = isset($get_user_mobile['mobile']) ? $get_user_mobile['mobile'] : '';
			// send APPROVED SMS
			if($mobile)
			{
				$sms = 'Congratulations !! Your KYC is approved Cranesmart Team
				';
		        
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
		else
		{
			// update request status
			$this->db->where('id',$requestID);
			$this->db->update('member_kyc_detail',array('status'=>4,'updated'=>date('Y-m-d H:i:s')));
			
			$this->db->where('id',$memberID);
			$this->db->update('users',array('kyc_status'=>4));
			// get user mobile number
			$get_user_mobile = $this->db->select('mobile')->get_where('users',array('id'=>$memberID))->row_array();
			$mobile = isset($get_user_mobile['mobile']) ? $get_user_mobile['mobile'] : '';
			// send APPROVED SMS
			if($mobile)
			{
				$sms = 'Alert !!! Your KYC is rejected Please resubmit clear copies of address proof ( front and back side of document) and Pan card. Cranesmart Team
				';
		        
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
		
		
		return true;
	}

}


/* end of file: az.php */
/* Location: ./application/models/az.php */