<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Status extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if($this->session->userdata('logged') !== TRUE){
            redirect('Login');
        }
        if ($this->session->userdata('role') !== 'Admin Kepegawaian') {
            redirect('Dashboard');
        }
        $this->load->model('Status_model');
    }

    public function index()
    {
        $data['title'] = 'Status Pegawai';
        $data['status'] = $this->Status_model->get_data();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('kepegawaian/status', $data);
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
            redirect('Status');

        } else {
            $data = array (
                'nama_status'=>$this->input->post('nama_status'), 
            );

            $this->Status_model->insert_data($data, 'status_pegawai');
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data berhasil ditambahkan!!<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span 
                aria-hidden="true">&times;</span></button></div>');
            redirect('Status');
        }
    }

    public function edit($id_status_pegawai)
    {
        $this->_rules();
        
        if ($this->form_validation->run() == FALSE) {
            $error_messages = strip_tags(validation_errors());
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">' .
                '<strong>Data gagal diubah!</strong> ' . $error_messages .
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' .
                '<span aria-hidden="true">&times;</span></button></div>');
            redirect('Status');
        } else {
            $data = array (
                'id_status_pegawai' => $id_status_pegawai,
                'nama_status'=>$this->input->post('nama_status'), 
            );

            $this->Status_model->update_data($data, 'status_pegawai');
            $this->session->set_flashdata('pesan', '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            Data berhasil diubah!!<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span 
                aria-hidden="true">&times;</span></button></div>');
            redirect('Status');
        }
    }
    
    public function hapus($id)
    {
        $where = array('id_status_pegawai' => $id);

        $this->Status_model->delete($where, 'status_pegawai');
        $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Data berhasil dihapus!!<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span 
                aria-hidden="true">&times;</span></button></div>');
            redirect('Status');
    }

    public function _rules()
    {
        $this->form_validation->set_rules('nama_status', 'Status', 'required', array(
            'required' => '%s tidak boleh kosong!!'
        ));
    }

}