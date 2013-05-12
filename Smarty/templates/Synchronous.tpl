<form action="index.php" method="post" name="ShopConfig" id="form" onsubmit="return validate(ShopConfig);">
<input type="hidden" name="module" value="Accounts">
<input type="hidden" name="action" value="Synchronousaccounts">
<table style="background-color: rgb(234, 234, 234);margin-top:-16px;" class="small" width="100%" border="0" cellpadding="3" cellspacing="1">
 <tr style="height: 25px;" bgcolor="white">
    <td width="100%" colspan="2" class="detailedViewHeader" style="font-weight:bolder;">
    	{$title} >>
        {if $connection != ''}
    		&nbsp;{$connection}
    	{/if}
    </td>
  </tr>
  <tr bgcolor="white" style="height: 25px;">
   <td class="dvtCellLabel" align="right" style="width:40%">&nbsp;选择店铺:</td>
    <td width="100%"  align="left">
    <select name="shopid">
    {foreach from=$LISTENTRIES item=shop}
    {if $shop[0] eq $shopid}
    	{assign var="selectedinfo"  value="selected"}
    {else}
    	{assign var="selectedinfo"  value=" "}
    {/if}
    <option value="{$shop[0]}" {$selectedinfo}>{$shop[1]}</option>
    {/foreach}
    </select>
  <a href="javascript:;" onclick="window.opener.location.href='index.php?module=Relsettings&action=ShopConfig&parenttab=Settings';return false;" ><span style="font-size:12px;color:#F00">设置店铺</span></a>
   </td>
  </tr>
  <tr bgcolor="white" style="height: 25px;">
   <td class="dvtCellLabel" align="right" style="width:40%"></td>
    <td width="100%"  align="left">
   <input type="submit" class="crmButton small edit" value=" 开始同步 "  name="submit" >
   </td>
  </tr>
    <tr bgcolor="white" style="height: 25px;">
  
   <td class="dvtCellLabel" align="right" style="width:20%">&nbsp;</td>

   <td width="100%" colspan="{$count}" align="left">
   
  	 <div id="showmessage">
     </div>
     {if  $message neq ''}
   		{$message} <br>
   	{/if}
    {if  $importresult neq ''}
   		{$importresult} <br>
   	{/if}
     {if $errormess neq ''}
    	{$errormess} <br>
    {/if}
    
   </td>

  </tr>
  </table>
</form>
