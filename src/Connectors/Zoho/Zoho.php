<?php

namespace Integrations\Connectors\Connector\Zoho;

use Log;
// use Stalker\Models\Video;
use App\Models\User;
use Integrations\Connectors\Connector\Integration;

class Zoho extends Integration
{
    public static $ID = 25;
    public static $URL = 'https://www.zoho.com/';

    public function getConnection($organizer = false)
    {
        return false;
    }
}
