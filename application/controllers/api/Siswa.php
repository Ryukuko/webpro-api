<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Siswa extends REST_Controller
{
    function __construct($config = 'rest')
    {
        parent::__construct($config);
        header('Access-Control-Allow-Origin:*');
            header("Access-Control-Allow-Headers:X-API-KEY,Origin,X-Requested-With,Content-Type,Accept,Access-Control-Request-Method,Authorization");
            header("Access-Control-Allow-Methods:GET,POST,OPTIONS,PUT,DELETE");
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "OPTIONS") {
                die();
            }
        $this->load->database('sekolah_api');
        $this->load->model('siswaModel');
        $this->load->library('form_validation');
    }

    // 
    public function options_get() {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT,
       DELETE");
       header("Access-Control-Allow-Headers: Content-Type,
       Access-Control-Allow-Headers, Authorization, X-Requested-With");
        exit();
       }

    function index_get()
    {
        if ($this->jwt->decode($this->input->request_header()['Authorization']) == false){
            return $this->response(
                array(
                    'kode' =>'401',
                    'pesan' => 'signature tidak sesuai',
                    'data' => []
                ), '401'
            );
        }
        $id = $this->get('id');
        if ($id == '')
        {
            $data = $this->siswaModel->fetch_all();
        }else{
            $data = $this->siswaModel->fetch_single_data($id);
        }
        $this->response($data, 200);
    }
    function index_post()
    {
        if ($this->post('nama') == ''){
            $response = array(
                'status' => 'gagal',
                'field' => 'nama',
                'message' => 'tidak boleh kosong',
                'status_code' => 502
            );
            return $this->response($response);
        }
        if ($this->post('id_kelas') == ''){
            $response = array(
                'status' => 'gagal',
                'field' => 'id_kelas',
                'message' => 'todak boleh kosong',
                'status_code' => 502
            );
            return $this->response($response);
        }
        if ($this->post('tanggal_lahir') == ''){
            $response = array(
                'status' => 'gagal',
                'field' => 'tanggal_lahir',
                'message' => 'todak boleh kosong',
                'status_code' => 502
            );
            return $this->response($response);
        }
        if ($this->post('gender') == ''){
            $response = array(
                'status' => 'gagal',
                'field' => 'gender',
                'message' => 'todak boleh kosong',
                'status_code' => 502
            );
            return $this->response($response);
        }
        if ($this->post('alamat') == ''){
            $response = array(
                'status' => 'gagal',
                'field' => 'alamat',
                'message' => 'todak boleh kosong',
                'status_code' => 502
            );
            return $this->response($response);
        }
        $data = array(
            'name' => trim($this->post('nama')),
            'class_id' => trim($this->post('id_kelas')),
            'date_birth' => trim($this->post('tanggal_lahir')),
            'gender' => trim($this->post('gender')),
            'address' => trim($this->post('alamat'))
        );
        $this->siswaModel->insert_api($data);
        $last_row = $this->db->select('*')->order_by('id','desc')->limit(1)->get('siswa')->row();
        $response = array(
            'status' => 'berhasil',
            'data' => $last_row,
            '$status_code' => 201
        );
        return $this->response($response);
    }
    function index_put()
        {
            $id = $this->put('id');
            $check = $this->siswaModel->check_data($id);
            if ($check == false){
                $error = array (
                    'status' => 'fail',
                    'field' => 'id',
                    'message' => 'data tidak terdaftar',
                    'status_code' => 502
                );
                return $this->response($error);
            }
            if ($this->put('nama')==''){
                $response = array (
                    'status' => 'fail',
                    'field' => 'nama',
                    'message' => 'tidak boleh kosong',
                    'status_code' => 502
                );
                return $this->response($response);
            }
            if ($this->put('id_kelas') == ''){
                $response = array(
                    'status' => 'gagal',
                    'field' => 'id_kelas',
                    'message' => 'tidak boleh kosong',
                    'status_code' => 502
                );
                return $this->response($response);
            }
            if ($this->put('tanggal_lahir') == ''){
                $response = array(
                    'status' => 'gagal',
                    'field' => 'tanggal_lahir',
                    'message' => 'tidak boleh kosong',
                    'status_code' => 502
                );
                return $this->response($response);
            }
            if ($this->put('gender') == ''){
                $response = array(
                    'status' => 'gagal',
                    'field' => 'gender',
                    'message' => 'tidak boleh kosong',
                    'status_code' => 502
                );
                return $this->response($response);
            }
            if ($this->put('alamat') == ''){
                $response = array(
                    'status' => 'gagal',
                    'field' => 'alamat',
                    'message' => 'tidak boleh kosong',
                    'status_code' => 502
                );
                return $this->response($response);
            }
            $data = array(
                'name' => trim($this->put('nama')),
                'class_id' => trim($this->put('id_kelas')),
                'date_birth' => trim($this->put('tanggal_lahir')),
                'gender' => trim($this->put('gender')),
                'address' => trim($this->put('alamat'))
            );
            $this->siswaModel->update_data($id,$data);
            $newData = $this->siswaModel->fetch_single_data($id);
            $response = array(
                'status' => 'succes',
                'data' => $newData,
                'status_code' => 200
            );
            return $this->response($response);
        }
        function index_delete(){
            $id = $this->delete('id');
            $check = $this->siswaModel->check_data($id);
            if ($check == false){
                $error = array (
                    'status' => 'fail',
                    'field' => 'id',
                    'message' => 'data tidak terdaftar',
                    'status_code' => 502
                );
                return $this->response($error);
            }
            $delete = $this->siswaModel->delete_data($id);
            $response = array (
                'status' => 'succes',
                'data' => null,
                'status_code' => 200
            );
            return $this->response($response);        
        }
    
}

?>