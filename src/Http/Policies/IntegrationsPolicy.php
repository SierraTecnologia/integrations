<?php

namespace Integrations\Http\Policies;

use App\Models\User;

/**
 * Class IntegrationsPolicy.
 *
 * @package Finder\Http\Policies
 */
class IntegrationsPolicy
{
    /**
     * Create a integrations.
     *
     * @param  User   $authUser
     * @param  string $integrationsClass
     * @return bool
     */
    public function create(User $authUser, string $integrationsClass)
    {
        if ($authUser->toEntity()->isAdministrator()) {
            return true;
        }

        return false;
    }

    /**
     * Get a integrations.
     *
     * @param  User  $authUser
     * @param  mixed $integrations
     * @return bool
     */
    public function get(User $authUser, $integrations)
    {
        return $this->hasAccessToIntegrations($authUser, $integrations);
    }

    /**
     * Determine if an authenticated user has access to a integrations.
     *
     * @param  User $authUser
     * @param  $integrations
     * @return bool
     */
    private function hasAccessToIntegrations(User $authUser, $integrations): bool
    {
        if ($authUser->toEntity()->isAdministrator()) {
            return true;
        }

        if ($integrations instanceof User && $authUser->id === optional($integrations)->id) {
            return true;
        }

        if ($authUser->id === optional($integrations)->created_by_user_id) {
            return true;
        }

        return false;
    }

    /**
     * Update a integrations.
     *
     * @param  User  $authUser
     * @param  mixed $integrations
     * @return bool
     */
    public function update(User $authUser, $integrations)
    {
        return $this->hasAccessToIntegrations($authUser, $integrations);
    }

    /**
     * Delete a integrations.
     *
     * @param  User  $authUser
     * @param  mixed $integrations
     * @return bool
     */
    public function delete(User $authUser, $integrations)
    {
        return $this->hasAccessToIntegrations($authUser, $integrations);
    }
}
