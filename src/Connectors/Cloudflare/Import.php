<?php

namespace Integrations\Connectors\Cloudflare;

use Log;
use App\Models\User;

class Import extends Cloudflare
{
    public function zones()
    {
        // Create a new DNS record
        $endpoint = new \Cloudflare\API\Endpoints\Zones($this->_connection);
        return  $endpoint->listZones();
    }

    public function pageRules()
    {
        // Create a new DNS record
        $endpoint = new \Cloudflare\API\Endpoints\PageRules($this->_connection);
        return  $endpoint->listZones();
    }

    public function dns()
    {
        // Create a new DNS record
        $endpoint = new \Cloudflare\API\Endpoints\DNS($this->_connection);
        return  $endpoint->listRecords();
    }
}
