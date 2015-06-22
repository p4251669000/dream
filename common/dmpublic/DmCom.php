<?php
/**
 * Created by PhpStorm.
 * User: 谢锐
 * Date: 2015/4/23
 * Time: 15:47
 */
namespace app\common\dmpublic;



class DmCom
{

    /**
     * @return string 当前时间
     */
    public static function getNowTime()
    {
        $time = date('Y-m-d H:i:s', time());
        return $time;
    }

    /**
     * 时间格式化短Id，适用于并发极低Id插入
     * @return Id 最后生成的主键Id
     */
    public static function getSmallId()
    {

        $id = date("YmdHis", time());

        return $id;

    }

    /**
     * 此函数用于返回ajax的json
     * @param $msg 成功或者失败的提示信息
     * @param $data 返回需要接收的数据
     * @param $result 0 失败，1成功
     * @return string json 序列化
     */
    public static function getResults($msg, $data, $result)
    {
        $arr = array('msg' => $msg, 'data' => $data, 'result' => $result);

        return json_encode($arr);
    }

    /**
     * 为了让自己的表单配合yii2的form验证，格式化成YII2表单验证
     * @param $data 传递过来的数据
     * @param $formName 添加一个实际的formName
     * @return mixed
     */
    public static function changePostArray($data,$formName){

        $array = array($formName => $data);

        return $array;
    }




}