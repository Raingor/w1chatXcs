<?php

namespace Home\Controller;


use Think\Upload\Driver\Qiniu;

class IndexController extends BaseController
{
    public function index()
    {
        if (IS_POST) {
            $config = C('UPLOAD_SITEIMG_QINIU');
            $upload = new Qiniu($config['driverConfig']);
            $info = $upload->save($_FILES);
            dump($info);
            dump($upload->getError());
        }
        $this->display();
    }
}