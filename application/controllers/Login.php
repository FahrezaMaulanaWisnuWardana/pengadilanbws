<?php 
	class Login extends CI_Controller
	{
		
		function __construct()
		{
			parent::__construct();
		}
		function index(){
			$data['judul'] = "Masuk";
			$this->load->view('login',$data);
		}
	}
 ?>