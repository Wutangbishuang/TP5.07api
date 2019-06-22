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

        // 1. 检测库存量 ， 超卖
        // 2. 更新这个订单的 status 状态
        // 3. 减库存
        // 如果成功处理 ， 我们返回微信成功处理的消息 。 否则，我们需要返回没有成功处理。

        // 特点：post xml 格式  不会携带参数
    }
}