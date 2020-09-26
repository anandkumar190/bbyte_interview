<?php 
class Seller extends CI_Controller {    
    
    
    public function __construct() 
    {
        parent::__construct();
       	$this->User->checkPermission();
        $this->load->model('admin/Seller_model');		
        $this->lang->load('admin/member', 'english');
        
    }

	public function sellerList(){

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
            'content_block' => 'seller/sellerList'
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
			$sql = "SELECT * FROM tbl_users as a  where  a.role_id = 3";
			
			$totalData = $this->db->query($sql)->num_rows();
			$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
		
		
			$sql = "SELECT a.*,b.name as country_name,c.name as state_name FROM tbl_users as a INNER JOIN tbl_countries as b ON b.id = a.country_id INNER JOIN tbl_states as c ON c.id = a.state_id where a.role_id = 3";	

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
				
				
				// get seller kyc detail
				$accountInfo = $this->db->get_where('member_kyc_detail',array('member_id'=>$list['id']))->row_array();
				
				$nestedData=array(); 
				$nestedData[] = '<input type="checkbox" class="product_chkbox" name="product_id[]" value="'.$list['id'].'" />';
				$nestedData[] = "<a href='javascript:void(0)' style='text-decoration:none;'>".$list['user_code']."</a>";
				$nestedData[] = $list['name'];
				
				$str = '<table class="table personal-info">';
				$str.='<tr><td><b>User name </b></td><td>'.$list['username'].'</td></tr>';
				$str.='<tr><td><b>Password </b></td><td>'.$list['decode_password'].'</td></tr>';
				$str.='<tr><td><b>Email </b></td><td>'.$list['email'].'</td></tr>';
				$str.='<tr><td><b>Mobile </b></td><td>'.$list['mobile'].'</td></tr>';
				$str.='<tr><td><b>Firm </b></td><td>'.$list['firm_name'].'</td></tr>';
				$str.='<tr><td><b>Address </b></td><td>'.$list['address'].'</td></tr>';
				$str.='<tr><td><b>Zip Code </b></td><td>'.$list['zip_code'].'</td></tr>';
				$str.='<tr><td><b>GST No. </b></td><td>'.$list['gst_no'].'</td></tr>';
				$str.='<tr><td><b>State </b></td><td>'.$list['state_name'].'</td></tr>';
				$str.='<tr><td><b>Country </b></td><td>'.$list['country_name'].'</td></tr>';
				$str.='</table>';
				$nestedData[] = $str;
				
				$str2 = '<table class="table">';
				$str2.='<tr><td><b>Account Holder Name </b></td><td>'.$accountInfo['account_holder_name'].'</td></tr>';
				$str2.='<tr><td><b>Account No. </b></td><td>'.$accountInfo['account_number'].'</td></tr>';
				$str2.='<tr><td><b>IFSC </b></td><td>'.$accountInfo['ifsc'].'</td></tr>';
				$str2.='<tr><td><b>Bank Name </b></td><td>'.$accountInfo['bank_name'].'</td></tr>';
				$str2.='</table>';
				$nestedData[] = $str2;
				
				$str2 = '<table class="table">';
				$str2.='<tr><td><b>Address Proof </b></td><td><a href="'.base_url($accountInfo['front_document']).'" target="_blank">View Document</a></td></tr>';
				$str2.='<tr><td><b>PAN Card </b></td><td><a href="'.base_url($accountInfo['pancard_document']).'" target="_blank">View Document</a></td></tr>';
				$str2.='</table>';
				$nestedData[] = $str2;

				
				$nestedData[] = date('d-M-Y',strtotime($list['created']));
				if($list['is_active'] == 1) {
					$nestedData[] = '<font color="green">Active</font>';
				}
				elseif($list['is_active'] == 0) {
					$nestedData[] = '<font color="red">Deactive</font>';
				}
				
				if($list['is_verified'] == 1) {
					$nestedData[] = '<font color="green">Yes</font>';
				}
				elseif($list['is_verified'] == 0) {
					$nestedData[] = '<font color="red">No</font>';
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
				$this->db->update('users',array('is_active'=>1));
				$response = array(
					'status' => 1,
					'msg' => 'Seller Activated Successfully.'
				);
			}
			elseif($action_type == 2)
			{
				$this->db->where_in('id',$post['product_id']);
				$this->db->update('users',array('is_active'=>0));
				$response = array(
					'status' => 1,
					'msg' => 'Seller Deactivated successfully.'
				);
			}
			elseif($action_type == 3)
			{
				$this->db->where_in('id',$post['product_id']);
				$this->db->update('users',array('is_verified'=>1));
				$response = array(
					'status' => 1,
					'msg' => 'Seller Verified Successfully.'
				);
			}
			elseif($action_type == 4)
			{
				$this->db->where_in('id',$post['product_id']);
				$this->db->update('users',array('is_verified'=>0));
				$response = array(
					'status' => 1,
					'msg' => 'Seller Rejected Successfully.'
				);
			}
			elseif($action_type == 5)
			{
				foreach($post['product_id'] as $product_id){
					// delete product all variation theme data
					$this->db->where('member_id',$product_id);
					$this->db->delete('member_kyc_detail');
					
					$this->db->where('id',$product_id);
					$this->db->delete('users');
				}
				$response = array(
					'status' => 1,
					'msg' => 'Seller Deleted Successfully.'
				);
			}
			
		}
		
		echo json_encode($response);
	}


	
	
}