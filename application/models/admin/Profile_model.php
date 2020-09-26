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

class Profile_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function updateAdminPassword($post,$account_id)
    {
    	$data = array(
    		'password' => do_hash($post['npw']),
            'decode_password' =>$post['npw'],
    		'updated' => date('Y-m-d h:i:s')
    	);

    	$this->db->where('id',$account_id);
    	$this->db->update('users',$data);

    	return true;
    }


    public function updateProfile($post)
    {
        $data = array(
            'name' => $post['name'],
            'mobile' => $post['mobile'],
            'email' => $post['email'],
            'username' => $post['username'],
            'updated' => date('Y-m-d h:i:s')
        );

        $this->db->where('id',$post['account_id']);
        $this->db->update('users',$data);

        return true;
    }

}


/* end of file: az.php */
/* Location: ./application/models/az.php */