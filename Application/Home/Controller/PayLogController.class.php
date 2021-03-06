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
            $user = $this->getUserByToken(I('post.token'));
            $data = I('post.');
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
            $user = $this->getUserByToken(I('get.token'));
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
            $returnData['paylogs'] = $paylogs;
            $returnData['totalCount'] = $paylogsCount;
            $returnData['pageIndex'] = $pageIndex;
            if (I('get.token')) {
                $this->response($returnData);
            } else {
                $this->response($returnData, 300);
            }
        } else {
            $this->response($this->getPAGENOEXIT(), 404, false);
        }
    }
}