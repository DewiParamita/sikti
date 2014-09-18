<?php
Class task_model extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function count_task($id_project)
	{
		$this -> db -> select();
		$this -> db -> from('tbl_task');
		$this -> db -> where('id_project', $id_project);

		$query = $this -> db -> get();
		
		return $query -> num_rows();
	}
	
	function get_task($id_project)
	{
		$this -> db -> select();
		$this -> db -> from('tbl_task');
		$this -> db -> where('id_project', $id_project);

		$query = $this -> db -> get();

		return $query->result();
	}

	function insert_task($nama,$deskripsi,$start_date,$duration,$id_project, $responsible)
	{
		$task = array(
			'nama'		=> $nama,
			'deskripsi'	=> $deskripsi,
			'start_date'=> $start_date,
			'duration'	=> $duration,
			'id_project'	=> $id_project,
			'responsible'=> $responsible,
			'progress'	=> '0'
		);
		$this->db->insert('tbl_task', $task);
	}
	
	function get_task_by_id($id_task)
	{
		$this -> db -> select();
		$this -> db -> from('tbl_task');
		$this -> db -> where('id_task', $id_task);

		$query = $this -> db -> get();

		return $query->result();
	}
	
	function edit_task($nama,$deskripsi,$start_date,$duration,$id_project, $responsible, $progress, $id_task)
	{
		$task = array(
			'nama'		=> $nama,
			'deskripsi'	=> $deskripsi,
			'start_date'=> $start_date,
			'duration'	=> $duration,
			'id_project'	=> $id_project,
			'responsible'=> $responsible,
			'progress'	=> $progress
		);
		$this->db->where('id_task',$id_task);
		$this->db->update('tbl_task', $task);
	}
	
	function delete_task($id_task)
	{
		$this->db->where('id_task',$id_task);
		$this->db->delete('tbl_task');
	}
}