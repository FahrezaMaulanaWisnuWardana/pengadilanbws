<?php 
	class User extends CI_Controller
	{
		
		function __construct()
		{
			parent::__construct();
			is_logged_in();
			$this->load->model('User_model','umodel');
			$this->load->model('Role_model','rolemod');
		}
		function index(){
			$data['judul']="Pengguna";
			$data['pengguna']=$this->umodel->read()->result_array();
			$this->load->view('dashboard/user/index',$data);
		}
		function add(){
			if($this->form_validation->run('pengguna'))$this->_save();
			$data['judul']="Tambah pengguna";
			$data['role']=$this->rolemod->read()->result_array();
			$this->load->view('dashboard/user/add-user',$data);
		}
		protected function _save(){
			$username = $this->input->post('username',true);
			$user = $this->umodel->read(compact('username'))->num_rows();
			if ($user>0) {
		        $this->session->set_flashdata(array(
		            'message' => 'Username telah terpakai',
		            'type' => 'danger'
		        ));
			}else{
				$data = $this->umodel->create(
					array(
						'full_name'=>$this->input->post('nama',true),
						'username' =>$this->input->post('username',true),
						'password' =>password_hash($this->input->post('password',true), PASSWORD_BCRYPT),
						'gender'   =>$this->input->post('jk',true),
						'id_role'  =>$this->input->post('role',true),
						'nip'	   =>$this->input->post('nip',true)
					)
				);
				if ($data>0) {
			        $this->session->set_flashdata(array(
			            'message' => 'Berhasil tambah pengguna',
			            'type' => 'success'
			        ));
				}else{
			        $this->session->set_flashdata(array(
			            'message' => 'Gagal tambah pengguna',
			            'type' => 'danger'
			        ));
				}
			}
			redirect('pengguna');
		}
		function delete(){
			$user_id = $this->input->post('user',true);
			$this->umodel->update(
						array(
						'active'=>2,
						'updated_at'=>date("Y-m-d H:i:s")
					),$user_id);
	        $this->session->set_flashdata(array(
	            'message' => 'Berhasil hapus pengguna',
	            'type' => 'success'
	        ));
	        redirect('pengguna');
		}
		function aktivasi(){
			$user_id = $this->input->post('user',true);
			$this->umodel->update(
						array(
						'active'=>1,
						'updated_at'=>date("Y-m-d H:i:s")
					),$user_id);
	        $this->session->set_flashdata(array(
	            'message' => 'Berhasil aktivasi pengguna',
	            'type' => 'success'
	        ));
	        redirect('pengguna');
		}
		function update($user_id){
			if ($this->form_validation->run('pengguna_upd')) $this->_update();
			$data['judul']="Ubah pengguna";
			$data['pengguna']=$this->umodel->read(compact('user_id'))->row_array();
			$data['role']=$this->rolemod->read()->result_array();
			$this->load->view('dashboard/user/update-user',$data);
		}
		protected function _update(){
			$username = $this->input->post('username',true);
			$user = $this->umodel->read(compact('username'))->num_rows();
			$uname = $this->umodel->read(compact('username'))->row_array();
			if ($username === $uname['username']) {
				$data = $this->umodel->update(
					array(
						'full_name'=>$this->input->post('nama',true),
						'username' =>$this->input->post('username',true),
						'gender'   =>$this->input->post('jk',true),
						'id_role'  =>$this->input->post('role',true),
						'nip'	   =>$this->input->post('nip',true),
						'updated_at'=>date("Y-m-d H:i:s")
					),$this->input->post('id')
				);
				if ($data>0) {
			        $this->session->set_flashdata(array(
			            'message' => 'Berhasil ubah pengguna',
			            'type' => 'success'
			        ));
				}else{
			        $this->session->set_flashdata(array(
			            'message' => 'Gagal ubah pengguna',
			            'type' => 'danger'
			        ));
				}
			}else{
				if ($user>0) {
			        $this->session->set_flashdata(array(
			            'message' => 'Username telah terpakai',
			            'type' => 'danger'
			        ));
				}else{
					$data = $this->umodel->update(
						array(
							'full_name'=>$this->input->post('nama',true),
							'username' =>$this->input->post('username',true),
							'gender'   =>$this->input->post('jk',true),
							'id_role'  =>$this->input->post('role',true),
							'nip'	   =>$this->input->post('nip',true),
							'updated_at'=>date("Y-m-d H:i:s")
						),$this->input->post('id')
					);
					if ($data>0) {
				        $this->session->set_flashdata(array(
				            'message' => 'Berhasil ubah pengguna',
				            'type' => 'success'
				        ));
					}else{
				        $this->session->set_flashdata(array(
				            'message' => 'Gagal ubah pengguna',
				            'type' => 'danger'
				        ));
					}
				}
			}
			redirect('pengguna');
		}
		function upd_password($user_id){
			if ($this->form_validation->run('pengguna_pass_upd')) $this->_update_password();
			$data['judul']="Ubah Password";
			$data['pengguna']=$this->umodel->read(compact('user_id'))->row_array();
			$this->load->view('dashboard/user/update-pass-user',$data);
		}
		protected function _update_password(){
			$data = $this->umodel->update(
				array(
					'password' =>password_hash($this->input->post('password',true), PASSWORD_BCRYPT),
					'updated_at'=>date("Y-m-d H:i:s")

				),$this->input->post('id')
			);
			if ($data>0) {
		        $this->session->set_flashdata(array(
		            'message' => 'Berhasil ubah password pengguna',
		            'type' => 'success'
		        ));
			}else{
		        $this->session->set_flashdata(array(
		            'message' => 'Gagal ubah password pengguna',
		            'type' => 'danger'
		        ));
			}
			redirect('pengguna');
		}
	}
 ?>