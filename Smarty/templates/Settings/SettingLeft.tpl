<div class="accordion-group">
	<div class="accordion-heading">
		<a class="accordion-toggle" data-toggle="collapse" data-parent="#settingion1"  href="#collapseOne">
		  {$RELSETHEAD}
		</a>
	</div>
	<div id="collapseOne" class="accordion-body collapse in">
		<div class="accordion-inner">
			<ul class="nav nav-list">
				
				{if $SETTYPE eq "SmsUser"}
				<li class="active">
					<a href="index.php?module=Settings&action=SmsUser">
						{$MOD.LBL_SMS_USER}
					</a>
				</li>
				{else}
				<li>
					<a href="index.php?module=Settings&action=SmsUser">
						{$MOD.LBL_SMS_USER}
					</a>
				{/if}
				</li>
				{if $SETTYPE eq "CustomFieldList"}
				<li class="active">
					<a href="index.php?module=Settings&action=CustomFieldList">
						{$MOD.LBL_CUSTOM_FIELDS}
					</a>
				</li>
				{else}
				<li>
					<a href="index.php?module=Settings&action=CustomFieldList">
						{$MOD.LBL_CUSTOM_FIELDS}
					</a>
				</li>
				{/if}
				{if $SETTYPE eq "PickList"}
				<li class="active">
					<a href="index.php?module=Settings&action=PickList">
						{$MOD.LBL_PICKLIST_EDITOR}
					</a>
				</li>
				{else}
				<li>
					<a href="index.php?module=Settings&action=PickList">
						{$MOD.LBL_PICKLIST_EDITOR}
					</a>
				<li>
				{/if}
				{if $SETTYPE eq "SmsTcManage"}
				<li class="active">
					<a href="index.php?module=Settings&action=SmsTcManage">
						{$MOD.LBL_SMS_TC_MANAGE}
					</a>
				</li>
				{else}
				<li>
					<a href="index.php?module=Settings&action=SmsTcManage">
						{$MOD.LBL_SMS_TC_MANAGE}
					</a>
				<li>
				{/if}
				{if $SETTYPE eq "LayoutList"}
				<li class="active">
					<a href="index.php?module=Settings&action=LayoutList">
						{$MOD.LBL_LAYOUT_EDITOR}
					</a>
				</li>
				{else}
				<li>
					<a href="index.php?module=Settings&action=LayoutList">
						{$MOD.LBL_LAYOUT_EDITOR}
					</a>
				<li>
				{/if}
				{if $SETTYPE eq "DefaultFieldPermissions"}
				<li class="active">
					<a href="index.php?module=Settings&action=DefaultFieldPermissions">
						{$MOD.LBL_FIELDS_ACCESS}
					</a>
				</li>
				{else}
				<li>
					<a href="index.php?module=Settings&action=DefaultFieldPermissions">
						{$MOD.LBL_FIELDS_ACCESS}
					</a>
				<li>
				{/if}

			</ul>
		</div>
	</div>
</div>