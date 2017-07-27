<?php

namespace Home\Controller;

class IndexController extends BaseController
{
    public function index()
    {
        $this->response($this->getSUCCESS());

    }
}