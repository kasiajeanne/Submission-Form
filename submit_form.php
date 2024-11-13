<?php
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

$to = 'kasia@enablemusic.group';
$subject = 'New Submission from Enable Music Group Form';

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$pieces = $_POST['pieces'] ?? '';
$delivery_deadline = $_POST['delivery_deadline'] ?? '';
$hard_deadline = isset($_POST['hard_deadline']) ? 'Yes' : 'No';

// Initialize PHPMailer
$mail = new PHPMailer(true);
try {
    // SMTP Settings for Gmail
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'kasia@enablemusic.group';
        $mail->Password = 'tknj nqqq nkgm fyhb';  // Your Gmail app password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Email headers
    $mail->setFrom($email, $name);
    $mail->addAddress($to);
    $mail->Subject = $subject;

    // Body
    $body = "Name: $name\nEmail: $email\nPhone #: $phone\nNumber of Pieces: $pieces\nDelivery Deadline: $delivery_deadline\nHard Deadline: $hard_deadline";
    $mail->Body = $body;

    // Handle File Attachment
    if (!empty($_FILES['design_file']['tmp_name'])) {
        $uploadfile = tempnam(sys_get_temp_dir(), sha1($_FILES['design_file']['name']));
        move_uploaded_file($_FILES['design_file']['tmp_name'], $uploadfile);
        $mail->addAttachment($uploadfile, $_FILES['design_file']['name']);
    }

    // Send Email
    $mail->send();
    // Redirect to success page
    header('Location: success.html');
    exit();
} catch (Exception $e) {
    echo "Message could not be sent. Error: {$mail->ErrorInfo}";
}
?>