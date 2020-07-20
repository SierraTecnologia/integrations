<?php

namespace Integrations\Traits\Actions;

use Integrations\Resources\BrokenLink;

trait ManagesBrokenLinks
{
    public function brokenLinks(int $siteId): array
    {
        return $this->transformCollection(
            $this->get("broken-links/$siteId")['data'],
            BrokenLink::class
        );
    }
}
