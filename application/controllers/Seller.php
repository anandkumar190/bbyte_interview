<?php
if(!defined('BASEPATH'))
    exit('No direct scrip access allowed');

/*
 * login Register controller for Frontend
 * 
 * this controller user for login, register, logout, forgot password, reset password
 * @author trilok
 */

class Seller extends CI_Controller
{

    public function __construct() {
        parent::__construct();
        //load language
        $this->load->model('admin/Seller_model');
        $this->lang->load('front/message', 'english');
    }
	
	public function index(){
		
		// get country list
		$countryList = $this->db->get('countries')->result_array();
		
		// get state list
		$stateList = $this->db->order_by('name','asc')->get_where('states',array('country_code_char2'=>'IN'))->result_array();
		
		$siteUrl = base_url();
		$data = array(
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'site_url' => $siteUrl,
			'countryList' => $countryList,
			'stateList' => $stateList,
            'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getsystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'content_block' => 'seller'
        );
        $this->parser->parse('front/layout/column-3' , $data);
    }

	public function registerAuth()
    {
        //check for foem validation
        $post = $this->input->post();
        $response = array();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Name', 'required|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'required|xss_clean|valid_email');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required|xss_clean|min_length[10]|max_length[10]');
		$this->form_validation->set_rules('password', 'Password', 'required|xss_clean|min_length[6]');
		$this->form_validation->set_rules('firm_name', 'Firm Name', 'xss_clean');
		$this->form_validation->set_rules('address', 'Address', 'required|xss_clean');
		$this->form_validation->set_rules('state', 'State', 'required|xss_clean');
		$this->form_validation->set_rules('country', 'Country', 'required|xss_clean');
		$this->form_validation->set_rules('zip_code', 'ZIP Code', 'required|xss_clean');
		$this->form_validation->set_rules('gst_no', 'GST No.', 'xss_clean');
		if(!isset($_FILES['address_proof']['name']) || !$_FILES['address_proof']['name']){
			$this->form_validation->set_rules('address_proof', 'Address Proof', 'required|xss_clean');
		}
		if(!isset($_FILES['pan_card']['name']) || !$_FILES['pan_card']['name']){
			$this->form_validation->set_rules('pan_card', 'PAN Card', 'required|xss_clean');
		}
		$this->form_validation->set_rules('account_holder_name', 'Account Holder Name', 'required|xss_clean');
		$this->form_validation->set_rules('account_no', 'Account No.', 'required|xss_clean');
		$this->form_validation->set_rules('ifsc', 'IFSC Code', 'required|xss_clean');
		$this->form_validation->set_rules('bank_name', 'Bank Name', 'required|xss_clean');
		$this->form_validation->set_rules('tab', 'Tab', 'xss_clean');
        
        if ($this->form_validation->run() == FALSE) {
           $this->index();
        }
        else
        {
			
			$chk_email_mobile =$this->db->query("SELECT * FROM tbl_users WHERE email = '$post[email]' or mobile = '$post[mobile]'")->num_rows();
            if($chk_email_mobile)           
            {
				
                $this->Az->redirect('seller', 'system_message_error',lang('SELLER_EMAIL_MOBILE_ALREDY_ERROR'));   
            }
            else
            {
				$address_proof = '';
				if ($_FILES['address_proof']['name'] != '') {
					//generate logo name randomly
					$fileName = rand(1111, 999999999);
					$config['upload_path'] = './media/seller_document/';
					$config['allowed_types'] = 'jpg|png|gif|jpeg';
					$config['file_name'] = $fileName;
					$this->load->library('upload');
					$this->upload->initialize($config);
					$this->upload->do_upload('address_proof');
					$uploadError = $this->upload->display_errors();
					if ($uploadError) {
						 $this->Az->redirect('seller', 'system_message_error', $uploadError);
					} else {
					   
						$fileData = $this->upload->data();
						//get uploaded file path
						$address_proof = substr($config['upload_path'] . $fileData['file_name'], 2);
					}
				}
				$pan_card = '';
				if ($_FILES['pan_card']['name'] != '') {
					//generate logo name randomly
					$fileName = rand(1111, 999999999);
					$config['upload_path'] = './media/seller_document/';
					$config['allowed_types'] = 'jpg|png|gif|jpeg';
					$config['file_name'] = $fileName;
					$this->load->library('upload');
					$this->upload->initialize($config);
					$this->upload->do_upload('pan_card');
					$uploadError = $this->upload->display_errors();
					if ($uploadError) {
						 $this->Az->redirect('seller', 'system_message_error', $uploadError);
					} else {
					   
						$fileData = $this->upload->data();
						//get uploaded file path
						$pan_card = substr($config['upload_path'] . $fileData['file_name'], 2);
					}
				}
				$status = $this->Seller_model->register_seller($post,$address_proof,$pan_card);
				$this->Az->redirect('seller', 'system_message_error',lang('SELLER_REGISTER_SUCCESS'));   
            }
			
        }
        
    
    }
	
	public function loginAuth()
    {
        //check for foem validation
        $post = $this->input->post();
        $response = array();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Email or Mobile', 'required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
           $this->index();
        }
        else
        {
			
			$username = $post['username'];
			$password = do_hash($post['password']);
            $chk_email_mobile =$this->db->query("SELECT * FROM tbl_users WHERE (username = '$username' or mobile = '$username' or email = '$username') and password = '$password' and role_id = 3")->num_rows();
            if(!$chk_email_mobile)           
            {
				$this->Az->redirect('seller', 'system_message_error',lang('LOGIN_FAILED'));   
            }
            else
            {
				$get_user_data =$this->db->query("SELECT * FROM tbl_users WHERE (username = '$username' or mobile = '$username'  or email = '$username') and password = '$password' and role_id = 3")->row_array();
				if($get_user_data['is_active'] == 0)
				{
					$this->Az->redirect('seller', 'system_message_error',lang('LOGIN_ACTIVE_FAILED'));   
				}
				elseif($get_user_data['is_verified'] == 0)
				{
					$this->Az->redirect('seller', 'system_message_error',lang('LOGIN_VERIFY_FAILED'));   
				}
				else
				{
					$this->session->set_userdata('cranesmart_seller_session',$get_user_data);
					$this->Az->redirect('seller-panel/dashboard', 'system_message_error','');   
					
				}   
            }
			
        }
        


    
    }

   public function forgotpasswordAuth()
    {

        //check for foem validation
        $post = $this->input->post();
        $response = array();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Email or Mobile', 'required|xss_clean');
        //$this->form_validation->set_rules('password', 'Password', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
           //$this->index();
        $response = ["status"=>0,"result"=>"Invalid Mobile or Email"];
        }
        else
        {
			 
			$username = $post['username'];
			$Otp_type = $post['otp_type'];
			//$password = do_hash($post['password']);
            $chk_email_mobile =$this->db->query("SELECT * FROM tbl_users WHERE (username = '$username' or mobile = '$username' or email = '$username') and role_id = 3")->num_rows();
            if(!$chk_email_mobile)           
            {
            	
				// $this->Az->redirect('seller', 'system_message_error',lang('LOGIN_FAILED')); 
$response = ["status"=>0,"result"=>"Mobile or Email not found"];  
            }
            else
            {
            	
$get_user_data =$this->db->query("SELECT * FROM tbl_users WHERE (username = '$username' or mobile = '$username'  or email = '$username') and role_id = 3")->row_array();
    $otp=rand(1000,9999);

if($Otp_type=="mobile"){
$sms_url = "http://bulksms.thedigitalindia.net/index.php/smsapi/httpapi/?uname=cranesmart&password=123456&sender=CRANES&receiver=".$get_user_data['mobile']."&route=TA&msgtype=1&sms=Your%20OTP%20".$otp."%20For%20Change%20Password";
	
	      //echo $sms_url;
	       
	function getRecords($url)
	{
		ini_set('max_execution_time', 600);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}
		$objResponse = getRecords($sms_url);
        //print_r($objResponse);
        $enter_otp_data =$this->db->query("UPDATE `tbl_users` SET `otp` = '$otp',`updated`=now() WHERE (username = '$username' or mobile = '$username'  or email = '$username') and role_id = 3");

$response = ["status"=>1,"username"=>"$username","result"=>"otp send to mobile"];

		}else {


			$this->load->library('email');

				$config = array(
				    'protocol'  => 'smtp',
				    'smtp_host' => 'ssl://smtp.googlemail.com',
				    'smtp_port' => 465,
				   'smtp_user' => 'xxxxxxxxx',
					'smtp_pass' => 'xxxxxx',
				    'mailtype'  => 'html',
				    'charset'   => 'utf-8'
				);
				$this->email->initialize($config);
				$this->email->set_mailtype("html");
				$this->email->set_newline("\r\n");

				//Email content
				$htmlContent = '<h1>Welcome To Cranes Mart '.' </h1>';
				$htmlContent .= '<p>Dear User "'.$get_user_data['name'].'"</p>';
				$htmlContent .= '<p>Your OTP is  "'.$otp.'"</p>';
				$this->email->from("ajaykumar.geektech@gmail.com","Cranes Mart");
				 $this->email->to($get_user_data['email']);
				$this->email->subject('Forgot Password OTP');
				$this->email->message($htmlContent);
                    if (!$this->email->send()) {
                show_error($this->email->print_debugger());
                 }
                 else{
                 $enter_otp_data =$this->db->query("UPDATE `tbl_users` SET `otp` = '$otp',`updated`=now() WHERE (username = '$username' or mobile = '$username'  or email = '$username') and role_id = 3");

$response = ["status"=>1,"username"=>"$username","result"=>"otp send to Email"];
		}	

                 }


				
            }
			
        } 

    echo json_encode($response); 
   }


public function verify_otp()
    {

        //check for foem validation
        $post = $this->input->post();
        $response = array();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Email or Mobile', 'required|xss_clean');
        //$this->form_validation->set_rules('password', 'Password', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
           //$this->index();
        $response = ["status"=>0,"result"=>"Invalid Mobile or Email"];
        }
        else
        {
			 
			$username = $post['username'];
			$otp_number = $post['otp_number'];
			//$password = do_hash($post['password']);
            $chk_email_mobile =$this->db->query("SELECT * FROM tbl_users WHERE (username = '$username' or mobile = '$username' or email = '$username') and role_id = 3 and otp = '$otp_number'")->num_rows();
            if(!$chk_email_mobile)           
            {
            	
				// $this->Az->redirect('seller', 'system_message_error',lang('LOGIN_FAILED')); 
$response = ["status"=>0,"result"=>"wrong OTP"];  
            }
            else
            {
            	
// $get_user_data =$this->db->query("SELECT * FROM tbl_users WHERE (username = '$username' or mobile = '$username'  or email = '$username') and role_id = 3")->row_array();
   $response = ["status"=>1,"username"=>"$username","result"=>"OTP verified"];  



				
            }
			
        } 

    echo json_encode($response); 
   }


public function changepassword()
    {

        //check for foem validation
        $post = $this->input->post();
        $response = array();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Email or Mobile', 'required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
           //$this->index();
        $response = ["status"=>0,"result"=>"Invalid Password"];

        }
        else
        {
			 
			$username = $post['username'];
			$password = do_hash($post['password']);
$update_password =$this->db->query("UPDATE `tbl_users` SET `password` = '$password',`updated`=now() WHERE (username = '$username' or mobile = '$username'  or email = '$username') and role_id = 3");



            if(!$update_password)           
            {
            	
				// $this->Az->redirect('seller', 'system_message_error',lang('LOGIN_FAILED')); 
$response = ["status"=>0,"result"=>"Password Not changed"];  
            }
            else
            {

 $response = ["status"=>1,"result"=>"Password Changed"];  
	
            }
			
        } 

    echo json_encode($response); 
   }


}
