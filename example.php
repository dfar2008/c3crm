<?php
// dummy example of RestClient
require_once('include/untis/CommonUtils.php');
require_once('include/RestClient.class.php');
$enteredUsername = "demo@c3crm.cn";//test account
$enteredPassword = "demo";

$paras = array();
//$paras["callback"] = "?";
$paras["method"] = "login";
$paras["input_type"] = "JSON";
$paras["response_type"] = "JSON";
$json = getJSONObj();

$paras["rest_data"] = $json->encode(array(array("password"=>$enteredPassword,"user_name"=>$enteredUsername),"C3CRM",array("name"=>"language","value"=>"en_US")));

$twitter = RestClient::post('http://crm123.sinaapp.com/rest.php',$paras);

//$twitter = RestClient::post( // Same for RestClient::get()
//            'http://crm123.sinaapp.com/rest.php?callback=?'
//            ,'{
//				method: "login",
//				input_type: "JSON",
//				response_type: "JSON",
//				rest_data: \'[{"password":"'.$enteredPassword.'","user_name":"'.$enteredUsername.'"},"C3CRM",{"name":"language","value":"en_US"}]\'
//			}' 
//            ,''
//            ,''
//			,'application/json');

var_dump($twitter->getResponse());
echo "<br>aaaaaaaaaaaa<br>";
var_dump($twitter->getResponseCode());
echo "<br>bbbbbbbbbbb<br>";
var_dump($twitter->getResponseMessage());
echo "<br>cccccccccccc<br>";
var_dump($twitter->getResponseContentType());
?>