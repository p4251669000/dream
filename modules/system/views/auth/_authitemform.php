<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\system\Drauthitem */
/* @var $form yii\widgets\ActiveForm */
?>

<input type="hidden" name="oldname" id="oldname" value="<?= $model->name?>">

<div class="form-body">
    <div class="form-body">

        <div class="form-group">
            <label class="control-label col-md-3"><?= $itemname ?>名 <span
                    class="required">
                                    * </span>
            </label>

            <div class="col-md-4">
                <input type="text" name="name" id="authname" value="<?= $model->name?>" data-required="1"
                       class="form-control"/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3"><?= $itemname ?>描述 <span
                    class="required">
                                    * </span>
            </label>

            <div class="col-md-4">
                <input type="text" name="description" value="<?= $model->description?>" class="form-control"/>
            </div>
        </div>
    </div>
</div>
