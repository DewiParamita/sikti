<?php
Class project_model extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function count_project($id)
	{
		$this -> db -> select();
		$this -> db -> from('tbl_project');
		$this -> db -> where('id_konsultan', $id);

		$query = $this -> db -> get();

		return $query -> num_rows();
	}
	
	function get_project($id)
	{
		$this -> db -> select();
		$this -> db -> from('tbl_project');
		$this -> db -> where('id_konsultan', $id);
		
		$query = $this->db->get();
		
		return $query->result();
	}
	
	function insert_project($nama,$deskripsi,$start_date,$duration,$id_konsultan,$id_customer)
	{
		$project = array(
			'nama'		=> $nama,
			'deskripsi'	=> $deskripsi,
			'start_date'=> $start_date,
			'duration'	=> $duration,
			'id_konsultan'	=> $id_konsultan,
			'id_customer'	=> $id_customer
		);
		$this->db->insert('tbl_project', $project);
	}
	
	function get_project_by($id_project)
	{
		$this -> db -> select();
		$this -> db -> from('tbl_project');
		$this -> db -> where('id_project', $id_project);
		
		$query = $this->db->get();
		
		return $query->result();
	}
	
	function update_project($id_project,$nama,$deskripsi,$start_date,$duration,$id_konsultan,$id_customer)
	{
		$project = array(
			'nama'		=> $nama,
			'deskripsi'	=> $deskripsi,
			'start_date'=> $start_date,
			'duration'	=> $duration,
			'id_konsultan'	=> $id_konsultan,
			'id_customer'	=> $id_customer
		);
		$this->db->where('id_project', $id_project);
		$this->db->update('tbl_project', $project);
	}
	
	function delete_project($id_project)
	{
		$this->db->where('id_project',$id_project);
		$this->db->delete('tbl_project');
	}
	
	//untuk login sbg tim
	
	function get_project_by_people($id_people)
	{
		$this -> db -> select();
		$this -> db -> from('tbl_hire');
		$this -> db -> join('tbl_project', 'tbl_hire.id_project = tbl_project.id_project');
		$this -> db -> where('id_people', $id_people);


		$query = $this -> db -> get();

		if($query -> num_rows() !=0)
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}
	
	function count_project_by_people($id_people)
	{
		$this -> db -> select('id_project');
		$this -> db -> from('tbl_hire');
		$this -> db -> where('id_people', $id_people);

		$query = $this -> db -> get();

		return $query -> num_rows();
	}
}