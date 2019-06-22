<?php


namespace app\api\service;

use think\Loader;

Loader::import('WxPay.Wxpay' , EXTEND_PATH , '.Api.php');
class WxNotify extends \WxPayNotify
{
    public function NotifyProcess($data , &$msg)
    {
        
    }
}