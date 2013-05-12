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

//Make a count query
function mkCountQuery($query)
{
    // Remove all the \n, \r and white spaces to keep the space between the words consistent. 
    // This is required for proper pattern matching for words like ' FROM ', 'ORDER BY', 'GROUP BY' as they depend on the spaces between the words.
    $query = preg_replace("/[\n\r\s]+/"," ",$query);
    
    //Strip of the current SELECT fields and replace them by "select count(*) as count"
    // Space across FROM has to be retained here so that we do not have a clash with string "from" found in select clause
    $query = "SELECT count(1) AS count ".substr($query, stripos($query,' FROM '),strlen($query));

    //Strip of any "GROUP BY" clause
    if(stripos($query,'GROUP BY') > 0)
	$query = substr($query, 0, stripos($query,'GROUP BY'));

    //Strip of any "ORDER BY" clause
    if(stripos($query,'ORDER BY') > 0)
	$query = substr($query, 0, stripos($query,'ORDER BY'));

    //That's it
    return( $query);
}

//Added for PHP version less than 5
if (!function_exists("stripos"))
{
	function stripos($query,$needle)
	{
		return strpos(strtolower($query),strtolower($needle));
	}
}

?>
