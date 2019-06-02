<?php


namespace app\api\controller\v1;


use app\api\validate\Count;
use app\lib\exception\ProductException;

class Product
{
    public function getRecent($count=15)
    {
        (new Count())->goCheck();
        $products = (new \app\api\model\Product)->getMostRecent($count);
        if($products->isEmpty()){
            throw new ProductException();
        }
        $products =$products->hidden(['summary']);
        return $products;

    }

}