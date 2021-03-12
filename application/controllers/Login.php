<?php 
	class Login extends CI_Controller
	{
		
		function __construct()
		{
			parent::__construct();
			is_logged_in();
			$this->load->model('Login_model','lmodel');
		}
		function index(){
			if ($this->form_validation->run('login'))$this->_login();
			$data['judul'] = "Masuk";
			$this->load->view('login',$data);
		}
		protected function _login(){
			$username = $this->input->post('username',true);
			$password = $this->input->post('password',true);
			$login = $this->lmodel->cek_user(array(
				'username'=>$username
			))->row_array();
			if ($login){
				if (password_verify($password, $login['password'])){
					if ($login['active']==='1') {
						$session = array(
							'user_id' => $login['user_id'],
							'name' => $login['full_name'] ,
							'username'=>$login['username'],
							'role'=>$login['id_role'],
							'role_name'=>$login['role_name'],
							'nip'=>$login['nip']
						);
						$this->session->set_userdata($session);
						redirect('beranda');
					}else{
				        $this->session->set_flashdata(array(
				            'message' => '<p class="text-center">Akun anda tidak aktif <br> silahkan hubungi admin untuk aktivasi</p>',
				            'type' => 'danger'
				        ));
					}
				}else{
			        $this->session->set_flashdata(array(
			            'message' => 'Password atau username salah',
			            'type' => 'danger'
			        ));
				}
			}else{
		        $this->session->set_flashdata(array(
		            'message' => 'Password atau username salah',
		            'type' => 'danger'
		        ));
			}
		}
		function logout(){
			$this->session->sess_destroy();
			redirect(base_url());
		}
	}
 ?>