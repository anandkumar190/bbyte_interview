<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    /*
     |- Name : Santosh Kumar
     |- Email : santosh.25dec94@gmail.com
     |- Contact No : 8825295127/8271808200
     */
    class Users extends SmrController {

        function __construct()
        {
            parent::__construct();
    		$this->load->model('smr/UserModel', 'user');
        }

        public function index()
        {
            $page_data['title'] = 'Users';
            $page_data['page'] = 'smr/user_list';
            $this->load->view('layout', $page_data);
        }

        public function getUserList(){
            $draw = intval($this->input->get("draw"));
            $start = intval($this->input->get("start"));
            $length = intval($this->input->get("length"));
            $search = $this->input->get("search");
            $order = $this->input->get("order");
            $order = !empty($order[0]) ? $order[0] : array();

            $data = $this->user->getUserList($start, $length, $search, $order);
            $count = $this->user->getUserListCount($search, $order);

            $result = array(
                "draw" => $draw,
                "recordsTotal" => $count,
                "recordsFiltered" => $count,
                "data" => $data
            );
            echo json_encode($result, JSON_UNESCAPED_SLASHES);
            exit();
        }
    }
