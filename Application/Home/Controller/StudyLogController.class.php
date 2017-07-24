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

    private $studyLog;

    /**
     * StudyLogController constructor.
     */
    public function __construct()
    {
        $this->studyLog = M('studylog');

    }

    /**
     * 根据UID查询学习记录
     */
    public function getByUid()
    {
        $method = $this->_method;
        if ($method = 'get') {
        } else {
            $this->response($this->PAGE_NO_EXIT);
        }


    }

}