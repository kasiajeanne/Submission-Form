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

<?php
// Enable error reporting for troubleshooting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Collect form data
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$pieces = $_POST['pieces'] ?? '';
$delivery_deadline = $_POST['delivery_deadline'] ?? '';
$hard_deadline = isset($_POST['hard_deadline']) ? 'Yes' : 'No';

// Check if required fields are missing
if (empty($name) || empty($email) || empty($phone) || empty($pieces) || empty($delivery_deadline)) {
    die('All required fields must be filled out.');
}

// File upload handling
$file_tmp_name = $_FILES['design_file']['tmp_name'] ?? '';
$file_name = $_FILES['design_file']['name'] ?? '';
$file_type = $_FILES['design_file']['type'] ?? '';
$file_error = $_FILES['design_file']['error'] ?? '';

// Check for file upload errors
if ($file_error !== UPLOAD_ERR_OK) {
    die('File upload error: ' . $file_error);
}

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->SMTPDebug = 2; // Enable SMTP debugging
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Gmail SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'your-email@gmail.com'; // Your Gmail address
    $mail->Password = 'your-app-password'; // Your Gmail app password (if using 2FA)
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Recipients
    $mail->setFrom($email, $name);
    $mail->addAddress('kasia@enablemusic.group');

    // Attach the file if it exists
    if ($file_tmp_name) {
        $mail->addAttachment($file_tmp_name, $file_name);
    }

    // Content
    $mail->isHTML(false);
    $mail->Subject = 'New Submission from Enable Music Group Form';
    $mail->Body = "Name: $name\n" .
                  "Email: $email\n" .
                  "Phone #: $phone\n" .
                  "Number of Pieces: $pieces\n" .
                  "Delivery Deadline: $delivery_deadline\n" .
                  "Hard Deadline: $hard_deadline\n";

    // Send the email
    if ($mail->send()) {
        echo "Thank you for your submission! We'll get in touch soon.";
        // Redirect to a success page if the email was sent successfully
        header("Location: success.html");
        exit();
    } else {
        echo "There was an error sending your submission. Please try again.";
    }

} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>

