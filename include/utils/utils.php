<?php
require_once('include/database/PearDatabase.php');
require_once('include/utils/ListViewUtils.php');	
require_once('include/utils/EditViewUtils.php');
require_once('include/utils/DetailViewUtils.php');
require_once('include/utils/CommonUtils.php');
require_once('include/utils/DeleteUtils.php');
require_once('include/utils/SearchUtils.php');
 //added by dingjianting on 2007-7-30 for open source license
 
/** Function to return a full name
  * @param $row -- row:: Type integer
  * @param $first_column -- first column:: Type string
  * @param $last_column -- last column:: Type string
  * @returns $fullname -- fullname:: Type string 
  *
*/
function return_name(&$row, $first_column, $last_column)
{
	global $log;
	$log->debug("Entering return_name() method ...");
	$first_name = "";
	$last_name = "";
	$full_name = "";

	if(isset($row[$first_column]))
	{
		$first_name = stripslashes($row[$first_column]);
	}

	if(isset($row[$last_column]))
	{
		$last_name = stripslashes($row[$last_column]);
	}

	$full_name = $first_name;

	// If we have a first name and we have a last name
	if($full_name != "" && $last_name != "")
	{
		// append a space, then the last name
		$full_name .= $last_name;
	}
	// If we have no first name, but we have a last name
	else if($last_name != "")
	{
		// append the last name without the space.
		$full_name .= $last_name;
	}

	$log->debug("Exiting return_name method ...");
	return $full_name;
}

/** Function to return language 
  * @returns $languages -- languages:: Type string 
  *
*/

function get_languages()
{
	global $log;
	$log->debug("Entering get_languages() method ...");
	global $languages;
	$log->debug("Exiting get_languages method ...");
	return $languages;
}

/** Function to return language 
  * @param $key -- key:: Type string
  * @returns $languages -- languages:: Type string 
  *
*/

//seems not used
function get_language_display($key)
{
	global $log;
	$log->debug("Entering get_language_display() method ...");
	global $languages;
	$log->debug("Exiting get_language_display method ...");
	return $languages[$key];
}

/** Function returns the user array 
  * @param $assigned_user_id -- assigned_user_id:: Type string
  * @returns $user_list -- user list:: Type array 
  *
*/

function get_assigned_user_name(&$assigned_user_id)
{
	global $log;
	$log->debug("Entering get_assigned_user_name() method ...");
	$user_list = &get_user_array(false,"");
	if(isset($user_list[$assigned_user_id]))
	{
		$log->debug("Exiting get_assigned_user_name method ...");
		return $user_list[$assigned_user_id];
	}

	$log->debug("Exiting get_assigned_user_name method ...");
	return "";
}

/** Function returns the user key in user array 
  * @param $add_blank -- boolean:: Type boolean
  * @param $status -- user status:: Type string
  * @param $assigned_user -- user id:: Type string
  * @param $private -- sharing type:: Type string
  * @returns $user_array -- user array:: Type array 
  *
*/

//used in module file
function get_user_array($add_blank=true, $status="Active", $assigned_user="",$private="")
{
	global $log,$adb;
	$log->debug("Entering get_user_array() method ...");
	global $current_user;

	static $user_array = null;
	$module = $_REQUEST['module'];

	if($user_array == null)
	{
		$temp_result = Array();
		// Including deleted ec_users for now.
		if (empty($status)) {
				$query = "SELECT id, user_name from ec_users where deleted=0 and status='Active'";
				if (!empty($assigned_user)&&is_numeric($assigned_user)) {
					 $query .= " OR id='$assigned_user'";
				}
		}
		else {
				if($private == 'private')
				{
					$query = "select id as id,user_name as user_name,ec_users.prefix from ec_users where id=".$current_user->id." and status='Active' union select ec_user2role.userid as id,ec_users.user_name as user_name,ec_users.prefix from ec_user2role inner join ec_users on ec_users.id=ec_user2role.userid inner join ec_role on ec_role.roleid=ec_user2role.roleid where ec_role.parentrole like '".$current_user_parent_role_seq."::%' and status='Active' ";	
					if (!empty($assigned_user) && is_numeric($assigned_user)) {
						 $query .= " OR id='$assigned_user'";
					}
					$query = "select * from (".$query.") as ec_unionuser";
						
				}
				else
				{
					$query = "SELECT id, user_name from ec_users WHERE deleted=0 and status='$status'";
					if (!empty($assigned_user) && is_numeric($assigned_user)) {
						 $query .= " OR id='$assigned_user'";
					}
				}
		}
		

		$query .= " order by prefix ASC";

		$result = $adb->getList($query, true, "Error filling in user array: ");

		if ($add_blank==true){
			// Add in a blank row
			$temp_result[''] = '';
		}
		foreach($result as $row)
		{
			$temp_result[$row['id']] = $row['user_name'];
		}

		$user_array = &$temp_result;
	}

	$log->debug("Exiting get_user_array method ...");
	return $user_array;
}

/** Function skips executing arbitary commands given in a string
  * @param $string -- string:: Type string
  * @param $maxlength -- maximun length:: Type integer
  * @returns $string -- escaped string:: Type string 
  *
*/

function clean($string, $maxLength)
{
	global $log;
	$log->debug("Entering clean() method ...");
	$string = substr($string, 0, $maxLength);
	$log->debug("Exiting clean method ...");
	return escapeshellcmd($string);
}

/**
 * Copy the specified request variable to the member variable of the specified object.
 * Do no copy if the member variable is already set.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 */
function safe_map($request_var, & $focus, $always_copy = false)
{
	global $log;
	//changed by dingjianting on 2007-11-05 for php5.2.x
	$log->debug("Entering safe_map() method ...");
	safe_map_named($request_var, $focus, $request_var, $always_copy);
	$log->debug("Exiting safe_map method ...");
}

/**
 * Copy the specified request variable to the member variable of the specified object.
 * Do no copy if the member variable is already set.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 */
function safe_map_named($request_var, & $focus, $member_var, $always_copy)
{
	global $log;
	$log->debug("Entering safe_map_named() method ...");
	if (isset($_REQUEST[$request_var]) && ($always_copy || is_null($focus->$member_var))) {
		$focus->$member_var = $_REQUEST[$request_var];
	}
	$log->debug("Exiting safe_map_named method ...");
}

/** This function retrieves an application language file and returns the array of strings included in the $app_list_strings var.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 * If you are using the current language, do not call this function unless you are loading it for the first time */

function return_app_list_strings_language($language)
{
	global $log;
	$log->debug("Entering return_app_list_strings_language() method ...");
	global $app_list_strings, $default_language, $log, $translation_string_prefix;
	$temp_app_list_strings = $app_list_strings;
	$language_used = $language;

	@include("include/language/$language.lang.php");
	if(!isset($app_list_strings))
	{
		$log->warn("Unable to find the application language file for language: ".$language);
		require("include/language/$default_language.lang.php");
		$language_used = $default_language;
	}
	if(is_file("cache/application/language/$language.lang.php"))
    {
        include("cache/application/language/$language.lang.php");
    }

	if(!isset($app_list_strings))
	{
		$log->fatal("Unable to load the application language file for the selected language($language) or the default language($default_language)");
		$log->debug("Exiting return_app_list_strings_language method ...");
		return null;
	}


	$return_value = $app_list_strings;
	$app_list_strings = $temp_app_list_strings;

	$log->debug("Exiting return_app_list_strings_language method ...");
	return $return_value;
}

/** This function retrieves an application language file and returns the array of strings included.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 * If you are using the current language, do not call this function unless you are loading it for the first time */
function return_application_language($language)
{
	global $log;
	$log->debug("Entering return_application_language() method ...");
	global $app_strings, $default_language,$translation_string_prefix;
	$temp_app_strings = $app_strings;
	$language_used = $language;
	include("include/language/$language.lang.php");
	if(!isset($app_strings))
	{
		$log->warn("Unable to find the application language file for language: ".$language);
		require("include/language/$default_language.lang.php");
		$language_used = $default_language;
	}

	if(is_file("cache/application/language/$language.lang.php"))
    {
        include("cache/application/language/$language.lang.php");
    }

	if(is_file("include/constants/$language.lang.php"))
    {
        include("include/constants/$language.lang.php");
    }

	if(!isset($app_strings))
	{
		$log->fatal("Unable to load the application language file for the selected language($language) or the default language($default_language)");
		$log->debug("Exiting return_application_language method ...");
		return null;
	}

	// If we are in debug mode for translating, turn on the prefix now!
	if($translation_string_prefix)
	{
		foreach($app_strings as $entry_key=>$entry_value)
		{
			$app_strings[$entry_key] = $language_used.' '.$entry_value;
		}
	}

	$return_value = $app_strings;
	$app_strings = $temp_app_strings;

	$log->debug("Exiting return_application_language method ...");
	return $return_value;
}

function return_custom_application_language($language)
{
	global $log;
	$log->debug("Entering return_custom_application_language() method ...");
	global $default_language;
	if($language == "") {
		$language = $default_language;
	}	

	if(is_file("cache/application/language/$language.lang.php"))
    {
        include("cache/application/language/$language.lang.php");
    }

	if(!isset($app_strings))
	{
		$log->debug("Exiting return_custom_application_language method ...");
		return null;
	}
	$return_value = $app_strings;
	$log->debug("Exiting return_custom_application_language method ...");
	return $return_value;
}

function return_custom_app_list_strings_language($language)
{
	global $log;
	$log->debug("Entering return_custom_application_language() method ...");
	global $default_language;
	if($language == "") {
		$language = $default_language;
	}	

	if(is_file("cache/application/language/$language.lang.php"))
    {
        include("cache/application/language/$language.lang.php");
    }

	if(!isset($app_list_strings))
	{
		$log->debug("Exiting return_custom_application_language method ...");
		return null;
	}
	$return_value = $app_list_strings;
	$log->debug("Exiting return_custom_application_language method ...");
	return $return_value;
}

/** This function retrieves a module's language file and returns the array of strings included.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 * If you are in the current module, do not call this function unless you are loading it for the first time */
function return_module_language($language, $module)
{
	global $log;
	$log->debug("Entering return_module_language() method ...");
	global $mod_strings, $default_language, $log, $currentModule, $translation_string_prefix;

	if($currentModule == $module && isset($mod_strings) && $mod_strings != null && $module !='Accounts'&& $module!='Contacts')
	{
		// We should have already loaded the array.  return the current one.
		$log->debug("Exiting return_module_language method ...");
		return $mod_strings;
	}

	$temp_mod_strings = $mod_strings;
	$language_used = $language;
	@include("modules/$module/language/$language.lang.php");
	if(!isset($mod_strings) && is_file("modules/$module/language/$default_language.lang.php"))
	{
		$log->warn("Unable to find the module language file for language: ".$language." and module: ".$module);
		require("modules/$module/language/$default_language.lang.php");
		$language_used = $default_language;
	}

	if(is_file("cache/modules/$module/language/$language.lang.php"))
    {
        include("cache/modules/$module/language/$language.lang.php");
    }

	if(!isset($mod_strings))
	{
		$log->fatal("Unable to load the module($module) language file for the selected language($language) or the default language($default_language)");
		$log->debug("Exiting return_module_language method ...");
		return null;
	}

	// If we are in debug mode for translating, turn on the prefix now!
	if($translation_string_prefix)
	{
		foreach($mod_strings as $entry_key=>$entry_value)
		{
			$mod_strings[$entry_key] = $language_used.' '.$entry_value;
		}
	}

	$return_value = $mod_strings;
	$mod_strings = $temp_mod_strings;

	$log->debug("Exiting return_module_language method ...");
	return $return_value;
}

/*This function returns the mod_strings for the current language and the specified module
*/

function return_specified_module_language($language, $module)
{
	global $log;
	global $default_language, $translation_string_prefix;

	@include("modules/$module/language/$language.lang.php");
	if(!isset($mod_strings))
	{
		$log->warn("Unable to find the module language file for language: ".$language." and module: ".$module);
		require("modules/$module/language/$default_language.lang.php");
		$language_used = $default_language;
	}
	if(is_file("cache/modules/$module/language/$language.lang.php"))
    {
        include("cache/modules/$module/language/$language.lang.php");
    }

	if(!isset($mod_strings))
	{
		$log->fatal("Unable to load the module($module) language file for the selected language($language) or the default language($default_language)");
		$log->debug("Exiting return_module_language method ...");
		return null;
	}

	$return_value = $mod_strings;

	$log->debug("Exiting return_module_language method ...");
	return $return_value;
}

/** This function retrieves an application language file and returns the array of strings included in the $mod_list_strings var.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 * If you are using the current language, do not call this function unless you are loading it for the first time */
function return_mod_list_strings_language($language,$module)
{
	global $log;
	$log->debug("Entering return_mod_list_strings_language() method ...");
	global $mod_list_strings, $default_language, $log, $currentModule,$translation_string_prefix;

	$language_used = $language;
	$temp_mod_list_strings = $mod_list_strings;

	if($currentModule == $module && isset($mod_list_strings) && $mod_list_strings != null)
	{
		$log->debug("Exiting return_mod_list_strings_language method ...");
		return $mod_list_strings;
	}

	@include("modules/$module/language/$language.lang.php");

	if(!isset($mod_list_strings))
	{
		$log->fatal("Unable to load the application list language file for the selected language($language) or the default language($default_language)");
		$log->debug("Exiting return_mod_list_strings_language method ...");
		return null;
	}

	$return_value = $mod_list_strings;
	$mod_list_strings = $temp_mod_list_strings;

	$log->debug("Exiting return_mod_list_strings_language method ...");
	return $return_value;
}

/** This function retrieves a theme's language file and returns the array of strings included.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 */
function return_theme_language($language, $theme)
{
	global $log;
	$log->debug("Entering return_theme_language() method ...");
	global $mod_strings, $default_language, $log, $currentModule, $translation_string_prefix;

	$language_used = $language;

	@include("themes/$theme/language/$current_language.lang.php");
	if(!isset($theme_strings))
	{
		$log->warn("Unable to find the theme file for language: ".$language." and theme: ".$theme);
		require("themes/$theme/language/$default_language.lang.php");
		$language_used = $default_language;
	}

	if(!isset($theme_strings))
	{
		$log->fatal("Unable to load the theme($theme) language file for the selected language($language) or the default language($default_language)");
		$log->debug("Exiting return_theme_language method ...");
		return null;
	}

	// If we are in debug mode for translating, turn on the prefix now!
	if($translation_string_prefix)
	{
		foreach($theme_strings as $entry_key=>$entry_value)
		{
			$theme_strings[$entry_key] = $language_used.' '.$entry_value;
		}
	}

	$log->debug("Exiting return_theme_language method ...");
	return $theme_strings;
}



/** If the session variable is defined and is not equal to "" then return it.  Otherwise, return the default value.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
*/
function return_session_value_or_default($varname, $default)
{
	global $log;
	$log->debug("Entering return_session_value_or_default() method ...");
	if(isset($_SESSION[$varname]) && $_SESSION[$varname] != "")
	{
		$log->debug("Exiting return_session_value_or_default method ...");
		return $_SESSION[$varname];
	}

	$log->debug("Exiting return_session_value_or_default method ...");
	return $default;
}

/**
  * Creates an array of where restrictions.  These are used to construct a where SQL statement on the query
  * It looks for the variable in the $_REQUEST array.  If it is set and is not "" it will create a where clause out of it.
  * @param &$where_clauses - The array to append the clause to
  * @param $variable_name - The name of the variable to look for an add to the where clause if found
  * @param $SQL_name - [Optional] If specified, this is the SQL column name that is used.  If not specified, the $variable_name is used as the SQL_name.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
  */
function append_where_clause(&$where_clauses, $variable_name, $SQL_name = null)
{
	global $log;
	$log->debug("Entering append_where_clause() method ...");
	if($SQL_name == null)
	{
		$SQL_name = $variable_name;
	}

	if(isset($_REQUEST[$variable_name]) && $_REQUEST[$variable_name] != "")
	{
		array_push($where_clauses, "$SQL_name like '$_REQUEST[$variable_name]%'");
	}
	$log->debug("Exiting append_where_clause method ...");
}

/**
  * Generate the appropriate SQL based on the where clauses.
  * @param $where_clauses - An Array of individual where clauses stored as strings
  * @returns string where_clause - The final SQL where clause to be executed.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
  */
function generate_where_statement($where_clauses)
{
	global $log;
	$log->debug("Entering generate_where_statement() method ...");
	$where = "";
	foreach($where_clauses as $clause)
	{
		if($where != "")
		$where .= " and ";
		$where .= $clause;
	}
	$log->debug("Exiting generate_where_statement method ...");
	return $where;
}

/**
 * A temporary method of generating GUIDs of the correct format for our DB.
 * @return String contianing a GUID in the format: aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee
 *
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
*/
function create_guid()
{
	global $log;
	$log->debug("Entering create_guid() method ...");
        $microTime = microtime();
	list($a_dec, $a_sec) = explode(" ", $microTime);

	$dec_hex = sprintf("%x", $a_dec* 1000000);
	$sec_hex = sprintf("%x", $a_sec);

	ensure_length($dec_hex, 5);
	ensure_length($sec_hex, 6);

	$guid = "";
	$guid .= $dec_hex;
	$guid .= create_guid_section(3);
	$guid .= '-';
	$guid .= create_guid_section(4);
	$guid .= '-';
	$guid .= create_guid_section(4);
	$guid .= '-';
	$guid .= create_guid_section(4);
	$guid .= '-';
	$guid .= $sec_hex;
	$guid .= create_guid_section(6);

	$log->debug("Exiting create_guid method ...");
	return $guid;

}

/** Function to create guid section for a given character
  * @param $characters -- characters:: Type string
  * @returns $return -- integer:: Type integer``
  */
function create_guid_section($characters)
{
	global $log;
	$log->debug("Entering create_guid_section() method ...");
	$return = "";
	for($i=0; $i<$characters; $i++)
	{
		$return .= sprintf("%x", rand(0,15));
	}
	$log->debug("Exiting create_guid_section method ...");
	return $return;
}

/** Function to ensure length
  * @param $string -- string:: Type string
  * @param $length -- length:: Type string
  */

function ensure_length(&$string, $length)
{
	global $log;
	$log->debug("Entering ensure_length() method ...");
	$strlen = strlen($string);
	if($strlen < $length)
	{
		$string = str_pad($string,$length,"0");
	}
	else if($strlen > $length)
	{
		$string = substr($string, 0, $length);
	}
	$log->debug("Exiting ensure_length method ...");
}

function microtime_diff($a, $b) {
	global $log;
	$log->debug("Entering microtime_diff() method ...");
	list($a_dec, $a_sec) = explode(" ", $a);
	list($b_dec, $b_sec) = explode(" ", $b);
	$log->debug("Exiting microtime_diff method ...");
	return $b_sec - $a_sec + $b_dec - $a_dec;
}


/**
 * Return the display name for a theme if it exists.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 */
function get_theme_display($theme) {
	global $log;
	$log->debug("Entering get_theme_display() method ...");
	global $theme_name, $theme_description;
	$temp_theme_name = $theme_name;
	$temp_theme_description = $theme_description;

	if (is_file("./themes/$theme/config.php")) {
		@include("./themes/$theme/config.php");
		$return_theme_value = $theme_name;
	}
	else {
		$return_theme_value = $theme;
	}
	$theme_name = $temp_theme_name;
	$theme_description = $temp_theme_description;

	$log->debug("Exiting get_theme_display method ...");
	return $return_theme_value;
}

/**
 * Return an array of directory names.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 */
function get_themes() {
	global $log;
	$log->debug("Entering get_themes() method ...");
   if ($dir = @opendir("./themes")) {
		while (($file = readdir($dir)) !== false) {
           if ($file != ".." && $file != "." && $file != "CVS" && $file != "Attic" && $file != "akodarkgem" && $file != "bushtree" && $file != "coolblue" && $file != "Amazon" && $file != "busthree" && $file != "Aqua" && $file != "nature" && $file != "orange" && $file != "blue") {
			   if(is_dir("./themes/".$file)) {
				   if(!($file[0] == '.')) {
				   	// set the initial theme name to the filename
				   	$name = $file; 

				   	// if there is a configuration class, load that.
				   	if(is_file("./themes/$file/config.php"))
				   	{
				   		require_once("./themes/$file/config.php");
				   		$name = $theme_name;
				   	}

				   	if(is_file("./themes/$file/header.php"))
					{
						$filelist[$file] = $name;
					}
				   }
			   }
		   }
	   }
	   closedir($dir);
   }

   ksort($filelist);
   $log->debug("Exiting get_themes method ...");
   return $filelist;
}



/**
 * Create javascript to clear values of all elements in a form.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 */
function get_clear_form_js () {
global $log;
$log->debug("Entering get_clear_form_js () method ...");
$the_script = <<<EOQ
<script type="text/javascript" language="JavaScript">
<!-- Begin
function clear_form(form) {
	for (j = 0; j < form.elements.length; j++) {
		if (form.elements[j].type == 'text' || form.elements[j].type == 'select-one') {
			form.elements[j].value = '';
		}
	}
}
//  End -->
</script>
EOQ;

$log->debug("Exiting get_clear_form_js  method ...");
return $the_script;
}

/**
 * Create javascript to set the cursor focus to specific ec_field in a form
 * when the screen is rendered.  The ec_field name is currently hardcoded into the
 * the function.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 */
function get_set_focus_js () {
global $log;
$log->debug("Entering set_focus() method ...");
//TODO Clint 5/20 - Make this function more generic so that it can take in the target form and ec_field names as variables
$the_script = <<<EOQ
<script type="text/javascript" language="JavaScript">
<!-- Begin
function set_focus() {
	if (document.forms.length > 0) {
		for (i = 0; i < document.forms.length; i++) {
			for (j = 0; j < document.forms[i].elements.length; j++) {
				var ec_field = document.forms[i].elements[j];
				if ((ec_field.type == "text" || ec_field.type == "textarea" || ec_field.type == "password") &&
						!field.disabled && (ec_field.name == "first_name" || ec_field.name == "name")) {
				ec_field.focus();
                    if (ec_field.type == "text") {
                        ec_field.select();
                    }
					break;
	    		}
			}
      	}
   	}
}
//  End -->
</script>
EOQ;

$log->debug("Exiting get_set_focus_js  method ...");
return $the_script;
}

/**
 * Very cool algorithm for sorting multi-dimensional arrays.  Found at http://us2.php.net/manual/en/function.array-multisort.php
 * Syntax: $new_array = array_csort($array [, 'col1' [, SORT_FLAG [, SORT_FLAG]]]...);
 * Explanation: $array is the array you want to sort, 'col1' is the name of the column
 * you want to sort, SORT_FLAGS are : SORT_ASC, SORT_DESC, SORT_REGULAR, SORT_NUMERIC, SORT_STRING
 * you can repeat the 'col',FLAG,FLAG, as often you want, the highest prioritiy is given to
 * the first - so the array is sorted by the last given column first, then the one before ...
 * Example: $array = array_csort($array,'town','age',SORT_DESC,'name');
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 */
function array_csort() {
   global $log;
   $log->debug("Entering array_csort() method ...");
   $args = func_get_args();
   $marray = array_shift($args);
   $i = 0;

   $msortline = "return(array_multisort(";
   foreach ($args as $arg) {
	   $i++;
	   if (is_string($arg)) {
		   foreach ($marray as $row) {
			   $sortarr[$i][] = $row[$arg];
		   }
	   } else {
		   $sortarr[$i] = $arg;
	   }
	   $msortline .= "\$sortarr[".$i."],";
   }
   $msortline .= "\$marray));";

   eval($msortline);
   $log->debug("Exiting array_csort method ...");
   return $marray;
}

/** Function to set default varibles on to the global variable
  * @param $defaults -- default values:: Type array
       */
function set_default_config(&$defaults)
{
	global $log;
	$log->debug("Entering set_default_config() method ...");

	foreach ($defaults as $name=>$value)
	{
		if ( ! isset($GLOBALS[$name]) )
		{
			$GLOBALS[$name] = $value;
		}
	}
	$log->debug("Exiting set_default_config method ...");
}

$toHtml = array(
        '"' => '&quot;',
        '<' => '&lt;',
        '>' => '&gt;',
        '& ' => '&amp; ',
        "'" =>  '&#039;',
);

/** Function to convert the given string to html
  * @param $string -- string:: Type string
  * @param $ecnode -- boolean:: Type boolean
    * @returns $string -- string:: Type string 
      *
       */
function to_html($string, $encode=true){
	global $log;
	$log->debug("Entering to_html() method ...");
	global $toHtml;
	$string = trim($string);
	if($encode && is_string($string)){//$string = htmlentities($string, ENT_QUOTES);		
		if (is_array($toHtml)) {
			$string = str_replace(array_keys($toHtml), array_values($toHtml), $string);
		}
	}
	$log->debug("Exiting to_html method ...");
    return $string;
}

/** Function to get the tabname for a given id
  * @param $tabid -- tab id:: Type integer
    * @returns $string -- string:: Type string 
      *
       */

function getTabname($tabid)
{
	global $log;
	$log->debug("Entering getTabname() method ...");
	$tabname = getTabModuleName($tabid);
	$log->debug("Exiting getTabname method ...");
	return $tabname;

}

/** Function to get the tab module name for a given id
  * @param $tabid -- tab id:: Type integer
    * @returns $string -- string:: Type string 
      *
       */

function getTabModuleName($tabid)
{
	global $log;
	$log->debug("Entering getTabModuleName() method ...");
	$moduletabname = "";
	$key = "moduletablist";
	$result_array = getSqlCacheData($key);
	if(!$result_array) {
		global $adb;
		$sql = "select * from ec_tab order by tabid";
		$result = $adb->query($sql);
		$num_rows=$adb->num_rows($result);
		$result_array=Array();
		$seq_array=Array();
		for($i=0;$i<$num_rows;$i++)
		{
				$id=$adb->query_result($result,$i,'tabid');
				$name=$adb->query_result($result,$i,'name');
				$presence=$adb->query_result($result,$i,'presence');
				$result_array[$id]=$name;
				//$seq_array[$tabid]=$presence;

		}
		setSqlCacheData($key,$result_array);
	}
	if(isset($result_array[$tabid])) {
		$moduletabname= $result_array[$tabid];
	}
	$log->debug("Exiting getTabModuleName method ...");
	return $moduletabname;
}

/** Function to get column fields for a given module
  * @param $module -- module:: Type string
    * @returns $column_fld -- column field :: Type array 
      *
       */

function getColumnFields($module)
{
	global $log;
	$log->debug("Entering getColumnFields() method ...");
	//changed by dingjianting on 2007-10-3 for cache HeaderArray
	$key = "column_fld_".$module;
	$column_fld = getSqlCacheData($key);
	if(!$column_fld) {
		global $adb;
		$column_fld = Array();
		$tabid = getTabid($module);
		$sql = "select * from ec_field where tabid='".$tabid."'";
		$result = $adb->query($sql);
		$noofrows = $adb->num_rows($result);
		for($i=0; $i<$noofrows; $i++)
		{
			$fieldname = $adb->query_result($result,$i,"fieldname");
			$column_fld[$fieldname] = ''; 
		}
		setSqlCacheData($key,$column_fld);
	}
	$log->debug("Exiting getColumnFields method ...");
	return $column_fld;	
}

function getTranslatedColumnFields($module)
{
	global $log;
	global $current_language;
	$import_mod_strings = return_specified_module_language($current_language,$module);
	$log->debug("Entering getTranslatedColumnFields() method ...");
	global $adb;
	$column_fld = Array();
    $tabid = getTabid($module);
	$sql = "select ec_field.* from ec_field inner join ec_def_org_field on ec_def_org_field.fieldid=ec_field.fieldid where ec_def_org_field.visible=0 and ec_field.tabid='".$tabid."' order by block,sequence";
	$result = $adb->query($sql);
	$noofrows = $adb->num_rows($result);
	for($i=0; $i<$noofrows; $i++)
	{
		$fieldname = $adb->query_result($result,$i,"fieldname");
		$fieldlabel = $adb->query_result($result,$i,"fieldlabel");
		if(isset($import_mod_strings[$fieldlabel])) {
			$column_fld[$fieldname] = $import_mod_strings[$fieldlabel];
		} else {
			$column_fld[$fieldname] = $fieldlabel;
		}
	}
	$log->debug("Exiting getTranslatedColumnFields method ...");
	return $column_fld;	
}

/** Function to get a users's mail id
  * @param $userid -- userid :: Type integer
    * @returns $email -- email :: Type string 
      *
       */

function getUserEmail($userid)
{
	global $log;
	$log->debug("Entering getUserEmail() method ...");
        global $adb;
        if($userid != '')
        {
                $sql = "select email1 from ec_users where id=".$userid;
                $result = $adb->query($sql);
                $email = $adb->query_result($result,0,"email1");
        }
	$log->debug("Exiting getUserEmail method ...");
        return $email;
}		

/** Function to get a userid for outlook
  * @param $username -- username :: Type string
    * @returns $user_id -- user id :: Type integer 
       */

//outlook security
function getUserId_Ol($username)
{
	global $log;
	$log->debug("Entering getUserId_Ol() method ...");
	$username = trim($username);  
	$key = "useridslist_ol";
	$userIdList = getSqlCacheData($key);
	if(!$userIdList) {
		global $adb;
		$query = "select id,user_name from ec_users order by id";
		$result = $adb->getList($query);
		$userIdList = array();
		//foreach($pickListResult as $row) {
       // var_dump($result."hello");
        //exit();
        foreach($result as $row){
			$userIdList[$row['user_name']] = $row['id'];
		}
		setSqlCacheData($key,$userIdList);
	}
	$log->debug("Exiting getUserId_Ol method ...");
	if(isset($userIdList[$username])) return $userIdList[$username];
	else return "0";
}


/** Function to get a action id for a given action name
  * @param $action -- action name :: Type string
    * @returns $actionid -- action id :: Type integer 
       */

function getActionid($action)
{
	global $log;
	$log->debug("Entering getActionid() method ...");
	$curactionid = '';
	$key = "actionidlist";
	$actionidlist = getSqlCacheData($key);
	if(!$actionidlist) {
		global $adb;
		$sql = "select * from ec_actionmapping";
		$result = $adb->query($sql);
		$actionidlist = array();
		$noofrows = $adb->num_rows($result);
		for($i=0; $i<$noofrows; $i++)
		{
			$name = $adb->query_result($result,$i,"actionname");
			$id = $adb->query_result($result,$i,"actionid");
			$actionidlist[$name] = $id; 
		}
		setSqlCacheData($key,$actionidlist);
	}
	if(isset($actionidlist[$action])) {
		$curactionid = $actionidlist[$action];
	}
	
	$log->debug("Exiting getActionid method ...");	
	return $curactionid;
}

/** Function to get a action for a given action id
  * @param $action id -- action id :: Type integer
    * @returns $actionname-- action name :: Type string 
       */


function getActionname($actionid)
{
	global $log;
	$log->debug("Entering getActionname() method ...");
	global $adb;
	$curactionname = '';
	$key = "actionnamelist";
	$actionnamelist = getSqlCacheData($key);
	if(!$actionnamelist) {
		global $adb;
		$sql = "select * from ec_actionmapping where securitycheck=0";
		$result = $adb->query($sql);
		$actionnamelist = array();
		$noofrows = $adb->num_rows($result);
		for($i=0; $i<$noofrows; $i++)
		{
			$name = $adb->query_result($result,$i,"actionname");
			$id = $adb->query_result($result,$i,"actionid");
			$actionnamelist[$id] = $name; 
		}
		setSqlCacheData($key,$actionnamelist);
	}
	if(isset($actionnamelist[$actionid])) {
		$curactionname = $actionnamelist[$actionid];
	}
	$log->debug("Exiting getActionname method ...");
	return $curactionname;
}

/** Function to insert into default org field
       */

function insert_def_org_field()
{
	global $log;
	$log->debug("Entering insert_def_org_field() method ...");
	global $adb;
	$adb->database->SetFetchMode(ADODB_FETCH_ASSOC); 
	$fld_result = $adb->query("select * from ec_field where generatedtype=1 and displaytype in (1,2) and tabid != 29");
        $num_rows = $adb->num_rows($fld_result);
        for($i=0; $i<$num_rows; $i++)
        {
                 $tab_id = $adb->query_result($fld_result,$i,'tabid');
                 $field_id = $adb->query_result($fld_result,$i,'fieldid');
                 $adb->query("insert into ec_def_org_field values (".$tab_id.",".$field_id.",0,1)");
	}
	$log->debug("Exiting insert_def_org_field() method ...");
}

/** Function to getdefaultfield organisation list for a given module
  * @param $fld_module -- module name :: Type string
  * @returns $result -- string :: Type object
  */

//end of fn added by jeri

function getDefOrgFieldList($fld_module)
{
	global $log;
	$log->debug("Entering getDefOrgFieldList() method ...");
	global $adb;
	$tabid = getTabid($fld_module);
	
	$query = "select ec_def_org_field.visible,ec_field.* from ec_def_org_field inner join ec_field on ec_field.fieldid=ec_def_org_field.fieldid where ec_def_org_field.tabid=".$tabid;
	$result = $adb->query($query);
	$log->debug("Exiting getDefOrgFieldList method ...");
	return $result;
}


/** Function to set date values compatible to database (YY_MM_DD)
  * @param $value -- value :: Type string
  * @returns $insert_date -- insert_date :: Type string
  */

function getDBInsertDateValue($value)
{
	global $log;
	$log->debug("Entering getDBInsertDateValue() method ...");
	global $current_user;
	$dat_fmt = $current_user->date_format;
	if($dat_fmt == '')
        {
		        //changed by dingjianting on 2006-12-4 for simplized chinese dateformat
                $dat_fmt = 'yyyy-mm-dd';
        }
	$insert_date='';
	if($dat_fmt == 'dd-mm-yyyy')
	{
		list($d,$m,$y) = split('-',$value);
	}
	elseif($dat_fmt == 'mm-dd-yyyy')
	{
		list($m,$d,$y) = split('-',$value);
	}
	elseif($dat_fmt == 'yyyy-mm-dd')
	{
		list($y,$m,$d) = split('-',$value);
	}
		
	if(!$y && !$m && !$d) {
		$insert_date = '';
	} else {
		$insert_date=$y.'-'.$m.'-'.$d;
	}
	$log->debug("Exiting getDBInsertDateValue method ...");
	return $insert_date;
}

/** Function to get unitprice for a given product id
  * @param $productid -- product id :: Type integer
  * @returns $up -- up :: Type string
  */

function getUnitPrice($productid)
{
	global $log,$current_user;
	$log->debug("Entering getUnitPrice() method ...");
	global $adb;
	$query = "select unit_price from ec_products where productid=".$productid;
	$result = $adb->query($query);
	$up = $adb->query_result($result,0,'unit_price');
	$log->debug("Exiting getUnitPrice method ...");
	return $up;
}

/** Function to get account information 
  * @param $parent_id -- parent id :: Type integer
  * @returns $accountid -- accountid:: Type integer
  */

function get_account_info($parent_id)
{
	global $log;
	$log->debug("Entering get_account_info() method ...");
	global $adb;
	$query = "select accountid from ec_potential where potentialid=".$parent_id;
	$result = $adb->query($query);
	$accountid=$adb->query_result($result,0,'accountid');
	$log->debug("Exiting get_account_info method ...");
	return $accountid;
}

/** Function to seperate the Date and Time
  * This function accepts a sting with date and time and
  * returns an array of two elements.The first element
  * contains the date and the second one contains the time
  */
function getDateFromDateAndtime($date_time)
{
	global $log;
	$log->debug("Entering getDateFromDateAndtime(".$date_time.") method ...");
	$result = explode(" ",$date_time);
	$log->debug("Exiting getDateFromDateAndtime method ...");
	return $result;
}


/** Function to get header for block in edit/create and detailview  
  * @param $header_label -- header label :: Type string
  * @returns $output -- output:: Type string
  */

function getBlockTableHeader($header_label)
{
	global $log;
	$log->debug("Entering getBlockTableHeader() method ...");
	global $mod_strings;
	$label = $mod_strings[$header_label];
	$output = $label;
	$log->debug("Exiting getBlockTableHeader method ...");
	return $output;

}



/**     Function to get the ec_table name from 'field' ec_table for the input ec_field based on the module
 *      @param  : string $module - current module value
 *      @param  : string $fieldname - ec_fieldname to which we want the ec_tablename
 *      @return : string $tablename - ec_tablename in which $fieldname is a column, which is retrieved from 'field' ec_table per $module basis
 */
function getTableNameForField($module,$fieldname)
{
	global $log;
	$log->debug("Entering getTableNameForField() method ...");
	global $adb;
	$tabid = getTabid($module);

	$sql = "select tablename from ec_field where tabid='".$tabid."' and columnname like '%".$fieldname."%'";
	$res = $adb->query($sql);

	$tablename = '';
	if($adb->num_rows($res) > 0)
	{
		$tablename = $adb->query_result($res,0,'tablename');
	}

	$log->debug("Exiting getTableNameForField method ...");
	return $tablename;
}

/** Function to get Quotes related Potentials   
  * @param $record_id -- record id :: Type integer
  * @returns $accountid -- accountid:: Type integer
  */

function getSalesOrderRelatedAccounts($record_id)
{
	global $log;
	$log->debug("Entering getSalesOrderRelatedAccounts() method ...");
	global $adb;
        $query="select accountid from ec_salesorder where salesorderid=".$record_id;
        $result=$adb->query($query);
        $accountid=$adb->query_result($result,0,'accountid');
	$log->debug("Exiting getSalesOrderRelatedAccounts method ...");
        return $accountid;
}

/** Function to get Days and Dates in between the dates specified
        * Portions created by vtiger are Copyright (C) vtiger.
        * All Rights Reserved.
        * Contributor(s): ______________________________________..
 */
function get_days_n_dates($st,$en)
{
	global $log;
	$log->debug("Entering get_days_n_dates() method ...");
        $stdate_arr=explode("-",$st);
        $endate_arr=explode("-",$en);

        $dateDiff = mktime(0,0,0,$endate_arr[1],$endate_arr[2],$endate_arr[0]) - mktime(0,0,0,$stdate_arr[1],$stdate_arr[2],$stdate_arr[0]);//to get  dates difference

        $days   =  floor($dateDiff/60/60/24)+1; //to calculate no of. days
        for($i=0;$i<$days;$i++)
        {
                $day_date[] = date("Y-m-d",mktime(0,0,0,date("$stdate_arr[1]"),(date("$stdate_arr[2]")+($i)),date("$stdate_arr[0]")));
        }
        if(!isset($day_date))
                $day_date=0;
        $nodays_dates=array($days,$day_date);
	$log->debug("Exiting get_days_n_dates method ...");
        return $nodays_dates; //passing no of days , days in between the days
}//function end


/** Function to get the start and End Dates based upon the period which we give
        * Portions created by vtiger are Copyright (C) vtiger.
        * All Rights Reserved.
        * Contributor(s): ______________________________________..
 */
function start_end_dates($period)
{
	global $log;
	$log->debug("Entering start_end_dates() method ...");
        $st_thisweek= date("Y-m-d",mktime(0,0,0,date("n"),(date("j")-date("w")),date("Y")));
        if($period=="tweek")
        {
                $st_date= date("Y-m-d",mktime(0,0,0,date("n"),(date("j")-date("w")),date("Y")));
                $end_date = date("Y-m-d",mktime(0,0,0,date("n"),(date("j")-1),date("Y")));
                $st_week= date("w",mktime(0,0,0,date("n"),date("j"),date("Y")));
                if($st_week==0)
                {
                        $start_week=explode("-",$st_thisweek);
                        $st_date = date("Y-m-d",mktime(0,0,0,date("$start_week[1]"),(date("$start_week[2]")-7),date("$start_week[0]")));
                        $end_date = date("Y-m-d",mktime(0,0,0,date("$start_week[1]"),(date("$start_week[2]")-1),date("$start_week[0]")));
                }
                $period_type="week";
                $width="360";
        }
        else if($period=="lweek")
        {
                $start_week=explode("-",$st_thisweek);
                $st_date = date("Y-m-d",mktime(0,0,0,date("$start_week[1]"),(date("$start_week[2]")-7),date("$start_week[0]")));
                $end_date = date("Y-m-d",mktime(0,0,0,date("$start_week[1]"),(date("$start_week[2]")-1),date("$start_week[0]")));
                $st_week= date("w",mktime(0,0,0,date("n"),date("j"),date("Y")));
                if($st_week==0)
                {
                        $start_week=explode("-",$st_thisweek);
                        $st_date = date("Y-m-d",mktime(0,0,0,date("$start_week[1]"),(date("$start_week[2]")-14),date("$start_week[0]")));
                        $end_date = date("Y-m-d",mktime(0,0,0,date("$start_week[1]"),(date("$start_week[2]")-8),date("$start_week[0]")));
                }
                $period_type="week";
                $width="360";
        }
        else if($period=="tmon")
        {
		$period_type="month";
		$width="840";
		$st_date = date("Y-m-d",mktime(0, 0, 0, date("m"), "01",   date("Y")));	
		$end_date = date("Y-m-t");

        }
        else if($period=="lmon")
        {
                $st_date=date("Y-m-d",mktime(0,0,0,date("n")-1,date("1"),date("Y")));
                $end_date = date("Y-m-d",mktime(0, 0, 1, date("n"), 0,date("Y")));
                $period_type="month";
                $start_month=date("d",mktime(0,0,0,date("n"),date("j"),date("Y")));
                if($start_month==1)
                {
                        $st_date=date("Y-m-d",mktime(0,0,0,date("n")-2,date("1"),date("Y")));
                        $end_date = date("Y-m-d",mktime(0, 0, 1, date("n")-1, 0,date("Y")));
                }

                $width="840";
        }
        else
        {
                $curr_date=date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")));
                $today_date=explode("-",$curr_date);
                $lastday_date=date("Y-m-d",mktime(0,0,0,date("$today_date[1]"),date("$today_date[2]")-1,date("$today_date[0]")));
                $st_date=$lastday_date;
                $end_date=$lastday_date;
                $period_type="yday";
		 $width="250";
        }
        if($period_type=="yday")
                $height="160";
        else
                $height="250";
        $datevalues=array($st_date,$end_date,$period_type,$width,$height);
	$log->debug("Exiting start_end_dates method ...");
        return $datevalues;
}//function ends


/**   Function to get the Graph and ec_table format for a particular date
        based upon the period
        * Portions created by vtiger are Copyright (C) vtiger.
        * All Rights Reserved.
        * Contributor(s): ______________________________________..
 */
function Graph_n_table_format($period_type,$date_value)
{
	global $log;
	$log->debug("Entering Graph_n_table_format() method ...");
        $date_val=explode("-",$date_value);
        if($period_type=="month")   //to get the ec_table format dates
        {
                $table_format=date("j",mktime(0,0,0,date($date_val[1]),(date($date_val[2])),date($date_val[0])));
                $graph_format=date("D",mktime(0,0,0,date($date_val[1]),(date($date_val[2])),date($date_val[0])));
        }
        else if($period_type=="week")
        {
                $table_format=date("d/m",mktime(0,0,0,date($date_val[1]),(date($date_val[2])),date($date_val[0])));
                $graph_format=date("D",mktime(0,0,0,date($date_val[1]),(date($date_val[2])),date($date_val[0])));
        }
        else if($period_type=="yday")
        {
                $table_format=date("j",mktime(0,0,0,date($date_val[1]),(date($date_val[2])),date($date_val[0])));
                $graph_format=$table_format;
        }
        $values=array($graph_format,$table_format);
	$log->debug("Exiting Graph_n_table_format method ...");
        return $values;
}

/**   Function to remove the script tag in the contents
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 */
function strip_selected_tags($text, $tags = array())
{
    $args = func_get_args();
    $text = array_shift($args);
    $tags = func_num_args() > 2 ? array_diff($args,array($text))  : (array)$tags;
    foreach ($tags as $tag){
        if(preg_match_all('/<'.$tag.'[^>]*>(.*)<\/'.$tag.'>/iU', $text, $found)){
            $text = str_replace($found[0],$found[1],$text);
        }
    }

    return $text;
}

/** Function to check whether user has opted for internal mailer
  * @returns $int_mailer -- int mailer:: Type boolean
    */
function useInternalMailer() {
	global $default_use_internalmailer;
	if(isset($default_use_internalmailer)) {
		return $default_use_internalmailer; 
	} else {
		return 1;
	}
}

// Return Question mark
function _questionify($v){
	return "?";
}

/**
* Function to generate question marks for a given list of items
*/
function generateQuestionMarks($items_list) {
	// array_map will call the function specified in the first parameter for every element of the list in second parameter
	if (is_array($items_list)) {
		return implode(",", array_map("_questionify", $items_list));	
	} else {	
		return implode(",", array_map("_questionify", explode(",", $items_list)));
	}
}

/** Function to get a user id or group id for a given entity
  * @param $record -- entity id :: Type integer
    * @returns $ownerArr -- owner id :: Type array 
       */

function getRecordOwnerId($module,$record)
{
	global $log;
	$log->debug("Entering getRecordOwnerId() method ...");
	global $adb;
	if($record == 0) {
		return 0;
	}
	$entityArr = getEntityTable($module);
	$tablename = $entityArr["tablename"];
	$entityidfield = $entityArr["entityidfield"];
	
	$query="select smownerid from ".$tablename." where ".$entityidfield." = ".$record;
	$result=$adb->query($query);
	$user_id = $adb->query_result($result,0,'smownerid');
	if($user_id != 0)
	{
		return $user_id;
	}

	$log->debug("Exiting getRecordOwnerId method ...");
	return 0;

}
?>
