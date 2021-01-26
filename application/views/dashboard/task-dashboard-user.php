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
                        <tr>
                          <th>No.</th>
                          <th>Tugas.</th>
                          <th>Eviden.</th>
                          <th>Aksi</th>
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
                                  <input type="hidden" class="id" value="<?=$data['user_room_id']?>">
                                  <input type="file" name="foto" capture="camera" data-task-id="<?=$data['task_id']?>" class="img" accept="image/*">
                                </td>
                                <td class="align-middle">
                                  <div class="form-group">
                                    <input disabled type="checkbox" name="tugas" data-task-id="<?=$data['task_id']?>" data-id="" data-aksi="tambah" value="<?=$data['task_id']?>" style="transform: scale(2.5);" class="checkbox mr-3">
                                    <button class="btn btn-success edit"><i class="fas fa-pen"></i></button>
                                    <small class="d-block text-primary warn">Silahkan centang jika telah upload file</small>
                                  </div>
                                </td>
                              </tr>
                            <?php
                          }
                         ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <th>No.</th>
                          <th>Tugas.</th>
                          <th>Eviden.</th>
                          <th>Aksi</th>
                        </tr>
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
      <!-- End of Main Content -->
	<?php $this->load->view('templates/footer-dashboard') ?>
  <script type="text/javascript">
    $(document).ready(function(){
      let file, tagimg , ri , ti
      var today = new Date();
      var dd = String(today.getDate()).padStart(2, '0');
      $.ajax({
        url:"<?=base_url('beranda/cek-tugas/'.$this->uri->segment(3))?>",
        method:"POST",
        dataType:'json',
        success:function(data){
          let count = 0;
          let countcheck = 0;
          let arritem = []
          for (var i = 0; i < data.item.length; i++) {
            if (data.item[i].user_id==="<?=$this->session->user_id?>"){
              if (new Date(data.item[i].date).getDate()===parseInt(dd)){
                arritem.push(parseInt(data.item[i].task_id))
              }
            }
          }
          $('.img').each(function(){
            if (arritem.includes($(this).data('task-id'))) {
              $(this).prop('disabled','disabled')
            }
          })
          $('.checkbox').each(function(){
            if (arritem.includes($(this).data('task-id'))) {
              $(this).prop('disabled','disabled')
              $(this).attr('data-id',data.item[count++].id_user_task)
              $(this).prop('checked',true)
              $(this).next('button').next('.warn').text('File telah terupload')
              $(this).next('button').next('.warn').removeClass('text-primary')
              $(this).next('button').next('.warn').addClass('text-success')
            }
          })
        }
      })
      $('.img').on('change',function(){
          tagimg = $(this)
          file = tagimg[0].files[0]
          ri = $(this).prev('input').val();
          ti = $(this).closest('td').next('td').find('input').val();
          if (file===undefined) {
            $(this).closest('td').next('td').find('input').prop('disabled','disabled');
            $(this).closest('td').next('td').find('input').prop('checked',false);
          }else{
            let checkbox = $(this).closest('td').next('td').find('input')
            checkbox.prop('disabled',false);
            $(checkbox).on('click',function(){
              if (confirm('Pastikan data telah valid')) {
                    let data = new FormData()
                    data.append('foto',file)
                    data.append('aksi',$(this).data('aksi'))
                    if ($(this).data('id')!=='') {
                      data.append('id',$(this).data('id'))
                    }
                    data.append('room',ri)
                    data.append('task',ti)
                    $.ajax({
                      url : "<?=base_url('beranda/simpan-tugas')?>",
                      method:"POST",
                      data:data,
                      dataType: 'json',
                      mimeType: 'multipart/form-data',
                      contentType: false,
                      cache: false,
                      processData: false,
                      success:function(data){
                        if(data.status === 1){
                          $.ajax({
                            url:"<?=base_url('beranda/cek-tugas/'.$this->uri->segment(3))?>",
                            method:"POST",
                            dataType:'json',
                            success:function(data){
                              let counter = 0;
                              let countcheck = 0;
                              let arritem = []
                              for (var i = 0; i < data.item.length; i++) {
                                if (new Date(data.item[i].date).getDate()===parseInt(dd)){
                                  arritem.push(parseInt(data.item[i].task_id))
                                }
                              }
                              $('.img').each(function(){
                                if (arritem.includes($(this).data('task-id'))) {
                                  $(this).prop('disabled','disabled')
                                }
                              })
                              $('.checkbox').each(function(){
                                if (arritem.includes($(this).data('task-id'))) {
                                  $(this).prop('disabled','disabled')
                                  $(this).attr('data-id',data.item[counter++].id_user_task)
                                  $(this).prop('checked',true)
                                  $(this).next('button').next('.warn').text('File telah terupload')
                                  $(this).next('button').next('.warn').removeClass('text-primary')
                                  $(this).next('button').next('.warn').addClass('text-success')
                                }
                              })
                            }
                          })
                          checkbox.closest('td').prev('td').find('input').prop('disabled',true)
                        }else{
                          checkbox.next('button').next('.warn').text('Gagal simpan data')
                          checkbox.next('button').next('.warn').removeClass('text-primary')
                          checkbox.next('button').next('.warn').addClass('text-danger')
                        }
                      }
                    })
                    location.reload()
              }else{
                return false
              }
            })
          }
      })
      $('.edit').on('click',function(){
          $(this).prev('input').prop('checked',false)
          $(this).prev('input').attr('data-aksi','update')
          $(this).next('small').text('Silahkan centang jika telah upload file')
          $(this).next('small').addClass('text-primary')
          $(this).next('small').removeClass('text-success')
          $(this).closest('td').prev('td').find('input').prop('disabled',false)
      })

    })
  </script>
</html>