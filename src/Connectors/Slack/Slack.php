<?php

namespace Integrations\Connectors\Connector\Slack;

use Log;
// use Stalker\Models\Video;
use App\Models\User;
use Integrations\Connectors\Connector\Integration;

class Slack extends Integration
{
    public static $ID = 17;
    public static $URL = 'https://www.slack.com/';

    public function getConnection($organizer = false)
    {
        return false;
    }
}
