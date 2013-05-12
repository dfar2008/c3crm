<?php
//global $log;
//global $app_strings;
//global $adb;
//global $current_user;
include_once('include/feed/Parser.php');

///global $app_strings, $mod_strings, $theme, $currentModule;
$html_contents = '';
$html_contents .= '<table border=0 cellspacing=0 cellpadding=2 width=100%>';
$ftimeout = 60;
$fparser = new EC_Feed_Parser();
$fparser->ec_dofetch('http://www.c3crm.com/blog/?feed=rss2', $ftimeout);
$items = $fparser->get_items();
foreach($items as $item) {
	$html_contents .= '<tr><td align="left"><a href="'.$item->get_link().'" target="_blank">&nbsp;'.$item->get_title().'</a></td></tr>';
}
$html_contents .= '</table>';
?>
