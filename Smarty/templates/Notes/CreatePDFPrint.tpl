<link rel="stylesheet" type="text/css" href="{$THEME_PATH}style.css">
<table width="650" cellpadding="2" cellspacing="0" border="0" align=center>
<tr><td>
<!-- Contents -->
<table border=0 cellspacing=0 cellpadding=0 width=98% align=center>
<tr>
	<td valign=top></td>
	<td valign=top width=100%>
		<div class="small" style="padding:10px" >
		<table border=0 cellspacing=0 cellpadding=0 width=95% align=center>
		<tr>
			<td>
				<table border=0 cellspacing=0 cellpadding=3 width=100% class="small">
				<tr>
					<td class="dvtTabCache" style="width:10px" nowrap>&nbsp;</td>
					
					<td class="dvtSelectedCell" align=center nowrap>{$APP.Note}{$APP.LBL_INFORMATION}</td>	
					<td class="dvtTabCache" style="width:10px">&nbsp;</td>
					<td class="dvtTabCache" style="width:100%">&nbsp;</td>					
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td valign=top align=left >
                <table border=0 cellspacing=0 cellpadding=3 width=100% class="dvtContentSpace">
				<tr>

					<td align=left>
					<!-- content cache -->
					
				<table border=0 cellspacing=0 cellpadding=0 width=100%>
                <tr>
					<td style="padding:5px">
					<!-- Command Buttons -->
				<form action="index.php" method="post" name="DetailView" id="form">
					
				    <table border=0 cellspacing=0 cellpadding=0 width=100%>
					{strip}<tr>
					<td  colspan=4 style="padding:5px">		
					
						

							</td>
						     </tr>{/strip}
						     <tr><td>
							{foreach key=header item=detail from=$BLOCKS}
							<!-- Detailed View Code starts here-->
							<table border=0 cellspacing=0 cellpadding=0 width=100% class="small">
							<tr>
							<td width="20%">&nbsp;</td><td width="30%">&nbsp;</td>
							<td width="20%">&nbsp;</td><td width="30%">&nbsp;</td>
							
							</tr>
							
						     <tr>{strip}
						     <td colspan=6 class="dvInnerHeader">
							<b>
						        	{$header}
	  			     			</b>
						     </td>{/strip}
					             </tr>
						   {foreach item=detail from=$detail}
						     <tr style="height:25px">
							{foreach key=label item=data from=$detail}
							   {assign var=keyid value=$data.ui}
							   {assign var=keyval value=$data.value}
							   {assign var=keyseclink value=$data.link}
							   {if $label ne ''}
							    <td class="dvtCellLabel" align=right>{$label}</td>								
							    {include file="DetailViewFields.tpl"}
							   {/if}
                                                        {/foreach}
						      </tr>	
						   {/foreach}	
						   </table>
                     	                      </td>
					   </tr>
		<tr>                                                                                                               <td style="padding:10px">
			{/foreach}
                    {*-- End of Blocks--*} 
			</td>
                </tr>
	   
			
</form>
			
		</table>
		</td>	
		
		</tr>
		</table>
		
		</div>
		<!-- PUBLIC CONTENTS STOPS-->
	</td>
</tr>
</table>
</td>
</tr></table>
</td>
	<td align=right valign=top></td>
</tr></table>