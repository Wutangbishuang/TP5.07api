<?php


namespace app\api\service;


use think\Exception;

class Pay
{
    private $orderID;
    private $orderNO;

    function __construct($orderID)
    {
        if(!$orderID){
            throw new Exception('订单编号不允许为空');
        }
        $this->orderNO = $orderID;
    }

    public function pay()
    {
        
    }


}