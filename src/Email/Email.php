<?php

namespace FacilePHP\Email;

use FacilePHP\Config\Constants;
use PHPMailer\PHPMailer\PHPMailer;
use Exception;

/**
 * Classe di base per inviare email utilizzando PHPMailer.
 */
final class Email
{
    protected readonly PHPMailer $mail;

    public array $to;
    public string $subject;
    public string $message;
    public string $from;
    public string $fromName;
    public string $reply;
    public string $replyName;

    /**
     * Costruttore per TemplateEmail.
     *
     * @param string $to Indirizzo email del destinatario.
     * @param string $subject Oggetto dell'email.
     * @param string $message
     * @param string $from
     * @param string $fromName
     * @param string $reply
     * @param string $replyName
     */
    public function __construct(string $to = '', string $subject = '', string $message = '', string $from = '', string $fromName = '', string $reply = '', string $replyName = '')
    {
        $this->mail = new PHPMailer(true);

        $this->to[] = $to;
        $this->subject = $subject;
        $this->message = $message;
        $this->from = $from;
        $this->fromName = $fromName;
        $this->reply = $reply;
        $this->replyName = $replyName;
    }

    /**
     * Binds data to variables inside message body
     *
     * @param array<string,string> $data Dati per popolare il template.
     */
    public function bindData(array $data): void
    {
        $data['version'] = Constants::APP_VERSION;

        foreach ($data as $key => $value) {
            $this->message = str_replace('{{' . $key . '}}', strval($value), $this->message);
        }
    }

    public function send(): bool
    {
        try {
            //Recipients
            $this->mail->setFrom($this->from, $this->fromName);
            foreach ($this->to as $to) {
                $this->mail->addAddress($this->to); // Add a recipient
            }

            $this->mail->addReplyTo($this->reply, $this->replyName);

            //Content
            $this->mail->isHTML(true); // Set email format to HTML
            $this->mail->Subject = $this->subject;
            $this->mail->msgHTML($this->message);

            return $this->mail->send();
        } catch (Exception $e) {
            throw new Exception('Message could not be sent. Mailer Error: ' . $this->mail->ErrorInfo);
        }
    }

    public function getReceivers(): array
    {
        return $this->to;
    }
    public function getSubject(): string
    {
        return $this->subject;
    }
    public function getMessage(): string
    {
        return $this->message;
    }
    public function getSender(): string
    {
        return $this->from;
    }
    public function getSenderName(): string
    {
        return $this->fromName;
    }
    public function getReplyTo(): string
    {
        return $this->reply;
    }
    public function getReplyToName(): string
    {
        return $this->replyName;
    }

    public function addReceiver(array|string $to): void
    {
        $this->to[] = $to;
    }


    public function setReceiver(array|string $to): void
    {
        $this->to = $to;
    }
    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }
    public function setMessageFromFile(string $pathToFile): void
    {
        $this->message = file_get_contents($pathToFile) ?? '';
    }
    public function setSender(string $from): void
    {
        $this->from = $from;
    }
    public function setSenderName(string $fromName): void
    {
        $this->fromName = $fromName;
    }
    public function setReplyTo(string $reply): void
    {
        $this->reply = $reply;
    }
    public function setReplyToName(string $replyName): void
    {
        $this->replyName = $replyName;
    }
}
