<?php
Class offers_model extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function count_offers()
	{
		$this -> db -> select();
		$this -> db -> from('tbl_offers');
		
		$query = $this -> db -> get();
		
		return $query -> num_rows();
	}
	
	function get_offers()
	{
		$this -> db -> select();
		$this -> db -> from('tbl_offers');

		$query = $this -> db -> get();

		return $query->result();
	}
	
	function get_consultant()
	{
		$this->db->select();
		$this->db->from('tbl_user');
		$this->db->where('id_role','3');
		$this->db->order_by('nama', 'asc');
		
		$query = $this->db->get(); 
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
		
		$query = $this->db->get(); 
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
	
	function insert_offers($nama,$deskripsi,$start_date,$duration,$budget,$posted_date,$id_user)
	{
		$offers = array(
			'nama'		=> $nama,
			'deskripsi'	=> $deskripsi,
			'start_date'=> $start_date,
			'duration'	=> $duration,
			'budget'	=> $budget,
			'posted_date' 	=> $posted_date,
			'id_company'	=> $id_user
		);
		$this->db->insert('tbl_offers', $offers);
	}
	
	function delete_offers($id_offers)
	{
		$this->db->where('id_offers',$id_offers);
		$this->db->delete('tbl_offers');
	}
	
	function get_offers_by_id($id_offers)
	{
		$this -> db -> select();
		$this -> db -> from('tbl_offers');
		$this -> db -> where('id_offers', $id_offers); 

		$query = $this -> db -> get();

		return $query->result();
	}
}
?>