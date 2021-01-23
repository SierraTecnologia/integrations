<?php

namespace Integrations\Connectors\Opera;

use Illuminate\Database\Eloquent\Model;
use Log;
use Integrations\Connectors\Connector;

class Opera extends Connector
{
    public static $ID = 36;

    // protected function getConnection($token = false)
    // {
    //     return new Cloudflare\API\Adapter\Guzzle(new APIKey('user@example.com', 'apiKey'));
    // }
}
