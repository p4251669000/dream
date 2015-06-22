<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Menusearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Drmenus';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="drmenu-index">
    <h1>菜单管理</h1>

    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-purple-plum">
                        <i class="icon-speech font-purple-plum"></i>
                        菜单管理
                    </div>
                    <div class="actions">

                        <a href="system/menu/create" class="btn btn-circle red-sunglo btn-sm ajaxify">
                            <i class="fa fa-plus"></i> 添加</a>
                        <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="#" data-original-title=""
                           title="">
                        </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-hover table-light gtreetable" id="gtreetable">
                        <thead>
                        </thead>
                    </table>
                </div>
            </div>
            <!-- END PORTLET-->
        </div>
    </div>


</div>


<link rel="stylesheet" type="text/css" href="assets/global/plugins/bootstrap-gtreetable/bootstrap-gtreetable.min.css"/>
<script type="text/javascript">
    /* Init Metronic's core jquery plugins and layout scripts */
    $(document).ready(function () {
        TreeMenu.init();
    });
</script>

