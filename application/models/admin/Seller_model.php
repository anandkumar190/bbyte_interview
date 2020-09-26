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

class Seller_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->lang->load('front/message', 'english');
    }

    public function register_seller($post,$address_proof,$pan_card)
    {
    	$user_display_id = $this->User->generate_unique_seller_id();
		
		$data = array(
			'role_id' => 3,
			'user_code'          =>  $user_display_id,      
			'name' => $post['name'],
			'username' => $user_display_id,
			'password' => do_hash($post['password']),
			'decode_password' => $post['password'],
			'email' => trim(strtolower($post['email'])),
			'mobile' => $post['mobile'],
			'firm_name' => $post['firm_name'],
			'address' => $post['address'],
			'zip_code' => $post['zip_code'],
			'gst_no' => $post['gst_no'],
			'country_id' => $post['country'],
			'state_id' => $post['state'],
			'is_active' => 0,
			'is_verified'=>0,
			'created' => date('Y-m-d H:i:s')
		);
		$this->db->insert('users',$data);
		$member_id = $this->db->insert_id();
		
		// save account detail and kyc
		$accountData = array(    
			'member_id'            =>  $member_id,      
			'account_holder_name'               =>  $post['account_holder_name'],
			'account_number'               =>  $post['account_no'],
			'ifsc'               =>  $post['ifsc'],
			'bank_name'               =>  $post['bank_name'],
			'front_document'           =>  $address_proof,
			'pancard_document'           =>  $pan_card,
			'status'           =>  2,
			'created'            =>  date('Y-m-d H:i:s')
		);
		$this->db->insert('member_kyc_detail',$accountData);
		return true;
    }
	
	
	
}


/* end of file: az.php */
/* Location: ./application/models/az.php */