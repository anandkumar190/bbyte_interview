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

class Wallet_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function saveWallet($post)
    {       
            $loggedUser = $this->User->getLoggedUser("cranesmart_admin");
    	    
            $before_balance = $this->db->get_where('users',array('id'=>$post['member']))->row_array();
			
			$type = $post['type'];
			
			if($type == 1){
				$after_balance = $before_balance['wallet_balance'] + $post['amount'];    
			}
			else
			{
				$after_balance = $before_balance['wallet_balance'] - $post['amount'];    
			}

            $wallet_data = array(

            'member_id'           => $post['member'],    
            'before_balance'      => $before_balance['wallet_balance'],
            'amount'              => $post['amount'],  
            'after_balance'       => $after_balance,      
            'status'              => 1,
            'type'                => $type,      
            'created'             => date('Y-m-d H:i:s'),      
            'credited_by'         => $loggedUser['id'],
            'description'         => $post['description']            
            );

            $this->db->insert('member_wallet',$wallet_data);

            $user_wallet = array(
            'wallet_balance'=>$after_balance,        
            );    

            $this->db->where('id',$post['member']);
            $this->db->update('users',$user_wallet);    

    	return true;
    }

    
}


/* end of file: az.php */
/* Location: ./application/models/az.php */