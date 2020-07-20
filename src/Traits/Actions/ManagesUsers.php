<?php

namespace Integrations\Traits\Actions;

use Integrations\Resources\User;

trait ManagesUsers
{
    public function me(): User
    {
        $userAttributes = $this->get('me');

        return new User($userAttributes, $this);
    }
}
