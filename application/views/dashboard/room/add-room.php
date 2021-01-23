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

          <!-- Content Row -->
          <div class="row">
            <div class="col-12">
              <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between">
                  <h5>Tambah Ruangan</h5>
                </div>
                <div class="card-body">
                  <?=form_open($this->uri->uri_string())?>
                    <div class="form-group">
                      <label>Nama ruangan</label>
                      <input type="text" name="ruangan" class="form-control <?= form_error('ruangan') === '' ? '' : 'is-invalid' ?>">
                      <div class="invalid-feedback mt-2">
                          <?= form_error('ruangan') ?>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-success float-right">
                      Tambah <i class="fas fa-plus"></i>
                    </button>
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