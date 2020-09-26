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

class Banners_model extends CI_Model 
{ 

    public function __construct() 
    {
 		parent::__construct();
    }
    
	public function save_banner($post,$banner_image_path)
	{
		$banner_order = $post['order_no'];
		if(!$post['order_no'])
		{
			// get last block position
			$get_last_order = $this->db->order_by('order_no','desc')->get_where('banners',array('banner_type_id'=>$post['banner_type_id']))->row_array();
			$banner_order = isset($get_last_order['order_no']) ? $get_last_order['order_no'] + 1 : 1 ;
		}
		$data = array(
			'order_no' => $banner_order,
			'banner_type_id'=>$post['banner_type_id'],
			'redirect_url'=>$post['redirect_url'],	
			'is_active' => $post['status'],
			'is_new_tab'=>$post['is_new_tab'],
			'image_path'=>$banner_image_path,
			'posted' => date('Y-m-d H:i:s')
		);
		
		$this->db->insert('banners',$data);
		return true;
	
	}

	public function update_banner($post,$banner_image_path)
	{
		$banner_order = $post['order_no'];
		
		$data = array(
			'order_no' => $banner_order,
			'banner_type_id'=>$post['banner_type_id'],
			'redirect_url'=>$post['redirect_url'],	
			'is_active' => $post['status'],
			'is_new_tab'=>$post['is_new_tab'],
			'posted' => date('Y-m-d H:i:s')
		);
		
		if($banner_image_path)
		{
			$data['image_path'] = $banner_image_path;
		}
		
		$this->db->where('id',$post['id']);
		$this->db->update('banners',$data);
		return true;
	
	}
	
	
}
?>