<?php
if(!defined('BASEPATH'))
    exit('No direct scrip access allowed');

/*
 * login Register controller for Frontend
 * 
 * this controller user for login, register, logout, forgot password, reset password
 * @author trilok
 */

class Orders extends CI_Controller{

    public function __construct() {
        parent::__construct();
        //load language
		
		$this->load->model('admin/Login_model');
		$this->load->model('member/Order_model');
        $this->lang->load('admin/dashboard', 'english');
        $this->lang->load('front_common' , 'english');
    }
	
	public function index(){
		
		$account_id = $this->User->get_logged_user_account_id();
		$orderData = $this->User->get_customer_order_data($account_id);
		
		$openorderData = $this->User->get_customer_order_data($account_id,1);
		
		$cancellorderData = $this->User->get_customer_order_data($account_id,4);
			


		$siteUrl = base_url();
		$data = array(
            'meta_title' => "Cranesmart",
            'meta_keywords' => "Cranesmart",
            'meta_description' => "Cranesmart",
            'site_url' => $siteUrl,
            'orderData' => $orderData,
            'openorderData'=>$openorderData,
            'cancellorderData'=>$cancellorderData,
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getsystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'content_block' => 'member/orders'
        );
        $this->parser->parse('front/layout/column-1' , $data);
    }
	
	
	
	public function detail($encoded_order_id = ''){
		
		$account_id = $this->User->get_logged_user_account_id();
		
		// check order id valid or not
		$chk_address = $this->db->get_where('orders',array('encoded_order_id'=>$encoded_order_id))->num_rows();
		if(!$chk_address)
		{
			$this->Az->redirect('customer/orders', 'system_message_error',lang('DB_ERROR'));
		}
		
		$orderData = $this->User->get_customer_current_order_data($account_id,$encoded_order_id);
		
		$siteUrl = base_url();
		$data = array(
            'meta_title' => "Cranesmart",
            'meta_keywords' => "Cranesmart",
            'meta_description' => "Cranesmart",
            'site_url' => $siteUrl,
            'orderData' => $orderData,
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getsystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'content_block' => 'member/orders-detail'
        );
        $this->parser->parse('front/layout/column-1' , $data);
    }

	
	public function invoice($encoded_order_id = ''){
		
		$account_id = $this->User->get_logged_user_account_id();
		// check order id valid or not
		$chk_address = $this->db->get_where('orders',array('encoded_order_id'=>$encoded_order_id))->num_rows();
		if(!$chk_address)
		{
			$this->Az->redirect('customer/orders', 'system_message_error',lang('DB_ERROR'));
		}
		
		$orderData = $this->User->get_customer_current_order_data($account_id,$encoded_order_id);
		
		// GET COMPANY DATA
		$companyData = $this->db->select('address,company_name,pan_number,gst_number')->get_where('site_settings',array('id'=>1))->row_array();
		
		$order_id = isset($orderData[0]['id']) ? $orderData[0]['id'] : 0 ;
		// get order invoice data
		$invoiceData = $this->db->select('*')->get_where('order_invoice',array('order_id'=>$order_id,'customer_id'=>$account_id))->row_array();
		
		
		
		
		$siteUrl = base_url();
		$data = array(
            'meta_title' => "Cranesmart",
            'meta_keywords' => "Cranesmart",
            'meta_description' => "Cranesmart",
            'site_url' => $siteUrl,
            'orderData' => $orderData,
            'companyData' => $companyData,
            'invoiceData' => $invoiceData,
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getsystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'content_block' => 'customer/order-invoice'
        );
        $this->parser->parse('front/layout/column-3' , $data);
    }
	
	
	public function feedback($encoded_order_id = '', $product_id = 0){
		
		$account_id = $this->User->get_logged_user_account_id();
		// check order id valid or not
		$chk_address = $this->db->get_where('orders',array('encoded_order_id'=>$encoded_order_id))->num_rows();
		if(!$chk_address)
		{
			$this->Az->redirect('customer/orders', 'system_message_error',lang('DB_ERROR'));
		}
		
		$orderData = $this->User->get_customer_current_order_data($account_id,$encoded_order_id);
		
		$order_id = isset($orderData[0]['id']) ? $orderData[0]['id'] : 0 ;
		// check product id valid or not
		$chk_product = $this->db->get_where('order_item_summary',array('order_id'=>$order_id,'customer_id'=>$account_id,'product_id'=>$product_id))->num_rows();
		if(!$chk_product)
		{
			$this->Az->redirect('customer/orders', 'system_message_error',lang('DB_ERROR'));
		}
		
		// get vendor name
		$get_vendor_name = $this->db->select('users.name as vendor_name')->join('users','users.id = order_item_summary.vendor_id')->get_where('order_item_summary',array('order_id'=>$order_id,'customer_id'=>$account_id,'product_id'=>$product_id))->row_array();
		$vendor_name = isset($get_vendor_name['vendor_name']) ? $get_vendor_name['vendor_name'] : '';
		
		
		$siteUrl = base_url();
		$data = array(
            'meta_title' => "Cranesmart",
            'meta_keywords' => "Cranesmart",
            'meta_description' => "Cranesmart",
            'site_url' => $siteUrl,
            'orderData' => $orderData,
            'vendor_name' => $vendor_name,
            'encoded_order_id' => $encoded_order_id,
            'product_id' => $product_id,
            'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getsystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'content_block' => 'customer/seller-review'
        );
        $this->parser->parse('front/layout/column-1' , $data);
    }
	
	public function feedbackAuth()
	{
		$post = $this->input->post();
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('encoded_order_id', 'encoded_order_id', 'required|xss_clean');
		$this->form_validation->set_rules('product_id', 'product_id', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			
			$this->feedback($post['encoded_order_id'],$post['product_id']);
		}
		else
		{
			$encoded_order_id = $post['encoded_order_id'];
			$product_id = $post['product_id'];
			$rating = $post['rating'];
			
			if($rating < 1 || $rating > 5)
			{
				$this->Az->redirect('customer/orders/feedback/'.$encoded_order_id.'/'.$product_id, 'system_message_error',lang('FEEDBACK_RATING_VALID_ERROR'));
			}
			
			$account_id = $this->User->get_logged_user_account_id();
			// check order id valid or not
			$chk_address = $this->db->get_where('orders',array('encoded_order_id'=>$encoded_order_id))->num_rows();
			if(!$chk_address)
			{
				$this->Az->redirect('customer/orders', 'system_message_error',lang('DB_ERROR'));
			}
			
			$orderData = $this->User->get_customer_current_order_data($account_id,$encoded_order_id);
			
			$order_id = isset($orderData[0]['id']) ? $orderData[0]['id'] : 0 ;
			// check product id valid or not
			$chk_product = $this->db->get_where('order_item_summary',array('order_id'=>$order_id,'customer_id'=>$account_id,'product_id'=>$product_id))->num_rows();
			if(!$chk_product)
			{
				$this->Az->redirect('customer/orders', 'system_message_error',lang('DB_ERROR'));
			}
			
			$this->Order_model->save_seller_feedback($post,$account_id,$order_id);
			
			$this->Az->redirect('customer/orders', 'system_message_error',lang('FEEDBACK_RATING_SUCCESS'));
		}
		
	}
	
	public function review($encoded_order_id = '', $product_id = 0){
		
		$account_id = $this->User->get_logged_user_account_id();
		// check order id valid or not
		$chk_address = $this->db->get_where('orders',array('encoded_order_id'=>$encoded_order_id))->num_rows();
		if(!$chk_address)
		{
			$this->Az->redirect('customer/orders', 'system_message_error',lang('DB_ERROR'));
		}
		
		$orderData = $this->User->get_customer_current_order_data($account_id,$encoded_order_id);
		
		$order_id = isset($orderData[0]['id']) ? $orderData[0]['id'] : 0 ;
		// check product id valid or not
		$chk_product = $this->db->get_where('order_item_summary',array('order_id'=>$order_id,'customer_id'=>$account_id,'product_id'=>$product_id))->num_rows();
		if(!$chk_product)
		{
			$this->Az->redirect('customer/orders', 'system_message_error',lang('DB_ERROR'));
		}
		
		// get vendor name
		$get_vendor_name = $this->db->select('users.name as vendor_name')->join('users','users.id = order_item_summary.vendor_id')->get_where('order_item_summary',array('order_id'=>$order_id,'customer_id'=>$account_id,'product_id'=>$product_id))->row_array();
		$vendor_name = isset($get_vendor_name['vendor_name']) ? $get_vendor_name['vendor_name'] : '';
		
		$productData = $this->User->get_current_product_data($product_id);
		
		
		
		$siteUrl = base_url();
		$data = array(
            'meta_title' => "Cranesmart",
            'meta_keywords' => "Cranesmart",
            'meta_description' => "Cranesmart",
            'site_url' => $siteUrl,
            'orderData' => $orderData,
            'productData' => $productData,
            'vendor_name' => $vendor_name,
            'encoded_order_id' => $encoded_order_id,
            'product_id' => $product_id,
            'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getsystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'content_block' => 'customer/product-review'
        );
        $this->parser->parse('front/layout/column-1' , $data);
    }
	
	public function reviewAuth()
	{
		$post = $this->input->post();
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('encoded_order_id', 'encoded_order_id', 'required|xss_clean');
		$this->form_validation->set_rules('product_id', 'product_id', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			
			$this->review($post['encoded_order_id'],$post['product_id']);
		}
		else
		{
			$encoded_order_id = $post['encoded_order_id'];
			$product_id = $post['product_id'];
			$rating = $post['rating'];
			
			if($rating < 1 || $rating > 5)
			{
				$this->Az->redirect('customer/orders/review/'.$encoded_order_id.'/'.$product_id, 'system_message_error',lang('FEEDBACK_RATING_VALID_ERROR'));
			}
			
			$account_id = $this->User->get_logged_user_account_id();
			// check order id valid or not
			$chk_address = $this->db->get_where('orders',array('encoded_order_id'=>$encoded_order_id))->num_rows();
			if(!$chk_address)
			{
				$this->Az->redirect('customer/orders', 'system_message_error',lang('DB_ERROR'));
			}
			
			$orderData = $this->User->get_customer_current_order_data($account_id,$encoded_order_id);
			
			$order_id = isset($orderData[0]['id']) ? $orderData[0]['id'] : 0 ;
			// check product id valid or not
			$chk_product = $this->db->get_where('order_item_summary',array('order_id'=>$order_id,'customer_id'=>$account_id,'product_id'=>$product_id))->num_rows();
			if(!$chk_product)
			{
				$this->Az->redirect('customer/orders', 'system_message_error',lang('DB_ERROR'));
			}
			
			$this->Order_model->save_product_feedback($post,$account_id,$order_id);
			
			$this->Az->redirect('customer/orders', 'system_message_error',lang('FEEDBACK_RATING_SUCCESS'));
		}
		
	}
	
	
	
	
}


/* End of file login.php */
/* Location: ./application/controllers/login.php */