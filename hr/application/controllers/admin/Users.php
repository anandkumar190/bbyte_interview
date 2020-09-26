<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    /*
     |- Name : Santosh Kumar
     |- Email : santosh.25dec94@gmail.com
     |- Contact No : 8825295127/8271808200
     */

    class Users extends AdminController {

        function __construct()
        {
            parent::__construct();
    		$this->load->model('admin/UserModel', 'user');
        }

        public function index()
        {
            $page_data['title'] = 'Users';
            $page_data['page'] = 'admin/user_list';
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

        public function saveUpdateUsers(){
            $response = array("status" => 'warning', "message"=>'Something was wrong, Please try again.');
            $this->form_validation->set_rules('state_id', '', 'required');
            $this->form_validation->set_rules('city_id', '', 'required');
            $this->form_validation->set_rules('fname', '', 'required');
            if($this->input->post('type') == 'save') {
                $this->form_validation->set_rules('email', '', 'required|valid_email|is_unique[users.email]');
                $this->form_validation->set_rules('contact_no', '', 'required|min_length[10]|max_length[10]|is_unique[users.phone]');
            }
            $this->form_validation->set_rules('role', '', 'required');
            if(!empty($this->form_validation->run())){
                $res = $this->user->saveUpdateUsers($this->input->post());
                if($res){
                    $response['status'] ='success';
                    $response['message'] ='User added successfully';
                }
            }
            echo json_encode($response, true);
        }

    }
