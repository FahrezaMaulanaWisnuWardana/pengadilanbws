<?php 
	class Room_model extends CI_model
	{
		function create($data){
			$this->db->insert('room',$data);
			return $this->db->affected_rows();
		}
		function read($id=NULL){
			$this->db->select('*');
			$this->db->from('room');
			($id!=NULL)?$this->db->where($id):'';
			return $this->db->get();
		}
		function delete($room_id){
			$this->db->delete('room',compact('room_id'));
		}
		function update($data,$room_id){
			$this->db->update('room',$data,compact('room_id'));
			return $this->db->affected_rows();
		}
	}
 ?>