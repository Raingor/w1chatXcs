<?php

namespace Home\Controller;

use Home\Controller\BaseController;

class IndexController extends BaseController
{

    private $userModel;

    function __construct()
    {
        $this->userModel = M('user');
    }

    public function index()
    {
        $this->response($this->PAGE_NO_EXIT);
    }
}