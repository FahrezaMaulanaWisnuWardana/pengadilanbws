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
                  <h5><?=$judul.' '.$ruangan['room_name']?></h5>
                  <span id="tambah" class="btn btn-success"><i class="fas fa-plus"></i></span>
                </div>
                <div class="card-body">
                  <?=form_open('ruangan/pengguna/simpan', array('class' => 'needs-validation', 'novalidate' => true))?>
                    <input type="hidden" name="id" value="<?=$ruangan['room_id']?>">
                    <div class="form-group">
                      <label>Pengguna</label>
                      <select class="form-control" name="pengguna[]">
                        <option disabled selected>Silahkan pilih akun</option>
                        <?php 
                          foreach ($pengguna as $data) {
                            if ($data['id_role']!=='1' && $data['id_role']!=='4') {
                              ?>
                                <option value="<?=$data['user_id']?>"><?=$data['full_name']?></option>
                              <?php
                            }
                          }
                         ?>
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
                        + '<span class="mb-3 btn btn-danger rmvBtn"><i class="fas fa-times"></i></span>'
                        + '<div class="form-group">'
                        + '<label>Pengguna</label>'
                        +'<select class="form-control appended-select" name="pengguna[]">'
                        + '<option disabled selected>Silahkan pilih akun</option>'
                              <?php 
                                foreach ($pengguna as $data) {
                                    ?>
                        +             '<option value="<?=$data['user_id']?>"><?=$data['full_name']?></option>'
                                    <?php
                                }
                               ?>
                        +'</select>'
                        +'</div>'
                        +'</div>'
          let selected = [];
          $('select').map(function () {
            $(this).val() && selected.push($(this).val())
          })
          $("#appendformtask").append(formtask)

          selected.forEach((value, index) => {
             $('.appended-select').find(`option[value="${value}"]`).attr('disabled', true);
          })
          $('.appended-select').removeClass('appended-select')
          
        }else{
          alert("maksimal 10 saja")
        }
      })
      $(wrapper).on('click','.rmvBtn',function(e){
        e.preventDefault()
        $(this).parent('div').remove()
        start--
      })

        $(document).on('change', 'select', function () {
          let selected = [];
          $('select').map(function () {
            $(this).val() && selected.push($(this).val())
          })

          $('select').not($(this)).each(function (index, elem) {
            selected.forEach((value, index) => {
              if ($(elem).val() !== value) {
                $(elem).find(`option[value="${value}"]`).attr('disabled', 1);
              }
            })
          });
        })
    })
  </script>
</html>