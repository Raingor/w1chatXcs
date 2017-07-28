<?php
/**
 * Get请求
 * @param $url
 */
function sendGet($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
//    curl_setopt($ch,CURLOPT_HEADER,1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

/**
 * POST请求
 * @param $url
 * @param $params
 * @return mixed
 */
function sendPost($url, $params)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}