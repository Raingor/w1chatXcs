<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/7/24
 * Time: 17:26
 */

namespace Home\Controller;
use Think\Controller\RestController;

class UserController extends RestController
{
    public function add() {
        $method = $this->_method;
        $user = M('user');
        if($method == 'post'){
            $data = I("post.");
            $id = $user->add($data);
            if($id){
                $this->response(SUCCESS,'json');
            }else{
                $this->response(FAIL,'json');
            }
        }else{
            $this->response(PAGE_NO_EXIT,'json');
        }
    }
}