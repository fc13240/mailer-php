<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
if($_SESSION["session_flag"] == $_POST['hook']){
	$subject = $_POST['send_subject'];
	$send_address = array_unique($_POST['send_address']);
	$send_type = $_POST['send_type'];
	if($send_type == 1){
		$send_content = $_POST['send_text'];
	}else{
		$send_content = file_get_contents($_POST['send_file']);
	}
	if(!empty($subject) && !empty($send_content) && is_array($send_address)){
		require_once('../lib/mail/class.Mail.php');
		$result = Mail::send_gearman($send_address,$subject,$send_content);
		if(is_array($result)){
			foreach ($result as $key => $value) {
				echo ($value?'OK  ':'Fail').' '.$key.'<br/>';
			}
		}else{
			echo 'sending mail in background use gearman!<br/>';
		}
		echo '<a href="./">back</a>';
	}else{
		echo 'something is wrong!';
	}
}else{
	echo '<font color="red">Please dont\'t repeat commit!</font><br/><a href="./">back</a>';
}	
$_SESSION["session_flag"] = md5(time().rand());
?>