<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-dark bg-success">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button">
        <i class="fas fa-bars"></i>
      </a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- User Dropdown Menu -->
    <li class="nav-item dropdown">
      <a class="nav-link" style="padding-top: 3px;" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
        <div class="d-flex align-items-center my-auto">
          <span class="ml-2 d-none d-lg-inline-block text-white" style="font-family: 'Poppins', sans-serif;">
            Hallo, <?= $this->session->userdata('username') ?>
          </span>
          <img src="<?= base_url('assets/template/') ?>dist/img/profile.png" 
               class="img-circle elevation-2 img-size-32 img-bordered-sm ml-2" 
               alt="User Image"> 
        </div>
      </a>
      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown" style="min-width: 100px;">
      <a href="<?= base_url('Login/logout') ?>" class="dropdown-item">
        <i class="fas fa-sign-out-alt mr-2"></i> Logout
      </a>
    </div>
    </li>
  </ul>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-2 sidebar-light-success">
  <!-- Brand Logo -->
  

  <a href="Dashboard" class="brand-link navbar-success d-flex">
    <img src="<?= base_url('assets/template/') ?>dist/img/logosmk.png" alt="Logo SMK" class="brand-image img-circle">
    <div class="d-flex flex-column justify-content-center" style="line-height: 1;">
      <span class="brand-text text-white font-weight-bold" style="font-size: 1.3rem;">Sistem Pegawai</span>
      <span class="brand-text text-white" style="font-size: 0.5rem;">SMKN 2 Pekanbaru</span>
    </div>
  </a>
  
  <!-- Sidebar Admin-->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?= base_url('assets/template/') ?>dist/img/profile.png" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a class="d-block"><?= $this->session->userdata('role') ?> </a> <!-- Dynamically set name -->
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a  style="padding-top:6px;  padding-bottom:6px;" href="<?= base_url('Dashboard') ?>" class="nav-link <?php if ($this->uri->segment(1) == 'Dashboard') echo 'active' ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i> <!-- Dashboard icon remains the same -->
            <p>Dashboard</p>
          </a>
        </li>
        <?php
        $uri_segment1 = $this->uri->segment(1);
        $controllers_pegawai = ['Pegawai', 'RiwayatPendidikan', 'RiwayatGolongan', 'RiwayatJabatan', 'RiwayatStatusPegawai', 'RiwayatStatusKerja'];
        ?>
        <li class="nav-item">
          <a style="padding-top: 6px; padding-bottom: 6px;" 
            href="<?= base_url('Pegawai') ?>" 
            class="nav-link <?= in_array($uri_segment1, $controllers_pegawai) ? 'active' : '' ?>">
            <i class="nav-icon fas fa-users"></i>
            <p>Data Pegawai</p>
          </a>
        </li> 
        <li class="nav-item">
          <a style=" padding-top: 6px;  padding-bottom: 6px; " href="<?= base_url('Absensi') ?>" class="nav-link <?php if ($this->uri->segment(1) == 'Absensi') echo 'active' ?>">
            <i class="nav-icon fas fa-user-check"></i> 
            <p>
              Absensi Pegawai
             </p>
          </a>
        </li> 

        <?php if ($this->session->userdata('role') == 'Admin Kepegawaian') : ?>
          <li class="nav-header" style=" padding-top: 12px;">MENU ADMINISTRASI</li>
          <li class="nav-item">
            <a style=" padding-top: 6px;  padding-bottom: 6px; " href="<?= base_url('SuratTugas') ?>" class="nav-link <?php if ($this->uri->segment(1) == 'SuratTugas') echo 'active' ?>">
              <i class="nav-icon fas fa-envelope-open-text"></i>
              <p>Surat Tugas</p>
            </a>
          </li>
          <li class="nav-item">
            <a style=" padding-top: 6px;  padding-bottom: 6px; " href="<?= base_url('SuratCuti') ?>" class="nav-link <?php if ($this->uri->segment(1) == 'SuratCuti') echo 'active' ?>">
              <i class="nav-icon fas fa-calendar-alt"></i>
              <p>Surat Cuti</p>
            </a>
          </li>
          <li class="nav-item">
            <a style=" padding-top: 6px;  padding-bottom: 6px; " href="<?= base_url('SuratKeterangan') ?>" class="nav-link <?php if ($this->uri->segment(1) == 'SuratKeterangan') echo 'active' ?>">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>Surat Keterangan</p>
            </a>
          </li>
          <li class="nav-header" style=" padding-top: 12px; ">MENU KEPEGAWAIAN</li>
          
          <li class="nav-item">
            <a style=" padding-top: 6px;  padding-bottom: 6px; " href="<?= base_url('Golongan') ?>" class="nav-link <?php if ($this->uri->segment(1) == 'Golongan') echo 'active' ?>">
              <i class="nav-icon fas fa-layer-group"></i> <!-- Updated icon for Golongan Pegawai -->
              <p>Golongan Pegawai</p>
            </a>
          </li>
          <li class="nav-item">
            <a style=" padding-top: 6px;  padding-bottom: 6px; " href="<?= base_url('Jabatan') ?>" class="nav-link <?php if ($this->uri->segment(1) == 'Jabatan') echo 'active' ?>">
              <i class="nav-icon fas fa-briefcase"></i> <!-- Updated icon for Jabatan Pegawai -->
              <p>Jabatan Pegawai</p>
            </a>
          </li>
          <li class="nav-item">
            <a style=" padding-top: 6px;  padding-bottom: 6px; " href="<?= base_url('Status') ?>" class="nav-link <?php if ($this->uri->segment(1) == 'Status') echo 'active' ?>">
              <i class="nav-icon fas fa-user-tag"></i> <!-- Updated icon for Status Pegawai -->
              <p>Status Pegawai</p>
            </a>
          </li>
        <?php endif; ?>  
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar Admin-->
</aside>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <!-- Title Section -->
        <div class="col-lg-6 col-md-6 col-sm-12">
          <h1 class="m-0 text-dark"><?= $title ?></h1>
        </div>
        <!-- Breadcrumb Section -->
        <div class="col-lg-6 col-md-6 col-sm-12">
          <ol class="breadcrumb float-lg-right float-md-right float-sm-left float-left">
            <li class="breadcrumb-item"><a href="Dashboard">Home</a></li>
            <li class="breadcrumb-item active"><?= $title ?></li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">


