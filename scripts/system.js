/**
 * Created by 谢锐 on 2015/5/10.
 */

/**
 * 加载菜单初始化
 */
var TreeMenu = function () {
    var treemenu = function () {
        $('#gtreetable').gtreetable({
            'languages': {
                'en-US': {
                    save: '保存',
                    cancel: '取消',
                    action: '操作',
                    actions: {
                        update: '更新',
                        'delete': '删除'
                    },
                    messages: {
                        onDelete: '真的要删除吗?'
                    }
                }
            },
            'defaultActions': [
                {
                    name: '${delete}',
                    event: function (oNode, oManager) {
                        if (confirm(oManager.language.messages.onDelete)) {
                            var arr = oNode.id.split(":");
                            $.Dream.drAjax({
                                type: "post",
                                url: "system/menu/delete",
                                data: "id=" + arr[0],
                                dataType: "json",
                                success: function (data) {
                                    var obj = eval('(' + data + ')');
                                    if (obj.result) {
                                        oNode.remove();
                                    }else {
                                        alert(obj.msg);
                                    }
                                },
                                error : function(XMLHttpRequest, textStatus, errorThrown) {
                                    alert(XMLHttpRequest.readyState);
                                }

                            });


                        }
                    }
                }
                ,
                {
                    name: '${update}',
                    event: function (oNode, oManager) {
                        var arr = oNode.id.split(":");
                        directAjaxUrl("system/menu/update?id=" + arr[0]);
                    }
                }
            ],
            'draggable': true,
            'source': function (id) {
                return {
                    type: 'GET',
                    url: 'system/menu/getchildmenu',
                    data: {
                        'id': id
                    },
                    dataType: 'json',
                    error: function (XMLHttpRequest) {
                        alert(XMLHttpRequest.status + ': ' + XMLHttpRequest.responseText);
                    }
                }
            },
            'sort': function (a, b) {
                // var aName = a.name.toLowerCase();
                // var bName = b.name.toLowerCase();
                // return ((aName < bName) ? -1 : ((aName > bName) ? 1 : 0));
            },
            'types': {default: 'glyphicon glyphicon-folder-open', folder: 'glyphicon glyphicon-folder-open'},
            'inputWidth': '255px'
        });
    };

    return {

        //main function to initiate the module
        init: function () {
            treemenu();
        }

    };

}();

