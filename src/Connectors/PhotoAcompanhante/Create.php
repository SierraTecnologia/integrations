<?php

namespace Integrations\Connectors\Connector\PhotoAcompanhante;

use Log;
use App\Models\User;

class Create extends PhotoAcompanhante
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
