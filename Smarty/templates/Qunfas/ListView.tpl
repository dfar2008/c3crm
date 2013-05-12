

{*<!-- module header -->*}
<link href="include/ajaxtabs/ajaxtabs.css" type="text/css" rel="stylesheet"/>
<script language="JavaScript" type="text/javascript" src="include/js/ListView.js"></script>
<script language="JavaScript" type="text/javascript" src="include/js/search.js"></script>
<script language="JavaScript" type="text/javascript" src="modules/{$MODULE}/{$SINGLE_MOD}.js"></script>

		{include file='Buttons_List.tpl'}
                        </td>
                </tr>
                </table>
        </td>
</tr>
</table>

{*<!-- Contents -->*}

<table class="list_table" style="margin-top:2px;" border="0" cellpadding="3" cellspacing="1" width="100%">
        <tbody><tr >
        
          <td>
	  <table border="0" cellpadding="0" cellspacing="0" style="padding-right:5px;padding-top:2px;padding-bottom:2px;">

	  <tr>
	  <td><img src="themes/images/filter.png" border=0></td>
	  <td>{$APP.LBL_FENZU}
	  {foreach name="listviewforeach" key=id item=fenzuname from=$CUSTOMVIEW_OPTION}

			{if $id eq $VIEWID} 
			<span style="padding-right:5px;padding-top:5px;padding-bottom:5px;">
			&nbsp;&nbsp;<a class="cus_markbai tablink" href="javascript:;" onclick="javascript:getTableViewForFenzu('{$MODULE}','viewname={$id}',this,{$id});">{$fenzuname}</a>&nbsp;&nbsp;
			</span>
			{else}
			<span style="padding-right:5px;padding-top:5px;padding-bottom:5px;">
			&nbsp;&nbsp;<a class="cus_markhui tablink" href="javascript:;" onclick="javascript:getTableViewForFenzu('{$MODULE}','viewname={$id}',this,{$id});">{$fenzuname}</a>&nbsp;&nbsp;
			</span>
			{/if}		
			
	  {/foreach}
	  
	
		        
			<span style="padding-right:5px;padding-top:5px;padding-bottom:5px;">&nbsp;<a href="index.php?module={$MODULE}&action=Fenzu&parenttab={$CATEGORY}">{$APP.LNK_CV_CREATEFENZU}</a> | 
						
						<a href="javascript:editFenzu('{$MODULE}','{$CATEGORY}')">{$APP.LNK_CV_EDIT}</a> |
						
						<a href="javascript:deleteFenzu('{$MODULE}','{$CATEGORY}')">{$APP.LNK_CV_DELETE}</a></span>&nbsp;
		</td>
		</tr>
            </tbody></table>
	</td>
        </tr>
	<tr>
<td  colspan=3 bgcolor="#ffffff" valign="top">
<table border=0 cellspacing=0 cellpadding=0 width=100% align=center>
     <tr>
      <td class="lvt" valign="top" width=100% style="padding:0px;">
	   <!-- PUBLIC CONTENTS STARTS-->
	  <div id="ListViewContents" class="small" style="width:100%;position:relative;">
			{include file="Qunfas/ListViewEntries.tpl"}
	  </div>
     </td>
   </tr>
</table>
<!-- New List -->
</td></tr></tbody></table>

<!-- QuickEdit Feature -->

<script language="javascript" type="text/javascript">
{literal}
function setSendContent(obj){
	document.getElementById('sendmessageinfo').value = obj.value;
}
function checkFieldNum(){
	var sendmessageinfo = document.getElementById('sendmessageinfo').value;
	var contentlen = fucCheckLength2(sendmessageinfo);
	var zishu = 65 - contentlen;
	var str = "你还能输入:<font color=red><b>"+zishu+"</b></font>个字...";
	//document.getElementById("showzishu").update(str);
	$("showzishu").update(str);
}
{/literal}
</script>




