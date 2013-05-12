<?php
/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Public License Version 1.1.2
 * ("License"); You may not use this file except in compliance with the
 * License. You may obtain a copy of the License at http://www.sugarcrm.com/SPL
 * Software distributed under the License is distributed on an  "AS IS"  basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License for
 * the specific language governing rights and limitations under the License.
 * The Original Code is:  SugarCRM Open Source
 * The Initial Developer of the Original Code is SugarCRM, Inc.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.;
 * All Rights Reserved.
 * Contributor(s): ______________________________________.
 ********************************************************************************/
/*********************************************************************************
 * $Header$
 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

      /** to get the details of a KeyMetrics on Home page 
        * @returns  $customviewlist Array in the following format
	* $values = Array('Title'=>Array(0=>'image name',
	*				 1=>'Key Metrics',
	*			 	 2=>'home_metrics'
	*			 	),
	*		  'Header'=>Array(0=>'Metrics',
	*	  			  1=>'Count'
	*			  	),
	*		  'Entries'=>Array($cvid=>Array(
	*			  			0=>$customview name,
	*						1=>$no of records for the view
	*					       ),
	*				   $cvid=>Array(
        *                                               0=>$customview name,
        *                                               1=>$no of records for the view
        *                                              ),
	*					|
	*					|
        *				   $cvid=>Array(
        *                                               0=>$customview name,
        *                                               1=>$no of records for the view
        *                                              )	
	*				  )
	*
       */
function getKeyMetrics()
{
	require_once("data/Tracker.php");
	require_once('modules/CustomView/CustomView.php');
	require_once('include/logging.php');
	require_once('include/ListView/ListView.php');

	global $app_strings;
	global $adb;
	global $log;
	global $current_language;
	$metricviewnames = "'Hot Leads'";

	$current_module_strings = return_module_language($current_language, "CustomView");
	$log = LoggerManager::getLogger('metrics');

	$metriclists = getMetricList();
	$log->info("Metrics :: Successfully got MetricList to be displayed");
	if(isset($metriclists))
	{
		foreach ($metriclists as $key => $metriclist)
		{
			$listquery = getListQuery($metriclist['module']);
			if(empty($listquery)) {
				if(is_file("modules/".$metriclist['module']."/".$metriclist['module'].".php")) {
					include_once("modules/".$metriclist['module']."/".$metriclist['module'].".php");
					$metric_focus = new $metriclist['module']();
					$listquery = $metric_focus->getListQuery('');
				}
			}
			$oCustomView = new CustomView($metriclist['module']);
			$metricsql = $oCustomView->getMetricsCvListQuery($metriclist['id'],$listquery,$metriclist['module']);
			$metricresult = $adb->query($metricsql);
			if($metricresult)
			{
				$rowcount = $adb->fetch_array($metricresult);
				if(isset($rowcount))
				{
					$metriclists[$key]['count'] = $rowcount['count'];
				}
			}
		}
		$log->info("Metrics :: Successfully build the Metrics");
	}
	$title=array();
	$title[]='keyMetrics.gif';
	$title[]=$app_strings['LBL_HOME_KEY_METRICS'];
	$title[]='home_metrics';
	$header=Array();
	$header[]=$app_strings['LBL_HOME_METRICS'];
	$header[]=$app_strings['LBL_HOME_COUNT'];
	$entries=Array();
	if(isset($metriclists))
	{
		$oddRow = true;
		foreach($metriclists as $metriclist)
		{
			$value=array();
			$metric_fields = array(
					'ID' => $metriclist['id'],
					'NAME' => $metriclist['name'],
					'COUNT' => $metriclist['count'],
					'MODULE' => $metriclist['module']
					);

			$value[]='<a href="index.php?action=index&module='.$metriclist['module'].'&viewname='.$metriclist['id'].'">'.$metriclist['name'].'</a>';
			$value[]='<a href="index.php?action=index&module='.$metriclist['module'].'&viewname='.$metriclist['id'].'">'.$metriclist['count'].'</a>';
			$entries[$metriclist['id']]=$value;
		}

	}
	$values=Array('Title'=>$title,'Header'=>$header,'Entries'=>$entries);
	//if ( ($display_empty_home_blocks ) || (count($value)!= 0) )
	return $values;

}
	
	/** to get the details of a customview Entries
	  * @returns  $metriclists Array in the following format
	  * $customviewlist []= Array('id'=>custom view id,
	  *                         'name'=>custom view name,
	  *                         'module'=>modulename,
	  			    'count'=>''
			           )	
	 */
function getMetricList()
{
	global $adb;
	$ssql = "select ec_customview.* from ec_customview inner join ec_tab on ec_tab.name = ec_customview.entitytype";
	$ssql .= " where ec_customview.setmetrics = 1 order by ec_customview.entitytype";
	$result = $adb->query($ssql);
	while($cvrow=$adb->fetch_array($result))
	{
		$metricslist = Array();

		$metricslist['id'] = $cvrow['cvid'];
		$metricslist['name'] = $cvrow['viewname'];
		$metricslist['module'] = $cvrow['entitytype'];
		$metricslist['count'] = '';
		if(isPermitted($cvrow['entitytype'],"index") == "yes")
			$metriclists[] = $metricslist;
	}

	return $metriclists;
}

?>
