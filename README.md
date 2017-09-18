# Erdiko Email Package

## Important: This package is currently on development, please don't use it until have a beta or stable version.

### Introduction

Erdiko Email is a package to handle in an easy and elastic way the email transports.

### Official Documentation

Documentation for Erdiko Email Package can be found on the [Erdiko website](http://erdiko.org/email/).

### Installation

We recommend installing Erdiko Email Package with [Composer](https://getcomposer.org/).  At the commandline simply run:
```
composer require erdiko/email
```

### Transports

Current Transports Available:
 - PHPMailer: EmailTransportPHPMailer
 - Mailgun: EmailTransportMailgun - API and SMTP

### Dependencies

This package depends of Erdiko\Core

### Configuration

File Path
```
[site_root]/app/config/default/email.php
```

File format
```
[
    "transport" => "Mailgun",
    "config" => [
        "smtp" => true,
        "apikey" => "API_KEY",
        "user" => "USER",
        "pass" => 'PASS',
        "host" => "HOST",
        "domain" => "DOMAIN",
        "port" => "587",
        "secure" => "tls",
        "auth" => true
    ]
]
```
### Available Methods

You will find several methods that will satisfy your requirements for handling email data.

 - subject
 - to
 - from
 - plain
 - html
 - template
 - send

### Basic Usage
```
$email = $container->email;

$email->subject('Subject Test');
$email->from('from@email.com', 'From Name');
$email->to('to@email.com', 'To Name');
$email->plain('plain text email');
$email->html('<h1>Test email</h1><p>Test Body</p>');
$email->send();
```

### Tests
*On development*

### Credits

* Mauricio Pineda
* John Arroyo
* Leo Daidone

[All Contributors](https://github.com/Erdiko/session/graphs/contributors)

* If you want to help, please do, we'd love more brainpower!  Fork, commit your enhancements and do a pull request.  If you want to get to even more involved please contact us!

### Sponsors

[Arroyo Labs](http://www.arroyolabs.com/)


### License

Erdiko is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
