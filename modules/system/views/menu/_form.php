<?php
/**
 * User: 谢锐
 * Date: 2015/5/15
 * Time: 9:35
 */
$buttonName= $model->isNewRecord ? "创建菜单" :"更新菜单";

?>

<div class="row">
    <div class="col-md-12">
        <!-- BEGIN VALIDATION STATES-->
        <div class="portlet box purple">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>
                </div>
                <div class="tools">
                    <a href="javascript:;" class="reload">
                    </a>
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form id="menuform" class="form-horizontal" method="post">
                    <input type="hidden" name="id" id="id" value="<?= $model->id ?>">

                    <div class="form-body">

                        <?php if ($model->isNewRecord){ ?>
                            <div class="form-group">
                                <label class="control-label col-md-3">父菜单<span class="required">
                                    * </span>
                                </label>

                                <div class="col-md-4">
                                    <select class="form-control select2me" name="parentid">
                                        <option value="0">根目录</option>
                                        <?php foreach ($listData as $key => $val): ?>
                                            <option value="<?= $key ?>"><?= $val ?></option>
                                        <?php endforeach; ?>

                                    </select>
                                </div>
                            </div>
                        <?php }else { ?>
                        <div class="form-body">

                            <div class="form-group">
                                <label class="control-label col-md-3">父菜单<span class="required">
                                    * </span>
                                </label>

                                <div class="col-md-4">
                                    <select class="form-control select2me" name="parentid">
                                        <option value="0">根目录</option>
                                        <?php foreach ($listData as $key => $val): ?>
                                            <?php if ($key <> $model->parentid && $key <> $model->id) { ?>
                                                <option  value="<?= $key ?>"><?= $val ?></option>
                                            <?php } elseif ($key == $model->parentid) { ?>
                                                <option value="<?= $key ?>" selected="selected"><?= $val ?></option>
                                            <?php } ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="form-group">
                                <label class="control-label col-md-3">菜单logo <span class="required"> </span></label>

                                <div class="col-md-4">
                                    <span id="myico"><i class="<?= $model->ico ?>"></i></span>
                                    <input type="hidden" name="ico" id="ico" value="<?= $model->ico ?>"/>
                                    <a class="btn default" data-toggle="modal" href="#large">
                                        选择LOGO</a>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">菜单名 <span class="required">
                                    * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="name" value="<?= $model->name ?>" data-required="1"
                                           class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">菜单url
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="url" value="<?= $model->url ?>" class="form-control"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" class="btn green"><?= $buttonName?></button>
                                </div>
                            </div>
                        </div>
                </form>
                <!-- END FORM-->
            </div>
        </div>
        <!-- END VALIDATION STATES-->
    </div>
</div>

<?= $this->render('_ico', []) ?>

<script type="text/javascript">

    /**
     * 选择ico图标
     */
    $("#tab_1_1 i").each(function () {
        $(this).bind("click", function () {
            var html = "<i class='" + this.className + "'><i/>";
            $("#myico").html(html);
            $("#ico").val(this.className);
            $("#icoclose").click();
            //$("#large").hide();
        });
    })

    /* Init Metronic's core jquery plugins and layout scripts */
    $(document).ready(function () {
        ComponentsDropdowns.init(); // init todo page
        FormValidation.init();
        UIAlertDialogApi.init();
    });


    $(document).ready(
        function () {

            var handleValidation = function () {

                var form3 = $('#menuform');
                var error3 = $('.alert-danger', form3);
                var success3 = $('.alert-success', form3);

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
                            required: true
                        }
                    },

                    messages: {
                        name: {
                            required: "菜单名是必须的"
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

                    unhighlight: function (element) { // revert the change done by hightlight
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
                            addMenu();
                        } else {
                            updateMenu();
                        }

                    }

                });


                $('.select2me', form3).change(function () {
                    form3.validate().element($(this));
                });

                // initialize select2 tags
                $("#select2_tags").change(function () {
                    form3.validate().element($(this));
                }).select2({
                    tags: ["red", "green", "blue", "yellow", "pink"]
                });

                //initialize datepicker
                $('.date-picker').datepicker({
                    rtl: Metronic.isRTL(),
                    autoclose: true
                });
                $('.date-picker .form-control').change(function () {
                    form3.validate().element($(this));
                })
            }

            handleValidation();
        })
</script>

<!-- END JAVASCRIPTS -->
