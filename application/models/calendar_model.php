<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class calendar_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function get_calendar($year, $mon){
		$year  = ($mon < 9 && strlen($mon) == 1) ? "$year-0$mon" : "$year-$mon";
		$query = $this->db->select('tanggal, keterangan')->from('libur')->like('tanggal', $year, 'after')->get();
		if($query->num_rows() > 0){
			$data = array();
			foreach($query->result_array() as $row){
				$data[(int) end(explode('-',$row['tanggal']))] = $row['keterangan'];
			}
			return $data;
		}else{
			return false;
		}
	}
	
	function add_note($year, $mon, $day, $note){
		$mon = (strlen($mon) == 2)? $mon : "0$mon";
		$day = (strlen($day) == 2)? $day : "0$day";
		$this->db->query("INSERT INTO libur(tanggal, keterangan) VALUES ('$year-$mon-$day', ?)", array($note));
	}
	
	function edit_note($year, $mon, $day, $note){
		$mon = (strlen($mon) == 2)? $mon : "0$mon";
		$day = (strlen($day) == 2)? $day : "0$day";
		$this->db->query("UPDATE libur SET keterangan = ? WHERE date = '$year-$mon-$day'", array($note));
	}
	
	function delete_note($year, $mon, $day){
		$mon = (strlen($mon) == 2)? $mon : "0$mon";
		$day = (strlen($day) == 2)? $day : "0$day";
		$this->db->query("DELETE FROM libur WHERE tanggal = '$year-$mon-$day'");
	}
	
	function get_note($year, $mon, $day){
		$mon   = (strlen($mon) == 2)? $mon : "0$mon";
		$day   = (strlen($day) == 2)? $day : "0$day";
		$query = $this->db->query("SELECT libur FROM libur WHERE tanggal = '$year-$mon-$day'");
		if($query->num_rows() == 1){
			$query = $query->row_array();
			return $query['libur'];
		}else{
			return false;
		}
	}
}?>