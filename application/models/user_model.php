<?php
Class user_model extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function login($username, $password)
	{
		$this -> db -> select('id_user, nama, username, password, id_role');
		$this -> db -> from('tbl_user');
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
	
	function get_user()
	{
		$this->db->select();
		$this->db->from('tbl_user');
		
		$query = $this->db->get();
		
		return $query->result();
	}
	
	function get_user_by_username($username)
	{
		$this->db->select();
		$this->db->from('tbl_user');
		$this->db->where('username',$username);
		
		$query = $this->db->get();
		
		return $query->result();
	}
	
	function get_user_by_id($id)
	{
		$this->db->select();
		$this->db->from('tbl_user');
		$this->db->where('id_user',$id);
		
		$query = $this->db->get();
		
		return $query->result();
	}
	
	function get_user_except($username)
	{
		$this->db->select();
		$this->db->from('tbl_user');
		$this->db->where('username !=',$username);
		$this->db->where('id_role !=','1');
		$this->db->where('id_role !=','3');
		$query = $this->db->get();
		
		return $query->result();
	}
	
	function is_unik($username)
	{
		$this->db->select();
		$this->db->from('tbl_user');
		$this->db->where('username', $username);
		$query = $this->db->get();
		return $query -> num_rows() ;
	}
	
	function insert_user($id_role,$nama,$kategori,$alamat,$no_telp,$email,$website,$foto,$username,$password)
	{
		$user = array(
			'id_role'	=> $id_role,
			'nama'		=> $nama,
			'kategori'	=> $kategori,
			'alamat'	=> $alamat,
			'no_telp'	=> $no_telp,
			'email'		=> $email,
			'website'	=> $website,
			'foto'		=> $foto,
			'username'	=> $username,
			'password'	=> MD5($password)
		);
		$this->db->insert('tbl_user', $user);
	}
	
	/*function get_consultant($perPage,$uri)
	{
		$this->db->select();
		$this->db->from('tbl_user');
		$this->db->where('id_role','3');
		
		$query = $this->db->get('', $perPage, $uri); 
		if($query->num_rows() > 0)
			return $query->result();
		else
			return null;
	}
	
	function count_consultant()
	{
		$this->db->select();
		$this->db->from('tbl_user');
		$this->db->where('id_role','3');
		
		$query = $this->db->get(''); 
		return $query->num_rows();
	}
	
	function get_customer($perPage,$uri)
	{
		$this->db->select();
		$this->db->from('tbl_user');
		$this->db->where('id_role','2');
		
		$query = $this->db->get('', $perPage, $uri); 
		if($query->num_rows() > 0)
			return $query->result();
		else
			return null;
	}
	
	function count_customer()
	{
		$this->db->select();
		$this->db->from('tbl_user');
		$this->db->where('id_role','2');
		
		$query = $this->db->get(''); 
		return $query->num_rows();
	}*/
	
	function get_consultant()
	{
		$this->db->select();
		$this->db->from('tbl_user');
		$this->db->where('id_role','3');
		
		$query = $this->db->get(''); 
		if($query->num_rows() > 0)
			return $query->result();
		else
			return null;
	}
	
	function count_consultant()
	{
		$this->db->select();
		$this->db->from('tbl_user');
		$this->db->where('id_role','3');
		
		$query = $this->db->get(''); 
		return $query->num_rows();
	}
	
	function get_customer()
	{
		$this->db->select();
		$this->db->from('tbl_user');
		$this->db->where('id_role','2');
		
		$query = $this->db->get(''); 
		if($query->num_rows() > 0)
			return $query->result();
		else
			return null;
	}
	
	function count_customer()
	{
		$this->db->select();
		$this->db->from('tbl_user');
		$this->db->where('id_role','2');
		
		$query = $this->db->get(''); 
		return $query->num_rows();
	}
	
	function check_email_username($input)
	{
		$this->db->select();
		$this->db->from('tbl_user');
		$this->db->where('email',$input);
		$this->db->or_where('username', $input);
		
		$query = $this->db->get(''); 
		return $query->num_rows();
	}
	
	function get_email($input)
	{
		$this->db->select();
		$this->db->from('tbl_user');
		$this->db->where('email',$input);
		$this->db->or_where('username', $input);
		
		$query = $this->db->get(''); 
		if($query->num_rows() > 0)
			return $query->result();
		else
			return null;
	}
	
	function reset_password($email)
	{	
		$user = array(
			'password'	=> MD5('12345')
		);
		
		$this->db->where('email', $email);
		$this->db->update('tbl_user', $user);
	}
	
	/*********************Search Client**********************/
	function search_consultant($keyword)
	{
		$where = "(nama LIKE '%".$keyword."%' OR kategori LIKE '%".$keyword."%' OR alamat LIKE '%".$keyword."%')";
		$this->db->select();
		$this->db->from('tbl_user');
		$this->db->where('id_role','3');
		$this->db->where($where);
		/*$this->db->like('nama',$keyword);
		$this->db->or_like('kategori',$keyword);
		$this->db->or_like('alamat',$keyword);*/
		
		$query = $this->db->get(''); 
		if($query->num_rows() > 0)
			return $query->result();
		else
			return null;
	}
	
	function count_search_consultant($keyword)
	{
		$where = "(nama LIKE '%".$keyword."%' OR kategori LIKE '%".$keyword."%' OR alamat LIKE '%".$keyword."%')";
		$this->db->select();
		$this->db->from('tbl_user');
		$this->db->where('id_role','3');
		$this->db->where($where);
		
		$query = $this->db->get(''); 
		return $query->num_rows();
	}
	
	function search_customer($keyword)
	{
		$where = "(nama LIKE '%".$keyword."%' OR kategori LIKE '%".$keyword."%' OR alamat LIKE '%".$keyword."%')";
		$this->db->select();
		$this->db->from('tbl_user');
		$this->db->where('id_role','2');
		$this->db->where($where);
		
		$query = $this->db->get(''); 
		if($query->num_rows() > 0)
			return $query->result();
		else
			return null;
	}
	
	function count_search_customer($keyword)
	{
		$where = "(nama LIKE '%".$keyword."%' OR kategori LIKE '%".$keyword."%' OR alamat LIKE '%".$keyword."%')";
		$this->db->select();
		$this->db->from('tbl_user');
		$this->db->where('id_role','2');
		$this->db->where($where);
		
		$query = $this->db->get(''); 
		return $query->num_rows();
	}
}
?>