<?php
Class people_model extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function get_people_by($id_konsultan, $id_project)
	{
		$this -> db -> select();
		$this -> db -> from('tbl_people');
		$this -> db -> join('tbl_hire', 'tbl_hire.id_people = tbl_people.id_people');
		$this -> db -> where('id_konsultan', $id_konsultan);
		$this -> db -> where('id_project', $id_project);
		
		$query = $this->db->get();
		
		return $query->result();
	}
	
	function count_people($id_konsultan, $id_project)
	{
		$this -> db -> select();
		$this -> db -> from('tbl_people');
		$this -> db -> join('tbl_hire', 'tbl_hire.id_people = tbl_people.id_people');
		$this -> db -> where('id_konsultan', $id_konsultan);
		$this -> db -> where('id_project', $id_project);
		
		$query = $this -> db -> get();

		return $query -> num_rows();
	}
	
	function delete_people_that_position($id_position, $id_konsultan, $id_project)
	{
		$this->db->where('id_position',$id_position);
		$this->db->where('id_konsultan',$id_konsultan);
		//$this->db->where('id_project',$id_project);
		$this->db->delete('tbl_people');
	}
	
	function insert_people($nama,$email,$tipe, $username, $password, $id_position, $id_konsultan)
	{
		$people = array(
			'nama'			=> $nama,
			'email'			=> $email,
			'tipe'			=> $tipe,
			'username'		=> $username,
			'password'		=> MD5($password),
			'id_position'	=> $id_position,
			'id_konsultan'	=> $id_konsultan
		);
		$this->db->insert('tbl_people', $people);
	}
	
	function get_people_by_position($id_konsultan, $id_project, $id_position)
	{
		$this -> db -> select();
		$this -> db -> from('tbl_people');
		$this -> db -> join('tbl_hire', 'tbl_hire.id_people = tbl_people.id_people');
		$this -> db -> where('id_konsultan', $id_konsultan);
		$this -> db -> where('id_project', $id_project);
		$this -> db -> where('id_position', $id_position);
		
		$query = $this->db->get();
		
		return $query->result();
	}
	
	function delete_people($id_people)
	{
		$this->db->where('id_people',$id_people);
		$this->db->delete('tbl_people');
	}
	
	function get_people_by_id($id_people)
	{
		$this -> db -> select();
		$this -> db -> from('tbl_people');
		$this -> db -> where('id_people', $id_people);
		
		$query = $this->db->get();
		
		return $query->result();
	}
	
	////////untuk login/////////////
	function get_max_people_id()
	{
		$this -> db -> select_max('id_people');
		$this -> db -> from('tbl_people');
		
		$query = $this->db->get();
		
		return $query->result();
	}
	
	function login($username, $password)
	{
		$this -> db -> select();
		$this -> db -> from('tbl_people');
		$this -> db -> where('tipe', '1');
		$this -> db -> where('username', $username);
		$this -> db -> where('password', MD5($password));
		$this -> db -> limit(1);

		$query = $this -> db -> get();

		if($query -> num_rows() == 1)
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}
	
	function get_user_by_username($username)
	{
		$this->db->select();
		$this->db->from('tbl_people');
		$this->db->where('username',$username);
		
		$query = $this->db->get();
		
		return $query->result();
	}
	
	function edit_people($nama,$email,$tipe, $username, $password, $id_position, $id_konsultan, $id_people)
	{
		$people = array(
			'nama'			=> $nama,
			'email'			=> $email,
			'tipe'			=> $tipe,
			'username'		=> $username,
			'password'		=> MD5($password),
			'id_position'	=> $id_position,
			'id_konsultan'	=> $id_konsultan
		);
		$this->db->where('id_people',$id_people);
		$this->db->update('tbl_people', $people);
	}
}