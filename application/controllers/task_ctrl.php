<?php if (! defined('BASEPATH')) exit('No direct script allowed');
session_start();

class task_ctrl extends CI_Controller {

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
		$this->load->model('task_model');
	}
	
		
	function display_add_task()
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
				foreach($data['user'] as $row)
					$data['id_konsultan']=$row->id_user;
				
			}
			else if($session_data['tipe']=='tim')
			{
				$data['tipe']		= $session_data['tipe'];
				$data['id_konsultan'] 	= $session_data['id_user'];
				$data['username'] 	= $session_data['username'];
				$data['id_people'] 	= $session_data['id_people'];
				$data['user'] 		= $this->people_model->get_user_by_username($data['username']);
				
			}
			$data['people'] = $this->people_model->get_people_by($data['id_konsultan'], $data['id_project']);
			$this->load->view('add_task', $data);
		}
		else
		{
			$this->load->view('login', $data);
		}
	}
	
	function add_task()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['tipe']		= $session_data['tipe'];
			if($session_data['tipe']=='konsultan')
			{
				$data['username'] 	= $session_data['username'];
				$data['id_role'] 	= $session_data['id_role'];
				$data['user'] = $this->user_model->get_user_by_username($data['username']);
				foreach($data['user'] as $row)
					$data['id_konsultan']=$row->id_user;
			}
			else if($session_data['tipe']=='tim')
			{
				$data['id_konsultan'] 	= $session_data['id_user'];
				$data['username'] 	= $session_data['username'];
				$data['id_people'] 	= $session_data['id_people'];
			
				
			}
			 	
			$this->form_validation->set_rules('task_name', 'Task Name', 'required|max_length[50]');
			$this->form_validation->set_rules('deskripsi', 'Description', 'max_length[200]');
			$this->form_validation->set_rules('start_date', 'Start Date', 'required|date');
			$this->form_validation->set_rules('duration', 'Duration', 'required|numeric');
			
			$data['task_name']	= $this->input->post('task_name');
			$data['deskripsi']	= $this->input->post('deskripsi');
			$data['start_date']	= $this->input->post('start_date');
			$data['duration']	= $this->input->post('duration');
			$data['responsible']= $this->input->post('select_people');
							
			if($this->session->userdata('project_sess'))
			{
				$session_data = $this->session->userdata('project_sess');
				$data['nama'] = $session_data['nama'];
				$data['id_project'] = $session_data['id_project'];
			}
	
			if	($this->form_validation->run() == FALSE )
			{
				$data['people'] = $this->people_model->get_people_by($data['id_konsultan'], $data['id_project']);
				$this->load->view('add_task',$data);
			}
			else
			{
				$this->task_model->insert_task($data['task_name'],$data['deskripsi'],$data['start_date'], $data['duration'],$data['id_project'], $data['responsible']);
						
				$data['jml_task'] 	= $this->task_model->count_task($data['id_project']);
				$data['task'] 		= $this->task_model->get_task($data['id_project']);
				$this->load->view('task', $data);
			}
		}
		else
		{
			$this->load->view('index');
		}
	}
	
	function display_edit_task()
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
				foreach($data['user'] as $row)
					$data['id_konsultan']=$row->id_user;
				
			}
			else if($session_data['tipe']=='tim')
			{
				$data['tipe']		= $session_data['tipe'];
				$data['id_konsultan'] 	= $session_data['id_user'];
				$data['username'] 	= $session_data['username'];
				$data['id_people'] 	= $session_data['id_people'];
				$data['user'] 		= $this->people_model->get_user_by_username($data['username']);
				
			}
			
			$data['id_task'] = $this->input->get('id');
			$task = $this->task_model->get_task_by_id($data['id_task']);
			foreach($task as $rows)
			{
				$data['task_name'] 	= $rows->nama;
				$data['deskripsi']	= $rows->deskripsi;
				$data['start_date']	= $rows->start_date;
				$data['duration']	= $rows->duration;
				$data['progress']	= $rows->progress;
				$data['responsible']= $rows->responsible;
			}
			$data['people'] = $this->people_model->get_people_by($data['id_konsultan'], $data['id_project']);
			$this->load->view('edit_task', $data);
		}
		else
		{
			$this->load->view('login', $data);
		}
	}
	
	function edit_task()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['tipe']		= $session_data['tipe'];
			if($session_data['tipe']=='konsultan')
			{
				$data['username'] 	= $session_data['username'];
				$data['id_role'] 	= $session_data['id_role'];
				$data['user'] = $this->user_model->get_user_by_username($data['username']);
				foreach($data['user'] as $row)
					$data['id_konsultan']=$row->id_user;
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
			 	
			$this->form_validation->set_rules('task_name', 'Task Name', 'required|max_length[50]');
			$this->form_validation->set_rules('deskripsi', 'Description', 'max_length[200]');
			$this->form_validation->set_rules('start_date', 'Start Date', 'required|date');
			$this->form_validation->set_rules('duration', 'Duration', 'required|numeric');
			$this->form_validation->set_rules('select_progress', 'Progress', 'required|numeric');
			
			$data['id_task']	= $this->input->post('id_task');
			$data['task_name']	= $this->input->post('task_name');
			$data['deskripsi']	= $this->input->post('deskripsi');
			$data['start_date']	= $this->input->post('start_date');
			$data['duration']	= $this->input->post('duration');
			$data['progress']	= $this->input->post('select_progress');
			$data['responsible']= $this->input->post('select_people');
							
			if($this->session->userdata('project_sess'))
			{
				$session_data = $this->session->userdata('project_sess');
				$data['nama'] = $session_data['nama'];
				$data['id_project'] = $session_data['id_project'];
			}
	
			if	($this->form_validation->run() == FALSE )
			{
				$data['people'] = $this->people_model->get_people_by($data['id_konsultan'], $data['id_project']);
				$this->load->view('edit_task',$data);
			}
			else
			{
				$this->task_model->edit_task($data['task_name'],$data['deskripsi'],$data['start_date'], $data['duration'],$data['id_project'], $data['responsible'], $data['progress'], $data['id_task']);
						
				$data['jml_task'] 	= $this->task_model->count_task($data['id_project']);
				$data['task'] 		= $this->task_model->get_task($data['id_project']);
				$this->load->view('task', $data);
			}
		}
		else
		{
			$this->load->view('index');
		}
	}
	
	function delete_task()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['tipe']		= $session_data['tipe'];
			if($session_data['tipe']=='konsultan')
			{
				$data['username'] 	= $session_data['username'];
				$data['id_role'] 	= $session_data['id_role'];
				$data['user'] = $this->user_model->get_user_by_username($data['username']);
				foreach($data['user'] as $row)
					$data['id_konsultan']=$row->id_user;
			}
			else if($session_data['tipe']=='tim')
			{
				$data['id_konsultan'] 	= $session_data['id_user'];
				$data['username'] 	= $session_data['username'];
				$data['id_people'] 	= $session_data['id_people'];
			
				
			}
			$data['id_task']	= $this->input->get('id');
							
			if($this->session->userdata('project_sess'))
			{
				$session_data = $this->session->userdata('project_sess');
				$data['nama'] = $session_data['nama'];
				$data['id_project'] = $session_data['id_project'];
			}
	
			
				$this->task_model->delete_task($data['id_task']);
						
				$data['jml_task'] 	= $this->task_model->count_task($data['id_project']);
				$data['task'] 		= $this->task_model->get_task($data['id_project']);
				$this->load->view('task', $data);
			
		}
		else
		{
			$this->load->view('index');
		}
	}
}
	