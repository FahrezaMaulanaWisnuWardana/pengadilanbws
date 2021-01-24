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

          <!-- Content Row -->
          <div class="row">
            <div class="col-12">
            <?php if ($this->session->flashdata('message')) $this->load->view('partials/toast') ?>
              <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between">
                  <h5>Data Ruangan</h5>
                  <a href="<?=base_url('ruangan/tambah')?>" class="text-success"><i class="fas fa-plus"></i></a>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>No.</th>
                          <th>Nama Ruangan.</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>No.</th>
                          <th>Nama Ruangan.</th>
                          <th>Aksi</th>
                        </tr>
                      </tfoot>
                      <tbody>
                        <?php 
                          $no =1;
                          foreach ($ruangan as $data) {
                            ?>
                            <tr>
                              <td><?=$no++?></td>
                              <td><?=$data['room_name']?></td>
                              <td>
                                <?=form_open(base_url('ruangan/hapus'))?>
                                  <button class="btn btn-danger" name="room" onclick="return confirm('Yakin ingin menghapus ruangan?')" type="submit" value="<?=$data['room_id']?>"><i class="fas fa-trash"></i></button>
                                    <a href="<?=base_url('ruangan/edit/'.$data['room_id'])?>" class="btn btn-success"><i class="fas fa-pen"></i></a>
                                <?=form_close()?>
                              </td>
                            </tr>
                            <?php
                          }
                         ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
	<?php $this->load->view('templates/footer-dashboard') ?>
  <!-- Page level plugins -->
  <script src="<?=base_url('assets/vendor/datatables/jquery.dataTables.min.js')?>"></script>
  <script src="<?=base_url('assets/vendor/datatables/dataTables.bootstrap4.min.js')?>"></script>
  <script src="<?=base_url('assets/js/demo/datatables-demo.js')?>"></script>
</html>