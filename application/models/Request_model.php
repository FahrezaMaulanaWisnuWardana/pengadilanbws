<?php 
	class Request_model extends CI_model
	{
		function read($where=null,$detail=false){
			$this->db->select('*');
			$this->db->from('user_request ur');
			$this->db->join('room','ur.room_id=room.room_id');
			($detail==true)?$this->db->join('request r','r.id_urequest=ur.id_urequest'):'';
			($where!=null)?$this->db->where($where):'';
			return $this->db->get();
		}
		function create($data){
			$this->db->insert('user_request',$data);
			return $this->db->insert_id();
		}
		function create_request($data){
			$this->db->insert('request',$data);
			return $this->db->affected_rows();
		}
		function update_request($data,$id){
			$this->db->update('request',$data,$id);
			return $this->db->affected_rows();
		}
	}
 ?>