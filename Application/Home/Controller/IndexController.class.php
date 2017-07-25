<?php

namespace Home\Controller;

use Home\Controller\BaseController;

class IndexController extends BaseController
{
    public function index()
    {
        $this->response($this->getSUCCESS(), true);
    }
}