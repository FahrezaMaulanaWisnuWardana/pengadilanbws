<?php 
	class Request_model extends CI_model
	{
		
		function create($data){
			$this->db->insert('user_request',$data);
			return $this->db->insert_id();
		}
		function create_request($data){
			$this->db->insert('request',$data);
			return $this->db->affected_rows();
		}
	}
 ?>