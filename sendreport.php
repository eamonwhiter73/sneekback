<?php 
	    $to = "eamon.white7@gmail.com"; // this is your Email address
	    $from = $_POST['user'] . "@complainer.com"; // this is the sender's Email address
	    $subject = $_POST['markerid'];
	    $message = 'pic complaint';

	    $headers = "From:" . $from .  "\r\n";
	    $headers .= 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-Type: text/html; charset=ISO-8859-1' . "\r\n";
	    mail($to,$subject,$message,$headers);
?>