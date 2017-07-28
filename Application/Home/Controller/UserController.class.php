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
        $method = $this->_method;
        if ($method == 'post') {

            $code = I('post.code');
            $search = array("APPID", 'SECRET', 'JSCODE');
            $replace = array($this->getAppid(), $this->getAppsecret(), $code);
            $url = str_replace($search, $replace, $this->getWxGetOpenUrl());
            $wxObject = sendGet($url);
            //判断用户是否存在
            if ($this->checkUser($wxObject['openid'])) {
                $token = $this->updateTokenByOpenid($wxObject['openid']);
            } else {
                $token = $this->add($wxObject['openid']);
            }
            if ($token) {
                $this->response($token);
            } else {
                $this->response($this->getFAIL(), 502);
            }
        } else {
            $this->response($this->getFAIL(), 404);
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