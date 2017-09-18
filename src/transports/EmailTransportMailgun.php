<?php

namespace erdiko\email\transports;

use erdiko\email\abstracts\EmailTransportAbstract;
use Mailgun\Mailgun;

class EmailTransportMailgun extends EmailTransportAbstract
{
    /**
     * @var Mailgun
     */
    protected $mailgun;

    protected $data;

    protected $isSMTP;

    public function _construct()
    {
        $this->isSMTP = $this->config['smtp'];
        if ($this->isSMTP) {
            $this->mailgun = new EmailTransportPHPMailer($this->config);
        } else {
            $this->mailgun = Mailgun::create($this->config['apikey']);
        }
    }

    public function from($email, $name)
    {
        if ($this->isSMTP) {
            $this->mailgun->from($email, $name);
        } else {
            $this->data['from'] = "$name <$email>";
        }
    }

    public function to($email, $name)
    {
        if ($this->isSMTP) {
            $this->mailgun->to($email, $name);
        } else {
            $this->data['to'] = "$name <$email>";
        }
    }

    public function addCc($email, $name)
    {
        if ($this->isSMTP) {
            $this->mailgun->addCC($email, $name);
        } else {
            $this->data['cc'] = "$name <$email>";
        }
    }

    public function addBcc($email, $name)
    {
        if ($this->isSMTP) {
            $this->mailgun->addBCC($email, $name);
        } else {
            $this->data['bcc'] = "$name <$email>";
        }
    }

    public function addReplyTo($email, $name)
    {
        if ($this->isSMTP) {
            $this->mailgun->addReplyTo($email, $name);
        } else {
            $this->data['h:Reply-To'] = "$name <$email>";
        }
    }

    public function addAttachments(array $files)
    {
        foreach ($files as $file) {
            if ($this->isSMTP) {
                $this->mailgun->addAttachment($file);
            } else {
                $this->data['attachment'][] = ['filePath' => $file];
            }
        }
    }

    public function subject($subject)
    {
        if ($this->isSMTP) {
            $this->mailgun->subject($subject);
        } else {
            $this->data['subject'] = $subject;
        }
    }

    public function plain($body)
    {
        if ($this->isSMTP) {
            $this->mailgun->plain($body);
        } else {
            $this->data['text'] = $body;
        }
    }

    public function html($body)
    {
        if ($this->isSMTP) {
            $this->mailgun->html($body);
        } else {
            $this->data['html'] = $body;
        }
    }

    public function send()
    {
        if ($this->isSMTP) {
            $this->mailgun->send();
        } else {
            $this->mailgun->sendMessage($this->config['domain'], $this->data);
        }
    }

    public function initSmtpConfig()
    {
        // This is initialized for PHPMailer in constructor
    }

}
