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
            dump($this->getNonceStr(32));
            $lessonType = $this->getLessonTypeModel()->select();
            $this->assign('lessontype', $lessonType);
            $this->display();
        }
    }

    /*
   * 产生随机字符串，不长于32位
   * @param int $length
   * @return 产生的随机字符串
   */
    private function getNonceStr($length = 32)
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }
}