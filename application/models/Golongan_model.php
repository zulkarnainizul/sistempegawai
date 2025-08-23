<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Golongan_model extends CI_Model {

    public function get_data(){
        $this->db->from('golongan_pegawai');
        $this->db->order_by('date_create', 'desc'); 
        return $this->db->get()->result();
    }

    public function insert_data($data, $table){
        $this->db->insert($table, $data);
        
    }
    
    public function update_data($data, $table){
        $this->db->where('id_golongan', $data['id_golongan']);
        $this->db->update($table, $data);
    }

    public function delete($where, $table){
        $this->db->where($where);
        $this->db->delete($table);
    }

}
