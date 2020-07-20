<?php

namespace Integrations\Connectors\Gitlab;

use Log;
use App\Models\User;

class Create extends Gitlab
{
    public function project(Project $project)
    {
        $project = $this->_connection->api('projects')->create(
            $project->name,
            $this->fromBossProject($project)
        );
        return $project;
    }

    public function projectWithModel(Project $project)
    {
        // Creating a new project
        $project = \Gitlab\Model\Project::create(
            $this->_connection,
            $project->name,
            $this->fromBossProject($project)
        );
        return $project;
    }

    private function fromBossProject(Project $project)
    {
        return [
            'description' => $project->description,
            'issues_enabled' => false
        ];
    }
}
