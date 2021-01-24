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
                        <option>Silahkan pilih akun</option>
                        <?php 
                          foreach ($pengguna as $data) {
                              ?>
                                <option value="<?=$data['user_id']?>"><?=$data['full_name']?></option>
                              <?php
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
      let arr = []
      $("#tambah").on('click',function(){
        if (start<max) {
        start++
          let sel = '<select class="form-control" name="pengguna[]">'
                        + '<option>Silahkan pilih akun</option>'
                              <?php 
                                foreach ($pengguna as $data) {
                                    ?>
                        +             '<option value="<?=$data['user_id']?>"><?=$data['full_name']?></option>'
                                    <?php
                                }
                               ?>
                        +'</select>'
          let formtask ='<div>'
                        + '<span class="mb-3 btn btn-danger rmvBtn"><i class="fas fa-times"></i></span>'
                        + '<div class="form-group">'
                        + '<label>Pengguna</label>'+sel
                        +'</div>'
                        +'</div>'
          $('select').each(function(){
            arr.push($(this).val())
          })
          arr.forEach(function(item,index){
            $("option[value='"+item+"']",$(sel)[0]).val(item).attr('disabled','disabled')
          })
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
      $(document).on('change','select',function(){
          let sel = $(this).children("option:selected").val()
          $("select").not(this).each(function(){
            console.log(this)
            $("option[value='"+sel+"']",this).val(sel).attr('disabled','disabled')
          })
      });
    })
  </script>
</html>