<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\system\Drauthitem */

$this->title = '更新权限';
$this->params['breadcrumbs'][] = ['label' => 'Drauthitems', 'url' => ['index']];
$this->params['breadcrumbs'][] = "";
$itemname = "权限";
$button = "更新权限";
?>
<div class="drauthitem-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_permissionform', [
        'itemname' => $itemname,
        'button' => $button,
        'model' => $model
    ]) ?>

</div>
