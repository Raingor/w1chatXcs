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
        $user = $this->getUserByToken(I('request.token'));
        $where['uid'] = $user['id'];
        $pageIndex = I('get.p') ? I('get.p') : 1;
        $studyLogCount = $this->getStudylogModel()->where($where)->count();
        $studyLog = $this->getStudylogModel()->where($where)->page(($pageIndex - 1) . ',' . $this->getPageSize())->order('create_time desc')->select();
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
    }

    /**
     * 添加课程记录
     */
    public function add()
    {
        $user = $this->getUserByToken(I('request.token'));
        if (!$user) {
            $this->response($this->getNOLOGIN(), 300, false);
        }
        $in_studylog = I('request.');
        $in_studylog['uid'] = $user['id'];
        $studyLog = $this->getStudylogModel()->where(array('uid' => $user['id'], 'lessonid' => $in_studylog['lessonid']))->find();
        if ($studyLog) {
            $studyLog['create_time'] = date('Y-m-d H:i:s');
            $out_studylog = $this->getStudylogModel()->save($studyLog);
        } else {
            $in_studylog['create_time'] = date('Y-m-d H:i:s');
            $out_studylog = $this->getStudylogModel()->add($in_studylog);
        }
        if ($out_studylog) {
            $this->response($this->getSUCCESS());
        } else {
            $this->response($this->getFAIL(), 502, false);
        }
    }

}