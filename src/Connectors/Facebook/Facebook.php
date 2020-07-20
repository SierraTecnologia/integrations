<?php

namespace Integrations\Connectors\Connector\Facebook;

use Log;
use App\Models\User;
use Integrations\Connectors\Connector\Integration;

class Facebook extends Integration
{

    public static $ID = 3;
    
    public function __construct()
    {
        
    }

    public function getNewDataForComponent($component)
    {

    }

}
