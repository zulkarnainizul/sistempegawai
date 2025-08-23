<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Golongan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if($this->session->userdata('logged') !== TRUE){
            redirect('Login');
        }
        if ($this->session->userdata('role') !== 'Admin Kepegawaian') {
            redirect('Dashboard');
        }
        $this->load->model('Golongan_model');
    }

    public function index()
    {
        $data['title'] = 'Golongan Pegawai';
        $data['golongan'] = $this->Golongan_model->get_data();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('kepegawaian/golongan', $data);
        $this->load->view('templates/footer');
    }


    public function tambah()
    {
        $this->_rules();
        
        if ($this->form_validation->run() == FALSE) {
            $error_messages = strip_tags(validation_errors());
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">' .
                '<strong>Data gagal ditambahkan!</strong> ' . $error_messages .
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' .
                '<span aria-hidden="true">&times;</span></button></div>');
            redirect('Golongan');
        } else {
            $data = array (
                'nama_golongan'=>$this->input->post('nama_golongan'), 
            );

            $this->Golongan_model->insert_data($data, 'golongan_pegawai');
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data Berhasil Ditambahkan!!<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span 
                aria-hidden="true">&times;</span></button></div>');
            redirect('Golongan');
        }
    }

    public function edit($id_golongan)
    {
        $this->_rules();
        
        if ($this->form_validation->run() == FALSE) {
            $error_messages = strip_tags(validation_errors());
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">' .
                '<strong>Data gagal diubah!</strong> ' . $error_messages .
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' .
                '<span aria-hidden="true">&times;</span></button></div>');
            redirect('Golongan');
        } else {
            $data = array (
                'id_golongan' => $id_golongan,
                'nama_golongan'=>$this->input->post('nama_golongan'), 
            );

            $this->Golongan_model->update_data($data, 'golongan_pegawai');
            $this->session->set_flashdata('pesan', '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            Data Berhasil Diubah!!<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span 
                aria-hidden="true">&times;</span></button></div>');
            redirect('Golongan');
        }
    }
    
    public function hapus($id)
    {
        $where = array('id_golongan' => $id);

        $this->Golongan_model->delete($where, 'golongan_pegawai');
        $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Data Berhasil Dihapus!!<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span 
                aria-hidden="true">&times;</span></button></div>');
            redirect('Golongan');
    }

    public function _rules()
    {
        $this->form_validation->set_rules('nama_golongan', 'Golongan', 'required', array(
            'required' => '%s harus diisi!!'
        ));
    }
}
