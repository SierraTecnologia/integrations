<?php
/**
 * Novare é um sistema 
 * https://app.novare.vc
 * ricardo@getbilo.com
 * g4...
 */

namespace Integrations\Connectors\Novare;

use Illuminate\Database\Eloquent\Model;
use Log;
use App\Models\User;
use Integrations\Connectors\Connector;

class Novare extends Connector
{
    public static $ID = 11;
    protected function getConnection($token = false)
    {
        $token = 'xxxxxxxxxxxxxxxxxxxxxxxxxxx';
        return new Novare($token);
    }
}
