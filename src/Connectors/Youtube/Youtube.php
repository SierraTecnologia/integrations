<?php

namespace Integrations\Connectors\Youtube;

use Log;
// use Stalker\Models\Video;
use App\Models\User;
use Integrations\Connectors\Connector;

class Youtube extends Integration
{
    public static $ID = 24;
    public static $URL = 'https://www.youtube.com/';

    public function getConnection($organizer = false)
    {
        return false;
    }
}
