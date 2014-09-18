<?php if (! defined('BASEPATH')) exit('No direct script allowed');
session_start();

class project_ctrl extends CI_Controller {

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
	}
	
	function display_add_project()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			
			if($session_data['tipe']=='konsultan')
			{
				$data['username'] 	= $session_data['username'];
				$data['id_role'] 	= $session_data['id_role'];
				$data['user'] = $this->user_model->get_user_by_username($data['username']);
				$data['client'] = $this->user_model->get_user_except($data['username']);
			}
			else if($session_data['tipe']=='tim')
			{
				$data['id_user'] 	= $session_data['id_user']; //id_konsultan
				$data['username'] 	= $session_data['username'];
				$data['id_people'] 	= $session_data['id_people'];
				$data['user'] = $this->people_model->get_user_by_username($data['username']);
				$data['data_konsultan'] = $this->user_model->get_user_by_id($data['id_user']);
				foreach($data['data_konsultan'] as $row)
					$data['username_konsultan']=$row->username;
				$data['client'] = $this->user_model->get_user_except($data['username_konsultan']);
			}
			 
			if($this->session->userdata('project_sess'))
			{
				$session_data = $this->session->userdata('project_sess');
				$data['nama'] = $session_data['nama'];
				$data['id_project'] = $session_data['id_project'];
			}
			$this->load->view('add_project', $data);
		}
		else
		{
			$this->load->view('login');
		}
	}
	
	function add_project()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			if($session_data['tipe']=='konsultan')
			{
				$data['username'] 	= $session_data['username'];
				$data['id_role'] 	= $session_data['id_role'];
				$data['user'] = $this->user_model->get_user_by_username($data['username']);
				$data['client'] = $this->user_model->get_user_except($data['username']);
				foreach($data['user'] as $row)
					$data['id_konsultan']=$row->id_user;
			}
			else if($session_data['tipe']=='tim')
			{
				$data['id_konsultan'] 	= $session_data['id_user']; //id_konsultan
				$data['username'] 	= $session_data['username'];
				$data['id_people'] 	= $session_data['id_people'];
				$data['user'] = $this->people_model->get_user_by_username($data['username']);
				$data['data_konsultan'] = $this->user_model->get_user_by_id($data['id_user']);
				foreach($data['data_konsultan'] as $row)
					$data['username_konsultan']=$row->username;
				$data['client'] = $this->user_model->get_user_except($data['username_konsultan']);
			}
			 
			$this->form_validation->set_rules('project_name', 'Project Name', 'required|max_length[50]');
			$this->form_validation->set_rules('deskripsi', 'Description', 'max_length[200]');
			$this->form_validation->set_rules('start_date', 'Start Date', 'required|date');
			$this->form_validation->set_rules('duration', 'Duration', 'required|numeric');
			$this->form_validation->set_rules('project_for', 'Radio Button Client', 'required');
			if($this->input->post('project_for')=='Yes')
			{
				$this->form_validation->set_rules('select_client', 'Client', 'required');
			}
				
			$data['nama']=$this->input->post('project_name');
			$data['deskripsi']=$this->input->post('deskripsi');
			$data['start_date']=$this->input->post('start_date');
			$data['duration']=$this->input->post('duration');
			$data['project_for']=$this->input->post('project_for');

			if($data['project_for']=='Yes')
			{
				$this->form_validation->set_rules('select_client', 'Client', 'required');
				$data['id_customer']=$this->input->post('select_client');
			}
			else if($data['project_for']=='No')
			{
				$data['id_customer']=$data['id_konsultan'];
			}
			
			if	($this->form_validation->run() == FALSE )
			{
				if($this->session->userdata('project_sess'))
				{
					$session_data = $this->session->userdata('project_sess');
					$data['nama'] = $session_data['nama'];
					$data['id_project'] = $session_data['id_project'];
				}
				$this->load->view('add_project',$data);
			}
			else
			{
				$this->project_model->insert_project($data['nama'],$data['deskripsi'],$data['start_date'],$data['duration'],$data['id_konsultan'],$data['id_customer']);
				$data['user'] = $this->user_model->get_user_by_username($data['username']);
			
				if($session_data['tipe']=='konsultan')
				{
					foreach($data['user'] as $row)
					{
						$data['jml_project'] = $this->project_model->count_project($row->id_user);
						$data['project'] = $this->project_model->get_project($row->id_user);
			
					}
				}
				else if($session_data['tipe']=='tim')
				{
					$data['jml_project']= $this->project_model->count_project_by_people($data['id_people'] );
					$data['project'] 	= $this->project_model->get_project_by_people($data['id_people'] );
					
				}
				$this->load->view('project', $data);
			}
		}
		else
		{
			$this->load->view('login');
		}
	}
	
	function display_edit_project()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			if($session_data['tipe']=='konsultan')
			{
				$data['username'] 	= $session_data['username'];
				$data['id_role'] 	= $session_data['id_role'];
				$data['user'] = $this->user_model->get_user_by_username($data['username']);
				foreach($data['user'] as $row)
					$data['id_konsultan']=$row->id_user;
				$data['client'] = $this->user_model->get_user_except($data['username']);
			}
			else if($session_data['tipe']=='tim')
			{
				$data['id_konsultan'] 	= $session_data['id_user'];
				$data['username'] 	= $session_data['username'];
				$data['id_people'] 	= $session_data['id_people'];
				$data['user'] = $this->people_model->get_user_by_username($data['username']);
				
				$data['data_konsultan'] = $this->user_model->get_user_by_id($data['id_konsultan']);
				foreach($data['data_konsultan'] as $row)
					$data['username_konsultan']=$row->username;
				$data['client'] = $this->user_model->get_user_except($data['username_konsultan']);
			}
			 
			
			$data['id_project'] = $this->input->get('id');
			$project = $this->project_model->get_project_by($data['id_project']);
			foreach($project as $rows)
			{
				$data['nama']		= $rows->nama;
				$data['deskripsi']	= $rows->deskripsi;
				$data['start_date']	= $rows->start_date;
				$data['duration']	= $rows->duration;
				$data['id_customer']= $rows->id_customer;
				$data['client'] 	= $this->user_model->get_user_except($data['username']);
			}
			if($data['id_customer'] == $data['id_konsultan'])
				$data['project_for'] = 'No';
			else
				$data['project_for'] = 'Yes';
				
			$this->load->view('edit_project', $data);
		}
		else
		{
			$this->load->view('login');
		}
	}
	
	function edit_project()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			if($session_data['tipe']=='konsultan')
			{
				$data['username'] 	= $session_data['username'];
				$data['id_role'] 	= $session_data['id_role'];
				$data['user'] = $this->user_model->get_user_by_username($data['username']);
				foreach($data['user'] as $row)
					$data['id_konsultan']=$row->id_user;
				$data['client'] = $this->user_model->get_user_except($data['username']);
			}
			else if($session_data['tipe']=='tim')
			{
				$data['id_konsultan'] 	= $session_data['id_user'];
				$data['username'] 	= $session_data['username'];
				$data['id_people'] 	= $session_data['id_people'];
				$data['user'] = $this->people_model->get_user_by_username($data['username']);
				
				$data['data_konsultan'] = $this->user_model->get_user_by_id($data['id_user']);
				foreach($data['data_konsultan'] as $row)
					$data['username_konsultan']=$row->username;
				$data['client'] = $this->user_model->get_user_except($data['username_konsultan']);
			}
			 
			$this->form_validation->set_rules('nama', 'Project Name', 'required|max_length[50]');
			$this->form_validation->set_rules('deskripsi', 'Description', 'max_length[200]');
			$this->form_validation->set_rules('start_date', 'Start Date', 'required|date');
			$this->form_validation->set_rules('duration', 'Duration', 'required|numeric');
			$this->form_validation->set_rules('project_for', 'Radio Button Client', 'required');
			if($this->input->post('project_for')=='1')
			{
				$this->form_validation->set_rules('select_client', 'Client', 'required');
			}
				
			$data['id_project']=$this->input->post('id_project');
			$data['nama']=$this->input->post('nama');
			$data['deskripsi']=$this->input->post('deskripsi');
			$data['start_date']=$this->input->post('start_date');
			$data['duration']=$this->input->post('duration');
			$data['project_for']=$this->input->post('project_for');

				
			if($data['project_for']=='Yes')
			{
				$this->form_validation->set_rules('select_client', 'Client', 'required');
				$data['id_customer']=$this->input->post('select_client');
			}
			else if($data['project_for']=='No')
			{
				$data['id_customer']=$data['id_konsultan'];
			}
			
			if	($this->form_validation->run() == FALSE )
			{
				
				$this->load->view('edit_project',$data);
			}
			else
			{
				$this->project_model->update_project($data['id_project'],$data['nama'],$data['deskripsi'],$data['start_date'],$data['duration'],$data['id_konsultan'],$data['id_customer']);
				$data['user'] = $this->user_model->get_user_by_username($data['username']);
			
				if($session_data['tipe']=='konsultan')
				{
					foreach($data['user'] as $row)
					{
						$data['jml_project'] = $this->project_model->count_project($row->id_user);
						$data['project'] = $this->project_model->get_project($row->id_user);
			
					}
				}
				else if($session_data['tipe']=='tim')
				{
					$data['jml_project']= $this->project_model->count_project_by_people($data['id_people'] );
					$data['project'] 	= $this->project_model->get_project_by_people($data['id_people'] );
					
				}
				$this->load->view('project', $data);
			}
		}
		else
		{
			$this->load->view('login');
		}
	}
	
	function detil_project()
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
				$data['id_konsultan'] 	= $session_data['id_user'];
				$data['username'] 	= $session_data['username'];
				$data['id_people'] 	= $session_data['id_people'];
				$data['user'] = $this->people_model->get_user_by_username($data['username']);
			}
	
			
			$data['id_project']=$this->input->get('id');
			$project = $this->project_model->get_project_by($data['id_project']);
			foreach($project as $rows)
			{
				$data['nama']		= $rows->nama;
				$data['deskripsi']	= $rows->deskripsi;
				$data['start_date']	= $rows->start_date;
				$data['duration']	= $rows->duration;
				$data['customer']	= $this->user_model->get_user_by_id($rows->id_customer);
				$data['id_konsultan']= $rows->id_konsultan;
			}
			
			$sess_array = array();
			$sess_array = array(
				'nama' => $data['nama'],
				'id_project' => $data['id_project']
			);
			$this->session->set_userdata('project_sess', $sess_array);
			
			
			$this->load->view('detil_project', $data);
		}
		else
		{
			$this->load->view('login');
		}
	}
	
	function delete_project()
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
				$data['id_konsultan'] 	= $session_data['id_user'];
				$data['username'] 	= $session_data['username'];
				$data['id_people'] 	= $session_data['id_people'];
				$data['user'] = $this->people_model->get_user_by_username($data['username']);

			}
			
			$data['id_project'] = $this->input->get('id');
			$this->project_model->delete_project($data['id_project']);
			
			if($session_data['tipe']=='konsultan')
			{
				foreach($data['user'] as $row)
				{
					$data['jml_project'] = $this->project_model->count_project($row->id_user);
					$data['project'] = $this->project_model->get_project($row->id_user);
				}
			}
			else if($session_data['tipe']=='tim')
			{
				$data['jml_project']= $this->project_model->count_project_by_people($data['id_people'] );
				$data['project'] 	= $this->project_model->get_project_by_people($data['id_people'] );
					
			}
			
			$this->load->view('project', $data);
		}
		else
		{
			$this->load->view('login');
		}
	}
	
	function display_add_company()
	{
		$data['message']='';
		if($this->session->userdata('logged_in'))
		{
			if($session_data['tipe']=='konsultan')
			{
				$data['username'] 	= $session_data['username'];
				$data['id_role'] 	= $session_data['id_role'];
				$data['user'] = $this->user_model->get_user_by_username($data['username']);

			}
			else if($session_data['tipe']=='tim')
			{
				$data['id_konsultan'] 	= $session_data['id_user'];
				$data['username'] 	= $session_data['username'];
				$data['id_people'] 	= $session_data['id_people'];
				$data['user'] = $this->people_model->get_user_by_username($data['username']);

			}
		}
		
		if($this->session->userdata('project_sess'))
		{
			$session_data 		= $this->session->userdata('project_sess');
			$data['nama'] 		= $session_data['nama'];
			$data['id_project'] = $session_data['id_project'];
		}
		
		/*$data['project_name']= $this->input->post('project_name');
		$data['deskripsi']	= $this->input->post('deskripsi');
		$data['start_date']	= $this->input->post('start_date');
		$data['duration']	= $this->input->post('duration');
		$data['project_for']= $this->input->post('project_for');
		$data['client'] 	= $this->user_model->get_user_except($data['username']); //untuk dropdown client
		
		$sess_array = array(
			'project_name' 	=> $data['project_name'],
			'deskripsi' 	=> $data['deskripsi'],
			'start_date' 	=> $data['start_date'],
			'duration' 		=> $data['duration'],
			'project_for' 	=> $data['project_for'],
			'client' 		=> $data['client'],
		);
		$this->session->set_userdata('new_project', $sess_array);*/
        $this->load->view('add_company', $data);
	}
	
	function add_company()
	{
		$data['base_url'] = $this->config->item('base_url');
		$data['username'] = '';
		$data['message']='';
		
		if($this->session->userdata('logged_in'))
	    {
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
	    }
	    else
	    {
			$data['username']='';
		}
		
		$this->form_validation->set_rules('company_name', 'Company Name', 'required|max_length[50]');
		$this->form_validation->set_rules('kategori', 'Category', 'max_length[100]');
		$this->form_validation->set_rules('alamat', 'Address', 'required|max_length[300]');
		$this->form_validation->set_rules('phone', 'Phone Number', 'required|max_length[20]');
		$this->form_validation->set_rules('email', 'Email', 'required|max_length[50]');
		$this->form_validation->set_rules('website', 'Website', 'max_length[100]');
		$this->form_validation->set_rules('company_username', 'Username', 'required|max_length[50]');
		$this->form_validation->set_rules('password', 'Password', 'required|max_length[30]');

		
		$data['role'] = '2';
		$data['company_name'] = $this->input->post('company_name');
		$data['kategori'] = $this->input->post('kategori');
		$data['alamat'] = $this->input->post('alamat');
		$data['phone'] = $this->input->post('phone');
		$data['email'] = $this->input->post('email');
		$data['website'] = $this->input->post('website');
		$data['company_username'] = $this->input->post('company_username');
		$data['password'] = $this->input->post('password');

		if($this->session->userdata('project_sess'))
		{
			$session_data = $this->session->userdata('project_sess');
			$data['nama'] = $session_data['nama'];
			$data['id_project'] = $session_data['id_project'];
		}
			
		if	($this->form_validation->run() == FALSE)
		{
			$this->load->view('add_company',$data);
		}
		else
		{
			if($this->user_model->is_unik($data['company_username'])!=0)
			{
				$data['message']='Username is not available';
				$this->load->view('add_company',$data);
			}
			else
			{
				$config['upload_path'] = 'C:\xampp\htdocs\sikti\photo';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_size'] = '1024';
				$config['max_width'] = '1920';
				$config['max_height'] = '1280';
				$this->load->library('upload', $config);
				$this->upload->do_upload();
				$dataFoto = $this->upload->data();
				$data['photo']= element('full_path',$dataFoto);
				
				if($data['photo']=='C:/xampp/htdocs/sikti/photo/')
				{
					$data['photo']='';
				}
				$this->user_model->insert_user($data['role'],$data['company_name'],$data['kategori'],$data['alamat'],$data['phone'],$data['email'],$data['website'],$data['photo'],$data['company_username'],$data['password']);
				
				/*if($this->session->userdata('new_project'))
				{
					$session_data = $this->session->userdata('new_project');
					$data['project_name'] 	= $session_data['project_name'];
					$data['deskripsi'] 		= $session_data['deskripsi'];
					$data['start_date'] 	= $session_data['start_date'];
					$data['duration'] 		= $session_data['duration'];
					$data['project_for'] 	= $session_data['project_for'];
					$data['client'] 		= $session_data['client'];			
				}*/
				$data['client'] 	= $this->user_model->get_user_except($data['username']);
				
				$this->load->view('add_project',$data);
			}
		}
	}
}
	