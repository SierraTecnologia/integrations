<?php

namespace Integrations\Connectors\Gitlab;

use Log;
use App\Models\User;
use Finder\Models\Code\Project;
use Fabrica\Bundle\CoreBundle\EventDispatcher\FabricaEvents;
use Fabrica\Bundle\CoreBundle\EventDispatcher\Event\ProjectEvent;

/**
 * https://github.com/GitLabPHP/Client/blob/9.18/lib/Gitlab/Api/Projects.php
 */
class Import extends Gitlab
{
    public function handle($output = false)
    {
        $this->projects($output);
    }
    
    public function projects($output)
    {
        $projects = $this->_connection->api('projects')->all(
            [
            'owned' => true
            ]
        );

        foreach ($projects as $project) {
            try {
                if (!$projectModel = Project::where(['projectPathKey' => $project['path_with_namespace']])->first()) {
                    $this->info('Importando Projeto: '.$project['path_with_namespace']);
                    $projectModel = new Project();
                    $projectModel->setName($project['name']);
                    $projectModel->setSlug($project['path_with_namespace']);
            
                    $projectModel->save();
            
                    $event = new ProjectEvent($projectModel);
                    event($event);
                }

            } catch (\Throwable $th) {
                
                dd(
                    'ImportGitlab',
                    $project,
                    $project['name'],
                    $project['path_with_namespace'],
                    $th->getMessage()
                );
            }
        }
    }
    public function issuesWithPager($output)
    {
        $pager = new \Gitlab\ResultPager($this->_connection);
        $issues = $pager->fetchAll($client->issues(), 'all', [null, ['state' => 'closed']]);

        // @todo
    }
}
