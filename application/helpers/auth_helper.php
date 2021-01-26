<?php 
	function is_logged_in(){
		$ci = get_instance();
		if ($ci->session->username){
			if ($ci->uri->uri_string()==="") {
				redirect('beranda');
			}else if ($ci->uri->segment(1)!=="beranda" && $ci->uri->segment(1)!=="laporan" && $ci->uri->segment(1)!=="keluar"){
				if ($ci->session->role!=='1') show_404();
			}
		}else{
			if ($ci->uri->uri_string()!=="") {
				redirect(base_url());
			}
		}
	}

 ?>