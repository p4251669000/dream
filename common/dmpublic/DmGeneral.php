<?php
/**
 * User: 谢锐
 * Date: 2015/6/19
 * Time: 16:47
 */

namespace app\common\dmpublic;

use app\models\system\Drmenu;


class DmGeneral
{

    /**
     * 得到相应父ID的树html
     * @param $parentid 父Id
     */
    public function getMenuTreeHtml($parentid, $roleName)
    {
        $menus = $this->getChildMenuById($parentid, $roleName);

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

                $treeMenuHtml .= $this->getMenuTreeHtml($menu->id, $roleName) . '</ul>';

            }

            $treeMenuHtml = $treeMenuHtml . "</li>";
        }

        return $treeMenuHtml;

    }

    /**
     * 查询相应父Id的子菜单
     * @param $parendId 父Id
     * @param $roleName 菜单所属角色名
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getChildMenuById($parendId, $roleName)
    {
        $sql = 'select * from drmenu where parentid =' . $parendId . ' and id in (select menuid from drauthrolemenu where
rolename="' . $roleName . '")';

        $model = Drmenu::findBySql($sql)->all();

        return $model;
    }


}