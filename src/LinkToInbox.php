<?php

/*
 * This file is part of LinkToInbox.
 *
 * (c) Blue Bay Travel <developers@bluebaytravel.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlueBayTravel\LinkToInbox;

/**
 * The link to inbox class.
 *
 * @author James Brooks <james@bluebaytravel.co.uk>
 */
class LinkToInbox
{
    /**
     * Creates a new link to the inbox.
     *
     * @param string $email
     * @param bool   $filter
     * @param bool   $onlyMatched
     * @param string $text
     *
     * @return string
     */
    public function createLink($email, $filter, $onlyMatched, $text = null)
    {
        if (!$text) {
            $text = 'Check your %s inbox';
        }

        $spec = $this->getSpec($email, $filter, $onlyMatched);

        if (!$spec) {
            return false;
        }

        $href = $this->getHref($email, $filter, $onlyMatched);
        $linkText = sprintf($text, $spec['name']);

        return '<a href="'.$href.'" target="_blank">'.$linkText.'</a>';
    }

    /**
     * Generates the href link.
     *
     * @param string $email
     * @param bool   $filter
     * @param bool   $onlyMatched
     *
     * @return string
     */
    protected function getHref($email, $filter, $onlyMatched)
    {
        $spec = $this->getSpec($email, $filter, $onlyMatched);

        if (!$spec) {
            return false;
        }

        $href = $spec['protocol'].'://'.$spec['domain'].$spec['path'];

        return $href;
    }

    /**
     * Gets the mailbox specification.
     *
     * @param string $email
     * @param bool   $filter
     * @param bool   $onlyMatched
     *
     * @return array
     */
    protected function getSpec($email, $filter, $onlyMatched)
    {
        $matched = true;
        $domain = explode('@', $email)[1];
        $parsedFilters = null;

        $spec = [
            'name'     => $domain,
            'protocol' => 'https',
            'domain'   => $domain,
            'path'     => '',
        ];

        if ($filter) {
            $parsedFilters = [];

            if (isset($filter['subject'])) {
                $parsedFilters['subject'] = urlencode($filter['subject']);
            }

            if (isset($filter['sender'])) {
                $parsedFilters['sender'] = urlencode($filter['sender']);
            }
        }

        switch ($domain) {
            case 'gmail.com':
            case 'googlemail.com':
                $spec['name'] = 'Gmail';
                $spec['domain'] = 'mail.google.com';
                $spec['path'] = '/mail/u/0/';

                if ($parsedFilters) {
                    $spec['path'] .= '#search/in%3Aanywhere';

                    if (isset($parsedFilters['subject'])) {
                        $spec['path'] .= '+subject%3A%22'.$parsedFilters['subject'].'%22';
                    }

                    if (isset($parsedFilters['sender'])) {
                        $spec['path'] .= '+from%3A'.$parsedFilters['sender'];
                    }
                }

                break;
            case 'live.com':
            case 'hotmail.com':
            case 'outlook.com':
                $spec['name'] = 'Outlook';
                $spec['domain'] = 'mail.live.com';
                $spec['path'] = '/';

                if ($parsedFilters) {
                    $spec['path'] .= '?fid=flsearch&srch=1&sdr=4&satt=0';

                    if (isset($parsedFilters['subject'])) {
                        $spec['path'] .= '&skws='.$parsedFilters['subject'];
                    }

                    if (isset($parsedFilters['sender'])) {
                        $spec['path'] .= '&skws='.$parsedFilters['sender'];
                    }
                }

                break;
            default:
                $matched = false;
        }

        if ($onlyMatched && !$matched) {
            return false;
        }

        return $spec;
    }
}
