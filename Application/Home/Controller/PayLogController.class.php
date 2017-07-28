<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/7/25
 * Time: 15:46
 */

namespace Home\Controller;

use Home\Controller\BaseController;

class PayLogController extends BaseController
{
    /**
     * 添加支付记录
     */
    public function add()
    {
        $method = $this->_method;
        if ($method == 'post') {
            $user = session('USER_LOGIN_SESSION');
            $data = I('post.');
            $data['id'] = time() . rand(0, 9);
            $data['uid'] = $user['id'];
            $data['paytime'] = time();
            $id = $this->getPaylogModel()->add($data);
            if ($id) {
                $this->response($this->getSUCCESS());
            } else {
                $this->response($this->getFAIL(), 502);
            }
        }
        $this->response($this->getPAGENOEXIT(), 404);
    }

    /**
     * 根据用户返回消费记录
     */
    public function getPayLogByUser()
    {
        $method = $this->_method;
        if ($method == 'get') {
            $user = session('USER_LOGIN_SESSION');
            $where['uid'] = $user['id'];
            $pageIndex = I('get.p') ? I('get.p') : 1;
            $paylogsCount = $this->getPaylogModel()->where($where)->count();
            $paylogs = $this->getPaylogModel()->where($where)->page(($pageIndex - 1) . ',' . $this->getPageSize())->select();
            $lessons = $this->getLessonModel()->select();
            foreach ($paylogs as $key => $value) {
                foreach ($lessons as $k => $v) {
                    if ($v['id'] == $value['lessonid']) {
                        $paylogs[$key]['lesson'] = $lessons[$k];
                        break;
                    }
                }
            }
            $paylogs['totalCount'] = $paylogsCount;
            $paylogs['pageIndex'] = $pageIndex;
            $this->response($paylogs);
        } else {
            $this->response($this->getPAGENOEXIT(), 404);
        }
    }
}