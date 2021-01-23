<!DOCTYPE html>
<html lang="en">

<head>
  <?php $this->load->view('templates/head-login'); ?>
</head>

<body style="background:#43aa8b">

  <div class="container" style="margin-top: 120px;">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-6 col-md-12 col-sm-12 col-xs-12">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-12">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Masuk Ceklist Kebersihan</h1>
                  </div>
                  <form class="user">
                    <div class="form-group">
                      <input type="email" class="form-control form-control-user" placeholder="Username">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" placeholder="Password">
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                      Masuk
                    </button>
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
  <script src="<?=base_url('js/sb-admin-2.min.js')?>"></script>

</body>

</html>
