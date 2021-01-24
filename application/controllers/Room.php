<?php 
	class Room extends CI_Controller
	{
		
		function __construct()
		{
			parent::__construct();
			$this->load->model('Room_model','rmodel');
			$this->load->model('User_model','umodel');
		}
		function index(){
			$data['judul']="Ruangan";
			$data['ruangan']= $this->rmodel->read()->result_array();
			$this->load->view('dashboard/room/index',$data);
		}
		function add(){
			if ($this->form_validation->run('ruangan')) $this->_save();
			$data['judul']="Tambah Ruangan";
			$this->load->view('dashboard/room/add-room',$data);	
		}
		protected function _save(){
			$save = $this->rmodel->create(array(
				'room_name'=>$this->input->post('ruangan',true)
			));
			if ($save>0) {
		        $this->session->set_flashdata(array(
		            'message' => 'Berhasil menambah ruangan',
		            'type' => 'success'
		        ));
			}else{
		        $this->session->set_flashdata(array(
		            'message' => 'Gagal menambah ruangan',
		            'type' => 'danger'
		        ));
			}
	        redirect('ruangan');
		}
		function delete(){
			$room_id = $this->input->post('room',true);
			$this->rmodel->delete($room_id);
	        $this->session->set_flashdata(array(
	            'message' => 'Berhasil hapus ruangan',
	            'type' => 'success'
	        ));
	        redirect('ruangan');
		}
		function update($room_id){
			if ($this->form_validation->run('ruangan')) $this->_update();
			$data['ruangan']= $this->rmodel->read(compact('room_id'))->row_array();
			$data['judul']="Ubah ruangan";
			$this->load->view('dashboard/room/update-room',$data);
		}
		protected function _update(){
			$room_id = $this->input->post('room',true);
			$update = $this->rmodel->update(array('room_name'=>$this->input->post('ruangan',true)),$room_id);
			if ($update>0) {
		        $this->session->set_flashdata(array(
		            'message' => 'Berhasil ubah ruangan',
		            'type' => 'success'
		        ));
			}else{
		        $this->session->set_flashdata(array(
		            'message' => 'Gagal ubah ruangan',
		            'type' => 'danger'
		        ));
			}
	        redirect('ruangan');
		}
		function user($room_id=null){
			$data['judul']="Ruangan Pengguna";
			if($room_id==null){
				$data['ruangan'] = $this->rmodel->read()->result_array();
				$this->load->view('dashboard/room/list-room-user',$data);
			}else{
				$data['ruangan'] = $this->rmodel->read(['room.room_id'=>$room_id])->row_array();
				$data['user'] = $this->rmodel->read_room_user(['user_room.room_id'=>$room_id])->result_array();
				$this->load->view('dashboard/room/list-room-detail-user',$data);
			}
		}
		function add_user($room_id){
			$data['judul'] = "Tambah pengguna";
			$data['ruangan']= $this->rmodel->read(compact('room_id'))->row_array();
			$data['pengguna']=$this->umodel->read()->result_array();
			$this->load->view('dashboard/room/add-room-user',$data);
		}
		function save_user(){
			$user = $this->input->post('pengguna',true);
			for ($i=0; $i < count($user); $i++) { 
				$data =	$this->rmodel->create_room_user(array(
					'user_id'=>$user[$i],
					'room_id'=>$this->input->post('id',true)
				));
			}
			if ($data>0) {
		        $this->session->set_flashdata(array(
		            'message' => 'Berhasil menambah akun',
		            'type' => 'success'
		        ));
			}else{
		        $this->session->set_flashdata(array(
		            'message' => 'Gagal menambah akun',
		            'type' => 'danger'
		        ));
			}
			redirect('ruangan/pengguna/'.$this->input->post('id',true));
		}
		function delete_user(){
			$room_id = $this->input->post('user',true);
			$this->rmodel->delete_room_user($room_id);
	        $this->session->set_flashdata(array(
	            'message' => 'Berhasil hapus akun',
	            'type' => 'success'
	        ));
	        redirect('ruangan/pengguna/'.$this->input->post('room',true));
		}
		function update_user($user_room_id){
			if ($this->form_validation->run('pengguna_room')) $this->_update_user();
			$data['judul']="Ubah akun ruangan";
			$data['ruangan'] = $this->rmodel->read_room_user(compact('user_room_id'))->row_array();
			$data['pengguna']=$this->umodel->read()->result_array();
			$this->load->view('dashboard/room/update-room-user',$data);
		}
		protected function _update_user(){
			$id = $this->input->post('id',true);
			$user = $this->rmodel->read_room_user(['user_room.room_id'=>$this->input->post('room',true)])->num_rows();
			if ($user>1) {
		        $this->session->set_flashdata(array(
		            'message' => 'Gagal merubah akun telah ada',
		            'type' => 'danger'
		        ));
			}else{
				$data = $this->rmodel->update_room_user(array(
					'user_id'=>$this->input->post('pengguna',true)
				),$id);
				if ($data>0) {
			        $this->session->set_flashdata(array(
			            'message' => 'Berhasil merubah akun',
			            'type' => 'success'
			        ));
				}else{
			        $this->session->set_flashdata(array(
			            'message' => 'Gagal merubah akun',
			            'type' => 'danger'
			        ));
				}
			}
			redirect('ruangan/pengguna/'.$this->input->post('room',true));
		}
	}
 ?>