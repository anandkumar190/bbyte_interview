<?php
if(!defined('BASEPATH'))
    exit('No direct scrip access allowed');

/*
 * login Register controller for Frontend
 * 
 * this controller user for login, register, logout, forgot password, reset password
 * @author trilok
 */

class Mobile extends CI_Controller{

    public function __construct() {
        parent::__construct();
        $this->lang->load('admin/dashboard', 'english');
        $this->lang->load('front/recharge', 'english');
        $this->lang->load('front_common', 'english');
    }
	
	
	
	public function index(){
	    
		
        $operator = $this->db->get_where('operator',array('type'=>'Prepaid'))->result_array();

        //get circle list

        $circle = $this->db->get('circle')->result_array();   

		$siteUrl = base_url();
		$data = array(
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'site_url' => $siteUrl,
            'operator' => $operator,
            'circle'   => $circle,  
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getsystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'content_block' => 'mobile'
        );
        $this->parser->parse('front/layout/column-1' , $data);
    }
	
	public function getPostpaidOperatorList()
	{
		$operator = $this->db->get_where('operator',array('type'=>'Postpaid'))->result_array();
		$str = '<option value="">Select Your Operator*</option>';
		if($operator)
		{
			foreach($operator as $list)
			{
				$str.='<option value="'.$list['operator_code'].'">'.$list['operator_name'].'</option>';
			}
		}
		echo $str;
	}
	
	public function getPrepaidOperatorList()
	{
		$operator = $this->db->get_where('operator',array('type'=>'Prepaid'))->result_array();
		$str = '<option value="">Select Your Operator*</option>';
		if($operator)
		{
			foreach($operator as $list)
			{
				$str.='<option value="'.$list['operator_code'].'">'.$list['operator_name'].'</option>';
			}
		}
		echo $str;
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
        $this->form_validation->set_rules('mobile', 'Mobile Number', 'required|numeric|max_length[12]|xss_clean');
        if($post['recharge_type']==2){

          $this->form_validation->set_rules('acnumber', 'Account Number', 'required|numeric|max_length[12]|xss_clean');

        }
        $this->form_validation->set_rules('mobile', 'Mobile Number', 'required|numeric|max_length[12]|xss_clean');
        
        $this->form_validation->set_rules('operator', 'Operator', 'required');
        $this->form_validation->set_rules('circle', 'Circle', 'required');
        $this->form_validation->set_rules('amount', 'Amount', 'required|numeric|callback_maximumCheck');
        
        if ($this->form_validation->run() == FALSE) {
            
            $this->index();
        }
        else
        {   
            $chk_wallet_balance =$this->db->get_where('users',array('id'=>$loggedUser['id']))->row_array();

            if($chk_wallet_balance['wallet_balance'] < $post['amount']){

				$this->Az->redirect('mobile', 'system_message_error',lang('WALLET_ERROR'));   

            }  
            
            
           // $this->Az->redirect('mobile', 'system_message_error',lang('RECHARGE_DOWN_ERROR'));   
			
			
            // generate recharge unique id
            $recharge_unique_id = rand(1111,9999).time();

			$data = array(
				'member_id'          => $loggedUser['id'],
				'recharge_type'      => 1,
				'recharge_subtype'   => $post['recharge_type'],
				'recharge_display_id'=> $recharge_unique_id,
				'mobile'             => $post['mobile'],
				'account_number'     => isset($post['acnumber']) ? $post['acnumber'] : '',
				'operator_code'      => $post['operator'],
				'circle_code'        => $post['circle'],
				'amount'             => $post['amount'],
				'status'         	 => 1,
				'created'            => date('Y-m-d H:i:s')                  
			);

			$this->db->insert('recharge_history',$data);
			$recharge_id = $this->db->insert_id();

            if($post['recharge_type'] == 1){
				$mobile = $post['mobile'];
				$operator_code = $post['operator'];
				$circle_code = $post['circle'];
				$amount = $post['amount'];
				// call recharge API
				$api_response = $this->User->prepaid_rechage_api($mobile,$operator_code,$circle_code,$amount,$recharge_unique_id,$loggedUser['id']);
			}
			elseif($post['recharge_type'] == 2){
				$mobile = $post['mobile'];
				$operator_code = $post['operator'];
				$circle_code = $post['circle'];
				$amount = $post['amount'];
				$account = $post['acnumber'];
				// call recharge API
				$api_response = $this->User->postpaid_rechage_api($mobile,$operator_code,$circle_code,$amount,$account,$recharge_unique_id,$loggedUser['id']);
			}

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
					'description'         => 'Recharge #'.$recharge_unique_id.' Amount Deducted.'
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
					$this->Az->redirect('mobile', 'system_message_error',lang('RECHARGE_PENDING'));
				}
				else
				{
					// update recharge status
					$this->db->where('id',$recharge_id);
					$this->db->where('recharge_display_id',$recharge_unique_id);
					$this->db->update('recharge_history',array('status'=>2,'txid'=>$api_response['txid'],'operator_ref'=>$api_response['operator_ref'],'api_response_id'=>$api_response['api_response_id']));
					
					// add 100% CM Points
					$this->User->recharge_cm_points_add($loggedUser['id'],$post['amount'],'Mobile',$recharge_unique_id);
					
					$this->Az->redirect('mobile', 'system_message_error',lang('RECHARGE_SUCCESS'));
				}
			}
			else
			{
				// update recharge status
				$this->db->where('id',$recharge_id);
				$this->db->where('recharge_display_id',$recharge_unique_id);
				$this->db->update('recharge_history',array('status'=>3));
				$this->Az->redirect('mobile', 'system_message_error',lang('RECHARGE_FAILED'));
			}
			
			

            
            
        }
    
    }






    



}
/* End of file login.php */
/* Location: ./application/controllers/login.php */