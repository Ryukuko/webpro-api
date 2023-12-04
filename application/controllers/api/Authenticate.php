<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require_once FCPATH . 'vendor/autoload.php';

use Firebase\JWT\JWT;
use Restserver\Libraries\REST_Controller;

class Authenticate extends REST_Controller {
    
    function __construct($config = 'rest'){
        parent::__construct($config);
        $this->load->library('jwt');
    }
    public function generateSecretKey_get()
    {
        $length = 21;
        $secretKey = bin2hex(random_bytes($length));

        return $this->response(['aku_mah_apa_atuh' => $secretKey]);
    }

    public function getToken_post(){
        $data = array(
            'username' => $this->input->post('username'),
            'password' => $this->input->post('password')
        );
        $token = $this->jwt->encode($data);
        $output = [
            'status' => 200,
            'message' => 'Berhasil Login',
            'token' => $token
        ];
        $data = array($output);
        $this->response($data,200);
    }
}