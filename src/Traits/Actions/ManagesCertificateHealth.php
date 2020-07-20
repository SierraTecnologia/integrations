<?php

namespace Integrations\Traits\Actions;

use Integrations\Resources\CertificateHealth;

trait ManagesCertificateHealth
{
    public function certificateHealth(int $siteId)
    {
        return new CertificateHealth($this->get("certificate-health/{$siteId}"));
    }
}
