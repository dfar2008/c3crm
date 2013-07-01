<?php
global $mod_strings;
$count = clear_cache_files();
//echo "<center><font siez=15><b>".$mod_strings["LBL_CLEAR_DATABASE_CACHE"]."</b></font></center>";
echo "<script language=javascript>alert('".$mod_strings["LBL_CLEARED_DATABASE_CACHE"]."');document.location.href='index.php?module=Settings&action=index';</script>";
?>