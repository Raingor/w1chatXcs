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
        if ($method == 'post') {
            if (session('USER_LOGIN_SESSION')) {
                $user = session('USER_LOGIN_SESSION');
                $where['uid'] = $user['id'];
                $studyLog = $this->getStudylogModel()->where($where)->order('id desc')->select();
                $lessons = $this->getLessonModel()->select();
                foreach ($studyLog as $key => $value) {
                    foreach ($lessons as $k => $v) {
                        if ($v['id'] == $value['lessonid']) {
                            $studyLog['lesson'] = $lessons[$k];
                            break;
                        }
                    }
                }
                $returnData = array('user' => $user, 'studyLog' => $studyLog);
                $this->response($returnData);
            } else {
                $this->response($this->OBJECT_NOT_FOUNT);
            }
        } else {
            $this->response($this->PAGE_NO_EXIT);
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
            $in_studylog['id'] = time();
            $in_studylog['uid'] = $user['id'];
            $in_studylog['create_time'] = date('Y-m-d H:i:s');
            $out_studylog = $this->getStudylogModel()->add($in_studylog);
            if ($out_studylog) {
                $this->response($this->getSUCCESS());
            } else {
                $this->response($this->getFAIL());
            }
        } else {
            $this->response($this->PAGE_NO_EXIT);
        }
    }

}