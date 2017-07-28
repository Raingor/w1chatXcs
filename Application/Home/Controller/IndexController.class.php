<?php

namespace Home\Controller;

use Home\Controller\UtilController;

class IndexController extends BaseController
{
    public function index()
    {
        $this->response($data['test'] = 'test', 'json', 200);
    }
}