<?php

namespace app\api\controller\v1;

use app\api\validate\IDCollection;
use think\Controller;
use think\Request;

class Theme extends Controller
{
    /**
     * @url /theme?ids=id1 , id2 , id3 , ...
     * @return 一组 Theme 模型
     */

    public function getSimpleList($ids = '')
    {
        (new IDCollection())->goCheck();
        return 'success';
    }
}
