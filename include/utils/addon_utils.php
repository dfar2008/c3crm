<?php
require_once('include/utils/ChineseUtils.php');
/**
* solve utf-8 php5 's basename bug
*/

function explode_basename($path) {
    $path = str_replace('\\', '/', $path);
    $part = explode('/', $path);
    return $part[count($part) - 1];
}

//javascript unesape
function unescape($str) {
    //$str = str_replace(" ","<br />",$str);
    $str = str_replace("\n","<br />",$str);
    $str = rawurldecode($str);
    preg_match_all("/(?:%u.{4})|&#x.{4};|&#\d+;|.+/U",$str,$r);
    $ar = $r[0];
    foreach($ar as $k=>$v) {
        if(substr($v,0,2) == "%u")
            //$ar[$k] = iconv("UCS-2","UTF-8",pack("H4",substr($v,-4)));
            $ar[$k] = iconv("UCS-2BE","UTF-8",pack("H4",substr($v,-4)));
        elseif(substr($v,0,3) == "&#x")
            //$ar[$k] = iconv("UCS-2","UTF-8",pack("H4",substr($v,3,-1)));
            $ar[$k] = iconv("UCS-2BE","UTF-8",pack("H4",substr($v,3,-1)));
        elseif(substr($v,0,2) == "&#") {
            //echo substr($v,2,-1)."<br>";
            //$ar[$k] = iconv("UCS-2","UTF-8",pack("n",substr($v,2,-1)));
            $ar[$k] = iconv("UCS-2BE","UTF-8",pack("n",substr($v,2,-1)));
        } 
    }
    $str1 = join("",$ar);
    $str1 = nl2br($str1);
    return $str1;
}

function escape($str) {
  preg_match_all("/[\x80-\xff].|[\x01-\x7f]+/",$str,$r);
  $ar = $r[0];
  foreach($ar as $k=>$v) {
    if(ord($v[0]) < 128)
      $ar[$k] = rawurlencode($v);
    else
      $ar[$k] = "%u".bin2hex(iconv("UTF-8","UCS-2BE",$v));
  }
  return join("",$ar);
}


/**
* the function is like unescape in javascript
* added by dingjianting on 2006-10-1 for picklist editor
*/
function utf8RawUrlDecode ($source) {
    /*
    $decodedStr = "";
    $pos = 0;
    $len = strlen ($source);
    while ($pos < $len) {
        $charAt = substr ($source, $pos, 1);
        if ($charAt == '%') {
            $pos++;
            $charAt = substr ($source, $pos, 1);
            if ($charAt == 'u') {
                // we got a unicode character
                $pos++;
                $unicodeHexVal = substr ($source, $pos, 4);
                $unicode = hexdec ($unicodeHexVal);
                $entity = "&#". $unicode . ';';
                //$decodedStr .= utf8_encode ($entity);
                $entity = iconv('iso-8859-1', 'utf-8', $entity);
                $decodedStr .= $entity;
                $pos += 4;
            }
            else {
                // we have an escaped ascii character
                $hexVal = substr ($source, $pos, 2);
                $decodedStr .= chr (hexdec ($hexVal));
                $pos += 2;
            }
        } else {
            $decodedStr .= $charAt;
            $pos++;
        }
    }
    $decodedStr = from_html($decodedStr);
    //$decodedStr = iconv("utf8","GBK",$decodedStr);
    //$decodedStr = iconv("GBK","utf8",$decodedStr);
    //return $decodedStr;
    */
    $source = from_html(unescape($source));
    return $source;
}

if ( !function_exists('str_ireplace') )
{
   function str_ireplace ($search, $replace, $subject) // >> , &$count)
   {
       //Loop back until done if using a subject array
       if ( is_array($subject) )
       {
           $array_keys = array_keys($subject);
           while ( true )
           {
               // This is done here rather than in the while() statement because 0 evaluates as false
               $key = array_pop($array_keys);
               
               // If $key is null then there are no more subjects
               if ( $key === NULL)
               {
                   return $subject;
               }
           
               $subject[$key] = str_ireplace($search, $replace, $subject[$key]); // >> , $count);
           }
           return $subject;
       }
   
       // Loop back until done if using a search array        
       if ( is_array($search) )
       {
           //Only need to check this once
           $is_array = is_array($replace);
           
           while ( true )
           {
               $needle = array_pop($search);
               
               // If needle is null then there are no more searches to process
               if ( $needle === NULL )
               {
                   return $subject;
               }
               
               // If no needle, don't even bother
               // In PHP, empty(0) returns true, so the second check is needed
               if ( empty($needle) && (string)$needle !== "0" )
               {
                   continue;
               }
               
               if ( $is_array == true )
               {
                   // If no replacements are left, use empty string instead
                   if ( count($replace) )
                   {
                       $replacement = array_pop($replace);
                   }
                   else
                   {
                       $replacement = '';
                   }
               }
               else
               {
                   // If replacement is not an array, use the same value each time
                   $replacement = $replace;
               }
               
               $subject = str_ireplace($needle, $replacement, $subject); // >> , $count);
           }
           return $subject;
       }
   
       // Now begins the meat of the function
       // Define some variables - compiler throws 'E_NOTICE undefined variable' if you don't
       $newsubject = '';
       $end = '';
       $offset = 0;
   
       // Only need to do this once
       $lowerneedle = strtolower($search);
       $lowersubject = strtolower($subject);
   
       // Keep going until I say so
       while ( true )
       {
           // $pos will either be the position of the needle (can be 0) or FALSE
           $pos = strpos($lowersubject, $lowerneedle, $offset);
           // Operator === also checks against types, 0 == FALSE, 0 !== FALSE
           if ($pos === false)
           {
               // Tack on the rest
               $end = substr($subject, $offset);
               $newsubject .= $end;
               return $newsubject;
           }
           
           // Get the data before the needle
           $front = substr($subject, $offset, $pos);
           // Append the next piece and the replacement
           $newsubject .= $front . $replace;
           // Set offset to search beyond needle next time
           // This is important because the replacement may contain the needle
           $offset = $pos + strlen($search);
           // Pretty self explanatory
           // >> $count++;
       }
   
       // This should never happen, but it's here in case
       return $subject;
   }
}

//disuz passport functions
function passport_encrypt($txt, $key) {
    srand((double)microtime() * 1000000);
    $encrypt_key = md5(rand(0, 32000));
    $ctr = 0;
    $tmp = '';
    for($i = 0;$i < strlen($txt); $i++) {
        $ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
        $tmp .= $encrypt_key[$ctr].($txt[$i] ^ $encrypt_key[$ctr++]);
    }
    return base64_encode(passport_key($tmp, $key));
}

function passport_decrypt($txt, $key) {
    $txt = passport_key(base64_decode($txt), $key);
    $tmp = '';
    for($i = 0;$i < strlen($txt); $i++) {
        $md5 = $txt[$i];
        $tmp .= $txt[++$i] ^ $md5;
    }
    return $tmp;
}

function passport_key($txt, $encrypt_key) {
    $encrypt_key = md5($encrypt_key);
    $ctr = 0;
    $tmp = '';
    for($i = 0; $i < strlen($txt); $i++) {
        $ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
        $tmp .= $txt[$i] ^ $encrypt_key[$ctr++];
    }
    return $tmp;
}
/**
* Passport ???(????)??????
*
* @param		array		??????????
*
* @return	string		?????????????
*/
function passport_encode($array) {

    // ??????????
    $arrayenc = array();

    // ???????? $array?????? $key ?????????��?$val ????????
    foreach($array as $key => $val) {
        // $arrayenc ????????????????????? "$key=???? urlencode() ??? $val ?"
        $arrayenc[] = $key.'='.urlencode($val);
    }

    // ?????? "&" l??? $arrayenc ???(implode)?????? $arrayenc = array('aa', 'bb', 'cc', 'dd')??
    // ?? implode('&', $arrayenc) ?????? ??aa&bb&cc&dd"
    return implode('&', $arrayenc);

}

/**
substr for chinese character(gbk2312)
*/
function msubstr1_gb($str, $start, $len) {
    $tmpstr = "";
    $strlen = $start + $len;
    for($i = 0; $i < $strlen; $i++) {
        if(ord(substr($str, $i, 1)) > 0xa0) {
            $tmpstr .= substr($str, $i, 2);
            $i++;
        } else
            $tmpstr .= substr($str, $i, 1);
    }
    return $tmpstr;
}

/**
substr for chinese character(utf8)
*/
function msubstr1_old($str, $start, $len)
{
    for($i=0;$i<$len;$i++)
    {
        $temp_str=substr($str,0,1);
        if(ord($temp_str) > 127)
        {
            $i++;
            if($i<$len)
            {
                $new_str[]=substr($str,0,3);
                $str=substr($str,3);
            }
        }
        else
        {
            $new_str[]=substr($str,0,1);
            $str=substr($str,1);
        }
    }
    return join($new_str);
}
function msubstr1($str, $start = 0, $length = 0, $append = true)
{
	$str = trim($str);
    if ($length == 0)
    {
        return $str;
    }

    if (function_exists('mb_substr'))
    {
        $newstr = mb_substr($str, $start, $length, 'UTF-8');
    }
    else
    {
        $strlength = strlen($str);

        if ($length < 0)
        {
            $length = $strlength + $length;
        }
        elseif ($length >= $strlength)
        {
            return $str;
        }
        $newstr = preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $start .  '}((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $length . '}).*#s', '$1', $str);
    }

    if ($append && $str != $newstr)
    {
        $newstr .= '...';
    }

    return $newstr;
}

function msubstr1_utf8_my($str, $start, $len)
{
    for($i=0;$i<$len;$i++)
    {
        $temp_str=substr($str,0,1);
        if(ord($temp_str) > 127)
        {
            $i++;
            if($i<$len)
            {
                $new_str[]=substr($str,0,3);
                $str=substr($str,3);
            }
        }
        else
        {
            $new_str[]=substr($str,0,1);
            $str=substr($str,1);
        }
    }
    $j = 0;
    $start_str = "";
    foreach($new_str as $item) {
        $j ++;
        if($j > $start) {
            $start_str .= $item;
        }
    }
    return $start_str;
    //return join($new_str);
}

/**
 * support double byte char
 *
 * @param   string      $str        �ַ�
 *
 * @return  string
 */
function trim_right($str)
{
    $length = strlen(preg_replace('/[\x00-\x7F]+/', '', $str)) % 3;

    if ($length > 0)
    {
        $str = substr($str, 0, 0 - $length);
    }

    return $str;
}

/**
 * count string length and support chinese char
 *
 * @param   string      $str
 *
 * @return  int
 */
function str_len($str)
{
    $length = strlen(preg_replace('/[\x00-\x7F]/', '', $str));

    if ($length)
    {
        return strlen($str) - $length + intval($length / 3) * 2;
    }
    else
    {
        return strlen($str);
    }
}

/**
 * get crlf of easy opterating system
 *
 * @access  public
 * @return  string
 */
function get_crlf()
{
/* LF (Line Feed, 0x0A, \N) �� CR(Carriage Return, 0x0D, \R) */
    if (stristr($_SERVER['HTTP_USER_AGENT'], 'Win'))
    {
        $the_crlf = '\r\n';
    }
    elseif (stristr($_SERVER['HTTP_USER_AGENT'], 'Mac'))
    {
        $the_crlf = '\r'; // for old MAC OS
    }
    else
    {
        $the_crlf = '\n';
    }

    return $the_crlf;
}

//get mac address
class GetMacAddr
{
    var $return_array = array(); // return string array with mac address
    var $mac_addr;
	var $os_type;   

    function GetMacAddr($os_type)
    {
		$this->os_type = $os_type;
	}
	function getAddr() {
		$macaddress = getHardWareAddr($this->os_type);		
		return $macaddress;
    }
}

//////////////////////////////////////////////////////////////////////////////
//CHANGE STRING IN THIS FILE
//-----------------------------------------------------------------------------
  function strChangeInThisFile ($thisFile, $thisString, $thatString){
// Open thisFile file

   $handle_r = fopen($thisFile,        "r");
   $handle_w = fopen($thisFile.".tmp", "w");

   if ($handle_r && $handle_w) {
    while (!feof($handle_r)) {
     $Buffer   = fgets($handle_r, 4096);
     $Buffer   =  str_replace($thisString, $thatString, $Buffer);
     $result_w = fwrite ($handle_w, $Buffer);
    }

//  Delete original and rename .tmp
    fclose($handle_r);
    fclose($handle_w);
    if (unlink($thisFile)){
     if (!(rename($thisFile.".tmp",$thisFile))){
      echo "ERROR - Could not rename file:".$thisFile.".tmp<br>";
     }
    }else{
     echo "ERROR - could not delete file:".$thisFile."<br>";
    }
    chmod ($thisFile, 0755);
    }else{
     echo "ERROR - Could not process '$thisFile' file<br>";
     fclose($handle_r);
     fclose($handle_w);
     return;
    }
  } // END of function strChangeInThisFile
//Change string in this file

function get_viewscope($module) {
    if(isset($_REQUEST['viewscope'])) {
        $viewscope = $_REQUEST['viewscope'];
        $_SESSION[$module.'_viewscope'] = $viewscope;
    }else {
        if(isset($_SESSION[$module.'_viewscope'])) {
            $viewscope = $_SESSION[$module.'_viewscope'];
        } else {
            $viewscope = "current_user";
        }
    }
    return $viewscope;
}

function send_msnmsg($recipient,$message) {
    include_once("include/msnmsg/sendMsg.php");
    include_once("modules/Emails/mail.php");
    $sender = "dfar2008@live.com";
    $password = "c3crm123";
    //$message = iconv("gb2312","UTF-8",$_POST["message"]);
    //$sendMsg = new sendMsg($message, $recipient,$sender,$password);
    //$sendMsg->sendMessage();

    $sendMsg = new sendMsg();
    $sendMsg->login($sender, $password);
    $sendMsg->createSession($recipient);
    $sendMsg->sendMessage($message);

    switch ($sendMsg->result) {
        case ERR_AUTHENTICATION_FAILED:
            $info = "Invalid password and/or password.";
            break;
        case ERR_SERVER_UNAVAILABLE:
            $info = "Server unavailable.";
            break;
        case ERR_INTERNAL_SERVER_ERROR:
            $info = "Something went wrong trying to connect to the server.";
            break;

        case USR_OFFLINE:
            $info = "Oops. The user appears to be offline.";
            send_mail("",$recipient,"admin","",$message,$message);
            break;

        case OK:
            $info = "The message was successfully sent.";
            break;
        default:
            $info = "Error occured when sending message.";
            send_mail("",$recipient,"admin","",$message,$message);
            break;

    }
    return $info;
}
/**
 * ���ֽ�ת�ɿ��Ķ���ʽ
 *
 * @access  public
 * @param
 *
 * @return void
 */
function num_bitunit($num)
{
    $bitunit = array(' B',' KB',' MB',' GB');
    for ($key = 0, $count = count($bitunit); $key < $count; $key++)
    {
       if ($num >= pow(2, 10 * $key) - 1) // 1024B ����ʾΪ 1KB
       {
           $num_bitunit_str = (ceil($num / pow(2, 10 * $key) * 100) / 100) . " $bitunit[$key]";
       }
    }

    return $num_bitunit_str;
}

/**
 *
 *
 * @access  public
 * @param
 * @return  void
 */
function remove_comment($var)
{
    return (substr($var, 0, 2) != '--');
}

/**
 *
 *
 * @access  public
 * @param
 *
 * @return void
 */
function sql_import($sql_file)
{
	global $adb;
    $sql_str = array_filter(file($sql_file), 'remove_comment');
    $sql_str = str_replace("\r", '', implode('', $sql_str));

    $ret = explode(";\n", $sql_str);
    $ret_count = count($ret);

	for($i = 0; $i < $ret_count; $i++)
	{
		$ret[$i] = trim($ret[$i], " \r\n;");
		//echo "ret[$i]:".$ret[$i]."<br>";
		if (!empty($ret[$i]))
		{
			$adb->runSql($ret[$i]);
		}
	}
    return true;
}
/*This function returns the mod_strings for the current language and the specified module
*/

function return_custom_module_language($language, $module)
{
    global $log;
    global $default_language;
    $log->debug("Entering return_custom_module_language method ...");

    if(is_file("cache/modules/$module/language/$language.lang.php"))
    {
        include("cache/modules/$module/language/$language.lang.php");
    }

    if(!isset($mod_strings))
    {
        $log->fatal("Unable to load the module($module) language file for the selected language($language) or the default language($default_language)");
        $log->debug("Exiting return_custom_module_language method ...");
        return null;
    }

    $return_value = $mod_strings;

    $log->debug("Exiting return_custom_module_language method ...");
    return $return_value;
}

function is_phone($fieldname)
{
    global $log;
    $log->debug("Entering get_uitype(".$fieldname.") method ...");
    global $adb;
    $dbquery = "SELECT uitype FROM ec_field inner join ec_tab on ec_tab.tabid=ec_field.tabid and ec_tab.name='Accounts' where fieldname='".$fieldname."' and uitype=85";
    $result = $adb->query($dbquery);
    if($adb->num_rows($result) > 0)
    {	
        return true;
    }
    $log->debug("Ending get_uitype(".$fieldname.") method ...");
    return false;
}

/**
 * Function to get the getCarPaino when a vtiger_account id is given 
 * Takes the input as $acount_id - vtiger_account id
 * returns the vtiger_account carpaino in string format.
 */

function getLatestNotes($account_id)
{
    global $log;
    $log->debug("Entering getLatestNotes(".$account_id.") method ...");
    $log->info("in getLatestNotes ".$account_id);
    $title = '';
    global $adb;
    if($account_id != '')
    {
        $sql = "select title from ec_notes  where ec_notes.deleted=0 and accountid=".$account_id." order by contact_date desc";
        $result = $adb->query($sql);
        $title = $adb->query_result($result,0,"title");
    }
    if(strlen($title) > 16)
    {
            //changed by dingjianting on 2007-3-19 for chinese character
            //$temp_val = substr($temp_val,0,40).'...';
            $title = msubstr1($title,0,16);
    }
    if(!empty($title)) {
        $title = "(".$title.")";
    }
    $log->debug("Exiting getLatestNotes method ...");
    return $title;
}
function getViewScopeFilterHTML($module,$selected="")
{
    global $current_user;
	$key = "getviewscopefilterhtml_".$module."_".$selected."_".$current_user->id;
	$shtml = getSqlCacheData($key);
	if(!$shtml) {
		global $app_strings;
		global $app_list_strings;
		$shtml = "";
		$tabid = getTabid($module);
		
		if("all_to_me" == $selected)
		{
			$shtml .= "<option selected value=\"all_to_me\">".$app_strings['LBL_ALL_TO_ME'].$app_list_strings['moduleList'][$module]."</option>";
		}else
		{
			$shtml .= "<option value=\"all_to_me\">".$app_strings['LBL_ALL_TO_ME'].$app_list_strings['moduleList'][$module]."</option>";
		}
		if("current_user" == $selected)
		{
			$shtml .= "<option selected value=\"current_user\">".$app_strings['LBL_CURRENT_USER'].$app_list_strings['moduleList'][$module]."</option>";
		}else
		{
			$shtml .= "<option value=\"current_user\">".$app_strings['LBL_CURRENT_USER'].$app_list_strings['moduleList'][$module]."</option>";
		}
		if("creator" == $selected)
		{
			$shtml .= "<option selected value=\"creator\">".$app_strings['LBL_CREATOR'].$app_list_strings['moduleList'][$module]."</option>";
		}else
		{
			$shtml .= "<option value=\"creator\">".$app_strings['LBL_CREATOR'].$app_list_strings['moduleList'][$module]."</option>";
		}

		if("sub_user" == $selected)
		{
			$shtml .= "<option selected value=\"sub_user\">".$app_strings['LBL_SUB_USER'].$app_list_strings['moduleList'][$module]."</option>";
		}else
		{
			$shtml .= "<option value=\"sub_user\">".$app_strings['LBL_SUB_USER'].$app_list_strings['moduleList'][$module]."</option>";
		}
		$shtml .= $users_combo ;
		if("share_to_me" == $selected)
		{
			$shtml .= "<option selected value=\"share_to_me\">".$app_strings['LBL_SHARE_TO_ME'].$app_list_strings['moduleList'][$module]."</option>";
		}else
		{
			$shtml .= "<option value=\"share_to_me\">".$app_strings['LBL_SHARE_TO_ME'].$app_list_strings['moduleList'][$module]."</option>";
		}
		if("share_of_me" == $selected)
		{
			$shtml .= "<option selected value=\"share_of_me\">".$app_strings['LBL_SHARE_OF_ME'].$app_list_strings['moduleList'][$module]."</option>";
		}else
		{
			$shtml .= "<option value=\"share_of_me\">".$app_strings['LBL_SHARE_OF_ME'].$app_list_strings['moduleList'][$module]."</option>";
		}
		setSqlCacheData($key,$shtml);
	}
    return $shtml;
}

function get_options_array($fieldname) {
    global $adb;
    global $log;
    $log->debug("entering get_options_array method ...");
	$key = "get_options_array_".$fieldname;
	$options = getSqlCacheData($key);
	if(!$options) {
		$pick_query="select colvalue from ec_picklist where colname='".$fieldname."' order by sequence asc";
		$pickListResult = $adb->query($pick_query);
		$noofpickrows = $adb->num_rows($pickListResult);
		$options = array();
		for($j = 0; $j < $noofpickrows; $j++)
		{
			$pickListValue = $adb->query_result($pickListResult,$j,"colvalue");
			$options[$pickListValue] = $pickListValue;	
		}
		setSqlCacheData($key,$options);
	}
    $log->debug("Exiting get_options_array method ...");
    return $options;
}

function get_html_options($fieldname,$selected_key='') {
    $options = get_options_array($fieldname);
    $html_options = get_select_options($options,$selected_key);
    return $html_options;
}

function getEntityTable($modulename) {
    global $adb;
    global $log;
    $log->debug("entering getEntityTable method ...");
	$key = "getEntityTable_".$modulename;
	$entityArr = getSqlCacheData($key);
	if(!$entityArr) {
		if($modulename == "Events") {
			$modulename = "Calendar";
		}
		$entityArr = array();
		$query="select * from ec_entityname where modulename='".$modulename."'";
		$entityArr = $adb->getFirstLine($query);
		$rownum = $adb->num_rows($entityArr);
		if($rownum > 0) {
			setSqlCacheData($key,$entityArr);
		}
		
	}
    $log->debug("Exiting getEntityTable method ...");
    return $entityArr;
}

function getEntityTableById($record) {
    global $adb;
    global $log;
    $log->debug("entering getEntityTableById method ...");
	$entityArr = array();
	$query="select * from ec_entityname where modulename=(select setype from ec_crmentity where crmid='".$record."')";
	$entityArr = $adb->getFirstLine($query);
    $log->debug("Exiting getEntityTableById method ...");
    return $entityArr;
}


function getReportSecurityParameter($module,$viewscope="current_user",$isreport=false)
{
    global $log;
    $log->debug("Entering getReportSecurityParameter(".$module.") method ...");
    global $adb;
    global $current_user;
    if($module == "Products" || $module == "PriceBooks" || $module == "Faq") {
        return "1=1";
    }
    $tabid=getTabid($module);
   
    if(empty($viewscope)) $viewscope="current_user";
    $entityArr = getEntityTable($module);
	$ec_crmentity = $entityArr["tablename"];
	$entityidfield = $entityArr["entityidfield"];
	$crmid = $ec_crmentity.".".$entityidfield;
	$sec_query = "";
    
    if($viewscope == "all_to_me") {
       $sec_query = "1=1";
    } elseif($viewscope == "current_user") {
        $sec_query .= " ($ec_crmentity.smownerid in($current_user->id)) ";
        if($module == 'Calendar')
        {
            $sec_query = "( ".$sec_query." or ec_salesmanactivityrel.smid=$current_user->id)";
        }
    } elseif($viewscope == "creator") {
        $sec_query .= " $ec_crmentity.smcreatorid in($current_user->id) ";
    } elseif($viewscope == "sub_user") {
		if(!isset($current_user_parent_role_seq) || $current_user_parent_role_seq == "") {
			$current_user_parent_role_seq = fetchUserRole($current_user->id);
		}
        $sec_query .= " $ec_crmentity.smownerid in(select ec_user2role.userid from ec_user2role inner join ec_users on ec_users.id=ec_user2role.userid inner join ec_role on ec_role.roleid=ec_user2role.roleid where ec_role.parentrole like '%".$current_user_parent_role_seq."::%') ";
    } elseif($viewscope == "current_group") {
        //$sec_query .= " $ec_crmentity.smownerid in (0) ";
        //$sec_query .= "and ec_groups.groupid in".getCurrentUserGroupList()." ";
        
    } elseif($viewscope == "share_to_me") {
        if($module == 'Calendar')
        {
            require_once('modules/Calendar/CalendarCommon.php');
            $shared_ids = getSharedCalendarId($current_user->id);
            if(isset($shared_ids) && $shared_ids != '')
                $sec_query .= " $ec_crmentity.smownerid in($shared_ids)";						
        }
		if($sec_query != "") {
			$sec_query = "(".$sec_query." or $crmid in (select crmid from ec_sharerecords where module='".$module."' and userid='".$current_user->id."'))";
		} else {
			$sec_query = "($crmid in (select crmid from ec_sharerecords where module='".$module."' and userid='".$current_user->id."'))";
		}
	} elseif($viewscope == "share_of_me") {		
		$sec_query .= "($ec_crmentity.smownerid='".$current_user->id."' and $crmid in (select crmid from ec_sharerecords where module='".$module."'))";
    } else {
		global $is_showsubuserdata;
		if(empty($is_showsubuserdata) || !$is_showsubuserdata) {
			$sec_query .= " $ec_crmentity.smownerid=".$viewscope;			
		} else {
				if(!isset($current_user_parent_role_seq) || $current_user_parent_role_seq == "") {
				$current_user_parent_role_seq = fetchUserRole($viewscope);
			}
			$sec_query .= " ($ec_crmentity.smownerid=$viewscope or $ec_crmentity.smownerid in (select ec_user2role.userid from ec_user2role inner join ec_users on ec_users.id=ec_user2role.userid inner join ec_role on ec_role.roleid=ec_user2role.roleid where ec_role.parentrole like '%".$current_user_parent_role_seq."::%') ) ";
		}
		if($module == 'Calendar')
		{
			 $sec_query = "( ".$sec_query." or ec_salesmanactivityrel.smid=".$viewscope.")";    
		}
    }
	
    $log->debug("Exiting getReportSecurityParameter method ...");
    return $sec_query;	
}

function getSpecUserSubUserQuery($userid){
    
    $ec_crmentity = "ec_crmentity";
    $sec_query="";
    if(!isset($current_user_parent_role_seq) || $current_user_parent_role_seq == "") {
        $current_user_parent_role_seq = fetchUserRole($userid);
    }
    $sec_query .= " ($ec_crmentity.smownerid=$userid or $ec_crmentity.smownerid in (select ec_user2role.userid from ec_user2role inner join ec_users on ec_users.id=ec_user2role.userid inner join ec_role on ec_role.roleid=ec_user2role.roleid where ec_role.parentrole like '%".$current_user_parent_role_seq."::%') ) ";
    return $sec_query;
}


/** Function to get a user id or group id for a given entity
  * @param $record -- entity id :: Type integer
    * @returns $ownerArr -- owner id :: Type array 
       */

function getRecordCreatorId($module,$record)
{
	global $log;
	$log->debug("Entering getRecordCreatorId() method ...");
	global $adb;
	if($record == 0) {
		return 0;
	}
	$entityArr = getEntityTable($module);
	$tablename = $entityArr["tablename"];
	$entityidfield = $entityArr["entityidfield"];	
	$query="select smcreatorid from ".$tablename." where ".$entityidfield." = ".$record;
	$result=$adb->query($query);
	$user_id = $adb->query_result($result,0,'smcreatorid');
	if($user_id != 0)
	{
		return $user_id;
	}

	$log->debug("Exiting getRecordCreatorId method ...");
	return 0;

}

function get_messagecount() 
{
    global $log;
    $log->debug("Entering get_messagecount() method ...");
    global $adb;
    global $current_user;
    $query = "select count(*) as count from ec_message where received=0 and type='msg' and recipient='".$current_user->id."'";
    $result = $adb->query($query);
    $count = $adb->query_result($result,0,'count');
    $log->debug("Exiting get_messagecount() method ...");
    return $count;
}

function getSqlCacheData($key)
{
	global $log;
	$log->debug("Entering getSqlCacheData(".$key.") method ...");
	global $memcache_enable;
	if($memcache_enable) {
		$mem = new Memcache;
		$mem->connect("127.0.0.1", 11211) or die ("Could not connect Memcache server");
		$return_data = $mem->get($key);
		$mem->close();
	} else {
		$max_cache_time = 3600;//max cache time (seconds)	
		global $root_directory;
		global $cache_dir;
		$key_hash = md5($key);
		$return_data = false;
		$cache_filename = $root_directory . $cache_dir . 'sqlcache_' . $key_hash . '.php';
		//$log->debug("get cache_filename:".$cache_filename);
		if(is_file($cache_filename) && ($data = file_get_contents($cache_filename)) && isset($data{23}))
		{
			$filetime = substr($data, 13, 10);
			$data     = substr($data, 23);
			$return_data = @unserialize($data);
		}
	}
	$log->debug("Exiting getSqlCacheData() method ...");
	return $return_data;
}

function setSqlCacheData($key,$data)
{
	global $log;
	$log->debug("Entering setSqlCacheData(".$key.") method ...");	
	global $memcache_enable;
	if($memcache_enable) {
		$mem = new Memcache;
		$mem->connect("127.0.0.1", 11211) or die ("Could not connect Memcache server");
		$mem->set($key, $data, 0, 0);
		$mem->close();
	} else {
		global $root_directory;
		global $cache_dir;
		$key_hash = md5($key);
		$cache_filename = $root_directory . $cache_dir . 'sqlcache_' . $key_hash . '.php';
		//$log->debug("set cache_filename:".$cache_filename);
		@file_put_contents($cache_filename, '<?php exit;?>' . time() . serialize($data));
		clearstatcache();
	}
	$log->debug("Exiting setSqlCacheData() method ...");
}

/**
 * @access  public
 * @param  bool       $is_cache  
 * @param  string     $ext       
 *
 * @return int        return file count
 */
function clear_cache_files()
{
	global $memcache_enable;
	if($memcache_enable) {
		$mem = new Memcache;
		$mem->connect("127.0.0.1", 11211) or die ("Could not connect Memcache server");
		$mem->flush();
		$mem->close();
	} else {
		global $root_directory;
		$dir = $root_directory."cache/";
		$folder = @opendir($dir);
		if ($folder == false)
		{
			return;
		}
		$count = 0;
		while ($file = readdir($folder))
		{

			if ($file == '.' || $file == '..' || $file == 'index.htm' || $file == 'index.html')
			{
				continue;
			}
			if (is_file($dir . $file))
			{			
				if (@unlink($dir . $file))
				{
					$count++;
				}
			}
		}
		closedir($folder);
	}

	$dir = $root_directory."Smarty/templates_c/";
    $folder = @opendir($dir);
	if ($folder == false)
	{
		return;
	}
	while ($file = readdir($folder))
	{

		if ($file == '.' || $file == '..' || $file == 'index.htm' || $file == 'index.html')
		{
			continue;
		}
		if (is_file($dir . $file))
		{			
			if (@unlink($dir . $file))
			{
				$count++;
			}
		}
	}
	closedir($folder);
    return $count;
}

/*
 * it acts has a complete override
 * for the additional_parameters array.
 */
function db_convert($string, $type, $additional_parameters=array()){
	//converts the paramters array into a comma delimited string.
    global $adb;
	$additional_parameters_string='';
	foreach ($additional_parameters as $value) {
		$additional_parameters_string.=",".$value;
	}
	
    if($adb->isMssql()){
        switch($type){
            case 'today': return "GETDATE()";	
            case 'left': return "LEFT($string".$additional_parameters_string.")";
            case 'date_format': 
                if($additional_parameters[0]=="'%Y-%m'"){
                    return "LEFT(CONVERT(varchar(100), $string, 23),7)";
                }elseif($additional_parameters[0]=="'%Y-%m-%d'"){
                    return "CONVERT(varchar(100), $string, 23)";
                }else{
                    return "";
                }  
            case 'datetime': return "CONVERT(varchar(100), $string, 120)";
            case 'IFNULL': return "ISNULL($string".$additional_parameters_string.")";
            case 'CONCAT': return "CONCAT($string,".implode(",",$additional_parameters).")";
        }
    }else{
        switch($type){
            case 'today': return "CURDATE()";	
            case 'left': return "LEFT($string".$additional_parameters_string.")";
            case 'date_format': return "DATE_FORMAT($string".$additional_parameters_string.")";
            case 'datetime': return "DATE_FORMAT($string, '%Y-%m-%d %H:%i:%s')";
            case 'IFNULL': return "IFNULL($string".$additional_parameters_string.")";
            case 'CONCAT': return "CONCAT($string,".implode(",",$additional_parameters).")";
        }
    }
	return $string;
} 

function db_concat($table, $fields){
	$ret = '';
	foreach($fields as $index=>$field){
		if(empty($ret))$ret = "CONCAT(". db_convert($table.".".$field,'IFNULL', array("''"));	
		else $ret.=	",' ',".db_convert($table.".".$field,'IFNULL', array("''"));
	}	
	if (!empty($ret)) $ret.=')';
	return $ret;
}

function iconv_ec($in_charset,$out_charset,$content) {
	if(function_exists('mb_convert_encoding')) {
		$content = mb_convert_encoding($content,$out_charset,$in_charset);
	} else if(function_exists('iconv')) {
		if($out_charset == "GBK" || $out_charset == "GB2312") {
			$out_charset = $out_charset."//IGNORE";
		}
		$content = iconv($in_charset,$out_charset,$content);
	} else {
		include_once('include/iconv/iconv.php');
		global $root_directory;
		$iconv = new Chinese();
		$in_charset = str_replace("-","",$in_charset);
		$out_charset = str_replace("-","",$out_charset);
		$content = $iconv->convert($in_charset, $out_charset, $content);
	}
	return $content;
}

function base64_encode_filename($str) {
	$ext_pos = strrpos($str, ".");
	$filename = substr($str, 0 , $ext_pos);
	$ext = substr($str, $ext_pos + 1);
	$filename = base64_encode($filename);
	$filename = $filename.".".$ext;
	if(substr_count($filename,"/") > 0) {
		$filename = str_replace("/","",$filename);

	}
	return $filename;
}


function datediff($date1, $date2) { 
	// $date1 is subtracted from $date2. 
	// if $date2 is not specified, then current date is assumed.

	//Splits date apart
	if (!$date1) { 
		return 0;
	} else {
		list($date1_year, $date1_month, $date1_day) = split('[/.-]', $date1); 
	}

	if (!$date2) { 
	  $date2_year = date("Y"); //Gets Current Year
	  $date2_month = date("m"); //Gets Current Month
	  $date2_day = date("d"); //Gets Current Day
	} else {
	  list($date2_year, $date2_month, $date2_day) = split('[/.-]', $date2);
	}

	$date1 = mktime(0,0,0,$date1_month, $date1_day, $date1_year); //Gets Unix timestamp for $date1
	$date2 = mktime(0,0,0,$date2_month, $date2_day, $date2_year); //Gets Unix timestamp for $date2

	$difference = $date2-$date1; //Calcuates Difference
	return floor($difference/60/60/24); //Calculates Days Old
}

/**
 * Redirect to another URL
 *
 * @access	public
 * @param	string	$url	The URL to redirect to
 */
function redirect( $url)
{
	/*
	 * If the headers have been sent, then we cannot send an additional location header
	 * so we will output a javascript redirect statement.
	 */
	if (headers_sent()) {
		echo "<script>document.location.href='$url';</script>\n";
	} else {
		//@ob_end_clean(); // clear output buffer
		//session_write_close();
		header( 'HTTP/1.1 301 Moved Permanently' );
		header( "Location: ". $url );
	}
	exit();
}

/**
 * Track the viewing of a detail record.  This leverages get_summary_text() which is object specific
 * params $user_id - The user that is viewing the record.
 */
function track_view($user_id, $current_module,$id='')
{
	global $log;
	$log->debug("Entering into function track_view()");
	$tracker = new Tracker();
	$tracker->track_view($user_id, $current_module, $id, '');
	$log->debug("Exiting function track_view()");
}



function unzip( $zip_archive, $zip_dir ){
	require_once('include/pclzip/pclzip.lib.php');
    if( !is_dir( $zip_dir ) ){
        die( "Specified directory '$zip_dir' for zip file '$zip_archive' extraction does not exist." );
    }

    $archive = new PclZip( $zip_archive );

    if( $archive->extract( PCLZIP_OPT_PATH, $zip_dir ) == 0 ){
        die( "Error: " . $archive->errorInfo(true) );
    }
}

function unzip_file( $zip_archive, $archive_file, $to_dir ){
	require_once('include/pclzip/pclzip.lib.php');
    if( !is_dir( $to_dir ) ){
        die( "Specified directory '$to_dir' for zip file '$zip_archive' extraction does not exist." );
    }

    $archive = new PclZip( "$zip_archive" );
    if( $archive->extract(  PCLZIP_OPT_BY_NAME, $archive_file,
                            PCLZIP_OPT_PATH,    $to_dir         ) == 0 ){
        die( "Error: " . $archive->errorInfo(true) );
    }
}

function zip_dir( $zip_dir, $zip_archive ){
	require_once('include/pclzip/pclzip.lib.php');
    $archive    = new PclZip( "$zip_archive" );
    $v_list     = $archive->create( "$zip_dir" );
    if( $v_list == 0 ){
        die( "Error: " . $archive->errorInfo(true) );
    }
}
function get_image($image,$other_attributes,$width="",$height=""){
	global $png_support;

	if ($png_support == false)
	$ext = "gif";
	else
	$ext = "png";
	$out = '';

	if (is_file($image.'.'.$ext)){
		$size=getimagesize($image.'.'.$ext);
		if ($width == "") { $width = $size[0];}
		if ($height == "") { $height = $size[1];}
		$out= "<img src='$image.$ext' width='".$width."' height='".$height."' $other_attributes>";
	}else if(substr_count($image,'themes') > 0){
		$path = explode('/',$image);
		$path[1] = 'Default';
		$image = implode('/',$path);

		if (is_file($image.'.'.$ext)){
			$size=getimagesize($image.'.'.$ext);
			if ($width == "") { $width = $size[0];}
			if ($height == "") { $height = $size[1];}
			$out= "<img src='$image.$ext' width='".$width."' height='".$height."' $other_attributes>";
		}

	}
	return $out;
}
/** 
  *rmdir -R include subdir 
**/
function rmdirr($dir) {
   if($objs = glob($dir."/*")){
       foreach($objs as $obj) {
           is_dir($obj)? rmdirr($obj) : unlink($obj);
       }
   }
   rmdir($dir);
}

function get_scale_height($imgPath,$width)
{
	if(function_exists("getimagesize") && $width !=0 && is_file($imgPath)) {
		$imageinfo = getimagesize($imgPath);         
		$ix = $imageinfo[0];
		$iy = $imageinfo[1];
		if($ix != 0) {
			$widthscale = $width/$ix;
		} else {
			$widthscale = 1;
		}
		$height = floor($widthscale*$iy);
		return $height;
	} 
	return $width;
}

 function getUreportSecurityParameter($module,$viewscope="current_user",$isreport=false)
 {
	global $log;
	$log->debug("Entering getUreportSecurityParameter() method ...");
	global $current_user;
	$tabid=getTabid($module);

	
	$where_sql =  "1=1";
	
	$log->debug("Exit getUreportSecurityParameter() method ...");
	return $where_sql;
 }


function getPickListWithField($fieldname,$fieldvalue = "")
{
	global $adb;
	$key = "picklist_array_".$fieldname;
	$picklist_array = getSqlCacheData($key);
	if(!$picklist_array) {
		$pick_query="select colvalue from ec_picklist where colname='".$fieldname."' order by sequence asc";
		$pickListResult = $adb->getList($pick_query);			
		$picklist_array = array();
		foreach($pickListResult as $row) {
			$picklist_array[] = $row['colvalue'];
		}
		
		setSqlCacheData($key,$picklist_array);
	}

	$options = '';
	foreach($picklist_array as $pickListValue)
	{
		if($fieldvalue == $pickListValue)
		{
			$chk_val = "selected";	
			$found = true;
		}
		else
		{	
			$chk_val = '';
		}
		$options .= '<option value="'.$pickListValue.'" '.$chk_val.'>'.$pickListValue.'</option>';	
	}
	return $options;
}
function getPickStringsWithField($fieldname)
{
	global $adb;
	$key = "picklist_array_".$fieldname;
	$picklist_array = getSqlCacheData($key);
	if(!$picklist_array) {
		$pick_query="select colvalue from ec_picklist where colname='".$fieldname."' order by sequence asc";
		$pickListResult = $adb->getList($pick_query);			
		$picklist_array = array();
		foreach($pickListResult as $row) {
			$picklist_array[] = $row['colvalue'];
		}			
		setSqlCacheData($key,$picklist_array);
	}

	$options = implode(',',$picklist_array);	
	return $options;
}

function getComposeMailUrl($to) 
{
	$mailer = useInternalMailer();
	if($mailer == 1)
	{
		//return 'index.php?module=Webmails&action=newmsg&&folder=INBOX&nameto=&mailto='.$to;
		return 'mailto:'.$to;
	}
	elseif($mailer == 2) 
	{
		global $googleapp_domain;
		if($googleapp_domain !="" && $googleapp_domain != "gmail.com") 
		{
			return 'https://mail.google.com/a/'.$googleapp_domain.'/mail?view=cm&fs=1&tf=1&to='.$to;
		} else {
			return 'https://mail.google.com/mail/?view=cm&fs=1&tf=1&to='.$to;
		}
	}
	else {
		return 'mailto:'.$to;
	}	
}
function getSearchMailUrl($to) 
{
	$mailer = useInternalMailer();
	if($mailer == 1)
	{
		return 'index.php?module=Webmails&action=search&searched=yes&searchtext='.$to;
	}
	elseif($mailer == 2) 
	{
		global $googleapp_domain;
		if($googleapp_domain !="" && $googleapp_domain != "gmail.com") 
		{
			//return 'https://mail.google.com/a/'.$googleapp_domain.'/?ui=2#search/'.$to;
			return 'https://mail.google.com/a/'.$googleapp_domain.'/?ui=1&search=query&q='.$to.'&view=tl&fs=1';
			
		} else {
			//return 'https://mail.google.com/mail/#search/'.$to; //ui=2
			return 'https://mail.google.com/mail/?ui=1&search=query&q='.$to.'&view=tl&fs=1';
		}
	}
	else {
		return 'mailto:'.$to;
	}	
}

function getFirstSpell($chineseStr)
{
	require_once("include/utils/ChineseSpellUtils.php");
	$spell = new ChineseSpell();
	$length = str_len($chineseStr);
	if($length > 1) 
	{
		$chineseStr = msubstr1($chineseStr,0,1,false);
		$chineseStr = iconv_ec("UTF-8","GBK",$chineseStr);
	}
	$str = $spell->getFirstSpell($chineseStr,1);
	$str = strtoupper($str);
	return $str;
}

function getEveryWordFirstSpell($chineseStr)
{
	require_once("include/utils/ChineseSpellUtils.php");
	$spell = new ChineseSpell();
    if(function_exists("mb_strlen")){
        $length =mb_strlen($chineseStr,"UTF-8");
    }else{
        $length = str_len($chineseStr);
    }
    $pingyinstr="";
	for($i=0;$i<$length;$i++) 
	{
		$substr = msubstr1($chineseStr,$i,1,false);
		$substr = iconv_ec("UTF-8","GBK",$substr);
        $str = $spell->getFirstSpell($substr,1);
        $str = strtoupper($str);
         $pingyinstr.=$str;
	}
	
	return $pingyinstr;
}
?>
