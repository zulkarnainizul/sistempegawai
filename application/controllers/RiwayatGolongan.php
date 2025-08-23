<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class RiwayatGolongan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('logged') !== TRUE) {
            redirect('Login');
        }
        $this->load->model('RiwayatGolongan_model');
        $this->load->model('Pegawai_model');
        $this->load->model('Golongan_model');
        $this->load->helper('tanggal');
    }

    public function index($id_pegawai)
    {
        $data['title'] = 'Detail Pegawai';
        $data['riwayat_golongan'] = $this->RiwayatGolongan_model->get_by_pegawai($id_pegawai);
        $data['pegawai'] = $this->Pegawai_model->get_detail_pegawai($id_pegawai);
        $data['id_pegawai'] = $id_pegawai;
        $data['golongan'] = $this->Golongan_model->get_data();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pegawai/detailpegawai/riwayatgolongan', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $id_pegawai = $this->input->post('id_pegawai');
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                Data gagal ditambahkan! ' . validation_errors() . '
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>');
            redirect('RiwayatGolongan/index/' . $id_pegawai);
        } else {
            $data = [
                'id_pegawai' => $id_pegawai,
                'id_golongan' => $this->input->post('id_golongan'),
                'tmt_golongan' => $this->input->post('tmt_golongan'),
            ];

            $this->RiwayatGolongan_model->insert_riwayat_golongan($data);
            $this->RiwayatGolongan_model->update_latest_riwayat($id_pegawai);

            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                Data berhasil ditambahkan!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>');
            redirect('RiwayatGolongan/index/' . $id_pegawai);
        }
    }

    public function edit()
    {
        $id_pegawai = $this->input->post('id_pegawai');
        $id_riwayat = $this->input->post('id_riwayat_golongan_pegawai');

        $data = [
            'id_golongan' => $this->input->post('id_golongan'),
            'tmt_golongan' => $this->input->post('tmt_golongan'),
        ];

        $this->RiwayatGolongan_model->update_data($id_riwayat, $data);
        $this->RiwayatGolongan_model->update_latest_riwayat($id_pegawai);

        $this->session->set_flashdata('pesan', '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            Data berhasil diubah!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>');
        redirect('RiwayatGolongan/index/' . $id_pegawai);
    }

    public function delete($id_riwayat)
    {
        $riwayat = $this->RiwayatGolongan_model->get_by_id($id_riwayat);

        if ($riwayat) {
            $id_pegawai = $riwayat->id_pegawai;

            $this->RiwayatGolongan_model->delete($id_riwayat);
            $this->RiwayatGolongan_model->update_latest_riwayat($id_pegawai);

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

        redirect('RiwayatGolongan/index/' . $riwayat->id_pegawai);
    }

    private function _rules()
    {
        $this->form_validation->set_rules('id_golongan', 'Golongan Pegawai', 'required', [
            'required' => '%s harus diisi!!'
        ]);
        $this->form_validation->set_rules('tmt_golongan', 'TMT Golongan', 'required', [
            'required' => '%s harus diisi!!'
        ]);
    }
}
