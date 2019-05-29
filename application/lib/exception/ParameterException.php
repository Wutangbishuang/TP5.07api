<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/29
 * Time: 22:22
 */

namespace app\lib\exception;


class ParameterException extends BaseException
{
    public $code = 400;
    public $msg = '参数错误';
    public $errorCode = 10000;
}