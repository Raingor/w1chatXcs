<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/7/27
 * Time: 17:31
 */

namespace Home\Controller;

use Home\Controller;

class UtilController extends BaseController
{
    /**
     * 小程序统一下单
     */
    public function wxPay()
    {
        $payParam['appid'] = $this->getAppid();
        $payParam['mch_id'] = $this->getMchid();
        $payParam['nonce_str'] = $this->getNonceStr(32);
        $payParam['sign'];
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
        $str = 'appid=APPID&mch_id=MCH_ID';
        $str = str_replace(array('APPID', 'MCH_ID'), array($param['appid'], $param['mch_id']), $str);
        $str = $str . '&key=' . $this->getMchKey();
        $sign = md5($str);
        $sign = strtoupper($sign);
    }

    /**
     * 输出xml字符
     * @throws WxPayException
     **/
    public function ToXml()
    {
        $xml = "<xml>";
        foreach ($this->values as $key => $val) {
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
        //将XML转为array
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $data;
    }


}