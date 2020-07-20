<?php

namespace Integrations\Traits\Actions;

use Integrations\Resources\MixedContentItem;

trait ManagesMixedContent
{
    public function mixedContent(int $siteId): array
    {
        return $this->transformCollection(
            $this->get("mixed-content/$siteId")['data'],
            MixedContentItem::class
        );
    }
}
