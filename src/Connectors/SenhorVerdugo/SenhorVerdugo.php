<?php

namespace Integrations\Connectors\SenhorVerdugo;

use App\Models\Model;
use Log;
use App\Models\User;
use Integrations\Connectors\Connector;

class SenhorVerdugo extends Integration
{
    public static $ID = 15;
    public function getConnection($organizer = false)
    {
        $token = 'xxxxxxxxxxxxxxxxxxxxxxxxxxx';
        return new SenhorVerdugo($token);
    }
}
