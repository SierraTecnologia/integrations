<?php

namespace Integrations\Connectors\Pipedrive;

use Log;
use App\Models\User;

class Create extends Pipedrive
{
    public function project(Project $project)
    {
        $arrayFromProject = array(
            'description' => $project->description,
            'issues_enabled' => false
        );
        $project = $client->api('projects')->create($project->name, $arrayFromProject);
    }
}
