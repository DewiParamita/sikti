<?php
Class comment_model extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function count_comment($id_discussion)
	{
		$this -> db -> select();
		$this -> db -> from('tbl_comment');
		$this -> db -> where('id_discussion', $id_discussion);

		$query = $this -> db -> get();
		
		return $query -> num_rows();

	}
	
	function get_comment($id_discussion)
	{
		$this -> db -> select();
		$this -> db -> from('tbl_comment');
		$this -> db -> where('id_discussion', $id_discussion);

		$query = $this -> db -> get();

		return $query->result();
	}
	
	function get_posted_by($id_comment)
	{
		$this -> db -> select('tbl_people.nama');
		$this -> db -> from('tbl_comment');
		$this -> db -> join('tbl_people', 'tbl_comment.posted_by = tbl_people.id_people');
		$this -> db -> where('id_comment', $id_comment);

		$query = $this -> db -> get();

		return $query->result();
	}

	function insert_comment($isi, $posted_by, $posted_date, $id_discussion)
	{
		$comment = array(
			'isi' 		=> $isi,
			'posted_by'	=> $posted_by,
			'posted_date'=> $posted_date,
			'id_discussion' => $id_discussion
		);
		$this->db->insert('tbl_comment', $comment);
	}
	
	function delete_comment($id_comment)
	{
		$this->db->where('id_comment',$id_comment);
		$this->db->delete('tbl_comment');
	}
}