<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class Laporan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if($this->session->userdata('logged') !== TRUE){
            redirect('Login');
        }   
        $this->load->model('Pegawai_model');
        $this->load->model('Status_model');
        $this->load->model('Jabatan_model');
        $this->load->model('Golongan_model');
        $this->load->model('SuratKeterangan_model');
        $this->load->model('SuratTugas_model');
        $this->load->model('SuratCuti_model');
        $this->load->model('PelaksanaTugas_model');
        $this->load->model('Absensi_model');
        $this->load->helper('tanggal');

    }

    public function cetak_laporan_pegawai()
    {
        $tipe_laporan = $this->input->post('tipe_laporan');
        $status_ids = $this->input->post('status_pegawai');

        if (empty($tipe_laporan) || empty($status_ids)) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger">Tipe laporan dan filter status wajib dipilih!</div>');
            redirect('Pegawai');
        }

        if ($tipe_laporan == 'pdf') {   
            $data['pegawai'] = $this->Pegawai_model->get_pegawai_by_status($status_ids);
            $this->_generate_pdf_pegawai($data);
        } elseif ($tipe_laporan == 'excel') {
            // $this->excel_pegawai(); 
            $this->excel_pegawai($status_ids); 
        } elseif ($tipe_laporan == 'excellengkap') {    
            $this->_generate_excel_lengkap($status_ids);
        }
    }

    // Laporan Pegawai (PDF)
    private function _generate_pdf_pegawai($data)
    {
        $this->load->library('pdf');
        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = "Laporan-Pegawai.pdf";
        $this->pdf->load_view('laporan/laporan_pegawai', $data);
    }
    
    // Laporan Pegawai (Excel)
    public function excel_pegawai($status_ids) { // <-- DIUBAH: Tambahkan parameter $status_ids
        // 1. Ambil data dari model berdasarkan status yang dipilih
        $data_pegawai = $this->Pegawai_model->get_pegawai_by_status($status_ids); // <-- DIUBAH: Ganti pengambilan data

        // 2. Buat objek Spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // 3. Atur Judul Laporan (dibuat lebih generik)
        $sheet->mergeCells('A1:G1');
        $sheet->setCellValue('A1', 'LAPORAN DATA PEGAWAI'); // <-- DIUBAH: Judul lebih generik
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->mergeCells('A2:G2');
        $sheet->setCellValue('A2', 'SMKN 2 PEKANBARU');
        $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        // 4. Buat Header Tabel (mulai dari baris ke-4)
        $sheet->setCellValue('A4', 'No');
        $sheet->setCellValue('B4', 'Nama Pegawai');
        $sheet->setCellValue('C4', 'NIP');
        $sheet->setCellValue('D4', 'Jenis Kelamin');
        $sheet->setCellValue('E4', 'Jabatan');
        $sheet->setCellValue('F4', 'Golongan');
        $sheet->setCellValue('G4', 'Status');

        // Beri style bold pada header
        $sheet->getStyle('A4:G4')->getFont()->setBold(true);
        $sheet->getStyle('A4:G4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // 5. Isi data pegawai dari database
        $row = 5; // Mulai dari baris ke-5
        $no = 1;
        foreach ($data_pegawai as $p) { // <-- DIUBAH: Gunakan variabel baru
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $p->nama);
            // Set NIP sebagai Teks agar tidak jadi format scientific
            $sheet->setCellValueExplicit('C' . $row, $p->nip, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('D' . $row, $p->jenis_kelamin);
            $sheet->setCellValue('E' . $row, $p->nama_jabatan);
            $sheet->setCellValue('F' . $row, $p->nama_golongan);
            $sheet->setCellValue('G' . $row, $p->nama_status);
            $row++;
        }

        // 6. Atur lebar kolom secara otomatis
        foreach (range('A', 'G') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // 7. Atur Header untuk download file .xlsx
        $filename = 'Laporan_Pegawai_' . date('Ymd') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        // 8. Buat file Excel dan kirim ke browser
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }

    // Laporan Pegawai (Excel Lengkap)
    private function _generate_excel_lengkap(array $status_ids)
    {
        $spreadsheet = new Spreadsheet();
        $sheet_index = 0;

        foreach ($status_ids as $status_id) {
            $pegawai = $this->Pegawai_model->get_pegawai_laporan_lengkap([$status_id]);
            $status_info = $this->Status_model->get_by_id($status_id);
            $sheet_title = preg_replace('/[^A-Za-z0-9 ]/', '', $status_info->nama_status); // Bersihkan nama sheet
            
            if ($sheet_index > 0) {
                $spreadsheet->createSheet();
            }
            $sheet = $spreadsheet->setActiveSheetIndex($sheet_index);
            $sheet->setTitle(substr($sheet_title, 0, 30)); // Judul sheet maks 31 karakter

            // === HEADER KOMPLEKS ===
            $sheet->mergeCells('A1:O1')->setCellValue('A1', 'LAPORAN DATA PEGAWAI')->getStyle('A1')->getFont()->setBold(true)->setSize(16);
            $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            
            // Definisikan header
            $headers = [
                'A3' => 'NO', 'B3' => 'NAMA', 'C3' => 'NIP', 'D3' => 'PANGKAT', 'F3' => 'JABATAN', 'H3' => 'MASA KERJA',
                'J3' => 'PENDIDIKAN', 'M3' => 'TEMPAT, TGL LAHIR', 'N3' => 'ALAMAT', 'O3' => 'MULAI BERTUGAS', 'P3' => 'STATUS'
            ];
            $sub_headers = [
                'D4' => 'GOL', 'E4' => 'TMT', 'F4' => 'NAMA', 'G4' => 'TMT', 'H4' => 'TAHUN', 'I4' => 'BULAN',
                'J4' => 'NAMA', 'K4' => 'THN LULUS', 'L4' => 'IJAZAH'
            ];
            
            // Merge & Set Header Utama
            $sheet->mergeCells('A3:A4')->mergeCells('B3:B4')->mergeCells('C3:C4');
            $sheet->mergeCells('D3:E3')->mergeCells('F3:G3')->mergeCells('H3:I3')->mergeCells('J3:L3');
            $sheet->mergeCells('M3:M4')->mergeCells('N3:N4')->mergeCells('O3:O4')->mergeCells('P3:P4');

            foreach ($headers as $cell => $value) { $sheet->setCellValue($cell, $value); }
            foreach ($sub_headers as $cell => $value) { $sheet->setCellValue($cell, $value); }
            
            // === ISI DATA ===
            $row = 5;
            $no = 1;
            foreach ($pegawai as $p) {
                // Kalkulasi Masa Kerja
                $masa_kerja_tahun = 0;
                $masa_kerja_bulan = 0;
                if (!empty($p->tanggal_mulai_bertugas)) {
                    $tgl_mulai = new DateTime($p->tanggal_mulai_bertugas);
                    $tgl_sekarang = new DateTime('now');
                    $interval = $tgl_mulai->diff($tgl_sekarang);
                    $masa_kerja_tahun = $interval->y;
                    $masa_kerja_bulan = $interval->m;
                }

                $sheet->setCellValue('A' . $row, $no++);
                $sheet->setCellValue('B' . $row, $p->nama);
                $sheet->setCellValueExplicit('C' . $row, $p->nip, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValue('D' . $row, $p->nama_golongan);
                $sheet->setCellValue('E' . $row, format_tanggal($p->tmt_golongan));
                $sheet->setCellValue('F' . $row, $p->nama_jabatan);
                $sheet->setCellValue('G' . $row, format_tanggal($p->tmt_jabatan));
                $sheet->setCellValue('H' . $row, $masa_kerja_tahun);
                $sheet->setCellValue('I' . $row, $masa_kerja_bulan);
                $sheet->setCellValue('J' . $row, $p->nama_jurusan);
                $sheet->setCellValue('K' . $row, $p->tahun_lulus);
                $sheet->setCellValue('L' . $row, $p->tingkat_ijazah);
                $sheet->setCellValue('M' . $row, $p->tempat_lahir . ', ' . format_tanggal($p->tanggal_lahir));
                $sheet->setCellValue('N' . $row, $p->alamat);
                $sheet->setCellValue('O' . $row, format_tanggal($p->tanggal_mulai_bertugas));
                $sheet->setCellValue('P' . $row, $p->nama_status);
                $row++;
            }
            // Style
            $styleArray = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]];
            $sheet->getStyle('A3:P' . ($row - 1))->applyFromArray($styleArray);
            $sheet->getStyle('A3:P4')->getFont()->setBold(true);
            $sheet->getStyle('A3:P4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
            
            $sheet_index++;
        }

        $spreadsheet->setActiveSheetIndex(0); // Set sheet pertama sebagai sheet aktif saat dibuka

        // Download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Laporan_Pegawai_Lengkap.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }   

    // Laporan Absensi
    // public function excel_absensi()
    // {
    //     // 1. Ambil input rentang tanggal dari form modal
    //     $start_date = $this->input->post('start_date');
    //     $end_date = $this->input->post('end_date');

    //     if (empty($start_date) || empty($end_date)) {
    //         redirect('Absensi');
    //     }

    //     // 2. Ambil data dari model dan lakukan proses pivot
    //     $raw_data = $this->Absensi_model->get_rekap_absensi($start_date, $end_date);
    //     $pegawai_data = [];
    //     foreach ($raw_data as $row) {
    //         if (!isset($pegawai_data[$row->userid])) {
    //             $pegawai_data[$row->userid] = [
    //                 'nama' => $row->name,
    //                 'absensi' => []
    //             ];
    //         }
    //         $jam_masuk = substr($row->jam_masuk, 0, 5);
    //         $jam_keluar = substr($row->jam_keluar, 0, 5);
    //         // Gabungkan jam masuk & keluar dengan newline untuk format petak
    //         $pegawai_data[$row->userid]['absensi'][$row->tanggal] = ($jam_masuk == $jam_keluar) ? $jam_masuk : $jam_masuk . "\n" . $jam_keluar;
    //     }

    //     // 3. Persiapan membuat file Excel
    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $sheet->setTitle('Rekap Kehadiran');

    //     // 4. Membuat Judul Laporan
    //     $nama_bulan_tahun = strtoupper(format_tanggal(date('Y-m-d', strtotime($start_date))));
    //     $nama_bulan_tahun = substr($nama_bulan_tahun, strpos($nama_bulan_tahun, " ") + 1);

    //     $sheet->mergeCells('A1:D1')->setCellValue('A1', 'DAFTAR HADIR GURU DAN PEGAWAI')->getStyle('A1')->getFont()->setBold(true)->setSize(14);
    //     $sheet->mergeCells('A2:D2')->setCellValue('A2', 'SMKN 2 PEKANBARU')->getStyle('A2')->getFont()->setBold(true);
    //     $sheet->mergeCells('A3:D3')->setCellValue('A3', 'BULAN: ' . $nama_bulan_tahun)->getStyle('A3')->getFont()->setBold(true);

    //     // 5. Membuat Header Tabel (disederhanakan tanpa Jabatan)
    //     $sheet->mergeCells('A5:A8')->setCellValue('A5', 'NO');
    //     $sheet->mergeCells('B5:B8')->setCellValue('B5', 'NAMA'); // Header diubah
    //     $sheet->setCellValue('C6', 'TANGGAL'); // Header utama untuk tanggal
        
    //     $date_range = new DatePeriod(new DateTime($start_date), new DateInterval('P1D'), (new DateTime($end_date))->modify('+1 day'));
    //     $kolom_index = 3; // Mulai dari kolom C
    //     foreach ($date_range as $tanggal) {
    //         $kolom_huruf = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($kolom_index);
    //         $sheet->setCellValue($kolom_huruf . '7', $tanggal->format('d')); // Angka tanggal
    //         $sheet->setCellValue($kolom_huruf . '8', substr(format_hari($tanggal->format('Y-m-d')), 0, 1)); // Inisial Hari
            
    //         // Tandai akhir pekan (Sabtu/Minggu) dengan warna abu-abu
    //         if (date('N', $tanggal->getTimestamp()) >= 6) {
    //             $sheet->getStyle($kolom_huruf . '5:' . $kolom_huruf . (count($pegawai_data) + 8))->getFill()
    //                 ->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFD3D3D3');
    //         }
    //         $kolom_index++;
    //     }
    //     $last_col_huruf = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($kolom_index - 1);
    //     $sheet->mergeCells('C6:' . $last_col_huruf . '6');

    //     // 6. Mengisi Data Pegawai
    //     $baris = 9; // Data mulai dari baris 9
    //     $no = 1;
    //     foreach ($pegawai_data as $data) {
    //         $sheet->setCellValue('A' . $baris, $no++);
    //         $sheet->setCellValue('B' . $baris, $data['nama']);

    //         $kolom_index_data = 3; // Mulai dari kolom C
    //         foreach ($date_range as $tanggal) {
    //             $kolom_huruf_data = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($kolom_index_data);
    //             $tanggal_str = $tanggal->format('Y-m-d');
    //             $cellValue = isset($data['absensi'][$tanggal_str]) ? $data['absensi'][$tanggal_str] : '';
    //             $sheet->setCellValue($kolom_huruf_data . $baris, $cellValue);
    //             $kolom_index_data++;
    //         }
    //         $baris++;
    //     }

    //     // 7. Styling Profesional
    //     $last_row = $baris - 1;
    //     $full_range = 'A5:' . $last_col_huruf . $last_row;

    //     // Terapkan semua style ke seluruh range tabel
    //     $styleArray = [
    //         'font' => ['bold' => true],
    //         'alignment' => [
    //             'horizontal' => Alignment::HORIZONTAL_CENTER,
    //             'vertical' => Alignment::VERTICAL_CENTER,
    //             'wrapText' => true,
    //         ],
    //         'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
    //     ];
    //     $sheet->getStyle($full_range)->applyFromArray($styleArray);

    //     // Atur lebar kolom
    //     $sheet->getColumnDimension('A')->setWidth(5);
    //     $sheet->getColumnDimension('B')->setWidth(35);
    //     // Atur lebar semua kolom tanggal
    //     $kolom_index_lebar = 3;
    //     while ($kolom_index_lebar < $kolom_index) {
    //         $sheet->getColumnDimensionByColumn($kolom_index_lebar)->setWidth(9);
    //         $kolom_index_lebar++;
    //     }

    //     // 8. Proses Download
    //     $filename = 'Laporan_Kehadiran_' . str_replace(' ', '_', $nama_bulan_tahun) . '.xlsx';
    //     header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //     header('Content-Disposition: attachment;filename="' . $filename . '"');
    //     header('Cache-Control: max-age=0');
    //     $writer = new Xlsx($spreadsheet);
    //     $writer->save('php://output');
    //     exit();
    // }

    public function excel_absensi()
    {
        // 1. Ambil input rentang tanggal dari form modal
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');

        if (empty($start_date) || empty($end_date)) {
            redirect('Absensi');
        }

        // 2. Ambil data dari model dan lakukan proses pivot
        $raw_data = $this->Absensi_model->get_rekap_absensi($start_date, $end_date);
        $pegawai_data = [];
        foreach ($raw_data as $row) {
            if (!isset($pegawai_data[$row->userid])) {
                $pegawai_data[$row->userid] = [
                    'nama' => $row->name,
                    'absensi' => []
                ];
            }
            $jam_masuk = substr($row->jam_masuk, 0, 5);
            $jam_keluar = substr($row->jam_keluar, 0, 5);
            $pegawai_data[$row->userid]['absensi'][$row->tanggal] = ($jam_masuk == $jam_keluar) ? $jam_masuk : $jam_masuk . "\n" . $jam_keluar;
        }

        // 3. Persiapan membuat file Excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Rekap Kehadiran');

        // 4. Membuat Judul Laporan
        $nama_bulan_tahun = strtoupper(format_tanggal(date('Y-m-d', strtotime($start_date)), false));
        $nama_bulan_tahun = substr($nama_bulan_tahun, strpos($nama_bulan_tahun, " ") + 1);

        $sheet->mergeCells('A1:D1')->setCellValue('A1', 'DAFTAR HADIR GURU DAN PEGAWAI')->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->mergeCells('A2:D2')->setCellValue('A2', 'SMKN 2 PEKANBARU')->getStyle('A2')->getFont()->setBold(true);
        $sheet->mergeCells('A3:D3')->setCellValue('A3', 'BULAN: ' . $nama_bulan_tahun)->getStyle('A3')->getFont()->setBold(true);
        $sheet->getStyle('A1:A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // 5. Membuat Header Tabel (Struktur Diperbaiki)
        // PERBAIKAN: Merge 'NO' dan 'NAMA' hanya sampai baris 7
        $sheet->mergeCells('A5:A7')->setCellValue('A5', 'NO');
        $sheet->mergeCells('B5:B7')->setCellValue('B5', 'NAMA');
        
        // PERMINTAAN: Judul 'TANGGAL' di merge ke samping dan di tengah
        $sheet->setCellValue('C5', 'TANGGAL'); 
        
        $date_range = new DatePeriod(new DateTime($start_date), new DateInterval('P1D'), (new DateTime($end_date))->modify('+1 day'));
        $kolom_index = 3; // Mulai dari kolom C
        foreach ($date_range as $tanggal) {
            $kolom_huruf = Coordinate::stringFromColumnIndex($kolom_index);
            $sheet->setCellValue($kolom_huruf . '6', $tanggal->format('d')); // Angka tanggal di baris 6
            $sheet->setCellValue($kolom_huruf . '7', substr(format_hari($tanggal->format('Y-m-d')), 0, 1)); // Inisial hari di baris 7
            $kolom_index++;
        }
        $last_col_huruf = Coordinate::stringFromColumnIndex($kolom_index - 1);
        $sheet->mergeCells('C5:' . $last_col_huruf . '5'); // Merge header 'TANGGAL'


        // 6. Mengisi Data Pegawai
        // PERBAIKAN: Data dimulai dari baris 8
        $baris = 8;
        $no = 1;
        foreach ($pegawai_data as $data) {
            $sheet->setCellValue('A' . $baris, $no++);
            $sheet->setCellValue('B' . $baris, $data['nama']);

            $kolom_index_data = 3;
            foreach ($date_range as $tanggal) {
                $kolom_huruf_data = Coordinate::stringFromColumnIndex($kolom_index_data);
                $tanggal_str = $tanggal->format('Y-m-d');
                
                if (date('N', $tanggal->getTimestamp()) < 6) {
                    $cellValue = isset($data['absensi'][$tanggal_str]) ? $data['absensi'][$tanggal_str] : '';
                    $sheet->setCellValue($kolom_huruf_data . $baris, $cellValue);
                }
                $kolom_index_data++;
            }
            $baris++;
        }

        // 7. Styling Profesional dan Penanganan Hari Libur (Sabtu & Minggu)
        $last_row = $baris - 1;
        $header_range = 'A5:' . $last_col_huruf . '7';

        $headerStyle = [
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFE2EFDA']], // Warna hijau header
        ];
        $sheet->getStyle($header_range)->applyFromArray($headerStyle);
        
        $bodyStyle = [
             'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ];
        $sheet->getStyle('A8:' . $last_col_huruf . $last_row)->applyFromArray($bodyStyle);
        $sheet->getStyle('B8:B' . $last_row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)->setIndent(1);
        
        // PERBAIKAN: Proses Merge dan Pewarnaan Hari Libur (Hanya Area Data)
        $kolom_libur_index = 3;
        foreach ($date_range as $tanggal) {
             if (date('N', $tanggal->getTimestamp()) >= 6) { 
                $kolom_libur_huruf = Coordinate::stringFromColumnIndex($kolom_libur_index);
                
                // Merge cell dari baris data pertama (8) sampai baris data terakhir
                $merge_range = $kolom_libur_huruf . '8:' . $kolom_libur_huruf . $last_row;
                $sheet->mergeCells($merge_range);
                
                $sheet->getStyle($merge_range)->getFill()
                      ->setFillType(Fill::FILL_SOLID)
                      ->getStartColor()->setARGB('FFFFC7CE'); // Warna merah muda
            }
            $kolom_libur_index++;
        }

        // 8. Atur lebar kolom
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(35);
        $kolom_index_lebar = 3;
        while ($kolom_index_lebar < $kolom_index) {
            $sheet->getColumnDimensionByColumn($kolom_index_lebar)->setWidth(9);
            $kolom_index_lebar++;
        }

        // 9. Proses Download
        $filename = 'Laporan_Kehadiran_' . str_replace(' ', '_', $nama_bulan_tahun) . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }

    public function pdf_surat_keterangan($id)
    {
        $this->load->library('pdf');

        $data['surat'] = $this->SuratKeterangan_model->get_surat_by_id($id);    
        $data['kepala_sekolah'] = $this->Pegawai_model->get_kepala_sekolah();

        $this->pdf->setPaper('A4', 'portrait');
        $this->pdf->filename = "Surat-Keterangan-".$id.".pdf";  
        $this->pdf->load_view('laporan/laporan_surat_keterangan', $data);
    }
    
    public function pdf_surat_tugas($id)
    {
        $this->load->library('pdf');

        $data['surat'] = $this->SuratTugas_model->get_surat_detail_by_id($id);
        $data['pelaksana'] = $this->PelaksanaTugas_model->get_pelaksana_by_surat_id($id);
        
        $data['kepala_sekolah'] = $this->Pegawai_model->get_kepala_sekolah();
        
        if (!$data['surat']) {  
            show_error('Data Surat Tugas tidak ditemukan.', 404, 'Error');
            return;
        }

        $this->pdf->setPaper('A4', 'portrait');
        $this->pdf->filename = "Surat-Tugas-".$id.".pdf";  
        $this->pdf->load_view('laporan/laporan_surat_tugas', $data);    
    }

    public function pdf_surat_cuti($id)
    {
        $this->load->library('pdf');

        // 1. Ambil data utama surat cuti
        $data['cuti'] = $this->SuratCuti_model->get_cuti_by_id($id);
        
        // 2. Ambil data Kepala Sekolah untuk tanda tangan
        $data['kepala_sekolah'] = $this->Pegawai_model->get_kepala_sekolah();

        // 3. Cek jika data cuti tidak ditemukan
        if (!$data['cuti']) {
            show_error('Data Surat Cuti tidak ditemukan.', 404, 'Error: Data Not Found');
            return;
        }
        
        // 4. Konfigurasi dan load view untuk PDF
        // Diubah menjadi F4 agar lebih panjang
        $this->pdf->setPaper('F4', 'portrait'); 
        $this->pdf->filename = "Surat-Cuti-" . str_replace(' ', '-', $data['cuti']->nama_pemohon) . ".pdf";
        $this->pdf->load_view('laporan/laporan_surat_cuti', $data);
    }

}   

?>
