<?php

namespace Integrations\Connectors\Pipedrive;

use Illuminate\Database\Eloquent\Model;
use Log;
use App\Models\User;
use Integrations\Connectors\Connector;

class Pipedrive extends Connector
{
    public static $ID = 14;
    protected function getConnection($token = false)
    {
        $token = 'xxxxxxxxxxxxxxxxxxxxxxxxxxx';
        return new Pipedrive($token);
    }
}
