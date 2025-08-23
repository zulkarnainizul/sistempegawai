<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class RiwayatStatusKerja extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if($this->session->userdata('logged') !== TRUE){
            redirect('Login');
        }
        $this->load->model('RiwayatStatusKerja_model'); 
        $this->load->helper('tanggal');
    }

    public function index($id_pegawai)
    {
        $data['title'] = 'Detail Pegawai';
        $data['riwayat_status_kerja'] = $this->RiwayatStatusKerja_model->get_by_pegawai($id_pegawai);
        $data['id_pegawai'] = $id_pegawai;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pegawai/detailpegawai/riwayatstatuskerja', $data);
        $this->load->view('templates/footer');
    }
    
}
