<?php

namespace Integrations\Connectors\Connector\Google;

use Log;
// use Stalker\Models\Video;
use App\Models\User;
use Integrations\Connectors\Connector\Integration;

class Google extends Integration
{
    public static $ID = 6;
    public static $URL = 'https://www.google.com/';

    public function getConnection($organizer = false)
    {
        return false;
    }
}
