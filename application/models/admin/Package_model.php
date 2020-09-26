<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * Model used for setup default message and resize image
 * 
 * This one used for defined some methods accross all site.
 * this one used for show system message, errors.
 * this one used for image resizing
 * @author trilok
 */

require_once BASEPATH . '/core/Model.php';

class Package_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function savePackage($post)
    {       
            
            $loggedUser = $this->User->getLoggedUser("cranesmart_admin");
    	   // get last member number 
            $get_package_display_number = $this->db->select('package_display_id_no')->order_by('package_display_id_no','desc')->get('package')->row_array();
            $package_display_number = isset($get_package_display_number['package_display_id_no']) ? $get_package_display_number['package_display_id_no'] + 1 : 1;
            
            $package_display_id = PACKAGE_DISPLAY_ID;
            
            if(strlen($package_display_number) == 1)
            {
                $package_display_id.='00000'.$package_display_number;
            }
            elseif(strlen($package_display_number) == 2)
            {
                $package_display_id.='0000'.$package_display_number;
            }
            elseif(strlen($package_display_number) == 3)
            {
                $package_display_id.='000'.$package_display_number;
            }
			elseif(strlen($package_display_number) == 4)
            {
                $package_display_id.='00'.$package_display_number;
            }
			elseif(strlen($package_display_number) == 5)
            {
                $package_display_id.='0'.$package_display_number;
            }
			elseif(strlen($package_display_number) == 6)
            {
                $package_display_id.=$package_display_number;
            }
            
            $data = array(    
                'package_display_id'        =>  $package_display_id,      
                'package_display_id_no'     =>  $package_display_number,      
                'package_name'              =>  $post['package_name'],
                'package_amount'            =>  $post['package_amount'],
                'cm_points'      			=>  $post['cm_points'],
                'refer_cm_points' 			=>  $post['refer_cm_points'],
                'cashback'            		=>  $post['cashback'],
                'status'                    =>  $post['status'],
                'created'                   =>  date('Y-m-d H:i:s')
            );

            $this->db->insert('package',$data);
         

    	return true;
    }

public function updatePackage($post)
    {       
            
            $data = array(    
                'package_name'              =>  $post['package_name'],
                'package_amount'            =>  $post['package_amount'],
                'cm_points'      			=>  $post['cm_points'],
                'refer_cm_points' 			=>  $post['refer_cm_points'],
                'cashback'            		=>  $post['cashback'],
                'status'                    =>  $post['status'],
                'updated'                   =>  date('Y-m-d H:i:s')
            );

            $this->db->where('id',$post['id']);
            $this->db->update('package',$data);
         

        return true;
    }


}


/* end of file: az.php */
/* Location: ./application/models/az.php */