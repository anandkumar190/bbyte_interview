<?php
class Order extends CI_Controller {    
    
    
    public function __construct() 
    {
        parent::__construct();
       	//$this->User->checkPermission();
        $this->load->model('admin/Catalog_model');		
        $this->load->model('admin/Section_model');		
        $this->lang->load('admin/dashboard', 'english');
        
    } 
    
	
	public function index()
    {
		$loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		
		// get vendor list
		$customerList = $this->db->select('id,name')->get_where('users',array('role_id'=>2))->result_array();
		
		$siteUrl = site_url();
		$data = array(
            'site_url' => $siteUrl,
            'meta_title' => 'Order List',
            'meta_keywords' => 'Order List',
            'meta_description' => 'Order List',
			'loggedUser' => $loggedUser,	
			'content_block' => 'order/orderList',
            'manager_description' => 'Order List',
			'customerList' => $customerList,
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getSystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning()
        );
        $this->parser->parse('admin/layout/column-1', $data);
		
    }
	
	public function getOrderList()
	{
		
		$requestData= $this->input->get();
		$extra_search = $requestData['extra_search'];
		$order_status = 0;
		$keyword = '';
		$customer_id = 0;
		
		if($extra_search)
		{
			$filterData = explode('-',$extra_search);
			$order_status = isset($filterData[0]) ? $filterData[0] : 0;
			$keyword = isset($filterData[1]) ? $filterData[1] : '';
			$customer_id = isset($filterData[2]) ? $filterData[2] : 0;
			
		}
		
		
		$columns = array( 
		// datatable column index  => database column name
			0 => 'a.id',
			1 => 'a.order_display_id',
			2 => 'e.name',
			3 => 'd.address_1',
			5 => 'a.status',
			6 => 'a.created',
			
		);
		
		
			// getting total number records without any search
			$sql = "SELECT a.*, e.name as customer_name, d.address_1 as address_1, d.address_2 as address_2, f.id as order_status ";
			
			$sql.=" FROM tbl_orders as a ";
			$sql.=" LEFT JOIN tbl_user_address as d ON a.address_id = d.id ";
			$sql.=" LEFT JOIN tbl_users as e ON a.customer_id = e.id ";  
			$sql.=" LEFT JOIN tbl_order_status as f ON a.status = f.id ";
			$sql.=" ORDER BY a.created DESC ";
			
		
			$totalData = $this->db->query($sql)->num_rows();
			
			$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
		
			$sql = "SELECT a.*, e.name as customer_name , d.address_1 as address_1, d.address_2 as address_2, f.id as order_status ";

			$sql.=" FROM tbl_orders as a ";
			$sql.=" LEFT JOIN tbl_user_address as d ON a.address_id = d.id ";
			$sql.=" LEFT JOIN tbl_users as e ON a.customer_id = e.id ";
			$sql.=" LEFT JOIN tbl_order_status as f ON a.status = f.id ";
			
			$sql.=" WHERE a.id > 0 ";
			
			if($order_status)
			{
				$sql.=" AND a.status = '$order_status' ";
			}
			
			if($customer_id)
			{
				$sql.=" AND a.customer_id = '$customer_id' ";
			}
			
			if($keyword != '') {

				$sql.=" AND ( a.order_display_id LIKE '".$keyword."%' ";    
				$sql.=" OR d.address_1 LIKE '".$keyword."%' ";
				$sql.=" OR d.address_2 LIKE '".$keyword."%' ";
				$sql.=" OR a.created LIKE '".$keyword."%' )";
				
			}
			
			$order_type = $requestData['order'][0]['dir'];
			//if($requestData['draw'] == 1)
			//	$order_type = 'DESC';
			
			$order_no = isset($requestData['order'][0]['column']) ? ($requestData['order'][0]['column'] == 0) ? 1 : $requestData['order'][0]['column'] : 1;
			$totalFiltered = $this->db->query($sql)->num_rows();
			$sql.=" ORDER BY ". $columns[$order_no]."   ".$order_type."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
		
		
		
		$get_filter_data = $this->db->query($sql)->result_array();
		
		$data = array();
		//$totalrecord = 0;
		if($get_filter_data){
			$i=1;
			foreach($get_filter_data as $list){
				
				$nestedData=array(); 
				
				$item_summary = $this->db->get_where('order_item_summary',array('order_id'=>$list['id']))->result_array();
				
				$nestedData[] = $i;
				$nestedData[] = $list['order_display_id'];
				$nestedData[] = $list['customer_name'];
				$nestedData[] = $list['address_1'].'</br>'.$list['address_2'];
				
				$str = '<table class="table">';
				$str.='<tr>';
				$str.='<td><b>Product</b></td>';
				$str.='<td><b>Price</b></td>';
				$str.='<td><b>Qty</b></td>';
				$str.='<td><b>Total Price</b></td>';
				
				if($item_summary){

				foreach($item_summary as $itemList){	
				
				$product = $this->db->get_where('products',array('id'=>$itemList['product_id']))->row_array();

				$str.='</tr>';
				$str.='<tr>';
				$str.='<td>'.$product['product_name'].'</td>';
				$str.='<td>'.$itemList['product_price'].'/-'.'</td>';
				$str.='<td>'.$itemList['product_qty'].'</td>';
				$str.='<td>'.$itemList['gross_amount'].'/-'.'</td>';
				
				}
				}

				$str.='<tr>';
				$str.='<td colspan=3><b>Total</b></td>';
				$str.='<td><b>'.$list['total_price'].'/-'.'</b></td>';

				$str.='</tr></table>';
				

				$nestedData[] = $str;

				if($list['order_status'] == 1) {
					$nestedData[] = '<font color="orange">Open</font>';
				}
				
				if($list['order_status'] == 2) {
					$nestedData[] = '<font color="blue">Proessing</font>';
				}

				if($list['order_status'] == 3) {
					$nestedData[] = '<font color="pink">Dispatched</font>';
				}

				if($list['order_status'] == 4) {
					$nestedData[] = '<font color="red">Cancelled</font>';
				}

				if($list['order_status'] == 5) {
					$nestedData[] = '<font color="green">Delivered</font>';
				}

				

				$nestedData[] = date('d-m-Y',strtotime($list['created']));
				
				$nestedData[] = '<a title="delete" class="btn btn-danger btn-sm" href="'.base_url('admin/order/deleteOrder').'/'.$list['id'].'" onclick="return confirm(\'Are you sure you want to delete?\')"><i class="fa fa-trash"></i></a>';
				
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




	public function invoice($account_id = 0,$encoded_order_id = ''){
		

		//$account_id = $this->User->get_logged_user_account_id();


		// check order id valid or not

		$chk_address = $this->db->get_where('orders',array('encoded_order_id'=>$encoded_order_id))->num_rows();
		if(!$chk_address)
		{
			$this->Az->redirect('customer/orders', 'system_message_error',lang('DB_ERROR'));
		}
		
		$orderData = $this->User->get_customer_current_order_data($account_id,$encoded_order_id);
		
		// GET COMPANY DATA
		$companyData = $this->db->select('address,company_name,pan_number,gst_number')->get_where('site_settings',array('id'=>1))->row_array();
		
		$order_id = isset($orderData[0]['id']) ? $orderData[0]['id'] : 0 ;
		// get order invoice data
		$invoiceData = $this->db->select('*')->get_where('order_invoice',array('order_id'=>$order_id,'customer_id'=>$account_id))->row_array();
		
		
		
		
		$siteUrl = base_url();
		$data = array(
            'meta_title' => "Cranesmart",
            'meta_keywords' => "Cranesmart",
            'meta_description' => "Cranesmart",
            'site_url' => $siteUrl,
            'orderData' => $orderData,
            'companyData' => $companyData,
            'invoiceData' => $invoiceData,
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getsystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'content_block' => 'order/order-invoice'
        );
        $this->parser->parse('admin/layout/column-3' , $data);
    }





 
  public function deleteOrder($orderID = 0){


   	$this->db->where('id',$orderID);
	$this->db->delete('orders');

	$this->db->where('order_id',$orderID);
	$this->db->delete('order_item_summary');

	$this->Az->redirect('admin/order/orderList', 'system_message_info', lang('ORDER_DELETE_SUCCESS'));

  } 
	
		
}
?>