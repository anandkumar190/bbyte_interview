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

class Order_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->lang->load('front/message', 'english');
    }


    public function save_seller_feedback($post,$account_id,$order_id)
    {
		
		$get_product_vendor_id = $this->db->get_where('order_item_summary',array('order_id'=>$order_id,'customer_id'=>$account_id,'product_id'=>$post['product_id']))->row_array();
		
		$vendor_id = isset($get_product_vendor_id['vendor_id']) ? $get_product_vendor_id['vendor_id'] : 0 ;
		
    	$data = array(
			'type' => 1,
			'customer_id' => $account_id,
			'order_id' => $order_id,
			'product_id' => $post['product_id'],
			'vendor_id' => $vendor_id,
			'rating' => $post['rating'],
			'comment' => $post['comment'],
			'created' => date('Y-m-d H:i:s')
		);
		$this->db->insert('product_review',$data);
		$address_id = $this->db->insert_id();
		return $address_id;
    }
	
	public function save_product_feedback($post,$account_id,$order_id)
    {
		
		$get_product_vendor_id = $this->db->get_where('order_item_summary',array('order_id'=>$order_id,'customer_id'=>$account_id,'product_id'=>$post['product_id']))->row_array();
		
		$vendor_id = isset($get_product_vendor_id['vendor_id']) ? $get_product_vendor_id['vendor_id'] : 0 ;
		
    	$data = array(
			'type' => 2,
			'customer_id' => $account_id,
			'order_id' => $order_id,
			'product_id' => $post['product_id'],
			'vendor_id' => $vendor_id,
			'rating' => $post['rating'],
			'comment' => $post['comment'],
			'created' => date('Y-m-d H:i:s')
		);
		$this->db->insert('product_review',$data);
		$address_id = $this->db->insert_id();
		return $address_id;
    }
	
	
	
	
}


/* end of file: az.php */
/* Location: ./application/models/az.php */