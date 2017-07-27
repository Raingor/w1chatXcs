<?php

namespace Home\Controller;

class IndexController extends BaseController
{
    public function index()
    {
        $data['ip'] = get_client_ip();
        $this->response($data);

    }
}