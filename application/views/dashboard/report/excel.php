<!DOCTYPE html>
<html>
<head>
	<?php $this->load->view('templates/head-dashboard');?>
  <link href="<?=base_url('assets/vendor/datatables/dataTables.bootstrap4.min.css')?>" rel="stylesheet">
</head>
<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php $this->load->view('partials/sidebar'); ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php $this->load->view('partials/topbar'); ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"><?=$judul?></h1>
          </div>
            <?php if ($this->session->flashdata('message')) $this->load->view('partials/toast') ?>

          <!-- Content Row -->
          <div class="row">
            <div class="col-12">
                <div class="card border-left-success shadow h-100 py-2">
                  <div class="card-body">

                    <div class="table-responsive">
                      <table class="table table-bordered" id="tabel-laporan">
                        <thead>
                          <tr>
                            <th id="ruangan" style="text-align: center;">CEKLIST RUANG <?=$ruangan['room_name']?></th>
                          </tr>
                          <tr>
                            <th id="petugas">Nama Petugas : <?=$user['full_name']?></th>
                          </tr>
                          <tr>
                            <th id="bulan">Bulan : <span id="bulan"><?=($this->input->post('tgl_awal')==="")?date('F'):strftime('%Y-%m-%d', strtotime($this->input->post('tgl_awal')))?></span></th>
                          </tr>
                          <tr id="head-top">
                            <th>No.</th>
                            <th>Uraian Tugas</th>
                            <?php 
                            	for ($i=1; $i <= date('t') ; $i++) { 
                            		?>
                            			<th class="text-center"><?=$i?></th>
                            		<?php
                            	}
                             ?>
                          </tr>
                        </thead>
                        <tbody>
                        	<?php 
                        		$no=0;
                        		foreach ($tugas as $dataTugas) {
                        			$no++;
                        			?>
                        			<tr>
                        				<td><?=$no?></td>
                        				<td><?=$dataTugas['task']?></td>
                        				<?php 
			                            	for ($i=1; $i <= date('t') ; $i++) {
			                            		($i <= 9)?$tgl = '0'.$i:$tgl = $i; 
			                            		?>
			                            			<td class="align-middle text-center tdbck">
			                            				<?php 
			                            					foreach ($lap as $tgsLap) {
																if ($tgl == strftime('%d', strtotime($tgsLap['date']))){
																	if ($tgsLap['score']==='1') {
																		echo'<span class="tdble">✓</span>';
																	}else if ($tgsLap['score']==='2') {
																		echo'<span class="tdble">✓</span>';
																	}else if ($tgsLap['score']==='3') {
																		echo'<span class="tdble">✓</span>';
																	}else if($tgsLap['score']==='4'){
																		echo'<span class="tdble">✓</span>';
																	}
																}
			                            					}
			                            				 ?>
			                            			</td>
			                            		<?php
			                            	}
                        				?>
                        			</tr>
                        			<?php
                        		}
                        	?>
                        	<tr>
                        		<td class="col-foot"></td>
                        		<td colspan="7" style="text-align: center;">Mengetahui</td>
                        	</tr>
                        	<tr>
                        		<td class="col-foot"></td>
                        		<td colspan="7" style="text-align: center;">Kab Sub Bagian Umum dan Keuangan</td>
                        	</tr>
                        	<tr height="70"></tr>
                        	<tr>
                        		<td class="col-foot"></td>
                        		<td colspan="7" style="text-align: center;">TTD</td>
                        	</tr>
                        	<tr>
                        		<td class="col-foot"></td>
                        		<td colspan="7" style="text-align: center;"><?=$pimpinan['full_name']?></td>
                        	</tr>
                        	<tr>
                        		<td class="col-foot"></td>
                        		<td colspan="7" style="text-align: center;">NIP <?=$pimpinan['nip']?></td>
                        	</tr>
                        </tbody>
                      </table>
                    </div>

                    <a download="<?=date('D-M-Y').$ruangan['room_name']?>.xls" href="#" class="btn mt-4 btn-success" onclick="return ExcellentExport.excel(this, 'tabel-laporan', 'Sheet Name Here');">Export to Excel</a>
                  </div>
                </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
	<?php $this->load->view('templates/footer-dashboard') ?>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/excellentexport@3.4.3/dist/excellentexport.min.js"></script>
  <script type="text/javascript">
    var d = new Date();
    var m = d.getMonth();
    var y = d.getYear();
    <?php 
    	if ($this->input->post('tgl_awal')==="" && $this->input->post('tgl_akhir')==="") {
    		?>
				$("#ruangan").prop('colspan',days(m,y)+2)
				$("#petugas").prop('colspan',days(m,y)+2)
				$("#bulan").prop('colspan',days(m,y)+2)
    		<?php
    	}else{
    		$z = (strftime('%m', strtotime($this->input->post('tgl_awal')))<10)?explode('0', strftime('%m', strtotime($this->input->post('tgl_awal')))):strftime('%m', strtotime($this->input->post('tgl_awal')));
    		?>
	            $("#ruangan").prop('colspan',days(<?=strftime('%m', strtotime($this->input->post('tgl_awal')))?>,y)+2)
	            $("#petugas").prop('colspan',days(<?=strftime('%m', strtotime($this->input->post('tgl_awal')))?>,y)+2)
	            $("#bulan").prop('colspan',days(<?=strftime('%m', strtotime($this->input->post('tgl_awal')))?>,y)+2)
    		<?php
    	}
     ?>
    // let style = $('.tdble').attr('style')
    // $('.tdble').each(function(){
    // 	$(this).parent('.tdbck').attr('style',style)
    // 	console.log($(this).parent())
    // })
	$(".col-foot").prop('colspan',days(m,y)-5)
    function days(month,year) {
       return new Date(year, month, 0).getDate();
    };
  </script>
</html>