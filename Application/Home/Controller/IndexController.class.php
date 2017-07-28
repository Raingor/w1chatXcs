<?php

namespace Home\Controller;

use Think\Controller;

class IndexController extends BaseController
{
    public function index()
    {
        $data['id'] = time();
        $data['openid'] = 123456;
        $data['token'] = $this->getWxToken();
        $data['token_expiresIn'] = date('Y-m-d H:i:s', mktime(date('H'), date('i'), date('s'), date('m'), date('d') + 3));
        $data['create_time'] = date('Y-m-d H:i:s');
        $id = $this->getUserModel()->add($data);
        $this->response(array('data' => $data, 'sql' => $id));
    }
}