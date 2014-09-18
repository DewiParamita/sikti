<?php if (! defined('BASEPATH')) exit('No direct script allowed');
session_start();

class user_ctrl extends CI_Controller {

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

	function index()
	{
		$data['username']='';				
		$this->load->view('index', $data);
	}
	 
	function logout()
	{
		$this->session->unset_userdata('logged_in');
		session_destroy();
		redirect('display', 'refresh');
	}
	
	function login()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'required');
	    $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');
	    $data['message']='';
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
		}
		else
		{
			$data['username'] = '';
		}	
		if($this->form_validation->run() == FALSE)
		{
			//Field validation failed.&nbsp; User redirected to login page
			$this->load->view('login',$data);
		}
		else
		{
			//Go to private area
			redirect('display', 'refresh');
		}
	}
	
	function check_database($password)
	{
		//Field validation succeeded.  Validate against database
		$username = $this->input->post('username');

		$result = $this->user_model->login($username, $password);

		if($result)
		{		
			$sess_array = array();
			foreach($result as $row)
			{
				$sess_array = array(
					'tipe'		=> 'konsultan',
					'id_user' 	=> $row->id_user,
					'username' 	=> $row->username,
					'id_role' 	=> $row->id_role
				);
				$this->session->set_userdata('logged_in', $sess_array);
			}
			return TRUE;
		}
		else
		{	
			
			$result2 = $this->people_model->login($username, $password);
			if($result2)
			{		
				$sess_array = array();
				foreach($result2 as $row)
				{
					$sess_array = array(
						'tipe'		=> 'tim',
						'id_user' 	=> $row->id_konsultan,
						'username' 	=> $row->username,
						'id_people' => $row->id_people
					);
					$this->session->set_userdata('logged_in', $sess_array);
				}
				return TRUE;
			}
			else
			{
				$this->form_validation->set_message('check_database', 'Invalid username or password');
				return false;
			}
		}
	}
	
	function add_user()
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
		
		$this->form_validation->set_rules('role', 'Register as', 'required');
		$this->form_validation->set_rules('nama', 'Company Name', 'required|max_length[50]');
		$this->form_validation->set_rules('kategori', 'Category', 'max_length[100]');
		$this->form_validation->set_rules('alamat', 'Address', 'required|max_length[300]');
		$this->form_validation->set_rules('phone', 'Phone Number', 'required|max_length[20]');
		$this->form_validation->set_rules('email', 'Email', 'required|max_length[50]');
		$this->form_validation->set_rules('website', 'Website', 'max_length[100]');
		$this->form_validation->set_rules('username', 'Username', 'required|max_length[50]');
		$this->form_validation->set_rules('password', 'Password', 'required|max_length[30]');
		$this->form_validation->set_rules('password2', 'Confirm Password', 'required|max_length[30]');
		$this->form_validation->set_rules('captcha', 'Captcha', 'required');
		
		$data['role'] = $this->input->post('role');
		$data['nama'] = $this->input->post('nama');
		$data['kategori'] = $this->input->post('kategori');
		$data['alamat'] = $this->input->post('alamat');
		$data['phone'] = $this->input->post('phone');
		$data['email'] = $this->input->post('email');
		$data['website'] = $this->input->post('website');
		//$data['photo']=array();
		//$data['photo'] = $_FILES['userfile'];
		$data['username'] = $this->input->post('username');
		$data['password'] = $this->input->post('password');
		$data['password2'] = $this->input->post('password2');
				
		if	($this->form_validation->run() == FALSE || $data['role']=='')
		{
			$data['image']=$this->get_new_captcha();
			$this->load->view('register',$data);
		}
		else
		{
			if($data['password']!=$data['password2'])
			{
				$data['message']='Confirm Password must be same as Password';
				$data['password2']='';
				$data['image']=$this->get_new_captcha();
				$this->load->view('register',$data);
			}
			else if($this->user_model->is_unik($data['username'])!=0)
			{
				$data['message']='Username is not available';
				$data['image']=$this->get_new_captcha();
				$this->load->view('register',$data);
			}
			else if ($this->input->post('captcha') != $this->session->userdata('mycaptcha'))
			{	
				$data['message']='Your captcha answer is wrong';
				$data['image']=$this->get_new_captcha();
				$this->load->view('register',$data);
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
				$this->user_model->insert_user($data['role'],$data['nama'],$data['kategori'],$data['alamat'],$data['phone'],$data['email'],$data['website'],$data['photo'],$data['username'],$data['password']);
				$this->load->view('index',$data);
			}
		}
	}
	
	function get_new_captcha()
	{
		//Untuk menampilkan captcha
		// load the session library
		$this->load->library('session');
		$this->load->helper(array('captcha','url'));
 
        // if form was submitted and given captcha word matches one in session
        /*if ($this->input->post() && ($this->input->post('secutity_code') == $this->session->userdata('mycaptcha'))) {
			$this->load->view('berhasil.php');
        }
		else
		{*/
            // load codeigniter captcha helper
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
 
            // create captcha image
            $cap = create_captcha($vals);
 
            // store image html code in a variable
            $data['image'] = $cap['image'];
 
            // store the captcha word in a session
            $this->session->set_userdata('mycaptcha', $cap['word']);
			
            return $data['image'];
 
       // }
	}
	
	function reload_captcha()
	{
		$this->load->library('session');
		$this->load->helper(array('captcha','url'));
 
        $this->load->helper('captcha');
 
		$data['role'] = $this->input->post('role');
		$data['nama'] = $this->input->post('nama');
		$data['kategori'] = $this->input->post('kategori');
		$data['alamat'] = $this->input->post('alamat');
		$data['phone'] = $this->input->post('phone');
		$data['email'] = $this->input->post('email');
		$data['website'] = $this->input->post('website');
		$data['username'] = $this->input->post('username');
		$data['password'] = $this->input->post('password');
		$data['password2'] = $this->input->post('password2');
            
		$vals = array(
			'word'       => strtoupper(substr(md5(time()), 0, 6)),
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
        $this->load->view('register',$data);
	}
	
	function reset_password()
	{
		$data['base_url'] = $this->config->item('base_url');
		$data['username'] = '';
		$data['message']='';
		
		if($this->session->userdata('logged_in'))
	    {
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['id_role'] = $session_data['id_role'];
	    }
	    else
	    {
			$data['username']='';
		}
		
		$this->form_validation->set_rules('input', 'Email or Username', 'required|max_length[50]');
		$data['input'] = $this->input->post('input');
		if($this->user_model->check_email_username($data['input'])==1)
		{
			$email_address=$this->user_model->get_email($data['input']);
			foreach($email_address as $rows)
				$email_add=$rows->email;
			$this->user_model->reset_password($email_add);
			
			$config = array(
				  'protocol' => 'smtp',
				  'smtp_host' => 'ssl://smtp.googlemail.com',
				  'smtp_port' => 465,
				  'smtp_user' => 'sikti.website@gmail.com', //isi alamat email
				  'smtp_pass' => 'sikti1234'//ganti passwordnya
			);
			 
			$this->load->library('email',$config);    
			$this->email->set_newline("\r\n");
				
			//$email = $rows->email;
			$this->email->from('sikti.website@gmail.com', 'Reset Password');
			$this->email->to($email_add);
			$this->email->subject('Sikti - Reset Password');
			$this->email->message('Your Password has been reset into "12345"');
			$this->email->send();
			
			$data['message']='Your password has been reset. The information have been sented to your email address.';
			$this->load->view('forgot_password', $data);
		}
		else
		{
			$data['message']='Email or username is invalid.';
			$this->load->view('forgot_password', $data);
		}
	}
	
	function search_client()
	{	
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
			 
			$data['keyword']=$this->input->post('search'); 
			if($data['keyword']=='')
			{
				$data['count_consultant'] = $this->user_model->count_consultant();
				$data['consultant'] = $this->user_model->get_consultant();
						
				$data['count_company'] = $this->user_model->count_customer();
				$data['company'] = $this->user_model->get_customer();
			}
			else
			{
				$data['count_consultant'] = $this->user_model->count_search_consultant($data['keyword']);
				$data['consultant'] = $this->user_model->search_consultant($data['keyword']);
							
				$data['count_company'] = $this->user_model->count_search_customer($data['keyword']);
				$data['company'] = $this->user_model->search_customer($data['keyword']);		
			}
			$this->load->view('client_list', $data);
		}
		else
		{
			$data['keyword']=$this->input->post('search'); 
			if($data['keyword']=='')
			{
				$data['count_consultant'] = $this->user_model->count_consultant();
				$data['consultant'] = $this->user_model->get_consultant();
						
				$data['count_company'] = $this->user_model->count_customer();
				$data['company'] = $this->user_model->get_customer();
			}
			else
			{
				$data['count_consultant'] = $this->user_model->count_search_consultant($data['keyword']);
				$data['consultant'] = $this->user_model->search_consultant($data['keyword']);
							
				$data['count_company'] = $this->user_model->count_search_customer($data['keyword']);
				$data['company'] = $this->user_model->search_customer($data['keyword']);		
			}
			
			$this->load->view('client_list', $data);
		}
	}
}