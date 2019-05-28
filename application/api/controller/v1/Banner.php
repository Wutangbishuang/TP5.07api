<?php
namespace app\api\controller\v1;


use app\api\validate\IDMustBePostiveInt;

class Banner
{
    /**
     * 获取指定id的banner信息
     * @url /banner/:id
     * @http GET
     * @id banner的id号
     */
    public function getBanner($id)
    {
        $data = [
            'id' => $id
        ];
        $validate = new IDMustBePostiveInt();
        $result = $validate->batch()->check($data);
        if($result) {

        } else {

        }
    }
}