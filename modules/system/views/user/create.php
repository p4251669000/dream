<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Druser */

$this->title = 'Create Druser';
$this->params['breadcrumbs'][] = ['label' => 'Drusers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1>创建用户</h1>

<?= $this->render('_form', [
    'model' => $model,
    'roles' => $roles
]) ?>


