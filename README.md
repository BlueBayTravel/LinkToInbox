# Link To Inbox

Creates a link to the webmail inbox based on email address.

```php
$linkToInbox = new LinkToInbox();
$link = $linkToInbox->createLink('test@live.com', [
    'subject' => 'Welcome to Acme Service',
    'sender'  => 'hello@acme-service.com',
], true);
```

## Installation

Require this package, with Composer, in the root directory of your project.

```
composer require bluebaytravel/link-to-inbox
```

## License

LinkToInbox is licensed under [The MIT License (MIT)](LICENSE).
