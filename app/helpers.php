<?php
/**
 * Created by PhpStorm.
 * User: high
 * Date: 2017/7/15
 * Time: 7:14
 */

/**
 * get item photo image path
 * @return string
 */
function getProductImagePath() {
    return public_path('uploads/product/');
}

/**
 * 获取当前日期
 * @return string
 */
function getCurDateString() {
    $dateCurrent = new DateTime("now");
    $strDate = getStringFromDate($dateCurrent);

    return $strDate;
}

/**
 * DateTime转string
 * @param $date DateTime
 * @return mixed
 */
function getStringFromDate($date) {
    return $date->format('Y-m-d');
}

/**
 * DateTime转string
 * @param $date DateTime
 * @return mixed
 */
function getStringFromDateTime($date) {
    return $date->format('Y-m-d H:i:s');
}

/**
 * @param $value
 * @return string
 */
function getEmptyString($value) {
    return !empty($value) ? $value : '';
}

/**
 * int转string
 * @param $value
 * @param $length
 * @return string
 */
function intToString($value, $length) {
    $nMax = 10 * $length;
    $nValue = $value % $nMax;

    return str_pad($nValue, $length, "0", STR_PAD_LEFT);
}