<?php 
class Recharge extends CI_Controller {    
    
    
    public function __construct() 
    {
        parent::__construct();
       	$this->User->checkPermission();
        $this->load->model('admin/Wallet_model');		
        $this->lang->load('admin/wallet', 'english');
        
    }

	public function index(){

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
            'content_block' => 'recharge/rechargeHistory'
        );
        $this->parser->parse('admin/layout/column-1' , $data);
    
	
	}


	public function getRechargeList()
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
			0 => 'a.id',	
			1 => 'a.recharge_display_id',
			2 => 'b.user_code',
			3 => 'b.name',
			8 => 'a.created',
			9 => 'a.recharge_type',
		);
		
		
		
			// getting total number records without any search
			$sql = "SELECT a.*, b.user_code as user_code, b.name as name FROM tbl_recharge_history as a INNER JOIN tbl_users as b ON b.id = a.member_id  where a.id > 0 ";
			
			$totalData = $this->db->query($sql)->num_rows();
			$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
		
		
			$sql = "SELECT a.*, b.user_code as user_code, b.name as name FROM tbl_recharge_history as a INNER JOIN tbl_users as b ON b.id = a.member_id  where a.id > 0 ";
			
			if($keyword != '') {   
				$sql.=" AND ( b.user_code LIKE '".$keyword."%' ";    
				$sql.=" OR a.mobile LIKE '".$keyword."%'";
				$sql.=" OR a.operator_code LIKE '".$keyword."%'";
				$sql.=" OR a.circle_code LIKE '".$keyword."%'";
				$sql.=" OR a.recharge_type LIKE '".$keyword."%'";
				$sql.=" OR a.recharge_display_id LIKE '".$keyword."%'";
				$sql.=" OR b.name LIKE '".$keyword."%' )";
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
				
				$recharge_type = $this->db->get_where('recharge_type',array('id'=>$list['recharge_type']))->row_array();

				$operator = $this->db->get_where('operator',array('operator_code'=>$list['operator_code']))->row_array();

				$circle = $this->db->get_where('circle',array('circle_code'=>$list['circle_code']))->row_array();					

				$nestedData=array(); 
				$nestedData[] = $i;
				$nestedData[] = "<a href='javascript:void(0)' style='text-decoration:none;'>".$list['recharge_display_id']."</a>";
				$nestedData[] = "<a href='javascript:void(0)' style='text-decoration:none;'>".$list['user_code']."</a>";
				$nestedData[] = $list['name'];
				$nestedData[] = $list['mobile'];
				$nestedData[] = $operator['operator_name'];
				$nestedData[] = $circle['circle_name'];
				$nestedData[] = $list['amount'].' /-';
				$nestedData[] = date('d-M-Y H:i:s',strtotime($list['created']));
				
				
				$nestedData[] = $recharge_type['type'];

				if($list['recharge_subtype'] == 1) {
					$nestedData[] = 'Prepaid';
				}
				elseif($list['recharge_subtype'] == 2) {
					$nestedData[] = 'Postpaid';
				}
				else
				{
					$nestedData[] = '';
				}
			
				
				if($list['status'] == 1) {
					$nestedData[] = '<font color="orange">Pending</font>';
				}
				elseif($list['status'] == 2) {
					$nestedData[] = '<font color="green">Success</font>';
				}
				elseif($list['status'] == 3) {
					$nestedData[] = '<font color="red">Failed</font>';
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


	
	// add member
	public function addWallet()
    {
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		$memberList = $this->db->get_where('users',array('role_id'=>2,'is_active'=>1))->result_array();
   		$siteUrl = site_url();
        $data = array(
            'site_url' => $siteUrl,
			'loggedUser' => $loggedUser,
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'content_block' => 'wallet/addWallet',
            'memberList'	=> $memberList,
            'manager_description' => lang('SITE_NAME'),
          	'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getSystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning() 
		);

        $this->parser->parse('admin/layout/column-1', $data);
		
    }

    // save member
	public function saveWallet()
	{
		//check for foem validation
		$post = $this->input->post();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('member', 'Member', 'required|xss_clean');
        $this->form_validation->set_rules('amount', 'Amount ', 'required|xss_clean|numeric');
        $this->form_validation->set_rules('description', 'Description', 'required|xss_clean');
        
		if ($this->form_validation->run() == FALSE) {
			
			$this->addWallet();
		}
		else
		{	
			
			$status = $this->Wallet_model->saveWallet($post);
			
			if($status == true)
			{
				$this->Az->redirect('admin/wallet/walletList', 'system_message_error',lang('WALLET_SAVED'));
			}
			else
			{
				$this->Az->redirect('admin/wallet/walletList', 'system_message_error',lang('WALLET_ERROR'));
			}
			
		}
	
	}

	
	
	//delete member
	public function deleteWallet($id)
	{
		$this->db->where('id',$id);
		$this->db->delete('member_wallet');		

		$this->Az->redirect('admin/wallet/walletList', 'system_message_error',lang('WALLET_DELETED'));
	}


	
	
}