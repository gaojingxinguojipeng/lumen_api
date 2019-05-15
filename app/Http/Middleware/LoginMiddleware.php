<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Redis;
use Closure;

class LoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//        $key="TextTime";
//        $num=Redis::get($key);
//        if($num>10){
//            die("超过次数限制");
//        }
//        echo "num:".$num;echo'</br>';
//        Redis::incr($key);
//        Redis::expire($key,60);
//        return $next($request);
        $token=$request->input("token");
        $uid=$request->input("uid");
        if (empty($token) || empty($uid)){
            $response = [
                'code'  =>  2,
                'msg'    =>  '请先登录'
            ];
            return $response;
        }else{
            $key = 'login_token'.$uid;
            $redis_token = Redis::get($key);
            if ($redis_token == $token){
                //TODO 登录成功
                $response = [
                    'code'  =>  0,
                    'msg'    =>  '登录成功'
                ];
                return $response;

            }else{
                //TODO token需要授权
                $response = [
                    'code'  =>  3,
                    'msg'    =>  '请先登录'
                ];
                return $response;
            }
        }

        return $next($request);
    }

}
