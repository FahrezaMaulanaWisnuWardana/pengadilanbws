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
                    <?=form_open('beranda/simpan-tugas',array('enctype'=>'multipart/form-data'))?>
                    <table class="table table-bordered text-center" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>No.</th>
                          <th>Tugas.</th>
                          <th>Aksi</th>
                          <th>Eviden.</th>
                          <?php 
                            if ($this->session->role_name==="pimpinan") {
                              ?>
                              <th>Nilai</th>
                              <?php
                            }
                           ?>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $no =1;
                          foreach ($tugas as $data) {
                            ?>
                              <tr>
                                <td class="align-middle"><?=$no++?></td>
                                <td class="align-middle"><?=$data['task']?></td>
                                <td class="align-middle">
                                  <div class="form-group">
                                    <input type="hidden" name="urid[]" value="<?=$data['user_room_id']?>">
                                    <input type="checkbox" name="tugas[]" value="<?=$data['task_id']?>" style="transform: scale(2.5);" class="checkbox mr-3" required>
                                    <?php 
                                        if ($this->session->role_name!=="pimpinan") {
                                          ?>
                                            <button class="btn btn-success edit" type="button" disabled><i class="fas fa-pen"></i></button>
                                          <?php
                                        }
                                     ?>
                                  </div>
                                </td>
                                <td class="align-middle">
                                <input type="hidden" class="id" value="<?=$data['user_room_id']?>">
                                <?php 
                                  if ($this->session->role_name==="pimpinan") {
                                    ?>
                                      <button type="button" class="btn btn-primary lihat" data-id="<?=$data['task_id']?>">
                                        Lihat foto
                                      </button>
                                    <?php
                                  }else{
                                    ?>
                                      <input type="file" name="foto[]" capture="camera" class="img" accept="image/*">
                                      <button type="button" data-id="<?=$data['task_id']?>" class="btn btn-success lihat" style="visibility: hidden;">Lihat gambar</button>
                                    <?php
                                  }
                                 ?>
                                </td>
                                <?php 
                                  if ($this->session->role_name==="pimpinan") {
                                    ?>
                                    <td class="align-middle">
                                      <div class="form-group">
                                        <select class="form-control nilai"  onFocus="this.oldIndex = this.selectedIndex" onChange="if(!confirm('Beri nilai untuk tugas ini?'))this.selectedIndex = this.oldIndex" data-id="<?=$data['task_id']?>">
                                          <option value="1">Pilih nilai</option>
                                          <option value="4">Hijau</option>
                                          <option value="3">Kuning</option>
                                          <option value="2">Merah</option>
                                        </select>
                                      </div>
                                    </td>
                                    <?php
                                  }
                                 ?>
                              </tr>
                            <?php
                          }
                         ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <th>No.</th>
                          <th>Tugas.</th>
                          <th>Aksi</th>
                          <th>Eviden.</th>
                          <?php 
                            if ($this->session->role_name==="pimpinan") {
                              ?>
                              <th>Nilai</th>
                              <?php
                            }
                           ?>
                        </tr>
                      </tfoot>
                    </table>
                    <?php 
                        if ($this->session->role_name!=="pimpinan") {
                          ?>
                            <div class="text-center">
                              <button type="submit" class="btn w-25 btn-success" id="btn"><i class="fas fa-plus"></i></button>
                            </div>
                          <?php
                        }
                     ?>
                    <?=form_close()?>
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
              ...
            </div>
          </div>
        </div>
      </div>
      <!-- End of Main Content -->
	<?php $this->load->view('templates/footer-dashboard') ?>
  <script type="text/javascript">
    $(document).ready(function(){

      var today = new Date();
      var dd = String(today.getDate()).padStart(2, '0');
      
      $.ajax({
        url:"<?=base_url('beranda/cek-tugas')?>",
        method:"POST",
        dataType:'json',
        success:function(data){
          for (var i = 0; i < data.item.length; i++) {
            if (new Date(data.item[i].date).getDate()===parseInt(dd)){
              $('.img').prop('disabled',true)
              $('.edit').prop('disabled',false)
              $('#btn').prop('disabled',true)
              $('.checkbox').prop('disabled',true)
              $('.checkbox').prop('checked',true)
              <?=($this->session->role_name!=="pimpinan")?"$('.lihat').css({'visibility':'visible'})":''?>
            }
          }
        }
      })
      $('.lihat').on('click',function(){
          $.ajax({
            url:"<?=base_url('beranda/cek-gambar')?>",
            method:"POST",
            data:{'id':$(this).data('id')},
            dataType:'json',
            success:function(data){
              if (data.item!==null){
                $('#cek-tugas').modal('show')
                if(data.item.eviden===null){
                  $('.cek-tugas').html('<span class="text-center mt-5">Gambar kosong</span>')
                }else{
                  $('.cek-tugas').html('<img src="<?=base_url()?>assets/img/eviden/'+data.item.eviden+'" class="img-fluid">')
                }
              }
            }
          })
      })
      $('.edit').on('click',function(){
        let checkbox = $(this).prev('.checkbox')
        let fileImg = $(this).closest('td').next('td').find('.img')
        $(this).prop('disabled',true)
        checkbox.prop('disabled',false)
        checkbox.on('click',function(){
          if (confirm('Ketika gambar diganti maka gambar sebelumnya akan hilang')){
            if ($(this).is(':checked')===true){
              $.ajax({
                url:"<?=base_url('beranda/cek-tugas')?>",
                method:"POST",
                dataType:'json',
                success:function(data){
                  for (var i = 0; i < data.item.length; i++) {
                    if (new Date(data.item[i].date).getDate()===parseInt(dd) && data.item[i].task_id === checkbox.val()){
                      fileImg.attr('data-task-id',data.item[i].id_user_task)
                    }
                  }
                }
              })
              fileImg.prop('disabled',false)
              fileImg.on('change',function(){
              let formData = new FormData()
              formData.append('foto',fileImg[0].files[0])
              formData.append('id',fileImg.data('task-id'))
                $.ajax({
                  url:"<?=base_url('beranda/update-tugas')?>",
                  method:"POST",
                  data: formData,
                  dataType:'json',
                  mimeType:'multipart/form-data',
                  contentType: false,
                  cache: false,
                  processData: false,
                  success:function(data){
                    alert("Gambar berhasil diubah")
                    location.reload()
                  }
                })
              })
            }else{
              fileImg.prop('disabled',true)
            }
          }else{
            return false
          }
          fileImg.on('change',function(){

          })
        })
        checkbox.prop('checked',false)
      })
      $('.nilai').on('change',function(){
        $.ajax({
          url:"<?=base_url('beranda/update-nilai')?>",
          data:{
            id:$(this).data('id'),
            leader:<?=$this->session->user_id?>,
            score:$(this).val()
          },
          method:"POST",
          dataType:'json',
          success:function(data){
            if (data.status===1){
              location.reload()
            }
          }
        })
      })
      <?php 
          if ($this->session->role_name==="pimpinan") {
            ?>
              $('.nilai').each(function(){
                let score = $(this)
                $.ajax({
                  url:"<?=base_url('beranda/cek-gambar')?>",
                  data:{
                    id:$(this).data('id')
                  },
                  method:"POST",
                  dataType:'json',
                  success:function(data){
                    console.log(data)
                    if (data.item===null){
                      $(':input').prop('disabled','disabled')
                    }else{
                      score.val(data.item.score)
                    }
                  }
                })
              })
            <?php
          }
       ?>

    })
  </script>
</html>