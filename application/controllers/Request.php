<?php 
	/**
	 * 
	 */
	class Request extends CI_Controller
	{
		
		function __construct()
		{
			parent::__construct();
			// is_logged_in();
			$this->load->model('Request_model','req_model');
			$this->load->model('Room_model','rmodel');
			$this->load->model('User_model','u_model');
		}
		function index(){
			$data['judul'] = "Permintaan";
			$data['user']  = $this->u_model->read()->result_array();
			$data['room'] = $this->rmodel->read()->result_array();
			$data['req'] = $this->req_model->read(null,false)->result_array();
			$this->load->view('Dashboard/request/index',$data);
		}
		function cek_request(){
			$data = $this->req_model->read(['ur.id_urequest'=>$this->input->post('id')],true)->result_array();
			$stat = array('item'=>$data);
			echo json_encode($stat);
		}
		function update_request(){
			$data = $this->req_model->update_request(array(
				'status'=>$this->input->post('val')
			),['id_request'=>$this->input->post('id')]);
			if ($data>0) {
				$item = array('status'=>$data);
			}else{
				$item = array('status'=>null);
			}
			echo json_encode($item);
		}
		function save(){
			$id = $this->req_model->create(array(
				'judul'=>$this->input->post('judul'),
				'user_id'=>$this->session->user_id,
				'user_request_id'=>$this->input->post('uid'),
				'room_id'=>$this->input->post('room_id')
			));
			for ($i=0; $i <count($this->input->post('request')); $i++) { 
				$data = $this->req_model->create_request(array(
					'id_urequest'=>$id,
					'request'=>$this->input->post('request')[$i],
					'status'=>'1'
				));
			}
			if ($data>0) {
		        $this->session->set_flashdata(array(
		            'message' => 'Berhasil tambah data',
		            'type' => 'success'
		        ));
			}else{
		        $this->session->set_flashdata(array(
		            'message' => 'Gagal tambah data',
		            'type' => 'danger'
		        ));
			}
			redirect('permintaan');
		}
	}
 ?>