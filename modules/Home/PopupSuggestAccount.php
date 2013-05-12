<ul>
<?php
require_once('config.php');
require_once('include/utils/utils.php');
require_once('include/database/PearDatabase.php');
global $adb;
$paramValue = trim($_REQUEST['account']);

$query="select accountname from ec_account where deleted=0 and accountname like '%".$paramValue."%'";
$result = $adb->limitQuery2($query,0,5,"ec_account.prefix","");
$no_rows=$adb->num_rows($result);
for($i=0;$i<$no_rows;$i++)
{
	$user_name=$adb->query_result($result,$i,"accountname");
	echo "<li>".$user_name."</li>";
	

}
?>
</ul>