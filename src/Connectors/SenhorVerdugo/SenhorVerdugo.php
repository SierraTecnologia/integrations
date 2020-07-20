<?php

namespace Integrations\Connectors\Connector\SenhorVerdugo;

use App\Models\Model;
use Log;
use App\Models\User;
use Integrations\Connectors\Connector\Integration;

class SenhorVerdugo extends Integration
{
    public static $ID = 15;
    public function getConnection($organizer = false)
    {
        $token = 'xxxxxxxxxxxxxxxxxxxxxxxxxxx';
        return new SenhorVerdugo($token);
    }
}
