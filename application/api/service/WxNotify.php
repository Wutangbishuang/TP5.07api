<?php


namespace app\api\service;

use app\api\model\Product;
use app\lib\enum\OrderStatusEnum;
use think\Loader;
use app\api\model\Order as OrderModel;
use app\api\service\Order as OrderService;
use think\Log;

Loader::import('WxPay.Wxpay' , EXTEND_PATH , '.Api.php');

class WxNotify extends \WxPayNotify
{
    public function NotifyProcess($data , &$msg)
    {
        if($data['result_code'] == 'SUCCESS'){
            $orderNo = $data['out_trade_no'];
            try
            {
                $order = OrderModel::where('order_no' , '=' , $orderNo)
                    ->find();

                if($order->status == 1){
                    $service = new OrderService();
                    $stockStatus = $service->checkOrderStock($order->id);

                    if($stockStatus['pass']){
                        $this->updateOrderStatus($order->id , true);
                        $this->reduceStock($stockStatus);
                    } else {
                        $this->updateOrderStatus($order->id,false);
                    }
                }
                return true;
            }
            catch (Exception $ex)
            {
                Log::error($ex);
                return false;
            }
        } else {
            return true; // 返回true 是知晓错误 ， 让微信停止发送信息
                         // 返回false 微信将持续发送消息 15/15...秒
        }
    }

    private function reduceStock($stockStatus)
    {
        foreach($stockStatus['pStatusArray'] as $singlePStatus){
//            $singlePStatus['count'];
            Product::where('id' , '=' , $singlePStatus['id'])
                ->setDec('stock' , $singlePStatus['count']);
        }
    }

    private function updateOrderStatus($orderID , $success)
    {
        $status = $success?
            OrderStatusEnum::PAID:
            OrderStatusEnum::PAID_BUT_OUT_OF;
        OrderModel::where('id' , '=' , $orderID)
            ->update(['status' => $status]);
    }
}