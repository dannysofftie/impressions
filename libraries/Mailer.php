<?php

namespace Libraries;

use Libraries\JSON;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Provides utilities for sending emails, and checking email status.
 *
 * Uses PHPMailer mailing library
 */
class Mailer
{
    private static $mail;

    public function __construct()
    {
        $this::$mail = new PHPMailer(true);
        $this::$mail->SMTPDebug = 0;
        $this::$mail->isSMTP();
        $this::$mail->Host = 'smtp.gmail.com';
        $this::$mail->SMTPAuth = true;
        $this::$mail->Username = APP_EMAIL_ADDRESS;
        $this::$mail->Password = APP_EMAIL_PASSWORD;
        $this::$mail->SMTPSecure = 'tls';
        $this::$mail->Port = 587;
    }

    /**
     * Sends emails to given email addresses
     *
     * @param [string] $email
     * @param [string] $message
     * @return array
     */
    public static function deliverMail($email, $subject, $message, $fromName)
    {
        new self();
        
        if (!isset($email) && !isset($message)) {
            throw new Exception('Expects an email and message to deliver');
        }

        $sendResult = [];
        
        try {
            self::$mail->setFrom(APP_EMAIL_ADDRESS, $fromName);
            self::$mail->addAddress($email);
            self::$mail->isHTML(true);
            self::$mail->Subject = $subject;
            self::$mail->Body    = $message;
            self::$mail->send();

            $sendResult = ['message' => 'sent', 'mailAddress' => $email];
        } catch (Exception $e) {
            $sendResult = ['message' => self::$mail->ErrorInfo, 'mailAddress' => $email];
        }

        return $sendResult;
    }
}
