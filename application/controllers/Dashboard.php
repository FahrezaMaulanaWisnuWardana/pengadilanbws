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
			if($this->session->role!=="1"){
				$data['judul'] = "Tugas Hari ini";
				$user_id = $this->session->userdata('user_id');
				$data['ruangan'] = $this->rmodel->room_by_user($user_id)->result_array();
			}else{
				$data['judul'] = "Dashboard";
				$data['ruangan'] = $this->rmodel->read()->result_array();
			}
			$this->load->view('dashboard/index',$data);
		}
		function task($room_id,$user_id){
			$data['judul']="Tugas anda";
			$data['tugas'] = $this->dmodel->task_room_user(['t.room_id'=>$room_id , 'ur.user_id'=>$user_id])->result_array();
			$this->load->view('dashboard/task-dashboard-user',$data);
		}
		function save(){
			$config['upload_path'] = './assets/img/eviden/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['overwrite'] = TRUE;
			$this->load->library('upload',$config);
			for ($i=0; $i < count($this->input->post('tugas')); $i++) {
				if (!empty($_FILES['foto']['name'][$i])) {
					$_FILES['file']['name'] = $_FILES['foto']['name'][$i];
					$_FILES['file']['type'] = $_FILES['foto']['type'][$i];
					$_FILES['file']['tmp_name'] = $_FILES['foto']['tmp_name'][$i];
					$_FILES['file']['error'] = $_FILES['foto']['error'][$i];
					$_FILES['file']['size'] = $_FILES['foto']['size'][$i];
				}

				$this->upload->do_upload('file');
				$uploadData = $this->upload->data();
				$data = $this->dmodel->create_task_user(array(
					'user_room_id'=>$this->input->post('urid')[$i],
					'task_id'=>$this->input->post('tugas')[$i],
					'eviden' => (!empty($_FILES['foto']['name'][$i]))?$uploadData['file_name']:NULL
				));
			}
			redirect('beranda');
		}
		function cek(){
			$data = $this->dmodel->task_user()->result_array();
			$arr = array('item'=>$data);
			echo json_encode($arr);
		}
		function cek_gambar(){
			$task_id = $this->input->post('id',true);
			$date = date('Y-m-d');
			$data = $this->dmodel->task_user(['task_id'=>$task_id, 'DATE(date)' => $date ])->row_array();
			$arr = array('item'=>$data);
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
			$config['upload_path'] = './assets/img/eviden/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['overwrite'] = TRUE;
			$config['file_name']     = $_FILES['foto']['name'];
			$this->load->library('upload',$config);
			if ($this->upload->do_upload('foto')){
				$data = $this->dmodel->update_task_user(array(
					'eviden'=>$config['file_name']
				),array('id_user_task'=>$this->input->post('id')) );
				$stat = array('status'=>$data);
				echo json_encode($stat);
			}
		}
	}
 ?>