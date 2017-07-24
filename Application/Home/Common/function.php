<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/7/24
 * Time: 17:36
 */
define('PAGE_NO_EXIT',array('errorCode'=>404,'errorMsg'=>'页面不存在'));

/**
 * Get请求
 * @param $url
 */
function sendGet($url){
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
//    curl_setopt($ch,CURLOPT_HEADER,1);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    $result = curl_exec($ch);
    $result=json_decode($result,true);
    return $result;
}

/**
 * POST请求
 * @param $url
 * @param $params
 * @return mixed
 */
function sendPost($url,$params){
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_POST,1);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$params);
    $result  = curl_exec($ch);
    return $result;
}