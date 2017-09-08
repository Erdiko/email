<?php

namespace erdiko\email;

use erdiko\email\exceptions\EmailTransportConfigException;

class Mail
{
    protected $config;

    protected $transport;

    protected $transportClass;

    public function __construct()
    {
        $this->initConfig();
        $this->initTransport();
    }

    protected function initConfig()
    {
        $this->config = require getenv("ERDIKO_ROOT").'/config/email.php';

        if (!$this->config['transport'] || $this->config['config']) {
            throw new EmailTransportConfigException('Basic configuration missing.');
        }
    }

    protected function initTransport()
    {
        $this->validateTransport();
        $this->instantiateTransport();
    }

    protected function validateTransport()
    {
        $this->transportClass = 'EmailTransport'.$this->config['transport'];
        if (!class_exists($this->transportClass)) {
            throw new EmailTransportConfigException("Invalid transport {$this->transportClass}.");
        }
        if (!is_array($this->config['config'])) {
            throw new EmailTransportConfigException("Invalid configuration for transport {$this->transportClass}.");
        }
    }

    private function instantiateTransport()
    {
        try {
            $this->transport = new $this->transportClass($this->config['config']);
        } catch (\Exception $e) {
            throw new EmailTransportException('An error has occurred on instantiate the Transport.');
        }
    }

    public function to($email, $name='')
    {
        $this->transport->to($email, $name);
    }

    public function from($email, $name='')
    {
        $this->transport->from($email, $name);
    }

    public function body($body, $isHtml=true)
    {
        if (!$isHtml) {
            $this->transport->plain($body);
        }
        $this->transport->html($body);
    }

    public function send()
    {
        $this->transport->send();
    }

}
