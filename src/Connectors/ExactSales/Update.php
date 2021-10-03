<?php
/**
 * @todo
 */

namespace Integrations\Connectors\ExactSales;

use Log;
use App\Models\Organization;

class Update extends ExactSales
{
    public function organization(Organization $organization)
    {
        // Also simple to update any ExactSales resource value
        $organization = $this->_connection->organizations->update(
            1,
            [
                'name' => $organization->id
            ]
        );
        var_dump($organization->getData());
    }
}
