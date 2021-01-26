<?php 
	class Login_model extends CI_Model
	{
		function cek_user($data){
	        $this->db->select('*');
	        $this->db->from('user');
	        $this->db->join('user_role','user.id_role=user_role.id_role');
	        $this->db->where($data);
	        return $this->db->get();
		}
	}
 ?>