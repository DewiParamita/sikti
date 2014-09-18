<?php if (! defined('BASEPATH')) exit('No direct script allowed');
session_start();

class display extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('pagination'); 
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->helper('array');
		$this->load->model('user_model');
		$this->load->model('project_model');
		$this->load->model('position_model');
		$this->load->model('people_model');
		$this->load->model('discussion_model');
		$this->load->model('file_model');
		$this->load->model('task_model');
		$this->load->model('offers_model');
	}
	
	function index()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			if($session_data['tipe']=='konsultan')
			{
				$data['username'] 	= $session_data['username'];
				$data['id_role'] 	= $session_data['id_role'];
				$data['user'] = $this->user_model->get_user_by_username($data['username']);
			}
			else if($session_data['tipe']=='tim')
			{
				$data['id_user'] 	= $session_data['id_user'];
				$data['username'] 	= $session_data['username'];
				$data['id_people'] 	= $session_data['id_people'];
				$data['user'] = $this->people_model->get_user_by_username($data['username']);
			}
			if($this->session->userdata('project_sess'))
			{
				$session_data = $this->session->userdata('project_sess');
				$data['nama'] = $session_data['nama'];
				$data['id_project'] = $session_data['id_project'];
			}
			$this->load->view('index', $data);
		}
		else
		{
			$this->load->view('index');
		}
	}
	
	function display_login()
	{
		
		$this->load->view('login');
		
	}
	
	function display_register()
	{
		$data['message']='';
		
		$this->load->helper(array('captcha','url'));
 
        $this->load->helper('captcha');
 
        $vals = array(
			'word'        => strtoupper(substr(md5(time()), 0, 6)),
            'img_path'	 => './captcha/',
            'img_url'	 => base_url().'captcha/',
            'img_width'	 => '200',
            'img_height' => 50,
            'border' => 1, 
			'font_path' => 'system/fonts/arialbd.ttf',
            'expiration' => 7200
        );
 
        $cap = create_captcha($vals);
        $data['image'] = $cap['image'];
 
        $this->session->set_userdata('mycaptcha', $cap['word']);
			
        $this->load->view('register', $data);
	}
	 
	function display_client_list()
	{
		/*$config['base_url'] = $this->config->item('base_url').'/index.php/display/display_client_list/'; 
		$config['total_rows'] = $this->user_model->count_consultant();
		$config['per_page'] = '6'; 
		$config['uri_segment'] = 3; 
		
		$this->pagination->initialize($config);*/
		
		if($this->session->userdata('project_sess'))
		{
			$session_data = $this->session->userdata('project_sess');
			$data['nama'] = $session_data['nama'];
			$data['id_project'] = $session_data['id_project'];
		}
			
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			if($session_data['tipe']=='konsultan')
			{
				$data['username'] 	= $session_data['username'];
				$data['id_role'] 	= $session_data['id_role'];
				$data['user'] = $this->user_model->get_user_by_username($data['username']);
			}
			else if($session_data['tipe']=='tim')
			{
				$data['id_user'] 	= $session_data['id_user'];
				$data['username'] 	= $session_data['username'];
				$data['id_people'] 	= $session_data['id_people'];
				$data['user'] = $this->people_model->get_user_by_username($data['username']);
			}
			 
			$data['count_consultant'] = $this->user_model->count_consultant();
			$data['consultant'] = $this->user_model->get_consultant();
			//$data['consultant'] = $this->user_model->get_consultant($config['per_page'],$this->uri->segment(3));
			
			$data['count_company'] = $this->user_model->count_customer();
			$data['company'] = $this->user_model->get_customer();
			//$data['company'] = $this->user_model->get_customer($config['per_page'],$this->uri->segment(3));
			
			$this->load->view('client_list', $data);
		}
		else
		{
			$data['count_consultant'] = $this->user_model->count_consultant();
			$data['consultant'] = $this->user_model->get_consultant();
			//$data['consultant'] = $this->user_model->get_consultant($config['per_page'],$this->uri->segment(3));
			
			$data['count_company'] = $this->user_model->count_customer();
			$data['company'] = $this->user_model->get_customer();
			//$data['company'] = $this->user_model->get_customer($config['per_page'],$this->uri->segment(3));
			$this->load->view('client_list', $data);
		}
	}
	
	
	function display_reset_password()
	{
		$data['message']='';
		$this->load->view('forgot_password', $data);
		
	}
	
	function display_project()
	{
		$data['message']='';
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			if($session_data['tipe']=='konsultan')
			{
				$data['username'] 	= $session_data['username'];
				$data['id_role'] 	= $session_data['id_role'];
				$data['user'] = $this->user_model->get_user_by_username($data['username']);
				foreach($data['user'] as $row)
				{
					$data['jml_project'] = $this->project_model->count_project($row->id_user);
					$data['project'] = $this->project_model->get_project($row->id_user);
		
				}
			}
			else if($session_data['tipe']=='tim')
			{
				$data['id_user'] 	= $session_data['id_user'];
				$data['username'] 	= $session_data['username'];
				$data['id_people'] 	= $session_data['id_people'];
				$data['user'] 		= $this->people_model->get_user_by_username($data['username']);
				$data['jml_project']= $this->project_model->count_project_by_people($data['id_people'] );
				$data['project'] 	= $this->project_model->get_project_by_people($data['id_people'] );
				
			}
			
			
			$this->load->view('project', $data);
		}
		else
		{
			$this->load->view('login', $data);
		}
	}
	
	function display_people()
	{
		$data['message']='';
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			if($session_data['tipe']=='konsultan')
			{
				$data['username'] 	= $session_data['username'];
				$data['id_role'] 	= $session_data['id_role'];
				$data['user'] = $this->user_model->get_user_by_username($data['username']);
			}
			else if($session_data['tipe']=='tim')
			{
				$data['id_user'] 	= $session_data['id_user'];
				$data['username'] 	= $session_data['username'];
				$data['id_people'] 	= $session_data['id_people'];
				$data_konsultan     = $this->user_model->get_user_by_id($data['id_user']);
				foreach($data_konsultan as $row)
					$data['username_konsultan']=$row->username;
				$data['user'] 		= $this->user_model->get_user_by_username($data['username_konsultan']);
			}
			 
			if($this->session->userdata('project_sess'))
			{
				$session_data = $this->session->userdata('project_sess');
				$data['nama'] = $session_data['nama'];
				$data['id_project'] = $session_data['id_project'];
			}

			
			foreach($data['user'] as $row)
			{
				$data['jml_position'] = $this->position_model->count_position($row->id_user);
				$data['position'] = $this->position_model->get_position_by($row->id_user);
				$data['jml_people'] = $this->people_model->count_people($row->id_user, $data['id_project']);
				$data['people'] = $this->people_model->get_people_by($row->id_user, $data['id_project']);
				$data['id_konsultan'] = $row->id_user;
			}
			$this->load->view('people', $data);
		}
		else
		{
			$this->load->view('login', $data);
		}
	}
	
	function display_discussion()
	{
		$data['message']='';
		
		if($this->session->userdata('project_sess'))
		{
			$session_data = $this->session->userdata('project_sess');
			$data['nama'] = $session_data['nama'];
			$data['id_project'] = $session_data['id_project'];
		}
			
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			if($session_data['tipe']=='konsultan')
			{	
				$data['tipe']		= $session_data['tipe'];
				$data['username'] 	= $session_data['username'];
				$data['id_role'] 	= $session_data['id_role'];
				$data['user'] 		= $this->user_model->get_user_by_username($data['username']);
				
			}
			else if($session_data['tipe']=='tim')
			{
				$data['tipe']		= $session_data['tipe'];
				$data['id_user'] 	= $session_data['id_user'];
				$data['username'] 	= $session_data['username'];
				$data['id_people'] 	= $session_data['id_people'];
				$data['user'] 		= $this->people_model->get_user_by_username($data['username']);
				
			}
			//echo $data['id_project'];
			$data['jml_discussion']	= $this->discussion_model->count_discussion($data['id_project']);
			$data['discussion']		= $this->discussion_model->get_discussion($data['id_project']);
			
			$this->load->view('discussion', $data);
		}
		else
		{
			$this->load->view('login', $data);
		}
	}
	
	function display_file()
	{
		$data['message']='';
		
		if($this->session->userdata('project_sess'))
		{
			$session_data = $this->session->userdata('project_sess');
			$data['nama'] = $session_data['nama'];
			$data['id_project'] = $session_data['id_project'];
		}
			
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			if($session_data['tipe']=='konsultan')
			{	
				$data['tipe']		= $session_data['tipe'];
				$data['username'] 	= $session_data['username'];
				$data['id_role'] 	= $session_data['id_role'];
				$data['user'] 		= $this->user_model->get_user_by_username($data['username']);
				
			}
			else if($session_data['tipe']=='tim')
			{
				$data['tipe']		= $session_data['tipe'];
				$data['id_user'] 	= $session_data['id_user'];
				$data['username'] 	= $session_data['username'];
				$data['id_people'] 	= $session_data['id_people'];
				$data['user'] 		= $this->people_model->get_user_by_username($data['username']);
				
			}
			//echo $data['id_project'];
			$data['jml_file']	= $this->file_model->count_file($data['id_project']);
			$data['file']		= $this->file_model->get_file($data['id_project']);
			
			$this->load->view('file', $data);
		}
		else
		{
			$this->load->view('login', $data);
		}
	}
	
	function display_gantt()
	{
		$data['message']='';
		if($this->session->userdata('project_sess'))
		{
			$session_data = $this->session->userdata('project_sess');
			$data['nama'] = $session_data['nama'];
			$data['id_project'] = $session_data['id_project'];
		}
		
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			if($session_data['tipe']=='konsultan')
			{
				$data['username'] 	= $session_data['username'];
				$data['id_role'] 	= $session_data['id_role'];
				$data['user'] = $this->user_model->get_user_by_username($data['username']);
				foreach($data['user'] as $row)
				{
					$data['jml_project'] = $this->project_model->count_project($row->id_user);
					$data['project'] = $this->project_model->get_project($row->id_user);
		
				}
			}
			else if($session_data['tipe']=='tim')
			{
				$data['id_user'] 	= $session_data['id_user'];
				$data['username'] 	= $session_data['username'];
				$data['id_people'] 	= $session_data['id_people'];
				$data['user'] 		= $this->people_model->get_user_by_username($data['username']);
				$data['jml_project']= $this->project_model->count_project_by_people($data['id_people'] );
				$data['project'] 	= $this->project_model->get_project_by_people($data['id_people'] );
				
			}
			//$foo = "021";
			//$foo = (int)$foo;
			//settype($foo, "integer");
			//echo $foo;
			$this->load->view('gantt_chart', $data);
		}
		else
		{
			$this->load->view('login', $data);
		}
	}
	
	function display_task()
	{
		$data['message']='';
		if($this->session->userdata('project_sess'))
		{
			$session_data = $this->session->userdata('project_sess');
			$data['nama'] = $session_data['nama'];
			$data['id_project'] = $session_data['id_project'];
		}
		
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			if($session_data['tipe']=='konsultan')
			{
				$data['username'] 	= $session_data['username'];
				$data['id_role'] 	= $session_data['id_role'];
				$data['user'] = $this->user_model->get_user_by_username($data['username']);

				$data['jml_task'] 	= $this->task_model->count_task($data['id_project']);
				$data['task'] 		= $this->task_model->get_task($data['id_project']);

			}
			else if($session_data['tipe']=='tim')
			{
				$data['id_user'] 	= $session_data['id_user'];
				$data['username'] 	= $session_data['username'];
				$data['id_people'] 	= $session_data['id_people'];
				$data['user'] 		= $this->people_model->get_user_by_username($data['username']);
				$data['jml_task'] 	= $this->task_model->count_task($data['id_project']);
				$data['task'] 		= $this->task_model->get_task($data['id_project']);
				
			}
			
			
			$this->load->view('task', $data);
		}
		else
		{
			$this->load->view('login', $data);
		}
	}
	
	function display_projects_offers()
	{
		$data['message']='';
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['tipe'] = $session_data['tipe'];
			if($data['tipe']=='konsultan')
			{
				$data['id_user']	= $session_data['id_user'];
				$data['username'] 	= $session_data['username'];
				$data['id_role'] 	= $session_data['id_role'];
			}
			else if($data['tipe']=='tim')
			{
				$data['id_user'] 	= $session_data['id_user'];
				$data['username'] 	= $session_data['username'];
				$data['id_people'] 	= $session_data['id_people'];
			}
			
			$this->session->set_userdata('username', $data['username']);
			
			$data['jml_offers']	= $this->offers_model->count_offers();
			$data['offers'] 	= $this->offers_model->get_offers();
			
			$data['jml_consultant']	= $this->offers_model->count_consultant();
			$data['consultant'] 	= $this->offers_model->get_consultant();
			
			$data['jml_customer']	= $this->offers_model->count_customer();
			$data['customer'] 		= $this->offers_model->get_customer();
			
			$this->load->view('projects_offers', $data);
		}
		else
		{
			$data['jml_offers']	= $this->offers_model->count_offers();
			$data['offers'] 	= $this->offers_model->get_offers();
			
			$data['jml_consultant']	= $this->offers_model->count_consultant();
			$data['consultant'] 	= $this->offers_model->get_consultant();
			
			$data['jml_customer']	= $this->offers_model->count_customer();
			$data['customer'] 		= $this->offers_model->get_customer();
			$this->load->view('projects_offers', $data);
		}
	}
}