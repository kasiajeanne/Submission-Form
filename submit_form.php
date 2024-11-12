<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

$to = 'kasia@enablemusic.group';
$subject = 'New Submission from Enable Music Group Form';

// Check if form data exists
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $pieces = $_POST['pieces'] ?? '';
    $delivery_deadline = $_POST['delivery_deadline'] ?? '';
    $hard_deadline = isset($_POST['hard_deadline']) ? 'Yes' : 'No';

    // Handle file upload
    $file_tmp_name = $_FILES['design_file']['tmp_name'] ?? '';
    $file_name = $_FILES['design_file']['name'] ?? '';
    $file_error = $_FILES['design_file']['error'] ?? '';

    if ($file_error !== UPLOAD_ERR_OK) {
        echo "Error uploading file. Please try again.";
        exit;
    }

    // Configure PHPMailer
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'kasia@enablemusic.group';
        $mail->Password = 'ChuckBassV1P3d!t';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email settings
        $mail->setFrom($email, $name);
        $mail->addAddress($to);
        $mail->Subject = $subject;

        // Message body
        $email_body = "Name: $name\n";
        $email_body .= "Email: $email\n";
        $email_body .= "Phone #: $phone\n";
        $email_body .= "Number of Pieces: $pieces\n";
        $email_body .= "Delivery Deadline: $delivery_deadline\n";
        $email_body .= "Hard Deadline: $hard_deadline\n";

        $mail->Body = $email_body;

        // Attach file
        $mail->addAttachment($file_tmp_name, $file_name);

        // Send the email
        if ($mail->send()) {
            echo "<script>alert('Thank you for your submission! We\\'ll get in touch soon.'); window.location.href = 'success.html';</script>";
        } else {
            echo "There was an error sending your submission. Please try again.";
        }
    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
}
?>
