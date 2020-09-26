<?php 
class Users extends CI_Controller {    
    
    
    public function __construct() 
    {
        parent::__construct();
       	$this->User->checkPermission();
        $this->load->model('admin/User_model');		
        $this->lang->load('admin/user', 'english');
        
    }

	public function userList(){

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
            'content_block' => 'user/userList'
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
			4 => 'created',
			5 => 'is_active',
		);
		
		
		
			// getting total number records without any search
			$sql = "SELECT * FROM tbl_users as a  where  a.role_id > 3";
			
			$totalData = $this->db->query($sql)->num_rows();
			$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
		
		
			$sql = "SELECT a.*,b.title as role_name FROM tbl_users as a INNER JOIN tbl_user_roles as b ON b.id = a.role_id where a.role_id > 3";	

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
				$nestedData[]=$list['role_name'];
				$nestedData[] = $list['name'];
				
				$str = '<table class="table">';
				$str.='<tr><td><b>User name </b></td><td>'.$list['username'].'</td></tr>';
				$str.='<tr><td><b>Password </b></td><td>'.$list['decode_password'].'</td></tr>';
				$str.='<tr><td><b>Email </b></td><td>'.$list['email'].'</td></tr>';
				$str.='<tr><td><b>Mobile </b></td><td>'.$list['mobile'].'</td></tr>';
				$str.='</table>';
				$nestedData[] = $str;

				

				$nestedData[] = date('d-M-Y',strtotime($list['created']));
				if($list['is_active'] == 1) {
					$nestedData[] = '<font color="green">Active</font>';
				}
				elseif($list['is_active'] == 0) {
					$nestedData[] = '<font color="red">Deactive</font>';
				}
				
				$nestedData[] ='<a title="edit" class="btn btn-primary btn-sm" href="'.base_url('admin/users/editUser').'/'.$list['id'].'"><i class="fa fa-edit" aria-hidden="true"></i></a> <a title="delete" class="btn btn-danger btn-sm" href="'.base_url('admin/users/deleteUser').'/'.$list['id'].'" onclick="return confirm(\'Are you sure you want to delete?\')"><i class="fa fa-trash" aria-hidden="true"></i></a>';
				
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
	public function addUser()
    {
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		
		// get role list
		$roleList = $this->db->get_where('user_roles',array('id >'=>3))->result_array();

   		$siteUrl = site_url();
        $data = array(
            'site_url' => $siteUrl,
			'loggedUser' => $loggedUser,
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'content_block' => 'user/addUser',
			'roleList' => $roleList,
            'manager_description' => lang('SITE_NAME'),
          	'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getSystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning() 
		);

        $this->parser->parse('admin/layout/column-1', $data);
		
    }

    // save member
	public function saveUser()
	{
		//check for foem validation
		$post = $this->input->post();
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Name', 'required|xss_clean');
        $this->form_validation->set_rules('email', 'Email ', 'required|xss_clean|valid_email');
        $this->form_validation->set_rules('mobile', 'Mobile Number', 'required|xss_clean|numeric|max_length[12]');
        $this->form_validation->set_rules('password', 'Password', 'required|xss_clean');
        $this->form_validation->set_rules('role_id', 'Role', 'required|xss_clean');
        if($this->input->post('role_id')==6){
            $this->form_validation->set_rules('for_view', 'For View', 'required|xss_clean');
        }
		if ($this->form_validation->run() == FALSE) {
			
			$this->addUser();
		}
		else
		{	
			$chk_mobile_email =$this->db->query("SELECT * FROM tbl_users WHERE email = '$post[email]' or mobile = '$post[mobile]'")->num_rows();
            
			if($chk_mobile_email){

			$this->Az->redirect('admin/users/addUser', 'system_message_error',lang('EMAIL_MOBILE_ERROR'));	

			}

			$status = $this->User_model->saveUser($post);
			
			if($status == true)
			{
				$this->Az->redirect('admin/users/userList', 'system_message_error',lang('MEMBER_SAVED'));
			}
			else
			{
				$this->Az->redirect('admin/users/userList', 'system_message_error',lang('MEMBER_ERROR'));
			}
			
		}
	
	}

	// edit employe
	public function editUser($id)
    {    

    	$loggedUser = $this->User->getLoggedUser('cranesmart_admin');
		//get member list
		$memberList = $this->db->get_where('users',array('id'=>$id))->row_array();

		// get role list
		$roleList = $this->db->get_where('user_roles',array('id >'=>3))->result_array();
		
		$accountID=$loggedUser['id'];	
    	$siteUrl = site_url();
    	$id=$id;
	    $data = array(
			'loggedUser' => $loggedUser,
            'site_url' => $siteUrl,
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'content_block' => 'user/editUser',
            'manager_description' => lang('SITE_NAME'),
			'memberList' => $memberList,
			'accountID'=>$accountID,
			'roleList'=>$roleList,
			'id'=>$id,
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getSystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning()
        );
        $this->parser->parse('admin/layout/column-1', $data);
		
    }

    //update member
	public function updateUser()
	{
		//check for foem validation
		$post = $this->input->post();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Name', 'required|xss_clean');
        $this->form_validation->set_rules('email', 'Email ', 'required|xss_clean|valid_email');
        $this->form_validation->set_rules('mobile', 'Mobile Number', 'required|xss_clean|numeric|max_length[12]');
		$this->form_validation->set_rules('role_id', 'Role', 'required|xss_clean');
        if($this->input->post('role_id')==6){
            $this->form_validation->set_rules('for_view', 'For View', 'required|xss_clean');
        }
		else
		{	
			$chk_mobile_email =$this->db->query("SELECT * FROM tbl_users WHERE (email = '$post[email]' OR mobile = '$post[mobile]') and id != '$post[id]'")->num_rows();
            
			if($chk_mobile_email){

				$this->Az->redirect('admin/users/editUser/'.$post['id'], 'system_message_error',lang('EMAIL_MOBILE_ERROR'));	

			}


			$status = $this->User_model->updateUser($post);
			
			if($status == true)
			{
				$this->Az->redirect('admin/users/userList', 'system_message_error',lang('MEMBER_UPDATED'));
			}
			else
			{
				$this->Az->redirect('admin/users/userList', 'system_message_error',lang('MEMBER_ERROR'));
			}
			
		}
	
	}
	
	
	//delete member
	public function deleteUser($id)
	{
		$this->db->where('id',$id);
		$this->db->delete('users');
		
		$this->Az->redirect('admin/users/userList', 'system_message_error',lang('MEMBER_DELETED'));
	}


	
	
}