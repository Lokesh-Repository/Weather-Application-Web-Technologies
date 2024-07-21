<!-- ewwwwww.....
What's That Brother....
what's That......
Need Clarifications ? visit http://lokeshportfolio.rf.gd/

Hi There Mr/Mrs.Hacker Good Luck On Understanding The Code Cause,I Coded This Shit And SomeTimes I Myself Get Confused.. -->
<?php
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

// Load .env file
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Get SMTP credentials from .env
$smtpHost = $_ENV['SMTP_HOST'];
$smtpPort = $_ENV['SMTP_PORT'];
$smtpUsername = $_ENV['SMTP_USERNAME'];
$smtpPassword = $_ENV['SMTP_PASSWORD'];
$smtpFrom = $_ENV['SMTP_FROM'];
$smtpFromName = $_ENV['SMTP_FROM_NAME'];
$smtpTo = $_ENV['SMTP_TO'];

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = $smtpHost;
        $mail->SMTPAuth = true;
        $mail->Username = $smtpUsername;
        $mail->Password = $smtpPassword;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $smtpPort;

        // Send email to visitor
        $mail->setFrom($smtpFrom, $smtpFromName);
        $mail->addAddress($email, $name);  
        $mail->isHTML(true);
        $mail->Subject = 'Thank you for getting in touch!';
        $mail->Body = "<p>Dear $name,</p><p>Thank you for getting in touch. We have received your message and will get back to you shortly.</p><p>Message: $message</p>";
        $mail->send();

        // Send email to yourself with form details
        $mail->clearAddresses(); // Clear all recipient addresses
        $mail->addAddress($smtpTo);        
        $mail->Subject = 'New Contact Form Submission';
        $mail->Body = "<p>New contact form submission:</p><p><strong>Name:</strong> $name</p><p><strong>Email:</strong> $email</p><p><strong>Message:</strong> $message</p>";
        $mail->send();

        // Redirect with success message
        header('Location: index.html');
        exit();
    } catch (Exception $e) {
        // Redirect with error message
        header('Location: error_message=' . urlencode($mail->ErrorInfo));
        exit();
    }
}
?>
