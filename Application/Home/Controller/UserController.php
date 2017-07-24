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
        if($method == 'post'){
            
        }else{
            $this->response(PAGE_NO_EXIT,'json');
        }
    }
}