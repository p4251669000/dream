<?php
/**
 * User: 谢锐
 * Date: 2015/6/19
 * Time: 15:42
 */
namespace app\common\dmpublic;

use yii\web;
use  yii\web\Session;


class DmCaptcha
{
    public static function CaptchaGoogle($num)
    {
        $session = new Session();
        $session->open();

        $general = new DmGeneral();
        $checkcode = $general->make_rand($num);
        $session['verifyCode'] = strtolower($checkcode);

        $general->getAuthImage($checkcode);
    }


}
