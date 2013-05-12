function displayDiv(mainModuleNumber, number) {
    var count = 15;
    var divOwner_Header = $("#div" + number.toString() + "_1");
    var divOwner_Body = $("#div" + number.toString() + "_2");
    if (divOwner_Body.css("display") != 'none') { divOwner_Body.hide(); return; }
    for (var i = 1; i <= count; i++) {
        var content = $("#div" + i.toString() + "_2");
        if (content.attr("id") != null) {
            //$("#div" + i.toString() + "_1").css("background", "url(bar_out.gif) repeat-x");//className
			$("#div" + i.toString() + "_1").className="header";
            content.hide();
        }
        else break;
    }
    if (divOwner_Body.css("display") == 'none') {
        if (divOwner_Header.attr("id") != null) divOwner_Header.show();
        if (divOwner_Body.attr("id") != null) divOwner_Body.show();
    }
    else {
        if (divOwner_Header.attr("id") != null) divOwner_Header.hide();
        if (divOwner_Body.attr("id") != null) divOwner_Body.hide();
    }
    //divOwner_Header.css("background", "url(bar_over.gif) repeat-x");
	divOwner_Header.className="headerSelected";
}

function onNodeEventHandler(sender, node, eventType) {
    if (eventType == "expanded") {
        var nodes = sender.getNodes();
        for (var i = 0; i < nodes.length; i++) {
            if (nodes[i].getText() != node.getText()) {
                if (nodes[i].getExpanded() == true) nodes[i].collapse();
            }
        }
    }
}
document.oncontextmenu = new Function("event.returnValue=false;");
document.onselectstart = new Function("event.returnValue=false;");
function SetHeight() {
    var parentHeight = parent.$("#outlook").height();
    $("#tbBody").css("height", parentHeight + "px");
    var fix = 0;
    if (location.href.indexOf("lient") > -1 || location.href.indexOf("tore") > -1) fix = 10;
    if (location.href.indexOf("esktop") > -1) fix = -0;
    var divheight = parentHeight - ($("#tbBody").find(".header:visible").length * 28) - fix;
    $(".demo").css("height", divheight + "px").css("max-height", divheight + "px");
    $(".itemStyle").css("height", divheight + "px").css("max-height", divheight + "px");
    $(".TreeViewStyle").css("height", divheight-1 + "px").css("max-height", divheight-1 + "px");
    if (IsIE(6)) {
        var divwidth = $(".header").width();
        $("#PyTree").parent().css("width", (divwidth - 2) + "px");
        if ($(".bjx").length > 0) {
            var divwidth2 = $(".bjx").width();
            $(".bjx").width(divwidth2 - 20);
        }

    }
	if(location.href.toLowerCase().indexOf("cmclient")>-1)
	{
		$("#div6_1").hide();$("#div6_2").hide();
	}

}