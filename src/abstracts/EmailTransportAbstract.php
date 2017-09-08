<?php

namespace erdiko\email\abstracts;

use erdiko\ email\interfaces\EmailTransportInterface;

abstract class EmailTransportAbstract implements EmailTransportInterface
{

    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
        $this->_construct();
    }

    public function addTo($email, $name)
    {
        $this->setTo($email, $name);
    }

    public function addReplyTo($email, $name)
    {
        $this->setReplyTo($email, $name);
    }

}
