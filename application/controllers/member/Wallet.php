<?php
if(!defined('BASEPATH'))
    exit('No direct scrip access allowed');

/*
 * login Register controller for Frontend
 * 
 * this controller user for login, register, logout, forgot password, reset password
 * @author trilok
 */

class Wallet extends CI_Controller{

    public function __construct() {
        parent::__construct();
		$this->User->checkUserPermission();
        $this->lang->load('admin/dashboard', 'english');
		$this->lang->load('admin/profile', 'english');
        $this->lang->load('front_common', 'english');
        $this->load->model('member/Withdraw_model');
    }
	
	
	public function premiumWalletHistory(){
		$loggedUser = $this->session->userdata('cranesmart_member_session');
        
        $recharge = $this->db->order_by('created','desc')->get_where('member_wallet',array('member_id'=>$loggedUser['id'],'wallet_type'=>1))->result_array();

		$siteUrl = base_url();
		$data = array(
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'site_url' => $siteUrl,
            'recharge' => $recharge, 
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getsystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'content_block' => 'member/premiumWalletHistory'
        );
        $this->parser->parse('front/layout/column-1' , $data);
    }
	
	public function pointsHistory(){
		$loggedUser = $this->session->userdata('cranesmart_member_session');
        
        $recharge = $this->db->order_by('created','desc')->get_where('member_wallet',array('member_id'=>$loggedUser['id'],'wallet_type'=>2))->result_array();

		$siteUrl = base_url();
		$data = array(
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'site_url' => $siteUrl,
            'recharge' => $recharge, 
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getsystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'content_block' => 'member/pointsHistory'
        );
        $this->parser->parse('front/layout/column-1' , $data);
    }
	
	public function topup(){
		
		$loggedUser = $this->session->userdata('cranesmart_member_session');
        $siteUrl = base_url();
		$data = array(
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'site_url' => $siteUrl,
            'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getsystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'content_block' => 'member/topup'
        );
        $this->parser->parse('front/layout/column-1' , $data);
    }
	
	function maximumCheck($num)
	{
		if ($num < 1)
		{
			$this->form_validation->set_message(
							'maximumCheck',
							'The %s field must be grater than 10'
						);
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

    public function topupAuth()
    {   
    	$siteUrl = base_url();
        $loggedUser = $this->session->userdata('cranesmart_member_session');
		$account_id = $loggedUser['id'];
        //check for foem validation
        $post = $this->input->post();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('amount', 'Amount', 'required|numeric|callback_maximumCheck');
        
        if ($this->form_validation->run() == FALSE) {
            
            $this->topup();
        }
        else
        {   
			$chk_wallet_balance =$this->db->get_where('users',array('id'=>$account_id))->row_array();
			$amount = $post['amount'];


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
			  $posted['productinfo'] = 'Cranesmart Wallet Topup';
			  $posted['firstname'] = $chk_wallet_balance['name'];
			  $posted['email'] = $chk_wallet_balance['email'];
			  $posted['phone'] = $chk_wallet_balance['mobile'];
			  $surl = $siteUrl.'member/wallet/paymentSuccess';
			  $furl = $siteUrl.'member/wallet/paymentFailed';
			  $posted['service_provider'] = 'payu_paisa';
			  
				$hash_string = '';	
					foreach($hashVarsSeq as $hash_var) {
					  $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
					  $hash_string .= '|';
					}
				$hash_string .= $SALT;
				$hash = strtolower(hash('sha512', $hash_string));
				$action = $PAYU_BASE_URL . '/_payment';


			
			// save payment request data
			$paymentRequestData = array(
				'userID' => $account_id,
				'orderID' => $txnid,
				'payment_request_id' => '',
				'amount' => $amount,
				'status' => 1,
				'api_response' => '',
				'posted' => date('Y-m-d H:i:s')
			);
			$this->db->insert('payment_request',$paymentRequestData);
			
			
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

    public function paymentSuccess()
    {
        $loggedUser = $this->User->getLoggedUser("cranesmart_member_session");
        $account_id = $loggedUser['id'];

        $status=isset($_POST["status"])?$_POST["status"]:'';
		$amount=isset($_POST["amount"])?$_POST["amount"]:0;
		$txnid=isset($_POST["txnid"])?$_POST["txnid"]:'';
        
		if(!$status && !$amount && !$txnid)
	    {
			$this->Az->redirect('member/wallet/topup', 'system_message_error',lang('TOPUP_FAILED'));
	    }

	    // check transaction id valid or not
	    $chk_txn_id = $this->db->get_where('payment_request',array('userID'=>$account_id,'orderID'=>$_POST["txnid"]))->num_rows();
	    if(!$chk_txn_id)
	    {
			$this->Az->redirect('member/wallet/topup', 'system_message_error',lang('TXN_FAILED'));
	    }

	    // check transaction id already used or not
	    $chk_txn_id = $this->db->get_where('payment_request',array('orderID'=>$_POST["txnid"],'status >'=>1))->num_rows();
	    if($chk_txn_id)
	    {
			$this->Az->redirect('member/wallet/topup', 'system_message_error',lang('TXN_ALREDY_FAILED'));
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
			$this->Az->redirect('member/wallet/topup', 'system_message_error',lang('TOPUP_FAILED'));
		}

	    $this->db->where('userID',$account_id);
		$this->db->where('orderID',$_POST["txnid"]);
		$this->db->update('payment_request',array('status'=>2,'payment_request_id'=>$_POST["txnid"]));
		
		// get order detail
		$get_order_detail = $this->db->get_where('payment_request',array('userID'=>$account_id,'orderID'=>$_POST["txnid"]))->row_array();
		$amount = isset($get_order_detail['amount']) ? $get_order_detail['amount'] : 0;
		
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

		$this->Az->redirect('member/wallet/topup', 'system_message_error',sprintf(lang('TOPUP_SUCCESS'),$amount));   

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
			$this->Az->redirect('member/wallet/topup', 'system_message_error',lang('TOPUP_FAILED'));
	    }

	    // check transaction id valid or not
	    $chk_txn_id = $this->db->get_where('payment_request',array('userID'=>$account_id,'orderID'=>$_POST["txnid"]))->num_rows();
	    if(!$chk_txn_id)
	    {
			$this->Az->redirect('member/wallet/topup', 'system_message_error',lang('TOPUP_FAILED'));
	    }

	    // check transaction id already used or not
	    $chk_txn_id = $this->db->get_where('payment_request',array('orderID'=>$_POST["txnid"],'status >'=>1))->num_rows();
	    if($chk_txn_id)
	    {
			$this->Az->redirect('member/wallet/topup', 'system_message_error',lang('TOPUP_FAILED'));
	    }

	    $this->db->where('userID',$account_id);
		$this->db->where('orderID',$_POST["txnid"]);
		$this->db->update('payment_request',array('status'=>3));
		$this->Az->redirect('member/wallet/topup', 'system_message_error',lang('TOPUP_FAILED'));

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
		
		if($_POST["STATUS"] == 'TXN_SUCCESS')
		{
			$this->db->where('userID',$account_id);
			$this->db->where('orderID',$_POST["ORDERID"]);
			$this->db->update('payment_request',array('status'=>2,'payment_request_id'=>$_POST["TXNID"]));
			
			// get order detail
			$get_order_detail = $this->db->get_where('payment_request',array('userID'=>$account_id,'orderID'=>$_POST["ORDERID"]))->row_array();
			$amount = isset($get_order_detail['amount']) ? $get_order_detail['amount'] : 0;
			
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

			$this->Az->redirect('member/wallet/topup', 'system_message_error',sprintf(lang('TOPUP_SUCCESS'),$amount));   
		}
		else
		{
			$this->db->where('userID',$account_id);
			$this->db->where('orderID',$_POST["ORDERID"]);
			$this->db->update('payment_request',array('status'=>3));
			$this->Az->redirect('member/wallet/topup', 'system_message_error',lang('TOPUP_FAILED'));
		}
		
    }
    
    
    public function activeWithdrawal(){

		$loggedUser = $this->session->userdata('cranesmart_member_session');

		$user_dmr_cusomer_id = $this->User->get_user_dmr_customer_id();
		if($user_dmr_cusomer_id != ''){
			$this->Az->redirect('member/wallet/benificary', 'system_message_error',lang('WITHDRAWAL_ACTIVE_ERROR'));
		}
		
		$user_kyc_status = $this->User->get_user_kyc_status();
		if($user_kyc_status != 3)
		{
			$this->Az->redirect('member/profile', 'system_message_error',lang('KYC_STATUS_FAILED'));
		}

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
            'content_block' => 'member/active-withdrawal'
        );
        $this->parser->parse('front/layout/column-1' , $data);
    }

    public function withdrawalAuth() {
        
        $this->load->library('template');
        $siteUrl = site_url();
        $post = $this->input->post();
        log_message('debug', 'Withdrawal Active Post Data - '.json_encode($post));	
        //get logged user info
        $loggedUser = $this->session->userdata('cranesmart_member_session');
        $account_id = $loggedUser['id'];

        //check for foem validation
        $this->load->library('form_validation');
        $this->form_validation->set_rules('first_name', 'First Name', 'required|xss_clean');     
        $this->form_validation->set_rules('last_name', 'Last Name', 'required|xss_clean');     
        $this->form_validation->set_rules('mobile', 'Mobile Number', 'required|xss_clean|numeric|min_length[10]|max_length[10]');     
        $this->form_validation->set_rules('email', 'Email', 'required|xss_clean|valid_email');
        $this->form_validation->set_rules('zipcode', 'Email', 'required|xss_clean|numeric|min_length[6]');
        if ($this->form_validation->run() == FALSE) {
            
            log_message('debug', 'Withdrawal Active Form Validation Error.');	
            $this->session->set_flashdata('system_message_error', lang('CHK_FIELDS'));
            $this->activeWithdrawal();
        } 
        else {
            
            // save active request
            $response = $this->Withdraw_model->save_withdrawal_active_request($post,$account_id);

            log_message('debug', 'Withdrawal Active Final API Response - '.json_encode($response));	

            if($response['status'])
            {
            	$this->Az->redirect('member/wallet/active-withdrawal', 'system_message_error',lang('WITHDRAWAL_ACTIVE_SUCCESS'));
        	}
        	else
        	{
        		$this->Az->redirect('member/wallet/active-withdrawal', 'system_message_error',sprintf(lang('WITHDRAWAL_ACTIVE_FAILED'),$response['msg']));

        	}
            
             
        }
        
    }

    public function benificary(){

		$loggedUser = $this->session->userdata('cranesmart_member_session');

        $memberDetail = $this->db->get_where('users',array('id'=>$loggedUser['id']))->row_array();

        $user_dmr_cusomer_id = $this->User->get_user_dmr_customer_id();
		if($user_dmr_cusomer_id == ''){
			$this->Az->redirect('member/wallet/active-withdrawal', 'system_message_error',lang('WITHDRAWAL_NOT_ACTIVE_ERROR'));
		}
		
		$user_kyc_status = $this->User->get_user_kyc_status();
		if($user_kyc_status != 3)
		{
			$this->Az->redirect('member/profile', 'system_message_error',lang('KYC_STATUS_FAILED'));
		}

		$account_id = $loggedUser['id'];

		// get Benificary list
		$benificaryList = $this->db->order_by('created','desc')->get_where('user_benificary',array('user_id'=>$account_id,'status'=>2))->result_array();

		$siteUrl = base_url();
		$data = array(
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'site_url' => $siteUrl,
            'memberDetail'=> $memberDetail,
            'benificaryList' => $benificaryList,
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getsystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'content_block' => 'member/benificary'
        );
        $this->parser->parse('front/layout/column-1' , $data);
    }

    public function benificaryAuth() {
        
        $this->load->library('template');
        $siteUrl = site_url();
        $post = $this->input->post();
        log_message('debug', 'Benificary Add Post Data - '.json_encode($post));	
        //get logged user info
        $loggedUser = $this->session->userdata('cranesmart_member_session');
        $account_id = $loggedUser['id'];

        //check for foem validation
        $this->load->library('form_validation');
        $this->form_validation->set_rules('account_holder_name', 'Account Holder Name', 'required|xss_clean');     
        $this->form_validation->set_rules('bank_name', 'Bank Name', 'required|xss_clean');     
        $this->form_validation->set_rules('account_number', 'Account Number', 'required|xss_clean|numeric|min_length[10]');     
        $this->form_validation->set_rules('ifsc', 'IFSC', 'required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            
            log_message('debug', 'Benificary Add Form Validation Error.');	
            $this->session->set_flashdata('system_message_error', lang('CHK_FIELDS'));
            $this->benificary();
        } 
        else {
            

        	// check account number already exits or not
        	$chk_account_no = $this->db->get_where('user_benificary',array('user_id'=>$account_id,'account_no'=>$post['account_number'],'status'=>2))->num_rows();
        	if($chk_account_no)
        	{
        		log_message('debug', 'Benificary Add Account Number Already Registered.');	
        		$this->Az->redirect('member/wallet/benificary', 'system_message_error',lang('BENIFICARY_ALREADY_ADDED_ERROR'));
        	}

            // save active request
            $response = $this->Withdraw_model->save_benificary($post,$account_id);

            log_message('debug', 'Benificary Add Final API Response - '.json_encode($response));	

            if($response['status'])
            {
            	$this->Az->redirect('member/wallet/benificary', 'system_message_error',lang('BENIFICARY_SUCCESS'));
        	}
        	else
        	{
        		$this->Az->redirect('member/wallet/benificary', 'system_message_error',sprintf(lang('BENIFICARY_FAILED'),$response['msg']));

        	}
            
             
        }
        
    }

    public function fundTransfer(){

		$loggedUser = $this->session->userdata('cranesmart_member_session');

        $memberDetail = $this->db->get_where('users',array('id'=>$loggedUser['id']))->row_array();

        $user_dmr_cusomer_id = $this->User->get_user_dmr_customer_id();
		if($user_dmr_cusomer_id == ''){
			$this->Az->redirect('member/wallet/active-withdrawal', 'system_message_error',lang('WITHDRAWAL_NOT_ACTIVE_ERROR'));
		}

		$user_kyc_status = $this->User->get_user_kyc_status();
		if($user_kyc_status != 3)
		{
			$this->Az->redirect('member/profile', 'system_message_error',lang('KYC_STATUS_FAILED'));
		}

		$account_id = $loggedUser['id'];

		// get Benificary list
		$benificaryList = $this->db->order_by('created','desc')->get_where('user_benificary',array('user_id'=>$account_id,'status'=>2))->result_array();

		// get account detail
		$accountDetail = $this->db->get_where('users',array('id'=>$account_id))->row_array();

		// get fund transfer percentage
		$get_fund_transfer_charge = $this->db->get_where('master_setting',array('id'=>1))->row_array();
		$fund_transfer_charge = isset($get_fund_transfer_charge['fund_transfer_charge']) ? $get_fund_transfer_charge['fund_transfer_charge'] : 0 ;

		$siteUrl = base_url();
		$data = array(
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'site_url' => $siteUrl,
            'memberDetail'=> $memberDetail,
            'benificaryList' => $benificaryList,
            'accountDetail' => $accountDetail,
            'fund_transfer_charge' => $fund_transfer_charge,
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getsystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'content_block' => 'member/fund-transfer'
        );
        $this->parser->parse('front/layout/column-1' , $data);
    }

    function amountCheck($num)
	{
		if ($num < 1)
		{
			$this->form_validation->set_message(
							'amountCheck',
							'The %s field must be grater than 1'
						);
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

    public function fundTransferAuth() {
        
		//get logged user info
        $loggedUser = $this->session->userdata('cranesmart_member_session');
        $account_id = $loggedUser['id'];

        $this->load->library('template');
        $siteUrl = site_url();
        $post = $this->input->post();
        log_message('debug', 'Fund Transfer Account ID - '.$account_id.' Post Data - '.json_encode($post));	
        

        //check for foem validation
        $this->load->library('form_validation');
        $this->form_validation->set_rules('transfer_to', 'Transfer To', 'required|xss_clean');     
        $this->form_validation->set_rules('amount', 'Amount', 'required|numeric|callback_amountCheck');
        if ($this->form_validation->run() == FALSE) {
            
            log_message('debug', 'Fund Transfer Form Validation Error.');	
            $this->session->set_flashdata('system_message_error', lang('CHK_FIELDS'));
            $this->fundTransfer();
        } 
        else {
            

        	// check benificary is valid or not 
        	$chk_benificary = $this->db->get_where('user_benificary',array('user_id'=>$account_id,'encode_ban_id'=>$post['transfer_to'],'status'=>2))->num_rows();
        	if(!$chk_benificary)
        	{
        		log_message('debug', 'Fund Transfer Benificary Error');	
        		$this->Az->redirect('member/wallet/fundTransfer', 'system_message_error',lang('FUND_TRANSFER_BENIFICARY_ERROR'));
        	}

        	// get account detail
			$accountDetail = $this->db->get_where('users',array('id'=>$account_id))->row_array();
			$wallet_balance = $accountDetail['wallet_balance'];


			if($post['amount'] > 5000)
			{
				log_message('debug', 'Fund Transfer Limit Error');	
        		$this->Az->redirect('member/wallet/fundTransfer', 'system_message_error',lang('FUND_TRANSFER_LIMIT_ERROR'));
			}

			// get fund transfer percentage
			$get_fund_transfer_charge = $this->db->get_where('master_setting',array('id'=>1))->row_array();
			$fund_transfer_charge = isset($get_fund_transfer_charge['fund_transfer_charge']) ? $get_fund_transfer_charge['fund_transfer_charge'] : 0 ;

			$total_wallet_deduct = $post['amount'];
			if($fund_transfer_charge)
			{
				$charge_amount = round(($fund_transfer_charge/100)*$post['amount'],2);
				$total_wallet_deduct = $charge_amount + $post['amount'];
			}

        	// check account balance
        	if($wallet_balance < $total_wallet_deduct)
        	{
        		log_message('debug', 'Fund Transfer Low Balance Error');	
        		$this->Az->redirect('member/wallet/fundTransfer', 'system_message_error',lang('FUND_TRANSFER_WALLET_ERROR'));
        	}

        	// get today total transfer amount
			$today_date = date('Y-m-d');
			$get_today_amount = $this->db->query("select sum(transfer_amount) as total_amount from tbl_user_fund_transfer where user_id = '$account_id' AND status IN (2,3) AND DATE(created) = '$today_date'")->row_array();
			$today_amount = isset($get_today_amount['total_amount']) ? $get_today_amount['total_amount'] : 0 ;

			$final_today_amount = $today_amount + $post['amount'];
			if($final_today_amount > 5000)
			{
				log_message('debug', 'Fund Transfer Today '.date('d-m-Y').' Limit Error');	
        		$this->Az->redirect('member/wallet/fundTransfer', 'system_message_error',lang('FUND_TRANSFER_DAILY_LIMIT_ERROR'));
			}


            // save fund transfer request
            $response = $this->Withdraw_model->save_fund_transfer_request($post,$account_id);

            log_message('debug', 'Transfer Fund Final API Response - '.json_encode($response));	

            if($response['status'])
            {
            	$this->Az->redirect('member/wallet/transferOTP/'.$response['encode_transaction_id'], 'system_message_error',lang('FUND_TRANSFER_OTP_SUCCESS'));
        	}
        	else
        	{
        		$this->Az->redirect('member/wallet/benificary', 'system_message_error',sprintf(lang('BENIFICARY_FAILED'),$response['msg']));

        	}
            
             
        }
        
    }


    public function transferOTP($encode_transaction_id = ''){

		$loggedUser = $this->session->userdata('cranesmart_member_session');

        $memberDetail = $this->db->get_where('users',array('id'=>$loggedUser['id']))->row_array();

        $user_dmr_cusomer_id = $this->User->get_user_dmr_customer_id();
		if($user_dmr_cusomer_id == ''){
			$this->Az->redirect('member/wallet/active-withdrawal', 'system_message_error',lang('WITHDRAWAL_NOT_ACTIVE_ERROR'));
		}

		$account_id = $loggedUser['id'];

		// check transaction id valid or not
		$chk_transaction_id = $this->db->get_where('user_fund_transfer',array('user_id'=>$account_id,'encode_transaction_id'=>$encode_transaction_id,'otp_status'=>0))->row_array();
		if(!$chk_transaction_id)
		{
			$this->Az->redirect('member/wallet/fundTransfer', 'system_message_error',lang('UPGRADE_FAILED'));
		}


		$siteUrl = base_url();
		$data = array(
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'site_url' => $siteUrl,
            'memberDetail'=> $memberDetail,
            'encode_transaction_id' => $encode_transaction_id,
            'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getsystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'content_block' => 'member/fund-transfer-otp'
        );
        $this->parser->parse('front/layout/column-1' , $data);
    }

    public function transferOTPAuth() {
        
		//get logged user info
        $loggedUser = $this->session->userdata('cranesmart_member_session');
        $account_id = $loggedUser['id'];

        $this->load->library('template');
        $siteUrl = site_url();
        $post = $this->input->post();
        $encode_transaction_id = $post['encode_transaction_id'];
        log_message('debug', 'Fund Transfer Account ID - '.$account_id.' OTP Post Data - '.json_encode($post));	
        

        //check for foem validation
        $this->load->library('form_validation');
        $this->form_validation->set_rules('otp_code', 'OTP Code', 'required|xss_clean');     
        if ($this->form_validation->run() == FALSE) {
            
            log_message('debug', 'Fund Transfer OTP Form Validation Error.');	
            $this->session->set_flashdata('system_message_error', lang('CHK_FIELDS'));
            $this->transferOTP($encode_transaction_id);
        } 
        else {
            

        	// check transaction id valid or not
			$chk_transaction_id = $this->db->get_where('user_fund_transfer',array('user_id'=>$account_id,'encode_transaction_id'=>$encode_transaction_id,'otp_status'=>0))->row_array();
			if(!$chk_transaction_id)
			{
				log_message('debug', 'Fund Transfer OTP Transaction ID is wrong.');	
				$this->Az->redirect('member/wallet/fundTransfer', 'system_message_error',lang('UPGRADE_FAILED'));
			}

			// check OTP Code
			$chk_otp = $this->db->get_where('users_otp',array('otp_code'=>$post['otp_code'],'encode_transaction_id'=>$encode_transaction_id,'status'=>0,'is_fund_transfer'=>1))->row_array();
			if(!$chk_otp)
			{
				log_message('debug', 'Fund Transfer OTP is wrong.');	
				$this->Az->redirect('member/wallet/transferOTP/'.$encode_transaction_id, 'system_message_error',lang('FUND_TRANSFER_OTP_FAILED'));
			}

			// get transfer data
			$get_transfer_data = $this->db->get_where('user_fund_transfer',array('user_id'=>$account_id,'encode_transaction_id'=>$encode_transaction_id))->row_array();
			
			$transfer_amount = isset($get_transfer_data['transfer_amount']) ? $get_transfer_data['transfer_amount'] : 0 ;

        	// get account detail
			$accountDetail = $this->db->get_where('users',array('id'=>$account_id))->row_array();
			$wallet_balance = $accountDetail['wallet_balance'];

			// get fund transfer percentage
			$get_fund_transfer_charge = $this->db->get_where('master_setting',array('id'=>1))->row_array();
			$fund_transfer_charge = isset($get_fund_transfer_charge['fund_transfer_charge']) ? $get_fund_transfer_charge['fund_transfer_charge'] : 0 ;

			$total_wallet_deduct = $transfer_amount;
			if($fund_transfer_charge)
			{
				$charge_amount = round(($fund_transfer_charge/100)*$transfer_amount,2);
				$total_wallet_deduct = $charge_amount + $transfer_amount;
			}
			
			if($transfer_amount > 5000)
			{
				log_message('debug', 'Fund Transfer Limit Error');	
        		$this->Az->redirect('member/wallet/fundTransfer', 'system_message_error',lang('FUND_TRANSFER_LIMIT_ERROR'));
			}

        	// check account balance
        	if($wallet_balance < $total_wallet_deduct)
        	{
        		log_message('debug', 'Fund Transfer Low Balance Error');	
        		$this->Az->redirect('member/wallet/fundTransfer', 'system_message_error',lang('FUND_TRANSFER_WALLET_ERROR'));
        	}

			// get today total transfer amount
			$today_date = date('Y-m-d');
			$get_today_amount = $this->db->query("select sum(transfer_amount) as total_amount from tbl_user_fund_transfer where user_id = '$account_id' AND status IN (2,3) AND DATE(created) = '$today_date'")->row_array();
			$today_amount = isset($get_today_amount['total_amount']) ? $get_today_amount['total_amount'] : 0 ;

			$final_today_amount = $today_amount + $transfer_amount;
			if($final_today_amount > 5000)
			{
				log_message('debug', 'Fund Transfer Today '.date('d-m-Y').' Limit Error');	
        		$this->Az->redirect('member/wallet/fundTransfer', 'system_message_error',lang('FUND_TRANSFER_DAILY_LIMIT_ERROR'));
			}


        	// update OTP status
			$this->db->where('otp_code',$post['otp_code']);
			$this->db->where('encode_transaction_id',$encode_transaction_id);
			$this->db->where('is_fund_transfer',1);
			$this->db->update('users_otp',array('status'=>1));

			log_message('debug', 'Fund Transfer OTP status updated.');	

            // save fund transfer request
            $response = $this->Withdraw_model->transfer_fund($get_transfer_data,$account_id,$encode_transaction_id);

            log_message('debug', 'Transfer Fund Final API Response - '.json_encode($response));	

            if($response['status'] == 1)
            {
            	$this->Az->redirect('member/wallet/fundTransfer', 'system_message_error',lang('FUND_TRANSFER_SUCCESS'));
        	}
        	elseif($response['status'] == 2)
            {
            	$this->Az->redirect('member/wallet/fundTransfer', 'system_message_error',lang('FUND_TRANSFER_PENDING'));
        	}
        	else
        	{
        		$this->Az->redirect('member/wallet/fundTransfer', 'system_message_error',lang('FUND_TRANSFER_FAILED'));

        	}
            
             
        }
        
    }


    public function transferReport(){
		$loggedUser = $this->session->userdata('cranesmart_member_session');
        
        $recharge = $this->db->select('user_fund_transfer.*,user_benificary.account_holder_name,user_benificary.account_no')->join('user_benificary','user_benificary.id = user_fund_transfer.to_ben_id')->order_by('user_fund_transfer.created','desc')->where_in('user_fund_transfer.status',array(2,3,4))->get_where('user_fund_transfer',array('user_fund_transfer.user_id'=>$loggedUser['id']))->result_array();
        
        $user_kyc_status = $this->User->get_user_kyc_status();
		if($user_kyc_status != 3)
		{
			$this->Az->redirect('member/profile', 'system_message_error',lang('KYC_STATUS_FAILED'));
		}

		$siteUrl = base_url();
		$data = array(
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'site_url' => $siteUrl,
            'recharge' => $recharge, 
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getsystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'content_block' => 'member/transfer-report'
        );
        $this->parser->parse('front/layout/column-1' , $data);
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
	
	
}
/* End of file login.php */
/* Location: ./application/controllers/login.php */