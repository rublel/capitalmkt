<?php
function send_maj ($dest_mail,$dest_name,$subject,$body, $sender){
	$email_sender = "capital.mkt.wlc@gmail.com"; //modifier
	$email_password = "DL555555";//modifier
    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';
    $mail->IsSMTP();
  	try {
  		$error = null;
  		$mail->setLanguage('fr');
  		$mail->SMTPAuth   = true;                  // enable SMTP authentication               // sets the prefix to the servier
  		$mail->SMTPSecure = 'tls';
		$mail->Host = 'smtp.gmail.com';
		$mail->Username   = $email_sender;  // GMAIL username
  		$mail->Password   = $email_password;            // GMAIL password
  		$mail->AddAddress($dest_mail, $dest_name);
		$mail->SetFrom($email_sender, $sender); //modifier
  		$mail->Subject = "$subject";
        $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
        //str_replace('$nom', "un nom", file_get_contents('./Simulation_ITE_Prospect.php'));
  		$mail-> msgHTML($body, __DIR__);
  		$mail->Send();  
  	}
    catch (phpmailerException $e) {
  		$error =  $e->errorMessage();
			print_r($error);
  	}
    catch (Exception $e) {
  		$error =  $e->getMessage();
			print_r($error);
  	}
 }