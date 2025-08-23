<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RealtimeAbsensi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();  
        $this->load->model('Absensi_model');
    }

    public function index()
    {
        $data['title'] = 'Absensi Realtime';    
        
        $this->load->view('templates/header', $data);
        $this->load->view('realtime-absensi', $data);
    }

    public function get_realtime_json()
    {   
        $absensi = $this->Absensi_model->get_data_realtime(10); 

        header('Content-Type: application/json');
        echo json_encode(['data' => $absensi]);
    }
}


