<?php

namespace Integrations\Connectors\Connector\Cloudflare;

use Log;
use App\Models\User;
use Cloudflare\Zone\Pagerules;
use Cloudflare\Zone\Dns;

class Create extends Cloudflare
{
    public function newDnsZone(Project $project)
    {
        // Create a new DNS record
        $endpoint = new \Cloudflare\API\Endpoints\Zones($this->_connection);
        $name = '';
        $jumpStart = false;
        $organizationID = '';
        $dns = '';
        return  $dns->addZone($name, $jumpStart, $organizationID);
    }

    public function newDns(Project $project)
    {
        // Create a new DNS record
        $endpoint = new \Cloudflare\API\Endpoints\DNS($this->_connection);
        $zoneID = '';
        $type = '';
        $name = '';
        $content = '';
        $ttl = 0;
        return  $dns->addRecord($zoneID, $type, $name, $content, $ttl);
    }

    public function createPageRule()
    {
        $endpoint = new \Cloudflare\API\Endpoints\PageRules($this->_connection);
        // Define your targets
        // Currently you can only specify one URL per page rule but this implementation matches the API
        // so I am leaving it for now in the assumption they are planning to add multiple targets.
        // PageRulesTargets
        $target = [
            [
                'target' => 'url',
                'constraint' =>
                [
                    'operator' => 'matches',
                    'value' => 'http://example.co.uk/*'
                ]
            ]
        ];
    
        // Define your actions
        // Each action is held within it's own array.
        // PageRulesActions
        $actions = [
            [
                'id' => 'always_online',
                'value' => 'on'
            ]
        ];

        $active = true;
        $priority = null; //int
    
        $endpoint->createPageRule($zoneID, $targets, $actions, $active, $priority);
    }
}
