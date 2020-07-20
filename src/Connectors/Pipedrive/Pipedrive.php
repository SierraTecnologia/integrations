<?php

namespace Integrations\Connectors\Connector\Pipedrive;

use Illuminate\Database\Eloquent\Model;
use Log;
use App\Models\User;
use Integrations\Connectors\Connector\Integration;

class Pipedrive extends Integration
{
    public static $ID = 14;
    protected function getConnection($token = false)
    {
        $token = 'xxxxxxxxxxxxxxxxxxxxxxxxxxx';
        return new Pipedrive($token);
    }
}
