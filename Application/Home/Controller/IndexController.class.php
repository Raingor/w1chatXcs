<?php

namespace Home\Controller;


use Think\Upload\Driver\Qiniu;

class IndexController extends BaseController
{
    public function index()
    {
        if (IS_POST) {
            $files = $_FILES;
            $config = C('UPLOAD_SITEIMG_QINIU');
            $upload = new Qiniu($config['driverConfig']);
            foreach ($files as $key => $value) {
                if ($value) {
                    $result = $upload->save($files[$key]);
                    if ($result) {
                        $data[$key] = $files[$key]['url'];
                    } else {
                        $this->response($this->getOBJECTNOTFOUNT(), 500, false);
                    }
                }
            }
            $data = I('post.');
            $data['create_time'] = date('Y-m-d H:i:s');
            $id = $this->getLessonModel()->add($data);
            if ($id) {
                $this->response($data);
            } else {
                $this->response($this->getOBJECTNOTFOUNT(), 500, false);
            }
            
        } else {
            $lessonType = $this->getLessonTypeModel()->select();
            $this->assign('lessontype', $lessonType);
            $this->display();
        }
    }
}