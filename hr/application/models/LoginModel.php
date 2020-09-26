<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');


class LoginModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function validateUser($username, $password){
        $response = array("login_status" => false);
        $this->db->where('email', $username);
        $this->db->where('status', '0');
        $query = $this->db->get('users');
        if($query->num_rows() > 0){
            $row = $query->row();
            if($row && password_verify($password, $row->password)) {
                $type = '';
                if($row->role == 0){
                    $type = 'admin';
                }elseif($row->role == 1){
                    $type = 'hr';
                }elseif($row->role == 2){
                    $type = 'smr';
                }elseif($row->role == 3){
                    $type = 'mr';
                }
                $response = array(
                    "id" => $row->id,
                    "role" => $row->role,
                    "email" => $row->email,
                    "phone" => $row->phone,
                    "name" => $row->fullname,
                    "type" => $type,
                    "login_status" => true
                );
            }
        }
        return $response;
    }
}
