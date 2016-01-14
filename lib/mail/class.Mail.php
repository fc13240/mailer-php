<?php
error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set("Asia/Chongqing");
require_once("class.phpmailer.php");
class Mail{
	const CODE_SUCCESS = 1;
	const CODE_FAIL = 2;
	/*发送邮件主方法，但要注意群发邮件时，会出现执行时太长，而当web超时时进程停止，造成发送过程不完整*/
	public static function send($toAddresses,$subject,$content){
		$conf = require('conf.php');
		$mail = new PHPMailer(true);
		$mail->CharSet="utf-8"; 
		$mail->Encoding = 'base64';
		$mail->IsSMTP();
		$mail->SMTPAuth = true;
		$mail->Host = $conf['host'];
		$mail->Port = $conf['port'];
		$mail->Username = $conf['username'];
		$mail->Password = $conf['pwd']; 
		// $mail->SMTPSecure = 'ssl'; 
		$mail->From = $conf['username'];
		$mail->FromName = $conf['fromname'];
		$mail->IsHTML(true);
		// $mail->Is_SSL = true;
		$mail->Subject = $subject;
		$mail->Body = $content;
		if(!is_array($toAddresses)){
			$toAddresses = array($toAddresses);
		}
		foreach ($toAddresses as $email) {
			$mail->AddAddress($email);
			try{
				$result = $mail->Send();
			}catch(phpmailerException $e){
				
			}
			
			if(!$result){
				$result = $mail->Send();
			}
			$resultArr[$email] = $result;
			$mail->ClearAddresses();
    		$mail->ClearAttachments();
		}
		return $resultArr;
	}
	/*在当GearmanClient存在时在后台发送*/
	public static function send_gearman($toAddresses,$subject,$content){
		if(class_exists('GearmanClient', false)){
			$conf = require('conf.php');
			$confGearman = $conf['gearman'];
			$client = new GearmanClient();
			$client->addServer($confGearman['host'], $confGearman['port']);
			$data = array('toAddresses'=>$toAddresses,'subject'=>$subject,'content'=>$content);
			return $client->doBackground("send_mail", serialize($data));
		}else{
			return Mail::send($toAddresses,$subject,$content);
		}
	}
}
?>