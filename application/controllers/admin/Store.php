<?php
class Store extends CI_Controller {    
    
    
    public function __construct() 
    {
        parent::__construct();
       	$this->User->checkPermission();
        $this->load->model('admin/Store_model');		
        $this->load->model('admin/Section_model');		
        $this->lang->load('admin/dashboard', 'english');
        
    } 
    
	public function attributeSetList()
    {
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		
        $categoryList = $this->db->order_by('created','desc')->get_where('attribute_set')->result_array();
		
		$siteUrl = site_url();
		$data = array(
            'site_url' => $siteUrl,
            'meta_title' => 'Attribute Set List',
            'meta_keywords' => 'Attribute Set List',
            'meta_description' => 'Attribute Set List',
			'loggedUser' => $loggedUser,	
			'content_block' => 'store/attributeSetList',
            'manager_description' => 'Attribute Set List',
			'categoryList' => $categoryList,
            'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getSystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning()
        );
        $this->parser->parse('admin/layout/column-1', $data);
		
    }

	public function addAttributeSet()
    {
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");

		   	
		$siteUrl = site_url();
        $data = array(
            'site_url' => $siteUrl,
			'loggedUser' => $loggedUser,
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'content_block' => 'store/addAttributeSet',
            'manager_description' => lang('SITE_NAME'),
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getSystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning() 
		);
        $this->parser->parse('admin/layout/column-1', $data);
		
    }
   
	
	public function saveAttributeSet()
	{
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		$userID = $loggedUser['id'];
		$post = $this->input->post();
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Title', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			
			$this->addAttributeSet();
		}
		else
		{
			// update organizer detail
			$this->Store_model->save_attribute_set($post);
			$this->Az->redirect('admin/store/addAttributeSet', 'system_message_error',lang('ATTRIBUTE_SET_SAVE_SUCCESS'));
		}
		
	}


	public function editAttributeSet($catID = 0)
    {
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		
		// check category valid or not
		$chk_cat = $this->db->get_where('attribute_set',array('id'=>$catID))->num_rows();
		if(!$chk_cat)
		{
			$this->Az->redirect('admin/store/attributeSetList', 'system_message_error',lang('ATTRIBUTE_SET_VALID_ERROR'));
		}

		// get category data
		$categoryData = $this->db->get_where('attribute_set',array('id'=>$catID))->row_array();
		
		// get attribute list
		$attributeList = $this->db->select('attribute.id,attribute.label')->join('attribute','attribute.id = attribute_set_attributes.attribute_id')->get_where('attribute_set_attributes',array('attribute_set_id'=>$catID))->result_array();
		
		
		   	
		$siteUrl = site_url();
        $data = array(
            'site_url' => $siteUrl,
			'loggedUser' => $loggedUser,
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'content_block' => 'store/editAttributeSet',
            'manager_description' => lang('SITE_NAME'),
            'categoryData' => $categoryData,
            'catID' => $catID,
            'attributeList' => $attributeList,
            'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getSystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning() 
		);
        $this->parser->parse('admin/layout/column-1', $data);
		
    }

    public function updateAttributeSet()
	{
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		$userID = $loggedUser['id'];
		$post = $this->input->post();
		$catID = $post['catID'];
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Title', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			
			$this->editAttributeSet($catID);
		}
		else
		{
			
			// update organizer detail
			$this->Store_model->update_attribute_set($post);
			$this->Az->redirect('admin/store/attributeSetList', 'system_message_error',lang('ATTRIBUTE_SET_UPDATE_SUCCESS'));
		
		}
		
		
			
		
	}


	public function deleteAttributeSet($catID = 0, $uploadError = '')
	{
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		// check category valid or not
		$chk_cat = $this->db->get_where('attribute_set',array('id'=>$catID))->num_rows();
		if(!$chk_cat)
		{
			$this->Az->redirect('admin/store/attributeSetList', 'system_message_error',lang('ATTRIBUTE_SET_VALID_ERROR'));
		}
		
		$this->db->where('id',$catID);
		$this->db->delete('attribute_set');
		$this->Az->redirect('admin/store/attributeSetList', 'system_message_info', lang('ATTRIBUTE_SET_DELETE_SUCCESS'));
		
    }
	
	public function attributeList()
    {
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		
        $categoryList = $this->db->order_by('created','desc')->get_where('attribute')->result_array();
		
		$siteUrl = site_url();
		$data = array(
            'site_url' => $siteUrl,
            'meta_title' => 'Attribute List',
            'meta_keywords' => 'Attribute List',
            'meta_description' => 'Attribute List',
			'loggedUser' => $loggedUser,	
			'content_block' => 'store/attributeList',
            'manager_description' => 'Attribute List',
			'categoryList' => $categoryList,
            'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getSystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning()
        );
        $this->parser->parse('admin/layout/column-1', $data);
		
    }
	
	
	public function setAttributeList($attribute_set_id = 0)
    {
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		
        $categoryList = $this->db->select('attribute.*')->join('attribute','attribute.id = attribute_set_attributes.attribute_id')->get_where('attribute_set_attributes',array('attribute_set_id'=>$attribute_set_id))->result_array();
		
		// get attribute set name
		$attributeSetName = $this->db->select('title')->get_where('attribute_set',array('id'=>$attribute_set_id))->row_array();
		
		$setName = isset($attributeSetName['title']) ? $attributeSetName['title'] : '';
		
		$siteUrl = site_url();
		$data = array(
            'site_url' => $siteUrl,
            'meta_title' => 'Attribute List',
            'meta_keywords' => 'Attribute List',
            'meta_description' => 'Attribute List',
			'loggedUser' => $loggedUser,	
			'content_block' => 'store/setAttributeList',
            'manager_description' => 'Attribute List',
			'categoryList' => $categoryList,
			'setName' => $setName,
            'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getSystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning()
        );
        $this->parser->parse('admin/layout/column-1', $data);
		
    }

	public function addAttribute()
    {
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		
		// get form type list
		$formTypeList = $this->db->get('attribute_form_type')->result_array();
		
		// get attribute set List
		$attributeSetList = $this->db->order_by('created','desc')->get_where('attribute_set',array('status'=>1))->result_array();
		   	
		$siteUrl = site_url();
        $data = array(
            'site_url' => $siteUrl,
			'loggedUser' => $loggedUser,
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'content_block' => 'store/addAttribute',
            'manager_description' => lang('SITE_NAME'),
			'formTypeList' => $formTypeList,
			'attributeSetList' => $attributeSetList,
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getSystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning() 
		);
        $this->parser->parse('admin/layout/column-1', $data);
		
    }
   
	
	public function saveAttribute()
	{
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		$userID = $loggedUser['id'];
		$post = $this->input->post();
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('label', 'Label', 'required|xss_clean');
		$this->form_validation->set_rules('attribute_code', 'Attribute Code', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			
			$this->addAttribute();
		}
		else
		{
			
			// update organizer detail
			$this->Store_model->save_attribute($post);
			$this->Az->redirect('admin/store/addAttribute', 'system_message_error',lang('ATTRIBUTE_SAVE_SUCCESS'));
		}
		
	}
	
	
	public function editAttribute($catID = 0)
    {
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		
		// check category valid or not
		$chk_cat = $this->db->get_where('attribute',array('id'=>$catID))->num_rows();
		if(!$chk_cat)
		{
			$this->Az->redirect('admin/store/attributeList', 'system_message_error',lang('ATTRIBUTE_VALID_ERROR'));
		}

		// get category data
		$attributeData = $this->db->get_where('attribute',array('id'=>$catID))->row_array();
		
		// get category data
		$attributeFormData = $this->db->order_by('order_no','asc')->get_where('attribute_data',array('attribute_id'=>$catID))->result_array();
		
		// get form type list
		$formTypeList = $this->db->get('attribute_form_type')->result_array();
		
		// get attribute set List
		$attributeSetList = $this->db->order_by('created','desc')->get_where('attribute_set',array('status'=>1))->result_array();
		
		// get attribute set List
		$attributeSetAttribute = $this->db->get_where('attribute_set_attributes',array('attribute_id'=>$catID))->result_array();
		
		$attributeSetAttributeData = array();
		if($attributeSetAttribute)
		{
			foreach($attributeSetAttribute as $key=>$list)
			{
				$attributeSetAttributeData[$key] = $list['attribute_set_id'];
			}
		}
		
		   	
		$siteUrl = site_url();
        $data = array(
            'site_url' => $siteUrl,
			'loggedUser' => $loggedUser,
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'content_block' => 'store/editAttribute',
            'manager_description' => lang('SITE_NAME'),
            'attributeData' => $attributeData,
            'attribute_id' => $catID,
			'formTypeList' => $formTypeList,
			'attributeSetList' => $attributeSetList,
			'attributeFormData' => $attributeFormData,
			'attributeSetAttributeData' => $attributeSetAttributeData,
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getSystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning() 
		);
        $this->parser->parse('admin/layout/column-1', $data);
		
    }

    public function updateAttribute()
	{
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		$userID = $loggedUser['id'];
		$post = $this->input->post();
		$attribute_id = $post['attribute_id'];
		$this->load->library('form_validation');
		$this->form_validation->set_rules('label', 'Label', 'required|xss_clean');
		$this->form_validation->set_rules('attribute_code', 'Attribute Code', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			
			$this->editAttribute($attribute_id);
		}
		else
		{
			
			// update organizer detail
			$this->Store_model->update_attribute($post);
			$this->Az->redirect('admin/store/attributeList', 'system_message_error',lang('ATTRIBUTE_UPDATE_SUCCESS'));
		
		}
		
		
			
		
	}


	public function deleteAttribute($attribute_id = 0, $uploadError = '')
	{
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		// check category valid or not
		$chk_cat = $this->db->get_where('attribute',array('id'=>$attribute_id))->num_rows();
		if(!$chk_cat)
		{
			$this->Az->redirect('admin/store/attributeList', 'system_message_error',lang('ATTRIBUTE_VALID_ERROR'));
		}
		
		$this->db->where('id',$attribute_id);
		$this->db->delete('attribute');
		
		
		$this->db->where('attribute_id',$attribute_id);
		$this->db->delete('attribute_data');
		
		
		$this->db->where('attribute_id',$attribute_id);
		$this->db->delete('attribute_set_attributes');
		
		$this->Az->redirect('admin/store/attributeList', 'system_message_info', lang('ATTRIBUTE_DELETE_SUCCESS'));
		
    }
	
	public function variationList()
    {
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		
        $categoryList = $this->db->order_by('created','desc')->get_where('variation_theme')->result_array();
		
		$siteUrl = site_url();
		$data = array(
            'site_url' => $siteUrl,
            'meta_title' => 'Variation List',
            'meta_keywords' => 'Variation List',
            'meta_description' => 'Variation List',
			'loggedUser' => $loggedUser,	
			'content_block' => 'store/variationList',
            'manager_description' => 'Variation List',
			'categoryList' => $categoryList,
            'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getSystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning()
        );
        $this->parser->parse('admin/layout/column-1', $data);
		
    }
	
	
	public function addVariation()
    {
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		   	
		$siteUrl = site_url();
        $data = array(
            'site_url' => $siteUrl,
			'loggedUser' => $loggedUser,
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'content_block' => 'store/addVariation',
            'manager_description' => lang('SITE_NAME'),
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getSystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning() 
		);
        $this->parser->parse('admin/layout/column-1', $data);
		
    }
	
	public function saveVariation()
	{
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		$userID = $loggedUser['id'];
		$post = $this->input->post();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('label', 'Label', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$this->addVariation();
		}
		else
		{
			// update organizer detail
			$this->Store_model->save_variation($post);
			$this->Az->redirect('admin/store/variationList', 'system_message_error',lang('VARIATION_SAVE_SUCCESS'));
		}
		
	}
	
	
	public function editVariation($catID = 0)
    {
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		
		// check category valid or not
		$chk_cat = $this->db->get_where('variation_theme',array('id'=>$catID))->num_rows();
		if(!$chk_cat)
		{
			$this->Az->redirect('admin/store/variationList', 'system_message_error',lang('VARIATION_VALID_ERROR'));
		}

		// get category data
		$variationData = $this->db->get_where('variation_theme',array('id'=>$catID))->row_array();
		
		// get category data
		$variationOption = $this->db->order_by('order_no','asc')->get_where('variation_option',array('theme_id'=>$catID))->result_array();
		   	
		$siteUrl = site_url();
        $data = array(
            'site_url' => $siteUrl,
			'loggedUser' => $loggedUser,
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'content_block' => 'store/editVariation',
            'manager_description' => lang('SITE_NAME'),
            'variationData' => $variationData,
            'variationOption' => $variationOption,
			'variationID' => $catID,
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getSystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning() 
		);
        $this->parser->parse('admin/layout/column-1', $data);
		
    }
	
	public function updateVariation()
	{
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		$userID = $loggedUser['id'];
		$post = $this->input->post();
		
		$variationID = $post['variationID'];
		$this->load->library('form_validation');
		$this->form_validation->set_rules('label', 'Label', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$this->editVariation($variationID);
		}
		else
		{
			// update organizer detail
			$this->Store_model->update_variation($post,$variationID);
			$this->Az->redirect('admin/store/variationList', 'system_message_error',lang('VARIATION_SAVE_SUCCESS'));
		}
		
	}
	
	public function deleteVariation($attribute_id = 0, $uploadError = '')
	{
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		// check category valid or not
		$chk_cat = $this->db->get_where('variation_theme',array('id'=>$attribute_id))->num_rows();
		if(!$chk_cat)
		{
			$this->Az->redirect('admin/store/variationList', 'system_message_error',lang('VARIATION_VALID_ERROR'));
		}
		
		$this->db->where('id',$attribute_id);
		$this->db->delete('variation_theme');
		
		$this->db->where('theme_id',$attribute_id);
		$this->db->delete('variation_option');
		
		$this->Az->redirect('admin/store/variationList', 'system_message_info', lang('VARIATION_DELETE_SUCCESS'));
		
    }
	
}
?>