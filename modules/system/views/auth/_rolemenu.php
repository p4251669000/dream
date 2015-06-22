<?php
/**
 * User: 谢锐
 * Date: 2015/6/13
 * Time: 23:29
 */
?>

<div id="tree_menu" class="tree-demo">

</div>

<script>
    /**
     * 异步加载相应的菜单
     */

    $(document).ready(function () {

        var ajaxTree = function () {
            $("#tree_menu").jstree({
                "core" : {
                    "themes" : {
                        "responsive": false
                    },
                    // so that create works
                    "check_callback" : true,
                    'data' : {
                        'url' : function (node) {
                            return 'system/auth/getroletree';
                        },
                        'data' : function (node) {
                            return { 'parent' : node.id ,'choose':'<?= $choosemenu?>' };
                        },
                        'dataType':'json'
                    }
                },
                "types" : {
                    "default" : {
                        "icon" : "fa fa-folder icon-state-warning icon-lg"
                    },
                    "file" : {
                        "icon" : "fa fa-file icon-state-warning icon-lg"
                    }
                },
                "state" : { "key" : "demo3" },
                "plugins" : [ "state", "types" ,"checkbox"]
            });

        }
        ajaxTree();
    });

</script>