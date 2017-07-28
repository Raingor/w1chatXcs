<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/25
 * Time: 1:14
 */

namespace Home\Controller;

use Think\Controller\RestController;

class BaseController extends RestController
{
    private $PAGE_NO_EXIT;
    private $OBJECT_NOT_FOUNT;
    private $SUCCESS;
    private $FAIL;
    private $userModel;
    private $lessonModel;
    private $lessonTypeModel;
    private $studylogModel;
    private $paylogModel;
    private $videosModel;
    private $discussModel;
    private $wx_getOpenUrl;
    private $wx_paymentUrl;
    private $wx_token;
    private $pageSize;
    private $appid;
    private $appsecret;
    private $mchid;
    private $mch_key;

    /**
     * @return mixed
     */
    public function getPageSize()
    {
        return $this->pageSize = 10;
    }

    /**
     * @return mixed
     */
    public function getWxToken()
    {
        return $this->wx_token = md5(time() . rand(0, 999) . 'qiyeclass');
    }


    /**
     * @return array
     */
    public function getPAGENOEXIT()
    {
        return $this->PAGE_NO_EXIT = array('msg' => '找不到页面啦');
    }

    /**
     * @return array
     */
    public function getOBJECTNOTFOUNT()
    {
        return $this->OBJECT_NOT_FOUNT = array('msg' => '找不到对象');
    }

    /**
     * @return array
     */
    public function getSUCCESS()
    {
        return $this->SUCCESS = array('msg' => '操作成功');
    }

    /**
     * @return array
     */
    public function getFAIL()
    {
        return $this->FAIL = array('msg' => '操作失败');
    }

    /**
     * @return mixed
     */
    public function getUserModel()
    {
        return $this->userModel = M('user');
    }

    /**
     * @return mixed
     */
    public function getLessonModel()
    {
        return $this->lessonModel = M('lesson');
    }

    /**
     * @return mixed
     */
    public function getLessonTypeModel()
    {
        return $this->lessonTypeModel = M('lessonType');
    }

    /**
     * @return mixed
     */
    public function getStudylogModel()
    {
        return $this->studylogModel = M('studylog');
    }

    /**
     * @return mixed
     */
    public function getPaylogModel()
    {
        return $this->paylogModel = M('paylog');
    }

    /**
     * @return mixed
     */
    public function getVideosModel()
    {
        return $this->videosModel = M('videos');
    }

    /**
     * @return mixed
     */
    public function getDiscussModel()
    {
        return $this->discussModel = M('discuss');
    }

    /**
     * @return mixed
     */
    public function getWxGetOpenUrl()
    {
        return $this->wx_getOpenUrl = 'https://api.weixin.qq.com/sns/jscode2session?appid=APPID&secret=SECRET&js_code=JSCODE&grant_type=authorization_code';
    }

    /**
     * @return mixed
     */
    public function getWxPaymentUrl()
    {
        return $this->wx_paymentUrl = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
    }


    /**
     * @return mixed
     */
    public function getAppid()
    {
        return $this->appid = 'wx6fc5f4836fc51f82';
    }

    /**
     * @return mixed
     */
    public function getAppsecret()
    {
        return $this->appsecret = 'aab9cf6c1f3de3f225d787afb097e40d';
    }

    /**
     * @return mixed
     */
    public function getMchid()
    {
        return $this->mchid = '1480255692';
    }

    /**
     * @return mixed
     */
    public function getMchKey()
    {
        return $this->mch_secret = 'zengdazengbiaozengmenglixiaoxiao';
    }


    protected function response($data, $code = 200, $success = true)
    {
        if (is_array($data)) {
            $data['code'] = $code;
            $data['success'] = $success;
        } else {
            return false;
        }
        $type = 'json';
        parent::response($data, $type, 200); // TODO: Change the autogenerated stub
    }

    /**
     * 检验token
     * @param $token
     * @return bool
     */
    protected function checkToken($token)
    {
        $user = $this->getUserModel()->where(array('token_expiresIn' => $token))->find();
        $expiresIn = $user['token_expiresIn'];
        $now = time();

        if ($expiresIn > $now) {
            $this->refreshToken($token);
            return true;
        }
        return false;
    }

    /**
     * 刷新token
     * @param $token
     */
    private
    function refreshToken($token)
    {
        $row = $this->getUserModel()->where(array('token' => $token))->save(array('token_expiresIn' => date('Y-m-d H:i:s', mktime(date('d') + 3))));
        if ($row) {
            return $token;
        } else {
            return false;
        }
    }

}