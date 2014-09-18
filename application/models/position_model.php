<?php
Class position_model extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function get_position_by($id_konsultan)
	{
		$this -> db -> select();
		$this -> db -> from('tbl_position');
		$this -> db -> where('id_konsultan', $id_konsultan);
		
		$query = $this->db->get();
		
		return $query->result();
	}
	
	function count_position($id_konsultan)
	{
		$this -> db -> select();
		$this -> db -> from('tbl_position');
		$this -> db -> where('id_konsultan', $id_konsultan);

		$query = $this -> db -> get();

		return $query -> num_rows();
	}
	
	function insert_position($nama,$deskripsi,$id_konsultan)
	{
		$position = array(
			'position'		=> $nama,
			'deskripsi'	=> $deskripsi,
			'id_konsultan'	=> $id_konsultan
		);
		$this->db->insert('tbl_position', $position);
	}
	
	function get_position_by_id($id_position)
	{
		$this -> db -> select();
		$this -> db -> from('tbl_position');
		$this -> db -> where('id_position', $id_position);
		
		$query = $this->db->get();
		
		return $query->result();
	}
	
	function update_position($nama,$deskripsi,$id_konsultan, $id_position)
	{
		$position = array(
			'position'		=> $nama,
			'deskripsi'		=> $deskripsi,
			'id_konsultan'	=> $id_konsultan
		);
		$this->db->where('id_position', $id_position);
		$this->db->update('tbl_position', $position);
	}
	
	function delete_position($id_position)
	{
		$this->db->where('id_position',$id_position);
		$this->db->delete('tbl_position');
	}
}