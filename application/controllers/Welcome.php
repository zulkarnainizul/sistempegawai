<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function __construct(){
        parent::__construct();
        // Tidak perlu load model atau library di sini
    }
    
    public function index(){
        // Cek jika user sudah login, jangan tampilkan halaman welcome lagi
        if($this->session->userdata('logged') === TRUE){
            redirect('Dashboard');
        } else {
            // Jika belum login, tampilkan halaman welcome
            $this->load->view('welcome');
        }
    }
}
?>