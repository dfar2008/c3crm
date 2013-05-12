top.window.moveTo(0, 0);
if (document.all) top.window.resizeTo(screen.availWidth, screen.availHeight);
else if (document.layers || document.getElementById) {
    if (top.window.outerHeight < screen.availHeight || top.window.outerWidth < screen.availWidth) {
        top.window.outerHeight = screen.availHeight;
        top.window.outerWidth = screen.availWidth;
    }
}
document.oncontextmenu = new Function("event.returnValue=false;");
document.onselectstart = new Function("event.returnValue=false;");
function window_beforeunload() {
    $.ajax({
        type: "POST",
        url: "/control/ClearLoginFlag.aspx"
    });
}
function Start() {
    $.ajax({ type: "POST", url: "/control/GetMain.aspx", success: function (str) {
        if (str.length > 0) {
            var tmp = str.split("|")[0];
            var tmp1 = str.split("|")[1];
            if (tmp.indexOf("已到") > -1) { alert(tmp); window.close(); }
            else { if (tmp.length > 0) alert(tmp); }
            document.title = tmp1;
        }
    }
    });
}
var date = new Date();
var COOKIE_NAME = 'isDemo_cookie';
var ADDITIONAL_COOKIE_NAME = 'additional';
var options = { path: '/', expires: 10 };
$(function () {
    setTimeout('Start()', 2000);
});

function btn_demo() {
    date.setTime(date.getTime() + (3 * 24 * 60 * 60 * 1000));
    $.cookie(COOKIE_NAME, 'frist', { path: '/', expires: date });
    $("#divback").hide();
    $("#divmsg").hide();
}
var timer_This;
function ShowPopMenu(heightSpan) {
    $("#pop_menu").css("top", 95 - heightSpan);
    $("#pop_menu").show();
}

var timer_favorite;
function ShowFavoriteList(obj) {
    var divFavoriteMenu = $('#divFavoriteMenu');
    if (divFavoriteMenu.html().trim().length == 0) {
        var imgLoading = parent.$('#top').contents().find("#imgLoading");
        imgLoading.show();
        $.ajax({
            type: "POST",
            url: "/Control/Common/Favorite.aspx",
            data: "isGet=true",
            success: function (data) {
                eval(data); imgLoading.hide();
                var offset = jQuery(obj).offset();
                var height = jQuery(obj).height();
                height = offset.top + height - 1;
                divFavoriteMenu.css({ left: offset.left - 2, top: height });
                divFavoriteMenu.show();
                if (timer_favorite != null) clearInterval(timer_favorite);
                timer_favorite = setInterval(HideFavorite, 2 * 1000);
            }
        });
    }
    else {
        var offset = jQuery(obj).offset();
        var height = jQuery(obj).height();
        height = offset.top + height - 1;
        divFavoriteMenu.css({ left: offset.left - 2, top: height });
        divFavoriteMenu.show();
        if (timer_favorite != null) clearInterval(timer_favorite);
        timer_favorite = setInterval(HideFavorite, 2 * 1000);
    }
}


rnd.today = new Date();
rnd.seed = rnd.today.getTime();
function rnd() {
    rnd.seed = (rnd.seed * 9301 + 49297) % 233280;
    return rnd.seed / (233280.0);
};



function RefreshBottom() {
    if (timer_RefreshBottom == null) return;
    index = index + 1;
    $('#bottom').attr("src", "/bottom.aspx?isLock=true&index=" + index);
}
function UnLock() {
    
}
//
function InitData() {
    //ShowLock_First();
    //InitPrompt_Day();
    //timer_Awake = setInterval(SendRequest_AwakeRecord, 1000 * 60 * 2);
    //timer_chatInfo = setInterval(ShowChatInfo, 1000 * 60 * 1);
}