<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    /*
     |- Name : Santosh Kumar
     |- Email : santosh.25dec94@gmail.com
     |- Contact No : 8825295127/8271808200
     */
    class Common extends CI_Controller {

        public function getCityByStateId()
        {
            $response = array("status" => false, "data" => array());
            $state_id = $this->input->get('stateId');
            if(!empty($state_id)){
                $data = $this->custom->getCityByStateId($state_id);
                if(!empty($data)){
                    $response['status'] = true;
                    $response['data'] = $data;
                }
            }
            echo json_encode($response, true);
        }
    }
