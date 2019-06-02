<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/28
 * Time: 17:38
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;
use think\Request;
use think\Validate;

class BaseValidate extends Validate
{
    public function goCheck()
    {
        // 获取http传入的参数
        // 对参数进行校验
        $request = Request::instance();
        $params = $request->param();

        $result = $this->batch()->check($params);
        if (!$this->check($params)) {
            $exception = new ParameterException(
                [
                    // $this->error有一个问题，并不是一定返回数组，需要判断
                    'msg' => is_array($this->error) ? implode(
                        ';', $this->error) : $this->error,
                ]);
            throw $exception;
        }
        return true;
    }

    protected function isPositiveInteger
    ($value , $rule='', $data='' , $field='')
    {
        if(is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        } else {
            return false;
//            return $field. '必须是正整数';
        }
    }

    protected function isNotEmpty
    ($value , $rule='', $data='' , $field='')
    {
        if(empty($value)) {
            return false;
        } else {
            return true;
//            return $field. '必须是正整数';
        }
    }
}