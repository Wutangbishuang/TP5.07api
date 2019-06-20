<?php


namespace app\api\controller\v1;


use app\api\validate\IDMustBePostiveInt;

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
    }
}