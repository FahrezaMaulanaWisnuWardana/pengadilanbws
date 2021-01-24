

    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background:#43aa8b">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?=base_url('beranda')?>">
        <div class="sidebar-brand-icon">
          <img src="<?=base_url('assets/img/icon.png')?>" style="width:40px;">
        </div>
        <div class="sidebar-brand-text mx-3">Checklist Kebersihan</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Menu
      </div>
      <li class="nav-item <?=($this->uri->segment(1)==="beranda")?'active':''?>">
        <a class="nav-link" href="<?=base_url('beranda')?>">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Beranda</span></a>
      </li>
      <li class="nav-item <?=($this->uri->segment(1)==="ruangan")?'active':''?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRuangan" aria-expanded="true" aria-controls="collapseRuangan">
          <i class="fas fa-fw fa-home"></i>
          <span>Ruangan</span>
        </a>
        <div id="collapseRuangan" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Menu Ruangan:</h6>
            <a class="collapse-item <?=($this->uri->segment(1)==="ruangan" && $this->uri->segment(2)===NULL)?'active text-success':''?>" href="<?=base_url('ruangan')?>">Daftar Ruangan</a>
            <a class="collapse-item <?=($this->uri->segment(1)==="ruangan" && $this->uri->segment(2)==="tambah")?'active text-success':''?>" href="<?=base_url('ruangan/tambah')?>">Tambah Ruangan</a>
            <a class="collapse-item <?=($this->uri->segment(1)==="ruangan" && $this->uri->segment(2)==="pengguna")?'active text-success':''?>" href="<?=base_url('ruangan/tambah')?>">Ruangan Pengguna</a>
          </div>
        </div>
      </li>
      <li class="nav-item <?=($this->uri->segment(1)==="pengguna")?'active':''?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePengguna" aria-expanded="true" aria-controls="collapsePengguna">
          <i class="fas fa-fw fa-users"></i>
          <span>Pengguna</span>
        </a>
        <div id="collapsePengguna" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Menu Pengguna:</h6>
            <a class="collapse-item <?=($this->uri->segment(1)==="pengguna" && $this->uri->segment(2)===NULL)?'active text-success':''?>" href="<?=base_url('pengguna')?>">Daftar Pengguna</a>
            <a class="collapse-item <?=($this->uri->segment(1)==="pengguna" && $this->uri->segment(2)==="pengguna")?'active text-success':''?>" href="<?=base_url('pengguna/tambah')?>">Tambah Pengguna</a>
          </div>
        </div>
      </li>
      <li class="nav-item <?=($this->uri->segment(1)==="hak-akses")?'active':''?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseHak" aria-expanded="true" aria-controls="collapseHak">
          <i class="fas fa-fw fa-bookmark"></i>
          <span>Hak Akses</span>
        </a>
        <div id="collapseHak" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Menu Hak Akses:</h6>
            <a class="collapse-item <?=($this->uri->segment(1)==="hak-akses" && $this->uri->segment(2)===NULL)?'active text-success':''?>" href="<?=base_url('hak-akses')?>">Daftar Hak Akses</a>
            <a class="collapse-item <?=($this->uri->segment(1)==="hak-akses" && $this->uri->segment(2)==="tambah")?'active text-success':''?>" href="<?=base_url('hak-akses/tambah')?>">Tambah Hak Akses</a>
          </div>
        </div>
      </li>
      <li class="nav-item <?=($this->uri->segment(1)==="tugas")?'active':''?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTugas" aria-expanded="true" aria-controls="collapseTugas">
          <i class="fas fa-fw fa-book"></i>
          <span>Tugas</span>
        </a>
        <div id="collapseTugas" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Menu Tugas:</h6>
            <a class="collapse-item <?=($this->uri->segment(1)==="tugas" && $this->uri->segment(2)===NULL)?'active text-success':''?>" href="<?=base_url('tugas')?>">Daftar Tugas</a>
            <a class="collapse-item <?=($this->uri->segment(1)==="tugas" && $this->uri->segment(2)==="tambah")?'active text-success':''?>" href="<?=base_url('tugas/tambah')?>">Tambah Tugas</a>
            <a class="collapse-item <?=($this->uri->segment(1)==="tugas" && $this->uri->segment(2)==="ruangan")?'active text-success':''?>" href="<?=base_url('tugas/tambah')?>">Tugas per ruangan</a>
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
          <i class="fas fa-fw fa-info"></i>
          <span>Laporan</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->