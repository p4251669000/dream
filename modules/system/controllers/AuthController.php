<?php

namespace app\modules\system\controllers;

use Yii;
use app\models\system\Drauthitem;
use yii\rbac\Permission;
use yii\rbac\Role;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\commands\BaseController;
use app\common\dmpublic\DmCom;
use app\models\system\Drmenu;
use app\models\system\Drauthrolemenu;

/**
 * DrauthitemController implements the CRUD actions for Drauthitem model.
 */
class AuthController extends BaseController
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
     * 进入添加权限页面
     * @return string
     */
    public function actionCreatepermission()
    {
        $model = new Permission();
        return $this->render('createpermission', [
            'model' => $model
        ]);

    }

    /**
     * 进入修改权限界面
     * @param $id 主键
     */
    public function actionUpdatepermission($id)
    {
        $auth = Yii::$app->authManager;
        $model = $auth->getPermission($id);

        return $this->render('updatepermission', [
            'model' => $model
        ]);
    }

    /**
     * 更新一条权限信息
     * @return string 返回权限
     */
    public function actionUpdatepermissioninfo()
    {
        $resultArr = null;
        if (Yii::$app->request->isAjax) {
            $postArr = Yii::$app->request->post();
            $name = $postArr['name'];
            $oldname = $postArr['oldname'];
            $description = $postArr['description'];

            $auth = Yii::$app->authManager;
            $updatePermission = $auth->getPermission($oldname);
            $updatePermission->description = $description;
            $updatePermission->name = $name;
            //添加一个角色
            $auth->update($oldname, $updatePermission);
            $resultArr = DmCom::getResults('成功', '', 1);

        } else {
            $resultArr = DmCom::getResults('失败', '', 0);
        }
        return json_encode($resultArr);
    }

    /**
     * 添加一条权限
     * @return 成功或者失败信息
     */
    public function actionAddpermission()
    {
        $resultArr = null;
        if (Yii::$app->request->isAjax) {

            $postArr = Yii::$app->request->post();
            $auth = Yii::$app->authManager;
            $createPer = $auth->createPermission($postArr['name']);
            $createPer->description = $postArr['description'];
            $auth->add($createPer);
            $resultArr = DmCom::getResults('成功', '', 1);

        } else {
            $resultArr = DmCom::getResults('失败', '', 0);
        }
        return json_encode($resultArr);
    }

    /**
     * 添加一个角色
     * @return string 返回成功或者失败信息
     */
    public function actionAddrole()
    {
        $resultArr = null;

        if (Yii::$app->request->isAjax) {

            $postArr = Yii::$app->request->post();
            $choosecheckmenu = $postArr['choosecheckmenu'];
            $name = $postArr['name'];
            $description = $postArr['description'];
            $chooserolepermission = $postArr['chooserolepermission'];

            $auth = Yii::$app->authManager;
            $createRole = $auth->createRole($name);
            $createRole->description = $description;
            //添加一个角色
            $auth->add($createRole);

            //添加角色关联权限
            $permission = $chooserolepermission;
            $this->addRolePermission($permission, $createRole);

            //添加角色关联菜单信息
            $this->addRoleMenu($choosecheckmenu, $name);

            $resultArr = DmCom::getResults('成功', '', 1);

        } else {
            $resultArr = DmCom::getResults('失败', '', 0);
        }
        return json_encode($resultArr);

    }

    /**
     * 添加角色权限关联信息
     * @param $permission 拥有权限
     * @param $createRole 创建角色
     */
    public function addRolePermission($permission, $createRole)
    {
        $auth = Yii::$app->authManager;
        $arrpermission = preg_split('/,/', $permission);
        foreach ($arrpermission as $val) {
            $createpermission = $auth->createPermission($val);
            //添加一条关联信息
            $auth->addChild($createRole, $createpermission);
        }

    }

    /**
     * 添加角色拥有menu
     * @param $rolemenu 角色拥有menu 数组
     * @param $name 角色名
     */
    public function addRoleMenu($rolemenu, $name)
    {
        $arrrolemenu = preg_split('/,/', $rolemenu);

        foreach ($arrrolemenu as $val) {
            $drrolemenu = new Drauthrolemenu();
            $drrolemenu->id = time() . rand(1000, 9999);
            $drrolemenu->rolename = $name;
            $drrolemenu->menuid = $val;
            $drrolemenu->save();
        }
    }

    /**
     * 得到权限或者角色集合
     * @param $type 1 为角色  2为权限
     * @return string 权限或角色信息集合
     */
    public function actionAuthitemlist($type)
    {
        $list = Drauthitem::find()->where(['type' => $type])->all();

        return $this->render('authitemlist', [
            'list' => $list,
            'type' => $type
        ]);

    }

    /**
     * 进入更新角色界面
     * @param $id 角色主键
     * @return string 返回成功或者失败信息
     * @throws NotFoundHttpException
     */
    public function actionUpdaterole($id)
    {
        $auth = Yii::$app->authManager;
        $model = $this->findModel($id);
        //取出角色菜单
        $menus = Drauthrolemenu::find()->where(['rolename' => $id])->all();
        $choosemenu = "";
        $num = 0;
        foreach ($menus as $key => $val) {
            if ($num == 0) {
                $choosemenu = $val->menuid;
            } else {
                $choosemenu .= ',' . $val->menuid;
            }
            $num++;
        }

        //取出角色拥有的权限
        $choosepermissions = $auth->getChildren($id);
        $permissions = $auth->getPermissions();

        return $this->render('updaterole', [
            'model' => $model,
            'choosemenu' => $choosemenu,
            'choosepermissions' => $choosepermissions,
            'permissions' => $permissions
        ]);


    }

    /**
     * 更新一个角色
     * @return string 成功或者失败信息
     */
    public function actionUpdateroleinfo()
    {
        $resultArr = null;

        if (Yii::$app->request->isAjax) {

            $postArr = Yii::$app->request->post();
            $choosecheckmenu = $postArr['choosecheckmenu'];
            $name = $postArr['name'];
            $oldname = $postArr['oldname'];
            $description = $postArr['description'];
            $chooserolepermission = $postArr['chooserolepermission'];

            $auth = Yii::$app->authManager;
            $updateRole = $auth->getRole($oldname);
            //删除原有角色关联权限
            $auth->removeChildren($updateRole);
            $updateRole->name = $name;
            $updateRole->description = $description;
            //更新一个角色
            $auth->update($oldname, $updateRole);

            //添加角色关联权限
            $permission = $chooserolepermission;
            $this->addRolePermission($permission, $updateRole);

            //删除原有角色菜单关联信息
            Drauthrolemenu::deleteAll('rolename = :rolename', array(':rolename' => $oldname));
            //添加角色关联菜单信息
            $this->addRoleMenu($choosecheckmenu, $name);

            $resultArr = DmCom::getResults('成功', '', 1);

        } else {
            $resultArr = DmCom::getResults('失败', '', 0);
        }
        return json_encode($resultArr);


    }

    /**
     * 检测权限是否重复
     * @return bool
     */
    public function actionPermissionisrepeat()
    {
        if (Yii::$app->request->isAjax) {
            $auth = Yii::$app->authManager;
            $postArr = Yii::$app->request->post();
            $oldname = $postArr['oldname'];
            $authname = $postArr['authname'];

            if ($oldname != $authname) {
                $premission = $auth->getPermission($postArr['authname']);
            }
            if (isset($premission)) {
                return "false";
            } else {
                return "true";
            }
        }
        return "false";
    }

    /**
     * 检测角色是否重复
     * @return bool
     */
    public function actionRoleisrepeat()
    {
        if (Yii::$app->request->isAjax) {
            $auth = Yii::$app->authManager;
            $postArr = Yii::$app->request->post();
            $oldname = $postArr['oldname'];
            $authname = $postArr['authname'];

            if ($oldname != $authname) {
                $role = $auth->getRole($authname);
            }
            if (isset($role)) {
                return "false";
            } else {
                return "true";
            }
        }
        return "false";
    }


    /**
     * 进入创建角色界面
     * @return mixed
     */
    public function actionCreaterole()
    {
        $model = new Role();

        $auth = Yii::$app->authManager;

        $permissions = $auth->getPermissions();

        return $this->render('createrole', [
            'model' => $model,
            'choosemenu' => '',
            'choosepermissions' => null,
            'permissions' => $permissions,
        ]);

    }

    /**
     * 得到角色的菜单树
     * @return null|string 菜单信息json
     */
    public function actionGetroletree()
    {
        $tree = null;

        $postArr = Yii::$app->request->get();
        $parent = $postArr['parent'] == "#" ? 0 : $postArr['parent'];
        $choose = preg_split('/,/', $postArr['choose']);

        //是否有子元素
        $childMenuCount = Drmenu::find()->where(['parentid' => $parent])->count();

        if ($childMenuCount != 0) {
            $tree = $this->getChildMenu($parent, $choose);
        }
        return $tree;
    }

    /**
     * 得到子菜单
     * @param $parent 父Id
     * @param $choose 被选择的Id
     * @return string 子菜单json
     */
    public function getChildMenu($parent, $choose)
    {
        $data = array();

        $menus = $this->getChildMenuById($parent);

        foreach ($menus as $key => $val) {

            $isin = in_array($val->id, $choose);

            $childMenuCount = Drmenu::find()->where(['parentid' => $val->id])->count();

            $children = $childMenuCount == 0 ? false : true;

            $data[] = array(
                "id" => $val->id,
                "icon" => $val->ico,
                "text" => $val->name,
                "state" => array("opened" => true, "selected" => $isin),
                "children" => $children
            );
        }
        return json_encode($data);
    }


    /**
     * 查询相应父Id的子菜单
     * @param $id
     * @return string 返回子菜单
     */
    public function getChildMenuById($parendId)
    {
        $model = Drmenu::find()->where(['parentid' => $parendId])->all();

        return $model;
    }


    /**
     * 删除一条权限或者角色
     * @param $id
     * @param $type 1 为角色 2为权限
     * @return string
     */
    public function actionDelete($id, $type)
    {
        $resultArr = null;
        $auth = Yii::$app->authManager;
        if (Yii::$app->request->isAjax) {
            if ($type == 2) {
                $permission = $auth->getPermission($id);
                $auth->remove($permission);
                $resultArr = DmCom::getResults('成功', '', 1);
            } else {
                $role = $auth->getRole($id);
                //先删除角色关联权限信息
                $auth->removeChildren($role);
                //删除角色用户关联信息
                $auth->remove($role);
                //删除角色关联菜单信息
                Drauthrolemenu::deleteAll('rolename = :rolename', array(':rolename' => $id));
                $resultArr = DmCom::getResults('成功', '', 0);
            }
        } else {
            $resultArr = DmCom::getResults('失败', '', 0);
        }

        return json_encode($resultArr);
    }

    /**
     * Finds the Drauthitem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Drauthitem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Drauthitem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
