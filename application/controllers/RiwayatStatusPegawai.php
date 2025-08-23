<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class RiwayatStatusPegawai extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if($this->session->userdata('logged') !== TRUE){
            redirect('Login');
        }
        $this->load->model('RiwayatStatusPegawai_model'); 
        $this->load->model('Pegawai_model');
        $this->load->model('Status_model'); 
        $this->load->helper('tanggal');
    }

    public function index($id_pegawai)
    {
        $data['title'] = 'Detail Pegawai';
        $data['riwayat_status_pegawai'] = $this->RiwayatStatusPegawai_model->get_by_pegawai($id_pegawai);
        $data['pegawai'] = $this->Pegawai_model->get_detail_pegawai($id_pegawai);
        $data['id_pegawai'] = $id_pegawai;
        $data['status_pegawai'] = $this->Status_model->get_data();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pegawai/detailpegawai/riwayatstatuspegawai', $data);
        $this->load->view('templates/footer');
    }   

    public function tambah()
    {   
        $id_pegawai = $this->input->post('id_pegawai'); 
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Data gagal ditambahkan!!<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span 
                aria-hidden="true">&times;</span></button>' . validation_errors() . '</div>');
            redirect('RiwayatStatusPegawai/index/' . $id_pegawai);
        } else {
            $data = [
                'id_pegawai'   => $id_pegawai,
                'id_status_pegawai'  => $this->input->post('id_status_pegawai'), 
                'tmt_status' => $this->input->post('tmt_status'), 
            ];

            $this->RiwayatStatusPegawai_model->insert_riwayat_status($data);
            $this->RiwayatStatusPegawai_model->update_latest_riwayat($id_pegawai);

            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data berhasil ditambahkan!!<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span 
                aria-hidden="true">&times;</span></button></div>');
            redirect('RiwayatStatusPegawai/index/' . $id_pegawai);
        }
    }

    public function edit()
    {
        $id_pegawai = $this->input->post('id_pegawai');
        $id_riwayat = $this->input->post('id_riwayat_status_pegawai');
        
        $data = [
            'id_status_pegawai'  => $this->input->post('id_status_pegawai'), 
            'tmt_status' => $this->input->post('tmt_status'), 
        ];

        $this->RiwayatStatusPegawai_model->update_data($id_riwayat, $data, 'riwayat_status_pegawai');
        $this->RiwayatStatusPegawai_model->update_latest_riwayat($id_pegawai);

        $this->session->set_flashdata('pesan', '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            Data berhasil diubah!!<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span 
                aria-hidden="true">&times;</span></button></div>');
        redirect('RiwayatStatusPegawai/index/' . $id_pegawai);
    }

    public function delete($id_riwayat)
    {
        $riwayat = $this->RiwayatStatusPegawai_model->get_by_id($id_riwayat);

        if ($riwayat) {
            $id_pegawai = $riwayat->id_pegawai;

            $this->RiwayatStatusPegawai_model->delete($id_riwayat);
            $this->RiwayatStatusPegawai_model->update_latest_riwayat($id_pegawai);

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

        redirect('RiwayatStatusPegawai/index/' . $riwayat->id_pegawai);
    }

    public function _rules()
    {
        $this->form_validation->set_rules('id_status_pegawai', 'Status Pegawai', 'required', array(
            'required' => '%s harus diisi!!'
        ));
        $this->form_validation->set_rules('tmt_status', 'TMT Status', 'required', array(
            'required' => '%s harus diisi!!'
        ));
    }
}
