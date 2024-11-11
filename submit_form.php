<?php
$to = 'kasia@enablemusic.group';
$subject = 'New Submission from Enable Music Group Form';

// Collect the form data
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

if ($file_error === UPLOAD_ERR_OK && is_uploaded_file($file_tmp_name)) {
    $file_content = chunk_split(base64_encode(file_get_contents($file_tmp_name)));
    $boundary = md5(uniqid(rand(), true));

    // Email content
    $email_body = "Name: $name\n";
    $email_body .= "Email: $email\n";
    $email_body .= "Phone #: $phone\n";
    $email_body .= "Number of Pieces: $pieces\n";
    $email_body .= "Delivery Deadline: $delivery_deadline\n";
    $email_body .= "Hard Deadline: $hard_deadline\n";

    // Set headers for email with attachment
    $headers = "From: $email\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";

    // Message body with file attachment
    $message = "--$boundary\r\n";
    $message .= "Content-Type: text/plain; charset=\"UTF-8\"\r\n";
    $message .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $message .= $email_body . "\r\n";
    $message .= "--$boundary\r\n";
    $message .= "Content-Type: $file_type; name=\"$file_name\"\r\n";
    $message .= "Content-Disposition: attachment; filename=\"$file_name\"\r\n";
    $message .= "Content-Transfer-Encoding: base64\r\n\r\n";
    $message .= $file_content . "\r\n";
    $message .= "--$boundary--";

    // Send the email
    if (mail($to, $subject, $message, $headers)) {
        echo "Thank you for your submission! We'll get in touch soon.";
    } else {
        echo "There was an error sending your submission. Please try again.";
    }
} else {
    echo "Error uploading file. Please try again.";
}

if (mail($to, $subject, "Test email body")) {
    echo "Email sent!";
} else {
    echo "Email failed.";
}
?>
