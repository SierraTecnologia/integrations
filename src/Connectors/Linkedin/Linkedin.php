<?php

namespace Integrations\Connectors\Linkedin;

use Log;
// use Stalker\Models\Video;
use App\Models\User;
use Integrations\Connectors\Connector;

class Linkedin extends Connector
{
    public static $ID = 10;
    public static $URL = 'https://www.linkedin.com/';

    public function getConnection($organizer = false)
    {
        return false;
    }
}
