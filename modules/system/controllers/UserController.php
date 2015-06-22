<?php

namespace app\modules\system\controllers;

use Yii;
use app\models\system\Druser;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use yii\data\LinkPager;
use yii\web\Session;

use app\common\dmpublic\DmCom;

/**
 * DruserController implements the CRUD actions for Druser model.
 */
class UserController extends Controller
{
    public $layout = false;

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
     * Lists all Druser models.
     * @return mixed
     */
    public function actionIndex()
    {
        $data = Druser::find();
        $count = $data->count();
        $programmerkey = Yii::$app->params["programmer"];
        $session = new Session();
        $session->open();
        $userinfo = $session->get("userinfo");
        $pages = null;
        $pages = new Pagination(['totalCount' => $count, 'pageSize' => '10']);

        //如果为程序员管理员则加载到列表里面
        if ($programmerkey == $userinfo['id']) {
            $model = $data->offset($pages->offset)->limit($pages->limit)->orderBy("id desc")->all();
        } else {
            $model = $data->offset($pages->offset)->where("id <> " . $programmerkey)->orderBy("id desc")->limit($pages->limit)->all();
        }

        return $this->render('index', [
            'model' => $model,
            'pages' => $pages,
        ]);
    }

    /**
     * 进入创建用户界面
     * @return mixed 用户信息 角色信息
     */
    public function actionCreate()
    {
        $model = new Druser();

        //给一个默认图像
        $model->img = 'assets/admin/layout/img/avatar3_small.jpg';
        $auth = Yii::$app->authManager;

        //得到所有角色
        $roles = $auth->getRoles();

        return $this->render('create', [
            'model' => $model,
            'roles' => $roles
        ]);

    }

    /**
     * 添加一个用户
     * @return 成功或者失败信息 1 成功 0失败
     */
    public function actionAdduser()
    {
        $model = new Druser();

        $postarr = Yii::$app->request->post();
        $rolename = $postarr['role'];

        $post = $model->load(DmCom::changePostArray($postarr, 'Druser'));

        $resultArr = null;

        if (Yii::$app->request->isAjax && $post && $model->validate()) {

            $model->generateAuthKey();
            $model->setPassword($model->password_hash);
            $model->id = DmCom::getSmallId();
            $model->save();

            //添加角色用户关联
            $auth = Yii::$app->authManager;
            $role = $auth->getRole($rolename);
            $auth->assign($role, $model->id);

            $resultArr = DmCom::getResults('成功', '', 1);

        } else {
            $resultArr = DmCom::getResults('失败', '', 0);
        }

        return json_encode($resultArr);


    }


    /**
     * 查看用户名是否重复
     * @return string true 不重复 false 重复
     */
    public function actionUsernameisrepeat()
    {
        if (Yii::$app->request->isAjax) {
            $postArr = Yii::$app->request->post();
            $oldname = $postArr['oldname'];
            $name = $postArr['name'];
            if ($oldname != $name) {
                $userCount = Druser::find()->where(['name' => $name])->count();

                if ($userCount > 0) {
                    return "false";
                } else {
                    return "true";
                }
            }
            return "true";
        }
        return "false";
    }


    /**
     * 进入更新用户界面
     * @param string $id 用户Id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $auth = Yii::$app->authManager;

        //得到所有角色
        $roles = $auth->getRoles();

        $roleinfo = $auth->getAssignments($id);

        $oldrolename = "";

        foreach ($roleinfo as $key => $val) {
            $oldrolename = $val->roleName;
        }


        return $this->render('update', [
            'model' => $model,
            'roles' => $roles,
            'roleinfo' => $roleinfo,
            'oldrolename' => $oldrolename
        ]);

    }

    /**
     * 更新一条用户信息
     * @return string 成功或者失败信息
     * @throws NotFoundHttpException
     */
    public function actionUpdateuser()
    {

        $postarr = Yii::$app->request->post();

        $id = $postarr['id'];

        $model = $this->findModel($id);

        $post = $model->load(DmCom::changePostArray($postarr, 'Druser'));

        $resultArr = null;

        if (Yii::$app->request->isAjax && $post && $model->validate()) {

            $rolename = $postarr['role'];
            $oldrolename = $postarr['oldrolename'];

            $auth = Yii::$app->authManager;
            $oldrole = $auth->getRole($oldrolename);
            //删除原角色用户关联
            if (isset($oldrole)) {
                $auth->revoke($oldrole, $model->id);
            }
            $model->setPassword($model->password_hash);
            $model->save();

            //添加角色用户关联
            $role = $auth->getRole($rolename);
            $auth->assign($role, $model->id);

            $resultArr = DmCom::getResults('成功', '', 1);

        } else {
            $resultArr = DmCom::getResults('失败', '', 0);
        }

        return json_encode($resultArr);

    }

    /**
     * 删除一条用户信息
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function actionDelete($id)
    {
        $resultArr = null;
        if (Yii::$app->request->isAjax) {
            $programmerkey = Yii::$app->params["programmer"];
            if ($id == $programmerkey) {
                $resultArr = DmCom::getResults('不能删除，此为程序管理员', '', 0);
            } else {
                $this->findModel($id)->delete();
                $resultArr = DmCom::getResults('成功', '', 1);
            }

        } else {
            $resultArr = DmCom::getResults('失败', '', 0);
        }

        return json_encode($resultArr);
    }

    /**
     * Finds the Druser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Druser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Druser::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
