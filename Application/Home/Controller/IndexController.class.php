<?php

namespace Home\Controller;

use Think\Controller;

class IndexController extends BaseController
{
    public function index()
    {
//        $search = array("APPID", 'SECRET', 'JSCODE');
//        $replace = array($this->getAppid(), $this->getAppsecret(), '011LX2ti2lBuSE0L8Lti2rvsti2LX2ts');
//        $url = str_replace($search, $replace, $this->getWxGetOpenUrl());
//        dump($url);
        $url='https://api.weixin.qq.com/sns/jscode2session?appid=wx6fc5f4836fc51f82&secret=aab9cf6c1f3de3f225d787afb097e40d&js_code=001Wsqyt1Qa1bb0O5bAt1efHyt1WsqyM&grant_type=authorization_code';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        dump($result);
    }
}