  <!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="icon" type="image/png" href="<?= base_url('assets/template/dist/img/logosmk.png') ?>">
  <title>Sistem Pegawai | <?= $title ?> </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Full Calender -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url('assets/template') ?>/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?= base_url('assets/template') ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/template') ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('assets/template') ?>/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
  <!-- Select2 -->
  <link rel="stylesheet" href="<?= base_url('assets/template') ?>/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/template') ?>/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Login -->
  <link rel="stylesheet" href="<?= base_url('assets/template') ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <style>
    /* Gaya tambahan untuk hover warna hijau */
    .nav-pills .nav-link,
    .nav-tabs .nav-link {
      color: #6c757d; /* Warna default untuk teks tab */
    }

    .nav-pills .nav-link.active,
    .nav-tabs .nav-link.active {
      background-color: #28a745; /* Warna hijau untuk tab aktif */
      color: white !important; /* Warna putih untuk link yang aktif */
    }

    .nav-pills .nav-link:hover,
    .nav-tabs .nav-link:hover {
      background-color: rgba(0, 0, 0, .1); /* Warna hijau untuk tab saat hover */
      color: black !important; /* Warna putih untuk teks saat hover */
    }

    .nav-pills .nav-link.active:hover,
    .nav-tabs .nav-link.active:hover {
      background-color: #28a745; /* Warna hijau untuk tab aktif saat hover */
      color: white !important; /* Warna putih untuk teks tab aktif saat hover */
    }

    /* Style Kalender */

    /* Gaya tombol navigasi */
    .fc-prev-button,
    .fc-next-button,
    .fc-today-button {
      background-color: #007bff; /* Warna latar belakang */
      color: #ffffff; /* Warna teks */
      border-color: #007bff; /* Warna border */
    }

    /* Gaya input kalender */
    .fc-button,
    .fc-button-primary {
      background-color: #28a745; /* Warna latar belakang */
      color: #ffffff; /* Warna teks */
      border-color: #28a745; /* Warna border */
    }
  </style>
</head>