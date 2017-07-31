<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/7/25
 * Time: 14:39
 */

namespace Home\Controller;

use Home\Controller\BaseController;
use Think\Page;

class LessonController extends BaseController
{
    /**
     * 查询所有推荐课程
     */
    public function getAll()
    {
        $method = $this->_method;
        if ($method == 'get') {
            $pageIndex = I('get.p') ? I('get.p') : 1;
            $where['recommend'] = 1;
            $lessonCount = $this->getLessonModel()->where($where)->count();
            $lessons = $this->getLessonModel()->where($where)->page(($pageIndex - 1) . ',' . $this->getPageSize())->select();
            $lessonTypes = $this->getLessonTypeModel()->select();
            foreach ($lessons as $key => $value) {
                foreach ($lessonTypes as $k => $v) {
                    if ($v['id'] == $value['typeid']) {
                        $lessons[$key]['type'] = $lessonTypes[$k];
                        break;
                    }
                }
            }
            $resData['lessons'] = $lessons;
            $resData['totalCount'] = $lessonCount;
            $resData['pageIndex'] = $pageIndex;
            $this->response($resData);
        }
        $this->response($this->getPAGENOEXIT(), 404, false);
    }

    /**
     * 查询所有课程类型
     */
    public function getAllType()
    {
        $method = $this->_method;
        if ($method == 'get') {
            $lessonType = $this->getLessonTypeModel()->select();
            $returnData['lessonType'] = $lessonType;
            $this->response($returnData);
        }
        $this->response($this->getPAGENOEXIT(), 404, false);
    }

    /**
     * 根据课程类型 返回 课程列表
     */
    public function getByType($typeid)
    {
        $method = $this->_method;
        if ($method == 'get') {
            $where['typeid'] = $typeid;
            $pageIndex = I('get.p') ? I('get.p') : 1;
            $lessonCount = $this->getLessonModel()->where($where)->count();
            $lessons = $this->getLessonModel()->where($where)->page(($pageIndex - 1) . ',' . $this->getPageSize())->select();
            $returnData['lessons'] = $lessons;
            $returnData['totalCount'] = $lessonCount;
            $returnData['pageIndex'] = $pageIndex;
            $returnData['typeid'] = $typeid;
            $this->response($returnData);
        }
        $this->response($this->getPAGENOEXIT(), 404, false);
    }

    /**
     * 根据指定的课程返回课程下的  视频音频
     */
    public function getLessonById()
    {
        $method = $this->_method;
        if ($method == 'get') {
            $lessonid = I('get.lessonid');
            $where['lessonid'] = $lessonid;
            $lesson = $this->getLessonModel()->find($lessonid);
            //判断课程是否免费
            if ($lesson['price'] != 0) {
                $token = I('get.token');
                $user = $this->getUserByToken($token);
                $payLog = $this->getPaylogModel()->where(array('uid' => $user['id'], 'lessonid' => $lessonid))->find();
                //如果没有购买的历史就进行支付
                if (!$payLog) {
                    $util = new UtilController();
                    $util->wxPay($token, $lessonid);
                }
            }
            $videos = $this->getVideosModel()->where($where)->select();
            $return['lesson'] = $lesson;
            $return['videos'] = $videos;
            if (I('get.token')) {
                $this->response($return);
            } else {
                $this->response($return, 300);
            }
        }
        $this->response($this->getPAGENOEXIT(), 404, false);

    }

    /**
     * 添加课程的方法
     */
    public function add()
    {
        $method = $this->_method;
        if ($method == 'post') {
            $data = I('post.');
            $data['id'] = time() + rand(0, 999);
            $data['create_time'] = time();
            $id = $this->getLessonModel()->add($data);
            if ($id) {
                $this->response($this->getSUCCESS());
            } else {
                $this->response($this->getFAIL(), 502, false);
            }
        }
        $this->response($this->getPAGENOEXIT(), 404, false);
    }

    /**
     * 根据视频id获取视频
     */
    public function getVideoById($videoid)
    {
        $method = $this->_method;
        if ($method == 'get') {
            $video = $this->getVideosModel()->find($videoid);
            $returnData['video'] = $video;
            if (I('get.token')) {
                $this->response($returnData);
            } else {
                $this->response($returnData, 300);
            }
        }
        $this->response($this->getPAGENOEXIT(), 404, false);
    }

    /**
     * 添加课程类型方法
     */
    public function addType()
    {
        $method = $this->_method;
        if ($method == 'post') {
            $data = I('post.');
            $data['id'] = time() + rand(0, 999);
            $data['create_time'] = time();
            $id = $this->getLessonTypeModel()->add($data);
            if ($id) {
                $this->response($this->getSUCCESS());
            } else {
                $this->response($this->getFAIL(), 502, false);
            }
        }
        $this->response($this->getPAGENOEXIT(), 404, false);
    }


    /**
     * 搜索课程
     */
    public function searchByKey()
    {
        $method = $this->_method;
        if ($method == 'get') {
            $key = I('get.key');
            $pageIndex = I('get.p') ? I('get.p') : 1;
            $where['title'] = array('like', "%$key%");
            $where['author'] = array('like', "%$key%");
            $lessonsCount = $this->getLessonModel()->where($where)->count();
            $lessons = $this->getLessonModel()->where($where)->page($pageIndex . ',' . $this->getPageSize())->select();
            $return['totalCount'] = $lessonsCount;
            $return['lessons'] = $lessons;
            $return['pageIndex'] = $pageIndex;
            $this->response($return);
        }

    }
}