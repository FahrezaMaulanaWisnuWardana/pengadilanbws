<?php 
	class Monitoring extends CI_Controller
	{
		
		function __construct()
		{
			parent::__construct();
			$this->load->model('Report_model','rmodel');
		}
		function index(){
			$data['tugas'] = $this->rmodel->laporan(['deleted_at'=>date('Y-m-d')])->result_array();
			if (count($data['tugas'])>0) {
				foreach ($data['tugas'] as $tugas) {
					$arr[] = array(
						'id'=> $tugas['id_user_task'],
						'eviden'=> explode(',', $tugas['eviden'])
					);
					$this->rmodel->delete_laporan($tugas['id_user_task']);
				}
				foreach ($arr as $key => $value) {
					foreach ($value['eviden'] as $data) {
						if (file_exists(FCPATH . 'assets\\img\\eviden\\'.$data)) {
							unlink(FCPATH . 'assets\\img\\eviden\\'.$data);
						}
					}
				}
			}else{
				echo "Kosong";
			}
		}
	}
 ?>