<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/7/27
 * Time: 17:31
 */

namespace Home\Controller;

use Home\Controller;
use Think\Exception;

class UtilController extends BaseController
{
    /**
     * 小程序统一下单
     */
    public function wxPay()
    {
        $token = I('post.token');
        $lessonid = I('post.lessonid');
        $user = $this->getUserByToken($token);
        $payParam['appid'] = $this->getAppid();
        $payParam['mch_id'] = $this->getMchid();
        $payParam['nonce_str'] = $this->getNonceStr(32);
        $payParam['body'] = "企业公开课";
        $payParam['sign'] = $this->buildSign($payParam);
        $payParam['out_trade_no'] = $lessonid . 'and' . $user['id'];
        $payParam['total_fee'] = 1;//分作单位
        $payParam['spbill_create_ip'] = $_SERVER['REMOTE_ADDR'];
        $payParam['notify_url'] = 'http://demo.qiyeclass.com' . U('notifyPay');
        $payParam['trade_type'] = 'JSAPI';
        $payParam['openid'] = $user['openid'];
        $xml = $this->ToXml($payParam);
        $result = $this->postXmlCurl($xml, $this->getWxPaymentUrl());
        $result = $this->FromXml($result);
        $result['sign'] = $payParam['sign'];
        $this->response($result);
//        if ($result['return_code'] == 'SUCCESS') {
//            $data['parameters'] = $this->GetJsApiParameters($result);
//            $this->response($data);
//        } else {
//            $this->response($this->getOBJECTNOTFOUNT(), 500, false);
//        }
    }

    /**
     * @param int $length
     * @return string
     */
    public function notifyPay()
    {
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];//$GLOBALS['HTTP_RAW_POST_DATA'];接受POST数据 也接收MIME数据
        $xmlarr = $this->FromXml($xml);
        if ($xmlarr['result_code'] == 'SUCCESS') {
            if ($xmlarr['out_trade_no']) {
                $array = explode('and', $xmlarr['out_trade_no']);
                $data['id'] = time() . rand(0, 9);
                $data['uid'] = $array[1];
                $data['paytime'] = time();
                $data['lessonid'] = $array[0];
                $lesson = M('lesson')->find($data['lessonid']);
                $data['paymoney'] = $lesson['price'];
                $id = M('paylog')->add($data);
                if ($id) {
                    $rt['return_code'] = "SUCCESS";
                    $rt['return_msg'] = "OK";
                    $rtxml = $this->ToXml($rt);
                    echo $rtxml;
                }
            }
        }
    }


    /*
    * 产生随机字符串，不长于32位
    * @param int $length
    * @return 产生的随机字符串
    */
    private function getNonceStr($length = 32)
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    /**
     * 生成签名的方法
     */
    private function buildSign($param)
    {
        $str = 'appid=' . $param['appid'];
        $str .= '&body=' . $param['body'];
        $str .= '&mch_id=' . $param['mch_id'];
        $str .= '&nonce_str=' . $param['nonce_str'];
        $str .= '&key=' . $this->getMchKey();
        $sign = md5($str);
        $sign = strtoupper($sign);
        return $sign;
    }

    /**
     * 输出xml字符
     * @throws WxPayException
     **/
    public function ToXml($data)
    {
        if (!is_array($data)
            || count($data) <= 0
        ) {
            exit("数组数据异常！");
        }

        $xml = "<xml>";
        foreach ($data as $key => $val) {
            if (is_numeric($val)) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
            }
        }
        $xml .= "</xml>";
        return $xml;
    }

    /**
     * 将xml转为array
     * @param string $xml
     * @throws WxPayException
     */
    public function FromXml($xml)
    {
        if (!$xml) {
            throw new Exception("xml数据异常！");
        }
        //将XML转为array
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $this->values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $this->values;
    }

    /**
     * 以post方式提交xml到对应的接口url
     *
     * @param string $xml 需要post的xml数据
     * @param string $url url
     * @param bool $useCert 是否需要证书，默认不需要
     * @param int $second url执行超时时间，默认30s
     * @throws WxPayException
     */
    private function postXmlCurl($xml, $url, $second = 30)
    {
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);//严格校验
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        //运行curl
        $data = curl_exec($ch);
        //返回结果
        if ($data) {
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
        }
    }

    /**
     *
     * 获取jsapi支付的参数
     * @param array $UnifiedOrderResult 统一支付接口返回的数据
     * @throws WxPayException
     *
     * @return json数据，可直接填入js函数作为参数
     */
    public function GetJsApiParameters($UnifiedOrderResult)
    {
        if (!array_key_exists("appid", $UnifiedOrderResult)
            || !array_key_exists("prepay_id", $UnifiedOrderResult)
            || $UnifiedOrderResult['prepay_id'] == ""
        ) {
            exit("参数错误");
        }
        $jsapi['appId'] = $UnifiedOrderResult["appid"];
        $jsapi['timeStamp'] = time() . '';
        $jsapi['nonceStr'] = $this->getNonceStr(32);
        $jsapi['package'] = "prepay_id=" . $UnifiedOrderResult['prepay_id'];
        $jsapi['signType'] = "MD5";
        $jsapi['paySign'] = $this->makePaySign($jsapi);
        $parameters = json_encode($jsapi);
        return $parameters;
    }

    /**
     * 生成支付签名
     * @param $param
     * @return string
     */
    private function makePaySign($param)
    {
        $str = 'appId=' . $param['appId'];
        $str .= '&nonceStr=' . $param['nonceStr'];
        $str .= '&package=' . $param['package'];
        $str .= '&signType=' . $param['signType'];
        $str .= '&timeStamp=' . $param['timeStamp'];
        $str .= '&key=' . $this->getMchKey();
        $paySign = md5($str);
        return $paySign;
    }
}