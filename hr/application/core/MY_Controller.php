<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 |- Name : Santosh Kumar
 |- Email : santosh.25dec94@gmail.com
 |- Contact No : 8825295127/8271808200
 */
class MY_Controller extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }
}

class AdminController extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['id']) || empty($_SESSION['id']) || $_SESSION['role'] != 0 || empty($_SESSION['login_status'])){
			 redirect(base_url(), 'refresh');
		}
    }
}

class HrController extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        if(!isset($_SESSION['id']) || empty($_SESSION['id']) || $_SESSION['role'] != 1  || empty($_SESSION['login_status'])){
            redirect(base_url(), 'refresh');
        }
    }
}

class SmrController extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        if(!isset($_SESSION['id']) || empty($_SESSION['id']) || $_SESSION['role'] != 2  || empty($_SESSION['login_status'])){
            redirect(base_url(), 'refresh');
        }
    }
}

class MrController extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        if(!isset($_SESSION['id']) || empty($_SESSION['id']) || $_SESSION['role'] != 3  || empty($_SESSION['login_status'])){
            redirect(base_url(), 'refresh');
        }
    }
}
