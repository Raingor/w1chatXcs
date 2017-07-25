<?php

namespace Home\Controller;

use Home\Controller\BaseController;

class IndexController extends BaseController
{


    public function index()
    {

        dump(date('Y-m-d H:i:s',(mktime(date('H')+2))));
    }
}