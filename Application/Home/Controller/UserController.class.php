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
    private $userModel;

    function __construct()
    {
        $this->userModel = M('user');
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
            $user = $this->userModel->find($id);
            session('User_Login_SESSION',$user);
            $this->response($user);
        } else {
            $this->response($this->PAGE_NO_EXIT);
        }
    }

    /**
     * 添加用户的方法
     */
    public function addUser()
    {
        $method = $this->_method;
        if ($method == 'post') {
            $data = I('post.');
            $data['id'] = time();
            $data['create_time'] = date('Y-m-d H:i:s');
            $id = $this->userModel->add($data);
            if ($id) {
                $this->response($this->SUCCESS);
            } else {
                $this->response($this->FAIL);
            }
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
            if($user == false){
                $this->response(FAIL);
            }
            $data = I('post.');
            $data['id']=$user['id'];
            $data['update_time']=date('Y-m-d H:i:s');
            $rows = $this->userModel->save($data);
            if ($rows) {
                $this->response($this->SUCCESS);
            }else{
                $this->response($this->FAIL);
            }
        } else {
            $this->response($this->PAGE_NO_EXIT);
        }
    }

}