<?php

namespace Tests\Functional;

require_once realpath(getenv('ERDIKO_ROOT').'/vendor/autoload.php');

use GuzzleHttp\Client;

class EmailTest extends BaseTestCase
{

    private $mailtrap;

    private $mailtrap_inbox;

    public function setUp()
    {
        $this->mailtrap = new Client([
            'base_uri' => 'https://mailtrap.io/api/v1/',
            'headers' => [
                'Api-Token' => '5b8b953ba42dcb32715805a8a58028af'
            ]
        ]);
        $this->mailtrap_inbox = '257892';
        $this->cleanMessages();
    }

    public function testMessage()
    {
        $email = $this->getApp()->getContainer()->email;

        $fromEmail = 'fromTest@erdiko.com';
        $fromName = 'From Test Name';
        $toEmail = 'toTest@erdiko.com';
        $toName = 'To Test Name';
        $subject = 'Test Subject';

        $template = 'emails/test.html';
        $templateData = ['username' => $fromName];
        $templateRendered = $this->getApp()->getContainer()->theme->fetch($template, $templateData);

        $email->from($fromEmail, $fromName);
        $email->to($toEmail, $toName);
        $email->subject($subject);
        $email->template($template, $templateData);
        $sent = $email->send();

        $this->assertTrue($sent);

        $message = $this->getLastMessage();

        $this->assertEquals($fromEmail, $message->from_email);
        $this->assertEquals($fromName, $message->from_name);
        $this->assertEquals($toEmail, $message->to_email);
        $this->assertEquals($toName, $message->to_name);
        $this->assertEquals($subject, $message->subject);
        $this->assertEquals(trim($templateRendered), trim($message->html_body));

    }

    private function getMessages()
    {
        $response = $this->mailtrap->request('GET', "inboxes/$this->mailtrap_inbox/messages");
        return json_decode((string) $response->getBody());
    }

    private function getLastMessage()
    {
        $messages = $this->getMessages();
        return empty($messages) ? false : $messages[0];
    }

    private function cleanMessages()
    {
        $this->mailtrap->request('PATCH', "inboxes/$this->mailtrap_inbox/clean");
    }

}
