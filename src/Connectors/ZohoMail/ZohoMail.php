<?php

namespace Integrations\Connectors\ZohoMail;

use Log;
// use Stalker\Models\Video;
use App\Models\User;
use Integrations\Connectors\Connector;

class ZohoMail extends Connector
{
    /**
     * Proxima é 33, por causa do camera prive e amazon, BitBucket, GitHub, Trello
     * e Coursera
     */
    public static $ID = 26;
    public static $URL = 'https://www.zohomail.com/';

    public function getConnection($organizer = false)
    {
        return false;
    }
}
