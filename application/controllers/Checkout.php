<?php
if(!defined('BASEPATH'))
    exit('No direct scrip access allowed');

/*
 * login Register controller for Frontend
 * 
 * this controller user for login, register, logout, forgot password, reset password
 * @author trilok
 */

class Checkout extends CI_Controller{

    public function __construct() {
        parent::__construct();
        $this->lang->load('admin/dashboard', 'english');
        $this->lang->load('front/message', 'english');
        $this->lang->load('front_common', 'english');
		$this->load->model('front/Checkout_model');
		if(!$this->session->userdata('cranesmart_vendor_session') && !$this->session->userdata('cranesmart_member_session')){
			$this->session->set_flashdata('message_error', lang('COMMON_ACCESS_DENIED'));
			redirect('login');
		}
    }
	
	
	public function index(){
		
		// get country list
		$countryList = $this->db->order_by('name','asc')->get('countries')->result_array();
		
		// get state list
		$stateList = $this->db->order_by('name','asc')->get_where('states',array('country_code_char2'=>'IN'))->result_array();
		
		// get user address list
		$account_id = $this->User->get_logged_user_account_id();
		
		$addressList = $this->db->select('user_address.*,states.name as state_name,countries.name as country_name')->join('states','states.id = user_address.state','left')->join('countries','countries.id = user_address.country','left')->get_where('user_address',array('userID'=>$account_id))->result_array();
		
		$siteUrl = base_url();
		$data = array(
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'site_url' => $siteUrl,
			'countryList' => $countryList,
			'stateList' => $stateList,
			'addressList' => $addressList,
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getsystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'content_block' => 'checkout'
        );
        $this->parser->parse('front/layout/column-2' , $data);
    }
	
	public function addAuth()
	{
		
		$post = $this->input->post();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Name', 'required|xss_clean');
		$this->form_validation->set_rules('address_line_1', 'Address', 'required|xss_clean');
		$this->form_validation->set_rules('address_line_2', 'Address', 'xss_clean');
		$this->form_validation->set_rules('city', 'City', 'required|xss_clean');
		$this->form_validation->set_rules('postal_code', 'Zip/Postal Code', 'required|xss_clean');
		$this->form_validation->set_rules('phone_number', 'Phone Number', 'required|xss_clean|min_length[10]');
		$this->form_validation->set_rules('state', 'State', 'required|xss_clean');
		$this->form_validation->set_rules('country', 'Country', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			
			$this->index();
		}
		else
		{
			// update organizer detail
			$address_id = $this->Checkout_model->save_user_address($post);
			$this->Az->redirect('checkout/review/'.$address_id, 'system_message_error',lang('CHECKOUT_ADDRESS_SAVE_SUCCESS'));
		}
		
	}
	
	public function getAddressData($recordID = 0)
	{
		$response = array();
		// get user address list
		$account_id = $this->User->get_logged_user_account_id();
		$addressList = $this->db->get_where('user_address',array('id'=>$recordID,'userID'=>$account_id))->row_array();
		if($addressList)
		{
			$response = array(
				'status' => 1,
				'name' => $addressList['name'],
				'phone_number' => $addressList['phone_number'],
				'address_1' => $addressList['address_1'],
				'address_2' => $addressList['address_2'],
				'city' => $addressList['city'],
				'country' => $addressList['country'],
				'state' => $addressList['state'],
				'zip_code' => $addressList['zip_code'],
			);
		}
		else
		{
			$this->session->set_flashdata('system_message_error', lang('DB_ERROR'));
			$response = array(
				'status' => 0,
				'msg' => 'Something Wrong'
			);
		}
		echo json_encode($response);
	}
	
	public function updateCheckoutAdd()
	{
		$response = array();
		$post = $this->input->post();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Name', 'required|xss_clean');
		$this->form_validation->set_rules('address_line_1', 'Address', 'required|xss_clean');
		$this->form_validation->set_rules('address_line_2', 'Address', 'xss_clean');
		$this->form_validation->set_rules('city', 'City', 'required|xss_clean');
		$this->form_validation->set_rules('postal_code', 'Zip/Postal Code', 'required|xss_clean');
		$this->form_validation->set_rules('phone_number', 'Phone Number', 'required|xss_clean|min_length[10]');
		$this->form_validation->set_rules('state', 'State Name', 'required|xss_clean');
		$this->form_validation->set_rules('country', 'Country', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			
			$response = array(
				'status' => 0,
				'msg' => validation_errors()
			);
		}
		else
		{
			// update organizer detail
			$this->Checkout_model->update_user_address($post);
			$this->session->set_flashdata('system_message_error', lang('CHECKOUT_ADDRESS_SAVE_SUCCESS'));
			$response = array(
				'status' => 1,
				'msg' => 'Success'
			);
		}
		echo json_encode($response);
	}
	
	public function deleteAddress($recordID = 0)
	{
		$response = array();
		// get user address list
		$account_id = $this->User->get_logged_user_account_id();
		$chkAddress = $this->db->get_where('user_address',array('id'=>$recordID,'userID'=>$account_id))->num_rows();
		if($chkAddress)
		{
			$this->db->where('id',$recordID);
			$this->db->where('userID',$account_id);
			$this->db->delete('user_address');
		
			$this->session->set_flashdata('system_message_error', lang('CHECKOUT_ADDRESS_DELETE_SUCCESS'));
			$response = array(
				'status' => 1,
				'msg' => 'Success'
			);
		}
		else
		{
			$this->session->set_flashdata('system_message_error', lang('DB_ERROR'));
			$response = array(
				'status' => 0,
				'msg' => 'Something Wrong'
			);
		}
		echo json_encode($response);
	}
	
	public function review($address_id = 0){
		
		$account_id = $this->User->get_logged_user_account_id();
		
		// check address valid or not
		$chk_address = $this->db->get_where('user_address',array('id'=>$address_id,'userID'=>$account_id))->num_rows();
		if(!$chk_address)
		{
			$this->Az->redirect('checkout', 'system_message_error',lang('DB_ERROR'));
		}
		
		$cartProductList = $this->User->get_cart_temp_data();
		
		if(!$cartProductList)
		{
			$this->Az->redirect('checkout/error', 'system_message_error','');
		}
		
		// get address data
		$addressData = $this->db->select('user_address.*,states.name as state_name,countries.name as country_name')->join('states','states.id = user_address.state','left')->join('countries','countries.id = user_address.country','left')->get_where('user_address',array('user_address.id'=>$address_id,'user_address.userID'=>$account_id))->row_array();
		
		$siteUrl = base_url();
		$data = array(
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'site_url' => $siteUrl,
			'cartProductList' => $cartProductList,
			'addressData' => $addressData,
			'address_id' => $address_id,
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getsystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'content_block' => 'review'
        );
        $this->parser->parse('front/layout/column-2' , $data);
    }
	
	public function orderAuth($address_id = 0){
		
		$account_id = $this->User->get_logged_user_account_id();
		
		$siteUrl = base_url();

		// check address valid or not
		$chk_address = $this->db->get_where('user_address',array('id'=>$address_id,'userID'=>$account_id))->num_rows();
		if(!$chk_address)
		{
			$this->Az->redirect('checkout', 'system_message_error',lang('DB_ERROR'));
		}
		
		$cartProductList = $this->User->get_cart_temp_data();
		
		if(!$cartProductList)
		{
			$this->Az->redirect('checkout/error', 'system_message_error','');
		}
		
		
		// save order data
		$response = $this->Checkout_model->save_order($cartProductList,$address_id,$account_id);
		$encoded_order_id = $response[0];
		$amount = $response[1];
		$order_display_id = $response[2];

		$chk_wallet_balance =$this->db->get_where('users',array('id'=>$account_id))->row_array();
		$wallet_balance = isset($chk_wallet_balance['wallet_balance']) ? $chk_wallet_balance['wallet_balance'] : 0;
		if($amount <= $wallet_balance)
		{
			$before_balance = $wallet_balance;
			$deduct_amount = $amount;
			$after_balance = $before_balance - $deduct_amount;
			$wallet_data = array(
				'member_id'           => $account_id,    
				'before_balance'      => $before_balance,
				'amount'              => $deduct_amount,  
				'after_balance'       => $after_balance,      
				'status'              => 1,
				'type'                => 2,      
				'wallet_type'		  => 1,
				'created'             => date('Y-m-d H:i:s'),      
				'credited_by'         => $account_id,
				'description'         => 'Order # '.$order_display_id.' Purchase'
			);

			$this->db->insert('member_wallet',$wallet_data);

			$userData = array(
				'wallet_balance'=>$after_balance,
				'updated' => date('Y-m-d H:i:s')
			);
			$this->db->where('id',$account_id);
			$this->db->update('users',$userData);

			// update order status

			$orderData = array(
				'payment_status'=>2
			);
			$this->db->where('customer_id',$account_id);
			$this->db->where('encoded_order_id',$encoded_order_id);
			$this->db->update('orders',$orderData);

			$this->Az->redirect('checkout/success/'.$encoded_order_id, 'system_message_error',lang('DB_ERROR'));
		}
		else
		{

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
			  $posted['productinfo'] = 'Cranesmart Product Purchase';
			  $posted['firstname'] = $chk_wallet_balance['name'];
			  $posted['email'] = $chk_wallet_balance['email'];
			  $posted['phone'] = $chk_wallet_balance['mobile'];
			  $surl = $siteUrl.'checkout/success/'.$encoded_order_id;
			  $furl = $siteUrl.'checkout/failed/'.$encoded_order_id;
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
	
	public function success($encoded_order_id = ''){
		
		$account_id = $this->User->get_logged_user_account_id();
		
		// check order id valid or not
		$chk_address = $this->db->get_where('orders',array('encoded_order_id'=>$encoded_order_id))->num_rows();
		if(!$chk_address)
		{
			$this->Az->redirect('checkout', 'system_message_error',lang('DB_ERROR'));
		}

		$status=isset($_POST["status"])?$_POST["status"]:'';
		$amount=isset($_POST["amount"])?$_POST["amount"]:0;
		$txnid=isset($_POST["txnid"])?$_POST["txnid"]:'';
        
		if(!$status && !$amount && !$txnid)
	    {
			$this->Az->redirect('checkout', 'system_message_error',lang('TOPUP_FAILED'));
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

        $get_wallet_balance = $this->db->get_where('users',array('id'=>$account_id))->row_array();

        $get_order_id = $this->db->get_where('orders',array('encoded_order_id'=>$encoded_order_id))->row_array();
        $order_display_id = isset($get_order_id['order_display_id']) ? $get_order_id['order_display_id'] : '' ;
        $before_balance = $get_wallet_balance['wallet_balance'];
		$deduct_amount = $amount;
		$after_balance = $before_balance - $deduct_amount;
		$wallet_data = array(
			'member_id'           => $account_id,    
			'before_balance'      => $before_balance,
			'amount'              => $deduct_amount,  
			'after_balance'       => $after_balance,      
			'status'              => 1,
			'type'                => 2,      
			'wallet_type'		  => 1,
			'created'             => date('Y-m-d H:i:s'),      
			'credited_by'         => $account_id,
			'description'         => 'Order # '.$order_display_id.' Purchase'
		);

		$this->db->insert('member_wallet',$wallet_data);

		$userData = array(
			'wallet_balance'=>$after_balance,
			'updated' => date('Y-m-d H:i:s')
		);
		$this->db->where('id',$account_id);
		$this->db->update('users',$userData);

		// update order status

		$orderData = array(
			'payment_status'=>2
		);
		$this->db->where('customer_id',$account_id);
		$this->db->where('encoded_order_id',$encoded_order_id);
		$this->db->update('orders',$orderData);
		
		$get_order_data = $this->db->select('orders.*,user_address.phone_number')->join('user_address','user_address.id = orders.address_id')->get_where('orders',array('encoded_order_id'=>$encoded_order_id))->row_array();
		
		$order_display_id = $get_order_data['order_display_id'];
		$phone_number = $get_order_data['phone_number'];
		
		$siteUrl = base_url();
		$data = array(
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'site_url' => $siteUrl,
			'order_display_id'  => $order_display_id,
			'phone_number'  => $phone_number,
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getsystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'content_block' => 'order-success'
        );
        $this->parser->parse('front/layout/column-2' , $data);
    }

    public function failed($encoded_order_id = ''){
		
		$account_id = $this->User->get_logged_user_account_id();
		
		// check order id valid or not
		$chk_address = $this->db->get_where('orders',array('encoded_order_id'=>$encoded_order_id))->num_rows();
		if(!$chk_address)
		{
			$this->Az->redirect('checkout', 'system_message_error',lang('DB_ERROR'));
		}

		$status=isset($_POST["status"])?$_POST["status"]:'';
		$amount=isset($_POST["amount"])?$_POST["amount"]:0;
		$txnid=isset($_POST["txnid"])?$_POST["txnid"]:'';
        
		if(!$status && !$amount && !$txnid)
	    {
			$this->Az->redirect('checkout', 'system_message_error',lang('TOPUP_FAILED'));
	    }

	    $this->db->where('userID',$account_id);
		$this->db->where('orderID',$_POST["txnid"]);
		$this->db->update('payment_request',array('status'=>3));
		
		// update order status

		$orderData = array(
			'payment_status'=>3
		);
		$this->db->where('customer_id',$account_id);
		$this->db->where('encoded_order_id',$encoded_order_id);
		$this->db->update('orders',$orderData);
		
		
		$siteUrl = base_url();
		$data = array(
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'site_url' => $siteUrl,
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getsystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'content_block' => 'order-failed'
        );
        $this->parser->parse('front/layout/column-2' , $data);
    }
	
	public function error(){
		
		$account_id = $this->User->get_logged_user_account_id();
		
		$siteUrl = base_url();
		$data = array(
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'site_url' => $siteUrl,
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getsystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'content_block' => 'cart-error'
        );
        $this->parser->parse('front/layout/column-2' , $data);
    }
	
	
}
/* End of file login.php */
/* Location: ./application/controllers/login.php */