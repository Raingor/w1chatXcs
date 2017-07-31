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
            $info = $upload->save($_FILES['file']);
            if ($info) {
                dump($_FILES['file']['name'] . '上传成功');
            } else {
                dump($upload->getError());

            }
        }
        $this->display();
    }
}