<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\DruserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户列表';
$this->params['breadcrumbs'][] = "";
?>

<h1>&nbsp;</h1>

<div class="row">
    <div class="col-md-12">

        <div class="portlet box grey-cascade">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i>用户列表
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse">
                    </a>

                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="actions">
                                <a href="system/user/create" class="ajaxify btn default yellow-stripe">
                                    <i class="fa fa-plus"></i>
								<span class="hidden-480">
								添加新用户 </span>
                                </a>
                            </div>
                        </div>



                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                    <thead>
                    <tr>
                        <th>
                            用户名
                        </th>
                        <th>
                            邮箱
                        </th>
                        <th>
                            状态
                        </th>
                        <th>
                            角色
                        </th>
                        <th>
                            创建时间
                        </th>
                        <th>
                            操作
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($model as $key => $val): ?>
                        <tr id="tr_<?= $val->id?>" class="">

                            <td>
                                <?= $val->name ?>
                            </td>
                            <td>
                                <?= $val->email ?>
                            </td>
                            <td>
                                <?= $val->status == 10 ? "启用" : "禁用" ?>
                            </td>
                            <td class="center">
                                <?= $val->email ?>
                            </td>
                            <td>
                                <?= date('Y-m-d H:i:s', $val->created_at) ?>
                            </td>
                            <td>
                                <a href="system/user/update?id=<?= $val->id?>" class="btn default btn-xs purple
                                ajaxify">
                                    <i class="fa fa-edit"></i> 修改 </a>

                                <a href="javscript:void(0)" onclick="deleteMethod('tr_<?= $val->id?>','<?= $val->id?>','system/user/delete')" class="btn default btn-xs black">
                                    <i class="fa fa-trash-o"></i> 删除 </a>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<?= LinkPager::widget(['pagination' => $pages]); ?>

