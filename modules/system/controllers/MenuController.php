<?php

namespace app\modules\system\controllers;

use Yii;
use app\models\system\Drmenu;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\commands\BaseController;
use app\common\dmpublic\DmCom;

/**
 * MenuController implements the CRUD actions for Drmenu model.
 */
class MenuController extends BaseController
{

    public $layout = false;

    /**
     * @var array记录菜单
     */
    public $arrmenu = array();


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
     * 进入菜单列表页面
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index', []);
    }


    /**
     * 进入创建菜单页面加载
     * @return mixed 菜单数据
     */
    public function actionCreate()
    {

        $model = new Drmenu();

        $listData = $this->getListData(0);

        return $this->render('create', [
            'model' => $model,
            'listData' => $listData
        ]);
    }

    /**
     * 进入更新页面
     * @param string $id 菜单主键Id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $listData = $this->getListData(0);

        return $this->render('update', [
            'model' => $model,
            'listData' => $listData
        ]);

    }


    /**
     * 得到所有菜单经过整理后的集合
     * @param $parentid 父Id
     * @return mixed 返回所有菜单完整的菜单名集合
     */
    public function getListData($parentid)
    {
        $menus = $this->getChildMenuById($parentid);

        global $arrmenu;

        foreach ($menus as $menu) {

            $wholeName = $this->getMenuWholeName($menu->parentid, $menu->name);

            $arrmenu[$menu->id] = $wholeName;

            //检查该菜单是否有子菜单
            $menuCount = Drmenu::find()->where(['parentid' => $menu->id])->count();

            //递归添加子菜单到数组中
            if ($menuCount > 0) {
                $this->getListData($menu->id);
            }
        }
        return $arrmenu;
    }

    /**
     * 得到页面左边的html菜单View ,因为菜单不常改变，因此以text文件保存起来
     */
    public function actionGettreemenu()
    {
        $html = $this->getMenuTreeHtml(0);

        $file_path = "common/cache/treemenuhtml.text";

        if (!file_exists($file_path)) {
            exit();
        }

        $fp = fopen($file_path, "w+");
        fwrite($fp, $html);
        fclose($fp);

        return $html;

    }

    /**
     * 得到相应父ID的树html
     * @param $parentid 父Id
     */
    public function getMenuTreeHtml($parentid)
    {
        $menus = $this->getChildMenuById($parentid);

        $treeMenuHtml = "";

        foreach ($menus as $menu) {

            $treeMenuHtml .= "<li>";

            //查看该菜单是否有子菜单
            $childMenuCount = Drmenu::find()->where(['parentid' => $menu->id])->count();

            if ($childMenuCount == 0) {

                if ($menu->parentid == 0) {

                    $treeMenuHtml .= '<a class="ajaxify" href="' . $menu->url . '"><i class="' . $menu->ico . '"></i> <span class="title">' . $menu->name . '</span><span class="selected"></span></a>';

                } else {
                    $treeMenuHtml .= '<a class="ajaxify" href="' . $menu->url . '"><i class="' . $menu->ico . '"></i>' . $menu->name . ' </a>';
                }

            } else {
                $treeMenuHtml .= '<a href="javascript:;"><i class="' . $menu->ico . '"></i>' . $menu->name . '<span class="selected"></span><span class="arrow"></span></a><ul class="sub-menu">';

                $treeMenuHtml .= $this->getMenuTreeHtml($menu->id) . '</ul>';

            }

            $treeMenuHtml = $treeMenuHtml . "</li>";
        }

        return $treeMenuHtml;

    }



    /**
     * 递归得到该菜单名完整的树名
     * @param $parentid 菜单父ID
     * @param $name 菜单名
     * @return string 完整树名
     */
    function getMenuWholeName($parentid, $name)
    {
        if ($parentid != 0) {

            $menu = Drmenu::findOne($parentid);

            $name = $menu->name . " => " . $name;

            return $this->getMenuWholeName($menu->parentid, $name);

        } else {
            return $name;
        }

    }


    /**
     * 更新相关Id菜单信息
     * @param $id 主键Id
     * @return json 成功或失败信息
     * @throws NotFoundHttpException
     */
    public function actionUpdatemenu()
    {
        $model = new Drmenu();

        $postArr = Yii::$app->request->post();

        $post = $model->load(DmCom::changePostArray($postArr, 'Drmenu'));

        $resultArr = null;

        if (Yii::$app->request->isAjax && $post && $model->validate()) {

            $model = $this->findModel($postArr['id']);
            $model->parentid = $postArr['parentid'];
            $model->url = $postArr['url'];
            $model->name = $postArr['name'];
            $model->ico = $postArr['ico'];
            $model->save();

            //更新成功后将菜单缓存到文件中
            $this->actionGettreemenu();

            $resultArr = DmCom::getResults('成功', '', 1);

        } else {
            $resultArr = DmCom::getResults('失败', '', 0);
        }

        return json_encode($resultArr);

    }

    /**
     * 删除一条菜单
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
        $postArr = Yii::$app->request->post();

        $result = $this->findModel($postArr['id'])->delete();

        $resultArr = null;
        if ($result) {
            //删除成功后将菜单缓存到文件中
            $this->actionGettreemenu();

            $resultArr = DmCom::getResults('成功', '', 1);
        } else {
            $resultArr = DmCom::getResults('失败', '', 1);
        }
        return json_encode($resultArr);
    }

    /**
     * 添加一条后台菜单
     * @return string 返回结果的json数据
     */
    public function actionAddmenu()
    {

        $model = new Drmenu();

        $post = $model->load(DmCom::changePostArray(Yii::$app->request->post(), 'Drmenu'));

        $arr = null;

        if (Yii::$app->request->isAjax && $post && $model->validate()) {

            $model->createtime = DmCom::getNowTime();
            $model->id = DmCom::getSmallId();
            $model->save();

            //添加成功后将菜单缓存到文件中
            $this->actionGettreemenu();

            $arr = DmCom::getResults('成功', '', 1);

        } else {
            $arr = DmCom::getResults('失败', '', 0);
        }

        return json_encode($arr);
    }

    /**
     *得到相应的子菜单,并返回相关json 数据给view
     * @param $parendId 父Id
     * @return string 所有子菜单的json数据
     */
    public function actionGetchildmenu($id)
    {
        $records = array();
        $records['nodes'] = array();

        $id = isset($id) ? $id : '0';
        $level = 1;
        if ($id != '0') {
            $id = explode(':', $id);
            $level = $id[1] + 1;
        }

        $menu = $this->getChildMenuById($id[0]);

        if (count($menu) != 0) {
            $arr = ArrayHelper::toArray($menu);

            foreach ($arr as $val) {
                $id_ = $val['id'] . ":" . $level;
                $records['nodes'][] = array('id' => $id_, 'parent' => $val['parentid'], 'name' => $val['name'], 'level' => $level, 'type' => 'folder');

            }
        }

        return json_encode($records);
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
     * Finds the Drmenu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Drmenu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Drmenu::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}
