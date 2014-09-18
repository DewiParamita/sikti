<?php if (! defined('BASEPATH')) exit('No direct script allowed');
session_start();

class offers_ctrl extends CI_Controller {

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
		$this->load->model('offers_model');
	}
	
	function display_add_offers()
	{
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
			 
			if($this->session->userdata('project_sess'))
			{
				$session_data = $this->session->userdata('project_sess');
				$data['nama'] = $session_data['nama'];
				$data['id_project'] = $session_data['id_project'];
			}
			$this->load->view('add_project_offers', $data);
		}
		else
		{
			$this->load->view('login');
		}
	}
	
	
	function add_offers()
	{
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
			 
			if($this->session->userdata('project_sess'))
			{
				$session_data = $this->session->userdata('project_sess');
				$data['nama'] = $session_data['nama'];
				$data['id_project'] = $session_data['id_project'];
			}
				
			$this->form_validation->set_rules('project_name', 'Project Name', 'required|max_length[50]');
			$this->form_validation->set_rules('deskripsi', 'Description', 'max_length[200]');
			$this->form_validation->set_rules('start_date', 'Start Date', 'required|date');
			$this->form_validation->set_rules('duration', 'Duration', 'required|numeric');
			$this->form_validation->set_rules('budget', 'Budget', 'required|numeric');
							
			$data['project_name'] =$this->input->post('project_name');
			$data['deskripsi']	=$this->input->post('deskripsi');
			$data['start_date']	=$this->input->post('start_date');
			$data['duration']	=$this->input->post('duration');
			$data['budget']		=$this->input->post('budget');

			if	($this->form_validation->run() == FALSE )
			{				
				$this->load->view('add_project_offers',$data);
			}
			else
			{
				$tz_object = new DateTimeZone('Asia/Jakarta');
				$datetime = new DateTime();
				$datetime->setTimezone($tz_object);
				$data['posted_date']= $datetime->format('Y\-m\-d\ h:i:s');
				
				$this->offers_model->insert_offers($data['project_name'],$data['deskripsi'],$data['start_date'],$data['duration'],$data['budget'],$data['posted_date'],$data['id_user']);
				$data['jml_offers']	= $this->offers_model->count_offers();
				$data['offers'] 	= $this->offers_model->get_offers();
				
				$data['jml_consultant']	= $this->offers_model->count_consultant();
				$data['consultant'] 	= $this->offers_model->get_consultant();
				
				$data['jml_customer']	= $this->offers_model->count_customer();
				$data['customer'] 		= $this->offers_model->get_customer();	
				$this->load->view('projects_offers', $data);
			}
		}
		else
		{
			$this->load->view('login');
		}
	}
	
	function delete_offers()
	{
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
			
			$data['id_offers'] = $this->input->get('id');
			$this->offers_model->delete_offers($data['id_offers']);
			
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
			$this->load->view('login');
		}
	}
	
	function edit_offers()
	{
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
			 
			if($this->session->userdata('project_sess'))
			{
				$session_data = $this->session->userdata('project_sess');
				$data['nama'] = $session_data['nama'];
				$data['id_project'] = $session_data['id_project'];
			}
							
			$data['select'] =$this->input->post('select_consultant');
			$data['id_offers'] =$this->input->post('id_offers');
			
			if	($data['select']=='')
			{			
				$data['jml_offers']	= $this->offers_model->count_offers();
				$data['offers'] 	= $this->offers_model->get_offers();
				
				$data['jml_consultant']	= $this->offers_model->count_consultant();
				$data['consultant'] 	= $this->offers_model->get_consultant();
				
				$data['jml_customer']	= $this->offers_model->count_customer();
				$data['customer'] 		= $this->offers_model->get_customer();	
				$this->load->view('projects_offers',$data);
			}
			else
			{
				$offers = $this->offers_model->get_offers_by_id($data['id_offers']);
				foreach($offers as $rows)
				{
					$data['project_name'] 	= $rows->nama;
					$data['deskripsi']		= $rows->deskripsi;
					$data['start_date']		= $rows->start_date;
					$data['duration']		= $rows->duration;
					$data['id_customer']	= $rows->id_company;
					$data['id_consultant']	= $data['select'];
				}	
				
				$this->project_model->insert_project($data['project_name'],$data['deskripsi'],$data['start_date'],$data['duration'],$data['id_consultant'],$data['id_customer']);
				$this->offers_model->delete_offers($data['id_offers']);
				
				$data['jml_offers']	= $this->offers_model->count_offers();
				$data['offers'] 	= $this->offers_model->get_offers();
				
				$data['jml_consultant']	= $this->offers_model->count_consultant();
				$data['consultant'] 	= $this->offers_model->get_consultant();
				
				$data['jml_customer']	= $this->offers_model->count_customer();
				$data['customer'] 		= $this->offers_model->get_customer();	
				$this->load->view('projects_offers', $data);
			}
		}
		else
		{
			$this->load->view('login');
		}
	}
}