<?php

namespace Integrations\Connectors\Connector\Amazon;

use Illuminate\Database\Eloquent\Model;
use Log;
use Integrations\Connectors\Connector\Integration;

class Amazon extends Integration
{
    public static $ID = 28;

    // protected function getConnection($token = false)
    // {
    //     return new Cloudflare\API\Adapter\Guzzle(new APIKey('user@example.com', 'apiKey'));
    // }
}
