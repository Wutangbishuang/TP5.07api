<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/29
 * Time: 0:28
 */

namespace app\api\model;

use think\Model;

class Banner extends Model
{
    public function items()
    {
        return $this->hasMany('BannerItem' , 'banner_id' , 'id');
    }

    public static function getBannerByID($id)
    {
        $banner = self::with(['items' , 'items.img'])
                ->find($id);
        return $banner;
    }
}