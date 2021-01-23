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
                  <h5><?=$judul?></h5>
                </div>
                <div class="card-body">
                  <?=form_open($this->uri->uri_string())?>
                  <input type="hidden" name="id" value="<?=$role['id_role']?>">
                    <div class="form-group">
                      <label>Nama akses</label>
                      <input type="text" name="role" class="form-control <?= form_error('role') === '' ? '' : 'is-invalid' ?>" value="<?=$role['role_name']?>">
                      <div class="invalid-feedback mt-2">
                          <?= form_error('role') ?>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-success float-right">
                      Ubah <i class="fas fa-pen"></i>
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