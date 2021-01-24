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
                  <span id="tambah" class="text-success"><i class="fas fa-plus"></i></span>
                </div>
                <div class="card-body">
                  <?=form_open('tugas/simpan', array('class' => 'needs-validation', 'novalidate' => true))?>
                    <div class="form-group">
                      <label>Tugas</label>
                      <input type="text" name="tugas[]" required class="form-control">
                      <div class="invalid-feedback mt-2">Lingkup harus diisi.</div>
                    </div>
                    <div class="form-group">
                      <label>Ruangan</label>
                        <select class="form-control" name="ruangan[]">
                          <?php foreach ($room as $data): ?>
                            <option value="<?=$data['room_id']?>"><?=$data['room_name']?></option>
                          <?php endforeach ?>
                        </select>
                    </div>
                    <div id="appendformtask"></div>
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
  <script type="text/javascript">
    $(document).ready(function(){
      let wrapper = $('form')
      let max = 10
      let start = 1
      $("#tambah").on('click',function(){
        if (start<max) {
        start++
          let formtask ='<div>'
                        +'<span class="mb-3 btn btn-danger rmvBtn"><b>- (Kurangi Form)</b></span>'
                        +'<div class="form-group">'
                        +'<label>Tugas</label>'
                        +'<input type="text" name="tugas[]" class="form-control" required>'
                        +'<div class="invalid-feedback mt-2">Tugas harus diisi.</div>'
                        +'</div>'
                        +'<div class="form-group">'
                        +'<label>Ruangan</label>'
                        +'  <select class="form-control" name="ruangan[]">'
                        +'    <?php foreach ($room as $data): ?>'
                        +'      <option value="<?=$data['room_id']?>"><?=$data['room_name']?></option>'
                        +'    <?php endforeach ?>'
                        +'  </select>'
                        +'</div>'
                        +'</div>'
          $("#appendformtask").append(formtask)
        }else{
          alert("maksimal 10 saja")
        }
      })
      $(wrapper).on('click','.rmvBtn',function(e){
        e.preventDefault()
        $(this).parent('div').remove()
        start--
      })
    })


    window.addEventListener(
      "load",
      function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName("needs-validation");
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
          form.addEventListener(
            "submit",
            function(event) {
              if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
              }
              form.classList.add("was-validated");
            },
            false
          );
        });
      },
      false
    );

  </script>
</html>