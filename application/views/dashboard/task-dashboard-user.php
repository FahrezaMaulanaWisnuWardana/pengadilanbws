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
            <?php if ($this->session->flashdata('message')) $this->load->view('partials/toast') ?>
              <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between">
                  <h5><?=$judul?></h5>
                  <a href="<?=base_url()?>" class="btn btn-success"><i class="fas fa-chevron-left"></i></a>
                </div>
                <div class="card-body">
                  <ul class="list-group mb-5">
                    <li class="list-group-item"><h5 class="font-weight-bold">Tugas</h5></li>
                        <?php
                          $no=0;
                          if (count($tugas)===0) {
                            ?>
                                <li class="list-group-item">Kamu belum memiliki tugas</li>
                            <?php
                          }else{
                            foreach ($tugas as $data) {
                              $no++;
                              ?>
                                <li class="list-group-item"><?=$data['task']?></li>
                              <?php
                            }
                          }
                         ?>
                  </ul>
                  <?php 
                    if (count($tugas)>0) {
                      ?>
                        <?=form_open('beranda/simpan-tugas',array('enctype'=>'multipart/form-data'))?>
                          <div class="form-group frm-cont">
                            <input type="hidden" name="room_id" value="<?=$data['room_id']?>">
                            <label class="d-block">Eviden( <small class="text-danger">Maksimal 5 foto</small> )</label>
                            <input type="file" name="foto[]" class="img" accept="image/*" multiple="true">
                          </div>
                          <button type="submit" class="btn btn-success form-control eviden">Tambah Data</button>
                        <?=form_close()?>
                        <div class="btn-cont">
                          
                        </div>
                        <label class="h5 my-3">Eviden</label>
                        <div class="task" data-id="<?=$data['room_id']?>">
                          
                        </div>
                      <?php
                    }
                   ?>
                </div>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <div class="modal fade" id="edit-tugas" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Eviden</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body cek-tugas">
              <?=form_open('beranda/edit-tugas',array('enctype'=>'multipart/form-data'))?>
                <div class="form-group">
                  <label>Ruangan</label>
                  <input type="text" readonly name="ruangan" class="form-control ruangan">
                  <input type="hidden" name="room_id" class="ruang-hide">
                </div>
                <div class="form-group">
                  <label>Eviden</label>
                  <input type="file" name="foto[]" class="img" accept="image/*" multiple="true">
                </div>
                <button type="submit" class="btn btn-success form-control">Ubah Data</button>
              <?=form_close()?>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="cek-eviden" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Eviden</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body cek-eviden"></div>
          </div>
        </div>
      </div>
      <!-- End of Main Content -->
	<?php $this->load->view('templates/footer-dashboard') ?>
  <script type="text/javascript">
    $('.img').on('change',function(){
      if($(this).get(0).files.length>5){
        alert("Maksimal gambar hanya 5")
        $(this).val("")
      }
    })
    $.ajax({
      url:"<?=base_url('beranda/cek-gambar')?>",
      method:"POST",
      data:{'id':$('.task').data('id')},
      dataType:'json',
      success:function(data){
        let imageHtml=''
        for (var i = 0; i < data.item.length; i++) {
          imageHtml += '<img src="<?=base_url()?>assets/img/eviden/'+data.item[i]+'" style="width:200px;" class="text-center d-inline ml-1 mt-1 img-eviden">'
        }
        $('.eviden').prop('disabled','disabled')
        $('.eviden').remove()
        $('.frm-cont').remove()
        $('.btn-cont').html('<button class="btn btn-success edit form-control" data-id="'+data.id+'"><i class="fas fa-pen"></i></button>')
        $('.task').html(imageHtml)
      }
    })
    $(document).on('click','.img-eviden',function(){
      $('#cek-eviden').modal('show')
      let imgsrc = $(this).attr('src')
      $('.cek-eviden').html('<img src="'+imgsrc+'" class="img-fluid">')   
    })
    $(document).on('click','.edit',function(){
      $('#edit-tugas').modal('show')
      $.ajax({
        url:"<?=base_url('beranda/tugas-ruangan')?>",
        data:{'id':$(this).data('id')},
        method:"POST",
        dataType:'json',
        success:function(data){
          $('.ruangan').val(data.item.room_name)
          $('.ruang-hide').val(data.item.room_id)
        }
      })
    })
  </script>
</html>