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
        self::$mail = new PHPMailer(true);
        self::$mail->SMTPDebug = 0;
        self::$mail->isSMTP();
        self::$mail->Host = 'smtp.gmail.com';
        self::$mail->SMTPAuth = true;
        self::$mail->Username = APP_EMAIL_ADDRESS;
        self::$mail->Password = APP_EMAIL_PASSWORD;
        self::$mail->SMTPSecure = 'tls';
        self::$mail->Port = 587;
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

        if (!isset ($email) && !isset ($message)) {
            throw new Exception('Expects an email and message to deliver');
        }

        $sendResult = [];

        try {
            self::$mail->setFrom(APP_EMAIL_ADDRESS, $fromName);
            self::$mail->addAddress($email);
            self::$mail->isHTML(true);
            self::$mail->Subject = $subject;
            self::$mail->Body = $message;
            self::$mail->send();

            $sendResult = ['message' => 'sent', 'mailAddress' => $email];
        }
        catch (Exception $e) {
            $sendResult = ['message' => self::$mail->ErrorInfo, 'mailAddress' => $email];
        }

        return $sendResult;
    }
}
