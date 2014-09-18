<?php if (! defined('BASEPATH')) exit('No direct script allowed');
session_start();

class people_ctrl extends CI_Controller {

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
		$this->load->model('people_model');
		$this->load->model('position_model');
		$this->load->model('hire_model');
	}
	
	function display_add_people()
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
				$data['id_konsultan']=$row->id_user;	
			}
			
			$this->load->view('add_people', $data);
		}
		else
		{
			$this->load->view('index');
		}
	}
	
	function add_people()
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
				$data_konsultan     = $this->user_model->get_user_by_id($data['id_user']);
				foreach($data_konsultan as $row)
					$data['username_konsultan']=$row->username;
				$data['user'] 		= $this->user_model->get_user_by_username($data['username_konsultan']);
				
			}
			 
			$this->form_validation->set_rules('people_name', 'Name', 'required|max_length[50]');
			$this->form_validation->set_rules('email', 'Email', 'required|max_length[50]');
			$this->form_validation->set_rules('tipe', 'Tipe', 'required');
			if($this->input->post('tipe')=='1')
			{
				$this->form_validation->set_rules('username2', 'Username', 'required|max_length[50]');
				$this->form_validation->set_rules('password', 'Password', 'required|max_length[50]');
				$this->form_validation->set_rules('select_position', 'Position', 'required');
			}
			
			$data['people_name']=$this->input->post('people_name');
			$data['email']		=$this->input->post('email');
			$data['tipe']		=$this->input->post('tipe');
			$data['username2']	=$this->input->post('username2');
			$data['password']	=$this->input->post('password');
			$data['id_position']=$this->input->post('select_position');
			
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
				$data['id_konsultan']=$row->id_user;	
			}
				
			if	($this->form_validation->run() == FALSE )
			{
				$this->load->view('add_people',$data);
			}
			else
			{
				$this->people_model->insert_people($data['people_name'],$data['email'],$data['tipe'],$data['username2'],$data['password'],$data['id_position'],$data['id_konsultan']);
				$id_people=$this->people_model->get_max_people_id();
				foreach($id_people as $row)
					$id=$row->id_people;
				$this->hire_model->insert_hire($id, $data['id_project']);
						
				foreach($data['user'] as $row)
				{
					$data['jml_position'] = $this->position_model->count_position($row->id_user);
					$data['position'] = $this->position_model->get_position_by($row->id_user);
					$data['jml_people'] = $this->people_model->count_people($row->id_user, $data['id_project']);
					$data['people'] = $this->people_model->get_people_by($row->id_user, $data['id_project']);
					$data['id_konsultan']=$row->id_user;	
				}
				$this->load->view('people', $data);
			}
		}
		else
		{
			$this->load->view('index');
		}
	}
	
	function delete_people()
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
				$data['id_konsultan']=$row->id_user;	
			}
				
			$data['id_people'] = $this->input->get('id');
			$this->people_model->delete_people($data['id_people']);
			
			$this->load->view('people', $data);
		}
		else
		{
			$this->load->view('index');
		}
	}
	
	function display_edit_people()
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
				$data['id_konsultan']=$row->id_user;	
			}
			$data['id_people'] = $this->input->get('id');
			$people=$this->people_model->get_people_by_id($data['id_people']);
			foreach($people as $row)
			{
				$data['people_name']= $row->nama;
				$data['email']		= $row->email;
				$data['tipe']		= $row->tipe;
				$data['username2']	= $row->username;
				$data['password']	= $row->password;
				$data['id_position']= $row->id_position;
				
			}
			$this->load->view('edit_people', $data);
		}
		else
		{
			$this->load->view('index');
		}
	}
	
	function edit_people()
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
				$data_konsultan     = $this->user_model->get_user_by_id($data['id_user']);
				foreach($data_konsultan as $row)
					$data['username_konsultan']=$row->username;
				$data['user'] 		= $this->user_model->get_user_by_username($data['username_konsultan']);
				
			}
			 
			$this->form_validation->set_rules('people_name', 'Name', 'required|max_length[50]');
			$this->form_validation->set_rules('email', 'Email', 'required|max_length[50]');
			$this->form_validation->set_rules('tipe', 'Tipe', 'required');
			if($this->input->post('tipe')=='1')
			{
				$this->form_validation->set_rules('username2', 'Username', 'required|max_length[50]');
				$this->form_validation->set_rules('password', 'Password', 'required|max_length[50]');
				$this->form_validation->set_rules('select_position', 'Position', 'required');
			}
			$data['id_people_edit']	= $this->input->post('id_people');
			$data['people_name']	= $this->input->post('people_name');
			$data['email']			= $this->input->post('email');
			$data['tipe']			= $this->input->post('tipe');
			$data['username2']		= $this->input->post('username2');
			$data['password']		= $this->input->post('password');
			$data['id_position']	= $this->input->post('select_position');
			
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
				$data['id_konsultan']=$row->id_user;	
			}
				
			if	($this->form_validation->run() == FALSE )
			{
				$this->load->view('edit_people',$data);
			}
			else
			{
				$this->people_model->edit_people($data['people_name'],$data['email'],$data['tipe'],$data['username2'],$data['password'],$data['id_position'],$data['id_konsultan'], $data['id_people_edit']);
				/*$id_people=$this->people_model->get_max_people_id();
				foreach($id_people as $row)
					$id=$row->id_people;
				$this->hire_model->insert_hire($id, $data['id_project']);*/
						
				foreach($data['user'] as $row)
				{
					$data['jml_position'] = $this->position_model->count_position($row->id_user);
					$data['position'] = $this->position_model->get_position_by($row->id_user);
					$data['jml_people'] = $this->people_model->count_people($row->id_user, $data['id_project']);
					$data['people'] = $this->people_model->get_people_by($row->id_user, $data['id_project']);
					$data['id_konsultan']=$row->id_user;	
				}
				$this->load->view('people', $data);
			}
		}
		else
		{
			$this->load->view('index');
		}
	}
}