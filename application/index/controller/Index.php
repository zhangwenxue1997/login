<?php
namespace app\index\controller;

use think\Controller;
use app\index\controller\Common;
class Index extends Controller
{
     public function index()//首页  没登录过就登录
    {
        
        if(!empty($_COOKIE['username'])){  //判断有没有cookie
            session('username',$_COOKIE['username']);  // 有就赋给 session'
        }  
        if(session('username')){
            $this->redirect('Index/newpage');
        }
        return $this->fetch();
    }
    public function esc()//注销登录
    {
        $_SESSION = array(); //清除SESSION值.  
        if(isset($_COOKIE["username"])){  //判断客户端的cookie文件是否存在,存在的话将其设置为过期.  
            setcookie('username','',time()-1,'/');  
        }  
        session_start();
        session_destroy();
        return $this->redirect('index');
    }
    public function newpage()
    {
        return $this->fetch();
    }
    
}
