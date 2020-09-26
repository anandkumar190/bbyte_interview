<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 |- Name : Santosh Kumar
 |- Email : santosh.25dec94@gmail.com
 |- Contact No : 8825295127/8271808200
 */
class Modal extends CI_Controller {

	function __construct()
    {
        parent::__construct();
    }

	public function popup($param1=false, $param2=false, $param3=false, $param4=false)
	{
        $results = array();
	    $userType = $this->session->userdata('type');
        switch ($param1 && $param2 == 'update' && !empty($param3)){
            CASE "add_user" :
                $this->load->model($userType.'/UserModel', 'user');
                $results = $this->user->getUserEditData($param3);
                break;

            default : break;
        }
		$page_data['data'] = $results;
		$page_data['type'] = $param2;
		$this->load->view( $this->session->userdata('type').'/'.$param1, $page_data);
	}
}

