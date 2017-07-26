<?php

namespace Home\Controller;

use Think\Upload;

class IndexController extends BaseController
{
    public function index()
    {
        if (IS_POST) {
            $setting = C('UPLOAD_SITEIMG_QINIU');
            $qiniu = new Upload\Driver\Qiniu($setting['driverConfig']);
            $info = $qiniu->save($_FILES['file']);
            $error = $qiniu->getError();
            dump($info);
            dump($error);
        }
        $this->display();


    }
}