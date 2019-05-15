<?php

namespace App\Http\Controllers\User;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
class LoginController extends Controller
{
    public function pub(){
        echo '<pre>';print_r($_GET);echo '</pre>';
        $str=file_get_contents("php://input");
        echo 'json:'.$str;echo'</br>';echo'<hr>';
        $rec_sign=$_GET['sign'];

        //解密
        $pk=openssl_get_publickey('file://'.storage_path('app/keys/public.pem'));
        $res=openssl_verify($str,base64_decode($rec_sign),$pk);

    var_dump($res);
    if($res==1){
//        $token=$this->generateLoginToken();
//        setcookie("token",$token,time()+86400,"/",".api.com");
        echo "登陆成功";
    }
    }
//    private function generateLoginToken(){
//        return substr(sha1(time().Str::random(10)),5,15);
//    }
    public function kuayuDo(){


        $arr=["code"=>1];
        $callback=$_GET["callback"];
        $str=json_encode($arr);
//        setcookie("uid",1,time()+3600,"/",".kuayu.com");
//        setcookie("uname","lisi",time()+3600,"/",".kuayu.com");
        echo "$callback($str)";
    }

//注册
    public function register(Request $request){
        $name=$request->input("name");
        $pwd=$request->input("pwd");
        $data=[
            "name"=>$name,
            "pwd"=>$pwd
        ];
        $json_str=json_encode($data);
        $api_url = "http://laravel.gaojingxin.top/openreg";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_str);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type:text/plain'
        ]);
        $response = curl_exec($ch);
        $err_code = curl_errno($ch);
        if ($err_code > 0) {
            echo "CURL 错误码：" . $err_code;
            exit;
        }
        curl_close($ch);
    }

//登录
public  function login(Request $request){
    $name=$request->input("name");
    $pwd=$request->input("pwd");
    $where=[
        "name"=>$name,
        "pwd"=>$pwd,
    ];
    $res=DB::table("user2")->where($where)->first();
    if($res){
        $token=$this->generateLoginToken($res->id);
        $key="login_token".$res->id;
        Redis::set($key,$token);
        Redis::expire($key,86400);
        $key="login_token".$res->id;
        $token=Redis::get($key);
        $response=[
            "code"=>1,
            "msg"=>"登录成功",
            "token"=>$token,
            "uid"=>$res->id,
        ];
        return $response;
    }
}

public function checkLogin(){
    $response = [
        'code'  =>  4,
        'msg'    =>  '欢迎来到个人中心'
    ];
    return $response;

}
public function a(){
    echo 111;
}
    private function generateLoginToken($id){
        return substr(sha1($id.time().Str::random(10)),5,15);
    }



}