<?php if (! defined('BASEPATH')) exit('No direct script allowed');
session_start();

class discussion_ctrl extends CI_Controller {

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
		$this->load->model('hire_model');
		$this->load->model('discussion_model');
	}
	
		
	function display_add_discussion()
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
			
			$this->load->view('add_discussion', $data);
		}
		else
		{
			$this->load->view('login', $data);
		}
	}
	
	function add_discussion()
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
				$data_konsultan     = $this->user_model->get_user_by_id($data['id_user']);
				foreach($data_konsultan as $row)
					$data['username_konsultan']=$row->username;
				$data['user'] 		= $this->user_model->get_user_by_username($data['username_konsultan']);
				
			}
			 
			$data['posted_by']=$data['id_people'];
		
			$this->form_validation->set_rules('topic', 'Topic Discussion', 'required|max_length[100]');
			$this->form_validation->set_rules('deskripsi', 'Description', 'max_length[300]');
			
			
			$data['topic']=$this->input->post('topic');
			$data['deskripsi']=$this->input->post('deskripsi');
						
							
			if($this->session->userdata('project_sess'))
			{
				$session_data = $this->session->userdata('project_sess');
				$data['nama'] = $session_data['nama'];
				$data['id_project'] = $session_data['id_project'];
			}

				
			if	($this->form_validation->run() == FALSE )
			{
				
				$this->load->view('add_discussion',$data);
			}
			else
			{
				$tz_object = new DateTimeZone('Asia/Jakarta');
				$datetime = new DateTime();
				$datetime->setTimezone($tz_object);
				$data['posted_date']= $datetime->format('Y\-m\-d\ h:i:s');
				
				$this->discussion_model->insert_discussion($data['topic'],$data['deskripsi'],$data['posted_by'], $data['posted_date'],$data['id_project']);
						
				$data['jml_discussion']	= $this->discussion_model->count_discussion($data['id_project']);
				$data['discussion']		= $this->discussion_model->get_discussion($data['id_project']);
				$this->load->view('discussion', $data);
			}
		}
		else
		{
			$this->load->view('index');
		}
	}
	
	function delete_discussion()
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
			
			if($this->session->userdata('project_sess'))
			{
				$session_data = $this->session->userdata('project_sess');
				$data['nama'] = $session_data['nama'];
				$data['id_project'] = $session_data['id_project'];
			}
			
			
				
			$data['id_discussion'] = $this->input->get('id');
			$this->discussion_model->delete_discussion($data['id_discussion']);
			
			$data['jml_discussion']	= $this->discussion_model->count_discussion($data['id_project']);
			$data['discussion']		= $this->discussion_model->get_discussion($data['id_project']);
				
			$this->load->view('discussion', $data);
		}
		else
		{
			$this->load->view('index');
		}
	}
	
	function display_edit_discussion()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data 	= $this->session->userdata('logged_in');
			$data['tipe']	= $session_data['tipe'];
			
			if($session_data['tipe']=='tim')
			{
				$data['id_user'] 	= $session_data['id_user'];
				$data['username'] 	= $session_data['username'];
				$data['id_people'] 	= $session_data['id_people'];				
			}
			
			if($this->session->userdata('project_sess'))
			{
				$session_data = $this->session->userdata('project_sess');
				$data['nama'] = $session_data['nama'];
				$data['id_project'] = $session_data['id_project'];
			}
			$data['id_discussion'] = $this->input->get('id');
			$data['discussion']    = $this->discussion_model->get_discussion_by_id($data['id_discussion']);
			
			foreach($data['discussion'] as $row)
			{
				$data['topic'] 			= $row->topic;
				$data['deskripsi']	   	= $row->deskripsi; 
				
			}

			$this->load->view('edit_discussion', $data);
		}
		else
		{
			$this->load->view('index');
		}
	}
	
	function edit_discussion()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['tipe']	= $session_data['tipe'];
			
			if($session_data['tipe']=='tim')
			{
				$data['id_user'] 	= $session_data['id_user'];
				$data['username'] 	= $session_data['username'];
				$data['id_people'] 	= $session_data['id_people'];
				
			}
			 
			$this->form_validation->set_rules('topic', 'Topic Discussion', 'required|max_length[100]');
			$this->form_validation->set_rules('deskripsi', 'Description', 'max_length[300]');
			
			$data['topic']		=$this->input->post('topic');
			$data['deskripsi']	=$this->input->post('deskripsi');
			$data['id_discussion']=$this->input->post('id_discussion');			
							
			if($this->session->userdata('project_sess'))
			{
				$session_data = $this->session->userdata('project_sess');
				$data['nama'] = $session_data['nama'];
				$data['id_project'] = $session_data['id_project'];
			}
									
			if	($this->form_validation->run() == FALSE )
			{
				
				$this->load->view('edit_discussion',$data);
			}
			else
			{
				$this->discussion_model->update_discussion($data['topic'],$data['deskripsi'], $data['id_discussion']);
				
				$data['jml_discussion']	= $this->discussion_model->count_discussion($data['id_project']);
				$data['discussion']		= $this->discussion_model->get_discussion($data['id_project']);		
				
				$this->load->view('discussion', $data);
			}
		}
		else
		{
			$this->load->view('index');
		}
	}
}