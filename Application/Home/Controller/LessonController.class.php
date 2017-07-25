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
     * 查询所有课程
     */
    public function getAll()
    {
        $method = $this->_method;
        if ($method == 'get') {
            $pageIndex = I('get.p') ? I('get.p') : 1;
            $lessonCount = $this->getLessonModel()->count();
            $lessons = $this->getLessonModel()->page(($pageIndex - 1) . ',' . $this->getPageSize())->select();
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
    public function getByType($typeId)
    {
        $method = $this->_method;
        if ($method == 'get') {
            $where['typeid'] = $typeId;
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
    public function getVideosById($lesson_id)
    {
        $method = $this->_method;
        if ($method == 'get') {
            $where['lessonid'] = $lesson_id;
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
            $data['id'] = time();
            $id = $this->getLessonModel()->add($data);
            if ($id) {
                $this->response($this->getSUCCESS());
            } else {
                $this->response($this->getFAIL(), false);
            }
        }
        $this->response($this->getPAGENOEXIT(), false);
    }


}