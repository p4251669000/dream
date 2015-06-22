<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\Drmenu */

$this->title = 'Create Drmenu';
$this->params['breadcrumbs'][] = ['label' => 'Drmenus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


?>
<h3 class="page-title">添加菜单  </h3>
<?php
/**
 * User: 谢锐
 * Date: 2015/5/10
 * Time: 15:32
 */
?>
<?= $this->render('_form', [
    'model' => $model,
    'listData' => $listData
]) ?>


