<?php

namespace Integrations\Connectors\Xvideos;

use Log;
// use Stalker\Models\Video;
use App\Models\User;
use Integrations\Connectors\Connector;

class Xvideos extends Integration
{
    public static $ID = 23;
    public static $URL = 'https://www.xvideos.com/';

    public function getConnection($organizer = false)
    {
        return false;
    }
}
