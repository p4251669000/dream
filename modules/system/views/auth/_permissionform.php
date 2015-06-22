<?php
/**
 * User: 谢锐
 * Date: 2015/6/12
 * Time: 20:55
 */
?>

<div class="row">
    <div class="col-md-12">
        <div class="tabbable tabbable-custom">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#tab_1_1" data-toggle="tab">
                        权限信息 </a>
                </li>

            </ul>
            <div class="tab-content">
                <div class="tab-pane active fontawesome-demo" id="tab_1_1">
                    <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                        <form id="permissionform" class="form-horizontal" method="post">
                            <?= $this->render('_authitemform', [
                                'itemname' => $itemname,
                                'model' => $model
                            ]) ?>

                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" class="btn
                                                            green"><?= $button ?></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- END FORM-->
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">


    $(document).ready(
        function () {

            var handleValidation = function () {
                var form3 = $('#permissionform');
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
                            required: true,
                            remote: {
                                url: "system/auth/permissionisrepeat",
                                type: "post",
                                data: {
                                    authname: function () {
                                        return $("#authname").val();
                                    },
                                    oldname: function () {
                                        return $("#oldname").val();
                                    }
                                }
                            }
                        },
                        description: {
                            required: true
                        }
                    },
                    messages: {
                        name: {
                            required: "请输入权限名",
                            remote: "已经存在,请重新输入"
                        },
                        description: {
                            required: "请输入角色描述"
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
                        if ($("#oldname").val() == "") {
                            addPermission();
                        } else {
                            updatePermission();
                        }
                    }
                });

                $('.date-picker .form-control').change(function () {
                    form3.validate().element($(this));
                })
            }

            handleValidation();
        }
    )
</script>

