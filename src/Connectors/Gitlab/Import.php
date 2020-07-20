<?php

namespace Integrations\Connectors\Gitlab;

use Log;
use App\Models\User;

class Import extends Gitlab
{
    public function bundle($output = false)
    {
        dd(
            $this->_connection->api('projects')->all()
        );
        $this->projects($output);
    }
    
    public function projects($output)
    {
        $project = $client->api('projects')->create(
            'My Project', array(
            'description' => 'This is a project',
            'issues_enabled' => false
            )
        );
    }
}
