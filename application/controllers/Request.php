<?php 
	/**
	 * 
	 */
	class Request extends CI_Controller
	{
		
		function __construct()
		{
			parent::__construct();
			$this->load->model('Request_model','req_model');
		}
		function index(){
			if ($this->session->role==='2' || $this->session->role==='5' || $this->session->role==='4'){
				echo $this->session->role_name;
			}
		}
	}
 ?>