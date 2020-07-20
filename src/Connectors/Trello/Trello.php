<?php

namespace Integrations\Connectors\Connector\Trello;

use Illuminate\Database\Eloquent\Model;
use Log;
use Integrations\Connectors\Connector\Integration;

class Trello extends Integration
{
    public static $ID = 31;

    // protected function getConnection($token = false)
    // {
    //     return new Cloudflare\API\Adapter\Guzzle(new APIKey('user@example.com', 'apiKey'));
    // }
}
