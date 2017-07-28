<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/25
 * Time: 0:50
 */

namespace Home\Controller;

use Home\Controller\BaseController;

class StudyLogController extends BaseController
{

    /**
     * 根据UID查询学习记录
     */
    public function getByUid()
    {
        $method = $this->_method;
        if ($method == 'get') {
            if (session('USER_LOGIN_SESSION')) {
                $user = session('USER_LOGIN_SESSION');
                $where['uid'] = $user['id'];
                $pageIndex = I('get.p') ? I('get.p') : 1;
                $studyLogCount = $this->getStudylogModel()->where($where)->count();
                $studyLog = $this->getStudylogModel()->where($where)->page(($pageIndex - 1) . ',' . $this->getPageSize())->order('id desc')->select();
                $lessons = $this->getLessonModel()->select();
                foreach ($studyLog as $key => $value) {
                    foreach ($lessons as $k => $v) {
                        if ($v['id'] == $value['lessonid']) {
                            $studyLog[$key]['lesson'] = $lessons[$k];
                            break;
                        }
                    }
                }
                $studyLog['pageIndex'] = $pageIndex;
                $studyLog['totalCount'] = $studyLogCount;
                $this->response($studyLog);
            } else {
                $this->response($this->getOBJECTNOTFOUNT(), 500);
            }
        } else {
            $this->response($this->getPAGENOEXIT(), 404);
        }
    }

    /**
     * 添加课程记录
     */
    public function add()
    {
        $method = $this->_method;
        if ($method == 'post') {
            $user = session('USER_LOGIN_SESSION');
            $in_studylog = I('post.');
            $in_studylog['id'] = time() . rand(0, 9);
            $in_studylog['uid'] = $user['id'];
            $in_studylog['create_time'] = date('Y-m-d H:i:s');
            $out_studylog = $this->getStudylogModel()->add($in_studylog);
            if ($out_studylog) {
                $this->response($this->getSUCCESS());
            } else {
                $this->response($this->getFAIL(),502);
            }
        } else {
            $this->response($this->getPAGENOEXIT(), 404);
        }
    }

}