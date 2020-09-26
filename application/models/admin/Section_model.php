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

class Section_model extends CI_Model 
{ 

    public function __construct() 
    {
 		parent::__construct();
    }
    
	public function save_product_section($post,$product_id = '')
	{
		$banner_order = $post['order_no'];
		if(!$post['order_no'])
		{
			// get last block position
			$get_last_order = $this->db->order_by('order_no','desc')->get('sections')->row_array();
			$banner_order = isset($get_last_order['order_no']) ? $get_last_order['order_no'] + 1 : 1 ;
		}
		$slug = url_title($post['section_name'], 'dash', true);
    	$data = array(			
			'section_type_id'  	=>	$post['section_type_id'],
			'section_name'	    =>	$post['section_name'],
			'slug'       =>  $slug,
			'order_no'		=>	$banner_order,
			'product_id'		=>	$product_id,
			'status'			=>	$post['status'],
			'created'			=>	date('Y-m-d H:i:s')
		);
		
		$this->db->insert("sections", $data);
		return true;
	}	
	
	public function save_two_banner_section($post,$two_banner_1_image = '',$two_banner_2_image = '')
	{
		$banner_order = $post['order_no'];
		if(!$post['order_no'])
		{
			// get last block position
			$get_last_order = $this->db->order_by('order_no','desc')->get('sections')->row_array();
			$banner_order = isset($get_last_order['order_no']) ? $get_last_order['order_no'] + 1 : 1 ;
		}
		$slug = url_title($post['section_name'], 'dash', true);
    	$data = array(			
			'section_type_id'  	=>	$post['section_type_id'],
			'section_name'	    =>	$post['section_name'],
			'slug'       =>  $slug,
			'order_no'		=>	$banner_order,
			'banner_1_image'		=>	$two_banner_1_image,
			'banner_1_redirect_url'	    =>	$post['two_banner_1_redirect_url'],
			'banner_1_is_new_tab'	    =>	$post['two_banner_1_is_new_tab'],
			'banner_2_image'		=>	$two_banner_2_image,
			'banner_2_redirect_url'	    =>	$post['two_banner_2_redirect_url'],
			'banner_2_is_new_tab'	    =>	$post['two_banner_2_is_new_tab'],
			'status'			=>	$post['status'],
			'created'			=>	date('Y-m-d H:i:s')
		);
		
		$this->db->insert("sections", $data);
		return true;
	}	
	
	public function save_five_banner_section($post,$five_banner_small_1_image,$five_banner_small_2_image,$five_banner_small_3_image)
	{
		$banner_order = $post['order_no'];
		if(!$post['order_no'])
		{
			// get last block position
			$get_last_order = $this->db->order_by('order_no','desc')->get('sections')->row_array();
			$banner_order = isset($get_last_order['order_no']) ? $get_last_order['order_no'] + 1 : 1 ;
		}
		$slug = url_title($post['section_name'], 'dash', true);
    	$data = array(			
			'section_type_id'  	=>	$post['section_type_id'],
			'section_name'	    =>	$post['section_name'],
			'slug'       =>  $slug,
			'order_no'		=>	$banner_order,
			'banner_1_image'		=>	$five_banner_small_1_image,
			'banner_1_redirect_url'	    =>	$post['five_banner_small_1_redirect_url'],
			'banner_1_is_new_tab'	    =>	$post['five_banner_small_1_is_new_tab'],
			'banner_2_image'		=>	$five_banner_small_2_image,
			'banner_2_redirect_url'	    =>	$post['five_banner_small_2_redirect_url'],
			'banner_2_is_new_tab'	    =>	$post['five_banner_small_2_is_new_tab'],
			'banner_3_image'		=>	$five_banner_small_3_image,
			'banner_3_redirect_url'	    =>	$post['five_banner_small_3_redirect_url'],
			'banner_3_is_new_tab'	    =>	$post['five_banner_small_3_is_new_tab'],
			'status'			=>	$post['status'],
			'created'			=>	date('Y-m-d H:i:s')
		);
		
		$this->db->insert("sections", $data);
		return true;
	}
	
	public function update_product_section($post,$product_id = '')
	{
		$banner_order = $post['order_no'];
		$slug = url_title($post['section_name'], 'dash', true);
    	$data = array(			
			'section_type_id'  	=>	$post['section_type_id'],
			'section_name'	    =>	$post['section_name'],
			'slug'       =>  $slug,
			'order_no'		=>	$banner_order,
			'product_id'		=>	$product_id,
			'status'			=>	$post['status'],
			'updated'			=>	date('Y-m-d H:i:s')
		);
		
		$this->db->where('id', $post['sectionID']);
		$this->db->update("sections", $data);
		return true;
	}	
	
	public function update_two_banner_section($post,$two_banner_1_image = '',$two_banner_2_image = '')
	{
		$banner_order = $post['order_no'];
		$slug = url_title($post['section_name'], 'dash', true);
    	$data = array(			
			'section_type_id'  	=>	$post['section_type_id'],
			'section_name'	    =>	$post['section_name'],
			'slug'       =>  $slug,
			'order_no'		=>	$banner_order,
			'banner_1_redirect_url'	    =>	$post['two_banner_1_redirect_url'],
			'banner_1_is_new_tab'	    =>	$post['two_banner_1_is_new_tab'],
			'banner_2_redirect_url'	    =>	$post['two_banner_2_redirect_url'],
			'banner_2_is_new_tab'	    =>	$post['two_banner_2_is_new_tab'],
			'status'			=>	$post['status'],
			'updated'			=>	date('Y-m-d H:i:s')
		);
		if($two_banner_1_image)
		{
			$data['banner_1_image'] = $two_banner_1_image;
		}
		if($two_banner_2_image)
		{
			$data['banner_2_image'] = $two_banner_2_image;
		}
		$this->db->where('id', $post['sectionID']);
		$this->db->update("sections", $data);
		return true;
	}	
	
	public function update_five_banner_section($post,$five_banner_small_1_image,$five_banner_small_2_image,$five_banner_small_3_image)
	{
		$banner_order = $post['order_no'];
		
		$slug = url_title($post['section_name'], 'dash', true);
    	$data = array(			
			'section_type_id'  	=>	$post['section_type_id'],
			'section_name'	    =>	$post['section_name'],
			'slug'       =>  $slug,
			'order_no'		=>	$banner_order,
			'banner_1_redirect_url'	    =>	$post['five_banner_small_1_redirect_url'],
			'banner_1_is_new_tab'	    =>	$post['five_banner_small_1_is_new_tab'],
			'banner_2_redirect_url'	    =>	$post['five_banner_small_2_redirect_url'],
			'banner_2_is_new_tab'	    =>	$post['five_banner_small_2_is_new_tab'],
			'banner_3_redirect_url'	    =>	$post['five_banner_small_3_redirect_url'],
			'banner_3_is_new_tab'	    =>	$post['five_banner_small_3_is_new_tab'],
			'status'			=>	$post['status'],
			'updated'			=>	date('Y-m-d H:i:s')
		);
		
		if($five_banner_small_1_image)
		{
			$data['banner_1_image'] = $five_banner_small_1_image;
		}
		if($five_banner_small_2_image)
		{
			$data['banner_2_image'] = $five_banner_small_2_image;
		}
		if($five_banner_small_3_image)
		{
			$data['banner_3_image'] = $five_banner_small_3_image;
		}
		
		$this->db->where('id', $post['sectionID']);
		$this->db->update("sections", $data);
		return true;
	}
	
	

}
?>