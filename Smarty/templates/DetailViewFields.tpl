		{if $keyid eq '1' || $keyid eq 2 || $keyid eq '11' || $keyid eq '7' || $keyid eq '9' || $keyid eq '55' || $keyid eq '71' || $keyid eq '72'} <!--TextBox-->
                                         	  <td class="dvn">&nbsp;
							         { if $data.fldname eq 'phone' || $data.fldname eq 'contactmobile'}
                                 	 <a href="index.php?module=Qunfas&action=ListView&idstring={$ID}&modulename={$MODULE}" target="main">{$keyval}</a>
                                      {else}
                                         {$keyval} 
                                      {/if}                                            
                                                  </td>
                                             {elseif $keyid eq '13'} <!--Email-->
                                                  <td class="dvn">&nbsp;
						 					 <a href="index.php?module=Maillists&action=ListView&idstring={$ID}&modulename={$MODULE}" target="main">{$keyval}</a>
                                                  </td>
                                             {elseif $keyid eq '15' || $keyid eq '16' || $keyid eq '111'} <!--ComboBox-->
               							<td class="dvn">&nbsp;{$keyval}
               							</td>
                                              {elseif $keyid eq '1021' || $keyid eq '1022' || $keyid eq '1023'} <!--ComboBox-->
               							<td width=25% class="dvtCellInfo" align="left" id="mouseArea_{$label}" >&nbsp;<span id="dtlview_{$label}">{$keyval}</span></td>
                                             {elseif $keyid eq '17'} <!--WebSite-->
                                                  <td class="dvn">&nbsp;<a href="{$keyval}" target="_blank">{$keyval}</a>
                                                  </td>
					     {elseif $keyid eq '85'}<!--Skype-->
                                                <td class="dvn">&nbsp;<img src="{$IMAGE_PATH}skype.gif" alt="Skype" title="Skype" LANGUAGE=javascript align="absmiddle"></img><a href="skype:{$keyval}?call" target=_blank>{$keyval}</a></td>
					     {elseif $keyid eq '86'}<!--QQ-->
					        {if $keyval neq ''}
                                                <td class="dvn">&nbsp;<a target="blank" href="http://wpa.qq.com/msgrd?V=1&Uin={$keyval}&Site=CRMONE&Menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=1:{$keyval}:4"  align="absmiddle">{$keyval}</a></td>
						{else}
						<td class="dvn">&nbsp;<img border="0" src="{$IMAGE_PATH}qq.gif"  align="absmiddle">{$keyval}</td>
						{/if}
					     {elseif $keyid eq '87'}<!--MSN-->
                                                <td class="dvn">&nbsp;<img src="{$IMAGE_PATH}msn.jpg" alt="MSN" title="MSN" LANGUAGE=javascript align="absmiddle"></img><span id="dtlview_{$label}"><a href="msnim:chat?contact={$keyval}" target=_blank>{$keyval}</a></td>	
					     {elseif $keyid eq '88'}<!--wangwang-->
                                                <td class="dvn">&nbsp;<a target=_blank href='http://amos.im.alisoft.com/msg.aw?v=2&uid={$keyval}&site=cnalichn&s=4&charset=utf-8'><img border=0 src='http://amos.im.alisoft.com/online.aw?v=2&uid={$keyval}&site=cnalichn&s=4&charset=utf-8'>{$keyval}</a></td>	
					     {elseif $keyid eq '89'}<!--YAHOO-->
                                                <td class="dvn">&nbsp;<img src="{$IMAGE_PATH}yahoo.gif" alt="YAHOO" title="YAHOO" LANGUAGE=javascript align="absmiddle"></img><a href="ymsgr:sendIM?{$keyval}" target=_blank>{$keyval}</a></td>	
                                             {elseif $keyid eq '19' || $keyid eq '20'} <!--TextArea/Description-->
                                                  <td width="75%" colspan="3" class="dvtCellInfo" align="left">{$keyval|nl2br}                   
                                                  </td>
                                             {elseif $keyid eq '21' || $keyid eq '24' || $keyid eq '22'} <!--TextArea/Street-->
                                                  <td class="dvn">{$keyval|nl2br}
                                                  </td>
                                             {elseif $keyid eq '50' || $keyid eq '73' || $keyid eq '51' || $keyid eq '57' || $keyid eq '59' || $keyid eq '75' || $keyid eq '81' || $keyid eq '76' || $keyid eq '78' || $keyid eq '80' || $keyid eq '1010'} <!--AccountPopup-->
                                                  <td class="dvn">&nbsp;<a href="{$keyseclink}">{$keyval}</a>
                                                  </td>
					     {elseif $keyid eq 1004} <!--Creator-->
                                                  <td class="dvn">&nbsp;{$keyval}
                                                  </td>
                                             {elseif $keyid eq 82} <!--Email Body-->
                                                  <td colspan="3" width=100% class="dvn">&nbsp;{$keyval}
                                                  </td>
					{elseif $keyid eq '53'} <!--Assigned To-->
                    <td class="dvn">&nbsp;
				{$keyval}                    
                    </td>
		    {elseif $keyid eq '56'} <!--CheckBox--> 
                      <td class="dvn">{$keyval}&nbsp;
                        </td>
	

				{elseif $keyid eq 69}<!-- for Image Reflection -->
                                                  	<td align="left" width="25%">&nbsp;{$keyval}</td>
				{else}									
                                                  	
							{if $keyseclink neq ''}
								<td  class="dvn" align="left" id="mouseArea_{$label}">&nbsp;<a href="{$keyseclink}">{$keyval}</a></td>
							{else}
								<td class="dvn" align="left">&nbsp;{$keyval}</td>
							{/if}
				{/if}
