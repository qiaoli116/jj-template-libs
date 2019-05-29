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
    $mail->SMTPDebug = 0;                                                   // Enable verbose debug output
    $mail->isSMTP();                                                        // Set mailer to use SMTP
   
    // set smtp user name and password
    $mail->SMTPAuth = true;                                                 // Enable SMTP authentication
    $mail->Username = 'smtp_name@mail.com';                                 // SMTP username
    $mail->Password = '************';                                       // SMTP password
    
    $mail->Host = 'smtp.com';                                               // Specify main and backup SMTP servers

    /* enable either ssl or tls according to smtp configuration */
    /* ssl default port is 587 */
    //$mail->SMTPSecure = "ssl";                                            // Enable TLS encryption, `ssl` also accepted
    //$mail->Port = 465;                                                    // TCP port to connect to

    /* tls default port is 587 */
    // $mail->SMTPSecure = "tls";                                           // Enable TLS encryption, `ssl` also accepted
    // $mail->Port = 587;                                                   // TCP port to connect to

    $mail->addBCC('someone_else@other.mail.com');                           // incase customer could not receive email

    //Recipients
    $mail->setFrom("smtp_name@mail.com", "Your Name");                      // this from address is associated with smtp setting, usually the same as the smtp user name
    $mail->addAddress('recipient_name@recipient.com', 'Recipient Name');    // Add a recipient
    $mail->addReplyTo($email, $name);

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = "[Enquiry From ...]";
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