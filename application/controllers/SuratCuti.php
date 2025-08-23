<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SuratCuti extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged') !== TRUE) {
            redirect('Login');
        }
        if ($this->session->userdata('role') !== 'Admin Kepegawaian') {
            redirect('Dashboard');
        }
        $this->load->model('SuratCuti_model');
        $this->load->model('Pegawai_model');
        $this->load->library('form_validation');
    }

    /**
     * Menampilkan halaman daftar surat cuti
     */
    public function index()
    {
        $data['title'] = 'Data Surat Cuti';
        $data['surat_cuti'] = $this->SuratCuti_model->get_all_cuti();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('surat_cuti/data_surat', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Menampilkan form tambah surat cuti
     */
    public function tambah()
    {
        $data['title'] = 'Tambah Surat Cuti';
        $data['pegawai']= $this->Pegawai_model->get_data_pegawai(1);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('surat_cuti/tambah_surat', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Memproses data dari form tambah
     */
    public function tambah_aksi()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->tambah();
        } else {
            $data = [
                'id_pegawai'         => $this->input->post('id_pegawai', TRUE),
                'jenis_cuti'         => $this->input->post('jenis_cuti', TRUE),
                'alasan_cuti'        => $this->input->post('alasan_cuti', TRUE),
                'lama_cuti'          => $this->input->post('lama_cuti', TRUE),
                'tanggal_mulai'      => $this->input->post('tanggal_mulai', TRUE),
                'tanggal_akhir'      => $this->input->post('tanggal_akhir', TRUE),
                'alamat_selama_cuti' => $this->input->post('alamat_selama_cuti', TRUE),
                'no_telp_cuti'       => $this->input->post('no_telp_cuti', TRUE),
                'jabatan_atasan1'    => $this->input->post('jabatan_atasan1', TRUE),
                'nama_atasan1'       => $this->input->post('nama_atasan1', TRUE),
                'nip_atasan1'        => $this->input->post('nip_atasan1', TRUE),
                'jabatan_atasan2'    => $this->input->post('jabatan_atasan2', TRUE),
                'nama_atasan2'       => $this->input->post('nama_atasan2', TRUE),
                'date_create'        => date('Y-m-d H:i:s')
            ];

            $this->SuratCuti_model->insert_cuti($data);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success">Surat cuti berhasil dibuat!</div>');
            redirect('SuratCuti');
        }
    }
    
    /**
     * Menampilkan form edit surat cuti
     */
    public function edit($id)
    {
        $data['title'] = 'Edit Surat Cuti';
        $data['cuti'] = $this->SuratCuti_model->get_cuti_by_id($id);
        $data['pegawai']= $this->Pegawai_model->get_data_pegawai(1);

        if (!$data['cuti']) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger">Data tidak ditemukan!</div>');
            redirect('SuratCuti');
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('surat_cuti/edit_surat', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Memproses data dari form edit
     */
    public function edit_aksi($id)
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->edit($id);
        } else {
            $data = [
                'id_pegawai'         => $this->input->post('id_pegawai', TRUE),
                'jenis_cuti'         => $this->input->post('jenis_cuti', TRUE),
                'alasan_cuti'        => $this->input->post('alasan_cuti', TRUE),
                'lama_cuti'          => $this->input->post('lama_cuti', TRUE),
                'tanggal_mulai'      => $this->input->post('tanggal_mulai', TRUE),
                'tanggal_akhir'      => $this->input->post('tanggal_akhir', TRUE),
                'alamat_selama_cuti' => $this->input->post('alamat_selama_cuti', TRUE),
                'no_telp_cuti'       => $this->input->post('no_telp_cuti', TRUE),
                'jabatan_atasan1'    => $this->input->post('jabatan_atasan1', TRUE),
                'nama_atasan1'       => $this->input->post('nama_atasan1', TRUE),
                'nip_atasan1'        => $this->input->post('nip_atasan1', TRUE),
                'jabatan_atasan2'    => $this->input->post('jabatan_atasan2', TRUE),
                'nama_atasan2'       => $this->input->post('nama_atasan2', TRUE),
            ];

            $this->SuratCuti_model->update_cuti($id, $data);
            $this->session->set_flashdata('pesan', '<div class="alert alert-warning">Data cuti berhasil diperbarui!</div>');
            redirect('SuratCuti');
        }
    }

    /**
     * Menampilkan halaman detail surat cuti.
     */
    public function detail($id)
    {
        $data['title'] = 'Detail Surat Cuti';
        // Memanggil model untuk mengambil data lengkap berdasarkan ID
        $data['cuti'] = $this->SuratCuti_model->get_cuti_by_id($id);

        if (!$data['cuti']) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger">Data tidak ditemukan!</div>');
            redirect('SuratCuti');
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        // Anda perlu membuat view ini untuk menampilkan detailnya
        $this->load->view('surat_cuti/detail_surat', $data); 
        $this->load->view('templates/footer');
    }

    /**
     * Menghapus data surat cuti
     */
    public function hapus($id)
    {
        if (!is_numeric($id)) {
            redirect('SuratCuti');
        }
        
        $this->SuratCuti_model->delete_cuti($id);
        $this->session->set_flashdata('pesan', '<div class="alert alert-danger">Data cuti berhasil dihapus!</div>');
        redirect('SuratCuti');
    }

    /**
     * Aturan validasi untuk form
     */
    private function _rules()
    {
        $this->form_validation->set_rules('id_pegawai', 'Nama Pegawai', 'required', ['required' => '%s wajib diisi.']);
        $this->form_validation->set_rules('jenis_cuti', 'Jenis Cuti', 'required', ['required' => '%s wajib dipilih.']);
        $this->form_validation->set_rules('alasan_cuti', 'Alasan Cuti', 'required', ['required' => '%s wajib diisi.']);
        $this->form_validation->set_rules('lama_cuti', 'Lama Cuti', 'required', ['required' => '%s wajib diisi.']);
        $this->form_validation->set_rules('tanggal_mulai', 'Tanggal Mulai', 'required', ['required' => '%s wajib diisi.']);
        $this->form_validation->set_rules('tanggal_akhir', 'Tanggal Akhir', 'required', ['required' => '%s wajib diisi.']);
        $this->form_validation->set_rules('alamat_selama_cuti', 'Alamat Cuti', 'required', ['required' => '%s wajib diisi.']);
        
        $this->form_validation->set_rules('jabatan_atasan1', 'Jabatan Atasan 1', 'required', ['required' => '%s wajib diisi.']);
        $this->form_validation->set_rules('nama_atasan1', 'Nama Atasan 1', 'required', ['required' => '%s wajib diisi.']);
        $this->form_validation->set_rules('nip_atasan1', 'NIP Atasan 1', 'required', ['required' => '%s wajib diisi.']);
        $this->form_validation->set_rules('jabatan_atasan2', 'Jabatan Atasan 2', 'required', ['required' => '%s wajib diisi.']);
        $this->form_validation->set_rules('nama_atasan2', 'Nama Atasan 2', 'required', ['required' => '%s wajib diisi.']);
    }
}