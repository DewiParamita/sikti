<?php if (! defined('BASEPATH')) exit('No direct script allowed');
session_start();

class file_ctrl extends CI_Controller {

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
	}
	
	function display_add_file()
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
			
			$this->load->view('add_file', $data);
		}
		else
		{
			$this->load->view('login', $data);
		}
	}
	
	function add_file()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['tipe']		= $session_data['tipe'];
			if($session_data['tipe']=='tim')
			{
				$data['id_user'] 	= $session_data['id_user'];
				$data['username'] 	= $session_data['username'];
				$data['id_people'] 	= $session_data['id_people'];				
			}
			 
			$this->form_validation->set_rules('judul', 'File Title', 'required|max_length[100]');
						
			$data['judul']		= $this->input->post('judul');
			$data['posted_by']	= $data['id_people'];
			$tz_object = new DateTimeZone('Asia/Jakarta');
			$datetime = new DateTime();
			$datetime->setTimezone($tz_object);
			$data['posted_date']= $datetime->format('Y\-m\-d\ h:i:s');
			
			$config['upload_path'] = 'C:\xampp\htdocs\sikti\file';
			$config['allowed_types'] = 'gif|jpg|png|zip|rar|doc|docx|xls|xlsx|ppt|pptx|pdf|tiff|gif';
			$config['max_size'] = '1024';
			$config['max_width'] = '1920';
			$config['max_height'] = '1280';
			$this->load->library('upload', $config);
			$this->upload->do_upload();
			$dataFile = $this->upload->data();
			$data['file']= element('full_path',$dataFile);
						
							
			if($this->session->userdata('project_sess'))
			{
				$session_data = $this->session->userdata('project_sess');
				$data['nama'] = $session_data['nama'];
				$data['id_project'] = $session_data['id_project'];
			}

				
			if	($this->form_validation->run() == FALSE || $data['file']=='C:/xampp/htdocs/sikti/file/')
			{
				if($data['file']=='C:/xampp/htdocs/sikti/file/')
					$data['message'] = 'File must be choosen';
				$this->load->view('add_file',$data);
			}
			else
			{
				$tz_object = new DateTimeZone('Asia/Jakarta');
				$datetime = new DateTime();
				$datetime->setTimezone($tz_object);
				$data['posted_date']= $datetime->format('Y\-m\-d\ h:i:s');
				
				$this->file_model->insert_file($data['judul'],$data['file'],$data['posted_by'], $data['posted_date'],$data['id_project']);
						
				$data['jml_file']	= $this->file_model->count_file($data['id_project']);
				$data['file']		= $this->file_model->get_file($data['id_project']);
				$this->load->view('file', $data);
			}
		}
		else
		{
			$this->load->view('index');
		}
	}
	
	function delete_file()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['tipe']		= $session_data['tipe'];
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
			
			if($this->session->userdata('project_sess'))
			{
				$session_data = $this->session->userdata('project_sess');
				$data['nama'] = $session_data['nama'];
				$data['id_project'] = $session_data['id_project'];
			}
			
			$data['id_file'] = $this->input->get('id');
			$this->file_model->delete_file($data['id_file']);
					
			$data['jml_file']	= $this->file_model->count_file($data['id_project']);
			$data['file']		= $this->file_model->get_file($data['id_project']);
				
			$this->load->view('file', $data);
		}
		else
		{
			$this->load->view('index');
		}
	}
}