<?php 
	class Room extends CI_Controller
	{
		
		function __construct()
		{
			parent::__construct();
			$this->load->model('Room_model','rmodel');
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
	}
 ?>