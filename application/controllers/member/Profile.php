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
		$this->User->checkUserPermission();
        $this->lang->load('admin/dashboard', 'english');
        $this->lang->load('admin/profile', 'english');
        $this->lang->load('front_common', 'english');
		$this->load->model('member/Withdraw_model');		
		$this->lang->load('member/withdraw', 'english');
    }
	
	
	public function index(){
		$loggedUser = $this->session->userdata('cranesmart_member_session');

        $memberDetail = $this->db->get_where('users',array('id'=>$loggedUser['id']))->row_array();

		$siteUrl = base_url();
		$data = array(
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'site_url' => $siteUrl,
            'memberDetail'=> $memberDetail,
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getsystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'content_block' => 'member/profile'
        );
        $this->parser->parse('front/layout/column-1' , $data);
    }

	public function myTeam(){
		$loggedUser = $this->session->userdata('cranesmart_member_session');
		$account_id = $loggedUser['id'];
        
		$member_current_package = $this->User->get_member_current_package();
		if($member_current_package < 2){
			$this->Az->redirect('member/profile', 'system_message_error',lang('UPGRADE_FAILED'));
		}
		
		// get member tree
		$memberTree = $this->User->get_member_tree($account_id);
		
		
		$siteUrl = base_url();
		$data = array(
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'site_url' => $siteUrl,
            'memberTree'=> $memberTree,
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getsystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'content_block' => 'member/team'
        );
        $this->parser->parse('front/layout/column-1' , $data);
    }

    public function updateProfile() {
        
        $this->load->library('template');
        $siteUrl = site_url();
        $post = $this->input->post();
        
        //get logged user info
        $loggedUser = $this->session->userdata('cranesmart_member_session');
        $account_id = $loggedUser['id'];

        //check for foem validation
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Name', 'required|xss_clean');     
        $this->form_validation->set_rules('mobile', 'Phone No.', 'required|xss_clean');     
        $this->form_validation->set_rules('email', 'Email', 'required|xss_clean|valid_email');
        if ($this->form_validation->run() == FALSE) {
            
            $this->index();
        } 
        else {
            
            $data = array(
            'name' => $post['name'],
            'mobile' => $post['mobile'],
            'email' => $post['email'],
            'updated' => date('Y-m-d h:i:s')
            );
             
            $query=$this->db->where('id', $account_id);
            $query.=$this->db->update('users',$data);   
            
            $this->Az->redirect('member/profile', 'system_message_error',lang('PROFILE_UPDATE_SUCCESSFULLY'));
            
             
        }
        
    }
	
	
	public function upgrade(){
		$loggedUser = $this->session->userdata('cranesmart_member_session');
        
        $packageList = $this->db->order_by('order_no','asc')->get_where('package',array('id >'=>1))->result_array();


        $member_current_package = $this->User->get_member_current_package();
        if($member_current_package == 2)
        {
        	unset($packageList[0]);
        	unset($packageList[2]);
        }
        elseif($member_current_package == 3)
        {
        	unset($packageList[0]);
        	unset($packageList[1]);
        	unset($packageList[2]);
        }
        elseif($member_current_package == 4)
        {
        	unset($packageList[1]);
        	unset($packageList[2]);
        }
        elseif($member_current_package == 1)
        {
        	unset($packageList[1]);
        }

		$siteUrl = base_url();
		$data = array(
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'site_url' => $siteUrl,
            'packageList'=> $packageList,
            'member_current_package' => $member_current_package,
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getsystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'content_block' => 'member/upgrade'
        );
        $this->parser->parse('front/layout/column-1' , $data);
    }
	
	public function upgradeAuth() {
        
        $this->load->library('template');
        $siteUrl = site_url();
        $post = $this->input->post();
        
        //get logged user info
        $loggedUser = $this->session->userdata('cranesmart_member_session');
        $account_id = $loggedUser['id'];

        //check for foem validation
        $this->load->library('form_validation');
        $this->form_validation->set_rules('package_id', 'Package ID', 'required|xss_clean');     
        if ($this->form_validation->run() == FALSE) {
            
            $this->Az->redirect('member/profile/upgrade', 'system_message_error',lang('UPGRADE_FAILED'));
        } 
        else {
            
			if($post['package_id'] < 2)
			{
				$this->Az->redirect('member/profile/upgrade', 'system_message_error',lang('UPGRADE_FAILED'));
			}
			
			$chk_wallet_balance =$this->db->get_where('users',array('id'=>$account_id))->row_array();
			$wallet_balance = isset($chk_wallet_balance['wallet_balance']) ? $chk_wallet_balance['wallet_balance'] : 0;
			
			$package_id = $post['package_id'];
			// get package amount
			$get_package_amount = $this->db->get_where('package',array('id'=>$package_id))->row_array();
			$package_amount = isset($get_package_amount['package_amount']) ? $get_package_amount['package_amount'] : 0 ;
			
			if($package_amount <= $wallet_balance)
			{
				$this->User->upgrade_member_package($account_id,$package_id);
				if($member_current_package == 3)
				{
					$this->Az->redirect('member/profile', 'system_message_error',lang('UPGRADE_SUCCESS'));
				}
				else
				{
					$this->Az->redirect('member/profile/upgrade', 'system_message_error',lang('UPGRADE_SUCCESS'));
				}
				
			}
			else
			{
			    
				$amount = $package_amount - $wallet_balance;
				
				$this->load->helper('string');
				$orderID = random_string('numeric',10);

				$MERCHANT_KEY = PAYU_MERCHANT_KEY;
				// Merchant Salt as provided by Payu
				$SALT = PAYU_MERCHANT_SALT;

				  // End point - change to https://secure.payu.in for LIVE mode
				  $PAYU_BASE_URL = PAYU_BASE_URL;

				  $action = '';
				  
				  $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
				  $hash = '';
				  // Hash Sequence
				  $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
				  $hashVarsSeq = explode('|', $hashSequence);
				  $posted['key'] = $MERCHANT_KEY;
				  $posted['txnid'] = $txnid;
				  $posted['amount'] = $amount;
				  $posted['productinfo'] = 'Cranesmart Membership Upgrade';
				  $posted['firstname'] = $chk_wallet_balance['name'];
				  $posted['email'] = $chk_wallet_balance['email'];
				  $posted['phone'] = $chk_wallet_balance['mobile'];
				  $surl = $siteUrl.'member/profile/paymentSuccess';
				  $furl = $siteUrl.'member/profile/paymentFailed';
				  $posted['service_provider'] = 'payu_paisa';
				  
					$hash_string = '';	
						foreach($hashVarsSeq as $hash_var) {
						  $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
						  $hash_string .= '|';
						}
					$hash_string .= $SALT;
					$hash = strtolower(hash('sha512', $hash_string));
					$action = $PAYU_BASE_URL . '/_payment';
                
				$paymentRequestData = array(
					'userID' => $account_id,
					'orderID' => $txnid,
					'payment_request_id' => '',
					'amount' => $amount,
					'is_membership_upgrade' => 1,
					'package_id' => $package_id,
					'package_amount' => $package_amount,
					'wallet_balance' => $wallet_balance,
					'status' => 1,
					'api_response' => '',
					'posted' => date('Y-m-d H:i:s')
				);
				$this->db->insert('payment_request',$paymentRequestData);
				
				/*header("Pragma: no-cache");
				header("Cache-Control: no-cache");
				header("Expires: 0");
				$checkSum = "";
				$paramList = array();


				$ORDER_ID = $orderID;
				//$ORDER_ID = 'ORDS37830391';
				$CUST_ID = $account_id;
				$INDUSTRY_TYPE_ID = 'Retail';
				$CHANNEL_ID = 'WEB';
				$TXN_AMOUNT = $amount;
			   
				// Create an array having all required parameters for creating checksum.
				$paramList["MID"] = PAYTM_MERCHANT_MID;
				$paramList["ORDER_ID"] = $ORDER_ID;
				$paramList["CUST_ID"] = $CUST_ID;
				$paramList["INDUSTRY_TYPE_ID"] = $INDUSTRY_TYPE_ID;
				$paramList["CHANNEL_ID"] = $CHANNEL_ID;
				$paramList["TXN_AMOUNT"] = $TXN_AMOUNT;
				$paramList["WEBSITE"] = PAYTM_MERCHANT_WEBSITE;
				$paramList["CALLBACK_URL"] = base_url()."member/profile/paymentResponse";
				
				// save payment request data
				
				
				

				//Here checksum string will return by getChecksumFromArray() function.
				$checkSum = $this->getChecksumFromArray($paramList,PAYTM_MERCHANT_KEY);*/
				?>
				  <html>
				  <head>
				  <title>Merchant Check Out Page</title>
				  </head>
				  <body>
					<center><h1>Please do not refresh this page...</h1></center>
					  <form method="post" action="<?php echo $action ?>" name="f1">
					  <table border="1">
						<tbody>
						<input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" />
      <input type="hidden" name="hash" value="<?php echo $hash ?>"/>
      <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />
      <input type="hidden" name="service_provider" value="payu_paisa" size="64" />
	  <input type="hidden" name="surl" value="<?php echo $surl; ?>" size="64" />
	  <input type="hidden" name="furl" value="<?php echo $furl; ?>" size="64" />
	  <input type="hidden" name="amount" value="<?php echo $amount; ?>" size="64" />
	  <input type="hidden" name="firstname" value="<?php echo $posted['firstname']; ?>" size="64" />
	  <input type="hidden" name="email" value="<?php echo $posted['email']; ?>" size="64" />
	  <input type="hidden" name="phone" value="<?php echo $posted['phone']; ?>" size="64" />
	  <input type="hidden" name="productinfo" value="<?php echo $posted['productinfo']; ?>" size="64" />
						
						</tbody>
					  </table>
					  <script type="text/javascript">
						document.f1.submit();
					  </script>
					</form>
			  <?php
            
            
			}
			
            
            
             
        }
        
    }
	
	
	/*public function packagePurchase()
    {
        $loggedUser = $this->User->getLoggedUser("cranesmart_member_session");
        $account_id = $loggedUser['id'];
        
		$amount = 1650;
		$package_id = 3;
		
		$before_balance = $this->db->get_where('users',array('id'=>$account_id))->row_array();
		$type = 1;
		if($type == 1){
			$after_balance = $before_balance['wallet_balance'] + $amount;    
		}
		else
		{
			$after_balance = $before_balance['wallet_balance'] - $amount;    
		}
		$wallet_data = array(
			'member_id'           => $account_id,    
			'before_balance'      => $before_balance['wallet_balance'],
			'amount'              => $amount,  
			'after_balance'       => $after_balance,      
			'status'              => 1,
			'type'                => $type,      
			'created'             => date('Y-m-d H:i:s'),      
			'credited_by'         => $account_id,
			'description'         => 'Topup Credited #1234567890'
		);

		$this->db->insert('member_wallet',$wallet_data);

		$user_wallet = array(
			'wallet_balance'=>$after_balance,        
		);    

		$this->db->where('id',$account_id);
		$this->db->update('users',$user_wallet); 

		$this->User->upgrade_member_package($account_id,$package_id);
		$member_current_package = $this->User->get_member_current_package();
		if($member_current_package == 3)
		{
			$this->Az->redirect('member/profile', 'system_message_error',lang('UPGRADE_SUCCESS'));
		}
		else
		{
			$this->Az->redirect('member/profile/upgrade', 'system_message_error',lang('UPGRADE_SUCCESS'));
		}
		
		
		
    }*/


    public function paymentSuccess()
    {
        $loggedUser = $this->User->getLoggedUser("cranesmart_member_session");
        $account_id = $loggedUser['id'];

        $status=isset($_POST["status"])?$_POST["status"]:'';
		$amount=isset($_POST["amount"])?$_POST["amount"]:0;
		$txnid=isset($_POST["txnid"])?$_POST["txnid"]:'';
        

		if(!$status && !$amount && !$txnid)
	    {
			$this->Az->redirect('member/profile/upgrade', 'system_message_error',lang('TOPUP_FAILED'));
	    }

	    // check transaction id valid or not
	    $chk_txn_id = $this->db->get_where('payment_request',array('userID'=>$account_id,'orderID'=>$_POST["txnid"]))->num_rows();
	    if(!$chk_txn_id)
	    {
			$this->Az->redirect('member/profile/upgrade', 'system_message_error',lang('TXN_FAILED'));
	    }

	    // check transaction id already used or not
	    $chk_txn_id = $this->db->get_where('payment_request',array('orderID'=>$_POST["txnid"],'status >'=>1))->num_rows();
	    if($chk_txn_id)
	    {
			$this->Az->redirect('member/profile/upgrade', 'system_message_error',lang('TXN_ALREDY_FAILED'));
	    }

	    $status=$_POST["status"];
		$firstname=$_POST["firstname"];
		$amount=$_POST["amount"];
		$txnid=$_POST["txnid"];
		$posted_hash=$_POST["hash"];
		$key=$_POST["key"];
		$productinfo=$_POST["productinfo"];
		$email=$_POST["email"];
		$salt=PAYU_MERCHANT_SALT;
		$retHashSeq = $salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
		$hash = hash("sha512", $retHashSeq);
		if ($hash != $posted_hash)
		{
			$this->Az->redirect('member/profile/upgrade', 'system_message_error',lang('TOPUP_FAILED'));
		}
	    $this->db->where('userID',$account_id);
		$this->db->where('orderID',$_POST["txnid"]);
		$this->db->update('payment_request',array('status'=>2,'payment_request_id'=>$_POST["txnid"]));
		
		// get order detail
		$get_order_detail = $this->db->get_where('payment_request',array('userID'=>$account_id,'orderID'=>$_POST["txnid"]))->row_array();
		$amount = isset($get_order_detail['amount']) ? $get_order_detail['amount'] : 0;
		$package_id = isset($get_order_detail['package_id']) ? $get_order_detail['package_id'] : 0;
		
		$before_balance = $this->db->get_where('users',array('id'=>$account_id))->row_array();
		$type = 1;
		if($type == 1){
			$after_balance = $before_balance['wallet_balance'] + $amount;    
		}
		else
		{
			$after_balance = $before_balance['wallet_balance'] - $amount;    
		}
		$wallet_data = array(
			'member_id'           => $account_id,    
			'before_balance'      => $before_balance['wallet_balance'],
			'amount'              => $amount,  
			'after_balance'       => $after_balance,      
			'status'              => 1,
			'type'                => $type,      
			'created'             => date('Y-m-d H:i:s'),      
			'credited_by'         => $account_id,
			'description'         => 'Topup Credited #'.$_POST["txnid"]
        );

        $this->db->insert('member_wallet',$wallet_data);

        $user_wallet = array(
			'wallet_balance'=>$after_balance,        
        );    

        $this->db->where('id',$account_id);
        $this->db->update('users',$user_wallet); 

		$this->User->upgrade_member_package($account_id,$package_id);
		$member_current_package = $this->User->get_member_current_package();
		if($member_current_package == 3)
		{
			$this->Az->redirect('member/profile', 'system_message_error',lang('UPGRADE_SUCCESS'));
		}
		else
		{
			$this->Az->redirect('member/profile/upgrade', 'system_message_error',lang('UPGRADE_SUCCESS'));
		}
		

    }

    public function paymentFailed()
    {
        $loggedUser = $this->User->getLoggedUser("cranesmart_member_session");
        $account_id = $loggedUser['id'];

        $status=isset($_POST["status"])?$_POST["status"]:'';
		$amount=isset($_POST["amount"])?$_POST["amount"]:0;
		$txnid=isset($_POST["txnid"])?$_POST["txnid"]:'';
        
		if(!$status && !$amount && !$txnid)
	    {
			$this->Az->redirect('member/profile/upgrade', 'system_message_error',lang('TOPUP_FAILED'));
	    }

	    // check transaction id valid or not
	    $chk_txn_id = $this->db->get_where('payment_request',array('userID'=>$account_id,'orderID'=>$_POST["txnid"]))->num_rows();
	    if(!$chk_txn_id)
	    {
			$this->Az->redirect('member/profile/upgrade', 'system_message_error',lang('TOPUP_FAILED'));
	    }

	    // check transaction id already used or not
	    $chk_txn_id = $this->db->get_where('payment_request',array('orderID'=>$_POST["txnid"],'status >'=>1))->num_rows();
	    if($chk_txn_id)
	    {
			$this->Az->redirect('member/profile/upgrade', 'system_message_error',lang('TOPUP_FAILED'));
	    }

	    $this->db->where('userID',$account_id);
		$this->db->where('orderID',$_POST["txnid"]);
		$this->db->update('payment_request',array('status'=>3));
		$this->Az->redirect('member/profile/upgrade', 'system_message_error',lang('TOPUP_FAILED'));

    }
	
	public function paymentResponse()
    {
        $loggedUser = $this->User->getLoggedUser("cranesmart_member_session");
        $account_id = $loggedUser['id'];
        
		$paytmChecksum = "";
		$paramList = array();
		$isValidChecksum = "FALSE";

		$paramList = $_POST;
		
		
		$paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg

		//Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application’s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
		$isValidChecksum = $this->verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.
		
		if($isValidChecksum == 'TRUE')
		{
			if ($_POST["STATUS"] == "TXN_SUCCESS") {
				$this->db->where('userID',$account_id);
				$this->db->where('orderID',$_POST["ORDERID"]);
				$this->db->update('payment_request',array('status'=>2,'payment_request_id'=>$_POST["TXNID"]));
				
				// get order detail
				$get_order_detail = $this->db->get_where('payment_request',array('userID'=>$account_id,'orderID'=>$_POST["ORDERID"]))->row_array();
				$amount = isset($get_order_detail['amount']) ? $get_order_detail['amount'] : 0;
				$package_id = isset($get_order_detail['package_id']) ? $get_order_detail['package_id'] : 0;
				
				$before_balance = $this->db->get_where('users',array('id'=>$account_id))->row_array();
				$type = 1;
				if($type == 1){
					$after_balance = $before_balance['wallet_balance'] + $amount;    
				}
				else
				{
					$after_balance = $before_balance['wallet_balance'] - $amount;    
				}
				$wallet_data = array(
					'member_id'           => $account_id,    
					'before_balance'      => $before_balance['wallet_balance'],
					'amount'              => $amount,  
					'after_balance'       => $after_balance,      
					'status'              => 1,
					'type'                => $type,      
					'created'             => date('Y-m-d H:i:s'),      
					'credited_by'         => $account_id,
					'description'         => 'Topup Credited #'.$_POST["ORDERID"]
	            );

	            $this->db->insert('member_wallet',$wallet_data);

	            $user_wallet = array(
					'wallet_balance'=>$after_balance,        
	            );    

	            $this->db->where('id',$account_id);
	            $this->db->update('users',$user_wallet); 

				$this->User->upgrade_member_package($account_id,$package_id);
				$member_current_package = $this->User->get_member_current_package();
				if($member_current_package == 3)
				{
					$this->Az->redirect('member/profile', 'system_message_error',lang('UPGRADE_SUCCESS'));
				}
				else
				{
					$this->Az->redirect('member/profile/upgrade', 'system_message_error',lang('UPGRADE_SUCCESS'));
				}
			}
			else
			{
				$this->db->where('userID',$account_id);
				$this->db->where('orderID',$_POST["ORDERID"]);
				$this->db->update('payment_request',array('status'=>3));
				$this->Az->redirect('member/profile/upgrade', 'system_message_error',lang('TOPUP_FAILED'));
			}
		}
		else
		{
			$this->db->where('userID',$account_id);
			$this->db->where('orderID',$_POST["ORDERID"]);
			$this->db->update('payment_request',array('status'=>3));
			$this->Az->redirect('member/profile/upgrade', 'system_message_error',lang('TOPUP_FAILED'));
		}
		
    }
	
	public function encrypt_e($input, $ky) {
		$key   = html_entity_decode($ky);
		$iv = "@@@@&&&&####$$$$";
		$data = openssl_encrypt ( $input , "AES-128-CBC" , $key, 0, $iv );
		return $data;
	}

	public function decrypt_e($crypt, $ky) {
		$key   = html_entity_decode($ky);
		$iv = "@@@@&&&&####$$$$";
		$data = openssl_decrypt ( $crypt , "AES-128-CBC" , $key, 0, $iv );
		return $data;
	}

	public function generateSalt_e($length) {
		$random = "";
		srand((double) microtime() * 1000000);

		$data = "AbcDE123IJKLMN67QRSTUVWXYZ";
		$data .= "aBCdefghijklmn123opq45rs67tuv89wxyz";
		$data .= "0FGH45OP89";

		for ($i = 0; $i < $length; $i++) {
			$random .= substr($data, (rand() % (strlen($data))), 1);
		}

		return $random;
	}

	public function checkString_e($value) {
		if ($value == 'null')
			$value = '';
		return $value;
	}

	public function getChecksumFromArray($arrayList, $key, $sort=1) {
		if ($sort != 0) {
			ksort($arrayList);
		}
		
		$str = $this->getArray2Str($arrayList);
		$salt = $this->generateSalt_e(4);
		$finalString = $str . "|" . $salt;
		$hash = hash("sha256", $finalString);
		$hashString = $hash . $salt;
		$checksum = $this->encrypt_e($hashString, $key);
		return $checksum;
	}
	public function getChecksumFromString($str, $key) {
		
		$salt = $this->generateSalt_e(4);
		$finalString = $str . "|" . $salt;
		$hash = hash("sha256", $finalString);
		$hashString = $hash . $salt;
		$checksum = $this->encrypt_e($hashString, $key);
		return $checksum;
	}

	public function verifychecksum_e($arrayList, $key, $checksumvalue) {
		$arrayList = $this->removeCheckSumParam($arrayList);
		ksort($arrayList);
		$str = $this->getArray2StrForVerify($arrayList);
		$paytm_hash = $this->decrypt_e($checksumvalue, $key);
		$salt = substr($paytm_hash, -4);

		$finalString = $str . "|" . $salt;

		$website_hash = hash("sha256", $finalString);
		$website_hash .= $salt;

		$validFlag = "FALSE";
		if ($website_hash == $paytm_hash) {
			$validFlag = "TRUE";
		} else {
			$validFlag = "FALSE";
		}
		return $validFlag;
	}

	public function verifychecksum_eFromStr($str, $key, $checksumvalue) {
		$paytm_hash = $this->decrypt_e($checksumvalue, $key);
		$salt = substr($paytm_hash, -4);

		$finalString = $str . "|" . $salt;

		$website_hash = hash("sha256", $finalString);
		$website_hash .= $salt;

		$validFlag = "FALSE";
		if ($website_hash == $paytm_hash) {
			$validFlag = "TRUE";
		} else {
			$validFlag = "FALSE";
		}
		return $validFlag;
	}

	public function getArray2Str($arrayList) {
		$findme   = 'REFUND';
		$findmepipe = '|';
		$paramStr = "";
		$flag = 1;	
		foreach ($arrayList as $key => $value) {
			$pos = strpos($value, $findme);
			$pospipe = strpos($value, $findmepipe);
			if ($pos !== false || $pospipe !== false) 
			{
				continue;
			}
			
			if ($flag) {
				$paramStr .= $this->checkString_e($value);
				$flag = 0;
			} else {
				$paramStr .= "|" . $this->checkString_e($value);
			}
		}
		return $paramStr;
	}

	public function getArray2StrForVerify($arrayList) {
		$paramStr = "";
		$flag = 1;
		foreach ($arrayList as $key => $value) {
			if ($flag) {
				$paramStr .= $this->checkString_e($value);
				$flag = 0;
			} else {
				$paramStr .= "|" . $this->checkString_e($value);
			}
		}
		return $paramStr;
	}

	public function redirect2PG($paramList, $key) {
		$hashString = $this->getchecksumFromArray($paramList);
		$checksum = $this->encrypt_e($hashString, $key);
	}

	public function removeCheckSumParam($arrayList) {
		if (isset($arrayList["CHECKSUMHASH"])) {
			unset($arrayList["CHECKSUMHASH"]);
		}
		return $arrayList;
	}

	public function getTxnStatus($requestParamList) {
		return $this->callAPI(PAYTM_STATUS_QUERY_URL, $requestParamList);
	}

	public function getTxnStatusNew($requestParamList) {
		return $this->callNewAPI(PAYTM_STATUS_QUERY_NEW_URL, $requestParamList);
	}

	public function initiateTxnRefund($requestParamList) {
		$CHECKSUM = $this->getRefundChecksumFromArray($requestParamList,PAYTM_MERCHANT_KEY,0);
		$requestParamList["CHECKSUM"] = $CHECKSUM;
		return $this->callAPI(PAYTM_REFUND_URL, $requestParamList);
	}

	public function callAPI($apiURL, $requestParamList) {
		$jsonResponse = "";
		$responseParamList = array();
		$JsonData =json_encode($requestParamList);
		$postData = 'JsonData='.urlencode($JsonData);
		$ch = curl_init($apiURL);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                         
		'Content-Type: application/json', 
		'Content-Length: ' . strlen($postData))                                                                       
		);  
		$jsonResponse = curl_exec($ch);   
		$responseParamList = json_decode($jsonResponse,true);
		return $responseParamList;
	}

	public function callNewAPI($apiURL, $requestParamList) {
		$jsonResponse = "";
		$responseParamList = array();
		$JsonData =json_encode($requestParamList);
		$postData = 'JsonData='.urlencode($JsonData);
		$ch = curl_init($apiURL);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                         
		'Content-Type: application/json', 
		'Content-Length: ' . strlen($postData))                                                                       
		);  
		$jsonResponse = curl_exec($ch);   
		$responseParamList = json_decode($jsonResponse,true);
		return $responseParamList;
	}
	public function getRefundChecksumFromArray($arrayList, $key, $sort=1) {
		if ($sort != 0) {
			ksort($arrayList);
		}
		$str = $this->getRefundArray2Str($arrayList);
		$salt = $this->generateSalt_e(4);
		$finalString = $str . "|" . $salt;
		$hash = hash("sha256", $finalString);
		$hashString = $hash . $salt;
		$checksum = $this->encrypt_e($hashString, $key);
		return $checksum;
	}
	public function getRefundArray2Str($arrayList) {	
		$findmepipe = '|';
		$paramStr = "";
		$flag = 1;	
		foreach ($arrayList as $key => $value) {		
			$pospipe = strpos($value, $findmepipe);
			if ($pospipe !== false) 
			{
				continue;
			}
			
			if ($flag) {
				$paramStr .= $this->checkString_e($value);
				$flag = 0;
			} else {
				$paramStr .= "|" . $this->checkString_e($value);
			}
		}
		return $paramStr;
	}
	public function callRefundAPI($refundApiURL, $requestParamList) {
		$jsonResponse = "";
		$responseParamList = array();
		$JsonData =json_encode($requestParamList);
		$postData = 'JsonData='.urlencode($JsonData);
		$ch = curl_init($apiURL);	
		curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_URL, $refundApiURL);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		$headers = array();
		$headers[] = 'Content-Type: application/json';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);  
		$jsonResponse = curl_exec($ch);   
		$responseParamList = json_decode($jsonResponse,true);
		return $responseParamList;
	}
	
	
	public function logout(){

		$this->session->unset_userdata('cranesmart_member_session');
		$this->Az->redirect('mobile', 'system_message_error', lang('LOGOUT_SUCCESS'));  

    }
	
	public function directDownline(){
		$loggedUser = $this->session->userdata('cranesmart_member_session');
		$account_id = $loggedUser['id'];
        
		$member_current_package = $this->User->get_member_current_package();
		if($member_current_package < 2){
			$this->Az->redirect('member/profile', 'system_message_error',lang('UPGRADE_FAILED'));
		}
		
		// get member direct downline
		$directDownlineList = $this->User->get_member_direct_downline($account_id);
		
		
		
		
		$siteUrl = base_url();
		$data = array(
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'site_url' => $siteUrl,
            'directDownlineList'=> $directDownlineList,
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getsystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'content_block' => 'member/direct-downline'
        );
        $this->parser->parse('front/layout/column-1' , $data);
    }
	
	public function directActive(){
		$loggedUser = $this->session->userdata('cranesmart_member_session');
		$account_id = $loggedUser['id'];
        
		$member_current_package = $this->User->get_member_current_package();
		if($member_current_package < 2){
			$this->Az->redirect('member/profile', 'system_message_error',lang('UPGRADE_FAILED'));
		}
		
		// get member direct downline
		$directDownlineList = $this->User->get_member_direct_active_downline($account_id);
		
		
		
		
		$siteUrl = base_url();
		$data = array(
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'site_url' => $siteUrl,
            'directDownlineList'=> $directDownlineList,
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getsystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'content_block' => 'member/direct-active'
        );
        $this->parser->parse('front/layout/column-1' , $data);
    }
	
	public function directDeactive(){
		$loggedUser = $this->session->userdata('cranesmart_member_session');
		$account_id = $loggedUser['id'];
        
		$member_current_package = $this->User->get_member_current_package();
		if($member_current_package < 2){
			$this->Az->redirect('member/profile', 'system_message_error',lang('UPGRADE_FAILED'));
		}
		
		// get member direct downline
		$directDownlineList = $this->User->get_member_direct_deactive_downline($account_id);
		
		
		
		
		$siteUrl = base_url();
		$data = array(
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'site_url' => $siteUrl,
            'directDownlineList'=> $directDownlineList,
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getsystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'content_block' => 'member/direct-deactive'
        );
        $this->parser->parse('front/layout/column-1' , $data);
    }
	
	public function totalDownline(){
		$loggedUser = $this->session->userdata('cranesmart_member_session');
		$account_id = $loggedUser['id'];
        
		$member_current_package = $this->User->get_member_current_package();
		if($member_current_package < 2){
			$this->Az->redirect('member/profile', 'system_message_error',lang('UPGRADE_FAILED'));
		}
		
		// get member direct downline
		$directDownlineList = $this->User->get_member_total_downline_member($account_id);
		
		
		
		
		$siteUrl = base_url();
		$data = array(
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'site_url' => $siteUrl,
            'directDownlineList'=> $directDownlineList,
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getsystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'content_block' => 'member/total-downline'
        );
        $this->parser->parse('front/layout/column-1' , $data);
    }
	
	public function totalActive(){
		$loggedUser = $this->session->userdata('cranesmart_member_session');
		$account_id = $loggedUser['id'];
        
		$member_current_package = $this->User->get_member_current_package();
		if($member_current_package < 2){
			$this->Az->redirect('member/profile', 'system_message_error',lang('UPGRADE_FAILED'));
		}
		
		// get member direct downline
		$directDownlineList = $this->User->get_member_total_downline_member($account_id);
		if($directDownlineList)
		{
			foreach($directDownlineList as $key=>$list)
			{
				if($list['paid_status'] == 0)
				{
					unset($directDownlineList[$key]);
				}
			}
		}
		
		
		
		$siteUrl = base_url();
		$data = array(
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'site_url' => $siteUrl,
            'directDownlineList'=> $directDownlineList,
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getsystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'content_block' => 'member/total-active'
        );
        $this->parser->parse('front/layout/column-1' , $data);
    }
	
	public function totalDeactive(){
		$loggedUser = $this->session->userdata('cranesmart_member_session');
		$account_id = $loggedUser['id'];
        
		$member_current_package = $this->User->get_member_current_package();
		if($member_current_package < 2){
			$this->Az->redirect('member/profile', 'system_message_error',lang('UPGRADE_FAILED'));
		}
		
		// get member direct downline
		$directDownlineList = $this->User->get_member_total_downline_member($account_id);
		if($directDownlineList)
		{
			foreach($directDownlineList as $key=>$list)
			{
				if($list['paid_status'] == 1)
				{
					unset($directDownlineList[$key]);
				}
			}
		}
		
		
		
		$siteUrl = base_url();
		$data = array(
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'site_url' => $siteUrl,
            'directDownlineList'=> $directDownlineList,
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getsystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'content_block' => 'member/total-deactive'
        );
        $this->parser->parse('front/layout/column-1' , $data);
    }
	
	public function kyc(){
		$loggedUser = $this->session->userdata('cranesmart_member_session');

        $memberDetail = $this->db->get_where('users',array('id'=>$loggedUser['id']))->row_array();
		$accountID = $loggedUser['id'];
		// get member current KYC Status
		$get_kyc_status = $this->db->select('kyc_status.*')->join('kyc_status','kyc_status.id = users.kyc_status')->get_where('users',array('users.id'=>$accountID))->row_array();
		
		
		/*echo "<pre>";
		print_r($get_kyc_status);
		die;*/
		
		// get member current KYC Detail
		$get_kyc_detail = $this->db->order_by('id','desc')->get_where('member_kyc_detail',array('member_id'=>$accountID,'status'=>3))->row_array();
		if(!$get_kyc_detail)
		{
			$get_kyc_detail = $this->db->order_by('id','desc')->get_where('member_kyc_detail',array('member_id'=>$accountID))->row_array();
		}
		

		$siteUrl = base_url();
		$data = array(
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'site_url' => $siteUrl,
            'memberDetail'=> $memberDetail,
			'get_kyc_status' => $get_kyc_status,
			'get_kyc_detail' => $get_kyc_detail,
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getsystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'content_block' => 'member/kyc'
        );
        $this->parser->parse('front/layout/column-1' , $data);
    }
	
	public function kycAuth()
	{
		$loggedUser = $this->User->getLoggedUser("cranesmart_member_session");
		$accountID = $loggedUser['id'];
		
		// check old kyc status is pending or not
		$pending_status = $this->db->get_where('member_kyc_detail',array('member_id'=>$accountID,'status'=>2))->num_rows();
		
		//check for foem validation
		$post = $this->input->post();
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('account_name', 'Account Holder Name', 'required|xss_clean');
		$this->form_validation->set_rules('account_number', 'Account No.', 'required|xss_clean');
		$this->form_validation->set_rules('ifsc', 'IFSC', 'required|xss_clean');
		$this->form_validation->set_rules('bank_name', 'Bank Name', 'required|xss_clean');
		if(!$pending_status)
		{
			if(!isset($_FILES['kyc_front_image']['name']) || $_FILES['kyc_front_image']['name'] == ''){
				$this->form_validation->set_rules('kyc_front_image', 'Aadhar Front Image', 'required|xss_clean');
			}
			if(!isset($_FILES['kyc_back_image']['name']) || $_FILES['kyc_back_image']['name'] == ''){
				$this->form_validation->set_rules('kyc_back_image', 'Aadhar Back Image', 'required|xss_clean');
			}
			if(!isset($_FILES['pancard_image']['name']) || $_FILES['pancard_image']['name'] == ''){
				$this->form_validation->set_rules('pancard_image', 'Pancard Image', 'required|xss_clean');
			}
		}
		
		if ($this->form_validation->run() == FALSE) {
			
			$this->kyc();
		}
		else
		{			
			// upload front document
			$front_document_path = '';
			if(isset($_FILES['kyc_front_image']['name']) && $_FILES['kyc_front_image']['name']){
				$config['upload_path'] = './media/kyc_document/';
				$config['allowed_types'] = 'jpg|png|jpeg';
				$config['max_size'] = 2048;
				$fileName = time().rand(111111,999999);
				$config['file_name'] = $fileName;
				$this->load->library('upload', $config);
				$this->upload->do_upload('kyc_front_image');		
				$uploadError = $this->upload->display_errors();
				if($uploadError){
					$this->Az->redirect('member/profile/kyc', 'system_message_error','<div class="alert alert-danger alert-dismissable">  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$uploadError.'</div>');
				}
				else
				{
					$fileData = $this->upload->data();
					//get uploaded file path
					$front_document_path = substr($config['upload_path'] . $fileData['file_name'], 2);
				}
			}
			
			
			// upload back document
			$back_document_path = '';
			if(isset($_FILES['kyc_back_image']['name']) && $_FILES['kyc_back_image']['name']){
				$config02['upload_path'] = './media/kyc_document/';
				$config02['allowed_types'] = 'jpg|png|jpeg';
				$config02['max_size'] = 2048;
				$fileName = time().rand(111111,999999);
				$config02['file_name'] = $fileName;
				$this->load->library('upload', $config02);
				$this->upload->do_upload('kyc_back_image');		
				$uploadError = $this->upload->display_errors();
				if($uploadError){
					$this->Az->redirect('member/profile/kyc', 'system_message_error','<div class="alert alert-danger alert-dismissable">  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$uploadError.'</div>');
				}
				else
				{
					$fileData = $this->upload->data();
					//get uploaded file path
					$back_document_path = substr($config02['upload_path'] . $fileData['file_name'], 2);
				}
			}
			
			// upload pancard document
			$pancard_document_path = '';
			if(isset($_FILES['pancard_image']['name']) && $_FILES['pancard_image']['name']){
				$config03['upload_path'] = './media/kyc_document/';
				$config03['allowed_types'] = 'jpg|png|jpeg';
				$config03['max_size'] = 2048;
				$fileName = time().rand(111111,999999);
				$config03['file_name'] = $fileName;
				$this->load->library('upload', $config03);
				$this->upload->do_upload('pancard_image');		
				$uploadError = $this->upload->display_errors();
				if($uploadError){
					$this->Az->redirect('member/profile/kyc', 'system_message_error','<div class="alert alert-danger alert-dismissable">  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$uploadError.'</div>');
				}
				else
				{
					$fileData = $this->upload->data();
					//get uploaded file path
					$pancard_document_path = substr($config03['upload_path'] . $fileData['file_name'], 2);
				}
			}
			
			$status = $this->Withdraw_model->save_kyc_data($post,$front_document_path,$back_document_path,$pancard_document_path,$accountID,$pending_status);
			
			if($status == true)
			{
				$this->Az->redirect('member/profile/kyc', 'system_message_error',lang('KYC_SAVED'));
			}
			else
			{
				$this->Az->redirect('member/profile/kyc', 'system_message_error',lang('DB_ERROR'));
			}
			
		}
	
	}
	
	public function fundRequest()
    {    

    	$loggedUser = $this->User->getLoggedUser('cranesmart_member_session');
		
		$account_id = $loggedUser['id'];	
    	$siteUrl = site_url();
		
		// get account detail
		$accountDetail = $this->db->get_where('users',array('id'=>$account_id))->row_array();
		$kyc_status = $accountDetail['kyc_status'];
		
		// get binary income percentage
		$get_direct_percentage = $this->db->get_where('master_setting',array('id'=>1))->row_array();
		$service_tax_percentage = isset($get_direct_percentage['service_tax']) ? $get_direct_percentage['service_tax'] : 0 ;
		
		$requestList = $this->db->query("SELECT a.* FROM tbl_member_fund_request as a WHERE  a.member_id = '$account_id' ")->result_array();	
		
    	
		$data = array(
			'loggedUser' => $loggedUser,
            'site_url' => $siteUrl,
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'content_block' => 'member/fund-request',
            'manager_description' => lang('SITE_NAME'),
			'accountID'=>$account_id,
			'accountDetail'=>$accountDetail,
			'kyc_status'=>$kyc_status,
			'service_tax_percentage'=>$service_tax_percentage,
			'requestList'=>$requestList,
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getSystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning()
        );
        $this->parser->parse('front/layout/column-1', $data);
		
    }
	
	function maximumCheck($num)
	{
		if ($num < 500)
		{
			$this->form_validation->set_message(
							'maximumCheck',
							'The %s field must be grater than 500'
						);
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	public function requestAuth()
	{
		$loggedUser = $this->User->getLoggedUser('cranesmart_member_session');
		$account_id = $loggedUser['id'];
		//check for foem validation
		$post = $this->input->post();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('amount', 'Amount', 'required|numeric|callback_maximumCheck');
        if ($this->form_validation->run() == FALSE) {
			
			$this->fundRequest();
		}
		else
		{
			$fund_request_date = date('d-m-Y',strtotime('next sunday'));
			$current_day = date('l');
			
			// get account detail
			$accountDetail = $this->db->get_where('users',array('id'=>$account_id))->row_array();
			$kyc_status = $accountDetail['kyc_status'];
			if($kyc_status != 3){
				$this->Az->redirect('member/profile/fundRequest', 'system_message_error',lang('KYC_VALIDATE_ERROR'));
			}
			$wallet_balance = $accountDetail['wallet_balance'];
			if($wallet_balance < $post['amount'])
			{
				$this->Az->redirect('member/profile/fundRequest', 'system_message_error',lang('FUND_REQUEST_FUND_ERROR'));
			}
			
			$status = $this->Withdraw_model->generateFundRequest($post);
			
			if($status == true)
			{
				$this->Az->redirect('member/profile/fundRequest', 'system_message_error',lang('REQUEST_GENERATE_SUCCESS'));
			}
			else
			{
				$this->Az->redirect('member/profile/fundRequest', 'system_message_error',lang('DB_ERROR'));
			}
			
		}
	
	}


    
	
}
/* End of file login.php */
/* Location: ./application/controllers/login.php */