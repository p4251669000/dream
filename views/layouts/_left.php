<?php
/**
 * User: 谢锐
 * Date: 2015/5/4
 * Time: 12:22
 */
use yii\web\Session;

//菜单赋值
$session = new Session();
$session->open();
$userinfo = $session->get("userinfo");

$tree = $userinfo['rolemenu'];

?>
<div class="page-sidebar-wrapper">

    <div class="page-sidebar navbar-collapse collapse">

        <ul class="page-sidebar-menu" data-slide-speed="200" data-auto-scroll="true"
            data-auto-scroll="true" data-slide-speed="200">
            <li class="start">

                <a class="ajaxify start" href="system/auth/authitemlist?type=2">
                    <i class="fa fa-home"></i>
					<span class="title">
					首页 </span>
					<span class="selected">
					</span>
                </a>
            </li>

            <?= $tree ?>
        </ul>
    </div>
</div>


