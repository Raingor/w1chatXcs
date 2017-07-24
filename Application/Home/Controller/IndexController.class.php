<?php
namespace Home\Controller;

use Think\Controller\RestController;

class IndexController extends RestController
{
    public function index()
    {
        $data ="{'id':'1','name':'admin'}";
        $type = gettype(json_decode($data,true));
        $this->response($type,'json');
    }
}