<?php
/**
 * 所有控制器都继承BaseController
 * User: 谢锐
 * Date: 2015/6/10
 * Time: 0:16
 */

namespace app\commands;

use Yii;
use yii\web;
use yii\web\Controller;
use yii\web\Session;



class BaseController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * 在执行action之前 ，先查询是否有权限执行
     * @param \yii\base\Action $action
     * @return bool
     */
    public function beforeAction($action)
    {
        $session = new Session();
        $session->open();
        $userinfo = $session->get("userinfo");
        $programmerkey = Yii::$app->params["programmer"];
        //检测是否登录
        if (isset($userinfo)) {
            //如果不为程序员管理员 则检测权限
            if ($programmerkey != $userinfo['id']) {
                $action = $this->action->id;
                $controller = $this->action->controller->id;
                $module = $this->action->controller->module->id;
                $permission = $module . '-' . $controller . '-' . $action;

                //检测是否有权限执行
                $auth = Yii::$app->authManager;
                $bool = $auth->checkAccess($userinfo['id'], $permission);
                //如果有权限则返回true
                if ($bool) {
                    return true;
                } else {
                    throw new UnauthorizedHttpException('对不起，您现在还没获此操作的权限');
                }
            } else {
                return true;
            }
        } else {
            header('Location: public/login');
            exit;
        }
        return true;

    }


}