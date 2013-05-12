<script type="text/javascript" src="modules/{$MODULE}/{$SINGLE_MOD}.js"></script>
{literal}
<script>
function getTabViewForRelated(ID){ 
	var typeid = document.getElementById("typeid").value;
	document.getElementById(typeid).className="tablink";
	document.getElementById(ID).className="tablink selected";
	document.getElementById(typeid+"1").style.display = "none";
	document.getElementById(ID+"1").style.display = "";
	document.getElementById("typeid").value = ID;
}
{/literal}
</script>

<!-- Contents -->
<div id="editlistprice" style="position:absolute;width:300px;"></div>
		<!-- PUBLIC CONTENTS STARTS-->
		
			<!-- Account details tabs -->
			<tr>
				<td valign=top align=left >
					<div class="small" style="padding:5px">
		                	<table border=0 cellspacing=0 cellpadding=3 width=100% >
						<tr>
							<td valign=top align=left>
							<!-- content cache -->
								<table border=0 cellspacing=0 cellpadding=0 width=100%>
									<tr>
										<td >
										   <!-- General details -->
												{include file='RelatedListsHidden.tpl'}
												<div id="RLContents">
					                                 {include file='RelatedListContents.tpl'}
                                        		</div>
												</form>
										  {*-- End of Blocks--*} 
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					</div>
				</td>
			</tr>
	<!-- PUBLIC CONTENTS STOPS-->

