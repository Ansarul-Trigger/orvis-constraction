<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    exit("Method Not Allowed");
}

// Sanitize input
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');

if (!$name || !$email || !$message) {
    exit("All fields are required.");
}

$mail = new PHPMailer(true);

try {

    // ================= SMTP CONFIG =================

    $mail->isSMTP();
    $mail->Host = 'smtp.hostinger.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'noreply@orviscontracting.com';

    // IMPORTANT: NO SPACES IN PASSWORD
    $mail->Password = 'svtpqxcviihsoppq';

    $mail->Port = 587;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

    $mail->CharSet = 'UTF-8';
    $mail->SMTPDebug = 0;

    // Fix Hostinger SSL validation
    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true,
        ],
    ];

    // ================= EMAIL HEADERS =================

    $mail->setFrom('noreply@orviscontracting.com', 'Orvis Construction Website');
    $mail->addAddress('contact@orviscontracting.com');
    $mail->addReplyTo($email, $name);

    // ================= EMAIL BODY =================

    $mail->isHTML(false);
    $mail->Subject = 'New Website Contact Message';

    $mail->Body =
        "Name: $name\n" .
        "Email: $email\n\n" .
        "Message:\n$message";

    $mail->send();

    // ================= REDIRECT =================

    header("Location: /contact.html?success=1");
    exit;

} catch (Exception $e) {
    echo "Mailer Error: " . $mail->ErrorInfo;
}
