<?php
    if (!defined('BASEPATH'))
        exit('No direct script access allowed');


    class UserModel extends CI_Model
    {
        function __construct()
        {
            parent::__construct();
        }

        public function getUserList($start, $length, $search, $order){
            $results = array();
            if (!empty($search['value'])) {
                $this->db->group_start();
                $this->db->like('u.fullname', $search['value']);
                $this->db->or_like('u.email', $search['value']);
                $this->db->or_like('u.phone', $search['value']);
                $this->db->or_like('s.name', $search['value']);
                $this->db->or_like('c.name', $search['value']);
                $this->db->or_like('r.title', $search['value']);
                $this->db->group_end();
            }

            $this->db->where('u.role', 3);
            $this->db->select('u.*, s.name as state, c.name as city, r.title as role_title');
            $this->db->from('users as u');
            $this->db->join('state as s', 'u.state_id=s.id');
            $this->db->join('city as c', 'u.city_id=c.id');
            $this->db->join('role as r', 'u.role=r.type');
            $this->db->limit($length, $start);
            $query = $this->db->get();
            if($query->num_rows() > 0){
                foreach ($query->result() as $index => $key) {
                    $status = '<label class="btn btn-xs btn-info">Active</label>';
                    if($key->status == 1){
                        $status = '<label class="btn btn-xs btn-warning">In-Active</label>';
                    }
                    $results[] = array(
                        $start + $index + 1,
                        $key->fullname,
                        $key->email,
                        $key->phone,
                        $key->role_title,
                        $status,
                        $key->state,
                        $key->city,
                    );
                }
            }
            return $results;
        }

        public function getUserListCount($search, $order){
            $count = 0;
            if (!empty($search['value'])) {
                $this->db->group_start();
                $this->db->like('u.fullname', $search['value']);
                $this->db->or_like('u.email', $search['value']);
                $this->db->or_like('u.phone', $search['value']);
                $this->db->or_like('s.name', $search['value']);
                $this->db->or_like('c.name', $search['value']);
                $this->db->or_like('r.title', $search['value']);
                $this->db->group_end();
            }

            $this->db->where('u.role', 3);
            $this->db->from('users as u');
            $this->db->join('state as s', 'u.state_id=s.id');
            $this->db->join('city as c', 'u.city_id=c.id');
            $this->db->join('role as r', 'u.role=r.type');
            $query = $this->db->get();
            if ($query->num_rows()) {
                $count = $query->num_rows();
            }
            return $count;
        }
    }
