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

class Catalog_model extends CI_Model 
{ 

    public function __construct() 
    {
 		parent::__construct();
    }
    
	public function save_product_data($post)
	{
		$is_variation = 0;
		$variation_variable = '';
		$variation_attribute_id = array();
		$loggedUser = $this->User->getLoggedUser("cranesmart_seller_session");
		$account_id = $loggedUser['id'];
		$slug = url_title($post['product_name'], 'dash', true);
		$data = array(
			'account_id' => $account_id,
			'product_name' => $post['product_name'],
			'slug' => $slug,
			'sku' => $post['sku'],
			'price' => $post['price'],
			'special_price' => $post['special_price'],
			'special_price_from' => ($post['special_price_from']) ? date('Y-m-d',strtotime($post['special_price_from'])) : '',
			'special_price_to' => ($post['special_price_to']) ? date('Y-m-d',strtotime($post['special_price_to'])) : '',
			'weight' => $post['weight'],
			'weight_unit' => $post['weight_unit'],
			'visibility' => $post['product_visibility'],
			'quantity' => $post['quantity'],
			'stock_status' => $post['stock_status'],
			'image_token' => $post['token'],
			'attribute_set_id' => $post['attribute_set_id'],
			'is_variation' => $is_variation,
			'variation_variable' => $variation_variable,
			'short_description' => $post['short_description'],
			'description' => $post['description'],
			'instruction' => isset($post['instruction']) ? implode('|',$post['instruction']) : '',
			'status' => $post['status'],
			'approve_status' => 2,
			'created' => date('Y-m-d H:i:s')
		);
		$this->db->insert('products',$data);
		$product_id = $this->db->insert_id();
		
		
		
		// save product sku
		$product_sku_data = array(
			'account_id' => $account_id,
			'is_main_product' => 1,
			'product_id' => $product_id,
			'sku' => $post['sku'],
			'created' => date('Y-m-d H:i:s')
		);
		$this->db->insert('product_sku',$product_sku_data);
		
		
		
		
		
		// save product category
		if(isset($post['category_id']))
		{
			foreach($post['category_id'] as $catID)
			{
				$catData = array(
					'account_id' => $account_id,
					'product_id' => $product_id,
					'category_id' => $catID
				);
				$this->db->insert('product_category',$catData);
			}
		}
		
		// save product offer data
		$offer_start_date = ($post['offer_start_date']) ? date('Y-m-d',strtotime($post['offer_start_date'])) : '';
		$offer_end_date = ($post['offer_end_date']) ? date('Y-m-d',strtotime($post['offer_end_date'])) : '';
		$offer_code = $post['offer_code'];
		$offer_type = $post['offer_type'];
		$offer_type_value = $post['offer_type_value'];
		
		$offerData = array(
			'account_id' => $account_id,
			'product_id' => $product_id,
			'offer_start_date' => $offer_start_date,
			'offer_end_date' => $offer_end_date,
			'offer_code' => $offer_code,
			'offer_type' => $offer_type,
			'offer_type_value' => $offer_type_value,
			'created' => date('Y-m-d H:i:s')
		);
		$this->db->insert('product_offer',$offerData);
		
		
		// save product meta data
		$meta_title = $post['meta_title'];
		$meta_description = $post['meta_description'];
		$meta_keyword = $post['meta_keyword'];
		
		$metaData = array(
			'account_id' => $account_id,
			'product_id' => $product_id,
			'meta_title' => $meta_title,
			'meta_description' => $meta_description,
			'meta_keyword' => $meta_keyword,
			'created' => date('Y-m-d H:i:s')
		);
		$this->db->insert('product_meta_data',$metaData);
		
		// get all token images
		$imageList = $this->db->get_where('product_image_temp_data',array('token'=>$post['token'],'row_no IS NULL'))->result_array();
		if($imageList)
		{
			foreach($imageList as $imgList)
			{
				$image_id = $imgList['id'];
				$image_path = $imgList['image_path'];
				$file_name = $imgList['file_name'];
				$is_base = 0;
				$is_small = 0;
				$is_thumbnail = 0;
				$is_large = 0;
				if($imgList['type'] == 1)
				{
					$is_base = 1;
				}
				else{
					$is_large = 1;
				}
				
				$imageData = array(
					'account_id' => $account_id,
					'product_id' => $product_id,
					'is_base' => $is_base,
					'is_small' => $is_small,
					'is_thumbnail' => $is_thumbnail,
					'is_large' => $is_large,
					'image_path' => $image_path,
					'file_name' => $file_name,
				);
				$this->db->insert('product_images',$imageData);
			}
		}
		
		// save all attribute data
		$attribute_set_id = $post['attribute_set_id'];
		$attributeList = $this->db->select('attribute.*')->join('attribute','attribute.id = attribute_set_attributes.attribute_id')->get_where('attribute_set_attributes',array('attribute_set_id'=>$attribute_set_id))->result_array();
		if($attributeList)
		{
			foreach($attributeList as $list)
			{
				$attribute_id = $list['id'];
				$form_type = $list['form_type'];
				$is_input_box = $list['is_input_box'];
				
				if($form_type == 4)
				{
					$attribute_value = isset($post['attribute_'.$attribute_id]) ? $post['attribute_'.$attribute_id] : array();
					
					if($attribute_value)
					{
						foreach($attribute_value as $val){
							$attribute_data = array(
								'account_id' => $account_id,
								'product_id' => $product_id,
								'attribute_id' => $attribute_id,
								'attribute_value' => $val
							);
							$this->db->insert('product_attribute',$attribute_data);
						}
					}
				}
				elseif($form_type == 5)
				{
					$attribute_value = isset($post['attribute_'.$attribute_id]) ? $post['attribute_'.$attribute_id] : array();
					
					if($attribute_value)
					{
						foreach($attribute_value as $val){
							$attribute_data = array(
								'account_id' => $account_id,
								'product_id' => $product_id,
								'attribute_id' => $attribute_id,
								'attribute_value' => $val
							);
							$this->db->insert('product_attribute',$attribute_data);
						}
					}
				}
				else
				{
					$attribute_value = isset($post['attribute_'.$attribute_id]) ? $post['attribute_'.$attribute_id] : 0;
					$attribute_input_value = isset($post['attribute_value_'.$attribute_id]) ? $post['attribute_value_'.$attribute_id] : '';
					
					if($attribute_value)
					{
						$attribute_data = array(
							'account_id' => $account_id,
							'product_id' => $product_id,
							'attribute_id' => $attribute_id,
							'attribute_value' => $attribute_value,
							'attribute_input_value' => $attribute_input_value
						);
						$this->db->insert('product_attribute',$attribute_data);
					}
				}
			}
		}
		
		
		return true;
	
	}
	
	
	public function update_product_data($post)
	{
		$loggedUser = $this->User->getLoggedUser("cranesmart_seller_session");
		$account_id = $loggedUser['id'];
		$slug = url_title($post['product_name'], 'dash', true);
		$data = array(
			'product_name' => $post['product_name'],
			'slug' => $slug,
			'sku' => $post['sku'],
			'price' => $post['price'],
			'special_price' => $post['special_price'],
			'special_price_from' => ($post['special_price_from']) ? date('Y-m-d',strtotime($post['special_price_from'])) : '',
			'special_price_to' => ($post['special_price_to']) ? date('Y-m-d',strtotime($post['special_price_to'])) : '',
			'visibility' => $post['product_visibility'],
			'quantity' => $post['quantity'],
			'stock_status' => $post['stock_status'],
			'image_token' => $post['token'],
			'short_description' => $post['short_description'],
			'description' => $post['description'],
			'instruction' => isset($post['instruction']) ? implode('|',$post['instruction']) : '',
			'status' => $post['status'],
			'updated' => date('Y-m-d H:i:s')
		);
		$this->db->where('id',$post['product_id']);
		$this->db->where('account_id',$account_id);
		$this->db->update('products',$data);
		$product_id = $post['product_id'];
		
		
		// save product category
		if(isset($post['category_id']))
		{
			$this->db->where('account_id',$account_id);
			$this->db->where('product_id',$product_id);
			$this->db->delete('product_category');
			foreach($post['category_id'] as $catID)
			{
				$catData = array(
					'account_id' => $account_id,
					'product_id' => $product_id,
					'category_id' => $catID
				);
				$this->db->insert('product_category',$catData);
			}
		}
		
		// save product offer data
		$offer_start_date = ($post['offer_start_date']) ? date('Y-m-d',strtotime($post['offer_start_date'])) : '';
		$offer_end_date = ($post['offer_end_date']) ? date('Y-m-d',strtotime($post['offer_end_date'])) : '';
		$offer_code = $post['offer_code'];
		$offer_type = $post['offer_type'];
		$offer_type_value = $post['offer_type_value'];
		
		$offerData = array(
			'offer_start_date' => $offer_start_date,
			'offer_end_date' => $offer_end_date,
			'offer_code' => $offer_code,
			'offer_type' => $offer_type,
			'offer_type_value' => $offer_type_value,
			'created' => date('Y-m-d H:i:s')
		);
		$this->db->where('account_id',$account_id);
		$this->db->where('product_id',$product_id);
		$this->db->update('product_offer',$offerData);
		
		
		// save product meta data
		$meta_title = $post['meta_title'];
		$meta_description = $post['meta_description'];
		$meta_keyword = $post['meta_keyword'];
		
		$metaData = array(
			'meta_title' => $meta_title,
			'meta_description' => $meta_description,
			'meta_keyword' => $meta_keyword,
			'created' => date('Y-m-d H:i:s')
		);
		$this->db->where('account_id',$account_id);
		$this->db->where('product_id',$product_id);
		$this->db->update('product_meta_data',$metaData);
		
		// get all token images
		$imageList = $this->db->get_where('product_image_temp_data',array('token'=>$post['token'],'row_no IS NULL'))->result_array();
		if($imageList)
		{
			foreach($imageList as $imgList)
			{
				$image_id = $imgList['id'];
				$image_path = $imgList['image_path'];
				$file_name = $imgList['file_name'];
				$is_base = 0;
				$is_small = 0;
				$is_thumbnail = 0;
				$is_large = 0;
				if($imgList['type'] == 1)
				{
					$is_base = 1;
				}
				else{
					$is_large = 1;
				}
				
				$imageData = array(
					'account_id' => $account_id,
					'product_id' => $product_id,
					'is_base' => $is_base,
					'is_small' => $is_small,
					'is_thumbnail' => $is_thumbnail,
					'is_large' => $is_large,
					'image_path' => $image_path,
					'file_name' => $file_name,
				);
				$this->db->insert('product_images',$imageData);
			}
		}
		
		return true;
	
	}
	
}
?>