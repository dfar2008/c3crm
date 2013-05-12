		{include file='Buttons_List.tpl'}
                                <div id="searchingUI" style="display:none;">
                                        <table border=0 cellspacing=0 cellpadding=0 width=100%>
                                        <tr>
                                                <td align=center>
                                                <img src="{$IMAGE_PATH}searching.gif" alt="Searching... please wait"  title="Searching... please wait">
                                                </td>
                                        </tr>
                                        </table>

                                </div>
                        </td>
                </tr>
                </table>
        </td>
</tr>
</table>
{*<!-- Contents -->*}
<table class="list_table" style="margin-top: 2px;" border="0" cellpadding="3" cellspacing="1" width="100%">
<tbody>
  <tr>
    <td  colspan=3 bgcolor="#ffffff" valign="top">

<table border=0 cellspacing=0 cellpadding=0 width=100% align=center>
  <tr>
	<td valign="top" width=100% style="padding:2px;">
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
          <td width=85% align="left" valign=top>
           <!-- PUBLIC CONTENTS STARTS-->
          <div id="ListViewContents">
                {include file="SfaDesktops/ListViewEntries.tpl"}
          </div>
          </td>
	    </tr>
	  </table>
    </td>
   </tr>
</table>
<!-- New List -->
</td></tr></tbody></table>
