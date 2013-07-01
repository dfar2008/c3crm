{if $smarty.request.ajax neq ''}
&#&#&#{$ERROR}&#&#&#
{/if}
<style>
{literal}
.trbt{
	background-color:#DFEBEF;
	height:25px;
	padding-left:0px;
	border-bottom:1px solid #999;
	border-left:1px solid #999;
	border-top:1px solid #999;
	border-right:1px solid #999;
}

.tdw{
	border-bottom:1px solid #999;
	border-left:1px solid #999;
	border-top:1px solid #999;
	border-right:1px solid #999;
}
.clear{
	clear:left;		
}
.zhengchang {
	float:left;	
}
.zhengchang li{
	height:21px;
	float:left;
	background: url("themes/softed/images/sfa_blue.png") no-repeat scroll 0 0 transparent;
	list-style: none outside none;
	padding-top:1px;
}
.zhengchang li a{
	height:21px;
	background: url("themes/softed/images/sfa_blue.png") repeat-x scroll 0 -21px transparent;
	display: inline-block;
    line-height: 21px;
    padding: 0 0 0 5px;
}
.zhengchang li a span{
	height:21px;
	display: inline-block;
    line-height: 21px;
    padding-right: 21px;
	background: url("themes/softed/images/sfa_blue.png") no-repeat scroll right -42px transparent;
}
.guoqi {
	float:left;	
}
.guoqi li{
	height:21px;
	float:left;
	background: url("themes/softed/images/sfa_gray.png") no-repeat scroll 0 0 transparent;
	list-style: none outside none;
	padding-top:1px;
}
.guoqi li a{
	height:21px;
	background: url("themes/softed/images/sfa_gray.png") repeat-x scroll 0 -21px transparent;
	display: inline-block;
    line-height: 21px;
    padding: 0 0 0 5px;
}
.guoqi li a span{
	height:21px;
	display: inline-block;
    line-height: 21px;
    padding-right: 21px;
	background: url("themes/softed/images/sfa_gray.png") no-repeat scroll right -42px transparent;
}
.jinxing {
	float:left;	
}
.jinxing li{
	height:21px;
	float:left;
	background: url("themes/softed/images/sfa_yello.png") no-repeat scroll 0 0 transparent;
	list-style: none outside none;
	padding-top:1px;
}
.jinxing li a{
	height:21px;
	background: url("themes/softed/images/sfa_yello.png") repeat-x scroll 0 -21px transparent;
	display: inline-block;
    line-height: 21px;
    padding: 0 0 0 5px;
}
.jinxing li a span{
	height:21px;
	display: inline-block;
    line-height: 21px;
    padding-right: 21px;
	background: url("themes/softed/images/sfa_yello.png") no-repeat scroll right -42px transparent;
}

li.sfasn {
    color: #000000;
    display: inline;
    float: left;
    font-family: 宋体;
    margin-bottom: 3px;
    white-space: nowrap;
}
li {
	line-height:150%;	
}
{/literal}
</style>
<table border=0 cellspacing=0 cellpadding=0 width=100% align=left >
<tr>
<td width="48%" valign="top">
<div style="float:left;width:100%;">
	<table border=0 cellspacing=0 cellpadding=0 width=100% align=left class="lvt small"  >
    <tr>
    <td  class="trbt">
    <b>7天内待联系客户(<font color=red>客户名称/下次联系时间</font>)</b>
    </td>
    </tr>
    <tr >
    <td class="tdw">
    
        <ul style="line-height:10px;margin-top:-5px;">
        {foreach item=nextcontactacc from=$NEXTCONTACTACCOUNT}
            &nbsp;&nbsp;<li >{$nextcontactacc}</li>
        {foreachelse}
         &nbsp;&nbsp;<li>暂无</li>
        {/foreach}
        </ul>
    </td>
    </tr>
    </table>
	
</div>
<div style="float:left; width:100%;padding-top:10px;">
     <table border=0 cellspacing=0 cellpadding=0 width=100% align=left class="lvt small">
    <tr>
    <td class="trbt">
     <b>需要我执行的SFA</b> <font color=red> (开始日期 ≤ 今天 ≤ 结束日期 和 不限定日期)</font>
    </td>
    </tr>
    <tr>
    <td class="tdw">
        <ul style="line-height:10px;margin-top:-5px;">
        {foreach item=do from=$SFALISTEVENTS_DO}
           &nbsp;&nbsp;<li >{$do}</li>
        {foreachelse}
         &nbsp;&nbsp;<li>暂无</li>
        {/foreach}
        </ul>
    </td>
    </tr>
    </table>
</div>
<div style="float:left;width:100%; padding-top:10px;">
    <table border=0 cellspacing=0 cellpadding=0 width=100% align=left class="lvt small"   >
    <tr>
    <td  class="trbt">
    <b>最近自动执行成功的SFA日志</b>
    </td>
    </tr>
    <tr >
    <td class="tdw">
        <ul style="line-height:10px;margin-top:-5px;">
        {foreach item=successlog from=$SFALISTEVENTS_SUCCESSLOG}
            &nbsp;&nbsp;<li >{$successlog}</li>
        {foreachelse}
         &nbsp;&nbsp;<li>暂无</li>
        {/foreach}
        </ul>
    </td>
    </tr>
    </table>
    </div>
</td>
<td width="1%" valign="top">&nbsp;</td>
<td valign="top"> 
<div style="float:left;width:100%;">
	<table border=0 cellspacing=0 cellpadding=0 width=100% align=left class="lvt small"   >
    <tr>
    <td  class="trbt">
    <b>一月内到期纪念日(<font color=red>客户名称/公历纪念日</font>)</b>
    </td>
    </tr>
    <tr >
    <td class="tdw">
    
        <ul style="line-height:10px;margin-top:-5px;">
        {foreach item=onemonthmemday from=$ONEMONTHMEMDAY}
            &nbsp;&nbsp;<li >{$onemonthmemday}</li>
        {foreachelse}
         &nbsp;&nbsp;<li>暂无</li>
        {/foreach}
        </ul>
    </td>
    </tr>
    </table>
</div>
<div style="float:left; width:100%;padding-top:10px;">
     <table border=0 cellspacing=0 cellpadding=0 width=100% align=right class="lvt small">
    <tr>
    <td  class="trbt">
    <b>执行失败的SFA</b>
    </td>
    </tr>
    <tr >
    <td class="tdw">
        <ul style="line-height:10px; margin-top:-5px;">
        {foreach item=failed from=$SFALISTEVENTS_FAILED}
            &nbsp;&nbsp;<li >{$failed}</li>
        {foreachelse}
         &nbsp;&nbsp;<li>暂无</li>
        {/foreach}
        </ul>
    </td>
    </tr>
    </table>
</div>
<div style="float:left; width:100%;padding-top:10px;">
     <table border=0 cellspacing=0 cellpadding=0 width=100% align=right class="lvt small">
    <tr>
    <td  class="trbt">
    <b>最近自动执行失败的SFA日志</b>
    </td>
    </tr>
    <tr >
    <td class="tdw">
        <ul style="line-height:10px; margin-top:-5px;">
        {foreach item=faillog from=$SFALISTEVENTS_FAILLOG}
            &nbsp;&nbsp;<li >{$faillog}</li>
        {foreachelse}
         &nbsp;&nbsp;<li>暂无</li>
        {/foreach}
        </ul>
    </td>
    </tr>
    </table>
</div>
<div style="float:left; width:100%;padding-top:10px;">
    <table border=0 cellspacing=0 cellpadding=0 width=100% align=left class="lvt small"   >
    <tr>
    <td  class="trbt">
    <b>SFA方案对应客户(未结束)</b>
    </td>
    </tr>
    <tr >
    <td class="tdw">
        <ul style="line-height:10px;margin-top:-5px;">
        {foreach item=acc from=$SFASETTINGACCOUNT}
            &nbsp;&nbsp;<li >{$acc}</li>
        {foreachelse}
         &nbsp;&nbsp;<li>暂无</li>
        {/foreach}
        </ul>
    </td>
    </tr>
    </table>
    </div>
</td>
</tr>
</table> 

<div style="clear:both;"></div>
 <div style="float:left; position:relative; z-index:1000;width:100%;padding-left:0px;padding-top:1px;">
	<table border=0 cellspacing=0 cellpadding=0 width=100% align=left class=" small" style="margin-top:10px;margin-bottom:100px;" >
    <tr>
    <td  class="trbt">
    <b>意向客户的SFA序列</b>
    &nbsp;&nbsp;&nbsp;&nbsp;图示【<img border="0" src="{$IMAGE_PATH}s31.png">成功<img border="0" src="{$IMAGE_PATH}s32.png">跳过<img border="0" src="{$IMAGE_PATH}s33.png">执行失败<img border="0" src="{$IMAGE_PATH}me.png">未执行/再次执行】
    </td>
    </tr>
    <tr >
    <td class="tdw">
        {foreach item=list_acc key=key from=$SFALISTACCOUNT}
        
                <div class="clear"></div>
                            &nbsp;&nbsp;<div style="height:25px;">{$list_acc}</div>
                    <div style="padding-left:35px;">
                     {foreach item=data from=$SFALIST_NOW_EVENTS_LIST.$key}
                        {$data}
                     {foreachelse}
                     &nbsp;&nbsp;暂无
                    {/foreach}
                     </div>
        {/foreach}
    </td>
    </tr>
    </table>
 </div>





<script>
{literal}
function openRunEvent(sfalisteventsid){
	var url = 'index.php?module=Sfalists&action=RunEvent&record='+sfalisteventsid;
	window.open (url,'openRunEvent','height=650,width=750,top=0,left=0,toolbar=no,menubar=no,scrollbars=yes, resizable=no,location=no, status=no')
}
 

{/literal}
</script>