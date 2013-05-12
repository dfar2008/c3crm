<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>控制面板 -级联字段- {$APP.LBL_BROWSER_TITLE}</title>
<meta http-equiv="Content-Type" content="text/html; charset="UTF-8">
<link href="themes/softed/style.css" rel="stylesheet" type="text/css"></link>
<script language="JavaScript" type="text/javascript" src="include/js/zh_cn.lang.js"></script>
<script language="JavaScript" type="text/javascript" src="include/js/general.js"></script>
<script language="javascript" type="text/javascript" src="include/scriptaculous/prototypeall.js"></script>
</head>
<body leftmargin=0 topmargin=0 marginheight=0 marginwidth=0 class=small>
        <script language="javascript">
        function dup_validation()
        {ldelim}
            var catalogname = $('catalogname').value;
            var mode = getObj('mode').value;
            var catalogid = getObj('catalogid').value;
            var multifieldid=getObj('multifieldid').value;
            var level=getObj('level').value;
            var parentfieldid=getObj('parentfieldid').value;
            if(mode == 'edit')
                var urlstring ="&mode="+mode+"&catalogName="+catalogname+"&catalogid="+catalogid+"&multifieldid="+multifieldid+"&level="+level+"&parentfieldid="+parentfieldid;
            else
                var urlstring ="&catalogName="+catalogname+"&multifieldid="+multifieldid+"&level="+level+"&parentfieldid="+parentfieldid;
            new Ajax.Request(
                        'index.php',
                        {ldelim}queue: {ldelim}position: 'end', scope: 'command'{rdelim},
                                        method: 'post',
                                        postBody: 'module=Settings&action=SettingsAjax&file=SaveMultiFieldNode&ajax=true&dup_check=true'+urlstring,
                                        onComplete: function(response) {ldelim}
                            if(response.responseText == 'SUCESS') 
                                document.newCatalogForm.submit();
                            else
                                alert(response.responseText);
                                        {rdelim}
                                {rdelim}
                        );

        {rdelim}
        function validate()
        {ldelim}
            if( !emptyCheck( "catalogName", "下拉框选项名称不能为空" ) )
                return false;

            dup_validation();
            //return true;
        {rdelim}
        </script>
        <br>
        <table align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
        <tbody><tr>
                <td valign="top"><img src="{$IMAGE_PATH}showPanelTopLeft.gif"></td>
                <td class="showPanelBg" style="padding: 10px;" valign="top" width="100%">
                <br>

            <div align=left>
                        <!-- DISPLAY -->
                       <form name="newCatalogForm" action="index.php" method="post">
                        <table border=0 cellspacing=0 cellpadding=5 width=100% class="settingsSelUITopLine">
                       
                        <input type="hidden" name="module" value="Settings">
                        <input type="hidden" name="action" value="SaveMultiFieldNode">
                        <input type="hidden" name="parenttab" value="Settings">
                        <input type="hidden" name="returnaction" value="{$RETURN_ACTION}">
                        <input type="hidden" name="catalogid" value="{$CATALOGID}">
                        <input type="hidden" name="mode" value="{$MODE}">
                        <input type="hidden" name="parent" value="{$PARENT}">
                        <input type="hidden" name="multifieldid" value="{$MULTIFIELDID}">
                        <input type="hidden" name="level" value="{$LEVEL}">
                        <input type="hidden" name="parentfieldid" value="{$PARENTFIELDID}">
                        <tr>
                            {if $MODE eq 'edit'}
                            <td class=heading2 valign=bottom><b> 级联字段 &gt; {$MOD.LBL_EDIT} &quot;下拉框选项&quot; </b></td>
                            {else}
                            <td class=heading2 valign=bottom><b> 级联字段  &gt; 新增 &quot;下拉框选项&quot;</b></td>
                            {/if}
                        </tr>
                        <tr>
                            {if $MODE eq 'edit'}
                            <td valign=top class="small">{$MOD.LBL_EDIT} {$MOD.LBL_PROPERTIES} &quot;{$CATALOGNAME}&quot; {$MOD.LBL_LIST_CONTACT_CATALOG}</td>
                            {else}
                            <td valign=top class="small">{$MOD.LBL_NEW_CATALOG}</td>
                            {/if}
                        </tr>
                        </table>
                        <table border=0 cellspacing=0 cellpadding=10 width=100% >
                        <tr>
                        <td valign=top>
                                <table width="100%"  border="0" cellspacing="0" cellpadding="5">
                                  <tr class="small"><td align="center" colspan=2>
                                  <input type="button" class="crmButton small save" name="add" value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " onClick="return validate()">
                                  <input type="button" class="crmButton cancel small" name="cancel" value="{$APP.LBL_CANCEL_BUTTON_LABEL}" onClick="goback()">
                                </td></tr>
                                  <tr class="small">
                                <td width="30%" class="small cellLabel" align="right"><font color="red">*</font><strong>下拉框选项名称</strong></td>
                                <td width="70%" class="cellText" ><input id="catalogname" name="catalogName" type="text" value="{$CATALOGNAME}" class="detailedViewTextBox"></td>
                                  </tr>
                                  <tr class="small">
                                <td class="small cellLabel" align="right"><strong>所在位置</strong></td>
                                <td class="cellText">{$PARENTNAME}</td>
                                  </tr>
                                </table>

                            </td>
                              </tr>
                            
                       </table>
                    </form>
            </div>

        </td>
                <td valign="top"><img src="{$IMAGE_PATH}showPanelTopRight.gif"></td>
           </tr>
        </tbody>
        </table>

        <script language="JavaScript" type="text/JavaScript">
                var moveupLinkObj,moveupDisabledObj,movedownLinkObj,movedownDisabledObj;
                function setObjects()
                {ldelim}
                    availListObj=getObj("availList")
                    selectedColumnsObj=getObj("selectedColumns")

                {rdelim}

                function addColumn()
                {ldelim}
                    for (i=0;i<selectedColumnsObj.length;i++)
                    {ldelim}
                        selectedColumnsObj.options[i].selected=false
                    {rdelim}

                    for (i=0;i<availListObj.length;i++)
                    {ldelim}
                        if (availListObj.options[i].selected==true)
                        {ldelim}
                            for (j=0;j<selectedColumnsObj.length;j++)
                            {ldelim}
                                if (selectedColumnsObj.options[j].value==availListObj.options[i].value)
                                {ldelim}
                                    var rowFound=true
                                    var existingObj=selectedColumnsObj.options[j]
                                    break
                                {rdelim}
                            {rdelim}

                            if (rowFound!=true)
                            {ldelim}
                                var newColObj=document.createElement("OPTION")
                                newColObj.value=availListObj.options[i].value
                                if (browser_ie) newColObj.innerText=availListObj.options[i].innerText
                                else if (browser_nn4 || browser_nn6) newColObj.text=availListObj.options[i].text
                                selectedColumnsObj.appendChild(newColObj)
                                availListObj.options[i].selected=false
                                newColObj.selected=true
                                rowFound=false
                            {rdelim}
                            else
                            {ldelim}
                                existingObj.selected=true
                            {rdelim}
                        {rdelim}
                    {rdelim}
                {rdelim}

                function delColumn()
                {ldelim}
                    for (i=0;i<=selectedColumnsObj.options.length;i++)
                    {ldelim}
                        if (selectedColumnsObj.options.selectedIndex>=0)
                        selectedColumnsObj.remove(selectedColumnsObj.options.selectedIndex)
                    {rdelim}
                {rdelim}

                function formSelectColumnString()
                {ldelim}
                    var selectedColStr = "";
                    for (i=0;i<selectedColumnsObj.options.length;i++)
                    {ldelim}
                        selectedColStr += selectedColumnsObj.options[i].value + ";";
                    {rdelim}
                    document.newCatalogForm.selectedColumnsString.value = selectedColStr;
                {rdelim}
            setObjects();
        </script>


</body>
</html>