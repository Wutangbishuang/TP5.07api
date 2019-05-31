<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/29
 * Time: 0:28
 */

namespace app\api\model;


use think\Db;
use think\Model;

class Banner extends Model
{
    public function items()
    {
        return $this->hasMany('BannerItem' , 'banner_id' , 'id');
    }

    public static function getBannerByID($id)
    {
        $result = Db::table('banner_item')
            ->where('banner_id' , '=' , $id)
            ->select();
        return $result;
    }
}