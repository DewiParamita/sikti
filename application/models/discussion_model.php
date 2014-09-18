<?php
Class discussion_model extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function count_discussion($id_project)
	{
		$this -> db -> select();
		$this -> db -> from('tbl_discussion');
		$this -> db -> where('id_project', $id_project);

		$query = $this -> db -> get();
		
		if($query -> num_rows() !=0)
		{
			return $query -> num_rows();
		}
		else
		{
			return 0;
		}
	}
	
	function get_discussion($id_project)
	{
		$this -> db -> select();
		$this -> db -> from('tbl_discussion');
		$this -> db -> where('id_project', $id_project);

		$query = $this -> db -> get();

		return $query->result();
	}
	
	function get_posted_by($id_discussion)
	{
		$this -> db -> select('tbl_people.nama');
		$this -> db -> from('tbl_discussion');
		$this -> db -> join('tbl_people', 'tbl_discussion.posted_by = tbl_people.id_people');
		$this -> db -> where('id_discussion', $id_discussion);

		$query = $this -> db -> get();

		return $query->result();
	}
	
	function insert_discussion($topic, $deskripsi, $posted_by, $posted_date, $id_project)
	{
		$discussion = array(
			'topic'			=> $topic,
			'deskripsi'		=> $deskripsi,
			'posted_by'		=> $posted_by,
			'posted_date'	=> $posted_date,
			'id_project'	=> $id_project
		);
		$this->db->insert('tbl_discussion', $discussion);
	}
	
	function delete_discussion($id_discussion)
	{
		$this->db->where('id_discussion',$id_discussion);
		$this->db->delete('tbl_discussion');
	}

	function get_discussion_by_id($id_discussion)
	{
		$this -> db -> select();
		$this -> db -> from('tbl_discussion');
		$this -> db -> where('id_discussion', $id_discussion);

		$query = $this -> db -> get();

		return $query->result();
	}
	
	function update_discussion($topic, $deskripsi, $id_discussion)
	{
		$discussion = array(
			'topic'			=> $topic,
			'deskripsi'		=> $deskripsi
		);
		$this->db->where('id_discussion', $id_discussion);
		$this->db->update('tbl_discussion', $discussion);
	}
}