<?php
error_reporting(E_STRICT | E_ALL);

date_default_timezone_set('Etc/UTC');

require_once 'vendor/autoload.php';

$mail = new PHPMailer;

$today = date('Y-m-d');


$mail->Body = 'suck it trebek'; //need to change this obviously

$mail->isSMTP();
$mail->SMTPSecure = 'tls'; //ssl has been deprecated since '98 ---not listed in mailing_lists to use...
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;//port 465 didn't seem to work.
$mail->SMTPAuth = true;
$mailail->SMTPKeepAlive = true; // SMTP connection will not close after each email sent, reduces SMTP overhead

$mail->Username = 'XXXXX';
$mail->Password = 'XXXXX';
$mail->SMTPDebug = 2; 
$mail->Debugoutput = 'html'; //Ask for HTML-friendly debug output

$mail->Subject = 'I like TORTLES';

//defining "from" and "from name"
//$mail->From = 'bartdangus@gmail.com';//email that the mail is being sent from which can be anything
$mail->FromName = 'mr';
$mail->addReplyTo('reply@REPLY.com','Reply address');//this is a method, reply to email
//$mail->addAddress('brskythomas@gmail.com', 'Brett Thomas');//this can be called infintly


$mail->Altbody = 'plain text email';

//Use this to unblock SMTP access if google tightens up again. Ideally I would want to create more secure setting, but this works for the demonstration
//http://stackoverflow.com/questions/21937586/phpmailer-smtp-error-password-command-failed-when-send-mail-from-my-server


//Connect to the database and select the recipients from your mailing list that have not yet been sent to
//You'll need to alter this to match your database
$mailysql = mysqli_connect('localhost', 'phpmailer', 'MailMe247');
mysqli_select_db($mailysql, 'mailer');
$result = mysqli_query($mailysql, 'SELECT first_name, email FROM clients WHERE hours_left <= .5');

//foreach ($result as $row) { //This iterator syntax only works in PHP 5.4+
    //$mail->addAddress($row['email'], $row['first_name']);
	//var_dump($mail->send()); //where the fuck does this go
    // if (!$mail->send()) {
    //     echo "Mailer Error (" . str_replace("@", "&#64;", $row["email"]) . ') ' . $mail->ErrorInfo . '<br />';
    //     break; //Abandon sending
    // } else {
    //     echo "Message sent to :" . $row['first_name'] . ' (' . str_replace("@", "&#64;", $row['email']) . ')<br />';
    //     //Mark it as sent in the DB
    //     mysqli_query(
    //         $mailysql,
    //         "UPDATE clients SET last_emailed = $today WHERE email = '" .
    //         mysqli_real_escape_string($mailysql, $row['email']) . "'"
    //     );
    // }

//GET MYSQL 
//ask for success/error code from send feature

    // Clear all addresses and attachments for next loop
    //$mail->clearAddresses();
    //$mail->clearAttachments();
}
//$didMailSend = $mail->send();

var_dump("Test");
var_dump($mail);
//send the message, check for errors
// if (!$didMailSend) {
//     echo "Mailer Error: " . $mail->ErrorInfo;
// } else {
// 	foreach ($result as $row) {
// 		// perform query to update last emailed
// 	    echo "Message sent to :" . $row['first_name'] . ' (' . str_replace("@", "&#64;", $row['email']) . ')<br />';
// 	    //Mark it as sent in the DB
// 	    mysqli_query(
// 	        $mailysql,
// 	        "UPDATE clients SET last_emailed = $today WHERE email = '" .
// 	        mysqli_real_escape_string($mailysql, $row['email']) . "'"
// 	    );
// 	}
// 	echo "Messages sent!";
// }





