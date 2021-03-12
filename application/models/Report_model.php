<?php 
	class Report_model extends CI_model
	{
		function laporan($where=null){
			$this->db->select('*');
			$this->db->from('user_task');
			($where!=null)?$this->db->where($where):'';
			return $this->db->get();
		}
		function laporan_permintaan($where=null){
			$this->db->select('* , user.username as username_req , user.full_name as name_req , request.updated_at as tgl_respon');
			$this->db->from('request');
			$this->db->join('user_request','user_request.id_urequest=request.id_urequest','INNER');
			$this->db->join('user','user_request.user_request_id=user.user_id','INNER');
			$this->db->join('user u','u.user_id=user_request.user_id','INNER');
			$this->db->join('room','room.room_id=user_request.room_id','INNER');
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