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

class Checkout_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->lang->load('front/message', 'english');
    }


    public function save_user_address($post)
    {
		$account_id = $this->User->get_logged_user_account_id();
    	$data = array(
			'userID' => $account_id,
			'name' => $post['name'],
			'phone_number' => $post['phone_number'],
			'address_1' => $post['address_line_1'],
			'address_2' => $post['address_line_2'],
			'city' => $post['city'],
			'country' => $post['country'],
			'state' => $post['state'],
			'zip_code' => $post['postal_code'],
			'created' => date('Y-m-d H:i:s')
		);
		$this->db->insert('user_address',$data);
		$address_id = $this->db->insert_id();
		return $address_id;
    }
	
	public function update_user_address($post)
    {
		$account_id = $this->User->get_logged_user_account_id();
    	$data = array(
			'name' => $post['name'],
			'phone_number' => $post['phone_number'],
			'address_1' => $post['address_line_1'],
			'address_2' => $post['address_line_2'],
			'city' => $post['city'],
			'country' => $post['country'],
			'state' => $post['state'],
			'zip_code' => $post['postal_code'],
			'updated' => date('Y-m-d H:i:s')
		);
		$this->db->where('id',$post['recordID']);
		$this->db->where('userID',$account_id);
		$this->db->update('user_address',$data);
		return true;
    }
	
	public function save_order($productData,$address_id,$account_id)
    {
		// get last order display id
		$order_id_data = $this->User->get_last_order_display_id();
		$order_display_id = $order_id_data['order_display_id'];
		$order_number = $order_id_data['order_number'];
		
		$total_item = count($productData);
		$total_item_price = 0;
		$total_base_price = 0;
		$tax_percentage = 0;
		foreach($productData as $cList){
			$product_price = $cList['price'] * $cList['qty'];
			$total_item_price+=$cList['price'] * $cList['qty'];
			
			// get total tax for this product
			$get_total_tax = $this->db->select('tax_rules.percentage')->join('tax_rules','tax_rules.id = products.tax_rule_id')->get_where('products',array('products.id'=>$cList['id'],'tax_rules.status'=>1))->row_array();
			$pro_tax_percentage = isset($get_total_tax['percentage']) ? $get_total_tax['percentage'] : 0 ;
			$tax_percentage+=$pro_tax_percentage;
			
			
			if($pro_tax_percentage)
			{
				// calculate product base price
				$tax_divide_amount = round((($pro_tax_percentage + 100)/100),2);
				$pro_base_price = round(($product_price/$tax_divide_amount),2);
				$total_base_price+=$pro_base_price;
			}
			else
			{
				$total_base_price+=$product_price;
			}
		}
		
		$discount_price = 0;
		$delivery_price = 0;
		
		$tax_amount = 0;
		if($tax_percentage)
		{
			$tax_amount = round((($tax_percentage/100)*$total_base_price),2);
		}
		
		$total_price = $total_base_price + $discount_price + $delivery_price + $tax_amount;
		
    	$data = array(
			'order_display_id' => $order_display_id,
			'order_number' => $order_number,
			'encoded_order_id' => do_hash($order_display_id),
			'customer_id' => $account_id,
			'address_id' => $address_id,
			'total_item' => $total_item,
			'total_item_price' => $total_item_price,
			'total_base_price' => $total_base_price,
			'discount_price' => $discount_price,
			'delivery_price' => $delivery_price,
			'tax_percentage' => $tax_percentage,
			'tax_amount' => $tax_amount,
			'total_price' => $total_price,
			'status' => 1,
			'created' => date('Y-m-d H:i:s')
		);
		$this->db->insert('orders',$data);
		$order_id = $this->db->insert_id();
		
		// save order item
		if($productData)
		{
			foreach($productData as $list)
			{
				$gst_percentage = 0;
				$is_variation = 0;
				$variation_pro_id = 0;
				
				// get total tax for this product
				$get_total_tax = $this->db->select('tax_rules.percentage')->join('tax_rules','tax_rules.id = products.tax_rule_id')->get_where('products',array('products.id'=>$list['id'],'tax_rules.status'=>1))->row_array();
				$pro_tax_percentage = isset($get_total_tax['percentage']) ? $get_total_tax['percentage'] : 0 ;
				$gst_percentage = $pro_tax_percentage;
				
				
				
				$product_base_price = $list['price'];
				if($gst_percentage){
					// calculate product base price
					$tax_divide_amount = round((($gst_percentage + 100)/100),2);
					$pro_base_price = round(($list['price']/$tax_divide_amount),2);
					$product_base_price = $pro_base_price;
				}
				
				$product_total_price = $product_base_price * $list['qty'];
				
				// get customer state
				$get_customer_state = $this->db->select('state')->get_where('user_address',array('id'=>$address_id,'userID'=>$account_id))->row_array();
				$customer_state_id = isset($get_customer_state['state']) ? ($get_customer_state['state']) ? $get_customer_state['state'] : 0 : 0 ;
				
				// get vendor state
				$get_vendor_state = $this->db->select('state_id')->get_where('users',array('id'=>$list['account_id']))->row_array();
				$vendor_state_id = isset($get_vendor_state['state_id']) ? ($get_vendor_state['state_id']) ? $get_vendor_state['state_id'] : 0 : 0 ;
				
				// check delivery is out of state or not
				$is_out_state = 0;
				if($customer_state_id && $vendor_state_id && $customer_state_id != $vendor_state_id)
				{
					$is_out_state = 1;
				}
				
				// calculate total GST amount
				$gst_amount = 0;
				if($gst_percentage)
				{
					$gst_amount = round((($gst_percentage/100)*$product_total_price),2);
				}
				$igst_percentage = 0;
				$igst_amount = 0;
				
				$sgst_percentage = 0;
				$sgst_amount = 0;
				
				$cgst_percentage = 0;
				$cgst_amount = 0;
				
				if($is_out_state)
				{
					$igst_percentage = $gst_percentage;
					$igst_amount = round((($gst_percentage/100)*$product_total_price),2);
				}
				else
				{
					$sgst_percentage = round(($gst_percentage/2),2);
					$sgst_amount = round((($sgst_percentage/100)*$product_total_price),2);
					
					$cgst_percentage = round(($gst_percentage/2),2);
					$cgst_amount = round((($cgst_percentage/100)*$product_total_price),2);
				}
				
				$gross_amount = $product_total_price + $gst_amount;
				
				$itemData = array(
					'order_id' => $order_id,
					'customer_id' => $account_id,
					'is_variation' => $is_variation,
					'variation_pro_id' => $variation_pro_id,
					'product_id' => $list['id'],
					'product_qty' => $list['qty'],
					'product_price' => $list['price'],
					'product_base_price' => $product_base_price,
					'product_total_price' => $product_total_price,
					'gst_percentage' => $gst_percentage,
					'gst_amount' => $gst_amount,
					'sgst_percentage' => $sgst_percentage,
					'sgst_amount' => $sgst_amount,
					'cgst_percentage' => $cgst_percentage,
					'cgst_amount' => $cgst_amount,
					'igst_percentage' => $igst_percentage,
					'igst_amount' => $igst_amount,
					'is_out_state' => $is_out_state,
					'gross_amount' => $gross_amount,
					'vendor_id' => $list['account_id']
				);
				$this->db->insert('order_item_summary',$itemData);
			}
		}
		
		// get last invoice display id
		$invoice_id_data = $this->User->get_last_invoice_display_id();
		$invoice_display_id = $invoice_id_data['invoice_display_id'];
		$invoice_number = $invoice_id_data['invoice_number'];
		
		$invoiceData = array(
			'invoice_display_id' => $invoice_display_id,
			'invoice_number' => $invoice_number,
			'order_id' => $order_id,
			'customer_id' => $account_id,
			'invoice_type' => 1,
			'status' => 3,
			'created' => date('Y-m-d H:i:s')
		);
		$this->db->insert('order_invoice',$invoiceData);
		
		// blank cart data
		$this->db->where('user_id',$account_id);
		$this->db->delete('cart_temp_data');
		
		return array(do_hash($order_display_id),$total_price,$order_display_id);
    }

	
	
	
}


/* end of file: az.php */
/* Location: ./application/models/az.php */