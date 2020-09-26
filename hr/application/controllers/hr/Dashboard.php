<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    /*
     |- Name : Santosh Kumar
     |- Email : santosh.25dec94@gmail.com
     |- Contact No : 8825295127/8271808200
     */
    class Dashboard extends HrController {

        function __construct()
        {
            parent::__construct();
        }

        public function index()
        {
            $page_data['title'] = 'HR Dashboard';
            $page_data['page'] = 'hr/dashboard';
            $this->load->view('layout', $page_data);
        }
    }
