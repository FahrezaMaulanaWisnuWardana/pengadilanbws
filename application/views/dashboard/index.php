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
            <?php
                if (empty($ruangan)) {
                  ?>
                    <div class="col-12">
                        <div class="card border-left-success shadow h-100 py-2">
                          <div class="card-body">
                            <div class="row no-gutters align-items-center">
                              <div class="col mr-2">
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Anda tidak memiliki tugas</div>
                              </div>
                              <div class="col-auto">
                                <i class="fas fa-laugh-wink fa-2x text-gray-300"></i>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                  <?php
                }else{
                  foreach ($ruangan as $data) {
                    ?>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12 mb-4">
                          <a href="<?php if($this->session->role==='2' || $this->session->role==='5'){
                              echo base_url('beranda/tugas/'.$data['room_id'].'/'.$this->session->user_id);
                            }else if($this->session->role=='4'){
                              echo base_url('beranda/tugas-pimpinan/'.$data['room_id']);
                            }else{
                              echo base_url('ruangan/pengguna/'.$data['room_id']);
                            }?>">
                            <div class="card border-left-success shadow h-100 py-2">
                              <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                  <div class="col mr-2">
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$data['room_name']?></div>
                                  </div>
                                  <div class="col-auto">
                                    <i class="fas fa-home fa-2x text-gray-300"></i>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </a>
                        </div>
                    <?php
                  }
                }
             ?>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
	<?php $this->load->view('templates/footer-dashboard') ?>
</html>