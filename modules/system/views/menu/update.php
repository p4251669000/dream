<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Drmenu */

$this->title = '更新菜单: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Drmenus', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="drmenu-update">

    <h1><?= Html::encode($this->title) ?> </h1>

    <?= $this->render('_form', [
        'model' => $model,
        'listData' => $listData
    ]) ?>


</div>
