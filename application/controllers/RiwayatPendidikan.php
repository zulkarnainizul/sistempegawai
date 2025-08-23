<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class RiwayatPendidikan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Cek login session
        if($this->session->userdata('logged') !== TRUE){
            redirect('Login');
        }   
        $this->load->model('RiwayatPendidikan_model');
        $this->load->model('Pegawai_model');
        $this->load->library('form_validation');
    }

    public function index($id_pegawai)
    {
        $data['title'] = 'Detail Pegawai';  
        $data['riwayat_pendidikan'] = $this->RiwayatPendidikan_model->get_by_pegawai_id($id_pegawai);
        $data['pegawai'] = $this->Pegawai_model->get_detail_pegawai($id_pegawai);
        $data['id_pegawai'] = $id_pegawai;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);  
        $this->load->view('pegawai/detailpegawai/riwayatpendidikan', $data); 
        $this->load->view('templates/footer');
    }

    public function tambah()
    {   
        $id_pegawai = $this->input->post('id_pegawai'); 
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Data gagal ditambahkan!!<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span 
                aria-hidden="true">&times;</span></button' . validation_errors() . '</div>');
            redirect('RiwayatPendidikan/index/' . $id_pegawai); 
        } else {
            $data = [
                'id_pegawai'     => $id_pegawai,
                'nama_jurusan'   => $this->input->post('nama_jurusan'),
                'tahun_lulus'    => $this->input->post('tahun_lulus'),
                'tingkat_ijazah' => $this->input->post('tingkat_ijazah'),
            ];

            $this->RiwayatPendidikan_model->insert_riwayat_pendidikan($data);
            $this->RiwayatPendidikan_model->update_latest_riwayat($id_pegawai);

            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data berhasil ditambahkan!!<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span 
                aria-hidden="true">&times;</span></button></div>');
            redirect('RiwayatPendidikan/index/' . $id_pegawai); 
        }
    }

    public function edit()
    {   
        $id_pegawai = $this->input->post('id_pegawai');
        $id_riwayat = $this->input->post('id_riwayat_pendidikan_pegawai');
        $this->_rules();
        
        $data = [
            'nama_jurusan' => $this->input->post('nama_jurusan'),
            'tahun_lulus' => $this->input->post('tahun_lulus'),
            'tingkat_ijazah' => $this->input->post('tingkat_ijazah'),
        ];
        
        $this->RiwayatPendidikan_model->update_data($id_riwayat, $data, 'riwayat_pendidikan_pegawai');
        $this->RiwayatPendidikan_model->update_latest_riwayat($id_pegawai);
        
        $this->session->set_flashdata('pesan', '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            Data berhasil diubah!!<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span 
                aria-hidden="true">&times;</span></button></div>');
        redirect('RiwayatPendidikan/index/' . $id_pegawai);
    }
    
    public function delete($id_riwayat)
    {
        $riwayat = $this->RiwayatPendidikan_model->get_by_id($id_riwayat);

        if ($riwayat) {
            $id_pegawai = $riwayat->id_pegawai;

            $this->RiwayatPendidikan_model->delete($id_riwayat);
            $this->RiwayatPendidikan_model->update_latest_riwayat($id_pegawai);

            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                Data berhasil dihapus!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>');
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                Data gagal dihapus. Riwayat tidak ditemukan.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>');
        }

        redirect('RiwayatPendidikan/index/' . $riwayat->id_pegawai);
    }

    public function _rules()
    {
        $this->form_validation->set_rules('nama_jurusan', 'Nama Jurusan/Prodi', 'required', [
            'required' => '%s harus diisi!'
        ]);
        $this->form_validation->set_rules('tahun_lulus', 'Tahun Lulus', 'required|numeric|exact_length[4]', [
            'required' => '%s harus diisi!',
            'numeric'  => '%s harus berupa angka!',
            'exact_length' => '%s harus 4 digit!'
        ]);
    }
}