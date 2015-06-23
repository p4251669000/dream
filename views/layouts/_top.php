<?php
/**
 * User: 谢锐
 * Date: 2015/5/15
 * Time: 8:02
 */
?>
<div class="top-menu">
    <ul class="nav navbar-nav pull-right">
        <li class="dropdown dropdown-user">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
               data-close-others="true">
                <img alt="" class="img-circle" src="<?= $userinfo['img'] ?>"/>
                                <span class="username username-hide-on-mobile">
                                   <?= $userinfo['name'] ?> </span>
                <i class="fa fa-angle-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-default">
                <li>
                    <a href="public/logout">
                        <i class="icon-key"></i> 注销 </a>
                </li>
            </ul>
        </li>

        <li class="dropdown dropdown-quick-sidebar-toggler">
            <a href="javascript:;" class="dropdown-toggle">
                <i class="icon-logout"></i>
            </a>
        </li>

    </ul>
</div>