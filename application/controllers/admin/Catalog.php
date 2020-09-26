<?php
class Catalog extends CI_Controller {    
    
    
    public function __construct() 
    {
        parent::__construct();
       	$this->User->checkPermission();
        $this->load->model('admin/Catalog_model');		
        $this->load->model('admin/Section_model');		
        $this->lang->load('admin/dashboard', 'english');
        
    } 
    
	public function categoryList()
    {
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		
        $categoryList = $this->db->order_by('order_number','asc')->get_where('category',array('parent_id'=>0))->result_array();
		$parent_category_list = array();
		$j = 0;
		if($categoryList)
		{
			foreach($categoryList as $key=>$list)
			{
				$parent_category_list[$j]['id'] = $list['id'];
				$parent_category_list[$j]['title'] = $list['title'];
				$parent_category_list[$j]['menu_status'] = $list['menu_status'];
				$parent_category_list[$j]['status'] = $list['status'];
				$j++;
				$cat_id = $list['id'];
				$subCategoryList = $this->db->order_by('order_number','asc')->get_where('category',array('parent_id'=>$cat_id))->result_array();
				if($subCategoryList)
				{
					foreach($subCategoryList as $subKey=>$subList)
					{
						$parent_category_list[$j]['id'] = $subList['id'];
						$parent_category_list[$j]['title'] = '-'.$subList['title'];
						$parent_category_list[$j]['menu_status'] = $list['menu_status'];
						$parent_category_list[$j]['status'] = $list['status'];
						$j++;
						$sub_cat_id = $subList['id'];
						$subSubCategoryList = $this->db->order_by('order_number','asc')->get_where('category',array('parent_id'=>$sub_cat_id))->result_array();
						if($subSubCategoryList)
						{
							foreach($subSubCategoryList as $subSubKey=>$subSubList)
							{
								$parent_category_list[$j]['id'] = $subSubList['id'];
								$parent_category_list[$j]['title'] = '--'.$subSubList['title'];
								$parent_category_list[$j]['menu_status'] = $list['menu_status'];
								$parent_category_list[$j]['status'] = $list['status'];
								$j++;
								$sub_sub_cat_id = $subSubList['id'];
								$subSubSubCategoryList = $this->db->order_by('order_number','asc')->get_where('category',array('parent_id'=>$sub_sub_cat_id))->result_array();
								if($subSubSubCategoryList)
								{
									foreach($subSubSubCategoryList as $subSubSubKey=>$subSubSubList)
									{
										$sub_sub_sub_cat_id = $subSubSubList['id'];
										$parent_category_list[$j]['id'] = $subSubSubList['id'];
										$parent_category_list[$j]['title'] = '---'.$subSubSubList['title'];
										$parent_category_list[$j]['menu_status'] = $list['menu_status'];
										$parent_category_list[$j]['status'] = $list['status'];
										$j++;
									}
								}
							}
						}
					}
				}
			}
		}
		
		
		
		$siteUrl = site_url();
		$data = array(
            'site_url' => $siteUrl,
            'meta_title' => 'Category List',
            'meta_keywords' => 'Category List',
            'meta_description' => 'Category List',
			'loggedUser' => $loggedUser,	
			'content_block' => 'catalog/categoryList',
            'manager_description' => 'Category List',
			'categoryList' => $parent_category_list,
            'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getSystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning()
        );
        $this->parser->parse('admin/layout/column-1', $data);
		
    }

	public function addCategory()
    {
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");

		$categoryList = $this->db->order_by('created','desc')->get_where('category',array('parent_id'=>0))->result_array();
		$parent_category_list = array();
		$j = 0;
		if($categoryList)
		{
			foreach($categoryList as $key=>$list)
			{
				$parent_category_list[$j]['id'] = $list['id'];
				$parent_category_list[$j]['title'] = $list['title'];
				$j++;
				$cat_id = $list['id'];
				$subCategoryList = $this->db->order_by('created','desc')->get_where('category',array('parent_id'=>$cat_id))->result_array();
				if($subCategoryList)
				{
					foreach($subCategoryList as $subKey=>$subList)
					{
						$parent_category_list[$j]['id'] = $subList['id'];
						$parent_category_list[$j]['title'] = '-'.$subList['title'];
						$j++;
						$sub_cat_id = $subList['id'];
						$subSubCategoryList = $this->db->order_by('created','desc')->get_where('category',array('parent_id'=>$sub_cat_id))->result_array();
						if($subSubCategoryList)
						{
							foreach($subSubCategoryList as $subSubKey=>$subSubList)
							{
								$parent_category_list[$j]['id'] = $subSubList['id'];
								$parent_category_list[$j]['title'] = '--'.$subSubList['title'];
								$j++;
								$sub_sub_cat_id = $subSubList['id'];
								$subSubSubCategoryList = $this->db->order_by('created','desc')->get_where('category',array('parent_id'=>$sub_sub_cat_id))->result_array();
								if($subSubSubCategoryList)
								{
									foreach($subSubSubCategoryList as $subSubSubKey=>$subSubSubList)
									{
										$sub_sub_sub_cat_id = $subSubSubList['id'];
										$parent_category_list[$j]['id'] = $subSubSubList['id'];
										$parent_category_list[$j]['title'] = '---'.$subSubSubList['title'];
										$j++;
									}
								}
							}
						}
					}
				}
			}
		}
		
		
		   	
		$siteUrl = site_url();
        $data = array(
            'site_url' => $siteUrl,
			'loggedUser' => $loggedUser,
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'content_block' => 'catalog/addCategory',
            'manager_description' => lang('SITE_NAME'),
			'parent_category_list' => $parent_category_list,
            'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getSystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning() 
		);
        $this->parser->parse('admin/layout/column-1', $data);
		
    }
   
	
	public function saveCategory()
	{
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		$userID = $loggedUser['id'];
		$post = $this->input->post();
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Title', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			
			$this->addCategory();
		}
		else
		{
			// update organizer detail
			$this->Catalog_model->save_category($post);
			$this->Az->redirect('admin/catalog/addCategory', 'system_message_error',lang('CATEGORY_SAVE_SUCCESS'));
		}
		
	}


	public function editCategory($catID = 0)
    {
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		
		// check category valid or not
		$chk_cat = $this->db->get_where('category',array('id'=>$catID))->num_rows();
		if(!$chk_cat)
		{
			$this->Az->redirect('admin/catalog/categoryList', 'system_message_error',lang('CATEGORY_VALID_ERROR'));
		}

		// get category data
		$categoryData = $this->db->get_where('category',array('id'=>$catID))->row_array();
		
		$categoryList = $this->db->order_by('created','desc')->get_where('category',array('parent_id'=>0))->result_array();
		$parent_category_list = array();
		$j = 0;
		if($categoryList)
		{
			foreach($categoryList as $key=>$list)
			{
				$parent_category_list[$j]['id'] = $list['id'];
				$parent_category_list[$j]['title'] = $list['title'];
				$j++;
				$cat_id = $list['id'];
				$subCategoryList = $this->db->order_by('created','desc')->get_where('category',array('parent_id'=>$cat_id))->result_array();
				if($subCategoryList)
				{
					foreach($subCategoryList as $subKey=>$subList)
					{
						$parent_category_list[$j]['id'] = $subList['id'];
						$parent_category_list[$j]['title'] = '-'.$subList['title'];
						$j++;
						$sub_cat_id = $subList['id'];
						$subSubCategoryList = $this->db->order_by('created','desc')->get_where('category',array('parent_id'=>$sub_cat_id))->result_array();
						if($subSubCategoryList)
						{
							foreach($subSubCategoryList as $subSubKey=>$subSubList)
							{
								$parent_category_list[$j]['id'] = $subSubList['id'];
								$parent_category_list[$j]['title'] = '--'.$subSubList['title'];
								$j++;
								$sub_sub_cat_id = $subSubList['id'];
								$subSubSubCategoryList = $this->db->order_by('created','desc')->get_where('category',array('parent_id'=>$sub_sub_cat_id))->result_array();
								if($subSubSubCategoryList)
								{
									foreach($subSubSubCategoryList as $subSubSubKey=>$subSubSubList)
									{
										$sub_sub_sub_cat_id = $subSubSubList['id'];
										$parent_category_list[$j]['id'] = $subSubSubList['id'];
										$parent_category_list[$j]['title'] = '---'.$subSubSubList['title'];
										$j++;
									}
								}
							}
						}
					}
				}
			}
		}
		   	
		$siteUrl = site_url();
        $data = array(
            'site_url' => $siteUrl,
			'loggedUser' => $loggedUser,
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'content_block' => 'catalog/editCategory',
            'manager_description' => lang('SITE_NAME'),
            'categoryData' => $categoryData,
            'catID' => $catID,
			'parent_category_list' => $parent_category_list,
          	'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getSystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning() 
		);
        $this->parser->parse('admin/layout/column-1', $data);
		
    }

    public function updateCategory()
	{
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		$userID = $loggedUser['id'];
		$post = $this->input->post();
		$catID = $post['catID'];
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Title', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			
			$this->editCategory($catID);
		}
		else
		{
			// update organizer detail
			$this->Catalog_model->update_category($post);
			$this->Az->redirect('admin/catalog/categoryList', 'system_message_error',lang('CATEGORY_UPDATE_SUCCESS'));
		
		}
		
		
			
		
	}


	public function deleteCategory($catID = 0, $uploadError = '')
	{
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		// check category valid or not
		$chk_cat = $this->db->get_where('category',array('id'=>$catID))->num_rows();
		if(!$chk_cat)
		{
			$this->Az->redirect('admin/catalog/categoryList', 'system_message_error',lang('CATEGORY_VALID_ERROR'));
		}
		
		$subCategoryList = $this->db->order_by('created','desc')->get_where('category',array('parent_id'=>$catID))->result_array();
		if($subCategoryList)
		{
			foreach($subCategoryList as $subKey=>$subList)
			{
				
				$sub_cat_id = $subList['id'];
				$subSubCategoryList = $this->db->order_by('created','desc')->get_where('category',array('parent_id'=>$sub_cat_id))->result_array();
				if($subSubCategoryList)
				{
					foreach($subSubCategoryList as $subSubKey=>$subSubList)
					{
						
						$sub_sub_cat_id = $subSubList['id'];
						$subSubSubCategoryList = $this->db->order_by('created','desc')->get_where('category',array('parent_id'=>$sub_sub_cat_id))->result_array();
						if($subSubSubCategoryList)
						{
							foreach($subSubSubCategoryList as $subSubSubKey=>$subSubSubList)
							{
								$sub_sub_sub_cat_id = $subSubSubList['id'];
								$this->db->where('id',$sub_sub_sub_cat_id);
								$this->db->delete('category');
							}
						}
						
						$this->db->where('id',$sub_sub_cat_id);
						$this->db->delete('category');
					}
				}
				
				$this->db->where('id',$sub_cat_id);
				$this->db->delete('category');
			}
		}
		
		$this->db->where('id',$catID);
		$this->db->delete('category');
		$this->Az->redirect('admin/catalog/categoryList', 'system_message_info', lang('CATEGORY_DELETE_SUCCESS'));
		
    }
	
	
	public function productList()
    {
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		
		// get vendor list
		$vendorList = $this->db->select('id,name')->get_where('users',array('role_id'=>3))->result_array();
		
		$siteUrl = site_url();
		$data = array(
            'site_url' => $siteUrl,
            'meta_title' => 'Product List',
            'meta_keywords' => 'Product List',
            'meta_description' => 'Product List',
			'loggedUser' => $loggedUser,	
			'content_block' => 'catalog/productList',
            'manager_description' => 'Product List',
			'vendorList' => $vendorList,
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getSystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning()
        );
        $this->parser->parse('admin/layout/column-1', $data);
		
    }
	
	public function getProductList()
	{
		
		$requestData= $this->input->get();
		$extra_search = $requestData['extra_search'];
		$stock_status = 0;
		$keyword = 0;
		$approve_status = 0;
		$vendor_id = 0;
		if($extra_search)
		{
			$filterData = explode('-',$extra_search);
			$stock_status = isset($filterData[0]) ? $filterData[0] : 0;
			$keyword = isset($filterData[1]) ? $filterData[1] : 0;
			$approve_status = isset($filterData[2]) ? $filterData[2] : 0;
			$vendor_id = isset($filterData[3]) ? $filterData[3] : 0;
			
		}
		
		$columns = array( 
		// datatable column index  => database column name
			1 => 'a.id',
			3 => 'a.product_name',
			5 => 'a.sku',
			6 => 'a.price',
			7 => 'b.title',
			8 => 'a.quantity',
			9 => 'a.stock_status',
			11 => 'a.status',
			13 => 'a.created',
		);
		
		
			// getting total number records without any search
			$sql = "SELECT a.*, b.title as attribute_set_name, c.name as seller_name ";
			$sql.="FROM tbl_products as a ";
			$sql.="LEFT JOIN tbl_attribute_set as b ON b.id = a.attribute_set_id ";
			$sql.="LEFT JOIN tbl_users as c ON c.id = a.account_id ";
			$sql.="ORDER BY a.created DESC";
			
		
			$totalData = $this->db->query($sql)->num_rows();
			$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
		
			$sql = "SELECT a.*, b.title as attribute_set_name, c.name as seller_name ";
			$sql.="FROM tbl_products as a ";
			$sql.="LEFT JOIN tbl_attribute_set as b ON b.id = a.attribute_set_id ";
			$sql.="LEFT JOIN tbl_users as c ON c.id = a.account_id ";
			$sql.=" WHERE a.id > 0";
			if($stock_status == 1)
			{
				$sql.=" AND a.stock_status = '1'";
			}
			elseif($stock_status == 2)
			{
				$sql.=" AND a.stock_status = '0'";
			}
			
			if($approve_status)
			{
				$sql.=" AND a.approve_status = '$approve_status'";
			}
			
			if($vendor_id)
			{
				$sql.=" AND a.account_id = '$vendor_id'";
			}
			
			if($keyword != '') {   
				$sql.=" AND ( a.id LIKE '".$keyword."%' ";    
				$sql.=" OR a.product_name LIKE '".$keyword."%' ";
				$sql.=" OR a.sku LIKE '".$keyword."%' ";
				$sql.=" OR a.price LIKE '".$keyword."%' ";
				$sql.=" OR b.title LIKE '".$keyword."%' ";
				$sql.=" OR a.quantity LIKE '".$keyword."%' )";
				
			}
			
			$order_type = $requestData['order'][0]['dir'];
			//if($requestData['draw'] == 1)
			//	$order_type = 'DESC';
			
			$order_no = isset($requestData['order'][0]['column']) ? ($requestData['order'][0]['column'] == 0) ? 1 : $requestData['order'][0]['column'] : 1;
			$totalFiltered = $this->db->query($sql)->num_rows();
			$sql.=" ORDER BY ". $columns[$order_no]."   ".$order_type."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
		
		
		
		$get_filter_data = $this->db->query($sql)->result_array();
		
		$data = array();
		$totalrecord = 0;
		if($get_filter_data){
			foreach($get_filter_data as $list){
				
				$nestedData=array(); 
				
				$product_id = $list['id'];
				$pro_account_id = $list['account_id'];
				
				// get thumbnail
				$get_thumbnail_img = $this->db->get_where('product_images',array('product_id'=>$product_id,'is_base'=>1))->row_array();
				$img = isset($get_thumbnail_img['file_name']) ? base_url('media/product_images/thumbnail-70x70/'.$get_thumbnail_img['file_name']) : '';
				
				
				$nestedData[] = '<input type="checkbox" class="product_chkbox" name="product_id[]" value="'.$list['id'].'" />';
				$nestedData[] = $list['id'];
				$nestedData[] = ($img) ? '<img src="'.$img.'" width="50" />' : 'Not Uploaded';
				$nestedData[] = $list['seller_name'];
				$nestedData[] = $list['product_name'];
				$nestedData[] = $list['sku'];
				$nestedData[] = 'INR '.$list['price'];
				$nestedData[] = ($list['attribute_set_name']) ? $list['attribute_set_name'] : 'Not Set';
				$nestedData[] = $list['quantity'];
				$nestedData[] = ($list['stock_status']) ? 'In Stock' : 'Out of Stock';
				if($list['status']) {
					$nestedData[] = '<font color="green">Enable</font>';
				}
				else
				{
					$nestedData[] = '<font color="red">Disable</font>';
				}
				
				if($list['approve_status'] == 1) {
					$nestedData[] = '<font color="orange">Pending</font>';
				}
				elseif($list['approve_status'] == 2) {
					$nestedData[] = '<font color="green">Approved</font>';
				}
				else
				{
					$nestedData[] = '<font color="red">Rejected</font>';
				}
				
				$nestedData[] = date('d-m-Y',strtotime($list['created']));
				$nestedData[] = '<a title="edit" class="btn btn-primary btn-sm" href="'.base_url('admin/catalog/editProduct').'/'.$list['id'].'"><i class="fa fa-edit" aria-hidden="true"></i></a>';
				$nestedData[] = '<a title="delete" class="btn btn-danger btn-sm" href="'.base_url('admin/catalog/deleteProduct').'/'.$list['id'].'" onclick="return confirm(\'Are you sure you want to delete?\')"><i class="fa fa-trash" aria-hidden="true"></i></a>';
				$data[] = $nestedData;
				
				
				
			}
		}



		$json_data = array(
					"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
					"recordsTotal"    => intval( $totalData ),  // total number of records
					"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
					"data"            => $data,   // total data array
					);

		echo json_encode($json_data);  // send data as json format
	}
	
	public function getSectionProductList()
	{
		
		$requestData= $this->input->get();
		$extra_search = $requestData['extra_search'];
		$sectionID = 0;
		$keyword = 0;
		$approve_status = 0;
		$vendor_id = 0;
		if($extra_search)
		{
			$filterData = explode('|',$extra_search);
			$sectionID = isset($filterData[0]) ? $filterData[0] : 0;
			$keyword = isset($filterData[1]) ? $filterData[1] : 0;
			$approve_status = isset($filterData[2]) ? $filterData[2] : 0;
			$vendor_id = isset($filterData[3]) ? $filterData[3] : 0;
			
		}
		
		$columns = array( 
		// datatable column index  => database column name
			1 => 'a.id',
			3 => 'a.product_name',
			4 => 'a.sku',
		);
		
		
			// getting total number records without any search
			$sql = "SELECT a.*, b.title as attribute_set_name ";
			$sql.="FROM tbl_products as a ";
			$sql.="LEFT JOIN tbl_attribute_set as b ON b.id = a.attribute_set_id ";
			$sql.="ORDER BY a.created DESC";
			
		
			$totalData = $this->db->query($sql)->num_rows();
			$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
		
			$sql = "SELECT a.*, b.title as attribute_set_name ";
			$sql.="FROM tbl_products as a ";
			$sql.="LEFT JOIN tbl_attribute_set as b ON b.id = a.attribute_set_id ";
			$sql.=" WHERE a.id > 0";
			
			if($approve_status)
			{
				$sql.=" AND a.approve_status = '$approve_status'";
			}
			
			if($vendor_id)
			{
				$sql.=" AND a.account_id = '$vendor_id'";
			}
			
			if(!empty($requestData['search']['value'])) {
				$keyword = $requestData['search']['value'];
				$sql.=" AND ( a.id LIKE '".$keyword."%' ";    
				$sql.=" OR a.product_name LIKE '".$keyword."%' ";
				$sql.=" OR a.sku LIKE '".$keyword."%' ";
				$sql.=" OR a.price LIKE '".$keyword."%' ";
				$sql.=" OR b.title LIKE '".$keyword."%' ";
				$sql.=" OR a.quantity LIKE '".$keyword."%' )";
				
			}
			
			$order_type = $requestData['order'][0]['dir'];
			//if($requestData['draw'] == 1)
			//	$order_type = 'DESC';
			
			$order_no = isset($requestData['order'][0]['column']) ? ($requestData['order'][0]['column'] == 0) ? 1 : $requestData['order'][0]['column'] : 1;
			$totalFiltered = $this->db->query($sql)->num_rows();
			$sql.=" ORDER BY ". $columns[$order_no]."   ".$order_type."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
		
		
		
		$get_filter_data = $this->db->query($sql)->result_array();
		
		$section_product_id = array();
		if($sectionID)
		{
			// get section product
			$secProductList = $this->db->select('product_id')->get_where('sections',array('id'=>$sectionID))->row_array();
			$section_product_id = isset($secProductList['product_id']) ? array_filter(explode('|',$secProductList['product_id'])) : array();
		}
		
		$data = array();
		$totalrecord = 0;
		if($get_filter_data){
			foreach($get_filter_data as $list){
				
				$nestedData=array(); 
				
				$product_id = $list['id'];
				$pro_account_id = $list['account_id'];
				
				// get thumbnail
				$get_thumbnail_img = $this->db->get_where('product_images',array('product_id'=>$product_id,'is_base'=>1))->row_array();
				$img = isset($get_thumbnail_img['file_name']) ? base_url('media/product_images/thumbnail-70x70/'.$get_thumbnail_img['file_name']) : '';
				
				if($sectionID && in_array($list['id'],$section_product_id))
				{
					$nestedData[] = '<input type="checkbox" checked="checked" class="product_chkbox" name="product_id[]" value="'.$list['id'].'" />';
				}
				else
				{
					$nestedData[] = '<input type="checkbox" class="product_chkbox" name="product_id[]" value="'.$list['id'].'" />';
				}
				$nestedData[] = $list['id'];
				$nestedData[] = ($img) ? '<img src="'.$img.'" width="50" />' : 'Not Uploaded';
				$nestedData[] = $list['product_name'];
				$nestedData[] = $list['sku'];
				
				$data[] = $nestedData;
				
				
				
			}
		}



		$json_data = array(
					"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
					"recordsTotal"    => intval( $totalData ),  // total number of records
					"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
					"data"            => $data,   // total data array
					);

		echo json_encode($json_data);  // send data as json format
	}
	
	public function getCouponProductList()
	{
		$requestData= $this->input->get();
		$extra_search = $requestData['extra_search'];
		$sectionID = 0;
		$keyword = 0;
		$approve_status = 0;
		$vendor_id = 0;
		if($extra_search)
		{
			$filterData = explode('|',$extra_search);
			$sectionID = isset($filterData[0]) ? $filterData[0] : 0;
			$keyword = isset($filterData[1]) ? $filterData[1] : 0;
			$approve_status = isset($filterData[2]) ? $filterData[2] : 0;
			$vendor_id = isset($filterData[3]) ? $filterData[3] : 0;
			
		}
		
		$columns = array( 
		// datatable column index  => database column name
			1 => 'a.id',
			3 => 'a.product_name',
			4 => 'a.sku',
		);
		
		
			// getting total number records without any search
			$sql = "SELECT a.*, b.title as attribute_set_name ";
			$sql.="FROM tbl_products as a ";
			$sql.="LEFT JOIN tbl_attribute_set as b ON b.id = a.attribute_set_id ";
			$sql.="ORDER BY a.created DESC";
			
		
			$totalData = $this->db->query($sql)->num_rows();
			$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
		
			$sql = "SELECT a.*, b.title as attribute_set_name ";
			$sql.="FROM tbl_products as a ";
			$sql.="LEFT JOIN tbl_attribute_set as b ON b.id = a.attribute_set_id ";
			$sql.="WHERE a.id > 0";
			
			if($approve_status)
			{
				$sql.=" AND a.approve_status = '$approve_status'";
			}
			
			
			
			if(!empty($requestData['search']['value'])) {
				$keyword = $requestData['search']['value'];
				$sql.=" AND ( a.id LIKE '".$keyword."%' ";    
				$sql.=" OR a.product_name LIKE '".$keyword."%' ";
				$sql.=" OR a.sku LIKE '".$keyword."%' ";
				$sql.=" OR a.price LIKE '".$keyword."%' ";
				$sql.=" OR b.title LIKE '".$keyword."%' ";
				$sql.=" OR a.quantity LIKE '".$keyword."%' )";
				
			}
			
			$order_type = $requestData['order'][0]['dir'];
			//if($requestData['draw'] == 1)
			//	$order_type = 'DESC';
			
			$order_no = isset($requestData['order'][0]['column']) ? ($requestData['order'][0]['column'] == 0) ? 1 : $requestData['order'][0]['column'] : 1;
			$totalFiltered = $this->db->query($sql)->num_rows();
			$sql.=" ORDER BY ". $columns[$order_no]."   ".$order_type."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
		
		
		
		$get_filter_data = $this->db->query($sql)->result_array();
		
		$section_product_id = array();
		if($sectionID)
		{
			// get coupon category
			$couponCategory = $this->db->get_where('coupon_product',array('coupon_id'=>$sectionID))->result_array();
			if($couponCategory)
			{
				foreach($couponCategory as $cKey=>$cList)
				{
					$section_product_id[$cKey] = $cList['product_id'];
				}
			}
		}
		
		$data = array();
		$totalrecord = 0;
		if($get_filter_data){
			foreach($get_filter_data as $list){
				
				$nestedData=array(); 
				
				$product_id = $list['id'];
				$pro_account_id = $list['account_id'];
				
				// get thumbnail
				$get_thumbnail_img = $this->db->get_where('product_images',array('product_id'=>$product_id,'is_large'=>1))->row_array();
				$img = isset($get_thumbnail_img['image_path']) ? base_url($get_thumbnail_img['image_path']) : '';
				
				if($sectionID && in_array($list['id'],$section_product_id))
				{
					$nestedData[] = '<input type="checkbox" checked="checked" class="product_chkbox" name="product_id[]" value="'.$list['id'].'" />';
				}
				else
				{
					$nestedData[] = '<input type="checkbox" class="product_chkbox" name="product_id[]" value="'.$list['id'].'" />';
				}
				$nestedData[] = $list['id'];
				$nestedData[] = ($img) ? '<img src="'.$img.'" width="50" />' : 'Not Uploaded';
				$nestedData[] = $list['product_name'];
				$nestedData[] = $list['sku'];
				
				$data[] = $nestedData;
				
				
				
			}
		}



		$json_data = array(
					"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
					"recordsTotal"    => intval( $totalData ),  // total number of records
					"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
					"data"            => $data,   // total data array
					"total_selected_students" => $total_selected_students
					);

		echo json_encode($json_data);  // send data as json format
	}
	
	public function getProductStockData($product_id = 0)
	{
		// get product data
		$productData = $this->db->get_where('products',array('id'=>$product_id))->row_array();
		$str = '<table class="table">';
		$str.='<tr>';
		$str.='<td><b>Product ID</b></td>';
		$str.='<td><b>Name</b></td>';
		$str.='<td><b>SKU</b></td>';
		$str.='<td width="20%"><b>Quantity</b></td>';
		$str.='<td width="20%"><b>Stock Status</b></td>';
		$str.='</tr>';
		$str.='<tr>';
		$str.='<td>'.$product_id.'</td>';
		$str.='<td>'.$productData['product_name'].'</td>';
		$str.='<td>'.$productData['sku'].'</td>';
		$str.='<td><input type="number" name="qty" id="qty" value="'.$productData['quantity'].'" class="form-control" /></td>';
		$str.='<td>';
		$str.='<select class="form-control" name="stock_status">';
		if($productData['stock_status'] == 1){
			$str.='<option value="1" selected="selected">In Stock</option>';
		}
		else
		{
			$str.='<option value="1">In Stock</option>';
		}
		if($productData['stock_status'] == 0){
			$str.='<option value="0" selected="selected">Out of Stock</option>';
		}
		else
		{
			$str.='<option value="0">Out of Stock</option>';
		}
		$str.='</select>';
		$str.='</td>';
		$str.='</tr></table>';
		
		$is_variation = $productData['is_variation'];
		$variation_variable = array_filter(explode('|',$productData['variation_variable']));
		if($is_variation){
			
			// get variation attribute
			$get_v_atr = $this->db->get_where('product_variation_attribute',array('product_id'=>$product_id))->row_array();
			
			$str.='<h3>Variation Product</h3>';
			$str.='<table class="table">';
			$str.='<tr>';
			$is_color = 0;
			if($variation_variable)
			{
				foreach($variation_variable as $atr_var)
				{
					$atr_id = isset($get_v_atr[$atr_var]) ? $get_v_atr[$atr_var] : 0;
					$attributeData = $this->db->select('attribute.*')->get_where('attribute',array('id'=>$atr_id))->row_array();
					if($attributeData)
					{
						$str.='<td><b>'.$attributeData['label'].'</b></td>';
						if($attributeData['is_input_box'])
						{
							$str.='<td><b>Unit</b></td>';
						}
						if($attributeData['form_type'] == 2)
						{
							$is_color = 1;
							$str.='<td><b>Color Map</b></td>';
						}
					}
				}
			}
			$totalOption = count($variation_variable);
			$str.='<td><b>SKU</b></td>';
			$str.='<td width="20%"><b>Quantity</b></td>';
			$str.='<td width="20%"><b>Stock Status</b></td>';
			$str.='<td width="20%"><b>Variation Status</b></td>';
			$str.='</tr>';
			
			// get product variation data
			$variationDataList = $this->db->get_where('product_variation_product_data',array('product_id'=>$product_id))->result_array();
			if($variationDataList)
			{
				foreach($variationDataList as $vList)
				{
					$str.='<tr>';
					$first_attribute_id = $vList['first_attribute_id'];
					if($first_attribute_id)
					{
						$attributeData = $this->db->select('attribute.*')->get_where('attribute',array('id'=>$first_attribute_id))->row_array();
						if($attributeData)
						{
							$str.='<td>'.$vList['first_option_data'].'</td>';
							if($attributeData['is_input_box'])
							{
								// get attribute data
								$attributeListData = $this->db->order_by('order_no','asc')->get_where('attribute_data',array('attribute_id'=>$first_attribute_id,'id'=>$vList['unit']))->row_array();
								$unit_data = isset($attributeListData['label']) ? $attributeListData['label'] : '';
								$str.='<td>'.$unit_data.'</td>';
								
							}
							if($attributeData['form_type'] == 2)
							{
								$str.='<td><input type="text" name="color_map['.$vList['id'].']" id="color_map" value="'.$vList['color_map'].'" class="form-control" /></td>';
							}
						}
					}
					$second_attribute_id = $vList['second_attribute_id'];
					if($second_attribute_id)
					{
						$attributeData = $this->db->select('attribute.*')->get_where('attribute',array('id'=>$second_attribute_id))->row_array();
						if($attributeData)
						{
							$str.='<td>'.$vList['second_option_data'].'</td>';
							if($attributeData['is_input_box'])
							{
								// get attribute data
								$attributeListData = $this->db->order_by('order_no','asc')->get_where('attribute_data',array('attribute_id'=>$second_attribute_id,'id'=>$vList['unit']))->row_array();
								$unit_data = isset($attributeListData['label']) ? $attributeListData['label'] : '';
								$str.='<td>'.$unit_data.'</td>';
								
							}
							if($attributeData['form_type'] == 2)
							{
								$str.='<td><input type="text" name="color_map['.$vList['id'].']" id="color_map" value="'.$vList['color_map'].'" class="form-control" /></td>';
							}
						}
					}
					$third_attribute_id = $vList['third_attribute_id'];
					if($third_attribute_id)
					{
						$attributeData = $this->db->select('attribute.*')->get_where('attribute',array('id'=>$third_attribute_id))->row_array();
						if($attributeData)
						{
							$str.='<td>'.$vList['third_option_data'].'</td>';
							if($attributeData['is_input_box'])
							{
								// get attribute data
								$attributeListData = $this->db->order_by('order_no','asc')->get_where('attribute_data',array('attribute_id'=>$third_attribute_id,'id'=>$vList['unit']))->row_array();
								$unit_data = isset($attributeListData['label']) ? $attributeListData['label'] : '';
								$str.='<td>'.$unit_data.'</td>';
								
							}
							if($attributeData['form_type'] == 2)
							{
								$str.='<td><input type="text" name="color_map['.$vList['id'].']" id="color_map" value="'.$vList['color_map'].'" class="form-control" /></td>';
							}
						}
					}
					$fourth_attribute_id = $vList['fourth_attribute_id'];
					if($fourth_attribute_id)
					{
						$attributeData = $this->db->select('attribute.*')->get_where('attribute',array('id'=>$fourth_attribute_id))->row_array();
						if($attributeData)
						{
							$str.='<td>'.$vList['fourth_option_data'].'</td>';
							if($attributeData['is_input_box'])
							{
								// get attribute data
								$attributeListData = $this->db->order_by('order_no','asc')->get_where('attribute_data',array('attribute_id'=>$fourth_attribute_id,'id'=>$vList['unit']))->row_array();
								$unit_data = isset($attributeListData['label']) ? $attributeListData['label'] : '';
								$str.='<td>'.$unit_data.'</td>';
								
							}
							if($attributeData['form_type'] == 2)
							{
								$str.='<td><input type="text" name="color_map['.$vList['id'].']" id="color_map" value="'.$vList['color_map'].'" class="form-control" /></td>';
							}
						}
					}
					$fifth_attribute_id = $vList['fifth_attribute_id'];
					if($fifth_attribute_id)
					{
						$attributeData = $this->db->select('attribute.*')->get_where('attribute',array('id'=>$fifth_attribute_id))->row_array();
						if($attributeData)
						{
							$str.='<td>'.$vList['fifth_option_data'].'</td>';
							if($attributeData['is_input_box'])
							{
								// get attribute data
								$attributeListData = $this->db->order_by('order_no','asc')->get_where('attribute_data',array('attribute_id'=>$fifth_attribute_id,'id'=>$vList['unit']))->row_array();
								$unit_data = isset($attributeListData['label']) ? $attributeListData['label'] : '';
								$str.='<td>'.$unit_data.'</td>';
								
							}
							if($attributeData['form_type'] == 2)
							{
								$str.='<td><input type="text" name="color_map['.$vList['id'].']" id="color_map" value="'.$vList['color_map'].'" class="form-control" /></td>';
							}
						}
					}
					
					
					$str.='<td>'.$vList['sku'].'</td>';
					$str.='<td><input type="number" name="variation_qty['.$vList['id'].']" id="variation_qty" value="'.$vList['quantity'].'" class="form-control" /></td>';
					$str.='<td>';
					$str.='<select class="form-control" name="variation_stock_status['.$vList['id'].']">';
					if($vList['stock_status'] == 1){
						$str.='<option value="1" selected="selected">In Stock</option>';
					}
					else
					{
						$str.='<option value="1">In Stock</option>';
					}
					if($vList['stock_status'] == 0){
						$str.='<option value="0" selected="selected">Out of Stock</option>';
					}
					else
					{
						$str.='<option value="0">Out of Stock</option>';
					}
					$str.='</select>';
					$str.='</td>';
					
					$str.='<td>';
					$str.='<select class="form-control" name="variation_status['.$vList['id'].']">';
					if($vList['variation_status'] == 1){
						$str.='<option value="1" selected="selected">Enable</option>';
					}
					else
					{
						$str.='<option value="1">Enable</option>';
					}
					if($vList['variation_status'] == 0){
						$str.='<option value="0" selected="selected">Disable</option>';
					}
					else
					{
						$str.='<option value="0">Disable</option>';
					}
					$str.='</select>';
					$str.='</td>';
					$str.='</tr>';
				}
			}
			
			$str.='</table>';
			
		}
		
		echo $str;
		
	}
	
	
	public function updateStockData()
	{
		$post = $this->input->post();
		if(isset($post['productID']))
		{
			$product_id = $post['productID'];
			$qty = $post['qty'];
			$stock_status = $post['stock_status'];
			
			// update product data
			$productData = array(
				'quantity' => $qty,
				'stock_status' => $stock_status,
				'updated' => date('Y-m-d H:i:s')
			);
			$this->db->where('id',$product_id);
			$this->db->update('products',$productData);
			
			// udpate variation stock data
			if(isset($post['variation_status']))
			{
				foreach($post['variation_status'] as $variation_id=>$variation_status)
				{
					$color_map = isset($post['color_map'][$variation_id]) ? $post['color_map'][$variation_id] : '';
					$variation_qty = isset($post['variation_qty'][$variation_id]) ? $post['variation_qty'][$variation_id] : 0;
					$variation_stock_status = isset($post['variation_stock_status'][$variation_id]) ? $post['variation_stock_status'][$variation_id] : 0;
					
					$variationData = array(
						'color_map' => $color_map,
						'quantity' => $variation_qty,
						'stock_status' => $variation_stock_status,
						'variation_status' => $variation_status,
						'updated' => date('Y-m-d H:i:s')
					);
					$this->db->where('id',$variation_id);
					$this->db->where('product_id',$product_id);
					$this->db->update('product_variation_product_data',$variationData);
				}
			}
		}
		echo 'Success';
	}

	public function addProduct($cat_slug = '', $sub_cat_slug = '', $sub_sub_cat_slug = '', $sub_sub_sub_cat_slug = '')
    {
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		
		// product token
		$token = do_hash(time());
		
		$categoryList = $this->db->order_by('created','desc')->get_where('category',array('parent_id'=>0))->result_array();
		$parent_category_list = array();
		$j = 0;
		if($categoryList)
		{
			foreach($categoryList as $key=>$list)
			{
				$parent_category_list[$key]['id'] = $list['id'];
				$parent_category_list[$key]['title'] = $list['title'];
				$parent_category_list[$key]['slug'] = $list['slug'];
				$cat_id = $list['id'];
				$subCategoryList = $this->db->order_by('created','desc')->get_where('category',array('parent_id'=>$cat_id))->result_array();
				if($subCategoryList)
				{
					foreach($subCategoryList as $subKey=>$subList)
					{
						$parent_category_list[$key]['subCat'][$subKey]['id'] = $subList['id'];
						$parent_category_list[$key]['subCat'][$subKey]['title'] = $subList['title'];
						$parent_category_list[$key]['subCat'][$subKey]['slug'] = $subList['slug'];
						$j++;
						$sub_cat_id = $subList['id'];
						$subSubCategoryList = $this->db->order_by('created','desc')->get_where('category',array('parent_id'=>$sub_cat_id))->result_array();
						if($subSubCategoryList)
						{
							foreach($subSubCategoryList as $subSubKey=>$subSubList)
							{
								$parent_category_list[$key]['subCat'][$subKey]['subCat'][$subSubKey]['id'] = $subSubList['id'];
								$parent_category_list[$key]['subCat'][$subKey]['subCat'][$subSubKey]['title'] = $subSubList['title'];
								$parent_category_list[$key]['subCat'][$subKey]['subCat'][$subSubKey]['slug'] = $subSubList['slug'];
								$j++;
								$sub_sub_cat_id = $subSubList['id'];
								$subSubSubCategoryList = $this->db->order_by('created','desc')->get_where('category',array('parent_id'=>$sub_sub_cat_id))->result_array();
								if($subSubSubCategoryList)
								{
									foreach($subSubSubCategoryList as $subSubSubKey=>$subSubSubList)
									{
										$sub_sub_sub_cat_id = $subSubSubList['id'];
										$parent_category_list[$key]['subCat'][$subKey]['subCat'][$subSubKey]['subCat'][$subSubSubKey]['id'] = $subSubSubList['id'];
										$parent_category_list[$key]['subCat'][$subKey]['subCat'][$subSubKey]['subCat'][$subSubSubKey]['title'] = $subSubSubList['title'];
										$parent_category_list[$key]['subCat'][$subKey]['subCat'][$subSubKey]['subCat'][$subSubSubKey]['slug'] = $subSubSubList['slug'];
										$j++;
									}
								}
							}
						}
					}
				}
			}
		}
		
		
		/*echo "<pre>";
		print_r($parent_category_list);
		die;*/
		$final_cat_title = '';
		$final_cat_id = array();
		if($cat_slug){
			// get category title
			$get_cat_title = $this->db->get_where('category',array('slug'=>$cat_slug,'status'=>1))->row_array();
			$cat_title = isset($get_cat_title['title']) ? $get_cat_title['title'] : '';
			$cat_id = isset($get_cat_title['id']) ? $get_cat_title['id'] : 0;
			$final_cat_title.=$cat_title;
			$final_cat_id[0] = $cat_id;
			
		}
		if($sub_cat_slug){
			// get category title
			$get_sub_cat_title = $this->db->get_where('category',array('slug'=>$sub_cat_slug,'status'=>1))->row_array();
			$sub_cat_title = isset($get_sub_cat_title['title']) ? $get_sub_cat_title['title'] : '';
			$sub_cat_id = isset($get_sub_cat_title['id']) ? $get_sub_cat_title['id'] : 0;
			$final_cat_title.=' - '.$sub_cat_title;
			$final_cat_id[1] = $sub_cat_id;
		}
		if($sub_sub_cat_slug){
			// get category title
			$get_sub_sub_cat_title = $this->db->get_where('category',array('slug'=>$sub_sub_cat_slug,'status'=>1))->row_array();
			$sub_sub_cat_title = isset($get_sub_sub_cat_title['title']) ? $get_sub_sub_cat_title['title'] : '';
			$sub_sub_cat_id = isset($get_sub_sub_cat_title['id']) ? $get_sub_sub_cat_title['id'] : 0;
			$final_cat_title.=' - '.$sub_sub_cat_title;
			$final_cat_id[2] = $sub_sub_cat_id;
		}
		if($sub_sub_sub_cat_slug){
			// get category title
			$get_sub_sub_sub_cat_title = $this->db->get_where('category',array('slug'=>$sub_sub_sub_cat_slug,'status'=>1))->row_array();
			$sub_sub_sub_cat_title = isset($get_sub_sub_sub_cat_title['title']) ? $get_sub_sub_sub_cat_title['title'] : '';
			$sub_sub_sub_cat_id = isset($get_sub_sub_sub_cat_title['id']) ? $get_sub_sub_sub_cat_title['id'] : 0;
			$final_cat_title.=' - '.$sub_sub_sub_cat_title;
			$final_cat_id[3] = $sub_sub_sub_cat_id;
		}
		
		
		
		// get attribute set List
		$attributeSetList = $this->db->order_by('created','desc')->get_where('attribute_set',array('status'=>1))->result_array();
		
		// get weight unit
		$getWeightUnit  = $this->db->get_where('attribute',array('is_weight_unit'=>1,'status'=>1))->row_array();
		$weight_attribute_id = isset($getWeightUnit['id']) ? $getWeightUnit['id'] : 0 ;
		// get unit list
		$weightUnitList  = $this->db->order_by('order_no','asc')->get_where('attribute_data',array('attribute_id'=>$weight_attribute_id))->result_array();
		
		// get visibility list
		$visibilityList  = $this->db->get('product_visibility_type')->result_array();
		
		
		// get variation list
		$variationList = array();
		
		   	
		$siteUrl = site_url();
        $data = array(
            'site_url' => $siteUrl,
			'loggedUser' => $loggedUser,
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'content_block' => 'catalog/addProduct',
            'manager_description' => lang('SITE_NAME'),
			'parent_category_list' => $parent_category_list,
			'attributeSetList' => $attributeSetList,
			'weightUnitList' => $weightUnitList,
			'visibilityList' => $visibilityList,
			'token' => $token,
			'variationList' => $variationList,
			'final_cat_title' => $final_cat_title,
			'final_cat_id' => $final_cat_id,
            'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getSystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning() 
		);
        $this->parser->parse('admin/layout/column-1', $data);
		
    }
   
	
	public function saveProduct()
	{
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		$userID = $loggedUser['id'];
		$post = $this->input->post();
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('product_name', 'Product Name', 'required|xss_clean');
		$this->form_validation->set_rules('sku', 'SKU', 'required|xss_clean');
		$this->form_validation->set_rules('price', 'Price', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			
			$this->addProduct();
		}
		else
		{
			// update organizer detail
			$this->Catalog_model->save_product_data($post);
			$this->Az->redirect('admin/catalog/productList', 'system_message_error',lang('PRODUCT_SAVE_SUCCESS'));
		}
		
	}
	
	
	public function getAttributeSetForm($setID = 0)
	{
		// get attribute list
		$attributeList = $this->db->select('attribute.*')->join('attribute','attribute.id = attribute_set_attributes.attribute_id')->get_where('attribute_set_attributes',array('attribute_set_id'=>$setID))->result_array();
		
		$str = '';
		if($attributeList)
		{
			foreach($attributeList as $list)
			{
				$attribute_id = $list['id'];
				$is_input_box = $list['is_input_box'];
				
				// get attribute data
				$attributeData = $this->db->order_by('order_no','asc')->get_where('attribute_data',array('attribute_id'=>$attribute_id))->result_array();
				
				if($list['form_type'] == 1 || $list['form_type'] == 3)
				{
					if($is_input_box){
						$str.='<div class="form-group">';
						$str.='<div class="row">';
						$str.='<div class="col-md-4">';
						$str.='<label>'.$list['label'].'</label>';
						$str.='<input type="text" class="form-control" name="attribute_value_'.$attribute_id.'" />';
						$str.='</div>';
						$str.='<div class="col-md-4">';
						$str.='<label></label>';
						$str.='<select id="select01" class="form-control" name="attribute_'.$attribute_id.'">';
						if($attributeData)
						{
							foreach($attributeData as $dList)
							{
								if($dList['is_default']){
									$str.='<option value="'.$dList['id'].'" selected="selected">'.$dList['label'].'</option>';
								}
								else
								{
									$str.='<option value="'.$dList['id'].'">'.$dList['label'].'</option>';
								}
							}
						}
						$str.='</select>';
						$str.='</div>';
						$str.='</div>';
						$str.='</div>';
					}
					else{
						$str.='<div class="form-group">';
						$str.='<label>'.$list['label'].'</label>';
						$str.='<select id="select01" class="form-control" name="attribute_'.$attribute_id.'">';
						if($attributeData)
						{
							foreach($attributeData as $dList)
							{
								if($dList['is_default']){
									$str.='<option value="'.$dList['id'].'" selected="selected">'.$dList['label'].'</option>';
								}
								else
								{
									$str.='<option value="'.$dList['id'].'">'.$dList['label'].'</option>';
								}
							}
						}
						$str.='</select>';
						$str.='</div>';
					}
				}
				elseif($list['form_type'] == 2)
				{
					if($is_input_box){
						$str.='<div class="form-group">';
						$str.='<div class="row">';
						$str.='<div class="col-md-4">';
						$str.='<label>'.$list['label'].'</label>';
						$str.='<input type="text" class="form-control" name="attribute_value_'.$attribute_id.'" />';
						$str.='</div>';
						$str.='<div class="col-md-4">';
						$str.='<label></label>';
						$str.='<select id="select01" class="form-control" name="attribute_'.$attribute_id.'">';
						if($attributeData)
						{
							foreach($attributeData as $dList)
							{
								if($dList['is_default']){
									$str.='<option value="'.$dList['id'].'" selected="selected">'.$dList['description'].'</option>';
								}
								else
								{
									$str.='<option value="'.$dList['id'].'">'.$dList['description'].'</option>';
								}
							}
						}
						$str.='</select>';
						$str.='</div>';
						$str.='</div>';
						$str.='</div>';
					}
					else{
						$str.='<div class="form-group">';
						$str.='<label>'.$list['label'].'</label>';
						$str.='<select id="select01" class="form-control" name="attribute_'.$attribute_id.'">';
						if($attributeData)
						{
							foreach($attributeData as $dList)
							{
								if($dList['is_default']){
									$str.='<option value="'.$dList['id'].'" selected="selected">'.$dList['description'].'</option>';
								}
								else
								{
									$str.='<option value="'.$dList['id'].'">'.$dList['description'].'</option>';
								}
								
							}
						}
						$str.='</select>';
						$str.='</div>';
					}
				}
				elseif($list['form_type'] == 4)
				{
					
					$str.='<div class="form-group">';
					$str.='<label>'.$list['label'].'</label>';
					$str.='<select id="select01" class="form-control" name="attribute_'.$attribute_id.'[]" multiple>';
					if($attributeData)
					{
						foreach($attributeData as $dList)
						{
							if($dList['is_default']){
								$str.='<option value="'.$dList['id'].'" selected="selected">'.$dList['description'].'</option>';
							}
							else
							{
								$str.='<option value="'.$dList['id'].'">'.$dList['description'].'</option>';
							}
						}
					}
					$str.='</select>';
					$str.='</div>';
					
				}
				elseif($list['form_type'] == 5)
				{
					
					$str.='<div class="form-group">';
					$str.='<label>'.$list['label'].'</label>';
					$str.='<select id="select01" class="form-control" name="attribute_'.$attribute_id.'[]" multiple>';
					if($attributeData)
					{
						foreach($attributeData as $dList)
						{
							if($dList['is_default']){
								$str.='<option value="'.$dList['id'].'" selected="selected">'.$dList['label'].'</option>';
							}
							else
							{
								$str.='<option value="'.$dList['id'].'">'.$dList['label'].'</option>';
							}
						}
					}
					$str.='</select>';
					$str.='</div>';
					
				}
			}
		}
		
		$variation_str = '';
		
		
		$response = array(
			'str' => $str,
			'variation_str' => $variation_str
		);
		
		echo json_encode($response);
	}
	
	
	public function uploadGallery($token = '',$type = 4)
	{
				
		if($_FILES['photos']['name']){
		//generate logo name randomly
		$config['upload_path'] = './media/product_images/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$siteUrl = site_url();
		
			$fileName = do_hash(time().rand(111111,999999));
			$config['file_name'] = $fileName;
			$this->load->library('upload', $config);
			$this->upload->do_upload('photos');		
			$uploadError = $this->upload->display_errors();
		
			if($uploadError){
				echo json_encode(
						array(
							"status"=>0,
							'msg' => $uploadError
							)
				);
			}
			else
			{
				
				$fileData = $this->upload->data();
				//get uploaded file path
				$filePath = substr($config['upload_path'] . $fileData['file_name'], 2);
				
				$imageData = array(
					'token' => $token,
					'image_path' => $filePath,
					'file_name' => $fileData['file_name'],
					'type' => $type,
					'created' => date('Y-m-d H:i:s')
				);
				$this->db->insert('product_image_temp_data',$imageData);
				$file_id = $this->db->insert_id();
				
				// resize image
				$this->User->resize_pro_image($fileData['file_name']);
				
				echo json_encode(
						array(
							"status"=>1,
							'msg' => 'Image Uploaded Successfully.',
							'filePath' => 'media/product_images/thumbnail-70x70/'.$fileData['file_name'],
							'file_id' => $file_id
							)
					);
				
				
			}
		
		
		
		}
		else
		{
			echo json_encode(
						array(
							"status"=>0,
							'msg' => 'Please select image.'
							)
				);
		}
		
	}
	
	public function variationUploadGallery($token = '',$rowID = 0, $type = 4)
	{
				
		if($_FILES['photos']['name']){
		//generate logo name randomly
		$config['upload_path'] = './media/product_images/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$siteUrl = site_url();
		
			$fileName = do_hash(time().rand(111111,999999));
			$config['file_name'] = $fileName;
			$this->load->library('upload', $config);
			$this->upload->do_upload('photos');		
			$uploadError = $this->upload->display_errors();
		
			if($uploadError){
				echo json_encode(
						array(
							"status"=>0,
							'msg' => $uploadError
							)
				);
			}
			else
			{
				
				$fileData = $this->upload->data();
				//get uploaded file path
				$filePath = substr($config['upload_path'] . $fileData['file_name'], 2);
				
				$imageData = array(
					'token' => $token,
					'image_path' => $filePath,
					'file_name' => $fileData['file_name'],
					'type' => $type,
					'row_no' => $rowID,
					'created' => date('Y-m-d H:i:s')
				);
				$this->db->insert('product_image_temp_data',$imageData);
				$file_id = $this->db->insert_id();
				
				// resize image
				$this->User->resize_pro_image($fileData['file_name']);
				
				echo json_encode(
						array(
							"status"=>1,
							'msg' => 'Image Uploaded Successfully.',
							'filePath' => 'media/product_images/thumbnail-70x70/'.$fileData['file_name'],
							'file_id' => $file_id
							)
					);
				
				
			}
		
		
		
		}
		else
		{
			echo json_encode(
						array(
							"status"=>0,
							'msg' => 'Please select image.'
							)
				);
		}
		
	}
	
	public function deleteProduct($product_id = 0, $uploadError = '')
	{
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		// check category valid or not
		$chk_cat = $this->db->get_where('products',array('id'=>$product_id))->num_rows();
		if(!$chk_cat)
		{
			$this->Az->redirect('admin/catalog/productList', 'system_message_error',lang('PRODUCT_VALID_ERROR'));
		}
		
		$productData = $this->db->order_by('created','desc')->get_where('products',array('id'=>$product_id))->row_array();
		$image_token = $productData['image_token'];
		
		// delete product all attribute
		$this->db->where('product_id',$product_id);
		$this->db->delete('product_attribute');
		
		// delete product all category
		$this->db->where('product_id',$product_id);
		$this->db->delete('product_category');
		
		// get product images
		$imageList = $this->db->get_where('product_images',array('product_id'=>$product_id))->result_array();
		if($imageList)
		{
			foreach($imageList as $list)
			{
				$image_path = $list['image_path'];
				$file_name = $list['file_name'];
				if($file_name)
				{
					if(file_exists("media/product_images/".$file_name))
					{
						unlink(str_replace('system/', '', BASEPATH . "media/product_images/".$file_name));
					}
					if(file_exists("media/product_images/thumbnail-70x70/".$file_name))
					{
						unlink(str_replace('system/', '', BASEPATH . "media/product_images/thumbnail-70x70/".$file_name));
					}
					if(file_exists("media/product_images/thumbnail-180x180/".$file_name))
					{
						unlink(str_replace('system/', '', BASEPATH . "media/product_images/thumbnail-180x180/".$file_name));
					}
					if(file_exists("media/product_images/thumbnail-400x400/".$file_name))
					{
						unlink(str_replace('system/', '', BASEPATH . "media/product_images/thumbnail-400x400/".$file_name));
					}
				}
				
				
			}
		}
		
		// delete product image 
		$this->db->where('product_id',$product_id);
		$this->db->delete('product_images');
		
		// delete product image temp data
		$this->db->where('token',$image_token);
		$this->db->delete('product_image_temp_data');
		
		// delete product meta data
		$this->db->where('product_id',$product_id);
		$this->db->delete('product_meta_data');
		
		// delete product offer
		$this->db->where('product_id',$product_id);
		$this->db->delete('product_offer');
		
		// delete product all SKU
		$this->db->where('product_id',$product_id);
		$this->db->delete('product_sku');
		
		
		$this->db->where('id',$product_id);
		$this->db->delete('products');
		$this->Az->redirect('admin/catalog/productList', 'system_message_info', lang('PRODUCT_DELETE_SUCCESS'));
		
    }
	
	public function deleteImageTempData($file_id = 0, $uploadError = '')
	{
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		
		$productData = $this->db->get_where('product_image_temp_data',array('id'=>$file_id))->row_array();
		$image_path = isset($productData['image_path']) ? $productData['image_path'] : '';
		$file_name = isset($productData['file_name']) ? $productData['file_name'] : '';
		
		if($file_name)
		{
			if(file_exists("media/product_images/".$file_name))
			{
				unlink(str_replace('system/', '', BASEPATH . "media/product_images/".$file_name));
			}
			if(file_exists("media/product_images/thumbnail-70x70/".$file_name))
			{
				unlink(str_replace('system/', '', BASEPATH . "media/product_images/thumbnail-70x70/".$file_name));
			}
			if(file_exists("media/product_images/thumbnail-180x180/".$file_name))
			{
				unlink(str_replace('system/', '', BASEPATH . "media/product_images/thumbnail-180x180/".$file_name));
			}
			if(file_exists("media/product_images/thumbnail-400x400/".$file_name))
			{
				unlink(str_replace('system/', '', BASEPATH . "media/product_images/thumbnail-400x400/".$file_name));
			}
			
		}
		$this->db->where('id',$file_id);
		$this->db->delete('product_image_temp_data');
		
		echo 'Success';
		
		
    }
	
	
	public function deleteProductImage($image_id = 0, $uploadError = '')
	{
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		
		$productData = $this->db->get_where('product_images',array('id'=>$image_id))->row_array();
		$image_path = isset($productData['image_path']) ? $productData['image_path'] : '';
		
		if($image_path)
		{
			unlink(str_replace('system/', '', BASEPATH . $image_path));
		}
		$this->db->where('id',$image_id);
		$this->db->delete('product_images');
		
		echo 'Success';
		
		
    }
	
	public function getVariationOption($theme_id = '')
	{
		if($theme_id){
			// explode theme id
			$explode_theme_id = explode('_',$theme_id);
			$is_combo = isset($explode_theme_id[0]) ? $explode_theme_id[0] : 0 ;
			$i = 1;
			if($is_combo == 0){
				$attribute_id = isset($explode_theme_id[1]) ? $explode_theme_id[1] : 0 ;
				
				$attributeData = $this->db->get_where('attribute',array('id'=>$attribute_id))->row_array();
				if($attributeData)
				{
					$str.='<div class="col-md-2">';
					$str.='<label>'.$attributeData['label'].'</label>';
					$str.='<input type="text" class="form-control" name="theme_option['.$attributeData['id'].']" id="theme_option_'.$i.'" />';
					$str.='</div>';
					$i++;
				}
				
			}
			else
			{
				$attribute_1_id = isset($explode_theme_id[1]) ? $explode_theme_id[1] : 0 ;
				$attribute_2_id = isset($explode_theme_id[2]) ? $explode_theme_id[2] : 0 ;
				$attribute_3_id = isset($explode_theme_id[3]) ? $explode_theme_id[3] : 0 ;
				$attribute_4_id = isset($explode_theme_id[4]) ? $explode_theme_id[4] : 0 ;
				$attribute_5_id = isset($explode_theme_id[5]) ? $explode_theme_id[5] : 0 ;
				
				if($attribute_1_id){
					$attributeData = $this->db->get_where('attribute',array('id'=>$attribute_1_id))->row_array();
					if($attributeData)
					{
						$str.='<div class="col-md-2">';
						$str.='<label>'.$attributeData['label'].'</label>';
						$str.='<input type="text" class="form-control" name="theme_option['.$attributeData['id'].']" id="theme_option_'.$i.'" />';
						$str.='</div>';
						$i++;
					}
				}
				if($attribute_2_id){
					$attributeData = $this->db->get_where('attribute',array('id'=>$attribute_2_id))->row_array();
					if($attributeData)
					{
						$str.='<div class="col-md-2">';
						$str.='<label>'.$attributeData['label'].'</label>';
						$str.='<input type="text" class="form-control" name="theme_option['.$attributeData['id'].']" id="theme_option_'.$i.'" />';
						$str.='</div>';
						$i++;
					}
				}
				if($attribute_3_id){
					$attributeData = $this->db->get_where('attribute',array('id'=>$attribute_3_id))->row_array();
					if($attributeData)
					{
						$str.='<div class="col-md-2">';
						$str.='<label>'.$attributeData['label'].'</label>';
						$str.='<input type="text" class="form-control" name="theme_option['.$attributeData['id'].']" id="theme_option_'.$i.'" />';
						$str.='</div>';
						$i++;
					}
				}
				if($attribute_4_id){
					$attributeData = $this->db->get_where('attribute',array('id'=>$attribute_4_id))->row_array();
					if($attributeData)
					{
						$str.='<div class="col-md-2">';
						$str.='<label>'.$attributeData['label'].'</label>';
						$str.='<input type="text" class="form-control" name="theme_option['.$attributeData['id'].']" id="theme_option_'.$i.'" />';
						$str.='</div>';
						$i++;
					}
				}
				if($attribute_5_id){
					$attributeData = $this->db->get_where('attribute',array('id'=>$attribute_5_id))->row_array();
					if($attributeData)
					{
						$str.='<div class="col-md-2">';
						$str.='<label>'.$attributeData['label'].'</label>';
						$str.='<input type="text" class="form-control" name="theme_option['.$attributeData['id'].']" id="theme_option_'.$i.'" />';
						$str.='</div>';
						$i++;
					}
				}
			}
			
			$response = array(
				'status' => 1,
				'str' => $str,
				'total_option' => ($i - 1)
			);
			
		}
		else
		{
			$response = array(
				'status' => 0,
				'str' => '',
				'total_option' => 0
			);
		}
		echo json_encode($response);
	}
	
	public function addVariationOption($theme_id = '',$is_header = 0,$option_row_no = 0)
	{
		
		$post = $this->input->post();
		if($is_header == 0){
			// explode theme id
			$explode_theme_id = explode('_',$theme_id);
			$is_combo = isset($explode_theme_id[0]) ? $explode_theme_id[0] : 0 ;
			
			$attribute_array_id = array();
			$attribute_array_inc = 0;
			
			$str = '';
			$str.='<tr>';
			if($is_combo == 0){
				$attribute_id = isset($explode_theme_id[1]) ? $explode_theme_id[1] : 0 ;
				
				$attributeData = $this->db->get_where('attribute',array('id'=>$attribute_id))->row_array();
				if($attributeData)
				{
					$str.='<td><b>'.$attributeData['label'].'</b></td>';
					if($attributeData['is_input_box']){
						$str.='<td><b>Unit</b></td>';
					}
					if($attributeData['form_type'] == 2){
						$str.='<td><b>Color Map</b></td>';
					}
					
				}
				
			}
			else
			{
				$attribute_1_id = isset($explode_theme_id[1]) ? $explode_theme_id[1] : 0 ;
				$attribute_2_id = isset($explode_theme_id[2]) ? $explode_theme_id[2] : 0 ;
				$attribute_3_id = isset($explode_theme_id[3]) ? $explode_theme_id[3] : 0 ;
				$attribute_4_id = isset($explode_theme_id[4]) ? $explode_theme_id[4] : 0 ;
				$attribute_5_id = isset($explode_theme_id[5]) ? $explode_theme_id[5] : 0 ;
				
				if($attribute_1_id){
					$attributeData = $this->db->get_where('attribute',array('id'=>$attribute_1_id))->row_array();
					if($attributeData)
					{
						$attribute_array_id[$attribute_array_inc] = $attribute_1_id;
						$attribute_array_inc++;
						$str.='<td><b>'.$attributeData['label'].'</b></td>';
						if($attributeData['is_input_box']){
							$str.='<td><b>Unit</b></td>';
						}
						if($attributeData['form_type'] == 2){
							$str.='<td><b>Color Map</b></td>';
						}
					}
				}
				if($attribute_2_id){
					$attributeData = $this->db->get_where('attribute',array('id'=>$attribute_2_id))->row_array();
					if($attributeData)
					{
						$attribute_array_id[$attribute_array_inc] = $attribute_2_id;
						$attribute_array_inc++;
						$str.='<td><b>'.$attributeData['label'].'</b></td>';
						if($attributeData['is_input_box']){
							$str.='<td><b>Unit</b></td>';
						}
						if($attributeData['form_type'] == 2){
							$str.='<td><b>Color Map</b></td>';
						}
					}
				}
				if($attribute_3_id){
					$attributeData = $this->db->get_where('attribute',array('id'=>$attribute_3_id))->row_array();
					if($attributeData)
					{
						$attribute_array_id[$attribute_array_inc] = $attribute_3_id;
						$attribute_array_inc++;
						$str.='<td><b>'.$attributeData['label'].'</b></td>';
						if($attributeData['is_input_box']){
							$str.='<td><b>Unit</b></td>';
						}
						if($attributeData['form_type'] == 2){
							$str.='<td><b>Color Map</b></td>';
						}
					}
				}
				if($attribute_4_id){
					$attributeData = $this->db->get_where('attribute',array('id'=>$attribute_4_id))->row_array();
					if($attributeData)
					{
						$attribute_array_id[$attribute_array_inc] = $attribute_4_id;
						$attribute_array_inc++;
						$str.='<td><b>'.$attributeData['label'].'</b></td>';
						if($attributeData['is_input_box']){
							$str.='<td><b>Unit</b></td>';
						}
						if($attributeData['form_type'] == 2){
							$str.='<td><b>Color Map</b></td>';
						}
					}
				}
				if($attribute_5_id){
					$attributeData = $this->db->get_where('attribute',array('id'=>$attribute_5_id))->row_array();
					if($attributeData)
					{
						$attribute_array_id[$attribute_array_inc] = $attribute_5_id;
						$attribute_array_inc++;
						$str.='<td><b>'.$attributeData['label'].'</b></td>';
						if($attributeData['is_input_box']){
							$str.='<td><b>Unit</b></td>';
						}
						if($attributeData['form_type'] == 2){
							$str.='<td><b>Color Map</b></td>';
						}
					}
				}
			}
			
			$str.='<td><b>Seller SKU</b></td>';
			$str.='<td><b>Your Price</b></td>';
			$str.='<td><b>Sale Price</b></td>';
			$str.='<td><b>Quantity</b></td>';
			$str.='<td><b>Stock</b></td>';
			$str.='<td><b>Status</b></td>';
			$str.='<td></td>';
			$str.='</tr>';
			
			$str.='<tr id="variation_option_tr_'.$option_row_no.'">';
			
			if($post['data'])
			{
				$order_no = 1;
				foreach($post['data'] as $ik=>$val)
				{
					if($is_combo == 0){
						$attribute_id = isset($explode_theme_id[1]) ? $explode_theme_id[1] : 0 ;
						
						$attributeData = $this->db->get_where('attribute',array('id'=>$attribute_id))->row_array();
						if($attributeData)
						{
							$str.='<td><input type="hidden" value="'.$val.'" name="theme_data['.$option_row_no.']['.$order_no.']" />'.$val.'</td>';
							
							if($attributeData['is_input_box']){
								// get attribute data
								$attributeData = $this->db->order_by('order_no','asc')->get_where('attribute_data',array('attribute_id'=>$attribute_id))->result_array();
								$str.='<td><select id="select01" class="form-control" name="theme_unit['.$option_row_no.']">';
								
								if($attributeData)
								{
									foreach($attributeData as $dList)
									{
										if($dList['is_default']){
											$str.='<option value="'.$dList['id'].'" selected="selected">'.$dList['label'].'</option>';
										}
										else
										{
											$str.='<option value="'.$dList['id'].'">'.$dList['label'].'</option>';
										}
									}
								}
								$str.='</select></td>';
							}
							if($attributeData['form_type'] == 2){
								$str.='<td><input type="text" class="form-control" name="theme_color_map['.$option_row_no.']" /></td>';
							}
							$order_no++;
						}
						
					}
					else
					{
						
						$attribute_1_id = isset($attribute_array_id[$ik]) ? $attribute_array_id[$ik] : 0 ;
						
						if($attribute_1_id){
							$attributeData = $this->db->get_where('attribute',array('id'=>$attribute_1_id))->row_array();
							if($attributeData)
							{
								$str.='<td><input type="hidden" value="'.$val.'" name="theme_data['.$option_row_no.']['.$order_no.']" />'.$val.'</td>';
							
								if($attributeData['is_input_box']){
									
									// get attribute data
									$attributeData = $this->db->order_by('order_no','asc')->get_where('attribute_data',array('attribute_id'=>$attribute_1_id))->result_array();
									$str.='<td><select id="select01" class="form-control" name="theme_unit['.$option_row_no.']">';
									
									if($attributeData)
									{
										foreach($attributeData as $dList)
										{
											if($dList['is_default']){
												$str.='<option value="'.$dList['id'].'" selected="selected">'.$dList['label'].'</option>';
											}
											else
											{
												$str.='<option value="'.$dList['id'].'">'.$dList['label'].'</option>';
											}
										}
									}
									$str.='</select></td>';
									
								}
								if($attributeData['form_type'] == 2){
									$str.='<td><input type="text" class="form-control" name="theme_color_map['.$option_row_no.']" /></td>';
								}
								$order_no++;
							}
						}
						
					}
					
				}
			}
			$str.='<td><input type="text" class="form-control" name="theme_sku['.$option_row_no.']" /></td>';
			$str.='<td><input type="text" class="form-control" name="theme_price['.$option_row_no.']" /></td>';
			$str.='<td><input type="text" class="form-control" name="theme_discount_price['.$option_row_no.']" /></td>';
			$str.='<td><input type="text" class="form-control" name="theme_qty['.$option_row_no.']" /></td>';
			$str.='<td><select class="form-control" name="theme_stock['.$option_row_no.']"><option value="1">In Stock</option><option value="0">Out of Stock</option></select></td>';
			$str.='<td><select class="form-control" name="theme_status['.$option_row_no.']"><option value="1">Enable</option><option value="0">Disable</option></select></td>';
			$str.='<td><i class="fa fa-trash" onclick="deleteVariationRow('.$option_row_no.')" aria-hidden="true"></i></td>';
			$str.='</tr>';
			
			$str.='<tr id="variation_option_img_desc_tr_'.$option_row_no.'">';
			$str.='<td colspan="10">';
			$str.='<button type="button" class="btn btn-primary" onclick="showVariationImg('.$option_row_no.')">Images</button>';
			$str.='<button type="button" class="btn btn-primary" onclick="showVariationDesc('.$option_row_no.')">Bullet Points</button>';
			$str.='<div id="variation-desc-'.$option_row_no.'" style="display:none;">';
			$str.='<table class="table" style="width:50%;">';
			$str.='<tr>';
			$str.='<td>#</td>';
			$str.='<td>Bullet Points</td>';
			$str.='<td></td>';
			$str.='</tr>';
			for($i = 1; $i<=5; $i++){
				$str.='<tr>';
				$str.='<td>'.$i.'</td>';
				$str.='<td><input type="text" class="form-control" name="variation_instruction['.$option_row_no.'][]" /></td>';
				$str.='<td></td>';
				$str.='</tr>';
			}
			$str.='</table>';
			$str.='</div>';
			$str.='<div id="variation-img-'.$option_row_no.'" style="display:none;">';
			$str.='<div class="image-loader-'.$option_row_no.'"></div>';
			$str.='<h4>Main</h4>';
			$str.='<div class="image-upload-block" id="image-upload-block-'.$option_row_no.'-0"><i class="fa fa-camera" aria-hidden="true"></i></div>';
			$str.='<input type="file" style="display:none;" class="images" id="main_images_'.$option_row_no.'_0" onchange="uploadVariationImg('.$option_row_no.',0);" name="main_images_'.$option_row_no.'_0">';
			$str.='<button type="button" class="btn btn-primary main-upload-btn" onclick="openUploadBox('.$option_row_no.',0);">Upload</button>';
			$str.='<div class="main-image-delete-block" id="main-image-delete-block-'.$option_row_no.'-0"></div>';
			$str.='<br /><br />';
			$str.='<div class="row">';
			$str.='<div class="col-md-2 other-img">';
			$str.='<div class="image-upload-block2" id="image-upload-block-'.$option_row_no.'-1"><i class="fa fa-camera" aria-hidden="true"></i></div>';
			$str.='<input type="file" style="display:none;" class="images" id="main_images_'.$option_row_no.'_1" onchange="uploadVariationImg('.$option_row_no.',1);" name="main_images_'.$option_row_no.'_1">';
			$str.='<button type="button" class="btn btn-primary main-upload-btn2" onclick="openUploadBox('.$option_row_no.',1);">Upload</button>';
			$str.='<div class="main-image-delete-block2" id="main-image-delete-block-'.$option_row_no.'-1"></div>';
			$str.='</div>';
			$str.='<div class="col-md-2 other-img">';
			$str.='<div class="image-upload-block2" id="image-upload-block-'.$option_row_no.'-2"><i class="fa fa-camera" aria-hidden="true"></i></div>';
			$str.='<input type="file" style="display:none;" class="images" id="main_images_'.$option_row_no.'_2" onchange="uploadVariationImg('.$option_row_no.',2);" name="main_images_'.$option_row_no.'_2">';
			$str.='<button type="button" class="btn btn-primary main-upload-btn2" onclick="openUploadBox('.$option_row_no.',2);">Upload</button>';
			$str.='<div class="main-image-delete-block2" id="main-image-delete-block-'.$option_row_no.'-2"></div>';
			$str.='</div>';
			$str.='<div class="col-md-2 other-img">';
			$str.='<div class="image-upload-block2" id="image-upload-block-'.$option_row_no.'-3"><i class="fa fa-camera" aria-hidden="true"></i></div>';
			$str.='<input type="file" style="display:none;" class="images" id="main_images_'.$option_row_no.'_3" onchange="uploadVariationImg('.$option_row_no.',3);" name="main_images_'.$option_row_no.'_3">';
			$str.='<button type="button" class="btn btn-primary main-upload-btn2" onclick="openUploadBox('.$option_row_no.',3);">Upload</button>';
			$str.='<div class="main-image-delete-block2" id="main-image-delete-block-'.$option_row_no.'-3"></div>';
			$str.='</div>';
			$str.='<div class="col-md-2 other-img">';
			$str.='<div class="image-upload-block2" id="image-upload-block-'.$option_row_no.'-4"><i class="fa fa-camera" aria-hidden="true"></i></div>';
			$str.='<input type="file" style="display:none;" class="images" id="main_images_'.$option_row_no.'_4" onchange="uploadVariationImg('.$option_row_no.',4);" name="main_images_'.$option_row_no.'_4">';
			$str.='<button type="button" class="btn btn-primary main-upload-btn2" onclick="openUploadBox('.$option_row_no.',4);">Upload</button>';
			$str.='<div class="main-image-delete-block2" id="main-image-delete-block-'.$option_row_no.'-4"></div>';
			$str.='</div>';
			$str.='<div class="col-md-2 other-img">';
			$str.='<div class="image-upload-block2" id="image-upload-block-'.$option_row_no.'-5"><i class="fa fa-camera" aria-hidden="true"></i></div>';
			$str.='<input type="file" style="display:none;" class="images" id="main_images_'.$option_row_no.'_5" onchange="uploadVariationImg('.$option_row_no.',5);" name="main_images_'.$option_row_no.'_5">';
			$str.='<button type="button" class="btn btn-primary main-upload-btn2" onclick="openUploadBox('.$option_row_no.',5);">Upload</button>';
			$str.='<div class="main-image-delete-block2" id="main-image-delete-block-'.$option_row_no.'-5"></div>';
			$str.='</div>';
			$str.='<div class="col-md-2 other-img">';
			$str.='<div class="image-upload-block2" id="image-upload-block-'.$option_row_no.'-6"><i class="fa fa-camera" aria-hidden="true"></i></div>';
			$str.='<input type="file" style="display:none;" class="images" id="main_images_'.$option_row_no.'_6" onchange="uploadVariationImg('.$option_row_no.',6);" name="main_images_'.$option_row_no.'_6">';
			$str.='<button type="button" class="btn btn-primary main-upload-btn2" onclick="openUploadBox('.$option_row_no.',6);">Upload</button>';
			$str.='<div class="main-image-delete-block2" id="main-image-delete-block-'.$option_row_no.'-6"></div>';
			$str.='</div>';
			$str.='</div>';
			$str.='</div>';
			$str.='</td>';
			$str.='</tr>';
		}
		else
		{
			// explode theme id
			$explode_theme_id = explode('_',$theme_id);
			$is_combo = isset($explode_theme_id[0]) ? $explode_theme_id[0] : 0 ;
			
			$attribute_array_id = array();
			$attribute_array_inc = 0;
			
			if($is_combo)
			{
				$attribute_1_id = isset($explode_theme_id[1]) ? $explode_theme_id[1] : 0 ;
				$attribute_2_id = isset($explode_theme_id[2]) ? $explode_theme_id[2] : 0 ;
				$attribute_3_id = isset($explode_theme_id[3]) ? $explode_theme_id[3] : 0 ;
				$attribute_4_id = isset($explode_theme_id[4]) ? $explode_theme_id[4] : 0 ;
				$attribute_5_id = isset($explode_theme_id[5]) ? $explode_theme_id[5] : 0 ;
				
				if($attribute_1_id){
					$attributeData = $this->db->get_where('attribute',array('id'=>$attribute_1_id))->row_array();
					if($attributeData)
					{
						$attribute_array_id[$attribute_array_inc] = $attribute_1_id;
						$attribute_array_inc++;
						
					}
				}
				if($attribute_2_id){
					$attributeData = $this->db->get_where('attribute',array('id'=>$attribute_2_id))->row_array();
					if($attributeData)
					{
						$attribute_array_id[$attribute_array_inc] = $attribute_2_id;
						$attribute_array_inc++;
						
					}
				}
				if($attribute_3_id){
					$attributeData = $this->db->get_where('attribute',array('id'=>$attribute_3_id))->row_array();
					if($attributeData)
					{
						$attribute_array_id[$attribute_array_inc] = $attribute_3_id;
						$attribute_array_inc++;
						
					}
				}
				if($attribute_4_id){
					$attributeData = $this->db->get_where('attribute',array('id'=>$attribute_4_id))->row_array();
					if($attributeData)
					{
						$attribute_array_id[$attribute_array_inc] = $attribute_4_id;
						$attribute_array_inc++;
						
					}
				}
				if($attribute_5_id){
					$attributeData = $this->db->get_where('attribute',array('id'=>$attribute_5_id))->row_array();
					if($attributeData)
					{
						$attribute_array_id[$attribute_array_inc] = $attribute_5_id;
						$attribute_array_inc++;
						
					}
				}
			}
			
			$str.='<tr id="variation_option_tr_'.$option_row_no.'">';
			if($post['data'])
			{
				$order_no = 1;
				foreach($post['data'] as $ik=>$val)
				{
					if($is_combo == 0){
						$attribute_id = isset($explode_theme_id[1]) ? $explode_theme_id[1] : 0 ;
						
						$attributeData = $this->db->get_where('attribute',array('id'=>$attribute_id))->row_array();
						if($attributeData)
						{
							$str.='<td><input type="hidden" value="'.$val.'" name="theme_data['.$option_row_no.']['.$order_no.']" />'.$val.'</td>';
							
							if($attributeData['is_input_box']){
								// get attribute data
								$attributeData = $this->db->order_by('order_no','asc')->get_where('attribute_data',array('attribute_id'=>$attribute_id))->result_array();
								$str.='<td><select id="select01" class="form-control" name="theme_unit['.$option_row_no.']">';
								
								if($attributeData)
								{
									foreach($attributeData as $dList)
									{
										if($dList['is_default']){
											$str.='<option value="'.$dList['id'].'" selected="selected">'.$dList['label'].'</option>';
										}
										else
										{
											$str.='<option value="'.$dList['id'].'">'.$dList['label'].'</option>';
										}
									}
								}
								$str.='</select></td>';
							}
							if($attributeData['form_type'] == 2){
								$str.='<td><input type="text" class="form-control" name="theme_color_map['.$option_row_no.']" /></td>';
							}
							$order_no++;
						}
						
					}
					else
					{
						
						$attribute_1_id = isset($attribute_array_id[$ik]) ? $attribute_array_id[$ik] : 0 ;
						
						if($attribute_1_id){
							$attributeData = $this->db->get_where('attribute',array('id'=>$attribute_1_id))->row_array();
							if($attributeData)
							{
								$str.='<td><input type="hidden" value="'.$val.'" name="theme_data['.$option_row_no.']['.$order_no.']" />'.$val.'</td>';
							
								if($attributeData['is_input_box']){
									
									// get attribute data
									$attributeData = $this->db->order_by('order_no','asc')->get_where('attribute_data',array('attribute_id'=>$attribute_1_id))->result_array();
									$str.='<td><select id="select01" class="form-control" name="theme_unit['.$option_row_no.']">';
									
									if($attributeData)
									{
										foreach($attributeData as $dList)
										{
											if($dList['is_default']){
												$str.='<option value="'.$dList['id'].'" selected="selected">'.$dList['label'].'</option>';
											}
											else
											{
												$str.='<option value="'.$dList['id'].'">'.$dList['label'].'</option>';
											}
										}
									}
									$str.='</select></td>';
									
								}
								if($attributeData['form_type'] == 2){
									$str.='<td><input type="text" class="form-control" name="theme_color_map['.$option_row_no.']" /></td>';
								}
								$order_no++;
							}
						}
						
					}
					
				}
			}
			$str.='<td><input type="text" class="form-control" name="theme_sku['.$option_row_no.']" /></td>';
			$str.='<td><input type="text" class="form-control" name="theme_price['.$option_row_no.']" /></td>';
			$str.='<td><input type="text" class="form-control" name="theme_discount_price['.$option_row_no.']" /></td>';
			$str.='<td><input type="text" class="form-control" name="theme_qty['.$option_row_no.']" /></td>';
			$str.='<td><select class="form-control" name="theme_stock['.$option_row_no.']"><option value="1">In Stock</option><option value="0">Out of Stock</option></select></td>';
			$str.='<td><select class="form-control" name="theme_status['.$option_row_no.']"><option value="1">Enable</option><option value="0">Disable</option></select></td>';
			$str.='<td><i class="fa fa-trash" onclick="deleteVariationRow('.$option_row_no.')" aria-hidden="true"></i></td>';
			$str.='</tr>';
			
			$str.='<tr id="variation_option_img_desc_tr_'.$option_row_no.'">';
			$str.='<td colspan="10">';
			$str.='<button type="button" class="btn btn-primary" onclick="showVariationImg('.$option_row_no.')">Images</button>';
			$str.='<button type="button" class="btn btn-primary" onclick="showVariationDesc('.$option_row_no.')">Bullet Points</button>';
			$str.='<div id="variation-desc-'.$option_row_no.'" style="display:none;">';
			$str.='<table class="table" style="width:50%;">';
			$str.='<tr>';
			$str.='<td>#</td>';
			$str.='<td>Bullet Points</td>';
			$str.='<td></td>';
			$str.='</tr>';
			for($i = 1; $i<=5; $i++){
				$str.='<tr>';
				$str.='<td>'.$i.'</td>';
				$str.='<td><input type="text" class="form-control" name="variation_instruction['.$option_row_no.'][]" /></td>';
				$str.='<td></td>';
				$str.='</tr>';
			}
			$str.='</table>';
			$str.='</div>';
			$str.='<div id="variation-img-'.$option_row_no.'" style="display:none;">';
			$str.='<div class="image-loader-'.$option_row_no.'"></div>';
			$str.='<h4>Main</h4>';
			$str.='<div class="image-upload-block" id="image-upload-block-'.$option_row_no.'-0"><i class="fa fa-camera" aria-hidden="true"></i></div>';
			$str.='<input type="file" style="display:none;" class="images" id="main_images_'.$option_row_no.'_0" onchange="uploadVariationImg('.$option_row_no.',0);" name="main_images_'.$option_row_no.'_0">';
			$str.='<button type="button" class="btn btn-primary main-upload-btn" onclick="openUploadBox('.$option_row_no.',0);">Upload</button>';
			$str.='<div class="main-image-delete-block" id="main-image-delete-block-'.$option_row_no.'-0"></div>';
			$str.='<br /><br />';
			$str.='<div class="row">';
			$str.='<div class="col-md-2 other-img">';
			$str.='<div class="image-upload-block2" id="image-upload-block-'.$option_row_no.'-1"><i class="fa fa-camera" aria-hidden="true"></i></div>';
			$str.='<input type="file" style="display:none;" class="images" id="main_images_'.$option_row_no.'_1" onchange="uploadVariationImg('.$option_row_no.',1);" name="main_images_'.$option_row_no.'_1">';
			$str.='<button type="button" class="btn btn-primary main-upload-btn2" onclick="openUploadBox('.$option_row_no.',1);">Upload</button>';
			$str.='<div class="main-image-delete-block2" id="main-image-delete-block-'.$option_row_no.'-1"></div>';
			$str.='</div>';
			$str.='<div class="col-md-2 other-img">';
			$str.='<div class="image-upload-block2" id="image-upload-block-'.$option_row_no.'-2"><i class="fa fa-camera" aria-hidden="true"></i></div>';
			$str.='<input type="file" style="display:none;" class="images" id="main_images_'.$option_row_no.'_2" onchange="uploadVariationImg('.$option_row_no.',2);" name="main_images_'.$option_row_no.'_2">';
			$str.='<button type="button" class="btn btn-primary main-upload-btn2" onclick="openUploadBox('.$option_row_no.',2);">Upload</button>';
			$str.='<div class="main-image-delete-block2" id="main-image-delete-block-'.$option_row_no.'-2"></div>';
			$str.='</div>';
			$str.='<div class="col-md-2 other-img">';
			$str.='<div class="image-upload-block2" id="image-upload-block-'.$option_row_no.'-3"><i class="fa fa-camera" aria-hidden="true"></i></div>';
			$str.='<input type="file" style="display:none;" class="images" id="main_images_'.$option_row_no.'_3" onchange="uploadVariationImg('.$option_row_no.',3);" name="main_images_'.$option_row_no.'_3">';
			$str.='<button type="button" class="btn btn-primary main-upload-btn2" onclick="openUploadBox('.$option_row_no.',3);">Upload</button>';
			$str.='<div class="main-image-delete-block2" id="main-image-delete-block-'.$option_row_no.'-3"></div>';
			$str.='</div>';
			$str.='<div class="col-md-2 other-img">';
			$str.='<div class="image-upload-block2" id="image-upload-block-'.$option_row_no.'-4"><i class="fa fa-camera" aria-hidden="true"></i></div>';
			$str.='<input type="file" style="display:none;" class="images" id="main_images_'.$option_row_no.'_4" onchange="uploadVariationImg('.$option_row_no.',4);" name="main_images_'.$option_row_no.'_4">';
			$str.='<button type="button" class="btn btn-primary main-upload-btn2" onclick="openUploadBox('.$option_row_no.',4);">Upload</button>';
			$str.='<div class="main-image-delete-block2" id="main-image-delete-block-'.$option_row_no.'-4"></div>';
			$str.='</div>';
			$str.='<div class="col-md-2 other-img">';
			$str.='<div class="image-upload-block2" id="image-upload-block-'.$option_row_no.'-5"><i class="fa fa-camera" aria-hidden="true"></i></div>';
			$str.='<input type="file" style="display:none;" class="images" id="main_images_'.$option_row_no.'_5" onchange="uploadVariationImg('.$option_row_no.',5);" name="main_images_'.$option_row_no.'_5">';
			$str.='<button type="button" class="btn btn-primary main-upload-btn2" onclick="openUploadBox('.$option_row_no.',5);">Upload</button>';
			$str.='<div class="main-image-delete-block2" id="main-image-delete-block-'.$option_row_no.'-5"></div>';
			$str.='</div>';
			$str.='<div class="col-md-2 other-img">';
			$str.='<div class="image-upload-block2" id="image-upload-block-'.$option_row_no.'-6"><i class="fa fa-camera" aria-hidden="true"></i></div>';
			$str.='<input type="file" style="display:none;" class="images" id="main_images_'.$option_row_no.'_6" onchange="uploadVariationImg('.$option_row_no.',6);" name="main_images_'.$option_row_no.'_6">';
			$str.='<button type="button" class="btn btn-primary main-upload-btn2" onclick="openUploadBox('.$option_row_no.',6);">Upload</button>';
			$str.='<div class="main-image-delete-block2" id="main-image-delete-block-'.$option_row_no.'-6"></div>';
			$str.='</div>';
			$str.='</div>';
			$str.='</div>';
			$str.='</td>';
			$str.='</tr>';
		}
		
		$option_row_no = $option_row_no + 1;
		
		$response = array(
			'status' => 1,
			'str' => $str,
			'option_row_no' => $option_row_no,
		);
		
		echo json_encode($response);
		
	}
	
	
	public function applyProductAction($action_type = 0)
	{
		$response = array();
		$post = $this->input->post();
		if(!isset($post['product_id']) || !$post['product_id'])
		{
			$response = array(
				'status' => 0,
				'msg' => 'Please select product.'
			);
		}
		else
		{
			if($action_type == 1)
			{
				$this->db->where_in('id',$post['product_id']);
				$this->db->update('products',array('status'=>1));
				$response = array(
					'status' => 1,
					'msg' => 'Product enabled successfully.'
				);
			}
			elseif($action_type == 2)
			{
				$this->db->where_in('id',$post['product_id']);
				$this->db->update('products',array('status'=>0));
				$response = array(
					'status' => 1,
					'msg' => 'Product disabled successfully.'
				);
			}
			elseif($action_type == 3)
			{
				$this->db->where_in('id',$post['product_id']);
				$this->db->update('products',array('stock_status'=>1));
				$response = array(
					'status' => 1,
					'msg' => 'Product Stock Updated Successfully.'
				);
			}
			elseif($action_type == 4)
			{
				$this->db->where_in('id',$post['product_id']);
				$this->db->update('products',array('stock_status'=>0));
				$response = array(
					'status' => 1,
					'msg' => 'Product Stock Updated Successfully.'
				);
			}
			elseif($action_type == 5)
			{
				foreach($post['product_id'] as $product_id){
					$productData = $this->db->order_by('created','desc')->get_where('products',array('id'=>$product_id))->row_array();
					$image_token = $productData['image_token'];
					
					// delete product all attribute
					$this->db->where('product_id',$product_id);
					$this->db->delete('product_attribute');
					
					// delete product all category
					$this->db->where('product_id',$product_id);
					$this->db->delete('product_category');
					
					// get product images
					$imageList = $this->db->get_where('product_images',array('product_id'=>$product_id))->result_array();
					if($imageList)
					{
						foreach($imageList as $list)
						{
							$image_path = $list['image_path'];
							$file_name = $list['file_name'];
							if($file_name)
							{
								if(file_exists("media/product_images/".$file_name))
								{
									unlink(str_replace('system/', '', BASEPATH . "media/product_images/".$file_name));
								}
								if(file_exists("media/product_images/thumbnail-70x70/".$file_name))
								{
									unlink(str_replace('system/', '', BASEPATH . "media/product_images/thumbnail-70x70/".$file_name));
								}
								if(file_exists("media/product_images/thumbnail-180x180/".$file_name))
								{
									unlink(str_replace('system/', '', BASEPATH . "media/product_images/thumbnail-180x180/".$file_name));
								}
								if(file_exists("media/product_images/thumbnail-400x400/".$file_name))
								{
									unlink(str_replace('system/', '', BASEPATH . "media/product_images/thumbnail-400x400/".$file_name));
								}
							}
							
							
						}
					}
					
					// delete product image 
					$this->db->where('product_id',$product_id);
					$this->db->delete('product_images');
					
					// delete product image temp data
					$this->db->where('token',$image_token);
					$this->db->delete('product_image_temp_data');
					
					// delete product meta data
					$this->db->where('product_id',$product_id);
					$this->db->delete('product_meta_data');
					
					// delete product offer
					$this->db->where('product_id',$product_id);
					$this->db->delete('product_offer');
					
					// delete product all SKU
					$this->db->where('product_id',$product_id);
					$this->db->delete('product_sku');
					
					// delete product all variation product
					$this->db->where('product_id',$product_id);
					$this->db->delete('product_variation_attribute');
					
					// delete product all variation product
					$this->db->where('product_id',$product_id);
					$this->db->delete('product_variation_product_data');
					
					// delete product all variation product images
					$this->db->where('product_id',$product_id);
					$this->db->delete('product_variation_product_images');
					
					// delete product all variation product instruction
					$this->db->where('product_id',$product_id);
					$this->db->delete('product_variation_product_instruction');
					
					// delete product all variation theme data
					$this->db->where('product_id',$product_id);
					$this->db->delete('product_variation_theme_data');
					
					$this->db->where('id',$product_id);
					$this->db->delete('products');
				}
				$response = array(
					'status' => 1,
					'msg' => 'Product Deleted Successfully.'
				);
			}
			elseif($action_type == 6)
			{
				$this->db->where_in('id',$post['product_id']);
				$this->db->update('products',array('approve_status'=>1));
				$response = array(
					'status' => 1,
					'msg' => 'Product Approve Status Updated Successfully.'
				);
			}
			elseif($action_type == 7)
			{
				$this->db->where_in('id',$post['product_id']);
				$this->db->update('products',array('approve_status'=>2));
				$response = array(
					'status' => 1,
					'msg' => 'Product Approve Status Updated Successfully.'
				);
			}
			elseif($action_type == 8)
			{
				$this->db->where_in('id',$post['product_id']);
				$this->db->update('products',array('approve_status'=>3));
				$response = array(
					'status' => 1,
					'msg' => 'Product Approve Status Updated Successfully.'
				);
			}
		}
		
		echo json_encode($response);
	}
	
	public function getSubParentCategory($catID = 0)
	{
		// get parent slug
		$getParentSlug = $this->db->get_where('category',array('id'=>$catID))->row_array();
		$parent_slug = isset($getParentSlug['slug']) ? $getParentSlug['slug'] : '';
		$str = '<ul>';
		$subCategoryList = $this->db->order_by('created','desc')->get_where('category',array('parent_id'=>$catID))->result_array();
		if($subCategoryList)
		{
			foreach($subCategoryList as $subKey=>$list)
			{
				$str.='<li><a href="'.base_url().'admin/catalog/addProduct/'.$parent_slug.'/'.$list['slug'].'" class="sub-parent-cat-link" id="'.$list['id'].'">'.$list['title'].'</a></li>';
				
				
			}
		}
		$str.='</ul>';
		echo $str;
	}
	
	public function getSubSubParentCategory($catID = 0)
	{
		// get parent slug
		$getSubParentSlug = $this->db->get_where('category',array('id'=>$catID))->row_array();
		$sub_parent_slug = isset($getSubParentSlug['slug']) ? $getSubParentSlug['slug'] : '';
		$sub_parent_id = isset($getSubParentSlug['parent_id']) ? $getSubParentSlug['parent_id'] : 0;
		
		// get parent slug
		$getParentSlug = $this->db->get_where('category',array('id'=>$sub_parent_id))->row_array();
		$parent_slug = isset($getParentSlug['slug']) ? $getParentSlug['slug'] : '';
		
		
		$str = '<ul>';
		$subCategoryList = $this->db->order_by('created','desc')->get_where('category',array('parent_id'=>$catID))->result_array();
		if($subCategoryList)
		{
			foreach($subCategoryList as $subKey=>$list)
			{
				$str.='<li><a href="'.base_url().'admin/catalog/addProduct/'.$parent_slug.'/'.$sub_parent_slug.'/'.$list['slug'].'" class="sub-sub-parent-cat-link" id="'.$list['id'].'">'.$list['title'].'</a></li>';
				
				
			}
		}
		$str.='</ul>';
		echo $str;
	}
	
	public function getSubSubSubParentCategory($catID = 0)
	{
		// get parent slug
		$getSubSubParentSlug = $this->db->get_where('category',array('id'=>$catID))->row_array();
		$sub_sub_parent_slug = isset($getSubSubParentSlug['slug']) ? $getSubSubParentSlug['slug'] : '';
		$sub_sub_parent_id = isset($getSubSubParentSlug['parent_id']) ? $getSubSubParentSlug['parent_id'] : 0;
		
		// get parent slug
		$getSubParentSlug = $this->db->get_where('category',array('id'=>$sub_sub_parent_id))->row_array();
		$sub_parent_slug = isset($getSubParentSlug['slug']) ? $getSubParentSlug['slug'] : '';
		$sub_parent_id = isset($getSubParentSlug['parent_id']) ? $getSubParentSlug['parent_id'] : 0;
		
		// get parent slug
		$getParentSlug = $this->db->get_where('category',array('id'=>$sub_parent_id))->row_array();
		$parent_slug = isset($getParentSlug['slug']) ? $getParentSlug['slug'] : '';
		
		
		$str = '<ul>';
		$subCategoryList = $this->db->order_by('created','desc')->get_where('category',array('parent_id'=>$catID))->result_array();
		if($subCategoryList)
		{
			foreach($subCategoryList as $subKey=>$list)
			{
				$str.='<li><a href="'.base_url().'admin/catalog/addProduct/'.$parent_slug.'/'.$sub_parent_slug.'/'.$sub_sub_parent_slug.'/'.$list['slug'].'" class="sub-sub-sub-parent-cat-link" id="'.$list['id'].'">'.$list['title'].'</a></li>';
				
				
			}
		}
		$str.='</ul>';
		echo $str;
	}
	
	
	public function editProduct($product_id = 0)
    {
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		
		// product token
		$token = do_hash(time());
		
		
		// get attribute set List
		$attributeSetList = $this->db->order_by('created','desc')->get_where('attribute_set',array('status'=>1))->result_array();
		
		// get weight unit
		$getWeightUnit  = $this->db->get_where('attribute',array('is_weight_unit'=>1,'status'=>1))->row_array();
		$weight_attribute_id = isset($getWeightUnit['id']) ? $getWeightUnit['id'] : 0 ;
		// get unit list
		$weightUnitList  = $this->db->order_by('order_no','asc')->get_where('attribute_data',array('attribute_id'=>$weight_attribute_id))->result_array();
		
		// get visibility list
		$visibilityList  = $this->db->get('product_visibility_type')->result_array();
		
		
		// get variation list
		$variationList = array();
		
		// get product data
		$productData = $this->db->get_where('products',array('id'=>$product_id))->row_array();
		
		// get product offer data
		$productOfferData = $this->db->get_where('product_offer',array('product_id'=>$product_id))->row_array();
		
		// get product meta data
		$productMetaData = $this->db->get_where('product_meta_data',array('product_id'=>$product_id))->row_array();
		
		// get product base image
		$get_product_base_img = $this->db->select('id,image_path,is_base,is_large')->get_where('product_images',array('product_id'=>$product_id))->result_array();
		$product_base_image = '';
		$product_base_id = 0;
		$product_large_image = array();
		$jk = 0;
		if($get_product_base_img)
		{
			foreach($get_product_base_img as $list)
			{
				if($list['is_base'] == 1)
				{
					$product_base_image = $list['image_path'];
					$product_base_id = $list['id'];
				}
				else
				{
					$product_large_image[$jk]['id'] = $list['id'];
					$product_large_image[$jk]['image_path'] = $list['image_path'];
					$jk++;
				}
			}
		}
		
		
		$categoryList = $this->db->order_by('created','desc')->get_where('category',array('parent_id'=>0))->result_array();
		$parent_category_list = array();
		$j = 0;
		if($categoryList)
		{
			foreach($categoryList as $key=>$list)
			{
				$parent_category_list[$key]['id'] = $list['id'];
				$parent_category_list[$key]['title'] = $list['title'];
				$parent_category_list[$key]['slug'] = $list['slug'];
				$cat_id = $list['id'];
				$subCategoryList = $this->db->order_by('created','desc')->get_where('category',array('parent_id'=>$cat_id))->result_array();
				if($subCategoryList)
				{
					foreach($subCategoryList as $subKey=>$subList)
					{
						$parent_category_list[$key]['subCat'][$subKey]['id'] = $subList['id'];
						$parent_category_list[$key]['subCat'][$subKey]['title'] = $subList['title'];
						$parent_category_list[$key]['subCat'][$subKey]['slug'] = $subList['slug'];
						$j++;
						$sub_cat_id = $subList['id'];
						$subSubCategoryList = $this->db->order_by('created','desc')->get_where('category',array('parent_id'=>$sub_cat_id))->result_array();
						if($subSubCategoryList)
						{
							foreach($subSubCategoryList as $subSubKey=>$subSubList)
							{
								$parent_category_list[$key]['subCat'][$subKey]['subCat'][$subSubKey]['id'] = $subSubList['id'];
								$parent_category_list[$key]['subCat'][$subKey]['subCat'][$subSubKey]['title'] = $subSubList['title'];
								$parent_category_list[$key]['subCat'][$subKey]['subCat'][$subSubKey]['slug'] = $subSubList['slug'];
								$j++;
								$sub_sub_cat_id = $subSubList['id'];
								$subSubSubCategoryList = $this->db->order_by('created','desc')->get_where('category',array('parent_id'=>$sub_sub_cat_id))->result_array();
								if($subSubSubCategoryList)
								{
									foreach($subSubSubCategoryList as $subSubSubKey=>$subSubSubList)
									{
										$sub_sub_sub_cat_id = $subSubSubList['id'];
										$parent_category_list[$key]['subCat'][$subKey]['subCat'][$subSubKey]['subCat'][$subSubSubKey]['id'] = $subSubSubList['id'];
										$parent_category_list[$key]['subCat'][$subKey]['subCat'][$subSubKey]['subCat'][$subSubSubKey]['title'] = $subSubSubList['title'];
										$parent_category_list[$key]['subCat'][$subKey]['subCat'][$subSubKey]['subCat'][$subSubSubKey]['slug'] = $subSubSubList['slug'];
										$j++;
									}
								}
							}
						}
					}
				}
			}
		}
		
		// get product category
		$productCategoryList = $this->db->select('category_id')->get_where('product_category',array('product_id'=>$product_id))->result_array();
		$product_category_id = array();
		if($productCategoryList)
		{
			foreach($productCategoryList as $key=>$list)
			{
				$product_category_id[$key] = $list['category_id'];
			}
		}
		
		
		   	
		$siteUrl = site_url();
        $data = array(
            'site_url' => $siteUrl,
			'loggedUser' => $loggedUser,
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'content_block' => 'catalog/editProduct',
            'manager_description' => lang('SITE_NAME'),
			'attributeSetList' => $attributeSetList,
			'weightUnitList' => $weightUnitList,
			'visibilityList' => $visibilityList,
			'token' => $token,
			'variationList' => $variationList,
			'product_id' => $product_id,
			'productData' => $productData,
			'product_base_image' => $product_base_image,
			'product_base_id' => $product_base_id,
			'product_large_image' => $product_large_image,
			'parent_category_list' => $parent_category_list,
			'product_category_id' => $product_category_id,
			'productOfferData' => $productOfferData,
			'productMetaData' => $productMetaData,
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getSystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning() 
		);
        $this->parser->parse('admin/layout/column-1', $data);
		
    }
	
	
	public function updateProduct()
	{
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		$userID = $loggedUser['id'];
		$post = $this->input->post();
		
		$product_id = $post['product_id'];
		$this->load->library('form_validation');
		$this->form_validation->set_rules('product_name', 'Product Name', 'required|xss_clean');
		$this->form_validation->set_rules('sku', 'SKU', 'required|xss_clean');
		$this->form_validation->set_rules('price', 'Price', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			
			$this->editProduct($product_id);
		}
		else
		{
			
			// update organizer detail
			$this->Catalog_model->update_product_data($post);
			$this->Az->redirect('admin/catalog/productList', 'system_message_error',lang('PRODUCT_SAVE_SUCCESS'));
		}
		
	}
	
}
?>