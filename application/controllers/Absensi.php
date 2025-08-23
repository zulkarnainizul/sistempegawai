<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Absensi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged')) {
            redirect('Login');
        }
        $this->load->model('Absensi_model');
    }

    public function index()
    {
        $data['title'] = 'Absensi'; 
        $data['pegawai_absensi'] = $this->Absensi_model->get_pegawai_absensi();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('absensi', $data);
        $this->load->view('templates/footer');
    }

    public function detail_absen($id)
    {
        $data['title'] = 'Detail Absensi';

        // Ambil filter tanggal dari GET
        $date_start = $this->input->get('date_start') ?: date('Y-m-d', strtotime('-6 days'));
        $date_end = $this->input->get('date_end') ?: date('Y-m-d');

        // Pagination
        $limit = 10;
        $page = $this->input->get('page') ?: 1;
        $offset = ($page - 1) * $limit;

        // Ambil data absensi terfilter dan terpaginated
        $data['absensi'] = $this->Absensi_model->get_data_absensi($id, $date_start, $date_end, $limit, $offset);
        $data['total'] = $this->Absensi_model->count_data_absensi($id, $date_start, $date_end);
        $data['userid'] = $id;
        // $data['pegawai'] = $this->Absensi_model->get_pegawaiById($id);
        $data['pegawai'] = $this->Absensi_model->get_pegawai_lengkap_by_id_absen($id);

        // Untuk kebutuhan pagination di view
        $data['limit'] = $limit;
        $data['page'] = $page;
        $data['date_start'] = $date_start;
        $data['date_end'] = $date_end;

        // Load view
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('detail_absensi', $data);
        $this->load->view('templates/footer');
    }
    public function edit2($id = '')
    {
        $data['title'] = 'Edit Jam Absen';
        $info = $this->Absensi_model->get_checkinout_by_id($id);
        $userid = $this->input->post('userid');
        $tanggal = $this->input->post('tanggal');
        $jam = $this->input->post('jam');
        $datetime = date('Y-m-d H:i:s', strtotime($tanggal . ' ' . $jam));
        $jumlahAbsen = $this->Absensi_model->get_num_absen($userid, $tanggal);
        $jenis = $this->input->post('jenis');
        // Ambil userid dari info saat ini
        $checktype = 0;
        if ($jumlahAbsen == 1) {
            $checktype = 1;
        }
        // var_dump($userid);
        // die;
        if ($info == null) {
            $isi = [
                'userid' => $userid,
                'checktime' => $datetime,
                'checktype' => $checktype,
                'verifycode' => 1
            ];
            $this->Absensi_model->insert($isi);

            //

            $this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissible" role="alert">
			Data Absensi Berhasil di Edit
		</div>');
            redirect('Absensi/detail_absen/' . $userid);
        } else {
            $isi = [
                'checktime' => $datetime,
            ];
            $this->Absensi_model->update(['id' => $id], $isi);
            $this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissible" role="alert">
			Data Absensi Berhasil di Edit
		</div>');
            redirect('Absensi/detail_absen/' . $userid);
        }



        $data['absensi'] = $this->Absensi_model->get_data_absensi($id);
        // Load view
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('detail_absensi', $data);
        $this->load->view('templates/footer');
    }

    
}
