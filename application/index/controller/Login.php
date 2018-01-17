<?php
namespace app\index\controller;

use think\Controller;
class Login extends Controller
{
	
	public function do_login()
	{
		$data=input('post.');
		$name=input('post.username');
    	$password=input('post.password');
         //$name="张文雪";
    	$db=db('user');
    	$info=$db->where("username='".$name."'")->find();
        // echo "<pre>";
        // print_r($info);exit;
    	if($info)
    	{
    		if($info['password']==$password)
    		{
    			session('user',$info['Id']);
                session('username',$name);
                if(!empty($data['xuanze']))
                {
                    cookie('username',$name,3600);
             
                }

    			$datas=[
    				'msg'=>'登陆成功',
    				'status'=>1
    			];
    			return $datas;
    		}else{
    			$datas=[
    				'msg'=>'密码错误',
    				'status'=>0
    			];
    			return $datas;
    		}
    	}
    	else{
    		$datas=[
                    'msg'=>'用户名不对',
                    'status'=>0
                ];
            return $datas;
    	}
	}
    public function do_reg()
    {
        $data=input('post.');
        $db=db('user');
        $info=$db->where("username='".$data['username']."'")->find();
        if($info)
        {
            $datas=[
                    'msg'=>'用户名已经存在',
                    'status'=>0
                ];
            return $datas;
        }else{
            if($data['password']==$data['password1'])
            {
                unset($data['password1']);
                $ins=$db->insert($data);
                $datas=[
                    'msg'=>'注册成功',
                    'status'=>1
                ];
                return $datas;
            }else{
                $datas=[
                    'msg'=>'密码不一致',
                    'status'=>0
                ];
                return $datas;
            }
        }
    }
}
?>