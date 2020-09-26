<?php 
class Kyc extends CI_Controller {    
    
    
    public function __construct() 
    {
        parent::__construct();
        if(empty($_SESSION['cranesmart_staff']) || empty($_SESSION['cranesmart_staff']['id']) || $_SESSION['cranesmart_staff']['role_id'] != 6 || $_SESSION['cranesmart_staff']['for_view'] != 1){
            redirect(base_url('admin/login'));
            exit();
        }
		$this->load->model('admin/Kyc_model');
        $this->lang->load('admin/kyc', 'english');

    }

	public function kycList()
    {

		$siteUrl = site_url();
		$data = array(
            'site_url' => $siteUrl,
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'content_block' => 'kyc/list',
            'manager_description' => lang('SITE_NAME'),
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getSystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning()
        );
        $this->parser->parse('staff/layout/column-1', $data);

    }
	
	public function getKycList()
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
			6 => 'a.created',	
		);
		
		
		
			// getting total number records without any search
			$sql = "SELECT a.* FROM tbl_member_kyc_detail as a LEFT JOIN tbl_users as b ON b.id = a.member_id WHERE a.id > '0'";
			
			$totalData = $this->db->query($sql)->num_rows();
			$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
		
		
			$sql = "SELECT a.*,b.name as member_name, b.user_code as member_code FROM tbl_member_kyc_detail as a LEFT JOIN tbl_users as b ON b.id = a.member_id WHERE a.id > '0' ";	

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
			
			$order_no = isset($requestData['order'][0]['column']) ? ($requestData['order'][0]['column'] == 0) ? 0 : $requestData['order'][0]['column'] : 1;
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
				$str = '<table class="table table-bordered table-striped">';
				$str.='<tr><td><b>Account Holder Name -</b></td><td>'.$list['account_holder_name'].'</td></tr>';
				$str.='<tr><td><b>Account No. -</b></td><td>'.$list['account_number'].'</td></tr>';
				$str.='<tr><td><b>IFSC -</b></td><td>'.$list['ifsc'].'</td></tr>';
				$str.='<tr><td><b>Bank Name -</b></td><td>'.$list['bank_name'].'</td></tr>';
				$str.='</table>';
				$nestedData[] = $str;
				
				$front_document = '<a href="'.base_url($list['front_document']).'" target="_blank">View Front Document</a><br /><br /><a href="'.base_url($list['back_document']).'" target="_blank">View Back Document</a><br /><br /><a href="'.base_url($list['pancard_document']).'" target="_blank">View PAN CARD</a>';
				
				
				$nestedData[] = $front_document;
				$nestedData[] = date('d-m-Y',strtotime($list['created']));
				
				if($list['status'] == 2)
				{
					$nestedData[] = '<font color="black">Pending</font>';
					$nestedData[] ='<a title="Approve" class="btn btn-success btn-sm" href="'.base_url('staff/kyc/updateKYCAuth').'/'.$list['id'].'/1" onclick="return confirm(\'Are you sure you want to approve this request?\')"><i class="fa fa-check" aria-hidden="true"></i></a> <a title="Reject" class="btn btn-danger btn-sm" href="'.base_url('staff/kyc/updateKYCAuth').'/'.$list['id'].'/2" onclick="return confirm(\'Are you sure you want to reject this request?\')"><i class="fa fa-times" aria-hidden="true"></i></a>';
				}
				elseif($list['status'] == 3)
				{
					$nestedData[] = '<font color="green">Approved</font>';
					$nestedData[] ='Updated';
				}
				elseif($list['status'] == 4)
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
	
	public function updateKYCAuth($requestID = 0, $status = 0)
	{
		// check request id valid or not
		$chk_request_id = $this->db->get_where('member_kyc_detail',array('id'=>$requestID,'status'=>2))->num_rows();
		if(!$chk_request_id)
		{
			$this->Az->redirect('staff/kyc/kycList', 'system_message_error',lang('DB_ERROR'));
		}
		
		$this->Kyc_model->updateRequestAuth($requestID,$status);
		if($status == 1){
			$this->Az->redirect('staff/kyc/kycList', 'system_message_error',lang('REQUEST_APPROVE_SUCCESS'));
		}
		else
		{
			$this->Az->redirect('staff/kyc/kycList', 'system_message_error',lang('REQUEST_REJECT_SUCCESS'));
		}
	}
}