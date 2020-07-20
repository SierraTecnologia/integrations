<?php
/**
 * Integração com o Test Link.
 * 
 * Equipe de Qa
 */

namespace Integrations\Connectors\Connector\Testlink;

use Illuminate\Database\Eloquent\Model;
use Log;
use App\Models\User;
use Integrations\Connectors\Connector\Integration;

class Testlink extends Integration
{
    public static $ID = 19;
    protected function getConnection($token = false)
    {
        $token = 'xxxxxxxxxxxxxxxxxxxxxxxxxxx';
        return new Testlink($token);
    }
}
