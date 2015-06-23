<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace app\controllers;

use Yii;
use yii\web;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\Session;

use app\common\dmpublic\DmCom;
use yii\web\UploadedFile;
use app\models\LoginForm;



class PublicController extends Controller
{
    public $layout = false;

    /**
     * 进入登录界面
     * @return string
     */
    public function actionLogin()
    {
        return $this->render('login', []);
    }

    /**
     * 后台登录
     * @return null|string 返回登录成功或者失败信息
     */
    public function actionLogininfo()
    {

        $model = new LoginForm();

        $arrReuslt = null;
        $postArr = Yii::$app->request->post();
        $verifyCode = $postArr['verifyCode'];
        $session = new Session();
        $session->open();
        $verifySession = $session->get('captch');

        //验证码是否正确
        if ($verifyCode == $verifySession) {
            $load = $model->load(DmCom::changePostArray($postArr, 'LoginForm'));
            $login = $model->login();

            //登录验证成功后
            if (Yii::$app->request->isAjax && $load && $login) {
                //$userid = $session->get('_id');
                //验证验证码
                $arrReuslt = DmCom::getResults("登录成功", "", 1);
            } else {
                $arrReuslt = DmCom::getResults("账号或者密码错误", "", 0);
            }
        } else {
            $arrReuslt = DmCom::getResults("验证码错误", "", 0);
        }
        return json_encode($arrReuslt);
    }

    /**
     * 注销
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        $session = new Session();
        $session->open();
        $session->removeAll();

        return $this->goHome();
    }

    /**
     * 公用上传单图片
     * @return Json 返回公共信息
     */
    public function actionUploadimageinfo()
    {
        try {
            $image = UploadedFile::getInstanceByName("Filedata");
            $ext = $image->getExtension();
            $imageName = time() . rand(100, 999) . '.' . $ext;
            $imageUrl = 'upload/images/' . $imageName;
            $image->saveAs($imageUrl);

            $arr = DmCom::getResults("成功", $imageUrl, 1);

            return $arr;

        } catch (Exception $ex) {

            $arr = DmCom::getResults("失败", $ex, 0);

            return $arr;
        }

    }

}
