<?php 
	class Dashboard extends CI_Controller
	{
		
		function __construct()
		{
			parent::__construct();
			is_logged_in();
			$this->load->model('Room_model','rmodel');
			$this->load->model('Dashboard_model','dmodel');
		}
		function index(){
			if($this->session->role!=="2"){
				$data['judul'] = "Dashboard";
				$data['ruangan'] = $this->rmodel->read()->result_array();
			}else{
				$data['judul'] = "Tugas Hari ini";
				$user_id = $this->session->userdata('user_id');
				$data['ruangan'] = $this->rmodel->room_by_user($user_id)->result_array();
			}
			$this->load->view('dashboard/index',$data);
		}
		function task($room_id,$user_id=null){
			$data['judul']="Tugas anda";
			($this->session->role==='2' || $this->session->role==='5')?$data['tugas'] = $this->dmodel->task_room(['t.room_id'=>$room_id])->result_array():'';
			$data['foto'] = $this->dmodel->task_user(['ut.room_id'=>$room_id , 'date(date)'=>date('Y-m-d')])->result_array();
			$this->load->view('dashboard/task-dashboard-user',$data);
		}
		function task_room(){
			$data = $this->dmodel->task_room(['task_id'=>$this->input->post('id')])->row_array();
			$stat = array('item'=>$data);
			echo json_encode($stat);
		}
		function task_leader($room_id){
			$data['judul'] = "Penilaian tugas";
			$data['tugas'] = $this->dmodel->task_user(['ut.room_id'=>$room_id , 'date(date)'=>date('Y-m-d')])->result_array();
			$this->load->view('dashboard/task-dashboard-leader',$data);
		}
		function save(){
			$config['upload_path'] = './assets/img/eviden/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['overwrite'] = TRUE;
			$this->load->library('upload',$config);
			for ($i=0; $i < count($_FILES['foto']['name']); $i++) {
				if (!empty($_FILES['foto']['name'])) {
					$_FILES['file']['name'] = $_FILES['foto']['name'][$i];
					$_FILES['file']['type'] = $_FILES['foto']['type'][$i];
					$_FILES['file']['tmp_name'] = $_FILES['foto']['tmp_name'][$i];
					$_FILES['file']['error'] = $_FILES['foto']['error'][$i];
					$_FILES['file']['size'] = $_FILES['foto']['size'][$i];
				}
			}
				$this->upload->do_upload('file');
				$uploadData = $this->upload->data();
				$data = $this->dmodel->create_task_user(array(
					'user_id'=>$this->session->user_id,
					'room_id'=>$this->input->post('room_id'),
					'task_id'=>$this->input->post('task_id'),
					'eviden' => (!empty($_FILES['foto']['name']))?implode(',', $_FILES['foto']['name']):NULL,
					'score' => (!empty($_FILES['foto']['name']))?'1':'2'
				));

	        $this->session->set_flashdata(array(
	            'message' => 'Berhasil menambah data '.$this->input->post('ruangan'),
	            'type' => 'success'
	        ));
			redirect('beranda');
		}
		function cek(){
			$data = $this->dmodel->task_user(['date(date)'=>date('Y-m-d')])->result_array();
			$arr = array('item'=>$data);
			echo json_encode($arr);
		}
		function cek_gambar(){
			$task_id = $this->input->post('id',true);
			$date = date('Y-m-d');
			$data = $this->dmodel->task_user(['ut.task_id'=>$task_id, 'DATE(date)' => $date ])->result_array();
			foreach ($data as $foto) {
				$arr = array(
					'item'=>explode(',', $foto['eviden']),
					'score'=>$foto['score'],
					'id'=>$task_id
				);
			}
			echo json_encode($arr);
		}
		function update_score(){
			$task_id = $this->input->post('id',true);
			$nilai = $this->input->post('score',true);
			$date = date('Y-m-d');
			$data = $this->dmodel->update_task_user(array(
				'leader_id'=>$this->input->post('leader',true),
				'score'=>$nilai
			),array('task_id'=>$task_id,'DATE(date)'=>$date));
			$stat = array('status'=>$data);
			echo json_encode($stat);
		}
		function update(){
			$date = date('Y-m-d');
			$config['upload_path'] = './assets/img/eviden/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['overwrite'] = TRUE;
			$this->load->library('upload',$config);
			for ($i=0; $i <= count($_FILES)-1; $i++) {
				$_FILES['file']['name'] = $_FILES['foto']['name'][$i];
				$_FILES['file']['type'] = $_FILES['foto']['type'][$i];
				$_FILES['file']['tmp_name'] = $_FILES['foto']['tmp_name'][$i];
				$_FILES['file']['error'] = $_FILES['foto']['error'][$i];
				$_FILES['file']['size'] = $_FILES['foto']['size'][$i];
			}
				$uploadData = $this->upload->data();
				$data = $this->dmodel->update_task_user(array(
					'eviden'=>implode(',', $_FILES['foto']['name'])
				),array('task_id'=>$this->input->post('task_id'),'DATE(date)'=>$date));
				if ($data>0) {
			        $this->session->set_flashdata(array(
			            'message' => 'Berhasil ubah data '.$this->input->post('ruangan'),
			            'type' => 'success'
			        ));
				}else{
			        $this->session->set_flashdata(array(
			            'message' => 'Gagal ubah data '.$this->input->post('ruangan'),
			            'type' => 'danger'
			        ));
				}
				redirect('beranda');
		}
	}
 ?>