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
                  <input type="hidden" name="id" value="<?=$pengguna['user_id']?>">
                    <div class="form-group">
                      <label>Nama lengkap</label>
                      <input type="text" name="nama" class="form-control <?= form_error('nama') === '' ? '' : 'is-invalid' ?>" value="<?=(empty($pengguna['full_name']))?set_value('nama'):$pengguna['full_name']?>">
                      <div class="invalid-feedback mt-2">
                          <?= form_error('nama') ?>
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Username</label>
                      <input type="text" name="username" class="form-control <?= form_error('username') === '' ? '' : 'is-invalid' ?>" value="<?=(empty($pengguna['username']))?set_value('username'):$pengguna['username']?>">
                      <div class="invalid-feedback mt-2">
                          <?= form_error('username') ?>
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Jenis Kelamin</label>
                      <select class="form-control" name="jk">
                        <option value="1" <?=($pengguna['gender']==="1")?'selected':''?>>Laki-Laki</option>
                        <option value="2" <?=($pengguna['gender']==="2")?'selected':''?>>Perempuan</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Role</label>
                      <select class="form-control" name="role">
                        <?php 
                            foreach ($role as $data_role) {
                              ?>
                              <option value="<?=$data_role['id_role']?>" <?=($pengguna['id_role']===$data_role['id_role'])?'selected':''?>><?=$data_role['role_name']?></option>
                              <?php
                            }
                         ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>NIP</label>
                      <input type="text" name="nip" class="form-control <?= form_error('nip') === '' ? '' : 'is-invalid' ?>" value="<?=(empty($pengguna['nip']))?set_value('nip'):$pengguna['nip']?>">
                      <div class="invalid-feedback mt-2">
                          <?= form_error('nip') ?>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-success float-right">
                      Ganti <i class="fas fa-pen"></i>
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