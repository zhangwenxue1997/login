<?php
namespace app\user\controller;

use think\Controller;

class User extends Controller
{
    public function getopenid()
    {
        //return '111';
        $code=input('code');
        $id=input('id');
        $url="https://api.weixin.qq.com/sns/jscode2session?appid=wx72d1adff132a40e9&secret=728a142e29c5dfb1dda0b338bbd9ee45&js_code=".$code."&grant_type=authorization_code";
         //初始化
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = json_decode(curl_exec($ch),true) ;
        curl_close($ch);
        //print_r($output);exit;
        $data['openid']=$output['openid'];
		//print_r($data);exit;
        if($id==1){
            $info=db('wx_teacher')->insert($data);
        }else{
            $info=db('wx_users')->insert($data);
        }
         if($info)
            {
                $result="succ";
            }
            else{
                $result="fail";
            }
        return json($result);
    }
     public function getopenids()
    {
        //echo "123";exit;
        $code=input('code');
        // $code='021TLdwr1digjq0z70vr1hlUvr1TLdwf';
        $id=input('id');
        $url="https://api.weixin.qq.com/sns/jscode2session?appid=wx72d1adff132a40e9&secret=728a142e29c5dfb1dda0b338bbd9ee45&js_code=".$code."&grant_type=authorization_code";
        //初始化
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }
	public function choserule()
	{
		$info=db('wx_choserule')->find();
		
		return json($info);
	}
    public function rules()
    {
        $code=input('code');
        $url="https://api.weixin.qq.com/sns/jscode2session?appid=wx72d1adff132a40e9&secret=728a142e29c5dfb1dda0b338bbd9ee45&js_code=".$code."&grant_type=authorization_code";
         //初始化
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = json_decode(curl_exec($ch),true) ;
        $result['openid'];
        $info=db('wx_teacher')->where("openid='".$result['openid']."'")->find();
        if(!empty($info))
        {
            $msg=[
                'flag'=>1,
            ];
        }
        else{
            $infos=db('wx_users')->where("openid='".$result['openid']."'")->find();
            if(!empty($infos))
            {
                $msg=[
                    'flag'=>2,
                ];
            }
            else{
                $msg=[
                    'flag'=>0,
                ];
            }
        }
        return json($msg);
    }
}
