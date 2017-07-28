<?php

namespace Home\Controller;


class IndexController extends BaseController
{
    public function index()
    {
        $data['id'] = time() . rand(0, 9);
        $data['name'] = '雷军讲堂音频';
        $data['url'] = 'http://pic.qiyeclass.com/%E9%9B%B7%E5%86%9B%E8%AE%B2%E5%BA%A7.mp3';
        $data['description'] = '雷军的课程';
        $data['cover'] = 'http://oqg59brw6.bkt.clouddn.com/%E9%9B%B7%E5%86%9B%E8%AE%B2%E5%BA%A7%E5%B0%81%E9%9D%A2.jpg';
        $data['picture'] = 'http://pic.qiyeclass.com/%E9%9B%B7%E5%86%9B.jpg';
        $data['lessonid'] = 2147483647;
        $data['create_time'] = date('Y-m-d H:i:s');
        $id = M('videos')->add($data);
        if ($id) {
            $this->response($this->getSUCCESS());
        } else {
            $this->response($this->getFAIL(), 502, false);
        }
    }
}