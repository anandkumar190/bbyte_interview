<?php
if(!defined('BASEPATH'))
    exit('No direct scrip access allowed');

/*
 * login Register controller for Frontend
 * 
 * this controller user for login, register, logout, forgot password, reset password
 * @author trilok
 */

class Water extends CI_Controller{

    public function __construct() {
        parent::__construct();
        $this->lang->load('admin/dashboard', 'english');
        $this->lang->load('front_common', 'english');
		$this->lang->load('front/recharge', 'english');
    }
	
	
	public function index(){
		
		$operator = $this->db->get_where('operator',array('type'=>'Water'))->result_array();
		
		$siteUrl = base_url();
		$data = array(
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'site_url' => $siteUrl,
			'operator' => $operator,
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getsystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'content_block' => 'water'
        );
        $this->parser->parse('front/layout/column-1' , $data);
    }
	
	public function fetchBiller($operator_code = '')
	{
		
		$response = $this->User->getElectricityOperatorDetail($operator_code);
		
		echo json_encode($response);
	}
	
	public function fetchBillerDetail($operator_code = '')
	{
		$post = $this->input->post();
		$account_number = isset($post['account_number']) ? $post['account_number'] : '';
		$response = $this->User->getElectricityOperatorBillerDetail($operator_code,$account_number);
		
		echo json_encode($response);
	}
	
	function maximumCheck($num)
	{
		if ($num < 1)
		{
			$this->form_validation->set_message(
							'maximumCheck',
							'The %s field must be grater than 10'
						);
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	
	public function proceedRecharge()
    {   
        $loggedUser = $this->session->userdata('cranesmart_member_session');
        //check for foem validation
        $post = $this->input->post();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('operator', 'Operator', 'required');
        $this->form_validation->set_rules('fetch_status', 'fetch_status', 'xss_clean');
        $this->form_validation->set_rules('fieldName', 'fieldName', 'xss_clean');
		if($post['fetch_status'])
		{
			$this->form_validation->set_rules('account_number', $post['fieldName'], 'required');
		}
        
        if ($this->form_validation->run() == FALSE) {
            
            $this->index();
        }
        else
        {
			if($post['fetch_status'] == 0)
			{
				$this->Az->redirect('water', 'system_message_error',lang('OPERATOR_VALID_ERROR'));   
			}
			
            $chk_wallet_balance =$this->db->get_where('users',array('id'=>$loggedUser['id']))->row_array();

            if($chk_wallet_balance['wallet_balance'] < $post['amount']){

				$this->Az->redirect('water', 'system_message_error',lang('WALLET_ERROR'));   

            }  
			
            // generate recharge unique id
            $recharge_unique_id = rand(1111,9999).time();

			$data = array(
				'member_id'          => $loggedUser['id'],
				'recharge_type'      => 7,
				'recharge_display_id'=> $recharge_unique_id,
				'mobile'             => $loggedUser['mobile'],
				'account_number'     => isset($post['account_number']) ? $post['account_number'] : '',
				'operator_code'      => $post['operator'],
				'amount'             => $post['amount'],
				'status'         	 => 1,
				'field_name'             => $post['fieldName'],
				'reference_id'             => $post['reference_id'],
				'customer_name'             => $post['customer_name'],
				'created'            => date('Y-m-d H:i:s')                  
			);

			$this->db->insert('recharge_history',$data);
			$recharge_id = $this->db->insert_id();

            
			$account_number = $post['account_number'];
			$operator_code = $post['operator'];
			$amount = $post['amount'];
			$reference_id = $post['reference_id'];
			// call recharge API
			$api_response = $this->User->electricity_rechage_api($account_number,$operator_code,$amount,$reference_id,$recharge_unique_id,$loggedUser['id'],$loggedUser['mobile']);
			

            if(isset($api_response['status']) && ($api_response['status'] == 1 || $api_response['status'] == 2))
			{
				$before_balance = $this->db->get_where('users',array('id'=>$loggedUser['id']))->row_array();

				$after_balance = $before_balance['wallet_balance'] - $post['amount'];    

				$wallet_data = array(
					'member_id'           => $loggedUser['id'],    
					'before_balance'      => $before_balance['wallet_balance'],
					'amount'              => $post['amount'],  
					'after_balance'       => $after_balance,      
					'status'              => 1,
					'type'                => 2,      
					'created'             => date('Y-m-d H:i:s'),      
					'description'         => 'Bill Pay #'.$recharge_unique_id.' Amount Deducted.'
				);

				$this->db->insert('member_wallet',$wallet_data);

				$user_wallet = array(
					'wallet_balance'=>$after_balance,        
				);    
				$this->db->where('id',$loggedUser['id']);
				$this->db->update('users',$user_wallet);
				if($api_response['status'] == 1){
					// update recharge status
					$this->db->where('id',$recharge_id);
					$this->db->where('recharge_display_id',$recharge_unique_id);
					$this->db->update('recharge_history',array('txid'=>$api_response['txid'],'operator_ref'=>$api_response['operator_ref'],'api_response_id'=>$api_response['api_response_id']));
					$this->Az->redirect('water', 'system_message_error',lang('RECHARGE_PENDING'));
				}
				else
				{
					// update recharge status
					$this->db->where('id',$recharge_id);
					$this->db->where('recharge_display_id',$recharge_unique_id);
					$this->db->update('recharge_history',array('status'=>2,'txid'=>$api_response['txid'],'operator_ref'=>$api_response['operator_ref'],'api_response_id'=>$api_response['api_response_id']));
					$this->Az->redirect('water', 'system_message_error',lang('RECHARGE_SUCCESS'));
				}
			}
			else
			{
				// update recharge status
				$this->db->where('id',$recharge_id);
				$this->db->where('recharge_display_id',$recharge_unique_id);
				$this->db->update('recharge_history',array('status'=>3));
				$this->Az->redirect('water', 'system_message_error',lang('RECHARGE_FAILED'));
			}
			
			

            
            
        }
    
    }
	
	
}
/* End of file login.php */
/* Location: ./application/controllers/login.php */