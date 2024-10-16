<?php
// Load Composer's autoloader (Make sure you have installed PHPMailer)
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;


// Set header to JSON output
header('Content-Type: application/json');

// Validate and sanitize input (can be from GET or POST)
$pin = isset($_REQUEST['pin']) ? htmlspecialchars(trim($_REQUEST['pin'])) : null;
$email = isset($_REQUEST['email']) ? filter_var(trim($_REQUEST['email']), FILTER_VALIDATE_EMAIL) : null;

if (!$pin || !$email) {
    echo json_encode(['status' => 'error', 'message' => 'Missing or invalid parameters']);
    exit;
}

// Create a new PHPMailer instance
$mail = new PHPMailer(true);

// try {
    // Server settings$phpmailer = new PHPMailer();

    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                       //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'your username';                     //SMTP username
    $mail->Password   = 'your passkey';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;       

    // Recipients
    $mail->setFrom('rinkalbhimani24@gmail.com', 'ShineTechno Lab');
    $mail->addAddress($email); // Add recipient email

    // Content
    $mail->isHTML(false); // Set email format to plain text
    $mail->Subject = 'Your PIN Information';
    $mail->Body = "Hello,\n\nYour PIN is: $pin";

    // Send the email
    if ($mail->send()) {
        echo json_encode(['status' => 'success', 'message' => 'Email sent successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Email could not be sent.']);
    }
// } catch (Exception $e) {
//     echo json_encode(['status' => 'error', 'message' => 'Email could not be sent. Error: ' . $mail->ErrorInfo]);
// }

?>
