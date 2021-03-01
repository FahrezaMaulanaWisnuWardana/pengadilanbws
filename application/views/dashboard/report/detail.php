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
            <h1 class="h3 mb-0 text-gray-800"><?=$judul.' '.$ruangan['room_name']?></h1>
          </div>

          <!-- Content Row -->
          <div class="row">
            <div class="col-12">
                <div class="card border-left-success shadow h-100 py-2">
                  <div class="card-body">
                    <?=form_open('laporan/cetak')?>
                      <div class="row mb-3">
                        <div class="col-12 mb-3">
                          <label>Petugas</label>
                          <select class="form-control" name="user_id">
                            <?php 
                                foreach ($user as $petugas) {
                                  if ($petugas['id_role']!=='4' && $petugas['id_role']!=='1') {
                                  ?>
                                    <option value="<?=$petugas['user_id']?>"><?=$petugas['username']?></option>
                                  <?php
                                  }
                                }
                             ?>
                          </select>
                        </div>
                        <div class="col">
                          <label>Tanggal Awal</label>
                          <input type="date" class="form-control" name="tgl_awal">
                        </div>
                        <div class="col">
                          <label>Tanggal Akhir</label>
                          <input type="date" class="form-control"  name="tgl_akhir">
                          <input type="hidden" name="room_id" value="<?=$ruangan['room_id']?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <button type="submit" class="form-control btn btn-success">Download laporan <i class="fas fa-download"></i></button>
                      </div>
                    <?=form_close()?>
                  </div>
                </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
	<?php $this->load->view('templates/footer-dashboard') ?>
</html>