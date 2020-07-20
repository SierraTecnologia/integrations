<?php

namespace Integrations\Connectors\Gmail;

use Log;
// use Stalker\Models\Video;
use App\Models\User;
use Integrations\Connectors\Connector;

class Gmail extends Connector
{
    public static $ID = 5;
    public static $URL = 'https://www.gmail.com/';

    public function getConnection($organizer = false)
    {
        return false;
    }
}
