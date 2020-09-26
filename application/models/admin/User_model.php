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

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function saveUser($post)
    {       
            $loggedUser = $this->User->getLoggedUser("cranesmart_admin");
    	    
			$user_display_id = $this->User->generate_unique_user_id();
            
            $data = array(    
                'role_id'            =>  $post['role_id'],      
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
                'for_view'           =>  (isset($post['for_view']) && !empty($post['for_view'])) ? $post['for_view'] : null,
                'created'            =>  date('Y-m-d H:i:s')
            );

            $this->db->insert('users',$data);
           

    	return true;
    }

    public function updateUser($post)
        {

            $data = array(    
				'role_id'            =>  $post['role_id'],      
                'name'               =>  $post['name'],
                'email'              =>  trim(strtolower($post['email'])),
                'mobile'             =>  $post['mobile'],
                'is_active'          =>  $post['is_active'],
                'for_view'           =>  (isset($post['for_view']) && !empty($post['for_view'])) ? $post['for_view'] : null,
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

}


/* end of file: az.php */
/* Location: ./application/models/az.php */