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

    public function setFrom($email, $name)
    {
        $this->mailer->setFrom($email, $name);
    }

    public function setTo($email, $name)
    {
        $this->mailer->addAddress($email, $name);
    }

    public function setCc($email, $name)
    {
        $this->mailer->addCC($email, $name);
    }

    public function setBcc($email, $name)
    {
        $this->mailer->addBCC($email, $name);
    }

    public function setReplyTo($email, $name)
    {
        $this->mailer->addReplyTo($email, $name);
    }

    public function setSend()
    {
        // TODO: Implement setSend() method.
    }

    public function addAttachments(array $files)
    {
        foreach ($files as $file) {
            $this->mailer->addAttachment($file);
        }
    }
}
