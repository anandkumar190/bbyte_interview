<?php
class Banners extends CI_Controller {    
    
    
    public function __construct() 
    {
        parent::__construct();
       	$this->User->checkPermission();
        $this->load->model('admin/Banners_model');		
        $this->lang->load('admin/dashboard', 'english');
        
    } 
    
	
	public function index()
    {
		
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		
        $bannerList = $this->db->order_by('id','desc')->get('banners')->result_array();
		
		
		$siteUrl = site_url();
		$data = array(
            'site_url' => $siteUrl,
            'meta_title' => 'Banners',
            'meta_keywords' => 'Banners',
            'meta_description' => 'Banners',
			'loggedUser' => $loggedUser,	
			'content_block' => 'banners/bannerList',
			'bannerList'=>$bannerList,
            'manager_description' => 'Banners',
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getSystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning()
        );
        $this->parser->parse('admin/layout/column-1', $data);
		
    }

	public function addBanner()
    {
		// get page list
		$bannerTypeList = $this->db->get('banner_type')->result_array();
		
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		$siteUrl = site_url();
        $data = array(
            'site_url' => $siteUrl,
			'loggedUser' => $loggedUser,
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'content_block' => 'banners/addBanner',
            'manager_description' => lang('SITE_NAME'),
			'bannerTypeList' => $bannerTypeList,
            'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getSystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning() 
		);
        $this->parser->parse('admin/layout/column-1', $data);
		
    }
   
	
	public function saveBanner()
	{
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		$userID = $loggedUser['id'];
		$post = $this->input->post();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('banner_type_id', 'Banner Type', 'required|xss_clean');
		if(!isset($_FILES['banner_image']['name']) || !$_FILES['banner_image']['name']){
			$this->form_validation->set_rules('banner_image', 'Banner Image', 'required|xss_clean');
		}
		if ($this->form_validation->run() == FALSE) {
			
			$this->addBanner();
		}
		else
		{	
			$banner_image_path = '';
            if ($_FILES['banner_image']['name'] != '') {
                //generate logo name randomly
                $fileName = rand(1111, 999999999);
                $config['upload_path'] = './media/banner_images/';
                $config['allowed_types'] = 'jpg|png|gif';
                $config['file_name'] = $fileName;
                $this->load->library('upload');
                $this->upload->initialize($config);
                $this->upload->do_upload('banner_image');
                $uploadError = $this->upload->display_errors();
                if ($uploadError) {
                     $this->Az->redirect('admin/banners', 'system_message_error', $uploadError);
                } else {
                   
                    $fileData = $this->upload->data();
                    //get uploaded file path
                    $banner_image_path = substr($config['upload_path'] . $fileData['file_name'], 2);
                }
            }

			$this->Banners_model->save_banner($post,$banner_image_path);
			$this->Az->redirect('admin/banners', 'system_message_error',lang('BANNER_SAVE_SUCCESS'));
		
		}
		
		
		
			
		
	}


	public function editBanner($id = 0)
    {
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		$chkBanner = $this->db->get_where('banners',array('id'=>$id))->num_rows();
		if(!$chkBanner)
		{
			$this->Az->redirect('admin/banners', 'system_message_error',lang('BANNER_VALID_ERROR'));
		}
		// get banner data
		$bannerData = $this->db->get_where('banners',array('id'=>$id))->row_array();
		$bannerTypeList = $this->db->get('banner_type')->result_array();
		
		$id=$id;
		$siteUrl = site_url();
        $data = array(
            'site_url' => $siteUrl,
			'loggedUser' => $loggedUser,
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'content_block' => 'banners/editBanner',
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

    public function updateBanner()
	{
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		$userID = $loggedUser['id'];
		$post = $this->input->post();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('banner_type_id', 'Banner Type', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			
			$this->editBanner($post['id']);
		}
		else
		{	
			$banner_image_path = '';
            if ($_FILES['banner_image']['name'] != '') {
                //generate logo name randomly
                $fileName = rand(1111, 999999999);
                $config['upload_path'] = './media/banner_images/';
                $config['allowed_types'] = 'jpg|png|gif';
                $config['file_name'] = $fileName;
                $this->load->library('upload');
                $this->upload->initialize($config);
                $this->upload->do_upload('banner_image');
                $uploadError = $this->upload->display_errors();
                if ($uploadError) {
                     $this->Az->redirect('admin/banners', 'system_message_error', $uploadError);
                } else {
                   
                    $fileData = $this->upload->data();
                    //get uploaded file path
                    $banner_image_path = substr($config['upload_path'] . $fileData['file_name'], 2);
                }
            }

			$this->Banners_model->update_banner($post,$banner_image_path);
			$this->Az->redirect('admin/banners', 'system_message_error',lang('BANNER_SAVE_SUCCESS'));
		
		}
		
		
		
			
		
	}


	public function deleteBanner($id)
	{
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		// check user valid or not
		
		$get_image_path = $this->db->select('image_path')->get_where('banners',array('id' => $id))->row_array();

		$image_path = isset($get_image_path['image_path']) ? $get_image_path['image_path'] : '';

		if($image_path)
		{
			if (file_exists($image_path)) 
			{
			    unlink(str_replace('system/', '', BASEPATH . $image_path));
			}
		}

		
		$this->db->where('id',$id);
		$this->db->delete('banners');
		
		$this->Az->redirect('admin/banners', 'system_message_info', lang('BANNER_DELETE_SUCCESS'));
		
    }
	
	


}
?>