<?php


namespace app\api\controller\v1;


use app\api\service\Token as TokenService;
use app\api\validate\OrderPlace;
use app\api\service\Order as OrderService;
use app\lib\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;
use app\lib\exception\TokenException;
use think\Controller;

class Order extends BaseController
{
    // 用户再选择商品后 ， 向 API 提交包含它所选择商品的相关信息
    // API再接收到信息后 ， 需要检查订单相关商品的库存量
    // 有库存 ， 把订单数据存入数据库中 = 下单成功了 ， 返回客户端消息 ， 告诉客户端可以支付了
    // 电泳我的支付接口 ， 进行支付
    // 还需要再次进行库存量检测
    // 服务器这边就可以调用微信的支付接口进行支付
    // 微信会返回给我们一个支付的结果（异步）
    // 成功：也需要进行库存量的检测
    // 成功：进行库存量的扣除 ， 失败：返回一个支付失败的结果

    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' =>'placeOrder']
    ];

    public function placeOrder()
    {
        (new OrderPlace())->goCheck();
        $products = input('post.products/a');
        $uid = TokenService::getCurrentUid();

        $order = new OrderService();
        $status = $order->place($uid , $products);
        return $status;
    }


}