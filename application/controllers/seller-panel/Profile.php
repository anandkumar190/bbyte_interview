<?php
if(!defined('BASEPATH'))
    exit('No direct scrip access allowed');

/*
 * login Register controller for Frontend
 * 
 * this controller user for login, register, logout, forgot password, reset password
 * @author trilok
 */

class Profile extends CI_Controller{

    public function __construct() {
        parent::__construct();
        //load language
		$this->User->checkSellerPermission();
		$this->load->model('admin/Profile_model');
        $this->lang->load('admin/profile', 'english');
        $this->lang->load('front_common' , 'english');
    }


    public function profile($uname_prefix = '' , $username = ''){

        //get logged user info
        $loggedUser = $this->User->getLoggedUser("cranesmart_seller_session");
        $account_id = $loggedUser['id'];


        // get country list
        $countryList = $this->db->get('countries')->result_array();
        
        // get state list
        $stateList = $this->db->order_by('name','asc')->get_where('states',array('country_code_char2'=>'IN'))->result_array();

         // get user Bank details 
        $bankdetails = $this->db->order_by('account_holder_name','asc')->get_where('tbl_member_kyc_detail',array('member_id'=>$account_id))->result_array();
      
      //print_r($bankdetails);die;
        
        
        $siteUrl = base_url();
        $data = array(
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'site_url' => $siteUrl,
            'countryList' => $countryList,
            'stateList' => $stateList,
            'bankdetails'=> $bankdetails,
            'loggedUser'  => $loggedUser,
            'account_id'=>$account_id,
            'page_title' => 'Profile',
            'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getsystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'content_block' => 'profile/myProfile'
        );
        $this->parser->parse('seller/layout/column-1' , $data);
    }


	
	public function update() {
        
		$this->load->library('template');
        $siteUrl = site_url();
		$post = $this->input->post();
		
        //get logged user info
        $loggedUser = $this->User->getLoggedUser('cranesmart_seller_session');
        $account_id = $loggedUser['id'];

        //check for foem validation
        $this->load->library('form_validation');
        $this->form_validation->set_rules('opw', 'Old Password', 'required|xss_clean');		
        $this->form_validation->set_rules('npw', 'New Password', 'required|xss_clean');     
        $this->form_validation->set_rules('cpw', 'Confirm New Password', 'required|xss_clean|matches[npw]');     
        if ($this->form_validation->run() == FALSE) {
			
			$this->Az->redirect('seller-panel/profile/profile', 'system_message_error',lang('CHK_ALL_FEILDS'));
            
        } 
		else {
			
            // check old password valid or not
            $chk_old_pwd = $this->db->get_where('users',array('id'=>$account_id,'password'=>do_hash($post['opw'])))->num_rows();
            if(!$chk_old_pwd)
            {
                $this->Az->redirect('seller-panel/profile/profile', 'system_message_error',lang('OLD_PASSWORD_FAILED'));   
            }

			$this->Profile_model->updateAdminPassword($post,$account_id);
			
			$this->Az->redirect('seller-panel/profile/profile', 'system_message_error',lang('PASSWORD_UPDATE_SUCCESSFULLY'));
			
			 
		}
		
    }


    public function updateProfile() {
        
        $this->load->library('template');
        $siteUrl = site_url();
        $post = $this->input->post();
        

        //get logged user info
        $loggedUser = $this->User->getLoggedUser('cranesmart_seller_session');
        $account_id = $loggedUser['id'];

        //check for foem validation
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Name', 'required|xss_clean');     
        $this->form_validation->set_rules('mobile', 'Phone No.', 'required|xss_clean');     
        $this->form_validation->set_rules('email', 'Email', 'required|xss_clean|valid_email');

        $this->form_validation->set_rules('address', 'address', 'required|xss_clean');     
        $this->form_validation->set_rules('state', 'state', 'required|xss_clean');
        $this->form_validation->set_rules('country', 'country', 'required|xss_clean');
        $this->form_validation->set_rules('zip_code', 'zip_code', 'required|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            
            $this->Az->redirect('seller-panel/profile/profile', 'system_message_error',lang('REQUIRED_ALL_FEILDS'));
        } 
        else {
            
            $data = array(
            'name' => $post['name'],
            'mobile' => $post['mobile'],
            'email' => $post['email'],
            'address' => $post['address'],
            'state_id' => $post['state'],
            'country_id' => $post['country'],
            'zip_code' => $post['zip_code'],
            'updated' => date('Y-m-d h:i:s')
            );
             

            $this->db->where('id',$account_id);
             $this->db->update('users', $data);

            $this->Az->redirect('seller-panel/profile/profile', 'system_message_error',lang('PROFILE_UPDATE_SUCCESSFULLY'));
            
             
        }
        
    }
	
	 public function profile_imageupdate() {
        $loggedUser = $this->User->getLoggedUser('cranesmart_seller_session');
        $account_id = $loggedUser['id'];
             $post = $this->input->post();
            $old_image=$post['photo'];

        $this->load->helper('url', 'form');

         $config['upload_path'] = './media/seller_profile/';
        $config['allowed_types'] = 'jpeg|jpg|png';
        $config['max_size'] = 2000;
        $config['max_width'] = 1500;
        $config['max_height'] = 1500;
         $config['file_name'] = rand()."_sellerprofile".$_FILES['file']['Profileupload']; 

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('Profileupload')) {
            $error = array('error' => $this->upload->display_errors());
            

            $this->Az->redirect('seller-panel/profile/profile', 'system_message_error',lang('REQUIRED_ALL_FEILDS'));

        } else {
            $data = array('image_metadata' => $this->upload->data());


            $data = array(
            'photo' => "media/seller_profile/".$data['image_metadata']['file_name'],
            'updated' => date('Y-m-d h:i:s')
            );


             $this->db->where('id',$account_id);
             $this->db->update('users', $data);

             
              if (is_file($old_image)) {
                    unlink($old_image);
                 }


           $this->Az->redirect('seller-panel/profile/profile', 'system_message_error',lang('PROFILE_UPDATE_SUCCESSFULLY'));

            //$this->load->view('files/upload_result', $data);
        }








        
     }
	
	
	
}


/* End of file login.php */
/* Location: ./application/controllers/login.php */