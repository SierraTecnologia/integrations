<?php

namespace Integrations\Traits\Actions;

use Integrations\Resources\StatusPage;

trait ManagesStatusPages
{
    public function statusPages(): array
    {
        return $this->transformCollection(
            $this->get('status-pages')['data'],
            StatusPage::class
        );
    }

    public function statusPage(int $statusPageId): StatusPage
    {
        $statusPageAttributes = $this->get("status-pages/{$statusPageId}");

        return new StatusPage($statusPageAttributes, $this);
    }
}
