<?php


namespace app\api\service;


use app\api\model\Product;
use app\lib\exception\OrderException;

class Order
{
    // 订单的商品列表 ， 也就是客户端传递过来的products参数
    protected $oProducts;

    // 真是的商品信息(库存量)
    protected $products;

    protected $uid;

    public function place($uid , $oProducts)
    {
        // oProducts 和 products 做对比
        // products从数据库中查询出来
        $this->oProducts = $oProducts;
        $this->products = $this->getProductsByOrder($oProducts);
        $this->uid = $uid;
    }

    private function getOrderStatus()
    {
        $status = [
            'pass' => true,
            'orderPrice' => 0, // 订单总价格
            'pStatusArray' => [] //保存订单所有商品详细信息
        ];

        foreach($this->oProducts as $oProduct){

            $pStatus = $this->getProductStatus(
                $oProduct['product_id'] , $oProduct['count'] , $this->products
            );

            if(!$pStatus['haveStock']) {
                $status['pass'] = false;
            }

            $status['orderPrice'] +=$pStatus['totalPrice'];
            array_push($status['pStatusArray'], $pStatus);
        }
        return $status;
    }

    private function getProductStatus($oPID , $oCount , $products)
    {
        $pIndex = -1;

        $pStatus = [
            'id' => null,
            'haveStock' => false,
            'count' => 0,
            'name' => '',
            'totalPrice' => 0 // 单价 * 数量的价格
        ];

        for( $i = 0;$i<count($products);$i++){
            if($oPID == $products[$i]['id']){
                $pIndex = $i;
            }
        }

        if($pIndex = -1){
            // 客户端传递的 product_id 有可能根本不存在
            throw new OrderException([
                'msg' => 'id为'.$oPID.'的商品不存在 ， 创建订单失败'
            ]);
        } else {
            $product = $products[$pIndex];
            $pStatus['id'] = $product['id'];
            $pStatus['count'] = $oCount;
            $pStatus['totalPrice'] = $product['price'] * $oCount;

            if($product['stock'] - $oCount >= 0){
                $pStatus['haveStock'] = true;
            }
        }
        return $pStatus;
    }

    // 根据订单信息查找真是的商品信息
    private function getProductsByOrder($oProducts)
    {
        $oPIDs = [];
        foreach ($oProducts as $item) {
            array_push($oPIDs , $item['ptoduct_id']);
        }
        $products = Product::all($oPIDs)
                    ->visible(['id' , 'price' , 'stock' , 'name' , 'main_img_url'])
                    ->toArray();
        return $products;
    }
}