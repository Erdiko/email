<?php

namespace erdiko\email\abstracts;

use erdiko\ email\interfaces\EmailTransportInterface;
use erdiko\email\exceptions\EmailTransportConfigException;

abstract class EmailTransportAbstract implements EmailTransportInterface
{

    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
        $this->_construct();
        $this->initConfig();
    }

    public function addTo($email, $name)
    {
        $this->setTo($email, $name);
    }

    public function addReplyTo($email, $name)
    {
        $this->setReplyTo($email, $name);
    }

    protected function initConfig()
    {
        $isSmtp = isset($this->config['smtp']) && $this->config['smtp'];
        switch (true) {
            case $isSmtp:
                $this->validateSmtpConfig();
                $this->initSmtpConfig();
            break;
            default:
                $this->validateDefaultConfig();
                $this->initDefaultConfig();
        }
    }

    protected function initDefaultConfig()
    {
        $this->from($this->config['from'], $this->config['from_name']);
    }

    protected function validateDefaultConfig()
    {
        $required = ['from', 'from_name'];
        $this->validateFields($required);
    }

    abstract protected function initSmtpConfig();

    protected function validateSmtpConfig()
    {
        $required = ['user', 'pass', 'host', 'port', 'secure', 'auth'];
        $this->validateFields($required);
    }

    protected function validateFields($fields)
    {
        foreach ($fields as $field) {
            if (empty($this->config[$field]) || !isset($this->config[$field])) {
                throw new EmailTransportConfigException("Email SMTP configuration $field missing.");
            }
        }
    }

}
