<?php

namespace Home\Controller;


use Think\Upload\Driver\Qiniu;

class IndexController extends BaseController
{
    public function index()
    {
        $this->display();
    }
}