<?php
namespace app\index\controller;

use think\Controller;
class Common extends Controller
{
	public function _initialize()
    {
        //echo session('username');exit;
        if($_COOKIE['username']!='')
        {
            session('username',$_COOKIE['username']);
        }
        if(session('username')=='')
        {
            $this->display('Index/index');
        }
    }
}
   