<?php 
	class Role_model extends CI_model
	{
		function read($id=null){
			$this->db->select('*');
			$this->db->from('user_role');
			($id!=null)?$this->db->where($id):'';
			return $this->db->get();
		}
	}
 ?>