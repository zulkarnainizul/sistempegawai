<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('form_validation');
    }
    
    public function index(){
        $data['title'] = 'Login';

        if($this->session->userdata('logged') !== TRUE){
            $this->load->view('templates/header', $data);
            $this->load->view('login');
        } else {
            redirect('Dashboard');
        }
    }
    
    public function autentikasi()
    {
        $this->form_validation->set_rules('username', 'Username', 'required', [
            'required' => 'Username wajib diisi.'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required', [
            'required' => 'Password wajib diisi.'
        ]);

        if ($this->form_validation->run() == FALSE) {
            $this->index();
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $result = $this->User_model->validate($username, $password);

            if (is_array($result)) { // Jika login berhasil (model mengembalikan array data user)
                $this->session->set_userdata([
                    'logged'   => TRUE,
                    'id_user'  => $result['id_user'], // Simpan juga ID user
                    'username' => $result['username'],
                    'role'     => $result['role']
                ]);
                redirect('Dashboard');

            } else { // Jika login gagal
                $message = '';
                switch ($result) {
                    case 'username_not_found':
                        $message = 'Username tidak ditemukan!';
                        break;
                    case 'password_wrong':
                        $message = 'Password yang Anda masukkan salah!';
                        break;
                    default:
                        $message = 'Terjadi kesalahan tidak diketahui.';
                        break;
                }
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger">'. $message .'</div>');
                redirect('Login');
            }
        }
    }

    public function logout(){
        $this->session->sess_destroy();
        redirect('Login');
    }
}
?>
