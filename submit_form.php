<?php
// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/PHPMailerAutoload.php';  // Adjust the path if needed

$to = 'kasia@enablemusic.group';
$subject = 'New Submission from Enable Music Group Form';

// Collect form data
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$pieces = $_POST['pieces'] ?? '';
$delivery_deadline = $_POST['delivery_deadline'] ?? '';
$hard_deadline = isset($_POST['hard_deadline']) ? 'Yes' : 'No';

// Handle file upload
$file_tmp_name = $_FILES['design_file']['tmp_name'] ?? '';
$file_name = $_FILES['design_file']['name'] ?? '';
$file_type = $_FILES['design_file']['type'] ?? '';
$file_error = $_FILES['design_file']['error'] ?? '';

// Set up PHPMailer
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                      // Set the SMTP server (use your SMTP server)
    $mail->SMTPAuth   = true;                                    // Enable SMTP authentication
    $mail->Username   = 'kasia@example.com';                // SMTP username
    $mail->Password   = 'ChuckBassV1P3d!t';                   // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;          // Enable TLS encryption
    $mail->Port       = 587;                                     // TCP port to connect to

    // Recipients
    $mail->setFrom($email, $name);                               // Sender's email and name
    $mail->addAddress($to);                                      // Add recipient's email

    // Content
    $mail->isHTML(false);                                        // Set email format to plain text
    $mail->Subject = $subject;
    $email_body = "Name: $name\n";
    $email_body .= "Email: $email\n";
    $email_body .= "Phone #: $phone\n";
    $email_body .= "Number of Pieces: $pieces\n";
    $email_body .= "Delivery Deadline: $delivery_deadline\n";
    $email_body .= "Hard Deadline: $hard_deadline\n";
    $mail->Body    = $email_body;

    // Attach the file
    if ($file_error === UPLOAD_ERR_OK && is_uploaded_file($file_tmp_name)) {
        $mail->addAttachment($file_tmp_name, $file_name); // Add attachment
    }

    // Send the email
    $mail->send();

    // Redirect to success page if email is sent successfully
    header("Location: success.php");
    exit(); // Make sure no further code is executed

} catch (Exception $e) {
    echo "There was an error sending your submission. Mailer Error: {$mail->ErrorInfo}";
}
?>
