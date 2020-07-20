<?php

namespace Integrations\Connectors\Pinterest;

use Log;
// use Stalker\Models\Video;
use App\Models\User;
use Integrations\Connectors\Connector;

class Pinterest extends Connector
{
    public static $ID = 13;
    public static $URL = 'https://www.pinterest.es/pin/';

    public function getConnection($organizer = false)
    {
        return false;
    }
}
