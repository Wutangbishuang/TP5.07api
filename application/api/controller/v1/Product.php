<?php


namespace app\api\controller\v1;


use app\api\validate\Count;
use app\api\validate\IDMustBePostiveInt;
use app\lib\exception\ProductException;
use app\api\model\Product as ProductModel;

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

    public function getAllInCategory($id)
    {
        (new IDMustBePostiveInt())->goCheck();
        $products = ProductModel::getProductsByCategoryID($id);
        if($products->isEmpty()){
            throw new ProductException();
        }
        $products = $products->hidden(['summary']);
        return $products;
    }

}