<?php
class Section extends CI_Controller {    
    
    
    public function __construct() 
    {
        parent::__construct();
       	$this->User->checkPermission();
        $this->load->model('admin/Section_model');
        $this->lang->load('admin/dashboard', 'english');
        
    } 
    
	
	public function index()
    {
		
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		
        $bannerList = $this->db->order_by('id','desc')->get('sections')->result_array();
		
		
		$siteUrl = site_url();
		$data = array(
            'site_url' => $siteUrl,
            'meta_title' => 'Home Section',
            'meta_keywords' => 'Home Section',
            'meta_description' => 'Home Section',
			'loggedUser' => $loggedUser,	
			'bannerList' => $bannerList,	
			'content_block' => 'section/sectionList',
			'manager_description' => 'Home Section',
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getSystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning()
        );
        $this->parser->parse('admin/layout/column-1', $data);
		
    }


    public function addSection()
    {
		// get page list
		$bannerTypeList = $this->db->get('section_type')->result_array();
		
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		$siteUrl = site_url();
        $data = array(
            'site_url' => $siteUrl,
			'loggedUser' => $loggedUser,
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'content_block' => 'section/addSection',
            'manager_description' => lang('SITE_NAME'),
			'bannerTypeList' => $bannerTypeList,
            'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getSystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning() 
		);
        $this->parser->parse('admin/layout/column-1', $data);
		
    }
	
	public function saveSection()
	{
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		$userID = $loggedUser['id'];
		$post = $this->input->post();
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('section_type_id', 'Section Type', 'required|xss_clean');
		
		if ($this->form_validation->run() == FALSE) {
			
			$this->addSection();
		}
		else
		{
			if($post['section_type_id'] == 1)
			{
				$product_id = (isset($post['product_id'])) ? implode('|',$post['product_id']) : '';
				if($product_id == '')
				{
					$this->Az->redirect('admin/section/addSection', 'system_message_error',lang('SECTION_PRODUCT_SELECT_ERROR'));
				}
				$this->Section_model->save_product_section($post,$product_id);
				$this->Az->redirect('admin/section', 'system_message_error',lang('SECTION_SAVE_SUCCESS'));
			}
			elseif($post['section_type_id'] == 2)
			{
				$two_banner_1_image = '';
				if ($_FILES['two_banner_1_image']['name'] != '') {
					//generate logo name randomly
					$fileName = rand(1111, 999999999);
					$config['upload_path'] = './media/banner_images/';
					$config['allowed_types'] = 'jpg|png|gif';
					$config['file_name'] = $fileName;
					$this->load->library('upload');
					$this->upload->initialize($config);
					$this->upload->do_upload('two_banner_1_image');
					$uploadError = $this->upload->display_errors();
					if ($uploadError) {
						 $this->Az->redirect('admin/section/addSection', 'system_message_error', $uploadError);
					} else {
					   
						$fileData = $this->upload->data();
						//get uploaded file path
						$two_banner_1_image = substr($config['upload_path'] . $fileData['file_name'], 2);
					}
				}
				$two_banner_2_image = '';
				if ($_FILES['two_banner_2_image']['name'] != '') {
					//generate logo name randomly
					$fileName = rand(1111, 999999999);
					$config['upload_path'] = './media/banner_images/';
					$config['allowed_types'] = 'jpg|png|gif';
					$config['file_name'] = $fileName;
					$this->load->library('upload');
					$this->upload->initialize($config);
					$this->upload->do_upload('two_banner_2_image');
					$uploadError = $this->upload->display_errors();
					if ($uploadError) {
						 $this->Az->redirect('admin/section/addSection', 'system_message_error', $uploadError);
					} else {
					   
						$fileData = $this->upload->data();
						//get uploaded file path
						$two_banner_2_image = substr($config['upload_path'] . $fileData['file_name'], 2);
					}
				}
				
				$this->Section_model->save_two_banner_section($post,$two_banner_1_image,$two_banner_2_image);
				$this->Az->redirect('admin/section', 'system_message_error',lang('SECTION_SAVE_SUCCESS'));
			}
			elseif($post['section_type_id'] == 3)
			{
				
				$five_banner_small_1_image = '';
				if ($_FILES['five_banner_small_1_image']['name'] != '') {
					//generate logo name randomly
					$fileName = rand(1111, 999999999);
					$config['upload_path'] = './media/banner_images/';
					$config['allowed_types'] = 'jpg|png|gif';
					$config['file_name'] = $fileName;
					$this->load->library('upload');
					$this->upload->initialize($config);
					$this->upload->do_upload('five_banner_small_1_image');
					$uploadError = $this->upload->display_errors();
					if ($uploadError) {
						 $this->Az->redirect('admin/section/addSection', 'system_message_error', $uploadError);
					} else {
					   
						$fileData = $this->upload->data();
						//get uploaded file path
						$five_banner_small_1_image = substr($config['upload_path'] . $fileData['file_name'], 2);
					}
				}
				$five_banner_small_2_image = '';
				if ($_FILES['five_banner_small_2_image']['name'] != '') {
					//generate logo name randomly
					$fileName = rand(1111, 999999999);
					$config['upload_path'] = './media/banner_images/';
					$config['allowed_types'] = 'jpg|png|gif';
					$config['file_name'] = $fileName;
					$this->load->library('upload');
					$this->upload->initialize($config);
					$this->upload->do_upload('five_banner_small_2_image');
					$uploadError = $this->upload->display_errors();
					if ($uploadError) {
						 $this->Az->redirect('admin/section/addSection', 'system_message_error', $uploadError);
					} else {
					   
						$fileData = $this->upload->data();
						//get uploaded file path
						$five_banner_small_2_image = substr($config['upload_path'] . $fileData['file_name'], 2);
					}
				}
				$five_banner_small_3_image = '';
				if ($_FILES['five_banner_small_3_image']['name'] != '') {
					//generate logo name randomly
					$fileName = rand(1111, 999999999);
					$config['upload_path'] = './media/banner_images/';
					$config['allowed_types'] = 'jpg|png|gif';
					$config['file_name'] = $fileName;
					$this->load->library('upload');
					$this->upload->initialize($config);
					$this->upload->do_upload('five_banner_small_3_image');
					$uploadError = $this->upload->display_errors();
					if ($uploadError) {
						 $this->Az->redirect('admin/section/addSection', 'system_message_error', $uploadError);
					} else {
					   
						$fileData = $this->upload->data();
						//get uploaded file path
						$five_banner_small_3_image = substr($config['upload_path'] . $fileData['file_name'], 2);
					}
				}
				
				$this->Section_model->save_five_banner_section($post,$five_banner_small_1_image,$five_banner_small_2_image,$five_banner_small_3_image);
				$this->Az->redirect('admin/section', 'system_message_error',lang('SECTION_SAVE_SUCCESS'));
			}
			

			
		
		}
		
		
		
			
		
	}
   
   
	public function editSection($id = 0)
    {
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		$chkBanner = $this->db->get_where('sections',array('id'=>$id))->num_rows();
		if(!$chkBanner)
		{
			$this->Az->redirect('admin/section', 'system_message_error',lang('SECTION_VALID_ERROR'));
		}
		// get banner data
		$bannerData = $this->db->get_where('sections',array('id'=>$id))->row_array();
		$bannerTypeList = $this->db->get('section_type')->result_array();
		
		$id=$id;
		$siteUrl = site_url();
        $data = array(
            'site_url' => $siteUrl,
			'loggedUser' => $loggedUser,
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'content_block' => 'section/editSection',
            'manager_description' => lang('SITE_NAME'),
            'bannerData' => $bannerData,
            'bannerTypeList'=>$bannerTypeList,
            'id' => $id,
            'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getSystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning() 
		);
        $this->parser->parse('admin/layout/column-1', $data);
		
    }

    public function updateSection()
	{
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		$userID = $loggedUser['id'];
		$post = $this->input->post();
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('section_type_id', 'Section Type', 'required|xss_clean');
		
		if ($this->form_validation->run() == FALSE) {
			
			$this->editSection($post['sectionID']);
		}
		else
		{
			if($post['section_type_id'] == 1)
			{
				$product_id = (isset($post['product_id'])) ? implode('|',$post['product_id']) : '';
				if($product_id == '')
				{
					$this->Az->redirect('admin/section/editSection/'.$post['sectionID'], 'system_message_error',lang('SECTION_PRODUCT_SELECT_ERROR'));
				}
				$this->Section_model->update_product_section($post,$product_id);
				$this->Az->redirect('admin/section', 'system_message_error',lang('SECTION_SAVE_SUCCESS'));
			}
			elseif($post['section_type_id'] == 2)
			{
				$two_banner_1_image = '';
				if ($_FILES['two_banner_1_image']['name'] != '') {
					//generate logo name randomly
					$fileName = rand(1111, 999999999);
					$config['upload_path'] = './media/banner_images/';
					$config['allowed_types'] = 'jpg|png|gif';
					$config['file_name'] = $fileName;
					$this->load->library('upload');
					$this->upload->initialize($config);
					$this->upload->do_upload('two_banner_1_image');
					$uploadError = $this->upload->display_errors();
					if ($uploadError) {
						 $this->Az->redirect('admin/section/editSection/'.$post['sectionID'], 'system_message_error', $uploadError);
					} else {
					   
						$fileData = $this->upload->data();
						//get uploaded file path
						$two_banner_1_image = substr($config['upload_path'] . $fileData['file_name'], 2);
					}
				}
				$two_banner_2_image = '';
				if ($_FILES['two_banner_2_image']['name'] != '') {
					//generate logo name randomly
					$fileName = rand(1111, 999999999);
					$config['upload_path'] = './media/banner_images/';
					$config['allowed_types'] = 'jpg|png|gif';
					$config['file_name'] = $fileName;
					$this->load->library('upload');
					$this->upload->initialize($config);
					$this->upload->do_upload('two_banner_2_image');
					$uploadError = $this->upload->display_errors();
					if ($uploadError) {
						 $this->Az->redirect('admin/section/editSection/'.$post['sectionID'], 'system_message_error', $uploadError);
					} else {
					   
						$fileData = $this->upload->data();
						//get uploaded file path
						$two_banner_2_image = substr($config['upload_path'] . $fileData['file_name'], 2);
					}
				}
				
				$this->Section_model->update_two_banner_section($post,$two_banner_1_image,$two_banner_2_image);
				$this->Az->redirect('admin/section', 'system_message_error',lang('SECTION_SAVE_SUCCESS'));
			}
			elseif($post['section_type_id'] == 3)
			{
				
				$five_banner_small_1_image = '';
				if ($_FILES['five_banner_small_1_image']['name'] != '') {
					//generate logo name randomly
					$fileName = rand(1111, 999999999);
					$config['upload_path'] = './media/banner_images/';
					$config['allowed_types'] = 'jpg|png|gif';
					$config['file_name'] = $fileName;
					$this->load->library('upload');
					$this->upload->initialize($config);
					$this->upload->do_upload('five_banner_small_1_image');
					$uploadError = $this->upload->display_errors();
					if ($uploadError) {
						 $this->Az->redirect('admin/section/editSection/'.$post['sectionID'], 'system_message_error', $uploadError);
					} else {
					   
						$fileData = $this->upload->data();
						//get uploaded file path
						$five_banner_small_1_image = substr($config['upload_path'] . $fileData['file_name'], 2);
					}
				}
				$five_banner_small_2_image = '';
				if ($_FILES['five_banner_small_2_image']['name'] != '') {
					//generate logo name randomly
					$fileName = rand(1111, 999999999);
					$config['upload_path'] = './media/banner_images/';
					$config['allowed_types'] = 'jpg|png|gif';
					$config['file_name'] = $fileName;
					$this->load->library('upload');
					$this->upload->initialize($config);
					$this->upload->do_upload('five_banner_small_2_image');
					$uploadError = $this->upload->display_errors();
					if ($uploadError) {
						 $this->Az->redirect('admin/section/editSection/'.$post['sectionID'], 'system_message_error', $uploadError);
					} else {
					   
						$fileData = $this->upload->data();
						//get uploaded file path
						$five_banner_small_2_image = substr($config['upload_path'] . $fileData['file_name'], 2);
					}
				}
				$five_banner_small_3_image = '';
				if ($_FILES['five_banner_small_3_image']['name'] != '') {
					//generate logo name randomly
					$fileName = rand(1111, 999999999);
					$config['upload_path'] = './media/banner_images/';
					$config['allowed_types'] = 'jpg|png|gif';
					$config['file_name'] = $fileName;
					$this->load->library('upload');
					$this->upload->initialize($config);
					$this->upload->do_upload('five_banner_small_3_image');
					$uploadError = $this->upload->display_errors();
					if ($uploadError) {
						 $this->Az->redirect('admin/section/editSection/'.$post['sectionID'], 'system_message_error', $uploadError);
					} else {
					   
						$fileData = $this->upload->data();
						//get uploaded file path
						$five_banner_small_3_image = substr($config['upload_path'] . $fileData['file_name'], 2);
					}
				}
				
				$this->Section_model->update_five_banner_section($post,$five_banner_small_1_image,$five_banner_small_2_image,$five_banner_small_3_image);
				$this->Az->redirect('admin/section', 'system_message_error',lang('SECTION_SAVE_SUCCESS'));
			}
		}
	}


	public function deleteSection($id = 0)
	{
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		// check user valid or not
		$chkBanner = $this->db->get_where('sections',array('id'=>$id))->num_rows();
		if(!$chkBanner)
		{
			$this->Az->redirect('admin/section', 'system_message_error',lang('SECTION_VALID_ERROR'));
		}
		$get_image_path = $this->db->select('*')->get_where('sections',array('id' => $id))->row_array();

		$banner_1_image = isset($get_image_path['banner_1_image']) ? $get_image_path['banner_1_image'] : '';
		$banner_2_image = isset($get_image_path['banner_2_image']) ? $get_image_path['banner_2_image'] : '';
		$banner_3_image = isset($get_image_path['banner_3_image']) ? $get_image_path['banner_3_image'] : '';
		$banner_4_image = isset($get_image_path['banner_4_image']) ? $get_image_path['banner_4_image'] : '';
		$banner_large_image = isset($get_image_path['banner_large_image']) ? $get_image_path['banner_large_image'] : '';

		if($banner_1_image)
		{
			if (file_exists($banner_1_image)) 
			{
			    unlink(str_replace('system/', '', BASEPATH . $banner_1_image));
			}
		}
		if($banner_2_image)
		{
			if (file_exists($banner_2_image)) 
			{
			    unlink(str_replace('system/', '', BASEPATH . $banner_2_image));
			}
		}
		if($banner_3_image)
		{
			if (file_exists($banner_3_image)) 
			{
			    unlink(str_replace('system/', '', BASEPATH . $banner_3_image));
			}
		}
		if($banner_4_image)
		{
			if (file_exists($banner_4_image)) 
			{
			    unlink(str_replace('system/', '', BASEPATH . $banner_4_image));
			}
		}
		if($banner_large_image)
		{
			if (file_exists($banner_large_image)) 
			{
			    unlink(str_replace('system/', '', BASEPATH . $banner_large_image));
			}
		}

		
		$this->db->where('id',$id);
		$this->db->delete('sections');
		
		$this->Az->redirect('admin/section', 'system_message_info', lang('SECTION_DELETE_SUCCESS'));
		
    }


}
?>