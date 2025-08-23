<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pegawai extends CI_Controller {

    public function __construct() 
    {
        parent::__construct();
        if($this->session->userdata('logged') !== TRUE){
            redirect('Login');
        }
        $this->load->model('Pegawai_model');
        $this->load->model('Absensi_model');
        $this->load->model('Status_model');
        $this->load->model('Jabatan_model');
        $this->load->model('Golongan_model');
        $this->load->model('RiwayatPendidikan_model');
        $this->load->model('RiwayatGolongan_model');
        $this->load->model('RiwayatJabatan_model');
        $this->load->model('RiwayatStatusPegawai_model');
        $this->load->model('RiwayatStatusKerja_model'); 
        $this->load->helper('tanggal');
    }
    
    public function index() 
    {
        $data['title'] = 'Pegawai';

        $data['pegawai_aktif']= $this->Pegawai_model->get_data_pegawai(1);
        $data['pegawai_tidak_aktif']= $this->Pegawai_model->get_data_pegawai(0);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pegawai/datapegawai', $data);
        $this->load->view('templates/footer');
    }

    public function sinkronisasi()
    {
        $jumlah_ditambahkan = $this->Absensi_model->sinkronisasi_absensi();

        // Siapkan pesan flashdata berdasarkan hasil
        if ($jumlah_ditambahkan > 0) {
            $pesan = "Sinkronisasi berhasil! <strong>{$jumlah_ditambahkan}</strong> data pegawai baru berhasil ditambahkan.";
            $this->session->set_flashdata('pesan', '<div class="alert alert-success">' . $pesan . '</div>');
        } else {
            $pesan = "Sinkronisasi berhasil! Data pegawai telah sesuai, tidak ada data baru yang ditambahkan.";
            $this->session->set_flashdata('pesan', '<div class="alert alert-info">' . $pesan . '</div>');
        }

        // Arahkan kembali ke halaman daftar pegawai
        redirect('Pegawai');
    }
        
    public function tambahpegawai() 
    {
        $data['title'] = 'Pegawai';

        if ($this->session->userdata('role') !== 'Admin Kepegawaian') {
            redirect('Pegawai');
        }
        
        $data['golongan'] = $this->Golongan_model->get_data();
        $data['status'] = $this->Status_model->get_data();
        $data['jabatan'] = $this->Jabatan_model->get_data();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pegawai/tambahpegawai', $data);
        $this->load->view('templates/footer');
    }

    public function simpan()
    {
        // Tempatkan semua pesan custom di sini, sebelum set_rules
        $this->form_validation->set_message('required', '{field} tidak boleh kosong.');
        $this->form_validation->set_message('is_unique', '{field} ini sudah terdaftar, silakan gunakan yang lain.');
        // Validasi input yang wajib diisi
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('nip', 'NIP', 'required|is_unique[pegawai.nip]');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
        // Anda mungkin perlu menambahkan validasi untuk dropdown wajib lainnya di sini
        $this->form_validation->set_rules('id_golongan', 'Golongan', 'required');
        $this->form_validation->set_rules('id_jabatan', 'Jabatan', 'required');
        $this->form_validation->set_rules('id_status_pegawai', 'Status Pegawai', 'required');

        // Kirim parameter [0] karena ini adalah data baru
        $this->form_validation->set_rules(
            'userid_absen', 
            'ID Absensi', 
            'required|trim|callback_cek_kombinasi_absen[0]',
            ['cek_kombinasi_absen' => 'Kombinasi ID Absensi dan Nomor Mesin ini sudah terdaftar.']
        );
        $this->form_validation->set_rules('SN_Absen', 'Nomor Mesin Absensi', 'required|trim');
        
        if ($this->form_validation->run() == FALSE) {
            $this->tambahpegawai();
            return;
        }

        // =======================================================================
        // PROSES SEMUA INPUT OPSIONAL SEBELUM DISIMPAN
        // Jika input kosong, ubah menjadi NULL. Jika ada isinya, gunakan isinya.
        // =======================================================================

        // Data pribadi opsional
        $no_hp = $this->input->post('no_hp') ?: NULL;
        $tanggal_mulai_bertugas = $this->input->post('tanggal_mulai_bertugas') ?: NULL;
        $alamat = $this->input->post('alamat') ?: NULL;
        $tempat_lahir = $this->input->post('tempat_lahir') ?: NULL;
        $tanggal_lahir = $this->input->post('tanggal_lahir') ?: NULL;

        // Data TMT opsional (atau bisa juga wajib tergantung kebutuhan)
        $tmt_golongan = $this->input->post('tmt_golongan') ?: NULL;
        $tmt_jabatan = $this->input->post('tmt_jabatan') ?: NULL;
        $tmt_status = $this->input->post('tmt_status') ?: NULL;

        // Data pendidikan opsional
        $nama_jurusan = $this->input->post('nama_jurusan') ?: NULL;
        $tahun_lulus = $this->input->post('tahun_lulus') ?: NULL;
        $tingkat_ijazah = $this->input->post('tingkat_ijazah') ?: NULL;

        
        // 1. Simpan data pegawai utama
        $pegawai_data = [
            'nama' => $this->input->post('nama'), // Wajib
            'nip' => $this->input->post('nip'), // Wajib
            'jenis_kelamin' => $this->input->post('jenis_kelamin'), // Wajib
            'userid_absen' => $this->input->post('userid_absen'), // Wajib
            'SN_Absen' => $this->input->post('SN_Absen'), // Wajib
            // Gunakan variabel yang sudah diproses untuk data opsional
            'no_hp' => $no_hp,
            'tanggal_mulai_bertugas' => $tanggal_mulai_bertugas,
            'alamat' => $alamat,
            'tempat_lahir' => $tempat_lahir,
            'tanggal_lahir' => $tanggal_lahir,
        ];

        $id_pegawai = $this->Pegawai_model->insert_data($pegawai_data);

        if (!$id_pegawai) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Data gagal ditambahkan!!<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span 
                aria-hidden="true">&times;</span></button></div>');
            redirect('Pegawai');
        }

        // 2. Simpan riwayat dan update latest_id secara modular
        $this->Pegawai_model->simpanRiwayatTerbaru($id_pegawai, [
            'golongan' => [
                'data' => [
                    'id_golongan' => $this->input->post('id_golongan'), // Wajib
                    'tmt_golongan' => $tmt_golongan, // Opsional
                ],
            ],
            'jabatan' => [
                'data' => [
                    'id_jabatan' => $this->input->post('id_jabatan'), // Wajib
                    'tmt_jabatan' => $tmt_jabatan, // Opsional
                ],
            ],
            'status' => [
                'data' => [
                    'id_status_pegawai' => $this->input->post('id_status_pegawai'), // Wajib
                    'tmt_status' => $tmt_status, // Opsional
                ],
            ],
            'status_kerja' => [
                'data' => [
                    'jenis_status_kerja' => "Mulai Bekerja", 
                    'tmt_status_kerja' => $tanggal_mulai_bertugas,
                ],
            ],
            'pendidikan' => [
                'data' => [
                    'nama_jurusan' => $nama_jurusan, // Opsional
                    'tahun_lulus' => $tahun_lulus, // Opsional
                    'tingkat_ijazah' => $tingkat_ijazah, // Opsional
                ],
            ],
        ]);

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data berhasil ditambahkan!!<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span 
                aria-hidden="true">&times;</span></button></div>');
        redirect('Pegawai');
    }

    public function cek_kombinasi_absen($userid_absen, $id_pegawai)
    {
        // Jika input kosong, biarkan aturan 'required' yang bekerja.
        if (empty($userid_absen)) {
            return TRUE;
        }

        // Lanjutkan pengecekan jika input tidak kosong
        $sn_absen = $this->input->post('SN_Absen');
        $is_duplicate = $this->Pegawai_model->cek_duplikat_absen($userid_absen, $sn_absen, $id_pegawai);

        if ($is_duplicate) {
            return FALSE; // Gagal jika duplikat ditemukan
        } else {
            return TRUE; // Berhasil jika tidak ada duplikat
        }
    }

    public function edit($id_pegawai_url)
    {
        // Set aturan validasi
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('nip', 'NIP', 'required|trim');
        // Tambahkan validasi NIP unik jika NIP diubah
        $pegawai = $this->Pegawai_model->get_detail_pegawai($id_pegawai_url);
        if ($this->input->post('nip') != $pegawai->nip) {
            $this->form_validation->set_rules('nip', 'NIP', 'required|trim|is_unique[pegawai.nip]');
        }
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required|trim');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('tanggal_mulai_bertugas', 'Mulai Bertugas', 'required');
        $this->form_validation->set_rules('no_hp', 'No HP', 'trim|numeric');
        $this->form_validation->set_rules('alamat', 'Alamat', 'trim');

        
        // Kirim parameter [$id_pegawai_url] yang sedang diedit
        $this->form_validation->set_rules(
            'userid_absen', 
            'ID Absensi', 
            "required|trim|callback_cek_kombinasi_absen[$id_pegawai_url]",
            ['cek_kombinasi_absen' => 'Kombinasi ID Absensi dan Nomor Mesin ini sudah terdaftar untuk pegawai lain.']
        );
        $this->form_validation->set_rules('SN_Absen', 'Nomor Mesin Absensi', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            // =========================================================================
            // PERBAIKAN UTAMA: Jangan redirect, tapi panggil fungsi yang memuat view.
            // Ini akan mempertahankan error validasi dan input lama (set_value).
            // =========================================================================
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger">Data pegawai gagal di edit, cek kesalahan inputan!</div>');
            $this->detailpegawai($id_pegawai_url);

        } else {
            // Proses update data jika validasi berhasil
            $id_pegawai_form = $this->input->post('id_pegawai');

            if ($id_pegawai_url != $id_pegawai_form) {
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger">Kesalahan: ID tidak cocok!</div>');
                redirect('Pegawai');
                return;
            }

            $data = [
                'nama'                   => $this->input->post('nama'),
                'nip'                    => $this->input->post('nip'),
                'jenis_kelamin'          => $this->input->post('jenis_kelamin'),
                'tempat_lahir'           => $this->input->post('tempat_lahir'),
                'tanggal_lahir'          => $this->input->post('tanggal_lahir'),
                'tanggal_mulai_bertugas' => $this->input->post('tanggal_mulai_bertugas'),
                'userid_absen'           => $this->input->post('userid_absen'),
                'SN_Absen' => $this->input->post('SN_Absen'),
                'no_hp'                  => $this->input->post('no_hp') ?: NULL,
                'alamat'                 => $this->input->post('alamat') ?: NULL,
            ];

            $this->Pegawai_model->update_data($id_pegawai_form, $data, 'pegawai');
            $this->RiwayatStatusKerja_model->update_tmt_mulai_bekerja($id_pegawai_form, $this->input->post('tanggal_mulai_bertugas'));
            
            $this->session->set_flashdata('pesan', '<div class="alert alert-warning">Data pegawai berhasil diubah!</div>');
            redirect('Pegawai/detailpegawai/' . $id_pegawai_form);
        }
    }
            
    public function detailpegawai($id_pegawai)
    {   
        $data['title'] = 'Detail Pegawai';
        $data['id_pegawai'] = $id_pegawai;

        $data['pegawai'] = $this->Pegawai_model->get_detail_pegawai($id_pegawai);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pegawai/detailpegawai/informasipegawai');
        $this->load->view('templates/footer');
    }
    
    public function delete($id)
    {
        $where = array('id_pegawai' => $id);
        $this->Pegawai_model->delete($where, 'pegawai');
        $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Data Berhasil Dihapus!!<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span 
                aria-hidden="true">&times;</span></button></div>');
            redirect('Pegawai');
    }

    public function nonaktifkan($id_pegawai)
    {
        $jenis_status_kerja = $this->input->post('jenis_status_kerja');
        $alasan_lainnya = $this->input->post('alasan_lainnya');

        if ($jenis_status_kerja === 'Lainnya' && !empty($alasan_lainnya)) {
            $jenis_status_kerja = $alasan_lainnya;
        }

        $success = $this->Pegawai_model->nonaktifkan_pegawai_dan_riwayat($id_pegawai, $jenis_status_kerja);

        if ($success) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-secondary alert-dismissible fade show" role="alert">
            Pegawai berhasil dinonaktifkan!!<button type="button" class="close" data-dismiss="alert" aria-label="Close"> 
            <span aria-hidden="true">&times;</span></button></div>');
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger">Gagal menonaktifkan pegawai.</div>');
        }

        redirect('Pegawai/detailpegawai/' . $id_pegawai);
    }

    public function aktifkan($id_pegawai)
    {
        $success = $this->Pegawai_model->aktifkan_pegawai_dan_riwayat($id_pegawai);

        if ($success) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Pegawai berhasil diaktifkan kembali!!<button type="button" class="close" data-dismiss="alert" aria-label="Close"> 
            <span aria-hidden="true">&times;</span></button></div>');
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger">Gagal mengaktifkan pegawai.</div>');
        }

        redirect('Pegawai/detailpegawai/' . $id_pegawai);
    }


}

?>
