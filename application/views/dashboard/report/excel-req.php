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

          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"><?=$judul.' '.$ruangan['room_name']?></h1>
          </div>
            <?php if ($this->session->flashdata('message')) $this->load->view('partials/toast') ?>

          <!-- Content Row -->
          <div class="row">
            <div class="col-12">
                <div class="card border-left-success shadow h-100 py-2">
                  <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tabel-laporan">
                          <thead>
                            <tr class="text-center">
                              <th id="head-title" colspan="8" style="text-align: center;">Laporan Permintaan Ruang <?=$ruangan['room_name']?></th>
                            </tr>
                            <tr>
                              <th>No.</th>
                              <th>Judul Permintaan</th>
                              <th>Perwakilan</th>
                              <th>Petugas</th>
                              <th>Permintaan</th>
                              <th>Tanggal Permintaan</th>
                              <th>Tanggal Respon</th>
                              <th>Hasil</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php 
                            $no=0;
                                foreach ($lap as $data) {
                                  $no++;
                                  ?>
                                  <tr>
                                    <td><?=$no?></td>
                                    <td><?=$data['judul']?></td>
                                    <td><?=$data['username']?></td>
                                    <td><?=$data['username_req']?></td>
                                    <td><?=$data['request']?></td>
                                    <td><?=strftime('%Y-%m-%d', strtotime($data['created_at']))?></td>
                                    <td><?=strftime('%Y-%m-%d', strtotime($data['tgl_respon']))?></td>
                                    <td><?=($data['status']==='1')?'Acc':'Stok Habis'?></td>
                                  </tr>
                                  <?php
                                }
                             ?>
                              <tr>
                                <td colspan="5"></td>
                                <td colspan="3" style="text-align: center;">Mengetahui</td>
                              </tr>
                              <tr>
                                <td colspan="5"></td>
                                <td colspan="3" style="text-align: center;">Kab Sub Bagian Umum dan Keuangan</td>
                              </tr>
                              <tr height="70"></tr>
                              <tr>
                                <td colspan="5"></td>
                                <td colspan="3" style="text-align: center;">TTD</td>
                              </tr>
                              <tr>
                                <td colspan="5"></td>
                                <td colspan="3" style="text-align: center;"><?=$lap[0]['name_lead']?></td>
                              </tr>
                              <tr>
                                <td colspan="5"></td>
                                <td colspan="3" style="text-align: center;">NIP <?=$lap[0]['nip']?></td>
                              </tr>
                          </tbody>
                        </table>
                    </div>
                    <a download="<?=date('D-M-Y').$ruangan['room_name']?>.xls" href="#" class="btn mt-4 btn-success" onclick="return ExcellentExport.excel(this, 'tabel-laporan', 'Sheet Name Here');">Export to Excel</a>
                  </div>
                </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
  <?php $this->load->view('templates/footer-dashboard') ?>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/excellentexport@3.4.3/dist/excellentexport.min.js"></script>
</html>