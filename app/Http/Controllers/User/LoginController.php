<?php

namespace App\Http\Controllers\User;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
class LoginController extends Controller
{
    public function pub(){
        echo '<pre>';print_r($_GET);echo '</pre>';
        $str=file_get_contents("php://input");
        echo 'json:'.$str;echo'</br>';echo'<hr>';
//        $data=json_decode($str);
//        echo $data;
//        echo 111;
        $rec_sign=$_GET['sign'];

        //解密
        $pk=openssl_get_publickey('file://'.storage_path('app/keys/public.pem'));
        $res=openssl_verify($str,base64_decode($rec_sign),$pk);

    var_dump($res);
    if($res==1){
        $token=$this->generateLoginToken();
        setcookie("token",$token,time()+86400,"/",".api.com");
        echo "登陆成功";
    }
    }
    private function generateLoginToken(){
        return substr(sha1(time().Str::random(10)),5,15);
    }
    public function kuayuDo(){


        $arr=["code"=>1];
        $callback=$_GET["callback"];
        $str=json_encode($arr);
//        setcookie("uid",1,time()+3600,"/",".kuayu.com");
//        setcookie("uname","lisi",time()+3600,"/",".kuayu.com");
        echo "$callback($str)";
    }


    public function register(Request $request){
        $name=$request->input("name");
        $pwd=$request->input("pwd");
        $data=[
            "name"=>$name,
            "pwd"=>$pwd
        ];
        $arr=DB::table("user2")->insert($data);
        if($arr){
            $response=[
                "code"=>1,
                "msg"=>"注册成功",
            ];
            return $response;
        }else{
            $response=[
                "code"=>2,
                "msg"=>"注册失败",
            ];
            return $response;
        }
    }





}