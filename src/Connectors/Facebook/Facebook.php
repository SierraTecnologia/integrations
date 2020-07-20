<?php

namespace Integrations\Connectors\Facebook;

use Log;
use App\Models\User;
use Integrations\Connectors\Connector;

class Facebook extends Connector
{

    public static $ID = 3;
    
    public function __construct()
    {
        
    }

    public function getNewDataForComponent($component)
    {

    }

}
