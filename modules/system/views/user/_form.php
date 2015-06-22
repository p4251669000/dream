<?php

use yii\rbac\Role;

/* @var $this yii\web\View */
/* @var $model app\models\Druser */
/* @var $form yii\widgets\ActiveForm */

$buttonName = $model->isNewRecord ? "创建用户" : "更新用户";

?>

<div class="row">
    <div class="col-md-12">
        <!-- BEGIN VALIDATION STATES-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse">
                    </a>

                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="#" id="userform" class="form-horizontal">
                    <input type="hidden" name="id" id="id" value="<?= $model->id ?>">

                    <div class="form-body">


                        <div class="form-group">
                            <label class="control-label col-md-3">用户名<span class="required">
										* </span>
                            </label>

                            <div class="col-md-4">
                                <input type="hidden" name="oldname" id="oldname" value="<?= $model->name ?>">
                                <input type="text" name="name" id="name" value="<?= $model->name ?>" data-required="1"
                                       class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">邮箱 <span class="required">
										* </span>
                            </label>

                            <div class="col-md-4">
                                <div class="input-group">
												<span class="input-group-addon">
												<i class="fa fa-envelope"></i>
												</span>
                                    <input type="email" name="email" value="<?= $model->email ?>" class="form-control"
                                           placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">密码 <span class="required">
										* </span></label>

                            <div class="col-md-4">
                                <input type="password" name="password_hash" value="" id="password_hash"
                                       data-required="1" class="form-control"/>
                            </div>

                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">确认密码<span class="required">
										* </span></label>

                            <div class="col-md-4">
                                <input type="password" name="repassword" id="repassword" data-required="1"
                                       class="form-control"/>
                            </div>

                        </div>
                        <div class="form-group">
                            <input type="hidden" id="userimgval" name="img" value="<?= $model->img ?>">
                            <label class="control-label col-md-3">上传图像<span class="required">
										 </span>
                            </label>

                            <div class="col-md-4">
                                <?= $this->render('../../../../views/public/_uploadImage', [
                                    'uploadId' => 'uploadUserImg',
                                    'imageId' => 'url',
                                    'imageDisplay' => 'userDisplay',
                                    'imageUrl' => $model->img,
                                ]) ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">角色
                            </label>

                            <div class="col-md-4">
                                <select class="form-control select2me" name="role">
                                    <?php if ($model->isNewRecord) { ?>
                                        <?php foreach ($roles as $key => $val): ?>
                                            <option value="<?= $val->name ?>"><?= $val->name ?></option>
                                        <?php endforeach; ?>
                                    <?php } else { ?>
                                        <?php foreach ($roles as $key => $val): ?>
                                            <option <?php if ($oldrolename == $val->name) { ?>
                                                selected="selected"
                                            <?php } ?>
                                                value="<?= $val->name ?>"><?= $val->name ?></option>
                                        <?php endforeach; ?>
                                        <input type="hidden" value="<?= $oldrolename ?>" id="oldrolename"
                                               name="oldrolename">
                                    <?php } ?>
                                </select>

                            </div>
                        </div>


                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" class="btn green"><?= $buttonName ?></button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- END FORM-->
            </div>
            <!-- END VALIDATION STATES-->
        </div>
    </div>
</div>


<script type="text/javascript">


    $(document).ready(
        function () {

            ComponentsDropdowns.init();
            UIAlertDialogApi.init();
            FormDropzone.init();

            var handleValidation3 = function () {


                var form3 = $('#userform');
                var error3 = $('.alert-danger', form3);
                var success3 = $('.alert-success', form3);

                //IMPORTANT: update CKEDITOR textarea with actual content before submit
                form3.on('submit', function () {
                    for (var instanceName in CKEDITOR.instances) {
                        CKEDITOR.instances[instanceName].updateElement();
                    }
                })

                form3.validate({
                    errorElement: 'span',
                    errorClass: 'help-block help-block-error',
                    focusInvalid: false,
                    ignore: "",
                    rules: {
                        name: {
                            minlength: 6,
                            required: true,
                            remote: {
                                url: "system/user/usernameisrepeat",
                                type: "post",
                                data: {
                                    name: function () {
                                        return $("#name").val();
                                    },
                                    oldname: function () {
                                        return $("#oldname").val();
                                    }
                                }
                            }
                        },
                        email: {
                            required: true,
                            email: true
                        },
                        password_hash: {
                            required: true,
                            minlength: 6

                        },
                        repassword: {
                            required: true,
                            minlength: 6,
                            equalTo: "#password_hash"
                        }
                    },

                    messages: {
                        email: {
                            required: "请输入邮箱",
                            email: "邮箱格式错误"
                        },
                        name: {
                            required: "请输入用户名",
                            minlength: "用户名最少需要6位",
                            remote: "用户名已被注册"
                        },
                        password_hash: {
                            required: "请输入密码",
                            minlength: "密码最少6位"

                        },
                        repassword: {
                            required: "请再次输入密码",
                            minlength: "密码最少6位",
                            equalTo: "2次密码不相同"
                        }
                    },

                    errorPlacement: function (error, element) { // render error placement for each input type
                        if (element.parent(".input-group").size() > 0) {
                            error.insertAfter(element.parent(".input-group"));
                        } else if (element.attr("data-error-container")) {
                            error.appendTo(element.attr("data-error-container"));
                        } else if (element.parents('.radio-list').size() > 0) {
                            error.appendTo(element.parents('.radio-list').attr("data-error-container"));
                        } else if (element.parents('.radio-inline').size() > 0) {
                            error.appendTo(element.parents('.radio-inline').attr("data-error-container"));
                        } else if (element.parents('.checkbox-list').size() > 0) {
                            error.appendTo(element.parents('.checkbox-list').attr("data-error-container"));
                        } else if (element.parents('.checkbox-inline').size() > 0) {
                            error.appendTo(element.parents('.checkbox-inline').attr("data-error-container"));
                        } else {
                            error.insertAfter(element); // for other inputs, just perform default behavior
                        }
                    },

                    invalidHandler: function (event, validator) {
                        success3.hide();
                        error3.show();
                        Metronic.scrollTo(error3, -200);
                    },

                    highlight: function (element) {
                        $(element)
                            .closest('.form-group').addClass('has-error');
                    },

                    unhighlight: function (element) {
                        $(element)
                            .closest('.form-group').removeClass('has-error');
                    },

                    success: function (label) {
                        label
                            .closest('.form-group').removeClass('has-error');
                    },

                    submitHandler: function (form) {
                        success3.show();
                        error3.hide();
                        if ($("#id").val() == "") {
                            addUser();
                        } else {
                            updateUser();
                        }
                    }

                });

                $('.date-picker .form-control').change(function () {
                    form3.validate().element($(this));
                })
            }

            handleValidation3();
        }
    )
</script>