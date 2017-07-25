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
            $replace = array($appid, $appsecret, $code);
            $url = str_replace($search, $replace, $this->getWxGetOpenUrl());
            $wxObject = sendGet($url);
            $data['id'] = time();
            $data['openid'] = $wxObject;
            $data['token'] = $this->getWxToken();
            $data['token_expiresIn'] = date('Y-m-d H:i:s', mktime(date('H') + 2));
            $data['create_time'] = date('Y-m-d H:i:s');
            $id = $this->getUserModel()->add($data);
            if ($id) {
                $this->response($this->SUCCESS);
            } else {
                $this->response($this->FAIL);
            }
        } else {
            $this->response($this->getFAIL());
        }
    }

    /**
     * 登录
     * 根据id 返回用户
     * @param $id
     */
    public function getById($id)
    {
        $method = $this->_method;
        if ($method == 'get') {
            $user = $this->getUserModel()->find($id);
            session('User_Login_SESSION', $user);
            $this->response($user);
        } else {
            $this->response($this->PAGE_NO_EXIT);
        }
    }


    /**
     * 修改用户的方法
     */
    public function updateUser()
    {
        $method = $this->_method;
        if ($method == 'post') {
            $user = session('USER_LOGIN_SESSION');
            if ($user == false) {
                $this->response(FAIL);
            }
            $data = I('post.');
            $data['id'] = $user['id'];
            $data['update_time'] = date('Y-m-d H:i:s');
            $rows = $this->getUserModel()->save($data);
            if ($rows) {
                $this->response($this->SUCCESS);
            } else {
                $this->response($this->FAIL);
            }
        } else {
            $this->response($this->PAGE_NO_EXIT);
        }
    }

}