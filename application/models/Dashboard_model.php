<?php 
	class Dashboard_model extends CI_Model
	{
		function task_room_user($id){
			$this->db->select('*');
			$this->db->from('task t');
			$this->db->join('user_room ur','t.room_id = ur.room_id');
			$this->db->where($id);
			return $this->db->get();
		}
		function create_task_user($data){
			$this->db->insert('user_task',$data);
			return $this->db->affected_rows();
		}
		function update_task_user($data,$id){
			$this->db->update('user_task',$data,$id);
			return $this->db->affected_rows();
		}
		function task_user($id=null){
			$this->db->select('*');
			$this->db->from('user_task');
			$this->db->join('user_room','user_task.user_room_id=user_room.user_room_id');
			($id!=null)?$this->db->where($id):'';
			return $this->db->get();
		}
	}
?>