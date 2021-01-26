<?php 
	class Role extends CI_Controller
	{
		
		function __construct()
		{
			parent::__construct();
			is_logged_in();
			$this->load->model('Role_model','rmodel');
		}
		function index(){
			$data['judul']="Hak akses";
			$data['role']=$this->rmodel->read()->result_array();
			$this->load->view('dashboard/role/index',$data);
		}
		function add(){
			if($this->form_validation->run('role'))$this->_save();
			$data['judul']="Tambah hak akses";
			$this->load->view('dashboard/role/add-role',$data);
		}
		protected function _save(){
			$data = $this->rmodel->create(array(
				'role_name'=>$this->input->post('role',true)
			));
			if ($data>0) {
		        $this->session->set_flashdata(array(
		            'message' => 'Berhasil menambah hak akses',
		            'type' => 'success'
		        ));
			}else{
		        $this->session->set_flashdata(array(
		            'message' => 'Gagal menambah hak akses',
		            'type' => 'danger'
		        ));
			}
			redirect('hak-akses');
		}
		function delete(){
			$id_role = $this->input->post('role',true);
			$this->rmodel->delete($id_role);
	        $this->session->set_flashdata(array(
	            'message' => 'Berhasil hapus hak akses',
	            'type' => 'success'
	        ));
	        redirect('hak-akses');
		}
		function update($id_role){
			if($this->form_validation->run('role'))$this->_update();
			$data['judul']="Ubah hak akses";
			$data['role']=$this->rmodel->read(compact('id_role'))->row_array();
			$this->load->view('dashboard/role/update-role',$data);
		}
		protected function _update(){
			$data = $this->rmodel->update(array(
				'role_name'=>$this->input->post('role',true)
			),$this->input->post('id'));
			if ($data>0) {
		        $this->session->set_flashdata(array(
		            'message' => 'Berhasil ubah hak akses',
		            'type' => 'success'
		        ));
			}else{
		        $this->session->set_flashdata(array(
		            'message' => 'Gagal ubah hak akses',
		            'type' => 'danger'
		        ));
			}
			redirect('hak-akses');
		}
	}
 ?>