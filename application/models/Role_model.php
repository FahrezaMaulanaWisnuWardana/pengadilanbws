<?php 
	class Role_model extends CI_model
	{
		function create($data){
			$this->db->insert('user_role',$data);
			return $this->db->affected_rows();
		}
		function read($id=null){
			$this->db->select('*');
			$this->db->from('user_role');
			($id!=null)?$this->db->where($id):'';
			return $this->db->get();
		}
		function delete($id_role){
			$this->db->delete('user_role',compact('id_role'));
		}
		function update($data,$id_role){
			$this->db->update('user_role',$data,compact('id_role'));
			return $this->db->affected_rows();
		}
	}
 ?>