<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Jabatan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if($this->session->userdata('logged') !== TRUE){
            redirect('Login');
        }
        if ($this->session->userdata('role') !== 'Admin Kepegawaian') {
            redirect('Dashboard');
        }
        $this->load->model('Jabatan_model');
    }
    
    public function index()
    {
        $data['title'] = 'Jabatan Pegawai';
        $data['jabatan'] = $this->Jabatan_model->get_data();
    
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('kepegawaian/jabatan', $data);
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
            redirect('Jabatan');
        } else {
            $data = array (
                'nama_jabatan'=>$this->input->post('nama_jabatan'), 
                'jenis_jabatan'=>$this->input->post('jenis_jabatan'), 
            );

            $this->Jabatan_model->insert_data($data, 'jabatan_pegawai');
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data berhasil ditambahkan!!<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span 
                aria-hidden="true">&times;</span></button></div>');
            redirect('Jabatan');
        }
    }

    public function edit($id_jabatan)
    {
        $this->_rules();
        
        if ($this->form_validation->run() == FALSE) {
            $error_messages = strip_tags(validation_errors());
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">' .
                '<strong>Data gagal diubah!</strong> ' . $error_messages .
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' .
                '<span aria-hidden="true">&times;</span></button></div>');
            redirect('Jabatan');
        } else {
            $data = array (
                'id_jabatan' => $id_jabatan,
                'nama_jabatan'=>$this->input->post('nama_jabatan'), 
                'jenis_jabatan'=>$this->input->post('jenis_jabatan'), 
            );

            $this->Jabatan_model->update_data($data, 'jabatan_pegawai');
            $this->session->set_flashdata('pesan', '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            Data berhasil diubah!!<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span 
                aria-hidden="true">&times;</span></button></div>');
            redirect('Jabatan');
        }
    }
    
    public function hapus($id)
    {
        $where = array('id_jabatan' => $id);

        $this->Jabatan_model->delete($where, 'jabatan_pegawai');
        $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Data berhasil dihapus!!<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span 
                aria-hidden="true">&times;</span></button></div>');
            redirect('Jabatan');
    }

    public function _rules()
    {
        $this->form_validation->set_rules('nama_jabatan', 'Nama jabatan', 'required', array(
            'required' => '%s harus diisi!!'
        ));
        $this->form_validation->set_rules('jenis_jabatan', 'Jenis jabatan', 'required', array(
            'required' => '%s harus diisi!!'
        ));
    }
}
?>
