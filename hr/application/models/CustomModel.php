<?php
    if (!defined('BASEPATH'))
        exit('No direct script access allowed');


    class CustomModel extends CI_Model
    {
        function __construct()
        {
            parent::__construct();
        }

        public function getUserDetails(){
            $result = array();
            $this->db->where('id', $this->session->userdata('id'));
            $query = $this->db->get('users');
            if($query->num_rows() > 0){
                $result = $query->row_array();
            }
            return $result;
        }

        public function getStateList(){
            $result = array();
            $query = $this->db->get('state');
            if($query->num_rows() > 0){
                $result = $query->result_array();
            }
            return $result;
        }

        public function getCityByStateId($state_id){
            $result = array();
            $this->db->where('state_id', $state_id);
            $query = $this->db->get('city');
            if($query->num_rows() > 0){
                $result = $query->result_array();
            }
            return $result;
        }

        public function getRoles(){
            $result = array();
            $role = $this->session->userdata('role');
            if($role == 0){
                $this->db->where('type !=', 0);
            }elseif ($role == 1){
                $this->db->where('type !=', 0);
                $this->db->where('type !=', 1);
            }
            $query = $this->db->get('role');
            if($query->num_rows() > 0){
                $result = $query->result_array();
            }
            return $result;
        }
    }
