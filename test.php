<?php

date_default_timezone_set('Etc/UTC');

require_once 'vendor/autoload.php';

$mail = new PHPMailer;

//date_default_timezone_set('America/Detroit');
$today = date('y/m/d');

$mail->isSMTP();
$mail->SMTPSecure = 'tls'; //ssl has been deprecated since '98 ---not listed in mailing_lists to use...
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;//port 465 didn't seem to work.
$mail->SMTPAuth = true;
$mailail->SMTPKeepAlive = true; // SMTP connection will not close after each email sent, reduces SMTP overhead

$mail->Username = 'ENTER EMAIL';
$mail->Password = 'ENTER PASSWORD';
//$mail->SMTPDebug = 2; turn this line and below on for errors
//$mail->Debugoutput = 'html'; //Ask for HTML-friendly debug output

$mail->Subject = 'Support Hours';
$mail->FromName = 'dOpenSource';
$mail->addReplyTo('support@dopensource.com','Reply address');//this is a method, reply to email
$mail->Altbody = 'plain text email';

$mlink = "http://dopensource.com/purchase-support/";
$nl = "\r\n";

//http://php.net/manual/en/mysqli.examples-basic.php
$mysqli = new mysqli('localhost', 'phpmailer', 'MailMe247', 'mailer');//connects to db
    if ($mysqli->connect_errno) {
        echo "Sorry, this website is experiencing problems.";
        // anyways, is print out MySQL error related information -- you might log this
        echo "Error: Failed to make a MySQL connection, here is why: \n";
        echo "Errno: " . $mysqli->connect_errno . "\n";
        echo "Error: " . $mysqli->connect_error . "\n";
        exit;
    }//assuming there is no connection error it moves on...

// Perform an SQL query
$sql = 'SELECT first_name, email, last_emailed, hours_left FROM clients WHERE hours_left <= .5';


if (!$result = $mysqli->query($sql)) {
    echo "Sorry, the website is experiencing problems.";
    exit;
}

//start of sending emails
while ($row = $result->fetch_assoc()) {
    //var_dump($row);
    $mail->Body = "Hello {$row['first_name']}," . $nl . $nl . "You currently have {$row['hours_left']} support hours left. You can purchase more time by going to " . $mlink . $nl . $nl ."Thank you, I love you.";
    $mail->addAddress($row['email'], $row['first_name']);
    
    if (!$mail->send()) {
        echo "Mailer Error (" . str_replace("@", "&#64;", $row["email"]) . ') ' . $mail->ErrorInfo . '<br />';
        break; //Abandon sending
    } else {
        echo $today . "Message sent to :" . $row['first_name'] . ' (' . str_replace("@", "&#64;", $row['email']) . ')<br />';
        
        //prepare statement safer way of updating the db
        if (!($stmt = $mysqli->prepare("UPDATE clients SET last_emailed = ? WHERE email = ?"))) {
           echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }
        if (!$stmt->bind_param('ss', $today, $row['email'])) {
           echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $stmt->close();
    }
    // Clears the addresses for the next loop
    $mail->clearAddresses();
}
//end of emails

    if (!$result = $mysqli->query($sql)) {
        // Oh no! The query failed. 
        echo "Sorry, the website is experiencing problems.";
        // to get the error information
        echo "Error: Our query failed to execute and here is why: \n";
        echo "Query: " . $sql . "\n";
        echo "Errno: " . $mysqli->errno . "\n";
        echo "Error: " . $mysqli->error . "\n";
        exit;
    }


?>