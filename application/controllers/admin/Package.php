<?php 
class Package extends CI_Controller {    
    
    
    public function __construct() 
    {
        parent::__construct();
       	$this->User->checkPermission();
        $this->load->model('admin/Package_model');		
        $this->lang->load('admin/package', 'english');
        
    }

	public function packageList(){

		//get logged user info
        $loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		
		
  		$siteUrl = base_url();		

		$data = array(
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'site_url' => $siteUrl,
			'loggedUser'  => $loggedUser,
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getsystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'content_block' => 'package/packageList'
        );
        $this->parser->parse('admin/layout/column-1' , $data);
    
	
	}


	public function getPackageList()
	{	
		$requestData= $this->input->get();
		$extra_search = $requestData['extra_search'];	
	   	$keyword = '';
		if($extra_search)
		{
			$filterData = explode('|',$extra_search);
			$keyword = isset($filterData[0]) ? trim($filterData[0]) : '';
		}
		
		$columns = array( 
		// datatable column index  => database column name
			0 => 'id',	
			1 => 'package_display_id',
			2 => 'package_name',
			4 => 'created',
			5 => 'status',
		);
		
		
		
			// getting total number records without any search
			$sql = "SELECT * FROM tbl_package as a  where  a.id > 0";
			
			$totalData = $this->db->query($sql)->num_rows();
			$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
		
		
			$sql = "SELECT * FROM tbl_package as a where a.id > 0";	

			if($keyword != '') {   
				$sql.=" AND ( a.package_display_id LIKE '".$keyword."%' ";    
				$sql.=" OR a.package_name LIKE '".$keyword."%' )";
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
				$i=1;
			foreach($get_filter_data as $list){
				
				
				$nestedData=array(); 
				$nestedData[] = $i;
				$nestedData[] = "<a href='javascript:void(0)' style='text-decoration:none;'>".$list['package_display_id']."</a>";
				$nestedData[] = $list['package_name'];
				
				$str = '<table class="table">';
				$str.='<tr><td><b>Amount </b></td><td>'.$list['package_amount'].' /- '.'</td></tr>';
				$str.='<tr><td><b>CM Points </b></td><td>'.$list['cm_points'].'</td></tr>';
				$str.='<tr><td><b>Refer CM Points </b></td><td>'.$list['refer_cm_points'].'</td></tr>';
				$str.='<tr><td><b>Cashback </b></td><td>'.$list['cashback'].' % '.'</td></tr>';
				$str.='</table>';
				$nestedData[] = $str;


				$nestedData[] = date('d-M-Y',strtotime($list['created']));
				if($list['status'] == 1) {
					$nestedData[] = '<font color="green">Active</font>';
				}
				elseif($list['status'] == 0) {
					$nestedData[] = '<font color="red">Deactive</font>';
				}
				
				$nestedData[] ='<a title="edit" class="btn btn-primary btn-sm" href="'.base_url('admin/package/editPackage').'/'.$list['id'].'"><i class="fa fa-edit" aria-hidden="true"></i></a> <a title="delete" class="btn btn-danger btn-sm" href="'.base_url('admin/package/deletePackage').'/'.$list['id'].'" onclick="return confirm(\'Are you sure you want to delete?\')"><i class="fa fa-trash" aria-hidden="true"></i></a>';
				
				$data[] = $nestedData;
				
				
				
			$i++;}
		}



		$json_data = array(
					"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
					"recordsTotal"    => intval( $totalData ),  // total number of records
					"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
					"data"            => $data,   // total data array
					);

		echo json_encode($json_data);  // send data as json format
	}


	
	// add package
	public function addPackage()
    {
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");

		$siteUrl = site_url();
        $data = array(
            'site_url' => $siteUrl,
			'loggedUser' => $loggedUser,
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'content_block' => 'package/addPackage',
            'manager_description' => lang('SITE_NAME'),
          	'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getSystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning() 
		);

        $this->parser->parse('admin/layout/column-1', $data);
		
    }

    // save package
	public function savePackage()
	{
		//check for foem validation
		$post = $this->input->post();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('package_name', 'Package Name', 'required|xss_clean');
        $this->form_validation->set_rules('package_amount', 'Package Amount', 'required|numeric|xss_clean');
        $this->form_validation->set_rules('cm_points', 'CM Points ', 'required|xss_clean|numeric');
        $this->form_validation->set_rules('refer_cm_points', 'Refer CM Points', 'required|xss_clean|numeric');
		$this->form_validation->set_rules('cashback', 'Cashback', 'required|numeric|xss_clean');
        

		if ($this->form_validation->run() == FALSE) {
			
			$this->addPackage();
		}
		else
		{			
			$status = $this->Package_model->savePackage($post);
			
			if($status == true)
			{
				$this->Az->redirect('admin/package/packageList', 'system_message_error',lang('PACKAGE_SAVED'));
			}
			else
			{
				$this->Az->redirect('admin/package/packageList', 'system_message_error',lang('PACKAGE_ERROR'));
			}
			
		}
	
	}

	// edit package
	public function editPackage($id)
    {    

    	$loggedUser = $this->User->getLoggedUser('codunitecrm_admin');
		//get package list
		$packageList = $this->db->get_where('package',array('id'=>$id))->row_array();

		$accountID=$loggedUser['id'];	
    	$siteUrl = site_url();
    	$id=$id;
		$data = array(
			'loggedUser' => $loggedUser,
            'site_url' => $siteUrl,
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'content_block' => 'package/editPackage',
            'manager_description' => lang('SITE_NAME'),
			'packageList' => $packageList,
			'accountID'=>$accountID,
			'id'=>$id,
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getSystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning()
        );
        $this->parser->parse('admin/layout/column-1', $data);
		
    }

    //update package
	public function updatePackage()
	{
		//check for foem validation
		$post = $this->input->post();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('package_name', 'Package Name', 'required|xss_clean');
        $this->form_validation->set_rules('package_amount', 'Package Amount', 'required|numeric|xss_clean');
        $this->form_validation->set_rules('cm_points', 'CM Points ', 'required|xss_clean|numeric');
        $this->form_validation->set_rules('refer_cm_points', 'Refer CM Points', 'required|xss_clean|numeric');
		$this->form_validation->set_rules('cashback', 'Cashback', 'required|numeric|xss_clean');

		if ($this->form_validation->run() == FALSE) {
			
			$this->editPackage($post['id']);
		}
		else
		{
			
			$status = $this->Package_model->updatePackage($post);
			
			if($status == true)
			{
				$this->Az->redirect('admin/package/packageList', 'system_message_error',lang('PACKAGE_UPDATED'));
			}
			else
			{
				$this->Az->redirect('admin/package/packageList', 'system_message_error',lang('PACKAGE_ERROR'));
			}
			
		}
	
	}
	
	
	//delete package
	public function deletePackage($id)
	{
		$this->db->where('id',$id);
		$this->db->delete('package');
		$this->Az->redirect('admin/package/packageList', 'system_message_error',lang('PACKAGE_DELETED'));
	}
	
	
}