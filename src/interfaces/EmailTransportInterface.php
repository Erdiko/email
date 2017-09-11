<?php

namespace erdiko\ email\interfaces;

interface EmailTransportInterface
{

    function _construct();

    function from($email, $name);

    function to($email, $name);

    function addTo($email, $name);

    function addCc($email, $name);

    function addBcc($email, $name);

    function addReplyTo($email, $name);

    function addAttachments(array $files);

    function plain($body);

    function html($body);

    function send();

}
