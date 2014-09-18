<?php if (! defined('BASEPATH')) exit('No direct script allowed');
session_start();

class position_ctrl extends CI_Controller {

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
	}
	
	function display_add_position()
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
			
			$this->load->view('add_position', $data);
		}
		else
		{
			$this->load->view('index');
		}
	}
	
	function add_position()
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
			 
			$this->form_validation->set_rules('position_name', 'Position Name', 'required|max_length[50]');
			$this->form_validation->set_rules('deskripsi', 'Job Description', 'max_length[200]');
			
			
			$data['position_name']=$this->input->post('position_name');
			$data['deskripsi']=$this->input->post('deskripsi');
						
							
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
				
				$this->load->view('add_position',$data);
			}
			else
			{
				$this->position_model->insert_position($data['position_name'],$data['deskripsi'],$data['id_konsultan']);
						
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
	
	function display_edit_position()
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
			$data['id_position'] = $this->input->get('id');
			$data['position']    = $this->position_model->get_position_by_id($data['id_position']);
			foreach($data['position'] as $row)
			{
				$data['position_name'] = $row->position;
				$data['deskripsi']	   = $row->deskripsi; 
				
			}

			$this->load->view('edit_position', $data);
		}
		else
		{
			$this->load->view('index');
		}
	}
	
	function edit_position()
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
			 
			$this->form_validation->set_rules('position_name', 'Position Name', 'required|max_length[50]');
			$this->form_validation->set_rules('deskripsi', 'Job Description', 'max_length[200]');
			
			$data['position_name']=$this->input->post('position_name');
			$data['deskripsi']=$this->input->post('deskripsi');
			$data['id_position']=$this->input->post('id_position');			
							
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
				
				$this->load->view('edit_position',$data);
			}
			else
			{
				$this->position_model->update_position($data['position_name'],$data['deskripsi'],$data['id_konsultan'], $data['id_position']);
						
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
	
	function delete_position()
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
				
			$data['id_position'] = $this->input->get('id');
			$this->position_model->delete_position($data['id_position']);
			$this->people_model->delete_people_that_position($data['id_position'], $data['id_konsultan'], $data['id_project']);
			
			foreach($data['user'] as $row)
			{
				$data['jml_position'] = $this->position_model->count_position($row->id_user);
				$data['position'] = $this->position_model->get_position_by($row->id_user);
				$data['jml_people'] = $this->people_model->count_people($row->id_user, $data['id_project']);
				$data['people'] = $this->people_model->get_people_by($row->id_user, $data['id_project']);	
			}
			
			$this->load->view('people', $data);
		}
		else
		{
			$this->load->view('index');
		}
	}
}