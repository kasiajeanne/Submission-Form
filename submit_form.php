<?php
// Enable error reporting and log errors to a file
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error_log.txt');

// Include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

// Initialize PHPMailer
$mail = new PHPMailer(true);

try {
    // Form data
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $pieces = $_POST['pieces'] ?? '';
    $delivery_deadline = $_POST['delivery_deadline'] ?? '';
    $hard_deadline = isset($_POST['hard_deadline']) ? 'Yes' : 'No';

    // Email content
    $to = 'kasia@enablemusic.group';
    $subject = 'New Submission from Enable Music Group Form';
    $email_body = "Name: $name\n";
    $email_body .= "Email: $email\n";
    $email_body .= "Phone #: $phone\n";
    $email_body .= "Number of Pieces: $pieces\n";
    $email_body .= "Delivery Deadline: $delivery_deadline\n";
    $email_body .= "Hard Deadline: $hard_deadline\n";

    // SMTP configuration
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'kasia@enablemusic.group';
    $mail->Password = 'tknj nqqq nkgm fyhb';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Recipients
    $mail->setFrom($email, $name);
    $mail->addAddress($to);

    // Email content
    $mail->Subject = $subject;
    $mail->Body    = $email_body;

    // Send email
    if ($mail->send()) {
        // Redirect to success page
        header('Location: success.html');
        exit;
    } else {
        echo "Message could not be sent. Please try again later.";
    }
} catch (Exception $e) {
    error_log("Mailer Error: " . $mail->ErrorInfo);
    echo "There was an error processing your request. Please try again.";
}
?>
