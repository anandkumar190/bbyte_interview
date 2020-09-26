<?php 
class Member extends CI_Controller {    
    
    
    public function __construct() 
    {
        parent::__construct();
       	$this->User->checkPermission();
        $this->load->model('admin/Member_model');		
        $this->lang->load('admin/member', 'english');
        
    }

	public function memberList(){

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
            'content_block' => 'member/memberList'
        );
        $this->parser->parse('admin/layout/column-1' , $data);
    
	
	}


	public function getMemberList()
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
			1 => 'user_code',
			2 => 'name',
			4 => 'wallet_balance',
			5 => 'created',
		);
		
		
		
			// getting total number records without any search
			$sql = "SELECT * FROM tbl_users as a  where  a.role_id = 2";
			
			$totalData = $this->db->query($sql)->num_rows();
			$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
		
		
			$sql = "SELECT * FROM tbl_users as a where a.role_id = 2";	

			if($keyword != '') {   
				$sql.=" AND ( a.user_code LIKE '".$keyword."%' ";    
				$sql.=" OR a.name LIKE '".$keyword."%' ";
				$sql.=" OR a.email LIKE '".$keyword."%' ";
				$sql.=" OR a.mobile LIKE '".$keyword."%' )";
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
				$nestedData[] = "<a href='javascript:void(0)' style='text-decoration:none;'>".$list['user_code']."</a>";
				$nestedData[] = $list['name'];
				
				$str = '<table class="table">';
				$str.='<tr><td><b>User name </b></td><td>'.$list['username'].'</td></tr>';
				$str.='<tr><td><b>Password </b></td><td>'.$list['decode_password'].'</td></tr>';
				$str.='<tr><td><b>Email </b></td><td>'.$list['email'].'</td></tr>';
				$str.='<tr><td><b>Mobile </b></td><td>'.$list['mobile'].'</td></tr>';
				$str.='</table>';
				$nestedData[] = $str;

				$nestedData[]=$list['wallet_balance'].' /- ';

				$nestedData[] = date('d-M-Y',strtotime($list['created']));
				if($list['is_active'] == 1) {
					$nestedData[] = '<font color="green">Active</font>';
				}
				elseif($list['is_active'] == 0) {
					$nestedData[] = '<font color="red">Deactive</font>';
				}
				
				$nestedData[] ='<a title="edit" class="btn btn-primary btn-sm" href="'.base_url('admin/member/editMember').'/'.$list['id'].'"><i class="fa fa-edit" aria-hidden="true"></i></a> <a title="delete" class="btn btn-danger btn-sm" href="'.base_url('admin/member/deleteMember').'/'.$list['id'].'" onclick="return confirm(\'Are you sure you want to delete?\')"><i class="fa fa-trash" aria-hidden="true"></i></a>';
				
				$data[] = $nestedData;
				
				
				
			$i++;}
		}



		$json_data = array(
					"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
					"recordsTotal"    => intval( $totalData ),  // total number of records
					"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
					"data"            => $data,   // total data array
					//"total_selected_students" => $total_selected_students
					);

		echo json_encode($json_data);  // send data as json format
	}
	
	
	public function investmentList(){

		//get logged user info
        $loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		
		// get package list
		$packageList = $this->db->get_where('package',array('id > '=>1))->result_array();

		
  		$siteUrl = base_url();		

		$data = array(
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'site_url' => $siteUrl,
			'loggedUser'  => $loggedUser,
			'packageList' => $packageList,
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getsystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'content_block' => 'member/investmentList'
        );
        $this->parser->parse('admin/layout/column-1' , $data);
    
	
	}


	public function getInvestmentList()
	{	
		$requestData= $this->input->get();
		$extra_search = $requestData['extra_search'];	
	   	$keyword = '';
	   	$package_id = '';
		if($extra_search)
		{
			$filterData = explode('|',$extra_search);
			$keyword = isset($filterData[0]) ? trim($filterData[0]) : '';
			$package_id = isset($filterData[1]) ? trim($filterData[1]) : 0;
		}
		
		$columns = array( 
		// datatable column index  => database column name
			5 => 'a.created',
		);
		
		
		
			// getting total number records without any search
			$sql = "SELECT c.user_code,c.name,b.package_name,b.package_amount,a.created FROM tbl_member_investment as a INNER JOIN tbl_package as b ON b.id = a.package_id INNER JOIN tbl_users as c ON c.id = a.member_id where a.id > 0";
			
			$totalData = $this->db->query($sql)->num_rows();
			$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
		
		
			$sql = "SELECT c.user_code,c.name,b.package_name,b.package_amount,a.created FROM tbl_member_investment as a INNER JOIN tbl_package as b ON b.id = a.package_id INNER JOIN tbl_users as c ON c.id = a.member_id where a.id > 0";	

			if($keyword != '') {   
				$sql.=" AND ( c.user_code LIKE '%".$keyword."%' ";    
				$sql.=" OR b.package_name LIKE '%".$keyword."%' ";
				$sql.=" OR c.name LIKE '%".$keyword."%' ";
				$sql.=" OR c.email LIKE '%".$keyword."%' ";
				$sql.=" OR c.mobile LIKE '%".$keyword."%' )";
			}

			if($package_id)
			{
				$sql.=" AND b.id = '$package_id'";    
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
				$nestedData[] = "<a href='javascript:void(0)' style='text-decoration:none;'>".$list['user_code']."</a>";
				$nestedData[] = $list['name'];
				$nestedData[] = $list['package_name'];
				$nestedData[] = 'INR '.number_format($list['package_amount'],2);
				$nestedData[] = date('d-M-Y',strtotime($list['created']));
				$data[] = $nestedData;
				
				
				
			$i++;}
		}



		$json_data = array(
					"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
					"recordsTotal"    => intval( $totalData ),  // total number of records
					"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
					"data"            => $data,   // total data array
					//"total_selected_students" => $total_selected_students
					);

		echo json_encode($json_data);  // send data as json format
	}
	
	
	// add member
	public function addMemberPackage()
    {
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		
		// get member list
		$memberList = $this->db->order_by('name','asc')->get_where('users',array('role_id'=>2))->result_array();
		
		// get package list
		$packageList = $this->db->get_where('package',array('id >'=>1))->result_array();

   		$siteUrl = site_url();
        $data = array(
            'site_url' => $siteUrl,
			'loggedUser' => $loggedUser,
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'content_block' => 'member/addMemberPackage',
            'manager_description' => lang('SITE_NAME'),
			'memberList' => $memberList,
			'packageList' => $packageList,
          	'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getSystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning() 
		);

        $this->parser->parse('admin/layout/column-1', $data);
		
    }

    // save member
	public function saveMemberPackage()
	{
		//check for foem validation
		$post = $this->input->post();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('member_id', 'Member', 'required|xss_clean');
        $this->form_validation->set_rules('package_id', 'Package', 'required|xss_clean');
        
		if ($this->form_validation->run() == FALSE) {
			
			$this->addMemberPackage();
		}
		else
		{	
		
			$this->User->upgrade_member_package_manual($post['member_id'],$post['package_id']);
			$this->Az->redirect('admin/member/investmentList', 'system_message_error',lang('MEMBER_PACKAGE_SAVED'));
			
		}
	
	}


	
	// add member
	public function addMember()
    {
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");

   		$siteUrl = site_url();
        $data = array(
            'site_url' => $siteUrl,
			'loggedUser' => $loggedUser,
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'content_block' => 'member/addMember',
            'manager_description' => lang('SITE_NAME'),
          	'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getSystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning() 
		);

        $this->parser->parse('admin/layout/column-1', $data);
		
    }

    // save member
	public function saveMember()
	{
		//check for foem validation
		$post = $this->input->post();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Name', 'required|xss_clean');
        $this->form_validation->set_rules('email', 'Email ', 'required|xss_clean|valid_email');
        $this->form_validation->set_rules('mobile', 'Mobile Number', 'required|xss_clean|numeric|max_length[12]');
        $this->form_validation->set_rules('password', 'Password', 'required|xss_clean');
        
		if ($this->form_validation->run() == FALSE) {
			
			$this->addMember();
		}
		else
		{	
			$chk_mobile_email =$this->db->query("SELECT * FROM tbl_users WHERE email = '$post[email]' or mobile = '$post[mobile]'")->num_rows();
            
			if($chk_mobile_email){

			$this->Az->redirect('admin/member/addMember', 'system_message_error',lang('EMAIL_MOBILE_ERROR'));	

			}

			$status = $this->Member_model->saveMember($post);
			
			if($status == true)
			{
				$this->Az->redirect('admin/member/memberList', 'system_message_error',lang('MEMBER_SAVED'));
			}
			else
			{
				$this->Az->redirect('admin/member/memberList', 'system_message_error',lang('MEMBER_ERROR'));
			}
			
		}
	
	}

	// edit employe
	public function editMember($id)
    {    

    	$loggedUser = $this->User->getLoggedUser('cranesmart_admin');
		//get member list
		$memberList = $this->db->get_where('users',array('id'=>$id))->row_array();

		
		$accountID=$loggedUser['id'];	
    	$siteUrl = site_url();
    	$id=$id;
		$data = array(
			'loggedUser' => $loggedUser,
            'site_url' => $siteUrl,
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'content_block' => 'member/editMember',
            'manager_description' => lang('SITE_NAME'),
			'memberList' => $memberList,
			'accountID'=>$accountID,
			'id'=>$id,
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getSystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning()
        );
        $this->parser->parse('admin/layout/column-1', $data);
		
    }

    //update member
	public function updateMember()
	{
		//check for foem validation
		$post = $this->input->post();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Name', 'required|xss_clean');
        $this->form_validation->set_rules('email', 'Email ', 'required|xss_clean|valid_email');
        $this->form_validation->set_rules('mobile', 'Mobile Number', 'required|xss_clean|numeric|max_length[12]');
        
		if ($this->form_validation->run() == FALSE) {
			
			$this->editMember($post['id']);
		}
		else
		{	
			$chk_mobile_email =$this->db->query("SELECT * FROM tbl_users WHERE (email = '$post[email]' OR mobile = '$post[mobile]') and id != '$post[id]'")->num_rows();
            
			if($chk_mobile_email){

				$this->Az->redirect('admin/member/editMember/'.$post['id'], 'system_message_error',lang('EMAIL_MOBILE_ERROR'));	

			}


			$status = $this->Member_model->updateMember($post);
			
			if($status == true)
			{
				$this->Az->redirect('admin/member/memberList', 'system_message_error',lang('MEMBER_UPDATED'));
			}
			else
			{
				$this->Az->redirect('admin/member/memberList', 'system_message_error',lang('MEMBER_ERROR'));
			}
			
		}
	
	}
	
	
	//delete member
	public function deleteMember($id)
	{
		$this->db->where('id',$id);
		$this->db->delete('users');
		
		$this->Az->redirect('admin/member/memberList', 'system_message_error',lang('MEMBER_DELETED'));
	}
	
	
	public function memberTree(){

		//get logged user info
        $loggedUser = $this->User->getLoggedUser("cranesmart_admin");

        // get member list
        $memberList = $this->db->order_by('name','asc')->where_in('role_id',array(1,2))->get('users')->result_array();

        $search_status = 0;
		
		
  		$siteUrl = base_url();		

		$data = array(
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'site_url' => $siteUrl,
			'loggedUser'  => $loggedUser,
			'memberList' => $memberList,
			'search_status' => $search_status,
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getsystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'content_block' => 'member/memberTree'
        );
        $this->parser->parse('admin/layout/column-1' , $data);
    
	
	}

	public function memberTreeAuth()
	{
		//check for foem validation
		$post = $this->input->post();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('member_id', 'Member ID', 'required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
			
			$this->memberTree();
		}
		else
		{
			$member_id = $post['member_id'];
			// get member tree
			$memberTree = $this->User->get_member_tree($member_id);	

			// get member direct downline
			$directDownlineList = $this->User->get_member_direct_downline($member_id);

			// get member direct active
			$directActiveList = $this->User->get_member_direct_active_downline($member_id);

			// get member direct deactive
			$directDeactiveList = $this->User->get_member_direct_deactive_downline($member_id);

			// get member total downline
			$totalDownlineList = $this->User->get_member_total_downline_member($member_id);

			// get member direct downline
			$totalActiveList = $totalDownlineList;
			$totalDeactiveList = $totalDownlineList;
			if($totalActiveList)
			{
				foreach($totalActiveList as $key=>$list)
				{
					if($list['paid_status'] == 0)
					{
						unset($totalActiveList[$key]);
					}
				}
			}

			if($totalDeactiveList)
			{
				foreach($totalDeactiveList as $key=>$list)
				{
					if($list['paid_status'] == 1)
					{
						unset($totalDeactiveList[$key]);
					}
				}
			}

			//get logged user info
	        $loggedUser = $this->User->getLoggedUser("cranesmart_admin");

	        // get member list
	        $memberList = $this->db->order_by('name','asc')->where_in('role_id',array(1,2))->get('users')->result_array();

	        $search_status = 1;
			
			
	  		$siteUrl = base_url();		

			$data = array(
	            'meta_title' => lang('SITE_NAME'),
	            'meta_keywords' => lang('SITE_NAME'),
	            'meta_description' => lang('SITE_NAME'),
	            'site_url' => $siteUrl,
				'loggedUser'  => $loggedUser,
				'memberList' => $memberList,
				'search_status' => $search_status,
				'member_id' => $member_id,
				'memberTree' => $memberTree,
				'directDownlineList'=> $directDownlineList,
				'directActiveList' => $directActiveList,
				'directDeactiveList' => $directDeactiveList,
				'totalDownlineList' => $totalDownlineList,
				'totalActiveList' => $totalActiveList,
				'totalDeactiveList' => $totalDeactiveList,
				'system_message' => $this->Az->getSystemMessageError(),
	            'system_info' => $this->Az->getsystemMessageInfo(),
	            'system_warning' => $this->Az->getSystemMessageWarning(),
	            'content_block' => 'member/memberTree'
	        );
	        $this->parser->parse('admin/layout/column-1' , $data);
			
		}
	
	}
	
	// add member
	public function addManulMember()
    {
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");

		// get member list
	    $memberList = $this->db->order_by('name','asc')->where_in('role_id',array(1,2))->get('users')->result_array();

   		$siteUrl = site_url();
        $data = array(
            'site_url' => $siteUrl,
			'loggedUser' => $loggedUser,
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'content_block' => 'member/addManulMember',
            'manager_description' => lang('SITE_NAME'),
            'memberList' => $memberList,
          	'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getSystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning() 
		);

        $this->parser->parse('admin/layout/column-1', $data);
		
    }

    // save member
	public function saveManualMember()
	{
		//check for foem validation
		$post = $this->input->post();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('member_id', 'Member ID', 'required|xss_clean');
        $this->form_validation->set_rules('member_number', 'Number of Member ID ', 'required|xss_clean|numeric');
        $this->form_validation->set_rules('password', 'Password', 'required|xss_clean');
        
		if ($this->form_validation->run() == FALSE) {
			
			$this->addManulMember();
		}
		else
		{	
			$str = '';

			for($i = 1; $i<= $post['member_number']; $i++)
			{
				$status = $this->Member_model->saveManualMember($post);
				$str.='<div class="alert alert-success alert-dismissable"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Member #'.$status.' with Password - '.$post['password'].' Added Successfully.</div>';
			}
			
			$this->Az->redirect('admin/member/addManulMember', 'system_message_error',$str);
			
			
		}
	
	}
	
	
	public function benificaryList(){

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
            'content_block' => 'member/benificaryList'
        );
        $this->parser->parse('admin/layout/column-1' , $data);
    
	
	}


	public function getBenificaryList()
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
			8 => 'a.created',
		);
		
		
		
			// getting total number records without any search
			$sql = "SELECT a.*,c.user_code,c.name FROM tbl_user_benificary as a INNER JOIN tbl_users as c ON c.id = a.user_id where a.id > 0";
			
			$totalData = $this->db->query($sql)->num_rows();
			$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
		
		
			$sql = "SELECT a.*,c.user_code,c.name FROM tbl_user_benificary as a INNER JOIN tbl_users as c ON c.id = a.user_id where a.id > 0";

			if($keyword != '') {   
				$sql.=" AND ( c.user_code LIKE '".$keyword."%' ";    
				$sql.=" OR a.account_holder_name LIKE '".$keyword."%' ";
				$sql.=" OR c.name LIKE '".$keyword."%' ";
				$sql.=" OR a.bank_name LIKE '".$keyword."%' ";
				$sql.=" OR a.account_no LIKE '".$keyword."%' ";
				$sql.=" OR a.ifsc LIKE '".$keyword."%' ";
				$sql.=" OR c.mobile LIKE '".$keyword."%' )";
			}
			
			$order_type = $requestData['order'][0]['dir'];
			//if($requestData['draw'] == 1)
			//	$order_type = 'DESC';
			
			$order_no = isset($requestData['order'][0]['column']) ? ($requestData['order'][0]['column'] == 0) ? 8 : $requestData['order'][0]['column'] : 8;
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
				$nestedData[] = "<a href='javascript:void(0)' style='text-decoration:none;'>".$list['user_code']."</a>";
				$nestedData[] = $list['name'];
				$nestedData[] = $list['account_holder_name'];
				$nestedData[] = $list['bank_name'];
				$nestedData[] = $list['account_no'];
				$nestedData[] = $list['ifsc'];
				if($list['status'] == 1)
				{
					$nestedData[] = '<font color="orange">Pending</font>';
				}
				elseif($list['status'] == 2)
				{
					$nestedData[] = '<font color="green">Success</font>';
				}
				elseif($list['status'] == 3)
				{
					$nestedData[] = '<font color="red">Failed</font>';
				}
				$nestedData[] = date('d-m-Y',strtotime($list['created']));
				
				$nestedData[] ='<a title="delete" class="btn btn-danger btn-sm" href="'.base_url('admin/member/deleteBenificary').'/'.$list['id'].'" onclick="return confirm(\'Are you sure you want to delete?\')"><i class="fa fa-trash" aria-hidden="true"></i></a>';
				
				$data[] = $nestedData;
				
				
				
			$i++;}
		}



		$json_data = array(
					"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
					"recordsTotal"    => intval( $totalData ),  // total number of records
					"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
					"data"            => $data,   // total data array
					//"total_selected_students" => $total_selected_students
					);

		echo json_encode($json_data);  // send data as json format
	}
	
	public function deleteBenificary($id)
	{
		$this->db->where('id',$id);
		$this->db->delete('user_benificary');
		
		$this->Az->redirect('admin/member/benificaryList', 'system_message_error',lang('BENIFICARY_DELETED'));
	}


	public function fundTransferList(){

		//get logged user info
        $loggedUser = $this->User->getLoggedUser("cranesmart_admin");

        $today_date = date('Y-m-d');

        // get today total fund request
        $get_total_fund_amount = $this->db->query("SELECT sum(transfer_amount) as total_amount FROM tbl_user_fund_transfer")->row_array();
        $total_fund_amount = isset($get_total_fund_amount['total_amount']) ? $get_total_fund_amount['total_amount'] : 0 ;

        // get today total success request
        $get_total_success_amount = $this->db->query("SELECT sum(transfer_amount) as total_amount FROM tbl_user_fund_transfer WHERE status = 3")->row_array();
        $total_success_amount = isset($get_total_success_amount['total_amount']) ? $get_total_success_amount['total_amount'] : 0 ;

        // get today total pending request
        $get_total_pending_amount = $this->db->query("SELECT sum(transfer_amount) as total_amount FROM tbl_user_fund_transfer WHERE status = 2")->row_array();
        $total_pending_amount = isset($get_total_pending_amount['total_amount']) ? $get_total_pending_amount['total_amount'] : 0 ;

        // get today total failed request
        $get_total_failed_amount = $this->db->query("SELECT sum(transfer_amount) as total_amount FROM tbl_user_fund_transfer WHERE status = 4")->row_array();
        $total_failed_amount = isset($get_total_failed_amount['total_amount']) ? $get_total_failed_amount['total_amount'] : 0 ;
		
		
  		$siteUrl = base_url();		

		$data = array(
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'site_url' => $siteUrl,
			'loggedUser'  => $loggedUser,
			'total_fund_amount' => $total_fund_amount,
			'total_success_amount' => $total_success_amount,
			'total_pending_amount' => $total_pending_amount,
			'total_failed_amount' => $total_failed_amount,
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getsystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'content_block' => 'member/fundTransferList'
        );
        $this->parser->parse('admin/layout/column-1' , $data);
    
	
	}


	public function getFundTransferList()
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
			7 => 'a.created',
		);
		
		
		
			// getting total number records without any search
			$sql = "SELECT a.*,c.user_code,c.name,d.account_holder_name,d.account_no FROM tbl_user_fund_transfer as a INNER JOIN tbl_users as c ON c.id = a.user_id INNER JOIN tbl_user_benificary as d ON d.id = a.to_ben_id where a.id > 0 and a.status IN (2,3,4)";
			
			$totalData = $this->db->query($sql)->num_rows();
			$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
		
		
			$sql = "SELECT a.*,c.user_code,c.name,d.account_holder_name,d.account_no FROM tbl_user_fund_transfer as a INNER JOIN tbl_users as c ON c.id = a.user_id INNER JOIN tbl_user_benificary as d ON d.id = a.to_ben_id where a.id > 0 and a.status IN (2,3,4)";

			if($keyword != '') {   
				$sql.=" AND ( c.user_code LIKE '".$keyword."%' ";    
				$sql.=" OR b.package_name LIKE '".$keyword."%' ";
				$sql.=" OR c.name LIKE '".$keyword."%' ";
				$sql.=" OR c.email LIKE '".$keyword."%' ";
				$sql.=" OR c.mobile LIKE '".$keyword."%' )";
			}
			
			$order_type = $requestData['order'][0]['dir'];
			//if($requestData['draw'] == 1)
			//	$order_type = 'DESC';
			
			$order_no = isset($requestData['order'][0]['column']) ? ($requestData['order'][0]['column'] == 0) ? 7 : $requestData['order'][0]['column'] : 7;
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
				$nestedData[] = "<a href='javascript:void(0)' style='text-decoration:none;'>".$list['user_code']."</a>";
				$nestedData[] = $list['name'];
				$nestedData[] = $list['account_holder_name'].' ('.$list['account_no'].')';
				$nestedData[] = 'INR '.$list['transfer_amount'];
				$nestedData[] = $list['transaction_id'];
				if($list['status'] == 1)
				{
					$nestedData[] = '<font color="black">Processing</font>';
				}
				elseif($list['status'] == 2)
				{
					$nestedData[] = '<font color="orange">Pending</font>';
				}
				elseif($list['status'] == 3)
				{
					$nestedData[] = '<font color="green">Success</font>';
				}
				elseif($list['status'] == 4)
				{
					$nestedData[] = '<font color="red">Failed</font>';
				}
				$nestedData[] = date('d-m-Y',strtotime($list['created']));
				$data[] = $nestedData;
				
				
				
			$i++;}
		}



		$json_data = array(
					"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
					"recordsTotal"    => intval( $totalData ),  // total number of records
					"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
					"data"            => $data,   // total data array
					//"total_selected_students" => $total_selected_students
					);

		echo json_encode($json_data);  // send data as json format
	}

    
    public function requestList()
    {    

    	$loggedUser = $this->User->getLoggedUser('cranesmart_admin');
		$siteUrl = site_url();

		// get binary income percentage
		$get_direct_percentage = $this->db->get_where('master_setting',array('id'=>1))->row_array();
		$service_tax_percentage = isset($get_direct_percentage['service_tax']) ? $get_direct_percentage['service_tax'] : 0 ;
    	
		$data = array(
			'loggedUser' => $loggedUser,
            'site_url' => $siteUrl,
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'content_block' => 'member/requestList',
            'service_tax_percentage' => $service_tax_percentage,
            'manager_description' => lang('SITE_NAME'),
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getSystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning()
        );
        $this->parser->parse('admin/layout/column-1', $data);
		
    }
	
	public function getRequestList()
	{	
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		$accountID = $loggedUser['id'];
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
			6 => 'a.created',	
		);
		
		
		
			// getting total number records without any search
			$sql = "SELECT a.* FROM tbl_member_fund_request as a LEFT JOIN tbl_users as b ON b.id = a.member_id WHERE a.id > '0'";
			
			$totalData = $this->db->query($sql)->num_rows();
			$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
		
		
			$sql = "SELECT a.*,b.name as member_name, b.user_code as member_code FROM tbl_member_fund_request as a LEFT JOIN tbl_users as b ON b.id = a.member_id WHERE a.id > '0' ";	

			if($keyword != '') {   
				$sql.=" AND ( a.btc_address LIKE '".$keyword."%' ";    
				$sql.=" OR a.created LIKE '".$keyword."%' ";
				$sql.=" OR a.bank_name LIKE '".$keyword."%' ";
				$sql.=" OR a.ifsc LIKE '".$keyword."%' ";
				$sql.=" OR a.eth_address LIKE '".$keyword."%' )";
			}
			
			$order_type = $requestData['order'][0]['dir'];
			//if($requestData['draw'] == 1)
			//	$order_type = 'DESC';
			
			$order_no = isset($requestData['order'][0]['column']) ? ($requestData['order'][0]['column'] == 0) ? 6 : $requestData['order'][0]['column'] : 6;
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
				$nestedData[] = $list['member_name'].' ('.$list['member_code'].')';
				$nestedData[] = $list['request_id'];
				$nestedData[] = 'INR '.number_format($list['request_amount'],2);
				$nestedData[] = 'INR '.number_format($list['service_amount'],2);
				$nestedData[] = 'INR '.number_format($list['transfer_amount'],2);
				$nestedData[] = date('d-m-Y',strtotime($list['created']));
				
				if($list['status'] == 1)
				{
					$nestedData[] = '<font color="black">Pending</font>';
					$nestedData[] ='<a title="Approve" class="btn btn-success btn-sm" href="'.base_url('admin/member/updateRequestAuth').'/'.$list['id'].'/1" onclick="return confirm(\'Are you sure you want to approve this request?\')"><i class="fa fa-check" aria-hidden="true"></i></a> <a title="Reject" class="btn btn-danger btn-sm" href="'.base_url('admin/member/updateRequestAuth').'/'.$list['id'].'/2" onclick="return confirm(\'Are you sure you want to reject this request?\')"><i class="fa fa-times" aria-hidden="true"></i></a>';
				}
				elseif($list['status'] == 2)
				{
					$nestedData[] = '<font color="green">Approved</font>';
					$nestedData[] ='Updated';
				}
				elseif($list['status'] == 3)
				{
					$nestedData[] = '<font color="red">Rejected</font>';
					$nestedData[] ='Updated';
				}
				
				
				
				$data[] = $nestedData;
				
				
				
			$i++;}
		}



		$json_data = array(
					"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
					"recordsTotal"    => intval( $totalData ),  // total number of records
					"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
					"data"            => $data,   // total data array
					//"total_selected_students" => $total_selected_students
					);

		echo json_encode($json_data);  // send data as json format
	}
	
	public function updateRequestAuth($requestID = 0, $status = 0)
	{
		// check request id valid or not
		$chk_request_id = $this->db->get_where('member_fund_request',array('id'=>$requestID,'status'=>1))->num_rows();
		if(!$chk_request_id)
		{
			$this->Az->redirect('admin/member/requestList', 'system_message_error',lang('DB_ERROR'));
		}
		
		$this->Member_model->updateRequestAuth($requestID,$status);
		if($status == 1){
			$this->Az->redirect('admin/member/requestList', 'system_message_error',lang('REQUEST_APPROVE_SUCCESS'));
		}
		else
		{
			$this->Az->redirect('admin/member/requestList', 'system_message_error',lang('REQUEST_REJECT_SUCCESS'));
		}
	}

	
	
}