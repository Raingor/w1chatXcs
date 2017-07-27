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
            $lessons['totalCount'] = $lessonCount;
            $lessons['pageIndex'] = $pageIndex;
            $this->response($lessons);
        }
        $this->response($this->getPAGENOEXIT(), false);
    }

    /**
     * 查询所有课程类型
     */
    public function getAllType()
    {
        $method = $this->_method;
        if ($method == 'get') {
            $lessonType = $this->getLessonTypeModel()->select();
            $this->response($lessonType);
        }
        $this->response($this->getPAGENOEXIT(), false);
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
            $lessons['totalCount'] = $lessonCount;
            $lessons['pageIndex'] = $pageIndex;
            $this->response($lessons);
        }
        $this->response($this->getPAGENOEXIT(), false);
    }

    /**
     * 根据指定的课程返回课程下的  视频音频
     */
    public function getLessonById($lessonid)
    {
        $method = $this->_method;
        if ($method == 'get') {
            $where['lessonid'] = $lessonid;
            $videos = $this->getVideosModel()->where($where)->select();
            $this->response($videos);
        }
        $this->response($this->getPAGENOEXIT(), false);

    }

    /**
     * 添加课程的方法
     */
    public function add()
    {
        $method = $this->_method;
        if ($method == 'post') {
            $data = I('post.');
            $data['id'] = time() . rand(0, 9);
            $id = $this->getLessonModel()->add($data);
            if ($id) {
                $this->response($this->getSUCCESS());
            } else {
                $this->response($this->getFAIL(), false);
            }
        }
        $this->response($this->getPAGENOEXIT(), false);
    }

    /**
     * 根据视频id获取视频
     */
    public function getVideoById($videoid)
    {
        $method = $this->_method;
        if ($method == 'get') {
            $video = $this->getVideosModel()->find($videoid);
            $this->response($video);
        }
        $this->response($this->getPAGENOEXIT(), false);
    }

    /**
     * 添加课程类型方法
     */
    public function addType()
    {
        $method = $this->_method;
        if ($method == 'post') {
            $data = I('post.');
            $data['id'] = time() . rand(0, 9);
            $data['create_time'] = time();
            $id = $this->getLessonTypeModel()->add($data);
            if ($id) {
                $this->response($this->getSUCCESS());
            } else {
                $this->response($this->getFAIL(), false);
            }
        }
        $this->response($this->getPAGENOEXIT(), false);
    }
}