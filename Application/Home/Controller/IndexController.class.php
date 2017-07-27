<?php

namespace Home\Controller;

use Home\Controller\UtilController;

class IndexController extends BaseController
{
    public function index()
    {
        $util = new  UtilController();
        $result = $util->wxPay();
        dump($result);

    }
}