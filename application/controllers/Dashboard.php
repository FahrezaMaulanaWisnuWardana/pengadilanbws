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
			switch ($_POST['aksi']) {
				case 'tambah':
						$config['upload_path'] = './assets/img/eviden/';
						$config['allowed_types'] = 'gif|jpg|png';
						$config['overwrite'] = TRUE;
						$config['file_name']     = $_FILES['foto']['name'];
						$this->load->library('upload',$config);
						if ($this->upload->do_upload('foto')){
							$data = $this->dmodel->create_task_user(array(
								'user_room_id'=>$this->input->post('room',true),
								'task_id'=> $this->input->post('task',true),
								'eviden'=>$config['file_name']
							));
							$stat = array('status'=>$data);
							echo json_encode($stat);
						}
					break;
				case 'update':
						$config['upload_path'] = './assets/img/eviden/';
						$config['allowed_types'] = 'gif|jpg|png';
						$config['overwrite'] = TRUE;
						$config['file_name']     = $_FILES['foto']['name'];
						$this->load->library('upload',$config);
						if ($this->upload->do_upload('foto')){
							$data = $this->dmodel->update_task_user(array(
								'eviden'=>$config['file_name']
							),array(
								'user_room_id'=>$this->input->post('room',true),
								'task_id'=> $this->input->post('task',true)
							));
							$stat = array('status'=>$data);
							echo json_encode($stat);
						}
					break;
				default:
						header("HTTP/1.0 404 Not Found");
					break;
			}
		}
		function cek($id){
			$data = $this->dmodel->task_user(['user_room.room_id'=>$id])->result_array();
			$arr = array('item'=>$data);
			echo json_encode($arr);
		}
	}
 ?>