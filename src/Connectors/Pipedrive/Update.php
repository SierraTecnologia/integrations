<?php

namespace Integrations\Connectors\Pipedrive;

use Log;
use App\Models\User;

class Update extends Pipedrive
{
    public function organization(Organization $organization)
    {
        // Also simple to update any Pipedrive resource value
        $organization = $this->_connection->organizations->update(
            1,
            [
                'name' => $organization->id
            ]
        );
        var_dump($organization->getData());
    }
}
