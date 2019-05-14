<?php

namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;

class UserController extends Controller
{
    //非对称解密
    public function rsa(){
    echo '<pre>';print_r($_GET);echo '</pre>';
    $str=file_get_contents("php://input");
    echo 'json:'.$str;echo'</br>';echo'<hr>';

    $rec_sign=$_GET['sign'];

    //解密
    $pk=openssl_get_publickey('file://'.storage_path('app/keys/public.pem'));
    $res=openssl_verify($str,base64_decode($rec_sign),$pk);
    //echo '<hr>';
    //echo $dec_data;
    var_dump($res);

    }




}