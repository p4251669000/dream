<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Druser */

$this->title = '更新用户: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Drusers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="druser-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'roles' => $roles,
        'roleinfo' => $roleinfo,
        'oldrolename' =>$oldrolename
    ]) ?>

</div>
