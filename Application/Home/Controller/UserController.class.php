<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/7/24
 * Time: 17:26
 */

namespace Home\Controller;

use Home\Controller\BaseController;

class UserController extends BaseController
{
    /**
     * 微信登录 添加用户
     */
    public function wxLogin()
    {
        $code = I('post.code');
//        $search = array("APPID", 'SECRET', 'JSCODE');
//        $replace = array($this->getAppid(), $this->getAppsecret(), $code);
//        $url = str_replace($search, $replace, $this->getWxGetOpenUrl());
        dump('code-----' . $code);
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid=wx6fc5f4836fc51f82&secret=aab9cf6c1f3de3f225d787afb097e40d&js_code=' . $code . '&grant_type=authorization_code';

        $wxObject = sendPost($url);
        dump('wxObject:' . $wxObject);
        //判断用户是否存在
        if ($this->checkUser($wxObject['openid'])) {
            $data['token'] = $this->getWxToken();
            $data['token_expiresIn'] = date('Y-m-d H:i:s', mktime(date('H'), date('i'), date('s'), date('m'), date('d') + 3));
            $id = $this->getUserModel()->where(array('openid' => $wxObject['openid']))->save($data);
        } else {
            $data['id'] = time();
            $data['openid'] = $wxObject['openid'];
            $data['token'] = $this->getWxToken();
            $data['token_expiresIn'] = date('Y-m-d H:i:s', mktime(date('H'), date('i'), date('s'), date('m'), date('d') + 3));
            $data['create_time'] = date('Y-m-d H:i:s');
            $id = M('User')->add($data);
        }
        if ($id) {
            $this->response(array('token' => $data['token']));
        } else {
            $this->response($this->getFAIL(), 502, false);
        }
    }

    /**
     * 添加用户的功能
     */
    private
    function add($openid)
    {
        $data['id'] = time();
        $data['openid'] = $openid;
        $data['token'] = $this->getWxToken();
        $data['token_expiresIn'] = date('Y-m-d H:i:s', mktime(date('d') + 3));
        $data['create_time'] = date('Y-m-d H:i:s');
        $id = $this->getUserModel()->add($data);
        if ($id) {

            return $data['token'];
        }
        return false;
    }

    /**
     * 根据openid刷新 token
     */
    private function updateTokenByOpenid($openid)
    {
        $data['token'] = $this->getWxToken();
        $data['token_expiresIn'] = date('Y-m-d H:i:s', mktime(date('d') + 3));
        $row = $this->getUserModel()->where(array('openid' => $openid))->save($data);
        if ($row) {
            return $data['token'];
        }
        return false;
    }

    /**
     * 判断用户是否已存在
     */
    private function checkUser($openid)
    {
        $user = $this->getUserModel()->find(array('openid' => $openid));
        return $user['openid'];
    }

}