<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Simulasi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Simulasi_model');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->helper('url');
    }

    /**
     * Menampilkan halaman form simulasi.
     */
    public function index()
    {
        $data['title'] = 'Simulasi Input Absensi Otomatis';
        
        // Ambil data untuk dropdown dari model
        $data['users'] = $this->Simulasi_model->get_all_userinfo();
        $data['machines'] = $this->Simulasi_model->get_all_machines();

        $this->load->view('templates/header', $data);
        $this->load->view('form_simulasi', $data);
    }

    /**
     * Memproses data simulasi dengan logika otomatis.
     */
    public function proses()
    {
        // Validasi hanya untuk input yang dipilih manual
        $this->form_validation->set_rules('userid', 'Nama Pegawai', 'required');
        $this->form_validation->set_rules('SN', 'Mesin Absensi', 'required');

        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, kembali ke form dengan pesan error
            $this->index();
        } else {
            // Tentukan Waktu Absen secara otomatis
            $waktu_sekarang = date('Y-m-d H:i:s');
            
            // Tentukan Tipe Absen (0=Masuk, 1=Keluar) berdasarkan jam
            $jam_sekarang = date('H'); // Format 00-23
            $tipe_absen_otomatis = ($jam_sekarang < 12) ? '0' : '1';

            // Siapkan data lengkap untuk disimpan
            $data_to_insert = [
                'userid'      => $this->input->post('userid'),
                'SN'          => $this->input->post('SN'),
                'checktime'   => $waktu_sekarang,
                'checktype'   => $tipe_absen_otomatis,
                'verifycode'  => 1,
                'sensorid'    => '1',
                'WorkCode'    => NULL,
                'Reserved'    => '0'
            ];

            // Panggil model untuk menyimpan data
            $this->Simulasi_model->insert_absensi($data_to_insert);

            // Set pesan sukses dan redirect
            $this->session->set_flashdata('pesan', '<div class="alert alert-success">Data absensi berhasil disimulasikan!</div>');
            redirect('simulasi');
        }
    }
}