<?php 
	class User_model extends CI_model
	{
		function create($data){
			$this->db->insert('user',$data);
			return $this->db->affected_rows();
		}
		function read($id=NULL){
			$this->db->select('*');
			$this->db->from('user');
			$this->db->join('user_role','user.id_role = user_role.id_role');
			($id!=NULL)?$this->db->where($id):'';
			return $this->db->get();
		}
		function delete($user_id){
			$this->db->delete('user',compact('user_id'));
		}
		function update($data,$user_id){
			$this->db->update('user',$data,compact('user_id'));
			return $this->db->affected_rows();
		}
	}
 ?>