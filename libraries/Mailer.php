<?php

namespace Libraries;

use PHPMailer\PHPMailer\PHPMailer;

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

        self::$mail->Host = APP_EMAIL_HOST;

        $this::$mail->SMTPAuth = true;
        $this::$mail->Username = APP_EMAIL_ADDRESS;
        $this::$mail->Password = APP_EMAIL_PASSWORD;
        $this::$mail->SMTPSecure = false;

        $this::$mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        $this::$mail->Port = 25;
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
            throw new \Exception('Expects an email and message to deliver');
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
        } catch (\Exception $e) {
            $sendResult = ['message' => self::$mail->ErrorInfo, 'mailAddress' => $email];
        }

        return $sendResult;
    }
}
