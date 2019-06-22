<?php


namespace app\api\controller\v1;


use app\api\validate\IDMustBePostiveInt;
use app\api\service\Pay as PayService;

class Pay extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'getPreOrder']
    ];

    /*
     * 预订单
     * $id 为 order表中的id
     */

    public function getPreOrder($id = '')
    {
        (new IDMustBePostiveInt())->goCheck();
        $pay = new PayService($id);
        return $pay->pay();
    }

    public function receiveNotify()
    {
        // 通知频率为 15/15/30/180/1800/1800/1800/1800/3600 单位： 秒
    }
}