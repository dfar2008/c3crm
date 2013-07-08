<div class="container-fluid" style="height:602px;">
	   <!--Dashboad-->
	<div class="container-fluid" style="height:602px;">
		<div class="row-fluid">
			<div class="span2" style="margin-left:-10px;">
				<div class="accordion" id="settingion1" style="overflow:auto;height:580px;">
					{include file='Settings/SettingLeft.tpl'}
				</div>
			</div>

			<div class="span10" style="margin-left:10px;">
				<!--	Setting		-->
				<div class="row-fluid box" style="height:602px;">
					<div class="tab-header">
						{$RELSETHEAD}
					</div>
					  <div class="padded" style="overflow:auto;height:520px;">

							<form action="index.php" method="post" name="settingform" id="settingform">
								<input type="hidden" name="module" value="Settings">
								<input type="hidden" name="action">
								<input type="hidden" name="parenttab" value="Settings">
								<input type="hidden" name="settype" value="{$SETTYPE}">
								<input type="hidden" name="settingmode" value="{$SETTINGMODE}">
								<input type="hidden" name="issubmit" value="1">
								{if $SETTYPE == 'SmsUser'}
									{include file='Settings/SmsUser.tpl'}
								{elseif $SETTYPE == 'CustomBlockList'}
									{include file='Settings/CustomBlockList.tpl'}
								{/if}
							</form>
					  </div>
				</div>
					
				</div>
				<!--	/Setting	-->
			</div>
	</div></div>
</div>