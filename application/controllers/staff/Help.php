<?php 
class Help extends CI_Controller {
    
    
    public function __construct() 
    {
        parent::__construct();
        if(empty($_SESSION['cranesmart_staff']) || empty($_SESSION['cranesmart_staff']['id']) || $_SESSION['cranesmart_staff']['role_id'] != 6 || $_SESSION['cranesmart_staff']['for_view'] != 2){
            redirect(base_url('admin/login'));
            exit();
        }
		$this->load->model('admin/HelpModel', 'help');
        $this->lang->load('admin/kyc', 'english');

    }

	public function index()
    {
		$siteUrl = site_url();
		$data = array(
            'site_url' => $siteUrl,
            'meta_title' => lang('SITE_NAME'),
            'meta_keywords' => lang('SITE_NAME'),
            'meta_description' => lang('SITE_NAME'),
            'content_block' => 'help/list',
            'manager_description' => lang('SITE_NAME'),
			'system_message' => $this->Az->getSystemMessageError(),
            'system_info' => $this->Az->getSystemMessageInfo(),
            'system_warning' => $this->Az->getSystemMessageWarning()
        );
        $this->parser->parse('staff/layout/column-1', $data);

    }
	
	public function getHelpList()
	{
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $search = $this->input->get("search");
        $order = $this->input->get("order");
        $order = !empty($order[0]) ? $order[0] : array();

        $data = $this->help->getHelpList($start, $length, $search, $order);
        $count = $this->help->getHelpListCount($search, $order);

        $result = array(
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $data
        );
        echo json_encode($result, JSON_UNESCAPED_SLASHES);
        exit();
	}
	
	public function updateKYCAuth($requestID = 0, $status = 0)
	{
		// check request id valid or not
		$chk_request_id = $this->db->get_where('member_kyc_detail',array('id'=>$requestID,'status'=>2))->num_rows();
		if(!$chk_request_id)
		{
			$this->Az->redirect('staff/kyc/kycList', 'system_message_error',lang('DB_ERROR'));
		}
		
		$this->Kyc_model->updateRequestAuth($requestID,$status);
		if($status == 1){
			$this->Az->redirect('staff/kyc/kycList', 'system_message_error',lang('REQUEST_APPROVE_SUCCESS'));
		}
		else
		{
			$this->Az->redirect('staff/kyc/kycList', 'system_message_error',lang('REQUEST_REJECT_SUCCESS'));
		}
	}
}