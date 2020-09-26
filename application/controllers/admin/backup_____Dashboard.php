<?php
if(!defined('BASEPATH'))
    exit('No direct scrip access allowed');

/*
 * login Register controller for Frontend
 * 
 * this controller user for login, register, logout, forgot password, reset password
 * @author trilok
 */

class Dashboard extends CI_Controller{

    public function __construct() {
        parent::__construct();
        //load language
		$this->User->checkPermission();
		$this->load->model('admin/Login_model');
        $this->lang->load('admin/dashboard', 'english');
        $this->lang->load('front_common' , 'english');
    }
	
	public function index($uname_prefix = '' , $username = ''){
		//get logged user info
        $loggedUser = $this->User->getLoggedUser("cranesmart_admin");
		$account_id = $loggedUser['id'];
		
		// get users total wallet balance
        $get_total_wallet_balance = $this->db->select('SUM(wallet_balance) as total_balance')->get('users')->row_array();
        $total_wallet_balance = isset($get_total_wallet_balance['total_balance']) ? $get_total_wallet_balance['total_balance'] : 0 ;

        // get total TDS
        $get_total_tds_balance = $this->db->select('SUM(tds_amount) as total_balance')->get_where('level_income',array('is_paid'=>1))->row_array();
        $tds_balance = isset($get_total_tds_balance['total_balance']) ? $get_total_tds_balance['total_balance'] : 0 ;

        // get users total cm points
        $get_total_cm_balance = $this->db->select('SUM(cm_points) as total_balance')->get('users')->row_array();
        $total_cm_balance = isset($get_total_cm_balance['total_balance']) ? $get_total_cm_balance['total_balance'] : 0 ;

        // get total Fund Charge
        $get_total_fund_balance = $this->db->select('SUM(transfer_charge_amount) as total_balance')->get_where('user_fund_transfer',array('status'=>3))->row_array();
        $fund_balance = isset($get_total_fund_balance['total_balance']) ? $get_total_fund_balance['total_balance'] : 0 ;
		
		$siteUrl = base_url();
		$data = array(
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'site_url' => $siteUrl,
			'loggedUser'  => $loggedUser,
            'account_id'=>$account_id,
            'total_wallet_balance' => $total_wallet_balance,
            'tds_balance' => $tds_balance,
            'total_cm_balance' => $total_cm_balance,
            'fund_balance' => $fund_balance,
		    'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getsystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'content_block' => 'dashboard'
        );
        $this->parser->parse('admin/layout/column-1' , $data);
    }
	
	public function edit_admin($id = '') {
		$this->load->library('template');
		
        //verify id is avaialabel or not
		$verify_admin = $this->db->select('*')
                        ->where('id', $id)
                        ->get('user_det')->row_array();
		
        if (!$verify_admin) {
            $this->Az->redirect('admin/Dashboard/index', 'system_message_error', lang('CANOT_EDIT_ADMIN'));
        }

		$siteUrl = site_url();

        //get logged user info
        $loggedUser = $this->User->getLoggedUser('cranesmart_admin');

		$data = array(
            'site_url' => $siteUrl,
            'meta_title' => 'Edit User',
            'meta_keywords' => 'Edit User',
            'meta_description' => 'Edit User',
            'content_block' => 'edit_admin',
            'page_title' => 'Edit User',
            'manager_description' => 'Create User',
            'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getSystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning(),
            'pagination' => $this->pagination->create_links(),
            'admin_info' => $verify_admin,
			'loggedUser' => $loggedUser,
            'title' => 'Edit User'
        );
        $this->parser->parse('admin/layout/column-1', $data);
    }
	
	public function chkoldpw() {
   
        //chekchk eneterd old pw is correct or not       
        if ($_POST['opw']) {
            $chk = $this->db->select('password')
                            ->where('password', do_hash($_POST['opw']))
                            ->get('user_det')->row_array();

            if (!$chk) {
                echo 'Please enter correct password';
            } else {
                echo 'Password matched';
            }
        }
    }
	
	public function update_admin() {
        
		$this->load->library('template');
        $siteUrl = site_url();
		$post = $this->input->post();
		
        //get logged user info
        $loggedUser = $this->User->getLoggedUser('cranesmart_admin');

        //check for foem validation
        $this->load->library('form_validation');
        $this->form_validation->set_rules('opw', 'Old Password', 'required|xss_clean');		
        

        if ($this->form_validation->run() == FALSE) {
			
			$this->edit_admin($post['admin_id']);
        } 
		else {
			
			$this->Login_model->updateUser($post);
			
			$this->Az->redirect('admin/Dashboard/', 'system_message_error',lang('USER_UPDATE_SUCCESSFULLY'));
			
			 
		}
		
    }
	
	public function logOut() {
        $this->Login_model->adminLogout();
        $this->Az->redirect('admin/Login', 'system_message_error', lang('LOGOUT_SUCCESS'));
    }
    
    /*
    public function income_generate()
    {
        $user_id = array(724);
        // get investment list
        $investmentList = $this->db->select('member_investment.*,users.user_code')->join('users','users.id = member_investment.member_id')->where_in('member_investment.member_id',$user_id)->get('member_investment')->result_array();
        if($investmentList)
        {
            foreach($investmentList as $list)
            {
                $investment_id = $list['id'];
        		$package_id = $list['package_id'];
        		$user_code = $list['user_code'];
        		$account_id = $list['member_id'];
        		// check if package is preminum
        		if($package_id > 1)
        		{
        			// get binary income percentage
        			$get_direct_percentage = $this->db->get_where('master_setting',array('id'=>1))->row_array();
        			$tds_percentage = isset($get_direct_percentage['tds']) ? $get_direct_percentage['tds'] : 0 ;
        			//$service_tax_percentage = isset($get_direct_percentage['service_tax']) ? $get_direct_percentage['service_tax'] : 0 ;
        			$service_tax_percentage = 0;
        			
        			$binary_amount = 1400;
        			log_message('debug', 'Member #'.$user_code.' Level Income Start');
        			// generate level income
        			$level_member_id = $account_id;
        			$level_title = array('Zero','First','Second','Third','Fourth','Fifth','Six','Seven','Eight','Nine','Ten','Eleven','Twelve','Thirteen','Fourteen','Fifteen','Sixteen','Seventeen','Eighteen','Nineteen','Twenty','Twenty One');
        			
        			$end_level = 21;
        			if($package_id == 2 || $package_id == 4)
        			{
        				$end_level = 4;
        			}
        			
        			for($level = 1; $level <=$end_level; $level++){
        				
        				$log_title = isset($level_title[$level]) ? $level_title[$level] : '';
        				
        				$level_member_id = $this->User->generate_level_income($level_member_id,$binary_amount,$user_code,$tds_percentage,$service_tax_percentage,$level,$account_id,$log_title);
        			}
        			
        			log_message('debug', 'Member #'.$user_code.' Level Income End');
        		}
            }
        }
        die("done");
        
    }
    
    public function income_paid()
    {
        $id = array(589);
        // get investment list
        $investmentList = $this->db->select('*')->where_in('level_income.id',$id)->get('level_income')->result_array();
        if($investmentList)
        {
            foreach($investmentList as $list)
            {
                $first_level_member_id = $list['paid_to_member_id'];
                
                $first_wallet_settle_amount = $list['wallet_settle_amount'];
                
                $paid_from_member_id = $list['paid_from_member_id'];
                
                // get first level member wallet balance
				$get_first_member_wallet_balance = $this->db->get_where('users',array('id'=>$first_level_member_id))->row_array();
				$first_wallet_balance = isset($get_first_member_wallet_balance['wallet_balance']) ? $get_first_member_wallet_balance['wallet_balance'] : 0 ;
				
				
				$first_after_balance = $first_wallet_balance + $first_wallet_settle_amount;
				
				// get paid member id
				$get_member_user_code = $this->db->select('user_code')->get_where('users',array('id'=>$paid_from_member_id))->row_array();
				$member_user_code = isset($get_member_user_code['user_code']) ? $get_member_user_code['user_code'] : '';
				
				$walletData = array(
					'member_id' => $first_level_member_id,
					'type' => 1,
					'before_balance' => $first_wallet_balance,
					'amount' => $first_wallet_settle_amount,
					'after_balance' => $first_after_balance,
					'is_income' => 1,
					'income_type' => 1,
					'description' => 'Level Income Settlement From Member #'.$member_user_code,
					'created' => date('Y-m-d H:i:s')
				);
				$this->db->insert('member_wallet',$walletData);
				
				// update member current wallet balance
				$this->db->where('id',$first_level_member_id);
				$this->db->update('users',array('wallet_balance'=>$first_after_balance));
				
				$this->db->where('id',$list['id']);
				$this->db->update('level_income',array('is_paid'=>1));
            }
        }
        die('success');
    }
    
    
    public function income_unpaid()
    {
        $id = array(4438,4439,4440);
        // get investment list
        $investmentList = $this->db->select('*')->where_in('level_income.id',$id)->get('level_income')->result_array();
        if($investmentList)
        {
            foreach($investmentList as $list)
            {
                $first_level_member_id = $list['paid_to_member_id'];
                
                $first_wallet_settle_amount = $list['wallet_settle_amount'];
                
                $paid_from_member_id = $list['paid_from_member_id'];
                
                // get first level member wallet balance
				$get_first_member_wallet_balance = $this->db->get_where('users',array('id'=>$first_level_member_id))->row_array();
				$first_wallet_balance = isset($get_first_member_wallet_balance['wallet_balance']) ? $get_first_member_wallet_balance['wallet_balance'] : 0 ;
				
				
				$first_after_balance = $first_wallet_balance - $first_wallet_settle_amount;
				
				$walletData = array(
					'member_id' => $first_level_member_id,
					'type' => 2,
					'before_balance' => $first_wallet_balance,
					'amount' => $first_wallet_settle_amount,
					'after_balance' => $first_after_balance,
					'is_income' => 1,
					'income_type' => 1,
					'description' => 'Debit against double Txn',
					'created' => date('Y-m-d H:i:s')
				);
				$this->db->insert('member_wallet',$walletData);
				
				// update member current wallet balance
				$this->db->where('id',$first_level_member_id);
				$this->db->update('users',array('wallet_balance'=>$first_after_balance));
				
				$this->db->where('id',$list['id']);
				$this->db->update('level_income',array('is_paid'=>0));
            }
        }
        die('success');
    }
    
    */
    
	
	
	
}


/* End of file login.php */
/* Location: ./application/controllers/login.php */