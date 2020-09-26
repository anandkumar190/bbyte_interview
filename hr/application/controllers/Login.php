<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    /*
     |- Name : Santosh Kumar
     |- Email : santosh.25dec94@gmail.com
     |- Contact No : 8825295127/8271808200
     */
    class Login extends CI_Controller {

        function __construct(){
            parent::__construct();
            $this->load->model("LoginModel", "login");
        }

        public function index()
        {
            if(isset($_SESSION['id']) && !empty($_SESSION['id']) && !empty($_SESSION['login_status'])){
                redirect(base_url($this->session->userdata('type').'/dashboard'), 'refresh');
                exit();
            }
            $page_data['title'] = 'Login';
            $page_data['page'] = 'login';
            $this->load->view('index', $page_data);
        }

        function validateUser(){
            $response = array('status' => false, "message" => "Invalid User Id & Password", "url" => '');
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            if(!empty($username) && !empty($password)){
                $res = $this->login->validateUser($username, $password);
                if(!empty($res['login_status'])){
                    $response['status'] = true;
                    $response['message'] = 'Login Successfully';
                    $response['url'] = $res['type'].'/dashboard';
                    $this->session->set_userdata($res);
                }
            }
            echo json_encode($response, true);
        }

        function logout(){
            if(!empty($this->session->userdata('id'))){
                $this->session->sess_destroy();
                unset($_SESSION);
                redirect(base_url(), 'refresh');
            }
        }
    }
