<?php

/*
 * This file is part of LinkToInbox.
 *
 * (c) Blue Bay Travel <developers@bluebaytravel.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlueBayTravel\Tests\LinkToInbox;

use BlueBayTravel\LinkToInbox\LinkToInbox;
use PHPUnit_Framework_TestCase;

class LinkToInboxTest extends PHPUnit_Framework_TestCase
{
    public function testCreateLinkGmail()
    {
        $linkToInbox = new LinkToInbox();
        $link = $linkToInbox->createLink('test@gmail.com', [
            'subject' => 'Welcome to LinkToInbox',
            'sender'  => 'example@example.com',
        ], true);

        $expected = '<a href="https://mail.google.com/mail/u/0/#search/in%3Aanywhere+subject%3A%22Welcome+to+LinkToInbox%22+from%3Aexample%40example.com" target="_blank">Check your Gmail inbox</a>';

        $this->assertSame($expected, $link);
    }

    public function testCreateLinkGmailNoSubject()
    {
        $linkToInbox = new LinkToInbox();
        $link = $linkToInbox->createLink('test@gmail.com', [
            'sender' => 'example@example.com',
        ], true);

        $expected = '<a href="https://mail.google.com/mail/u/0/#search/in%3Aanywhere+from%3Aexample%40example.com" target="_blank">Check your Gmail inbox</a>';

        $this->assertSame($expected, $link);
    }

    public function testCreateLinkLive()
    {
        $linkToInbox = new LinkToInbox();
        $link = $linkToInbox->createLink('test@live.com', [
            'subject' => 'Welcome to LinkToInbox',
            'sender'  => 'example@example.com',
        ], true);

        $expected = '<a href="https://mail.live.com/?fid=flsearch&srch=1&sdr=4&satt=0&skws=Welcome+to+LinkToInbox&skws=example%40example.com" target="_blank">Check your Outlook inbox</a>';

        $this->assertSame($expected, $link);
    }

    public function testCreateLinkLiveNoSubject()
    {
        $linkToInbox = new LinkToInbox();
        $link = $linkToInbox->createLink('test@live.com', [
            'sender'  => 'example@example.com',
        ], true);

        $expected = '<a href="https://mail.live.com/?fid=flsearch&srch=1&sdr=4&satt=0&skws=example%40example.com" target="_blank">Check your Outlook inbox</a>';

        $this->assertSame($expected, $link);
    }

    public function testCreateLinkUnknown()
    {
        $linkToInbox = new LinkToInbox();
        $link = $linkToInbox->createLink('test@acme.com', [
            'subject' => 'Welcome to LinkToInbox',
            'sender'  => 'example@example.com',
        ], true);

        $expected = false;

        $this->assertSame($expected, $link);
    }
}
