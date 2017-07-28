<?php

namespace Home\Controller;


class IndexController extends BaseController
{
    public function index()
    {
        $search = array("APPID", 'SECRET', 'JSCODE');
        $replace = array($this->getAppid(), $this->getAppsecret(), '011LX2ti2lBuSE0L8Lti2rvsti2LX2ts');
        $url = str_replace($search, $replace, $this->getWxGetOpenUrl());
        dump($url);
//        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid=wx6fc5f4836fc51f82&secret=aab9cf6c1f3de3f225d787afb097e40d&js_code=001HHmtq00MqKq1fDxvq00ebtq0HHmtH&grant_type=authorization_code';
        $result = sendPost($url);
        dump($result);
    }
}