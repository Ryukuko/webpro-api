<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Kelas extends REST_Controller
{
    function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->database('api_sekolah');
        $this->load->model('kelasModel');
        $this->load->library('form_validation');
    }
    function index_get()
    {
        $id = $this->get('id');
        if ($id == '')
        {
            $data = $this->kelasModel->fetch_all();
        }else{
            $data = $this->kelasModel->fetch_single_data($id);
        }
        $this->response($data, 200);
    }
    function index_post()
    {
        if ($this->post('kode_kelas') == ''){
            $response = array(
                'status' => 'gagal',
                'field' => 'class_code',
                'message' => 'tidak boleh kosong',
                'status_code' => 502
            );
            return $this->response($response);
        }
        if ($this->post('nama_kelas') == ''){
            $response = array(
                'status' => 'gagal',
                'field' => 'class_name',
                'message' => 'todak boleh kosong',
                'status_code' => 502
            );
            return $this->response($response);
        }
        $data = array(
            'class_code' => trim($this->post('kode_kelas')),
            'class_name' => trim($this->post('nama_kelas')),
        );
        $this->kelasModel->insert_api($data);
        $last_row = $this->db->select('*')->order_by('id','desc')->limit(1)->get('kelas')->row();
        $response = array(
            'status' => 'berhasil',
            'data' => $last_row,
            '$status_code' => 201
        );
        return $this->response($response);
    }
    function index_put(){
        $id = $this->put('id');
        $check = $this->kelasModel->check_data($id);
        if($check == false){
            $error = array(
                'status' => 'gagal',
                'field' => 'id',
                'message' => 'data tidak ditemukan',
                'status_code' => 502
            );
            return $this->response($error);
        }
        if ($this->put('kode_kelas') == ''){
            $response = array(
                'status' => 'gagal',
                'field' => 'class_code',
                'message' => 'tidak boleh kosong',
                'status_code' => 502
            );
            return $this->response($response);
        }
        if ($this->put('nama_kelas') == ''){
            $response = array(
                'status' => 'gagal',
                'field' => 'class_name',
                'message' => 'todak boleh kosong',
                'status_code' => 502
            );
            return $this->response($response);
        }
        $data = array(
            'class_code' => trim($this->put('kode_kelas')),
            'class_name' => trim($this->put('nama_kelas')),
        );
        $this->kelasModel->update_data($id,$data);
        $dataBaru = $this->kelasModel->fetch_single_data($id);
        $response = array(
            'status' => 'berhasil',
            'data' => $dataBaru,
            'status_code'=> 200,
        );
        return $this->response($response); 
    }
    function index_delete(){
        $id = $this->delete('id');
        $check = $this->kelasModel->check_data($id);
        if($check == false){
            $error = array(
                'status' => 'gagal',
                'field' => 'id',
                'message' => 'data tidak ada',
                'status_code' => 502
            );
            return $this->response($error);
        }
        $delete = $this->kelasModel->delete_data($id);
        $response = array(
            'status'=> 'berhasil',
            'data' => null,
            'status_code'=> 200
        );
        return $this->response($response);
    }

}