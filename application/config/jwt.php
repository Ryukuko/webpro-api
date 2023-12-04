<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

$config['jwt_key'] = '123456';
$config['jwt_algorithm'] = 'HS256';
$config['jwt_issuer'] = 'https://serverprovider.com';
$config['jwt_audience'] = 'https://serverclient.com';
$config['jwt_expire'] = 3600 ;
