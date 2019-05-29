<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
//Load Composer's autoloader
require 'vendor/autoload.php';

$mail = new PHPMailer(true);                              // Passing `true` enables exceptions

$name = isset($_POST['name'])? $_POST['name'] : "";
$phone = isset($_POST['phone'])? $_POST['phone'] : "";
$email = isset($_POST['email'])? $_POST['email'] : "";
$msg = isset($_POST['msg'])? $_POST['msg'] : "";
// value fax is a 


$result = array(
        "code" => 0,
        "des" => "Server error",
        "debug" => "before trying to send email",
    );

if( !(isset($_POST['fax']) && $_POST['fax']=="")) {
    $result = array(
        "code"  => 1,
        "des"   => "",
        "debug" => "",
    );
    echo json_encode($result);
    return;
}

if( $name == "" || $phone == "" || $email == "" || $msg == "") {
    $result = array(
        "code"  => 0,
        "des"   => "One or more of the mandatory fields are empty. Pleaes check.",
        "debug" => array(
            "name" => $name,
            "phone" => $phone,
            "email" => $email,
            "msg" => $msg,
        ),
    );
    echo json_encode($result);
    return;
}

try {
    //Server settings
    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
   
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'sender@solsticefrankston.com.au';                 // SMTP username
    $mail->Password = 'BP7V6h{x%!#-';                           // SMTP password
    
    $mail->Host = 'webcloud56.au.syrahost.com';  // Specify main and backup SMTP servers
    $mail->SMTPSecure = "ssl";                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465;                                    // TCP port to connect to
    $mail->addBCC('support@protrio.com.au'); // incase customer could not receive email
    //$mail->Host = 'mail.solsticefrankston.com.au';  // Specify main and backup SMTP servers
    //$mail->SMTPSecure = "";                            // Enable TLS encryption, `ssl` also accepted
    //$mail->Port = 25;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom("sender@solsticefrankston.com.au", "Solstice");
    $mail->addAddress('llawlor@bigginscott.com.au', 'llawlor');     // Add a recipient
    $mail->addReplyTo($email, $name);

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = "[Enquiry From solsticefrankston.com.au]";
    $mail->Body    = "
                <p><strong>New message from</strong> {$name}</p>
                <p><strong>Phone Number</strong> {$phone}</p>
                <p><strong>Email address</strong> {$email}</p>
                <p><strong>Message</strong> {$msg}</p>";
    $mail->AltBody = "
                New message from: {$name}. \n
                Phone Number: {$phone}. \n
                Email address: {$email}. \n
                Message: {$msg}. \n";

    $mail->send();
    
    $result = array(
        "code"  => 1,
        "des"   => "",
        "debug" => "",
    );
    
} catch (Exception $e) {
    
    $result = array(
        "code" => 0,
        "des" => "Your message was not successful. Plese try again later",
        "debug" => "Mailer Error: " . $mail->ErrorInfo,
    );
    
}
echo json_encode($result);