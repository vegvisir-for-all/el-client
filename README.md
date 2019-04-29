# EmailLabs PHP Client

This library is a EmailLabs.pl PHP Client, using EL's built-in API. Since it's in the alpha state, we cannot guarantee you it's free of any bugs, errors or whatsoever.

## Installation

```bash
composer require vegvisir/el-client
```

### Usage

```php

use EmailLabs\EmailLabs;

// Create new EmailLabs client
$el = new EmailLabs($appKey, $secretKey, $smtpAccount);

// Create new message without template
$msg1 = $el->message([
  'to' => 'mail@domain.com',
  'to_message_id' => 'mid@domain',
  'subject' => 'Test message',
  'from' => 'vegvisir@domain.com',
  'text' => 'Test message body',
  'html' => '<h1>Test message body</h1>',
]);

// Create new message with template
$msg2 = $el->messageWithTemplate([
  'to' => 'mail@domain.com',
  'to_name' => 'sigrun',
  'to_message_id' => 'mid@domain',
  'subject' => 'Test message',
  'from' => 'vegvisir@domain.com',
  'global_vars' => [
    'firstname' => 'John',
    'lastname' => 'Doe',
  ],
  'template_id' => 'el_template_id',
]);

// Send messages

$el->send([$msg1, $msg2]);

// or

$el->send($msg1);
$el->send($msg2);
```
