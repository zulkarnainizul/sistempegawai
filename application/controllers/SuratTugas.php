<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SuratTugas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('logged') !== TRUE) {
            redirect('Login');
        }
        if ($this->session->userdata('role') !== 'Admin Kepegawaian') {
            redirect('Dashboard');
        }
        $this->load->model('SuratTugas_model');
        $this->load->model('Pegawai_model');
        $this->load->model('PelaksanaTugas_model');
        $this->load->helper('tanggal'); // Helper custom Anda
        $this->load->library('form_validation');
    }

    /**
     * Halaman utama untuk menampilkan semua surat tugas (READ)
     */
    public function index() {
        $data['title'] = 'Data Surat Tugas';
        
        // Mengambil data yang sudah diolah dari model
        $data['surat_tugas'] = $this->SuratTugas_model->get_semua_surat_dengan_pelaksana();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        // Memuat view baru untuk menampilkan data
        $this->load->view('surat_tugas/data_surat', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Menampilkan form untuk menambah surat tugas (CREATE - Page)
     */
    public function tambah() {
        $data['title'] = 'Tambah Surat Tugas';
        $data['pegawai']= $this->Pegawai_model->get_data_pegawai(1);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('surat_tugas/tambah_surat', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Memproses data dari form tambah (CREATE - Action)
     */
    public function tambah_aksi() {
        $this->_rules(); // Panggil rules validasi

        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, kembalikan ke form tambah
            $this->tambah();
        } else {
            // Memulai transaction
            $this->db->trans_start();

            // 1. Simpan data utama surat tugas
            $data_surat = [
                'no_surat'          => $this->input->post('no_surat'),
                'dasar_surat'       => $this->input->post('dasar_surat'),
                'nama_kegiatan'     => $this->input->post('nama_kegiatan'),
                'tanggal_mulai'     => $this->input->post('tanggal_mulai'),
                'tanggal_akhir'     => $this->input->post('tanggal_akhir'),
                'tempat_kegiatan'   => $this->input->post('tempat_kegiatan'),
                'lokasi_kegiatan'   => $this->input->post('lokasi_kegiatan'),
                'pemberi_tugas'     => $this->input->post('pemberi_tugas'),
                'date_create'       => date('Y-m-d H:i:s')
            ];
            $id_surat = $this->SuratTugas_model->insert_surat_tugas($data_surat);

            // 2. Simpan data pelaksana tugas
            $pelaksana_ids = $this->input->post('pelaksana');
            if (!empty($pelaksana_ids)) {
                $data_pelaksana = [];
                foreach ($pelaksana_ids as $id_pegawai) {
                    $data_pelaksana[] = [
                        'id_surat_tugas' => $id_surat,
                        'id_pegawai'     => $id_pegawai
                    ];
                }
                $this->PelaksanaTugas_model->insert_batch_pelaksana($data_pelaksana);
            }

            // Menyelesaikan transaction
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger">Gagal menyimpan surat tugas.</div>');
            } else {
                $this->session->set_flashdata('pesan', '<div class="alert alert-success">Surat tugas berhasil disimpan.</div>');
            }
            redirect('SuratTugas');
        }
    }

    /**
     * Menampilkan form untuk mengedit surat tugas (UPDATE - Page)
     */
    public function edit($id) {
        $data['title'] = 'Edit Surat Tugas';
        // Ambil data detail surat tugas, termasuk pelaksananya
        $data['surat_tugas'] = $this->SuratTugas_model->get_surat_detail_by_id($id);
        // Ambil semua data pegawai untuk pilihan
        $data['pegawai']= $this->Pegawai_model->get_data_pegawai(1);

        if (!$data['surat_tugas']) {
            redirect('SuratTugas'); // Jika data tidak ditemukan, redirect
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('surat_tugas/edit_surat', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Memproses data dari form edit (UPDATE - Action)
     */
    public function edit_aksi($id) {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, kembali ke halaman edit
            $this->edit($id);
        } else {
            // Memulai transaction
            $this->db->trans_start();
            
            // 1. Update data utama surat tugas
            $surat_tugas_data = [
                'no_surat'          => $this->input->post('no_surat'),
                'dasar_surat'       => $this->input->post('dasar_surat'),
                'nama_kegiatan'     => $this->input->post('nama_kegiatan'),
                'tanggal_mulai'     => $this->input->post('tanggal_mulai'),
                'tanggal_akhir'     => $this->input->post('tanggal_akhir'),
                'tempat_kegiatan'   => $this->input->post('tempat_kegiatan'),
                'lokasi_kegiatan'   => $this->input->post('lokasi_kegiatan'),
                'pemberi_tugas'     => $this->input->post('pemberi_tugas'),
            ];
            $this->SuratTugas_model->update_surat_tugas($id, $surat_tugas_data);
            
            // 2. Hapus pelaksana tugas yang lama
            $this->PelaksanaTugas_model->delete_pelaksana_by_surat_id($id);
            
            // 3. Insert pelaksana tugas yang baru
            $pelaksana_ids = $this->input->post('pelaksana');
            if (!empty($pelaksana_ids)) {
                $data_pelaksana = [];
                foreach ($pelaksana_ids as $pegawai_id) {
                    $data_pelaksana[] = [
                        'id_surat_tugas' => $id,
                        'id_pegawai'     => $pegawai_id
                    ];
                }
                $this->PelaksanaTugas_model->insert_batch_pelaksana($data_pelaksana);
            }

            // Menyelesaikan transaction
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                 $this->session->set_flashdata('pesan', '<div class="alert alert-danger">Gagal mengubah surat tugas.</div>');
            } else {
                 $this->session->set_flashdata('pesan', '<div class="alert alert-warning">Data Surat Tugas berhasil diubah.</div>');
            }
            redirect('SuratTugas');
        }
    }

    /**
     * Menampilkan halaman detail surat tugas (DETAIL - Page)
     */
    public function detail($id) {
        $data['title'] = 'Detail Surat Tugas';
        $data['surat_tugas'] = $this->SuratTugas_model->get_surat_detail_by_id($id);

        if (!$data['surat_tugas']) {
            redirect('SuratTugas'); // Jika data tidak ditemukan
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('surat_tugas/detail_surat', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Menghapus data surat tugas (DELETE - Action)
     */
    public function delete($id) {
        // Sebaiknya hapus pelaksana dulu untuk menjaga integritas data
        $this->db->trans_start();
        $this->PelaksanaTugas_model->delete_pelaksana_by_surat_id($id);
        $this->SuratTugas_model->delete_surat_tugas($id);
        $this->db->trans_complete();
        
        $this->session->set_flashdata('pesan', '<div class="alert alert-success">Data Surat Tugas berhasil dihapus.</div>');
        redirect('SuratTugas');
    }

    /**
     * Rules untuk validasi form
     */
    private function _rules() {
        $this->form_validation->set_rules('no_surat', 'No. Surat', 'required');
        $this->form_validation->set_rules('pemberi_tugas', 'Pemberi Tugas', 'required');
        $this->form_validation->set_rules('dasar_surat', 'Dasar Surat', 'required');
        $this->form_validation->set_rules('nama_kegiatan', 'Nama Kegiatan', 'required');
        $this->form_validation->set_rules('tanggal_mulai', 'Tanggal Mulai', 'required');
        $this->form_validation->set_rules('tanggal_akhir', 'Tanggal Berakhir', 'required');
        $this->form_validation->set_rules('tempat_kegiatan', 'Tempat Kegiatan', 'required');
        $this->form_validation->set_rules('lokasi_kegiatan', 'Alamat Kegiatan', 'required');
        // Validasi untuk pelaksana bisa ditambahkan jika diperlukan
        // $this->form_validation->set_rules('pelaksana[]', 'Pelaksana Tugas', 'required');
    }
}