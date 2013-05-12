<meta http-equiv="Content-Type" content="text/html; charset="UTF-8">
<link href="themes/softed/style.css" rel="stylesheet" type="text/css"></link>
<script language="JavaScript" type="text/javascript" src="include/js/general.js"></script>
<script language="JavaScript" type="text/javascript" src="include/js/zh_cn.lang.js"></script>
<script language="javascript" type="text/javascript" src="include/scriptaculous/prototypeall.js"></script>
<script language="JavaScript" type="text/javascript" src="include/js/json.js"></script>
<script language="JavaScript" type="text/javascript" src="modules/SalesOrder/SalesOrder.js"></script>
<script type="text/javascript">
function add_data_to_relatedlist(entity_id,recordid,mod) {ldelim}
        opener.document.location.href="index.php?module={$RETURN_MODULE}&action=updateRelations&destination_module="+mod+"&entityid="+entity_id+"&parid="+recordid+"&return_action={$RETURN_ACTION}";
{rdelim}

</script>
<body class="small" marginwidth=0 marginheight=0 leftmargin=0 topmargin=0 bottommargin=0 rigthmargin=0>
<div id="createproduct_div" style="display:block;position:absolute;left:225px;top:200px;"></div>
<div id="status" style="position:absolute;display:none;left:100px;top:95px;height:27px;white-space:nowrap;"><img src="{$IMAGE_PATH}status.gif"></div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>
			
			<table width="100%" cellpadding="3" cellspacing="0" border="0"  class="homePageMatrixHdr">
				<tr>
					<td style="padding:5px;" >
						<form name="basicSearch" action="index.php" onSubmit="return false;">
						<table width="100%" cellpadding="5" cellspacing="0">
						<tr>
							
							<td width="30%" class="dvtCellLabel">							<select name ="search_field" class="txtBox">
											 {html_options  options=$SEARCHLISTHEADER }
											</select> &nbsp;</td>
							<td width="30%" class="dvtCellLabel">
							        <input type="text" name="search_text" class="txtBox" onKeyDown="javascript:if(event.keyCode==13) callSearch('Basic')">
								<input type="hidden" name="searchtype" value="BasicSearch">
								<input type="hidden" name="module" value="{$MODULE}">
								<input type="hidden" name="action" value="PopupForSO">
								<input type="hidden" name="query" value="true">
								
								
								<input type="hidden" name="curr_row" id="curr_row" value="{$CURR_ROW}">
								<input type="hidden" name="fldname_pb" value="{$FIELDNAME}">
								<input type="hidden" name="productid_pb" value="{$PRODUCTID}">
								
								<input name="recordid" id="recordid" type="hidden" value="{$RECORDID}">
								<input name="return_module" id="return_module" type="hidden" value="{$RETURN_MODULE}">
								<input name="from_link" id="from_link" type="hidden" value="{$smarty.request.fromlink.value}">
								<input id="viewname" name="viewname" type="hidden" value="{$VIEWID}">
			
							</td>
							<td width="20%" class="dvtCellLabel">
								<input type="button" name="search" value=" &nbsp;{$APP.LBL_SEARCH_NOW_BUTTON}&nbsp; " onClick="callSearch('Basic');" class="crmbutton small create">
								
								&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="button" name="create" value=" &nbsp;{$APP.LNK_NEW_PRODUCT}&nbsp; " onClick="callCreateProductDiv();" class="crmbutton small create">
								
							</td>
						</tr>
						</table>
						</form>
					</td>
				</tr>
			</table>
			<table border="0" cellpadding="0" cellspacing="0" style="padding-right:5px;padding-top:2px;padding-bottom:2px;">
			  <tr>
			  <td><img src="themes/images/filter.png" border=0></td>
			  <td>{$APP.LBL_VIEW}
			  {foreach name="listviewforeach" key=id item=viewname from=$CUSTOMVIEW_OPTION}

					{if $id eq $VIEWID} 
					<span style="padding-right:5px;padding-top:5px;padding-bottom:5px;">
					&nbsp;&nbsp;<a class="cus_markbai tablink" href="javascript:;" onClick="javascript:getTabView('{$MODULE}','viewname={$id}',this,{$id});">{$viewname}</a>&nbsp;&nbsp;
					</span>
					{else}
					<span style="padding-right:5px;padding-top:5px;padding-bottom:5px;">
					&nbsp;&nbsp;<a class="cus_markhui tablink" href="javascript:;" onClick="javascript:getTabView('{$MODULE}','viewname={$id}',this,{$id});">{$viewname}</a>&nbsp;&nbsp;
					</span>
					{/if}
			  {/foreach}
			  </td>
			  </tr>
			</table>
		       <table width="100%" border="0" cellspacing="0" cellpadding="0" class="small">
		       <tr>
		       <td width=70% align="left" valign=top style="padding:5px">
			<div id="ListViewContents">
				{include file="Products/PopupContentsForSO.tpl"}
			</div>
			</td>
			</tr>
			</table>
		</td>
	</tr>
	
</table>
</body>
<script>
var gPopupAlphaSearchUrl = '';
function callSearch(searchtype)
{ldelim}
    for(i=1;i<=26;i++)
    {ldelim}
        var data_td_id = 'alpha_'+ eval(i);
        getObj(data_td_id).className = 'searchAlph';
    {rdelim}
    gPopupAlphaSearchUrl = '';
    search_fld_val= document.basicSearch.search_field[document.basicSearch.search_field.selectedIndex].value;
    search_txt_val=document.basicSearch.search_text.value;
    var urlstring = '';
    if(searchtype == 'Basic')
    {ldelim}
	urlstring = 'search_field='+search_fld_val+'&searchtype=BasicSearch&search_text='+search_txt_val;
    {rdelim}
	popuptype = $('popup_type').value;
	urlstring += '&popuptype='+popuptype;
	urlstring = urlstring +'&query=true&file=PopupForSO&module=Products&action=ProductsAjax&ajax=true';
	urlstring +=gethiddenelements();
	new Ajax.Request(
		'index.php',
		{ldelim}queue: {ldelim}position: 'end', scope: 'command'{rdelim},
				method: 'post',
				postBody: urlstring,
				onComplete: function(response) {ldelim}
					$("ListViewContents").innerHTML= response.responseText;
					setSelectedProductRow();
				{rdelim}
			{rdelim}
		);
{rdelim}	
function gethiddenelements()
{ldelim}
	var urlstring=''	
	if(getObj('select_enable').value != '')
		urlstring +='&select=enable';	
	if(document.getElementById('curr_row').value != '')
		urlstring +='&curr_row='+document.getElementById('curr_row').value;	
	if(getObj('fldname_pb').value != '')
		urlstring +='&fldname='+getObj('fldname_pb').value;	
	if(getObj('productid_pb').value != '')
		urlstring +='&productid='+getObj('productid_pb').value;	
	if(getObj('recordid').value != '')
		urlstring +='&recordid='+getObj('recordid').value;	
	var return_module = document.getElementById('return_module').value;
	if(return_module != '')
		urlstring += '&return_module='+return_module;
	var idlist = document.selectall.idlist.value;
	var productlist = document.selectall.productlist.value;
	urlstring = urlstring + "&idlist=" + idlist;
	urlstring = urlstring + "&productlist=" + productlist;
	if(getObj('vendor_id') != undefined && getObj('vendor_id').value != '')
		urlstring +='&vendor_id='+getObj('vendor_id').value;

	return urlstring;
{rdelim}																							
function getListViewEntries_js(module,url)
{ldelim}
	popuptype = document.getElementById('popup_type').value;
        var urlstring ="module="+module+"&action="+module+"Ajax&file=PopupForSO&ajax=true&"+url;
    	urlstring +=gethiddenelements();
	//search_fld_val= document.basicSearch.search_field[document.basicSearch.search_field.selectedIndex].value;
	search_fld_val= document.selectall.search_field.value;
	//search_txt_val=document.basicSearch.search_text.value;
	search_txt_val=document.selectall.search_text.value;
    	if(search_txt_val != '')
		urlstring += '&query=true&search_field='+search_fld_val+'&searchtype=BasicSearch&search_text='+search_txt_val;
	if(gPopupAlphaSearchUrl != '')
		urlstring += gPopupAlphaSearchUrl;	
	else
		urlstring += '&popuptype='+popuptype;
	new Ajax.Request(
                'index.php',
                {ldelim}queue: {ldelim}position: 'end', scope: 'command'{rdelim},
                                method: 'post',
                                postBody: urlstring,
                                onComplete: function(response) {ldelim}
                                        $("ListViewContents").innerHTML= response.responseText;
					setSelectedProductRow();
				{rdelim}
			{rdelim}
		);
{rdelim}

function getListViewWithPageNo(module,pageElement)
{ldelim}
	//var pageno = document.getElementById('listviewpage').value;
	var pageno = pageElement.options[pageElement.options.selectedIndex].value;
	getListViewEntries_js(module,'start='+pageno);
{rdelim}
function getListViewWithPageSize(module,pageElement)
{ldelim}
	//var pageno = document.getElementById('listviewpage').value;
	var pagesize = pageElement.options[pageElement.options.selectedIndex].value;
	getListViewEntries_js(module,'pagesize='+pagesize);
{rdelim}

function getListViewSorted_js(module,url)
{ldelim}
        var urlstring ="module="+module+"&action="+module+"Ajax&file=PopupForSO&ajax=true"+url;
	new Ajax.Request(
                'index.php',
                {ldelim}queue: {ldelim}position: 'end', scope: 'command'{rdelim},
                                method: 'post',
                                postBody: urlstring,
                                onComplete: function(response) {ldelim}
                                        $("ListViewContents").innerHTML= response.responseText;
					setSelectedProductRow();
				{rdelim}
			{rdelim}
		);
{rdelim}
</script>
