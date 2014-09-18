<?php
Class file_model extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function count_file($id_project)
	{
		$this -> db -> select();
		$this -> db -> from('tbl_file');
		$this -> db -> where('id_project', $id_project);

		$query = $this -> db -> get();
		
		return $query -> num_rows();
	}
	
	function get_file($id_project)
	{
		$this -> db -> select();
		$this -> db -> from('tbl_file');
		$this -> db -> where('id_project', $id_project);

		$query = $this -> db -> get();

		return $query->result();
	}
	
	function get_posted_by($id_file)
	{
		$this -> db -> select('tbl_people.nama');
		$this -> db -> from('tbl_file');
		$this -> db -> join('tbl_people', 'tbl_file.upload_by = tbl_people.id_people');
		$this -> db -> where('id_file', $id_file);

		$query = $this -> db -> get();

		return $query->result();
	}
	
	function insert_file($judul, $path_file, $posted_by, $posted_date, $id_project)
	{
		$file = array(
			'judul'			=> $judul,
			'path'			=> $path_file,
			'upload_by'		=> $posted_by,
			'upload_date'	=> $posted_date,
			'id_project'	=> $id_project
		);
		$this->db->insert('tbl_file', $file);
	}
	
	function delete_file($id_file)
	{
		$this->db->where('id_file',$id_file);
		$this->db->delete('tbl_file');
	}

}