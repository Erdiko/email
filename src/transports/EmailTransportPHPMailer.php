<?php

namespace erdiko\email\transports;

use erdiko\email\abstracts\EmailTransportAbstract;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailTransportPHPMailer extends EmailTransportAbstract
{
    /**
     * @var PHPMailer
     */
    protected $mailer;

    public function _construct()
    {
        $this->mailer = new PHPMailer(true);
    }

    public function from($email, $name)
    {
        $this->mailer->setFrom($email, $name);
    }

    public function to($email, $name)
    {
        $this->mailer->addAddress($email, $name);
    }

    public function addCc($email, $name)
    {
        $this->mailer->addCC($email, $name);
    }

    public function addBcc($email, $name)
    {
        $this->mailer->addBCC($email, $name);
    }

    public function addReplyTo($email, $name)
    {
        $this->mailer->addReplyTo($email, $name);
    }

    public function addAttachments(array $files)
    {
        foreach ($files as $file) {
            $this->mailer->addAttachment($file);
        }
    }

    public function plain($body)
    {
        $this->mailer->AltBody = $body;
    }

    public function html($body)
    {
        $this->mailer->msgHTML($body);
    }

    public function send()
    {
        $this->mailer->send();
    }

    public function initSmtpConfig()
    {
        $this->mailer->isSMTP();
        $this->mailer->Host = $this->config['host'];
        $this->mailer->Port = $this->config['port'];
        $this->mailer->SMTPSecure = $this->config['tls'];
        $this->mailer->SMTPAuth = $this->config['auth'];
        $this->mailer->Username = $this->config['user'];
        $this->mailer->Password = $this->config['pass'];
    }

    public function initSendmailConfig()
    {
        $this->mailer->isSendmail();
    }
}
