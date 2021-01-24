<!DOCTYPE html>
<html>
<head>
	<?php $this->load->view('templates/head-dashboard');?>
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

          <!-- Content Row -->
          <div class="row">

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12 mb-4">
            	<a href="#">
	              <div class="card border-left-success shadow h-100 py-2">
	                <div class="card-body">
	                  <div class="row no-gutters align-items-center">
	                    <div class="col mr-2">
	                      <div class="h5 mb-0 font-weight-bold text-gray-800">Nama Ruangan</div>
	                    </div>
	                    <div class="col-auto">
	                      <i class="fas fa-home fa-2x text-gray-300"></i>
	                    </div>
	                  </div>
	                </div>
	              </div>
            	</a>
            </div>

          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
	<?php $this->load->view('templates/footer-dashboard') ?>
</html>