<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SuratKeterangan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('logged') !== TRUE) {
            redirect('Login');
        }
        if ($this->session->userdata('role') !== 'Admin Kepegawaian') {
            redirect('Dashboard');
        }
        $this->load->model('SuratKeterangan_model');
        $this->load->model('Pegawai_model');
        $this->load->helper('tanggal');
        $this->load->library('form_validation');
    }

    /**
     * Halaman utama untuk menampilkan daftar Surat Keterangan.
     */
    public function index() {
        $data['title'] = 'Data Surat Keterangan';
        $data['surat_keterangan'] = $this->SuratKeterangan_model->get_all_surat_with_pegawai();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('surat_keterangan/data_surat', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Menampilkan form untuk menambah surat keterangan.
     */
    public function tambah() {
        $data['title'] = 'Tambah Surat Keterangan';
        // Asumsi get_data_pegawai(1) adalah untuk mengambil pegawai aktif
        $data['pegawai'] = $this->Pegawai_model->get_data_pegawai(1);
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('surat_keterangan/tambah_surat', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Memproses data dari form tambah.
     */
    public function tambah_aksi() {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->tambah(); // Jika validasi gagal, kembali ke form tambah
        } else {
            $data = [
                'no_surat'        => $this->input->post('no_surat', TRUE),
                'id_pegawai'      => $this->input->post('id_pegawai', TRUE),
                'bidang_studi'    => $this->input->post('bidang_studi', TRUE),
                'kab_kota'        => $this->input->post('kab_kota', TRUE),
                'keperluan_surat' => $this->input->post('keperluan_surat', TRUE),
                'keterangan'      => $this->input->post('keterangan', TRUE),
                'date_create'     => date('Y-m-d H:i:s')
            ];
            
            $this->SuratKeterangan_model->insert_surat($data);
            
            // --- PESAN FLASHDATA BARU (SUCCESS) ---
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                Data surat keterangan berhasil ditambahkan!!<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span 
                    aria-hidden="true">&times;</span></button></div>');
            
            redirect('SuratKeterangan');
        }
    }

    /**
     * Menampilkan form untuk mengedit surat keterangan.
     */
    public function edit($id) {
        $data['title'] = 'Edit Surat Keterangan';
        $data['surat'] = $this->SuratKeterangan_model->get_surat_by_id($id);
        $data['pegawai'] = $this->Pegawai_model->get_data_pegawai(1);

        if (!$data['surat']) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger">Data tidak ditemukan!</div>');
            redirect('SuratKeterangan');
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('surat_keterangan/edit_surat', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Memproses data dari form edit.
     */
    public function edit_aksi($id) {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->edit($id);
        } else {
            $data = [
                'no_surat'        => $this->input->post('no_surat', TRUE),
                'id_pegawai'      => $this->input->post('id_pegawai', TRUE),
                'bidang_studi'    => $this->input->post('bidang_studi', TRUE),
                'kab_kota'        => $this->input->post('kab_kota', TRUE),
                'keperluan_surat' => $this->input->post('keperluan_surat', TRUE),
                'keterangan'      => $this->input->post('keterangan', TRUE),
            ];

            $this->SuratKeterangan_model->update_surat($id, $data);
            
            // --- PESAN FLASHDATA BARU (WARNING/UPDATE) ---
            $this->session->set_flashdata('pesan', '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                Data surat keterangan berhasil diperbarui!!<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span 
                    aria-hidden="true">&times;</span></button></div>');
            
            redirect('SuratKeterangan');
        }
    }

    /**
     * Menampilkan halaman detail surat keterangan.
     */
    public function detail($id) {
        $data['title'] = 'Detail Surat Keterangan';
        $data['surat'] = $this->SuratKeterangan_model->get_surat_by_id($id);

        if (!$data['surat']) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger">Data tidak ditemukan!</div>');
            redirect('SuratKeterangan');
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('surat_keterangan/detail_surat', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Menghapus data surat keterangan.
     */
    public function hapus($id) {
        if (!is_numeric($id)) {
            redirect('SuratKeterangan');
        }
        
        $this->SuratKeterangan_model->delete_surat($id);
        
        // --- PESAN FLASHDATA BARU (DANGER/DELETE) ---
        $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                Data Berhasil Dihapus!!<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span 
                    aria-hidden="true">&times;</span></button></div>');
                    
        redirect('SuratKeterangan');
    }
    
    /**
     * Aturan validasi form.
     */
    private function _rules() {
        $this->form_validation->set_rules('no_surat', 'No. Surat', 'required');
        $this->form_validation->set_rules('id_pegawai', 'Pegawai', 'required');
        $this->form_validation->set_rules('bidang_studi', 'Bidang Studi', 'required');
        $this->form_validation->set_rules('keperluan_surat', 'Keperluan Surat', 'required');
    }
}