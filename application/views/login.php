<!DOCTYPE html>
<html lang="en">

<head>
  <?php $this->load->view('templates/head-login'); ?>
  <style type="text/css">
    .card{
      background-color: rgba(255, 255, 255, .15);
      backdrop-filter: blur(5px);
      color: #ffff;
      transition: 0.3s;
    }
    .card:hover{
      background-color: rgba(255, 255, 255, 1);
      backdrop-filter: blur(5px);
      color: rgba(0,0,0,0.7);
    }
  </style>
</head>

<body style="background-image: url('<?=base_url(''.'assets/img/pengadilan1.jpeg'.'')?>'); background-size: cover;">

  <div class="container" style="margin-top: 120px;">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-6 col-md-12 col-sm-12 col-xs-12">

          <div class="px-5">
            <?php if ($this->session->flashdata('message')) $this->load->view('partials/toast') ?>
          </div>
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-12">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 mb-4">Aplikasi Ceklist Kebersihan</h1>
                  </div>
                  <?=form_open($this->uri->uri_string(),array('class'=>'user')) ?>
                    <div class="form-group">
                      <input type="text" name="username" class="form-control form-control-user <?= form_error('username') === '' ? '' : 'is-invalid' ?>" placeholder="Username" value="<?=set_value('username')?>">
                      <div class="invalid-feedback mt-2">
                          <?= form_error('username') ?>
                      </div>
                    </div>
                    <div class="form-group">
                      <input type="password" name="password" class="form-control form-control-user <?= form_error('password') === '' ? '' : 'is-invalid' ?>" placeholder="Password">
                      <div class="invalid-feedback mt-2">
                          <?= form_error('password') ?>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-success btn-user btn-block">
                      Masuk
                    </button>
                  <?=form_close()?>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="<?=base_url('assets/vendor/jquery/jquery.min.js')?>"></script>
  <script src="<?=base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')?>"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?=base_url('assets/vendor/jquery-easing/jquery.easing.min.js')?>"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?=base_url('assets/js/sb-admin-2.min.js')?>"></script>

</body>

</html>
