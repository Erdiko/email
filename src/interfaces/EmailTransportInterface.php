<?php

namespace erdiko\ email\interfaces;

interface EmailTransportInterface
{

    public function _construct();

    public function setFrom($email, $name);

    public function setTo($email, $name);

    public function addTo($email, $name);

    public function setCc($email, $name);

    public function setBcc($email, $name);

    public function setReplyTo($email, $name);

    public function addReplyTo($email, $name);

    public function addAttachments(array $files);

    public function setSend();

}
