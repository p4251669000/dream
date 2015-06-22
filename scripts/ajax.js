//@ sourceURL=ajax.js
/*
 *关于系统设置的ajax异步
 *创建时间：2015.4.6
 *创建人：谢锐
 */

$(document).ready(function () {


});

/**
 * 后台登录
 */
function adminLogin() {
    $.Dream.drAjax({
        type: "post",
        url: "../../public/logininfo",
        data: $('.login-form').serialize(),
        dataType: "json",
        success: function (data) {
            var obj = eval('(' + data + ')');
            if (!obj.result) {
                $("#errorinfo").text(obj.msg);
                $('.alert-danger', $('.login-form')).show();
                $("#virifyimg").attr("src", '../../common/dmpublic/Captchmath.php?nocache=' + Math.random());
            } else {
                window.location.href = "../../";
            }
        }
    });

}


/*
 *添加一条菜单
 */
function addMenu() {

    $.Dream.drAjax({
        type: "post",
        url: "system/menu/addmenu",
        data: $('#menuform').serialize(),
        dataType: "json",
        success: function (data) {
            var obj = eval('(' + data + ')');
            if (!obj.result) {
                alert(obj.msg);
            } else {
                alert(obj.msg);
                directAjaxUrl("system/menu/index");
            }
        }
    });
}

/**
 * 更新一条菜单
 */
function updateMenu() {

    $.Dream.drAjax({
        type: "post",
        url: "system/menu/updatemenu",
        data: $('#menuform').serialize(),
        dataType: "json",
        success: function (data) {
            var obj = eval('(' + data + ')');
            if (!obj.result) {
                alert(obj.msg);
            }
            else {
                alert(obj.msg);
                directAjaxUrl("system/menu/index");
            }

        }

    });
}

/**
 * 添加一个角色
 */
function addUser() {

    $.Dream.drAjax({
        type: "post",
        url: "system/user/adduser",
        data: $('#userform').serialize(),
        dataType: "json",
        success: function (data) {
            var obj = eval('(' + data + ')');
            if (!obj.result) {
                alert(obj.msg);
            }
            else {
                alert(obj.msg);
                directAjaxUrl("system/user/index");
            }

        }

    });

}

/**
 * 更新用户
 */
function updateUser() {

    $.Dream.drAjax({
        type: "post",
        url: "system/user/updateuser",
        data: $('#userform').serialize(),
        dataType: "json",
        success: function (data) {
            var obj = eval('(' + data + ')');
            if (!obj.result) {
                alert(obj.msg);
            }
            else {
                alert(obj.msg);
                directAjaxUrl("system/user/index");
            }

        }

    });
}

/**
 * 添加一条权限
 */
function addPermission() {
    $.Dream.drAjax({
        type: "post",
        url: "system/auth/addpermission",
        data: $('#permissionform').serialize(),
        dataType: "json",
        success: function (data) {
            var obj = eval('(' + data + ')');
            if (!obj.result) {
                alert(obj.msg);
            }
            else {
                alert(obj.msg);
                directAjaxUrl("system/auth/authitemlist?type=2");
            }

        }

    });
}

/**
 * 更新一条权限
 */
function updatePermission() {
    alert("ok");
    $.Dream.drAjax({
        type: "post",
        url: "system/auth/updatepermissioninfo",
        data: $('#permissionform').serialize(),
        dataType: "json",
        success: function (data) {
            var obj = eval('(' + data + ')');
            if (!obj.result) {
                alert(obj.msg);
            }
            else {
                alert(obj.msg);
                directAjaxUrl("system/auth/authitemlist?type=2");
            }

        }

    });
}


/**
 * 添加一条角色
 */
function addRole() {

    //得到选择的权限值
    var permission = choosecheck("rolename");
    $("#chooserolepermission").val(permission);

    //得到选择的菜单值
    var rolemenu = $('#tree_menu').jstree().get_checked();
    $("#choosecheckmenu").val(rolemenu);

    $.Dream.drAjax({
        type: "post",
        url: "system/auth/addrole",
        data: $('#roleform').serialize(),
        dataType: "json",
        success: function (data) {
            var obj = eval('(' + data + ')');
            if (!obj.result) {
                alert(obj.msg);
            }
            else {
                alert(obj.msg);
                directAjaxUrl("system/auth/authitemlist?type=1");
            }

        }

    });
}

/**
 * 更新角色
 */
function updateRole() {

    //得到选择的权限值
    var permission = choosecheck("rolename");
    $("#chooserolepermission").val(permission);

    //得到选择的菜单值
    var rolemenu = $('#tree_menu').jstree().get_checked();
    $("#choosecheckmenu").val(rolemenu);

    $.Dream.drAjax({
        type: "post",
        url: "system/auth/updateroleinfo",
        data: $('#roleform').serialize(),
        dataType: "json",
        success: function (data) {
            var obj = eval('(' + data + ')');
            if (!obj.result) {
                alert(obj.msg);
            }
            else {
                alert(obj.msg);
                directAjaxUrl("system/auth/authitemlist?type=1");
            }

        }

    });

}

function deleteMethod($trname, $id, $url) {

    if (confirm("是否删除")) {
        $.Dream.drAjax({
            type: "post",
            url: $url + "?id=" + $id,
            dataType: "json",
            success: function (data) {
                var obj = eval('(' + data + ')');
                if (!obj.result) {
                    alert(obj.msg);
                }
                else {
                    alert(obj.msg);
                    $("#"+$trname).remove();
                }

            }

        });

    }

}

