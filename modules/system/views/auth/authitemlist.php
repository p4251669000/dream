<?php
/**
 * User: 谢锐
 * Date: 2015/6/16
 * Time: 19:00
 */
$itemname = $type == 1 ? "角色" : "权限";

$updateurl = $type == 1 ? "system/auth/updaterole" : "system/auth/updatepermission";

$createurl = $type == 1 ? "system/auth/createrole" : "system/auth/createpermission";

?>
<h1>&nbsp;</h1>

<div class="row">
    <div class="col-md-12">

        <div class="portlet box grey-cascade">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i><?= $itemname?>列表
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse">
                    </a>

                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="actions">
                                <a href="<?= $createurl ?>" class="ajaxify btn default yellow-stripe">
                                    <i class="fa fa-plus"></i>
								<span class="hidden-480">
								添加<?= $itemname ?> </span>
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                    <thead>
                    <tr>
                        <th>
                            <?= $itemname ?>名
                        </th>
                        <th>
                            描述
                        </th>
                        <th>
                            操作
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($list as $key => $val): ?>
                        <tr id="tr_<?= $val->name ?>" class="">
                            <td>
                                <?= $val->name ?>
                            </td>
                            <td>
                                <?= $val->description ?>
                            </td>
                            <td>
                                <a href="<?= $updateurl?>?id=<?= $val->name ?>" class="btn default btn-xs purple
                                ajaxify">
                                    <i class="fa fa-edit"></i> 修改 </a>

                                <a href="javascript:void(0)" onclick="deleteMethod('tr_<?= $val->name?>','<?= $val->name?>&type=<?= $val->type?>','system/auth/delete')"  class="btn default btn-xs black">
                                    <i class="fa fa-trash-o"></i> 删除 </a>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
