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

<table border=0 cellspacing=0 cellpadding=5 width=95% align=center> 
	<tr>
		<td class=small >		
			<!-- popup specific content fill in starts -->
	     
				<table border=0 celspacing=0 cellpadding=5 width=100% align=center bgcolor=white  class="small">
				<tr>
             	   <td width="40%" valign="top" align="center">		
					 方案名称: 
					</td>
					<td width="60%" valign="top" align="left">		
					<select id="sfasettingsid" name="sfasettingsid">
                    		<option value="0">--请选择方案--</option>
                        	{$sfasettingshtml}
                    </select>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>


