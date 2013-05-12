<?php
/**   Function used to send email 
  *   $module 		-- current module 
  *   $to_email 	-- to email address 
  *   $from_name	-- currently loggedin user name
  *   $from_email	-- currently loggedin ec_users's email id. you can give as '' if you are not in HelpDesk module
  *   $subject		-- subject of the email you want to send
  *   $contents		-- body of the email you want to send
  *   $cc		-- add email ids with comma seperated. - optional 
  *   $bcc		-- add email ids with comma seperated. - optional.
  *   $attachment	-- whether we want to attach the currently selected file or all ec_files.[values = current,all] - optional
  *   $emailid		-- id of the email object which will be used to get the ec_attachments
  */
  
function send_webmail($to_email,$subject,$contents,$cc='',$bcc='',$attachment='',$emailid='')
{	

	global $adb, $log; 
	global $current_user;
	$log->debug("Entering send_webmail() method ...");
	
	$key = "webmail_array_".$current_user->id;
	$webmail_array = getSqlCacheData($key);
	if(!$webmail_array) {
	    $webmail_array = $adb->getFirstLine("select * from ec_systems where server_type='email' and smownerid='".$current_user->id."'");
		if(empty($webmail_array)) {
			return "No Smtp Server!";
		}
		setSqlCacheData($key,$webmail_array);	
	}
	$from_email = $webmail_array['from_email'];
	if($from_email == ''){
		$from_email = $webmail_array['server_username'];
	}

	require_once('include/phpmailer/class.phpmailer.php');

	$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

	$mail->IsSMTP(); // telling the class to use SMTP
	$result = "";

	try {
	  $mail->CharSet = "UTF-8";
	  $mail->Host       = $webmail_array['server']; // SMTP server
	  //$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
	  $mail->SMTPAuth   = true;                  // enable SMTP authentication
	  $mail->Port       = $webmail_array['server_port'];                    // set the SMTP port for the GMAIL server
	  $mail->Username   = $webmail_array['server_username']; // SMTP account username
	  $mail->Password   = $webmail_array['server_password'];        // SMTP account password
	  $mail->AddReplyTo($from_email, "");
	  $mail->AddAddress($to_email, "");
	  $mail->SetFrom($from_email, "");
	  $mail->Subject = $subject;
	  $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
	  $mail->MsgHTML($contents);
	  $mail->Send();
	} catch (phpmailerException $e) {
	  $result = $e->errorMessage(); //Pretty error messages from PHPMailer
	} catch (Exception $e) {
	  $result = $e->getMessage(); //Boring error messages from anything else!
	}
	
	$log->debug("Exit send_webmail() method ...");
	return $result;
}


?>
