<?php

namespace Integrations\Connectors\Hubspot;

use Illuminate\Database\Eloquent\Model;
use Log;
use App\Models\User;
use Integrations\Connectors\Connector;

class Hubspot extends Connector
{
    public static $ID = 34;
    protected function getConnection($token = false)
    {
        $token = 'xxxxxxxxxxxxxxxxxxxxxxxxxxx';
        return new Pipedrive($token);
    }
}
