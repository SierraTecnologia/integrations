<?php

namespace Integrations\Connectors\Cloudflare;

use Illuminate\Database\Eloquent\Model;
use Log;
use Cloudflare\API\Auth\APIKey;
use App\Models\User;
use Integrations\Connectors\Connector;

class Cloudflare extends Integration
{
    public static $ID = 1;

    protected function getConnection($token = false)
    {
        return new Cloudflare\API\Adapter\Guzzle(new APIKey('user@example.com', 'apiKey'));
    }
}
