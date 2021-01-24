<?php 
	class Task extends CI_Controller
	{
		
		function __construct()
		{
			parent::__construct();
			$this->load->model('Task_model','tmodel');
			$this->load->model('Room_model','rmodel');
		}
		function index(){
			$data['judul'] = "Daftar tugas";
			$data['tugas'] = $this->tmodel->read()->result_array();
			$this->load->view('dashboard/task/index',$data);
		}
		function add(){
			$data['judul']="Tambah tugas";
			$data['room'] = $this->rmodel->read()->result_array();
			$this->load->view('dashboard/task/add-task',$data);
		}
		function save(){
			$tugas = count($_POST['tugas']);
			for ($i=0; $i <$tugas ; $i++) { 
				$data = $this->tmodel->create(array(
					'task'=>$this->input->post('tugas',true)[$i],
					'room_id'=>$this->input->post('ruangan',true)[$i]
				));
			}
			if ($data>0) {
		        $this->session->set_flashdata(array(
		            'message' => 'Berhasil menambah tugas',
		            'type' => 'success'
		        ));
			}else{
		        $this->session->set_flashdata(array(
		            'message' => 'Gagal menambah tugas',
		            'type' => 'danger'
		        ));
			}
			redirect('tugas');
		}
		function delete(){
			$task_id = $this->input->post('task',true);
			$this->tmodel->delete($task_id);
	        $this->session->set_flashdata(array(
	            'message' => 'Berhasil hapus tugas',
	            'type' => 'success'
	        ));
	        redirect('tugas');
		}
		function update($id){
			if($this->form_validation->run('tugas'))$this->_update();
			$data['judul'] = "Ubah tugas";
			$data['tugas'] = $this->tmodel->read($id)->row_array();
			$data['room'] = $this->rmodel->read()->result_array();
			$this->load->view('dashboard/task/update-task',$data);
		}
		protected function _update(){
			$data = $this->tmodel->update(array(
				'task'=>$this->input->post('tugas',true),
				'room_id'=>$this->input->post('ruangan',true)
			),$this->input->post('id'));
			if ($data>0) {
		        $this->session->set_flashdata(array(
		            'message' => 'Berhasil ubah tugas',
		            'type' => 'success'
		        ));
			}else{
		        $this->session->set_flashdata(array(
		            'message' => 'Gagal ubah tugas',
		            'type' => 'danger'
		        ));
			}
			redirect('tugas');
		}
	}
 ?>