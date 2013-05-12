<?php
global $log;
global $app_strings;
global $adb;
global $current_language;
global $current_user;
require_once('modules/CustomView/CustomView.php');
require_once('modules/CustomView/ListViewTop.php');
$html_contents = '';
$html_contents .= '<table border=0 cellspacing=0 cellpadding=2 width=100%><tr>';
$html_contents .=  '<td class="crmTableRow" align="left"><b>&nbsp;'.$app_strings['LBL_VIEW'].'</b></td>';
$html_contents .=  '<td class="crmTableRow" align="left"><b>&nbsp;'.$app_strings['LBL_MODULE'].'</b></td>';
$html_contents .=  '<td class="crmTableRow" align="left"><b>&nbsp;'.$app_strings['LBL_HOME_COUNT'].'</b></td></tr>';


$metriclists = getMetricListHome();
if(isset($metriclists))
{
	foreach ($metriclists as $metriclist)
	{
		$listquery = getListQuery($metriclist['module'],'',true);
		if(empty($listquery)) {
			if(is_file("modules/".$metriclist['module']."/".$metriclist['module'].".php")) {
				include_once("modules/".$metriclist['module']."/".$metriclist['module'].".php");
				$metric_focus = new $metriclist['module']();
				$listquery = $metric_focus->getListQuery('',true);
			}
		}
		$oCustomView = new CustomView($metriclist['module']);
		$metricsql = $oCustomView->getMetricsCvListQuery($metriclist['id'],$listquery,$metriclist['module']);
		$log->info("metricsql:".$metricsql);
		$metricresult = $adb->query($metricsql);		
		if($metricresult)
		{
			$rowcount = $adb->fetch_array($metricresult);
			if(isset($rowcount))
			{
				$html_contents .=  '<tr><td class="crmTableRow" align="left">&nbsp;<a href="index.php?action=index&module='.$metriclist['module'].'&viewname='.$metriclist['id'].'">'.$metriclist['name'].'</a></td><td class="crmTableRow" align="left">&nbsp;'.$app_strings[$metriclist['module']].'</td><td class="crmTableRow" align="left">&nbsp;'.$rowcount['count'].'</td></tr>';
			}
		}
		$oCustomView = null;
	}
}
$html_contents .= '</table>';


/** to get the details of a customview Entries
  * @returns  $metriclists Array in the following format
  * $customviewlist []= Array('id'=>custom view id,
  *                         'name'=>custom view name,
  *                         'module'=>modulename,
				'count'=>''
				   )	
 */
function getMetricListHome()
{
	global $adb,$current_user;
	$ssql = "select ec_customview.* from ec_customview inner join ec_tab on ec_tab.name = ec_customview.entitytype";
	$ssql .= " where ec_customview.setmetrics = 1 order by ec_customview.entitytype";
	$result = $adb->query($ssql);
	$num_rows = $adb->num_rows($result);
	$metricslist = array();
	for($i=0; $i<$num_rows; $i++)
	{
		$metricslist['id'] = $adb->query_result($result,$i,'cvid');
		$metricslist['name'] =  $adb->query_result($result,$i,'viewname');
		$metricslist['module'] = $adb->query_result($result,$i,'entitytype');
		$metricslist['count'] = '';
		$metriclists[] = $metricslist;
	}
	return $metriclists;
}
?>
