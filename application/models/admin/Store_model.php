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

class Store_model extends CI_Model 
{ 

    public function __construct() 
    {
 		parent::__construct();
    }
    
	public function save_attribute_set($post)
	{
		$slug = url_title($post['title'], 'dash', true);
		$data = array(
			'title' => $post['title'],
			'slug' => $slug,
			'status' => $post['status'],
			'created' => date('Y-m-d H:i:s')
		);
		
		$this->db->insert('attribute_set',$data);
		return true;
	
	}
	
	public function update_attribute_set($post)
	{
		$slug = url_title($post['title'], 'dash', true);	
		$data = array(
			'title' => $post['title'],
			'slug' => $slug,
			'status' => $post['status'],
			'updated' => date('Y-m-d H:i:s')
		);
		
		$this->db->where('id',$post['catID']);
		$this->db->update('attribute_set',$data);
		
		
		return true;
	
	}
	
	
	public function save_attribute($post)
	{
		$slug = url_title($post['label'], 'dash', true);
		$data = array(
			'label' => $post['label'],
			'slug' => $slug,
			'attribute_code' => $post['attribute_code'],
			'is_filter' => $post['is_filter'],
			'form_type' => $post['form_type'],
			'is_required' => $post['is_required'],
			'is_input_box	' => $post['is_input_box'],
			'status	' => $post['status'],
			'created' => date('Y-m-d H:i:s')
		);
		$this->db->insert('attribute',$data);
		$attribute_id = $this->db->insert_id();
		
		
		
		if($post['form_type'] == 1 || $post['form_type'] == 2 || $post['form_type'] == 3)
		{
			$dropdown_is_default = isset($post['dropdown_is_default']) ? $post['dropdown_is_default'] : 0 ;
			if($post['dropdown_label'])
			{
				$order_no = 1;
				foreach($post['dropdown_label'] as $key=>$label)
				{
					$description = isset($post['dropdown_value'][$key]) ? $post['dropdown_value'][$key] : '' ;
					if($label)
					{
						$is_default = 0;
						if($key == $dropdown_is_default)
							$is_default = 1;
						
						$attribute_data = array(
							'attribute_id' => $attribute_id,
							'order_no' => $order_no,
							'is_default' => $is_default,
							'label' => $label,
							'description' => $description
						);
						$this->db->insert('attribute_data',$attribute_data);
						
						$order_no++;
						
					}
				}
			}
		}
		if($post['form_type'] == 4)
		{
			$dropdown_is_default = isset($post['dropdown_is_default']) ? $post['dropdown_is_default'] : array() ;
			if($post['dropdown_label'])
			{
				$order_no = 1;
				foreach($post['dropdown_label'] as $key=>$label)
				{
					$description = isset($post['dropdown_value'][$key]) ? $post['dropdown_value'][$key] : '' ;
					if($label)
					{
						$is_default = 0;
						if(in_array($key,$dropdown_is_default))
							$is_default = 1;
						
						$attribute_data = array(
							'attribute_id' => $attribute_id,
							'order_no' => $order_no,
							'is_default' => $is_default,
							'label' => $label,
							'description' => $description
						);
						$this->db->insert('attribute_data',$attribute_data);
						
						$order_no++;
						
					}
				}
			}
		}
		
		if($post['form_type'] == 5)
		{
			$dropdown_is_default = isset($post['dropdown_is_default']) ? $post['dropdown_is_default'] : array() ;
			if($post['dropdown_label'])
			{
				$order_no = 1;
				foreach($post['dropdown_label'] as $key=>$label)
				{
					$description = isset($post['dropdown_value'][$key]) ? $post['dropdown_value'][$key] : '' ;
					if($label)
					{
						$is_default = 0;
						if(in_array($key,$dropdown_is_default))
							$is_default = 1;
						
						$attribute_data = array(
							'attribute_id' => $attribute_id,
							'order_no' => $order_no,
							'is_default' => $is_default,
							'label' => $label,
							'description' => $description
						);
						$this->db->insert('attribute_data',$attribute_data);
						
						$order_no++;
						
					}
				}
			}
		}
		
		if(isset($post['attribute_set_id']))
		{
			foreach($post['attribute_set_id'] as $attribute_set_id)
			{
				$attribute_set_data = array(
					'attribute_id' => $attribute_id,
					'attribute_set_id' => $attribute_set_id,
				);
				$this->db->insert('attribute_set_attributes',$attribute_set_data);
			}
		}
		
		return true;
	
	}
	
	public function update_attribute($post)
	{
		
		$slug = url_title($post['label'], 'dash', true);
		$data = array(
			'label' => $post['label'],
			'slug' => $slug,
			'attribute_code' => $post['attribute_code'],
			'is_filter' => $post['is_filter'],
			'is_required' => $post['is_required'],
			'is_input_box	' => $post['is_input_box'],
			'status	' => $post['status'],
			'updated' => date('Y-m-d H:i:s')
		);
		
		$attribute_id = $post['attribute_id'];
		
		$this->db->where('id',$attribute_id);
		$this->db->update('attribute',$data);
		
		
		$this->db->where('attribute_id',$attribute_id);
		$this->db->delete('attribute_data');
		
		
		$this->db->where('attribute_id',$attribute_id);
		$this->db->delete('attribute_set_attributes');
		
		
		
		if($post['form_type_id'] == 1 || $post['form_type_id'] == 2 || $post['form_type_id'] == 3)
		{
			$dropdown_is_default = isset($post['dropdown_is_default']) ? $post['dropdown_is_default'] : 0 ;
			if($post['dropdown_label'])
			{
				$order_no = 1;
				foreach($post['dropdown_label'] as $key=>$label)
				{
					$description = isset($post['dropdown_value'][$key]) ? $post['dropdown_value'][$key] : '' ;
					if($label)
					{
						$is_default = 0;
						if($key == $dropdown_is_default)
							$is_default = 1;
						
						$attribute_data = array(
							'attribute_id' => $attribute_id,
							'order_no' => $order_no,
							'is_default' => $is_default,
							'label' => $label,
							'description' => $description
						);
						
						$this->db->insert('attribute_data',$attribute_data);
						
						$order_no++;
						
					}
				}
			}
		}
		if($post['form_type_id'] == 4)
		{
			$dropdown_is_default = isset($post['dropdown_is_default']) ? $post['dropdown_is_default'] : array() ;
			if($post['dropdown_label'])
			{
				$order_no = 1;
				foreach($post['dropdown_label'] as $key=>$label)
				{
					$description = isset($post['dropdown_value'][$key]) ? $post['dropdown_value'][$key] : '' ;
					if($label)
					{
						$is_default = 0;
						if(in_array($key,$dropdown_is_default))
							$is_default = 1;
						
						$attribute_data = array(
							'attribute_id' => $attribute_id,
							'order_no' => $order_no,
							'is_default' => $is_default,
							'label' => $label,
							'description' => $description
						);
						$this->db->insert('attribute_data',$attribute_data);
						
						$order_no++;
						
					}
				}
			}
		}
		
		if($post['form_type_id'] == 5)
		{
			$dropdown_is_default = isset($post['dropdown_is_default']) ? $post['dropdown_is_default'] : array() ;
			if($post['dropdown_label'])
			{
				$order_no = 1;
				foreach($post['dropdown_label'] as $key=>$label)
				{
					$description = isset($post['dropdown_value'][$key]) ? $post['dropdown_value'][$key] : '' ;
					if($label)
					{
						$is_default = 0;
						if(in_array($key,$dropdown_is_default))
							$is_default = 1;
						
						$attribute_data = array(
							'attribute_id' => $attribute_id,
							'order_no' => $order_no,
							'is_default' => $is_default,
							'label' => $label,
							'description' => $description
						);
						$this->db->insert('attribute_data',$attribute_data);
						
						$order_no++;
						
					}
				}
			}
		}
		
		if(isset($post['attribute_set_id']))
		{
			foreach($post['attribute_set_id'] as $attribute_set_id)
			{
				$attribute_set_data = array(
					'attribute_id' => $attribute_id,
					'attribute_set_id' => $attribute_set_id,
				);
				$this->db->insert('attribute_set_attributes',$attribute_set_data);
			}
		}
		
		return true;
	
	}
	
	
	
}
?>