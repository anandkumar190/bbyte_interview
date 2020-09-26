<?php
if(!defined('BASEPATH'))
    exit('No direct scrip access allowed');

/*
 * login Register controller for Frontend
 * 
 * this controller user for login, register, logout, forgot password, reset password
 * @author trilok
 */

class Home extends CI_Controller{

    public function __construct() {
        parent::__construct();
        $this->lang->load('admin/dashboard', 'english');
        $this->lang->load('front_common', 'english');
    }
	
	
	public function index(){
		
		
		// get section list
		$sectionList = $this->db->order_by('order_no','asc')->get_where('sections',array('status'=>1))->result_array();
		
		// get large banner list
		$largeBannerList = $this->db->order_by('order_no','asc')->get_where('banners',array('banner_type_id'=>1,'is_active'=>1))->result_array();
		
		$siteUrl = base_url();
		$data = array(
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'site_url' => $siteUrl,
			'sectionList'  => $sectionList,
			'largeBannerList'  => $largeBannerList,
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getsystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'content_block' => 'home'
        );
        $this->parser->parse('front/layout/column-2' , $data);
    }
	
	public function register()
	{
			$user_display_id = MEMBER_DISPLAY_ID;
            $this->load->helper('string');
			$user_display_number = random_string('numeric',6);
			$user_display_id.=$user_display_number;
            
            $name = 'Cranes Mart 1';
			$password = '123456';
			$email = 'cranesmart01@gmail.com';
			$mobile = '1234567890';
			$referral_id = '';

    		$data = array(
    			'role_id' => 2,
                'user_code'          =>  $user_display_id,      
                'name' => $name,
    			'username' => $user_display_id,
    			'password' => do_hash($password),
    			'decode_password' => $password,
    			'email' => trim(strtolower($email)),
    			'mobile' => $mobile,
    			'is_active' => 1,
    			'is_verified'=>1,
                'wallet_balance'=>0,
                'created' => date('Y-m-d H:i:s')
    		);
    		$this->db->insert('users',$data);
            $member_id = $this->db->insert_id();
			
			
			$parent_id = 1;
			$reffrel_id = 1;
			
			if($referral_id)
			{
				// check member id valid or not
				$chk_member = $this->db->get_where('users',array('role_id'=>2,'user_code'=>$referral_id))->num_rows();
				if($chk_member)
				{
					$get_member_id = $this->db->select('id')->get_where('users',array('role_id'=>2,'user_code'=>$referral_id))->row_array();
					$parent_id = isset($get_member_id['id']) ? $get_member_id['id'] : 0 ;
					$reffrel_id = isset($get_member_id['id']) ? $get_member_id['id'] : 0 ;
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
			die('success');
	}
	
	
}
/* End of file login.php */
/* Location: ./application/controllers/login.php */