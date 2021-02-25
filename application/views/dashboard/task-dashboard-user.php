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
                  <div class="table-responsive">
                    <table class="table table-bordered text-center" width="100%" cellspacing="0">
                      <thead>
                        <th>No.</th>
                        <th>Tugas.</th>
                        <th>Aksi.</th>
                        <th>Foto</th>
                      </thead>
                      <tbody>
                        <?php
                          $no=0;
                            foreach ($tugas as $data) {
                              $no++;
                              ?>
                              <tr>
                                <input type="hidden" name="room_id[]" value="<?=$data['room_id']?>">
                                <input type="hidden" name="task_id[]" value="<?=$data['task_id']?>">
                                <td><?=$no?></td>
                                <td><?=$data['task']?></td>
                                <td><button class="btn btn-success eviden" data-id="<?=$data['task_id']?>">Upload Eviden</button></td>
                                <td class="task" data-id="<?=$data['task_id']?>"></td>
                              </tr>
                              <?php 
                            }
                         ?>
                      </tbody>
                      <tfoot>
                        <th>No.</th>
                        <th>Tugas.</th>
                        <th>Aksi.</th>
                        <th>Foto</th>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <div class="modal fade" id="cek-tugas" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Eviden</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body cek-tugas">
              <?=form_open('beranda/simpan-tugas',array('enctype'=>'multipart/form-data'))?>
                <div class="form-group">
                  <label>Username</label>
                  <input type="text" disabled value="<?=$this->session->username?>" class="form-control">
                </div>
                <div class="form-group">
                  <label>Tugas</label>
                  <input type="text" disabled class="form-control tugas">
                  <input type="hidden" name="task_id" class="tugas-hide">
                </div>
                <div class="form-group">
                  <label>Ruangan</label>
                  <input type="text" readonly name="ruangan" class="form-control ruangan">
                  <input type="hidden" name="room_id" class="ruang-hide">
                </div>
                <div class="form-group">
                  <label>Eviden</label>
                  <input type="file" name="foto[]" class="img" accept="image/*" multiple="true">
                </div>
                <button type="submit" class="btn btn-success form-control">Tambah Data</button>
              <?=form_close()?>
            </div>
          </div>
        </div>
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
                  <label>Tugas</label>
                  <input type="text" disabled class="form-control tugas">
                  <input type="hidden" name="task_id" class="tugas-hide">
                </div>
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
    $('.task').each(function(){
      let tag = $(this)
        $.ajax({
          url:"<?=base_url('beranda/cek-gambar')?>",
          method:"POST",
          data:{'id':tag.data('id')},
          dataType:'json',
          success:function(data){
            let imageHtml=''
            for (var i = 0; i < data.item.length; i++) {
              imageHtml += '<img src="<?=base_url()?>assets/img/eviden/'+data.item[i]+'" style="width:50px;" class="d-inline ml-1 mt-1 img-eviden">'
            }
            if (parseInt(data.id) === tag.data('id')){
              $('.eviden').each(function(){
                if($(this).data('id') === parseInt(data.id)){
                  $(this).after('<button class="btn btn-success edit" data-id="'+data.id+'"><i class="fas fa-pen"></i></button>')
                  $(this).remove()
                }
              })
              tag.html(imageHtml)
            }
          }
        })
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
          $('.tugas').val(data.item.task)
          $('.tugas-hide').val(data.item.task_id)
          $('.ruangan').val(data.item.room_name)
          $('.ruang-hide').val(data.item.room_id)
        }
      })
    })
    $('.eviden').on('click',function(){
      $('#cek-tugas').modal('show')
      $.ajax({
        url:"<?=base_url('beranda/tugas-ruangan')?>",
        data:{'id':$(this).data('id')},
        method:"POST",
        dataType:'json',
        success:function(data){
          $('.tugas').val(data.item.task)
          $('.tugas-hide').val(data.item.task_id)
          $('.ruangan').val(data.item.room_name)
          $('.ruang-hide').val(data.item.room_id)
        }
      })
    })
  </script>
</html>