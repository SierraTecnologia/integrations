<?php

namespace Integrations\Connectors\Wakatime;

use Illuminate\Database\Eloquent\Model;
use Log;
use Integrations\Connectors\Connector;

class Wakatime extends Connector
{
    public static $ID = 37;

    // protected function getConnection($token = false)
    // {
    //     return new Cloudflare\API\Adapter\Guzzle(new APIKey('user@example.com', 'apiKey'));
    // }
}
