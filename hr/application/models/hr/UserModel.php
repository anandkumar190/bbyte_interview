<?php
    if (!defined('BASEPATH'))
        exit('No direct script access allowed');


    class UserModel extends CI_Model
    {
        function __construct()
        {
            parent::__construct();
        }

        public function saveUpdateUsers($post){
            $where = array();
            $queryType = 'insert';
            $data = array(
                'fullname' => $post['fname'],
                'state_id' => $post['state_id'],
                'city_id' => $post['city_id'],
                'role' => $post['role'],
            );
            if($post['type'] == 'update' && !empty($post['id'])){
                $data['updated_at'] = date('Y-m-d H:i:s');
                $where = array('id' => $post['id']);
                $queryType = 'update';
            }
            if($post['type'] == 'save' && empty($post['id'])){
                $data['email'] = $post['email'];
                $data['phone'] = $post['contact_no'];
                $data['password'] = password_hash('123456', PASSWORD_BCRYPT);
                $data['created_at'] = date('Y-m-d H:i:s');
            }
            if(!empty($where)){
                $this->db->where($where);
            }
            return $this->db->$queryType('users', $data);
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

            $this->db->where('u.role !=', 0);
            $this->db->where('u.role !=', 1);
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
                    $editUrl = base_url('modal/popup/add_user/update/'.$key->id);
                    $delUrl = '';
                    $action = '<button class="btn btn-xs btn-info" type="button" onclick="showAjaxModal(\'' .$editUrl.'\')"> <i class="fa fa-pencil-square"></i> Edit </button>
                                <button class="btn btn-xs btn-danger" type=button> <i class="fa fa-trash"></i> Delete</button>';
                    $results[] = array(
                        $start + $index + 1,
                        $key->fullname,
                        $key->email,
                        $key->phone,
                        $key->role_title,
                        $status,
                        $key->state,
                        $key->city,
                        $action
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

            $this->db->where('u.role !=', 0);
            $this->db->where('u.role !=', 1);
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

        public function getUserEditData($param3){
            $response = array();
            $this->db->where('id', $param3);
            $query = $this->db->get('users');
            if(!empty($query->num_rows())){
                $row = $query->row_array();
                $response = $row;
                $response['all_city'] = getCityByStateId($row['state_id']);
            }
            return $response;
        }
    }
