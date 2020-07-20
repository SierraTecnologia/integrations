<?php

namespace Integrations\Connectors\Connector\Linkedin;

use Log;
// use Stalker\Models\Video;
use App\Models\User;
use Integrations\Connectors\Connector\Integration;

class Linkedin extends Integration
{
    public static $ID = 10;
    public static $URL = 'https://www.linkedin.com/';

    public function getConnection($organizer = false)
    {
        return false;
    }
}
