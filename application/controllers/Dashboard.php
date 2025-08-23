<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged')) {
            redirect('Login');
        }
        $this->load->model('Dashboard_model');
    }   

   
    public function index() {
        $data['title'] = 'Dashboard';

        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');

        if (empty($start_date) || empty($end_date)) {
            $start_date = date('Y-m-d', strtotime('-6 days'));
            $end_date = date('Y-m-d');
        }
        
        $data['active_start_date'] = $start_date;
        $data['active_end_date'] = $end_date;

        $data['statistik_kehadiran'] = $this->Dashboard_model->get_statistik_kehadiran_by_range($start_date, $end_date);
        $data['kehadiran_hari_ini'] = $this->Dashboard_model->get_kehadiran_hari_ini();
        $data['total_pegawai_aktif'] = $this->Dashboard_model->count_pegawai_by_status(1);
        $data['total_pegawai_tidak_aktif'] = $this->Dashboard_model->count_pegawai_by_status(0);
        $data['summary_jabatan'] = $this->Dashboard_model->get_summary_by_jabatan();
        $data['summary_golongan'] = $this->Dashboard_model->get_summary_by_golongan();
        $data['summary_status'] = $this->Dashboard_model->get_summary_by_status_pegawai();
        $data['summary_gender'] = $this->Dashboard_model->get_summary_by_gender();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('dashboard', $data);
        $this->load->view('templates/footer');
    }
}   
?>
