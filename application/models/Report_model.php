<?php 
	class Report_model extends CI_model
	{
		function laporan($where=null){
			$this->db->select('*');
			$this->db->from('user_task');
			($where!=null)?$this->db->where($where):'';
			return $this->db->get();
		}
		function tugas($where=null){
			$this->db->select('*');
			$this->db->from('task');
			($where!=null)?$this->db->where($where):'';
			return $this->db->get();
		}
		function ruangan($where=null){
			$this->db->select('*');
			$this->db->from('room');
			($where!=null)?$this->db->where($where):'';
			return $this->db->get();
		}
		function user($where=null){
			$this->db->select('*');
			$this->db->from('user');
			($where!=null)?$this->db->where($where):'';
			return $this->db->get();
		}
	}
 ?>