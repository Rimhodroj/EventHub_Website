<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'includes/PHPMailer/src/Exception.php';
require 'includes/PHPMailer/src/PHPMailer.php';
require 'includes/PHPMailer/src/SMTP.php';

function sendEmailNotification($eventName, $eventImageUrl) {
    global $con;
    $mail = new PHPMailer(true);
    
    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'alibassam0300@gmail.com';  // Replace with your Gmail address
        $mail->Password   = 'izywqjlganlmvftu';  // Replace with your App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Email content
        $mail->setFrom('info@eventhub.com', 'Event Hub');
        $mail->isHTML(true);
        $mail->Subject = 'Event Approved';
        $logoUrl = 'https://eventhubplatform.000webhostapp.com/images/launcher.png'; // Replace with your actual logo URL
        $mail->Body = "
        <html>
        <body style='font-family: Arial, sans-serif; line-height: 1.6; color: #333;'>
            <div style='max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px;'>
                <div style='text-align: center; margin-bottom: 20px;'>
                    <img src='{$logoUrl}' alt='EventHub Logo' style='max-width: 100px;'>
                </div>
                <h2 style='color: #4a4a4a;'>Event Approved</h2>
                <p>Dear Valued Client,</p>
                <p>We are pleased to inform you that the event <strong>{$eventName}</strong> has been approved.</p>
                <div style='text-align: center; margin: 20px 0;'>
                    <img src='https://eventhubplatform.000webhostapp.com/images/{$eventImageUrl}' alt='Event Image' style='max-width: 100%; height: auto; border-radius: 5px;'>
                </div>
                <p>You can now proceed with any necessary preparations or promotions for this event.</p>
                <p>If you have any questions or need further assistance, please don't hesitate to contact us.</p>
                <p>Thank you for choosing EventHub for your event management needs.</p>
                <p>Best regards,<br>The EventHub Team</p>
                <div style='margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd; font-size: 12px; color: #888;'>
                    <p>This is an automated message, please do not reply directly to this email.</p>
                </div>
            </div>
        </body>
        </html>
        ";

        $clientEmails = [];
        $sql = "SELECT email FROM clients WHERE notification_status = 1";
        $result = mysqli_query($con, $sql);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $clientEmails[] = $row['email'];
            }
        } else {
            throw new Exception('Error fetching client emails: ' . mysqli_error($con));
        }

        foreach ($clientEmails as $email) {
            $mail->addAddress($email);
            $mail->send();
            $mail->clearAddresses();
        }

        return 'Emails sent successfully to all clients';
    } catch (Exception $e) {
        throw new Exception("Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
    }
}
?>