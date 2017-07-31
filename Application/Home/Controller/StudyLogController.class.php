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
            $user = $this->getUserByToken(I('get.token'));
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
            $returnData['studyLog'] = $studyLog;
            $returnData['pageIndex'] = $pageIndex;
            $returnData['totalCount'] = $studyLogCount;
            if (I('get.token')) {
                $this->response($returnData);
            } else {
                $this->response($returnData, 300);
            }
            $this->response($studyLog);
        } else {
            $this->response($this->getPAGENOEXIT(), 404, false);
        }
    }

    /**
     * 添加课程记录
     */
    public function add()
    {
        $method = $this->_method;
        $post = $GLOBALS['HTTP_RAW_POST_DATA'];
        $this->response($post);
//        if ($post) {
//            $user = $this->getUserByToken($post['token']);
//            $in_studylog = $post;
//            $in_studylog['uid'] = $user['id'];
//            $in_studylog['create_time'] = date('Y-m-d H:i:s');
//            $out_studylog = $this->getStudylogModel()->add($in_studylog);
//            if ($out_studylog) {
//                $this->response($this->getSUCCESS());
//            } else {
//                $this->response($this->getFAIL(), 502, false);
//            }
//        } else {
//            $this->response($this->getPAGENOEXIT(), 404, false);
//        }
    }

}