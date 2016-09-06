# Link To Inbox

Creates a link to the webmail inbox based on email address.

```php
$linkToInbox = new LinkToInbox();
$link = $linkToInbox->createLink('test@live.com', [
    'subject' => 'Welcome to Acme Service',
    'sender'  => 'hello@acme-service.com',
], true);
```

## License

LinkToInbox is licensed under [The MIT License (MIT)](LICENSE).
