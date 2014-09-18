<?php
Class hire_model extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function insert_hire($id_people, $id_project)
	{
		$hire = array(
			'id_people'		=> $id_people,
			'id_project'	=> $id_project
		);
		$this->db->insert('tbl_hire', $hire);
	}
	
	
}
