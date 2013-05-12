{*<!--
/*********************************************************************************
  ** The contents of this file are subject to the vtiger CRM Public License Version 1.0
   * ("License"); You may not use this file except in compliance with the License
   * The Original Code is:  vtiger CRM Open Source
   * The Initial Developer of the Original Code is vtiger.
   * Portions created by vtiger are Copyright (C) vtiger.
   * All Rights Reserved.
  *
 ********************************************************************************/
-->*}
<script language="JAVASCRIPT" type="text/javascript" src="include/js/smoothscroll.js"></script>
<script language="JavaScript" type="text/javascript" src="include/js/menu.js"></script>
<br>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
<tbody>
	<tr>
    <td class="showPanelBg" style="padding: 10px;" valign="top" width="100%">
	
	<div align=center>
				<!-- DISPLAY -->
				<table border=0 cellspacing=0 cellpadding=5 width=100% class="settingsSelUITopLine">
				<tr>
					<td width=50 rowspan=2 valign=top><img src="{$IMAGE_PATH}ico_mobile.gif" alt="Users" width="48" height="48" border=0 title="Users"></td>
					<td class=heading2 valign=bottom><b><a href="index.php?module=Relsettings&action=index&parenttab=Settings">{$MOD.LBL_RELSETTINGS}</a> > {$MOD.LBL_MEMDAY_SETTINGS} </b></td>
				</tr>
				<tr>
					<td valign=top class="small">{$MOD.LBL_MEMDAY_SETTINGS} </td>
				</tr>
				</table>
				
				<br>
                	<table border=0 cellspacing=1 cellpadding=3 width=99% align="center">
                		<tr>
                            <td><input type="button" value="新增" name="button" class="crmbutton small create" onclick="javascript:location.href='index.php?module=Relsettings&action=MemdayConfigEdit'"/></td>
                            <td align="right"><input type="button" onclick="window.location.reload();" value=" 刷新 " class="crmbutton small edit"></td>
                        </tr>
                       </table>
                     <table border=0 cellspacing=1 cellpadding=3 width=99% align="center" class="lvt small" >
                       
                       <tr>
                            {foreach name="listviewforeach" item=header from=$LISTHEADER}
                                <td class="lvtCol" nowrap="nowrap">{$header}</td>
                            {/foreach}
                        </tr>
                        <!-- Table Contents -->
                        {foreach item=entity key=entity_id from=$LISTENTITY}
                           <tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" id="row_{$entity_id}">
                            {foreach item=data from=$entity}	
                            <td>{$data}</td>
                            {/foreach}
                          </tr>
                          {foreachelse}
                       	   <tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" >
                            <td colspan="{$countnheader}" align="center" height="30">--无--</td>
                          </tr>
                        {/foreach}
                        <tr>
                        <td colspan="6">
                        备注: 
                        1.同一纪念日类型只能创建一个提醒模板。
                        </td>
                        </tr>
                    </table>
                  
					
				</td>
				</tr>
				</table>
						
			</td>
			</tr>
			</table>
		</td>
	</tr>
	</table>
		
	</div>
	
</td>
   </tr>
</tbody>
</table>
{literal}
<script>

</script>
{/literal}
