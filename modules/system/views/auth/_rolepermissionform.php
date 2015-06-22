<?php
/**
 * User: 谢锐
 * Date: 2015/6/13
 * Time: 13:16
 */
?>
<div class="form-body">
    <div class="form-group" style="margin-left: 5%;">
        <div class="input-group">
            <div class="icheck-inline">

                    <?php foreach ($permissions as $key => $val): ?>
                        <label>
                            <input type="checkbox"
                                <?php if(isset($choosepermissions[$val->name])){?>
                                    checked
                                <?php }?>
                                   name="rolename"   value="<?= $val->name ?>" class="icheck"
                                   data-checkbox="icheckbox_flat-grey"> <?= $val->description ?> </label>
                    <?php endforeach; ?>

            </div>
        </div>
    </div>
</div>

