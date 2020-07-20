<?php

namespace Integrations\Connectors\Connector\SnapChat;

use Log;
// use Stalker\Models\Video;
use App\Models\User;
use Integrations\Connectors\Connector\Integration;

class SnapChat extends Integration
{
    public static $ID = 18;
    public static $URL = 'https://www.snapchat.com/';

    public function getConnection($organizer = false)
    {
        return false;
    }
}
