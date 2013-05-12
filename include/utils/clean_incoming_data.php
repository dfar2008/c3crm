<?php
function clean_incoming_data() {
	if (get_magic_quotes_gpc() == 1) {
		$req  = array_map("preprocess_param", $_REQUEST);
		$post = array_map("preprocess_param", $_POST);
		$get  = array_map("preprocess_param", $_GET);
	} else {
		$req  = array_map("securexss", $_REQUEST);
		$post = array_map("securexss", $_POST);
		$get  = array_map("securexss", $_GET);
	}

	// PHP cannot stomp out superglobals reliably
	foreach($post as $k => $v) { $_POST[$k] = $v; }
	foreach($get  as $k => $v) { $_GET[$k] = $v; }

	foreach($req  as $k => $v) {
		 $_REQUEST[$k] = $v;
		 //ensure the keys are safe as well
		 securexsskey($k);
	}
}
function preprocess_param($value){
	if(is_string($value)){
		if(get_magic_quotes_gpc() == 1){
			$value = stripslashes($value);
		}
		$value = securexss($value);
	}
	return $value;
}
function securexss($value) {
	if(is_array($value)){
    	$new = array();
        foreach($value as $key=>$val){
       		$new[$key] = securexss($val);
        }
        return $new;
    }
	static $xss_cleanup=  array('"' =>'&quot;', "'" =>  '&#039;' , '<' =>'&lt;' , '>'=>'&gt;');
	$value = preg_replace(array('/javascript:/i', '/\0/'), array('java script:', ''), $value);
	$value = preg_replace('/javascript:/i', 'java script:', $value);
	return str_replace(array_keys($xss_cleanup), array_values($xss_cleanup), $value);
}
function securexsskey($value, $die=true){
	$matches = array();
	preg_match("/[\'\"\<\>]/", $value, $matches);
	if(!empty($matches)){
		if($die){
			die("Bad data passed in; <a href=\"{$sugar_config['site_url']}\">Return to Home</a>");
		}else{
			unset($_REQUEST[$value]);
			unset($_POST[$value]);
			unset($_GET[$value]);
		}
	}
}
?>