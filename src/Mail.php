<?php

namespace erdiko\email;

use erdiko\core\Container;
use erdiko\email\exceptions\EmailTransportConfigException;
use Slim\Views\Twig;

class Mail
{
    protected $container;

    protected $config;

    protected $transport;

    protected $transportClass;

    public function __construct($container)
    {
        $this->container = $container;
        $this->initConfig();
        $this->initTransport();
    }

    protected function initConfig()
    {
        $settings = $this->container->get('settings');
        if (!isset($settings['email'])) {
            throw new EmailTransportConfigException('Email config file does not exists.');
        }
        $this->config = $settings['email'];

        if (!$this->config['transport'] || !$this->config['config']) {
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
        $this->transportClass = 'erdiko\email\transports\EmailTransport'.$this->config['transport'];
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

    public function body($body, $isHtml=false)
    {
        $hasHtmlTags = $body != strip_tags($body);
        if ($hasHtmlTags || $isHtml!==false) {
            $this->transport->html($body);
        }
        $this->transport->plain($body);
    }

    public function bodyTemplate($template, $data)
    {
        $html = $this->container->theme->fetch($template, $data);
        $this->transport->html($html);
    }

    public function send()
    {
        $this->transport->send();
    }

}
