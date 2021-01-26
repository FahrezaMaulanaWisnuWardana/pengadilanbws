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
		function create_room_user($data){
			$this->db->insert('user_room',$data);
			return $this->db->affected_rows();
		}
		function read_room_user($id=null){
			$this->db->select('*');
			$this->db->from('user_room');
			$this->db->join('room','user_room.room_id = room.room_id');
			$this->db->join('user','user_room.user_id = user.user_id','left');
			($id!=null)?$this->db->where($id):'';
			return $this->db->get();
		}
		function delete_room_user($user_room_id){
			$this->db->delete('user_room',compact('user_room_id'));
		}
		function update_room_user($data,$user_room_id){
			$this->db->update('user_room',$data,compact('user_room_id'));
			return $this->db->affected_rows();	
		}
		function room_by_user($user_id){
			$this->db->select('*');
			$this->db->from('room r');
			$this->db->join('user_room ur','r.room_id = ur.room_id','left');
			$this->db->where(compact('user_id'));
			$this->db->group_by('r.room_id');
			return $this->db->get();
		}
	}
 ?>