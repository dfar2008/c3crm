<?php
include('ecversion.php');


/* database configuration
      db_server
      db_port
      db_hostname
      db_username
      db_password
      db_name
*/

$dbconfig['db_server'] = '_DBC_SERVER_';
$dbconfig['db_port'] = ':_DBC_PORT_';
$dbconfig['db_username'] = '_DBC_USER_';
$dbconfig['db_password'] = '_DBC_PASS_';
$dbconfig['db_name'] = '_DBC_NAME_';
$dbconfig['db_type'] = '_DBC_TYPE_';
$dbconfig['db_status'] = '_DB_STAT_';

// TODO: test if port is empty
// TODO: set db_hostname dependending on db_type
$dbconfig['db_hostname'] = $dbconfig['db_server'].$dbconfig['db_port'];

$host_name = $dbconfig['db_hostname'];

$site_URL = '_SITE_URL_';

// root directory path
$root_directory = '_VT_ROOTDIR_';

// cache direcory path
$cache_dir = '_VT_CACHEDIR_';

// tmp_dir default value prepended by cache_dir = images/
$tmp_dir = '_VT_TMPDIR_';

// import_dir default value prepended by cache_dir = import/
$import_dir = 'cache/import/';

// upload_dir default value prepended by cache_dir = upload/
$upload_dir = '_VT_UPLOADDIR_';


// maximum file size for uploaded files in bytes also used when uploading import files
// upload_maxsize default value = 3000000
$upload_maxsize = 3000000;

// flag to allow export functionality
// 'all' to allow anyone to use exports 
// 'admin' to only allow admins to export 
// 'none' to block exports completely 
// allow_exports default value = all
$allow_exports = 'all';

// files with one of these extensions will have '.txt' appended to their filename on upload
// upload_badext default value = php, php3, php4, php5, pl, cgi, py, asp, cfm, js, vbs, html, htm
$upload_badext = array('php', 'php3', 'php4', 'php5', 'pl', 'cgi', 'py', 'asp', 'cfm', 'js', 'vbs', 'html', 'htm');

// full path to include directory including the trailing slash
// includeDirectory default value = $root_directory..'include/
$includeDirectory = $root_directory.'include/';

// list_max_entries_per_page default value = 20
$list_max_entries_per_page = '20';

// limitpage_navigation default value = 5
$limitpage_navigation = '5';

// history_max_viewed default value = 5
$history_max_viewed = '5';

// default_module default value = Home
$default_module = 'Home';

// default_action default value = index
$default_action = 'index';

// set default theme
// default_theme default value = blue
$default_theme = 'softed';

$languages = Array('zh_cn'=>'Simplized Chinese',);


// default charset
// default charset default value = ISO-8859-1
$default_charset = 'UTF-8';

// default language
// default_language default value = en_us
$default_language = 'zh_cn';


//true for hosting server , false for dedicated servers or virtual private server
//2 for zend3.3.0 , 1 or true for hosting server(real_server_ip) ,false for dedicated servers or virtual private server
$ecustomer_hosting_type = '2';
//current_user or all_to_me
$default_viewscope = "current_user";
$default_activity_view = "day";
$display_latest_notes = true;
$default_use_internalmailer = 1;//1 -> use webmail to send mail ; 0 use out mailer(such outlook) to send mail 3 use saemail
$is_disable_approve = false;
$default_reminder_interval = 1;
$is_disable_pm = false;
$monday_first = 1;
$default_number_digits = 2;
$default_number_grouping_seperator = ",";
$default_number_decimal_seperator = ".";
$default_timezone = "Asia/Shanghai";
if(isset($default_timezone) && function_exists('date_default_timezone_set')) {
	@date_default_timezone_set($default_timezone);
}
?>