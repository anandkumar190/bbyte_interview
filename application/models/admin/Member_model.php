<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * Model used for setup default message and resize image
 * 
 * This one used for defined some methods accross all site.
 * this one used for show system message, errors.
 * this one used for image resizing
 * @author trilok
 */

require_once BASEPATH . '/core/Model.php';

class Member_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function saveMember($post)
    {       
            $loggedUser = $this->User->getLoggedUser("cranesmart_admin");
    	    
			$user_display_id = $this->User->generate_unique_member_id();
            
            $data = array(    
                'role_id'            =>  2,      
                'user_code'          =>  $user_display_id,      
                'name'               =>  $post['name'],
                'username'           =>  $user_display_id,
                'password'           =>  do_hash($post['password']),
                'decode_password'    =>  $post['password'],
                'email'              =>  trim(strtolower($post['email'])),
                'mobile'             =>  $post['mobile'],
                'created_by'         =>  $loggedUser['id'],   
                'is_active'          =>  $post['is_active'],
                'wallet_balance'     =>  0,   
                'is_verified'        =>  1,   
                'created'            =>  date('Y-m-d H:i:s')
            );

            $this->db->insert('users',$data);
            $member_id = $this->db->insert_id();
			
			$parent_id = 1;
			$reffrel_id = 1;
			
			// save member tree
			$tree_data = array(
				'member_id' => $member_id,
				'parent_id' => $parent_id,
				'reffrel_id'=> $reffrel_id,
				'position'  => 'L',
				'created'   => date('Y-m-d H:i:s')     
			);
			$this->db->insert('member_tree',$tree_data);

    	return true;
    }

    public function updateMember($post)
    {

        $data = array(    
            'name'               =>  $post['name'],
            'email'              =>  trim(strtolower($post['email'])),
            'mobile'             =>  $post['mobile'],
            'is_active'          =>  $post['is_active'],
            'updated'            =>  date('Y-m-d H:i:s')
        );

        if($post['password'])
        {
            $data['password'] = do_hash($post['password']);
            $data['decode_password'] = $post['password'];
        }

        $this->db->where('id',$post['id']);
        $this->db->update('users',$data);
        return true;
    
    }
    
    public function saveManualMember($post)
    {       
        $loggedUser = $this->User->getLoggedUser("cranesmart_admin");
        
        $user_display_id = $this->User->generate_unique_member_id();
        
        $data = array(    
            'role_id'            =>  2,      
            'user_code'          =>  $user_display_id,      
            'name'               =>  '',
            'username'           =>  $user_display_id,
            'password'           =>  do_hash($post['password']),
            'decode_password'    =>  $post['password'],
            'email'              =>  '',
            'mobile'             =>  '',
            'created_by'         =>  $loggedUser['id'],   
            'is_active'          =>  1,
            'wallet_balance'     =>  0,   
            'is_verified'        =>  1,   
            'created'            =>  date('Y-m-d H:i:s')
        );

        $this->db->insert('users',$data);
        $member_id = $this->db->insert_id();
        
        $parent_id = $post['member_id'];
        $reffrel_id = $post['member_id'];
        
        // save member tree
        $tree_data = array(
            'member_id' => $member_id,
            'parent_id' => $parent_id,
            'reffrel_id'=> $reffrel_id,
            'position'  => 'L',
            'created'   => date('Y-m-d H:i:s')     
        );
        $this->db->insert('member_tree',$tree_data);

        return $user_display_id;
    }
    
    
    public function updateRequestAuth($requestID,$status)
    {
        $get_request_data = $this->db->get_where('member_fund_request',array('id'=>$requestID,'status'=>1))->row_array();
        $memberID = $get_request_data['member_id'];
        $amount = $get_request_data['request_amount'];
        $request_id = $get_request_data['request_id'];
        if($status == 1){
            // update request status
            $this->db->where('id',$requestID);
            $this->db->update('member_fund_request',array('status'=>2,'updated'=>date('Y-m-d H:i:s')));
            
        }
        else
        {
            // update request status
            $this->db->where('id',$requestID);
            $this->db->update('member_fund_request',array('status'=>3,'updated'=>date('Y-m-d H:i:s')));
            

            //get member wallet_balance
            $get_member_status = $this->db->select('wallet_balance')->get_where('users',array('id'=>$memberID))->row_array();
            $before_wallet_balance = isset($get_member_status['wallet_balance']) ? $get_member_status['wallet_balance'] : 0 ;

            $after_wallet_balance = $before_wallet_balance + $amount;
            // update member wallet
            $wallet_data = array(
                'member_id'           => $memberID,    
                'before_balance'      => $before_wallet_balance,
                'amount'              => $amount,  
                'after_balance'       => $after_wallet_balance,      
                'status'              => 1,
                'type'                => 1,      
                'wallet_type'         => 1,
                'created'             => date('Y-m-d H:i:s'),      
                'credited_by'         => 1,
                'description'         => 'Fund Request #'.$request_id.' Refund Credited.' 
            );

            $this->db->insert('member_wallet',$wallet_data);
            
            // update member current wallet balance
            $this->db->where('id',$memberID);
            $this->db->update('users',array('wallet_balance'=>$after_wallet_balance));

        }   
        
        
        return true;
    }

}


/* end of file: az.php */
/* Location: ./application/models/az.php */