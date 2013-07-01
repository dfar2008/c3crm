<div class="accordion-group">
	<div class="accordion-heading">
		<a class="accordion-toggle" data-toggle="collapse" data-parent="#settingion1"  href="#collapseOne">
		  {$RELSETHEAD}
		</a>
	</div>
	<div id="collapseOne" class="accordion-body collapse in">
		<div class="accordion-inner">
			<ul class="nav nav-list">
				{foreach item=setarr key=setkey from=$SETTYPEARRAY}
					{if $SETTYPE == $setkey}
						{assign var=cssactive value="active"}
					{else}
						{assign var=cssactive value=""}
					{/if}
					<li class="{$cssactive}">
						<a href="index.php?module=Settings&action=index&settype={$SETTYPE}">
							{$setarr}
						</a>
					</li>
				{/foreach}
			</ul>
		</div>
	</div>
</div>