<?php


var_dump(function_exists('mysqli_query'));
//$mailysql = mysqli_connect("localhost", "phpmailer", "MailMe247", "mailer");
//$result = mysqli_query($mailysql, 'SELECT first_name, email, hours_left FROM clients WHERE hours_left <= 10');
//var_dump($mailysql);

$mysql = mysqli_connect('localhost', 'phpmailer', 'MailMe247', 'mailer');
echo $mysql;


$mail->Debugoutput = 'html'; //Ask for HTML-friendly debug output
$mail->SMTPDebug = 2; 




/* check connection */
// if (mysqli_connect_errno()) {
//     printf("Connect failed: %s\n", mysqli_connect_error());
//     exit();
// }


//ubuntu lamp stack - using lumin -

//so this is the code that I've been using just to test that now the mysqli methods work