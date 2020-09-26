<?php
if(!defined('BASEPATH'))
    exit('No direct scrip access allowed');

/*
 * login Register controller for Frontend
 * 
 * this controller user for login, register, logout, forgot password, reset password
 * @author trilok
 */

class Product extends CI_Controller{

    public function __construct() {
        parent::__construct();
        $this->lang->load('admin/dashboard', 'english');
        $this->lang->load('front/message', 'english');
        $this->lang->load('front_common', 'english');
    }
	
	
	public function index($slug = ''){
		
		$today_date = date('Y-m-d');
		
		$category_id = $this->User->get_category_sub_category_list($slug);
		
		if(!$category_id)
		{
			$this->Az->redirect('home', 'system_message_error','');
		}
		
		$get_category_data = $this->db->get_where('category',array('slug'=>$slug,'status'=>1))->row_array();
		$category_name = $get_category_data['title'];
		
		// product list
		$productList = $this->db->select('products.*')->join('product_category','product_category.product_id = products.id')->where_in('product_category.category_id',$category_id)->group_by('product_category.product_id')->get_where('products',array('products.status'=>1,'products.approve_status'=>2))->result_array();
		if($productList)
		{
			foreach($productList as $key=>$list)
			{
				// get product image
				$get_product_img = $this->db->select('image_path,file_name')->get_where('product_images',array('product_id'=>$list['id'],'is_base'=>1))->row_array();
				$product_img = isset($get_product_img['file_name']) ? 'media/product_images/thumbnail-180x180/'.$get_product_img['file_name'] : 'skin/front/images/product-default-img.png' ;
				
				$productList[$key]['product_img'] = $product_img;
				
				if($list['special_price'] && $list['special_price_to'] >= $today_date)
				{
					$productList[$key]['special_price_status'] = 1;
				}
				else
				{
					$productList[$key]['special_price_status'] = 0;
				}	
				
				
				
			}
		}
		
		
		
		$siteUrl = base_url();
		$data = array(
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'site_url' => $siteUrl,
			'productList' => $productList,
			'category_name' => $category_name,
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getsystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'content_block' => 'product-list'
        );
        $this->parser->parse('front/layout/column-2' , $data);
    }
	
	public function search(){
		
		$today_date = date('Y-m-d');
		
		$get = $this->input->get();
		$keyword = isset($get['keyword']) ? $get['keyword'] : '';
		
				
		// product list
		$productList = $this->db->query("SELECT a.* FROM tbl_products as a INNER JOIN tbl_product_category as b ON b.product_id = a.id WHERE (b.category_id IN (SELECT id FROM tbl_category as a WHERE a.title LIKE '%".$keyword."%') OR a.product_name LIKE '%".$keyword."%') GROUP BY b.product_id")->result_array();
		if($productList)
		{
			foreach($productList as $key=>$list)
			{
				// get product image
				$get_product_img = $this->db->select('image_path,file_name')->get_where('product_images',array('product_id'=>$list['id'],'is_base'=>1))->row_array();
				$product_img = isset($get_product_img['file_name']) ? 'media/product_images/thumbnail-180x180/'.$get_product_img['file_name'] : 'skin/front/images/product-default-img.png' ;
				
				$productList[$key]['product_img'] = $product_img;
				
				if($list['special_price'] && $list['special_price_to'] >= $today_date)
				{
					$productList[$key]['special_price_status'] = 1;
				}
				else
				{
					$productList[$key]['special_price_status'] = 0;
				}	
				
				
				
			}
		}
		
		
		
		$siteUrl = base_url();
		$data = array(
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'site_url' => $siteUrl,
			'productList' => $productList,
			'keyword' => $keyword,
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getsystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'content_block' => 'product-result'
        );
        $this->parser->parse('front/layout/column-2' , $data);
    }
	
	
	public function detail($slug = '',$is_variation = '',$variant_pro_id = 0){
		
		$today_date = date('Y-m-d');
		
		// chk product slug
		$chk_product = $this->db->get_where('products',array('status'=>1,'slug'=>$slug))->num_rows();
		if(!$chk_product)
		{
			$this->Az->redirect('product', 'system_message_error','');
		}
		
		// product list
		$productList = $this->db->get_where('products',array('status'=>1,'slug'=>$slug))->row_array();
		
		
		$productID = isset($productList['id']) ? $productList['id'] : 0 ;
		
		$variation_status = 0;
		
		
		// get product image
		$get_product_img = $this->db->select('image_path,file_name')->get_where('product_images',array('product_id'=>$productID,'is_base'=>1))->row_array();
		$product_img = isset($get_product_img['file_name']) ? 'media/product_images/thumbnail-400x400/'.$get_product_img['file_name'] : 'skin/front/images/product-default-img.png' ;
		
		$productList['base_img'] = $product_img;
		$productList['base_img_name'] = isset($get_product_img['file_name']) ? $get_product_img['file_name'] : '';
		
		// get product all image
		$get_product_all_img = $this->db->select('file_name')->get_where('product_images',array('product_id'=>$productID,'is_large'=>1))->result_array();
		
		$productList['all_img'] = $get_product_all_img;
		
		if($productList['special_price'] && $productList['special_price_to'] >= $today_date)
		{
			$productList['special_price_status'] = 1;
		}
		else
		{
			$productList['special_price_status'] = 0;
		}
		
		
			
		
		
		if($productList['attribute_set_id'])
		{
			// get weight unit
			$chk_attribute_set = $this->db->get_where('attribute_set',array('id'=>$productList['attribute_set_id'],'status'=>1))->num_rows();
			if($chk_attribute_set){
				
				// get attribute list
				$attribute_list = $this->db->select('attribute.label,attribute.id,attribute.form_type,attribute.is_input_box')->join('attribute','attribute.id = attribute_set_attributes.attribute_id')->get_where('attribute_set_attributes',array('attribute_set_attributes.attribute_set_id'=>$productList['attribute_set_id'],'attribute.status'=>1))->result_array();
				if($attribute_list)
				{
					foreach($attribute_list as $aKey=>$aList)
					{
						// get attribute product data
						$pro_attribute_data = $this->db->select('attribute_data.label,product_attribute.attribute_input_value')->join('attribute_data','attribute_data.id = product_attribute.attribute_value')->get_where('product_attribute',array('product_attribute.product_id'=>$productID,'product_attribute.attribute_id'=>$aList['id']))->result_array();
						
						if($pro_attribute_data)
						{
							$pro_attribute_data[0]['link'] = base_url('product/detail/'.$slug);
							if($is_variation == 'variation'){
								$pro_attribute_data[0]['is_active'] = 0;
							}
							else
							{
								$pro_attribute_data[0]['is_active'] = 1;
							}
						}
						
						$total_attribute_data = count($pro_attribute_data);
						
						if($productList['is_variation'])
						{
							// get variation list
							$variationList = $this->db->get_where('product_variation_product_data',array('product_id'=>$productID))->result_array();
							if($variationList)
							{
								foreach($variationList as $vList)
								{
									if($aList['id'] == $vList['first_attribute_id'])
									{
										if($aList['is_input_box'])
										{
											$unit_data = $this->db->select('attribute_data.label')->get_where('attribute_data',array('attribute_data.id'=>$vList['unit']))->row_array();
											$pro_attribute_data[$total_attribute_data]['label'] = isset($unit_data['label']) ? $unit_data['label'] : '';
											$pro_attribute_data[$total_attribute_data]['attribute_input_value'] = $vList['first_option_data'];
											$pro_attribute_data[$total_attribute_data]['link'] = base_url('product/detail/'.$slug.'/variation/'.$vList['id']);
											if($vList['id'] == $variant_pro_id)
											{
												$pro_attribute_data[$total_attribute_data]['is_active'] = 1;
											}
											else
											{
												$pro_attribute_data[$total_attribute_data]['is_active'] = 0;
											}
											$total_attribute_data++;
										}
										elseif($aList['form_type'] == 2)
										{
											$pro_attribute_data[$total_attribute_data]['label'] = $vList['color_map'];
											$pro_attribute_data[$total_attribute_data]['attribute_input_value'] = '';
											$pro_attribute_data[$total_attribute_data]['link'] = base_url('product/detail/'.$slug.'/variation/'.$vList['id']);
											if($vList['id'] == $variant_pro_id)
											{
												$pro_attribute_data[$total_attribute_data]['is_active'] = 1;
											}
											else
											{
												$pro_attribute_data[$total_attribute_data]['is_active'] = 0;
											}
											$total_attribute_data++;
										}
										else
										{
											$pro_attribute_data[$total_attribute_data]['label'] = $vList['first_option_data'];
											$pro_attribute_data[$total_attribute_data]['attribute_input_value'] = '';
											$pro_attribute_data[$total_attribute_data]['link'] = base_url('product/detail/'.$slug.'/variation/'.$vList['id']);
											if($vList['id'] == $variant_pro_id)
											{
												$pro_attribute_data[$total_attribute_data]['is_active'] = 1;
											}
											else
											{
												$pro_attribute_data[$total_attribute_data]['is_active'] = 0;
											}
											$total_attribute_data++;
										}
										
									}
									elseif($aList['id'] == $vList['second_attribute_id'])
									{
										if($aList['is_input_box'])
										{
											$unit_data = $this->db->select('attribute_data.label')->get_where('attribute_data',array('attribute_data.id'=>$vList['unit']))->row_array();
											$pro_attribute_data[$total_attribute_data]['label'] = isset($unit_data['label']) ? $unit_data['label'] : '';
											$pro_attribute_data[$total_attribute_data]['attribute_input_value'] = $vList['second_option_data'];
											$pro_attribute_data[$total_attribute_data]['link'] = base_url('product/detail/'.$slug.'/variation/'.$vList['id']);
											if($vList['id'] == $variant_pro_id)
											{
												$pro_attribute_data[$total_attribute_data]['is_active'] = 1;
											}
											else
											{
												$pro_attribute_data[$total_attribute_data]['is_active'] = 0;
											}
											$total_attribute_data++;
										}
										elseif($aList['form_type'] == 2)
										{
											$pro_attribute_data[$total_attribute_data]['label'] = $vList['color_map'];
											$pro_attribute_data[$total_attribute_data]['attribute_input_value'] = '';
											$pro_attribute_data[$total_attribute_data]['link'] = base_url('product/detail/'.$slug.'/variation/'.$vList['id']);
											if($vList['id'] == $variant_pro_id)
											{
												$pro_attribute_data[$total_attribute_data]['is_active'] = 1;
											}
											else
											{
												$pro_attribute_data[$total_attribute_data]['is_active'] = 0;
											}
											$total_attribute_data++;
										}
										else
										{
											$pro_attribute_data[$total_attribute_data]['label'] = $vList['second_option_data'];
											$pro_attribute_data[$total_attribute_data]['attribute_input_value'] = '';
											$pro_attribute_data[$total_attribute_data]['link'] = base_url('product/detail/'.$slug.'/variation/'.$vList['id']);
											if($vList['id'] == $variant_pro_id)
											{
												$pro_attribute_data[$total_attribute_data]['is_active'] = 1;
											}
											else
											{
												$pro_attribute_data[$total_attribute_data]['is_active'] = 0;
											}
											$total_attribute_data++;
										}
										
									}
									elseif($aList['id'] == $vList['third_attribute_id'])
									{
										if($aList['is_input_box'])
										{
											$unit_data = $this->db->select('attribute_data.label')->get_where('attribute_data',array('attribute_data.id'=>$vList['unit']))->row_array();
											$pro_attribute_data[$total_attribute_data]['label'] = isset($unit_data['label']) ? $unit_data['label'] : '';
											$pro_attribute_data[$total_attribute_data]['attribute_input_value'] = $vList['third_option_data'];
											$pro_attribute_data[$total_attribute_data]['link'] = base_url('product/detail/'.$slug.'/variation/'.$vList['id']);
											if($vList['id'] == $variant_pro_id)
											{
												$pro_attribute_data[$total_attribute_data]['is_active'] = 1;
											}
											else
											{
												$pro_attribute_data[$total_attribute_data]['is_active'] = 0;
											}
											$total_attribute_data++;
										}
										elseif($aList['form_type'] == 2)
										{
											$pro_attribute_data[$total_attribute_data]['label'] = $vList['color_map'];
											$pro_attribute_data[$total_attribute_data]['attribute_input_value'] = '';
											$pro_attribute_data[$total_attribute_data]['link'] = base_url('product/detail/'.$slug.'/variation/'.$vList['id']);
											if($vList['id'] == $variant_pro_id)
											{
												$pro_attribute_data[$total_attribute_data]['is_active'] = 1;
											}
											else
											{
												$pro_attribute_data[$total_attribute_data]['is_active'] = 0;
											}
											$total_attribute_data++;
										}
										else
										{
											$pro_attribute_data[$total_attribute_data]['label'] = $vList['third_option_data'];
											$pro_attribute_data[$total_attribute_data]['attribute_input_value'] = '';
											$pro_attribute_data[$total_attribute_data]['link'] = base_url('product/detail/'.$slug.'/variation/'.$vList['id']);
											if($vList['id'] == $variant_pro_id)
											{
												$pro_attribute_data[$total_attribute_data]['is_active'] = 1;
											}
											else
											{
												$pro_attribute_data[$total_attribute_data]['is_active'] = 0;
											}
											$total_attribute_data++;
										}
										
									}
									elseif($aList['id'] == $vList['fourth_attribute_id'])
									{
										if($aList['is_input_box'])
										{
											$unit_data = $this->db->select('attribute_data.label')->get_where('attribute_data',array('attribute_data.id'=>$vList['unit']))->row_array();
											$pro_attribute_data[$total_attribute_data]['label'] = isset($unit_data['label']) ? $unit_data['label'] : '';
											$pro_attribute_data[$total_attribute_data]['attribute_input_value'] = $vList['fourth_option_data'];
											$pro_attribute_data[$total_attribute_data]['link'] = base_url('product/detail/'.$slug.'/variation/'.$vList['id']);
											if($vList['id'] == $variant_pro_id)
											{
												$pro_attribute_data[$total_attribute_data]['is_active'] = 1;
											}
											else
											{
												$pro_attribute_data[$total_attribute_data]['is_active'] = 0;
											}
											$total_attribute_data++;
										}
										elseif($aList['form_type'] == 2)
										{
											$pro_attribute_data[$total_attribute_data]['label'] = $vList['color_map'];
											$pro_attribute_data[$total_attribute_data]['attribute_input_value'] = '';
											$pro_attribute_data[$total_attribute_data]['link'] = base_url('product/detail/'.$slug.'/variation/'.$vList['id']);
											if($vList['id'] == $variant_pro_id)
											{
												$pro_attribute_data[$total_attribute_data]['is_active'] = 1;
											}
											else
											{
												$pro_attribute_data[$total_attribute_data]['is_active'] = 0;
											}
											$total_attribute_data++;
										}
										else
										{
											$pro_attribute_data[$total_attribute_data]['label'] = $vList['fourth_option_data'];
											$pro_attribute_data[$total_attribute_data]['attribute_input_value'] = '';
											$pro_attribute_data[$total_attribute_data]['link'] = base_url('product/detail/'.$slug.'/variation/'.$vList['id']);
											if($vList['id'] == $variant_pro_id)
											{
												$pro_attribute_data[$total_attribute_data]['is_active'] = 1;
											}
											else
											{
												$pro_attribute_data[$total_attribute_data]['is_active'] = 0;
											}
											$total_attribute_data++;
										}
										
									}
									elseif($aList['id'] == $vList['fifth_attribute_id'])
									{
										if($aList['is_input_box'])
										{
											$unit_data = $this->db->select('attribute_data.label')->get_where('attribute_data',array('attribute_data.id'=>$vList['unit']))->row_array();
											$pro_attribute_data[$total_attribute_data]['label'] = isset($unit_data['label']) ? $unit_data['label'] : '';
											$pro_attribute_data[$total_attribute_data]['attribute_input_value'] = $vList['fifth_option_data'];
											$pro_attribute_data[$total_attribute_data]['link'] = base_url('product/detail/'.$slug.'/variation/'.$vList['id']);
											if($vList['id'] == $variant_pro_id)
											{
												$pro_attribute_data[$total_attribute_data]['is_active'] = 1;
											}
											else
											{
												$pro_attribute_data[$total_attribute_data]['is_active'] = 0;
											}
											$total_attribute_data++;
										}
										elseif($aList['form_type'] == 2)
										{
											$pro_attribute_data[$total_attribute_data]['label'] = $vList['color_map'];
											$pro_attribute_data[$total_attribute_data]['attribute_input_value'] = '';
											$pro_attribute_data[$total_attribute_data]['link'] = base_url('product/detail/'.$slug.'/variation/'.$vList['id']);
											if($vList['id'] == $variant_pro_id)
											{
												$pro_attribute_data[$total_attribute_data]['is_active'] = 1;
											}
											else
											{
												$pro_attribute_data[$total_attribute_data]['is_active'] = 0;
											}
											$total_attribute_data++;
										}
										else
										{
											$pro_attribute_data[$total_attribute_data]['label'] = $vList['fifth_option_data'];
											$pro_attribute_data[$total_attribute_data]['attribute_input_value'] = '';
											$pro_attribute_data[$total_attribute_data]['link'] = base_url('product/detail/'.$slug.'/variation/'.$vList['id']);
											if($vList['id'] == $variant_pro_id)
											{
												$pro_attribute_data[$total_attribute_data]['is_active'] = 1;
											}
											else
											{
												$pro_attribute_data[$total_attribute_data]['is_active'] = 0;
											}
											$total_attribute_data++;
										}
										
									}
								}
							}
						}
						
						$attribute_list[$aKey]['attribute_data'] = $pro_attribute_data;
					}
				}
				$productList['attribute_list'] = $attribute_list;
			}
		}
		
		/*echo "<pre>";
		print_r($productList);
		die;*/
		
		
		$siteUrl = base_url();
		$data = array(
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'site_url' => $siteUrl,
			'productList' => $productList,
			'variant_pro_id' => base64_encode($variant_pro_id),
			'variation_status' => $variation_status,
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getsystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'content_block' => 'product-detail'
        );
        $this->parser->parse('front/layout/column-2' , $data);
    }
	
	public function addToCart($productID = 0)
	{
		$post = $this->input->post();
		$productID = isset($post['proID']) ? $post['proID'] : 0;
		$variationStatus = isset($post['variationStatus']) ? $post['variationStatus'] : 0;
		$variationProID = isset($post['variationProID']) ? base64_decode($post['variationProID']) : 0;
		$response = array();
		$today_date = date('Y-m-d');
		// check product id valid or not
		$chk_product = $this->db->get_where('products',array('id'=>$productID,'status'=>1,'approve_status'=>2))->num_rows();
		if($chk_product)
		{
			$loggedUser = $this->session->userdata('cranesmart_member_session');
			$account_id = isset($loggedUser['id']) ? $loggedUser['id'] : 0;
			if(!$account_id)
			{
				$loggedUser = $this->session->userdata('cranesmart_vendor_session');
				$account_id = isset($loggedUser['id']) ? $loggedUser['id'] : 0;
			}
			$user_ip_address = $_SERVER['REMOTE_ADDR'];
			
			
			if($account_id)
			{
				
				// check product already is in cart or not
				$chk_cart_product = $this->db->get_where('cart_temp_data',array('user_id'=>$account_id,'product_id'=>$productID,'is_variation'=>0));
				
				if($chk_cart_product->num_rows())
				{
					$pro_qty = $chk_cart_product->row_array();
					$qty = isset($pro_qty['qty']) ? $pro_qty['qty'] + 1 : 1;
					//$product_price = $qty * $price;
					
					$cartData = array(
						'qty' => $qty,
						'updated' => date('Y-m-d H:i:s')
					);
					
					$this->db->where('user_id',$account_id);
					$this->db->where('product_id',$productID);
					$this->db->where('is_variation',0);
					$this->db->update('cart_temp_data',$cartData);
					
				}
				else
				{
					
					$cartData = array(
						'user_id' => $account_id,
						'product_id' => $productID,
						'qty' => 1,
						'created' => date('Y-m-d H:i:s')
					);
					$this->db->insert('cart_temp_data',$cartData);
					
				}
				
				// get total product in cart
				$get_total_product = $this->db->select('sum(qty) as total_qty')->get_where('cart_temp_data',array('user_id'=>$account_id))->row_array();
				$total_product = isset($get_total_product['total_qty']) ? $get_total_product['total_qty'] : 0 ;
			}
			else
			{
				
				// check product already is in cart or not
				$chk_cart_product = $this->db->get_where('cart_temp_data',array('ip'=>$user_ip_address,'product_id'=>$productID,'is_variation'=>1));
				
				if($chk_cart_product->num_rows())
				{
					$pro_qty = $chk_cart_product->row_array();
					$qty = isset($pro_qty['qty']) ? $pro_qty['qty'] + 1 : 1;
					//$product_price = $qty * $price;
					
					$cartData = array(
						'qty' => $qty,
						'updated' => date('Y-m-d H:i:s')
					);
					
					$this->db->where('ip',$user_ip_address);
					$this->db->where('product_id',$productID);
					$this->db->where('is_variation',0);
					$this->db->update('cart_temp_data',$cartData);
					
				}
				else
				{
					
					$cartData = array(
						'ip' => $user_ip_address,
						'product_id' => $productID,
						'qty' => 1,
						'created' => date('Y-m-d H:i:s')
					);
					$this->db->insert('cart_temp_data',$cartData);
					
				}
				// get total product in cart
				$get_total_product = $this->db->select('sum(qty) as total_qty')->get_where('cart_temp_data',array('ip'=>$user_ip_address))->row_array();
				$total_product = isset($get_total_product['total_qty']) ? $get_total_product['total_qty'] : 0 ;
			}
			
			$response = array(
				'status' => 1,
				'msg' => 'Product added in Cart.',
				'total_product' => $total_product
			);
		}
		else
		{
			$response = array(
				'status' => 0,
				'msg' => 'Sorry ! Product is not valid.'
			);
		}
		
		echo json_encode($response);
	}
	
	public function updateProCart($productID = 0,$qty = 0,$cart_temp_id = 0)
	{
		$response = array();
		$today_date = date('Y-m-d');
		// check product id valid or not
		$chk_product = $this->db->get_where('products',array('id'=>$productID,'status'=>1,'approve_status'=>2))->num_rows();
		if($chk_product)
		{
			$loggedUser = $this->session->userdata('cranesmart_member_session');
			$account_id = isset($loggedUser['id']) ? $loggedUser['id'] : 0;
			if(!$account_id)
			{
				$loggedUser = $this->session->userdata('cranesmart_vendor_session');
				$account_id = isset($loggedUser['id']) ? $loggedUser['id'] : 0;
			}
			$user_ip_address = $_SERVER['REMOTE_ADDR'];
			
			// get variation status
			$get_variation_data = $this->db->get_where('cart_temp_data',array('id'=>$cart_temp_id,'product_id'=>$productID))->row_array();
			$is_variation = isset($get_variation_data['is_variation']) ? $get_variation_data['is_variation'] : 0 ;
			$variation_pro_id = isset($get_variation_data['variation_pro_id']) ? $get_variation_data['variation_pro_id'] : 0 ;
			
			$stock_status = 1;
			
			// get product stock
			$get_product_stock = $this->db->select('quantity')->get_where('products',array('id'=>$productID))->row_array();
			$product_quantity = isset($get_product_stock['quantity']) ? $get_product_stock['quantity'] : 0 ;
			if($product_quantity < $qty)
			{
				$stock_status = 0;
			}
			
			
			if($stock_status)
			{
			
				if($account_id)
				{
					// check product already is in cart or not
					$chk_cart_product = $this->db->get_where('cart_temp_data',array('user_id'=>$account_id,'product_id'=>$productID));
					if($chk_cart_product->num_rows())
					{
						$pro_qty = $chk_cart_product->row_array();
						
						//$product_price = $qty * $price;
						
						$cartData = array(
							'qty' => $qty,
							'updated' => date('Y-m-d H:i:s')
						);
						
						$this->db->where('user_id',$account_id);
						$this->db->where('product_id',$productID);
						$this->db->where('is_variation',0);
						$this->db->update('cart_temp_data',$cartData);
						
					}
					else
					{
						
						$cartData = array(
							'user_id' => $account_id,
							'product_id' => $productID,
							'qty' => 1,
							'created' => date('Y-m-d H:i:s')
						);
						$this->db->insert('cart_temp_data',$cartData);
						
					}
					
					// get total product in cart
					$total_product = $this->db->get_where('cart_temp_data',array('user_id'=>$account_id))->num_rows();
				}
				else
				{
					// check product already is in cart or not
					$chk_cart_product = $this->db->get_where('cart_temp_data',array('ip'=>$user_ip_address,'product_id'=>$productID));
					if($chk_cart_product->num_rows())
					{
						$pro_qty = $chk_cart_product->row_array();
						
						$cartData = array(
							'qty' => $qty,
							'updated' => date('Y-m-d H:i:s')
						);
						
						$this->db->where('ip',$user_ip_address);
						$this->db->where('product_id',$productID);
						$this->db->update('cart_temp_data',$cartData);
						
					}
					else
					{
						
						$cartData = array(
							'ip' => $user_ip_address,
							'product_id' => $productID,
							'qty' => 1,
							'created' => date('Y-m-d H:i:s')
						);
						$this->db->insert('cart_temp_data',$cartData);
						
					}
					// get total product in cart
					$total_product = $this->db->get_where('cart_temp_data',array('ip'=>$user_ip_address))->num_rows();
				}
				
				
				if($account_id){
					$productList = $this->db->query("SELECT b.*,a.qty,a.id as temp_id,a.is_variation,a.variation_pro_id FROM tbl_cart_temp_data as a INNER JOIN tbl_products as b on b.id = a.product_id where a.user_id = '$account_id' AND b.status = 1 AND b.approve_status = 2")->result_array();
					
					// get total product in cart
					$get_total_product = $this->db->select('sum(qty) as total_qty')->get_where('cart_temp_data',array('user_id'=>$account_id))->row_array();
					$total_product = isset($get_total_product['total_qty']) ? $get_total_product['total_qty'] : 0 ;
				}
				else
				{
					$productList = $this->db->query("SELECT b.*,a.qty,a.id as temp_id,a.is_variation,a.variation_pro_id FROM tbl_cart_temp_data as a INNER JOIN tbl_products as b on b.id = a.product_id where a.ip = '$user_ip_address' AND b.status = 1 AND b.approve_status = 2")->result_array();
					
					// get total product in cart
					$get_total_product = $this->db->select('sum(qty) as total_qty')->get_where('cart_temp_data',array('ip'=>$user_ip_address))->row_array();
					$total_product = isset($get_total_product['total_qty']) ? $get_total_product['total_qty'] : 0 ;
				}
				
				$product_price = 0;
				if($productList)
				{
					foreach($productList as $key=>$list)
					{
						if($list['special_price'] && $list['special_price_to'] >= $today_date)
						{
							$productList[$key]['price'] = $list['special_price'];
						}
						$productList[$key]['qty'] = $list['qty'];	
						if($list['id'] == $productID)
						{
							$product_price = $productList[$key]['price'] * $list['qty'];
						}
					}
				}
				
				$total = 0;
				if($productList){
					foreach($productList as $cList){
						
						$total+=$cList['price'] * $cList['qty'];
					}
				}
				
				$response = array(
					'status' => 1,
					'total_product' => $total_product,
					'total_price' => number_format($total,2),
					'product_price' => number_format($product_price,2),
					'msg' => 'Product Quantity Updated Successfully.'
				);
				
			}
			else
			{
				$response = array(
					'status' => 0,
					'msg' => 'Sorry ! Stock is not available.'
				);
			}
		}
		else
		{
			$response = array(
				'status' => 0,
				'msg' => 'Sorry ! Product is not valid.'
			);
		}
		
		echo json_encode($response);
	}
	
	public function deleteCartProduct($temp_id = 0)
	{
		$loggedUser = $this->session->userdata('cranesmart_member_session');
		$account_id = isset($loggedUser['id']) ? $loggedUser['id'] : 0;
		$user_ip_address = $_SERVER['REMOTE_ADDR'];
		
		$this->db->where('id',$temp_id);
		$this->db->delete('cart_temp_data');
		$total_product = $this->db->query("SELECT a.* FROM tbl_cart_temp_data as a where a.user_id = '$account_id' or a.ip = '$user_ip_address'")->num_rows();
		
		$productList = $this->db->query("SELECT b.*,a.qty,a.id as temp_id,a.is_variation,a.variation_pro_id FROM tbl_cart_temp_data as a INNER JOIN tbl_products as b on b.id = a.product_id where (a.user_id = '$account_id' or a.ip = '$user_ip_address') AND b.status = 1 AND b.approve_status = 2")->result_array();
		
		if($productList)
		{
			foreach($productList as $key=>$list)
			{
				if($list['is_variation'])
				{
					$get_product_img = $this->db->select('image_path,file_name')->get_where('product_variation_product_images',array('product_id'=>$list['id'],'variation_product_id'=>$list['variation_pro_id'],'is_base'=>1))->row_array();
					
					$product_img = isset($get_product_img['file_name']) ? 'media/product_images/thumbnail-70x70/'.$get_product_img['file_name'] : 'skin/front/images/product-default-img.png' ;
					
					$productList[$key]['product_img'] = $product_img;
					
					// get variation product data
					$variationProData = $this->db->get_where('product_variation_product_data',array('id'=>$list['variation_pro_id'],'product_id'=>$list['id']))->row_array();
					
					$productList[$key]['price'] = isset($variationProData['discount_price']) ? $variationProData['discount_price'] : 0;
					
				}
				else
				{
					// get product image
					$get_product_img = $this->db->select('image_path,file_name')->get_where('product_images',array('product_id'=>$list['id'],'is_base'=>1))->row_array();
					$product_img = isset($get_product_img['file_name']) ? 'media/product_images/thumbnail-70x70/'.$get_product_img['file_name'] : 'skin/front/images/product-default-img.png' ;
					
					$productList[$key]['product_img'] = $product_img;
					
					if($list['special_price'] && $list['special_price_to'] >= $today_date)
					{
						$productList[$key]['price'] = $list['special_price'];
					}
				}
				$productList[$key]['qty'] = $list['qty'];	
				$productList[$key]['temp_id'] = $list['temp_id'];	
			}
		}
		
		$str = '<div class="show_div">';
		$str.='<div class="show_div">';
		$subtotal = 0;
		$total = 0;
		if($productList){
			foreach($productList as $cList){
				$subtotal+=$cList['price'] * $cList['qty'];
				$total+=$cList['price'] * $cList['qty'];
				$str.='<div class="col-sm-12" id="cart-data-'.$cList['temp_id'].'">';
				$str.='<div class="col-sm-2 image_hov">';
				$str.='<img src="'.base_url($cList['product_img']).'" id="image_div_img" />';
				$str.='</div>';
				$str.='<div class="col-sm-3">';
				$str.='<a href="'.base_url().'product/detail/'.$cList['slug'].'" title="'.$cList['product_name'].'">'.substr($cList['product_name'],0,42).'</a>';
				$str.='</div>';
				$str.='<div class="col-sm-2" style="text-align:right;">';
				$str.='X '.$cList['qty'];
				$str.='</div>';
				$str.='<div class="col-sm-4" id="rate_con" style="text-align:right;">';
				$str.='&#8377; '.$cList['price'] * $cList['qty'];
				$str.='</div>';
				$str.='<div class="col-sm-1" id="close_icon" onclick="deleteCartPro('.$cList['temp_id'].')">X</div>';
				$str.='</div>';
			}
		}
		$str.='<div class="col-sm-12"><div class="table_div"><table class="table table-bordered table-condensed"><tr><th class="text-right">Subtotal</th><td>&#8377; '.$subtotal.'</td></tr><tr><th class="text-right">Total</th><td>&#8377; '.$total.'</td></tr></table></div><div class="cart-data-loader"></div></div>';
		$str.='</div>';
		if($this->session->userdata('cranesmart_vendor_session') || $this->session->userdata('cranesmart_member_session')){
			$checkout_str = '<a href="'.base_url('checkout').'"><button type="button" id="view-cart-btn"><i class="fa fa-share" id="cart"></i>Checkout</button></a>';
		}
		else
		{
			$checkout_str = '<a href="'.base_url('login?ret_url=checkout').'"><button type="button" id="view-cart-btn"><i class="fa fa-share" id="cart"></i>Checkout</button></a>';
		}
		$str.='<div class="show_div" align="right"><div class="col-sm-12"><div class="btn-div-hov"><a href="#"><button type="button" id="view-cart-btn"><i class="fa fa-shopping-cart" id="cart"></i> View Cart</button></a>'.$checkout_str.'</div></div></div>';
		
		$response = array(
			'status' => 1,
			'msg' => 'Product Removed From Cart',
			'total_product' => $total_product,
			'str' => $str
		);
		echo json_encode($response);
	}
	
	public function deleteProCart($productID = 0,$cart_temp_id = 0)
	{
		$response = array();
		$today_date = date('Y-m-d');
		// check product id valid or not
		$chk_product = $this->db->get_where('products',array('id'=>$productID,'status'=>1,'approve_status'=>2))->num_rows();
		if($chk_product)
		{
			$loggedUser = $this->session->userdata('cranesmart_member_session');
			$account_id = isset($loggedUser['id']) ? $loggedUser['id'] : 0;
			if(!$account_id)
			{
				$loggedUser = $this->session->userdata('cranesmart_vendor_session');
				$account_id = isset($loggedUser['id']) ? $loggedUser['id'] : 0;
			}
			$user_ip_address = $_SERVER['REMOTE_ADDR'];
			
			// get variation status
			$get_variation_data = $this->db->get_where('cart_temp_data',array('id'=>$cart_temp_id,'product_id'=>$productID))->row_array();
			$is_variation = isset($get_variation_data['is_variation']) ? $get_variation_data['is_variation'] : 0 ;
			$variation_pro_id = isset($get_variation_data['variation_pro_id']) ? $get_variation_data['variation_pro_id'] : 0 ;
			
			if($account_id)
			{
				
				$this->db->where('user_id',$account_id);
				$this->db->where('product_id',$productID);
				$this->db->where('is_variation',0);
				$this->db->delete('cart_temp_data');
				
			}
			else
			{
				
				$this->db->where('ip',$user_ip_address);
				$this->db->where('product_id',$productID);
				$this->db->where('is_variation',0);
				$this->db->delete('cart_temp_data');
				
			}
			
			
			if($account_id){
				$productList = $this->db->query("SELECT b.*,a.qty,a.id as temp_id,a.is_variation,a.variation_pro_id FROM tbl_cart_temp_data as a INNER JOIN tbl_products as b on b.id = a.product_id where a.user_id = '$account_id' AND b.status = 1 AND b.approve_status = 2")->result_array();
				
				// get total product in cart
				$get_total_product = $this->db->select('sum(qty) as total_qty')->get_where('cart_temp_data',array('user_id'=>$account_id))->row_array();
				$total_product = isset($get_total_product['total_qty']) ? $get_total_product['total_qty'] : 0 ;
			}
			else
			{
				$productList = $this->db->query("SELECT b.*,a.qty,a.id as temp_id,a.is_variation,a.variation_pro_id FROM tbl_cart_temp_data as a INNER JOIN tbl_products as b on b.id = a.product_id where a.ip = '$user_ip_address' AND b.status = 1 AND b.approve_status = 2")->result_array();
				
				// get total product in cart
				$get_total_product = $this->db->select('sum(qty) as total_qty')->get_where('cart_temp_data',array('ip'=>$user_ip_address))->row_array();
				$total_product = isset($get_total_product['total_qty']) ? $get_total_product['total_qty'] : 0 ;
			}
			
			if($productList)
			{
				foreach($productList as $key=>$list)
				{
					if($list['special_price'] && $list['special_price_to'] >= $today_date)
					{
						$productList[$key]['price'] = $list['special_price'];
					}
					$productList[$key]['qty'] = $list['qty'];	
				}
			}
			
			$total = 0;
			if($productList){
				foreach($productList as $cList){
					
					$total+=$cList['price'] * $cList['qty'];
				}
			}
			
			$response = array(
				'status' => 1,
				'total_product' => $total_product,
				'total_price' => number_format($total,2),
				'msg' => 'Product Removed From Cart'
			);
		}
		else
		{
			$response = array(
				'status' => 0,
				'msg' => 'Sorry ! Product is not valid.'
			);
		}
		
		echo json_encode($response);
	}
	
	
}
/* End of file login.php */
/* Location: ./application/controllers/login.php */