<?php
require_once('config.inc.php');
require_once('include/utils/utils.php');
require_once('include/database/PearDatabase.php');
global $adb;

function encrypt_password($user_password)
{
	$salt='$1$rasm$';
	$encrypted_password = crypt($user_password, $salt);	
	return $encrypted_password;
}
$password = "admin";
$salt = substr(md5(time()),0,4);
echo $salt."<br>";
echo time()."<br>";
$password = md5(md5(trim($password)) . $salt);
echo $password;die;

$encrypted_new_password = encrypt_password("admin");
$user_hash = strtolower(md5("admin"));
//set new password
$query = "UPDATE ec_users SET user_password='$encrypted_new_password', user_hash='$user_hash',status='Active' where id='1'";
echo $query;
$adb->query($query);
echo "ok";

exit;
?>
