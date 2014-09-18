<?php if (! defined('BASEPATH')) exit('No direct script allowed');
session_start();

class comment_ctrl extends CI_Controller {

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
		$this->load->model('comment_model');
	}
	
		
	function display_comment()
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
			
			$data['id_discussion']	= $this->input->get('id');
			$data['discussion']		= $this->discussion_model->get_discussion_by_id($data['id_discussion']);
			
			
			$data['jml_comment']	= $this->comment_model->count_comment($data['id_discussion']);
			$data['comment']		= $this->comment_model->get_comment($data['id_discussion']);
			
			$this->load->view('comment', $data);
		}
		else
		{
			$this->load->view('login', $data);
		}
	}
	
	function delete_comment()
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
			
			$data['id_discussion']	= $this->input->get('id_discussion');
			$data['id_comment']		= $this->input->get('id_comment');
			$data['discussion']		= $this->discussion_model->get_discussion_by_id($data['id_discussion']);
			
			$this->comment_model->delete_comment($data['id_comment']);
			$data['jml_comment']	= $this->comment_model->count_comment($data['id_discussion']);
			$data['comment']		= $this->comment_model->get_comment($data['id_discussion']);
			
			$this->load->view('comment', $data);
		}
		else
		{
			$this->load->view('login', $data);
		}
	}
	
	function add_comment()
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
			 
			
		
			$this->form_validation->set_rules('komentar', 'Comment', 'required|max_length[300]');
			
			$data['id_discussion']	= $this->input->post('id_discussion');
			$data['isi']		= $this->input->post('komentar');	
			$data['posted_by']		=$data['id_people'];

			$data['discussion']		= $this->discussion_model->get_discussion_by_id($data['id_discussion']);
							
			if($this->session->userdata('project_sess'))
			{
				$session_data = $this->session->userdata('project_sess');
				$data['nama'] = $session_data['nama'];
				$data['id_project'] = $session_data['id_project'];
			}
	
			if	($this->form_validation->run() == FALSE )
			{
				$data['jml_comment']	= $this->comment_model->count_comment($data['id_discussion']);
				$data['comment']		= $this->comment_model->get_comment($data['id_discussion']);
				$this->load->view('comment',$data);
			}
			else
			{
				$tz_object = new DateTimeZone('Asia/Jakarta');
				$datetime = new DateTime();
				$datetime->setTimezone($tz_object);
				$data['posted_date']= $datetime->format('Y\-m\-d\ h:i:s');
				
				$this->comment_model->insert_comment($data['isi'],$data['posted_by'], $data['posted_date'],$data['id_discussion']);
						
				$data['jml_comment']	= $this->comment_model->count_comment($data['id_discussion']);
				$data['comment']		= $this->comment_model->get_comment($data['id_discussion']);
				$this->load->view('comment', $data);
			}
		}
		else
		{
			$this->load->view('login');
		}
	}
}