<?php

namespace Home\Controller;


use Think\Upload\Driver\Qiniu;

class IndexController extends BaseController
{
    public function index()
    {
        if (IS_POST) {
            $file = $_FILES['file'];
            $config = C('UPLOAD_SITEIMG_QINIU');
            $upload = new Qiniu($config['driverConfig']);
            $result = $upload->save($file);
            $data = I('post.');
            if ($result) {
                $data['picture'] = $file['url'];
            }
            $data['create_time'] = date('Y-m-d H:i:s');
            $id = $this->getLessonTypeModel()->add($data);
            if ($id) {
                $this->response($data);
            } else {
                $this->response($this->getOBJECTNOTFOUNT(), 500, false);
            }
        } else {
            dump(date('h'));
            $this->display();
        }
    }
}