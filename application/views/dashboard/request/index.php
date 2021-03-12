<!DOCTYPE html>
<html>
<head>
	<?php $this->load->view('templates/head-dashboard');?>
  <link href="<?=base_url('assets/vendor/datatables/dataTables.bootstrap4.min.css')?>" rel="stylesheet">
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
                  <div>
                    <span class="btn btn-success" id="tambah" style="cursor: pointer;"><i class="fas fa-plus"></i></span>
                    <a href="<?=base_url()?>" class="btn btn-success"><i class="fas fa-chevron-left"></i></a>
                  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                      <thead>
                        <th>No.</th>
                        <th>Permintaan.</th>
                        <th>Ruangan.</th>
                        <th>Tanggal.</th>
                        <th>Aksi.</th>
                      </thead>
                      <tbody>
                        <?php 
                        $no = 1;
                            foreach ($req as $data) {
                              ?>
                              <tr>
                                <td><?=$no++?></td>
                                <td><?=$data['judul']?></td>
                                <td><?=$data['room_name']?></td>
                                <td><?= strftime('%d %B %Y', strtotime($data['created_at'])) ?></td>
                                <td><span class="btn btn-success text-center detail" data-id="<?=$data['id_urequest']?>">Detail</span></td>
                              </tr>
                              <?php
                            }
                         ?>
                      </tbody>
                      <tfoot>
                        <th>No.</th>
                        <th>Permintaan.</th>
                        <th>Ruangan.</th>
                        <th>Tanggal.</th>
                        <th>Aksi.</th>
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

      <div class="modal fade" id="tambah-permintaan" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Eviden</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body cek-tugas">
              <?=form_open('permintaan/simpan-permintaan')?>
                <div class="form-group">
                  <label>Username</label>
                  <input type="text" disabled value="<?=$this->session->username?>" class="form-control">
                </div>
                <div class="form-group">
                  <label>Judul permintaan</label>
                  <input type="text" name="judul" class="form-control">
                </div>
                <div class="form-group">
                  <label>Peminta</label>
                  <select class="form-control" name="uid">
                    <?php 
                      foreach ($user as $dataUser) {
                        if ($dataUser['id_role']!=='1' && $dataUser['id_role']!=='4') {
                          ?>
                          <option value="<?=$dataUser['user_id']?>"><?=$dataUser['full_name']?></option>
                          <?php
                        }
                      }
                     ?>
                  </select>
                </div>
                <div class="form-group">
                  <label>Ruangan</label>
                  <select class="form-control" name="room_id">
                    <?php 
                      foreach ($room as $data) {
                          ?>
                          <option value="<?=$data['room_id']?>"><?=$data['room_name']?></option>
                          <?php
                      }
                     ?>
                  </select>
                </div>
                <div class="form-group">
                  <div class="d-flex justify-content-between mb-1">
                    <label>Permintaan</label>
                    <span class="btn btn-success" id="permintaan-tambah" style="cursor: pointer;"><i class="fas fa-plus"></i></span>
                  </div>
                  <input type="text" name="request[]" class="form-control">
                </div>
                <div id="appendformtask"></div>
                <button type="submit" class="btn btn-success form-control">Tambah Data</button>
              <?=form_close()?>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="detail-permintaan" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Detail permintaan</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body cek-permintaan">
            </div>
          </div>
        </div>
      </div>
      <!-- End of Main Content -->
	<?php $this->load->view('templates/footer-dashboard') ?>
  <script src="<?=base_url('assets/vendor/datatables/jquery.dataTables.min.js')?>"></script>
  <script src="<?=base_url('assets/vendor/datatables/dataTables.bootstrap4.min.js')?>"></script>
  <script src="<?=base_url('assets/js/demo/datatables-demo.js')?>"></script>
  <script type="text/javascript">
    $('#tambah').on('click',function(){
      $('#tambah-permintaan').modal('show')
    })
      let max = 5
      let start = 1
      let wrapper = $('form')
    $('#permintaan-tambah').on('click',function(){
        if (start<max) {
        start++
          let formReq = `<div>
                         <span class="mb-3 btn btn-danger rmvBtn"><i class="fas fa-times"></i></span>
                         <div class="form-group">
                         <div class="d-flex justify-content-between mb-1">
                         <label>Permintaan</label>
                         </div>
                         <input type="text" name="request[]" class="form-control">
                         </div>
                         </div>`
          $("#appendformtask").append(formReq)
        }else{
          alert("maksimal "+max+" saja")
        }
    })
    $(wrapper).on('click','.rmvBtn',function(e){
      e.preventDefault()
      $(this).parent('div').remove()
      start--
    })
    $(".detail").on('click',function(){
      let id = $(this).data('id')
      $.ajax({
        url:"<?=base_url('permintaan/cek-permintaan')?>",
        data:{'id':id},
        method:"POST",
        dataType:'json',
        success:function(data){
          $('#detail-permintaan').modal('show')
          let html=''
            for (var i = 0; i < data.item.length; i++) {
              let con = data.item[i].status
              <?php 
                  if ($this->session->role==='4') {
                    ?>
                      html+=`<li class="list-group-item d-flex justify-content-between">
                            <span>${data.item[i].request}</span>
                            <div class="form-group">
                            <select data-id="${data.item[i].id_request}" class="form-control status">
                            <option value="1" ${(con==='1')?'selected':''}>Pilih</option>
                            <option value="2" ${(con==='2')?'selected':''}>Terima</option>
                            <option value="3" ${(con==='3')?'selected':''}>Stok Habis</option>
                            </select>
                            </div>
                            </li>`
                    <?php
                  }else{
                    ?>
                      let stat =''
                      if (con == '1') {
                        con = "Sedang di proses"
                        stat = 'primary'
                      }else if(con == '2'){
                        con = "Telah di acc"
                        stat = 'success'
                      }else if(con == '3'){
                        con = "Tidak di acc"
                        stat = 'danger'
                      }
                      html+='<li class="list-group-item d-flex justify-content-between"><span>'+data.item[i].request+'</span><span class="btn btn-'+stat+'">'+con+'</span></li>'
                    <?php
                  }
               ?>
            }
            $('.cek-permintaan').html('<ul class="list-group">'+html+'</ul>')
        }
      })
    })
    <?php 
      if ($this->session->role==='4') {
        ?>
          $(document).on('change','.status',function(){
            let tag = $(this)
            $.ajax({
              url:"<?=base_url('permintaan/update-permintaan')?>",
              data:{'id':tag.data('id'),'val':tag.val()},
              method:"POST",
              dataType:'json',
              success:function(data){
                if (data.status===1){
                  alert("Aksi telah berhasil dilakukan")
                }else{
                  alert("Aksi telah gagal dilakukan")
                }
              }
            })
          })
        <?php
      }
     ?>
  </script>
</html>