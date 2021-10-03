<?php
/**
 * @todo
 */

namespace Integrations\Connectors\Hubspot;

use Log;

class Update extends Hubspot
{
    public function organization(Organization $organization)
    {
        // Also simple to update any Hubspot resource value
        $organization = $this->_connection->organizations->update(
            1,
            [
                'name' => $organization->id
            ]
        );
        var_dump($organization->getData());
    }
}
