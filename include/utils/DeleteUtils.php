<?php
function DeleteEntity($module,$return_module,$focus,$record,$return_id)
{
	
	$focus->mark_deleted($record);
}
?>
