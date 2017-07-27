<?php

namespace Home\Controller;

class IndexController extends BaseController
{
    public function index()
    {
        echo <<<EOF
        <h1>Hello World</h1>
EOF;

    }
}