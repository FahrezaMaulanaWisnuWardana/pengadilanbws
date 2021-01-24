<?php 
	class Task_model extends CI_model
	{
		private $_tb = "task";
		function create($data){
			$this->db->insert($this->_tb,$data);
			return $this->db->affected_rows();
		}
		function read($task_id=null){
			$this->db->select('*');
			$this->db->from($this->_tb);
			$this->db->join('room',$this->_tb.'.room_id = room.room_id');
			($task_id!=null)?$this->db->where(compact('task_id')):'';
			return $this->db->get();
		}
		function delete($task_id){
			$this->db->delete($this->_tb,compact('task_id'));
		}
		function update($data,$task_id){
			$this->db->update($this->_tb,$data,compact('task_id'));
			return $this->db->affected_rows();
		}
	}
 ?>