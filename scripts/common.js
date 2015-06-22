/**
 * Created by 谢锐 on 2015/5/9.
 */
var resBreakpointMd = Metronic.getResponsiveBreakpoint('md');

function test(){

}

/**
 * 异步加载页面函数
 * @param url 需要加载的页面URL
 */
function directAjaxUrl(url) {
    Metronic.scrollTop();

    //  var url = $(this).attr("href");
    var pageContentBody = $('.page-content .page-content-body');

    Metronic.startPageLoading();

    if (Metronic.getViewPort().width < resBreakpointMd && $('.page-sidebar').hasClass("in")) { // close the menu on mobile view while laoding a page
        $('.page-header .responsive-toggler').click();
    }

    $.ajax({
        type: "GET",
        cache: false,
        url: url,
        dataType: "html",
        success: function (res) {
            Metronic.stopPageLoading();
            pageContentBody.html(res);
            Layout.fixContentHeight(); // fix content height
            Metronic.initAjax(); // initialize core stuff
        },
        error: function (xhr, ajaxOptions, thrownError) {
            pageContentBody.html(xhr.responseText);
            Metronic.stopPageLoading();
        }
    });
}

/**
 * 异步加载封装，让其有正在加载标志
 */
$.Dream = {
    drAjax: function (o) {
        var defaults = {
            beforeSend: function () {
                Metronic.startPageLoading();
            },
            url: "",
            type: "post",
            data: null,
            dataType: "json",
            success: function () {
            },
            complete: function () {
                Metronic.stopPageLoading();
            },
            error: function () {
                Metronic.stopPageLoading();
            }
        };

        var options = $.extend(defaults, o);

        drPageAjax(options);
    }
};
function drPageAjax(options) {
    $.ajax(
        options
    );
}

/**
 * 得到选择name 的checkd
 * @param checkname name 名字
 * @returns {string} 返回所选择name的值
 */
function choosecheck(checkname) {

    var checkvalue = "";

    var num = 0;

    $("input[name='" + checkname + "']:checked").each(function () {

        if(num == 0){
            checkvalue = this.value;
        }else{
            checkvalue += "," + this.value;
        }

        num++;
    });

    return checkvalue;
}
