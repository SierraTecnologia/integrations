<?php

namespace Integrations\Traits\Actions;

use Integrations\Resources\Check;

trait ManagesChecks
{
    public function enableCheck(int $checkId): Check
    {
        $checkAttributes = $this->post("checks/{$checkId}/enable");

        return new Check($checkAttributes, $this);
    }

    public function disableCheck(int $checkId): Check
    {
        $checkAttributes = $this->post("checks/{$checkId}/disable");

        return new Check($checkAttributes, $this);
    }

    public function requestRun(int $checkId): Check
    {
        $checkAttributes = $this->post("checks/{$checkId}/request-run");

        return new Check($checkAttributes, $this);
    }

    public function snooze(int $checkId, int $minutes)
    {
        $checkAttributes = $this->post(
            "checks/{$checkId}/snooze", [
            'minutes' => $minutes,
            ]
        );

        return new Check($checkAttributes, $this);
    }

    public function unsnooze(int $checkId): Check
    {
        $checkAttributes = $this->post("checks/{$checkId}/unsnooze");

        return new Check($checkAttributes, $this);
    }
}
