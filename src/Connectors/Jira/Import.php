<?php

namespace Integrations\Connectors\Connector\Jira;

use Log;
use App\Models\User;

use Finder\Models\Digital\Code\CodeIssueLink;
use Casa\Models\Registers\Spent;
use Casa\Models\Calendar\Estimate;
use Casa\Models\Calendar\Event;

use Informate\Models\Comment;

use Finder\Models\Digital\Code\Release;
use Finder\Models\Digital\Code\Issue;
use Finder\Models\Digital\Code\Field as FieldModel;
use Finder\Models\Digital\Code\Project as ProjectModel;

use JiraRestApi\Project\ProjectService;
use JiraRestApi\JiraException;
use JiraRestApi\Field\Field;
use JiraRestApi\Issue\IssueService;
use JiraRestApi\Issue\Version;
use JiraRestApi\Field\FieldService;


class Import extends Jira
{
    public function bundle($output = false)
    {
        Log::channel('sitec-finder')->info('Importando Jira...');
        $this->getFields($output);
        $this->getProjects($output);
        $this->getInfoFromIssues($output);
    }

    public function getFields($output = false)
    {
        try {
            $fieldService = new FieldService($this->getConfig($this->_token));
        
            // $fieldService->getAllFields(Field::CUSTOM),
            $fields = $fieldService->getAllFields(); 
            foreach($fields as $field) {
                FieldModel::registerFieldForProject($field, $this->_token->account->customize_url);
            }
            
        } catch (JiraException $e) {
            $this->setError('testSearch Failed : '.$e->getMessage());
        }
    }

    public function getProjects($output = false)
    {
        Log::channel('sitec-finder')->info('Importando Projetos do Jira...');
        try {
            $proj = new ProjectService($this->getConfig($this->_token));
        
            $prjs = $proj->getAllProjects();
            // Log::channel('sitec-finder')->info(print_r($prjs, true));
        
            foreach ($prjs as $p) {
                // Log::channel('sitec-finder')->info(print_r($p, true));
                // Project Key:USS, Id:10021, Name:User Shipping Service, projectCategory: Desenvolvimento
                if (!$projModel = ProjectModel::where('projectPathKey', $p->key)->first()) {
                    if (!$projModel && !$projModel = ProjectModel::where('projectPath', $p->name)->first()) {
                        $projModel = ProjectModel::create(
                            [
                            'name' => $p->name,
                            'projectPathKey' => $p->key,
                            // 'created_at' => $p->created,
                            // 'updated_at' => $p->updated
                            ]
                        );
                    } else {
                        $projModel->projectPathKey = $p->key;
                        $projModel->save();
                    }
                }
                $this->projectVersions($projModel);

                $this->getIssuesFromProject($projModel);
                // echo sprintf("Project Key:%s, Id:%s, Name:%s, projectCategory: %s\n",
                //     $p->key, $p->id, $p->name, $p->projectCategory['name']
                // );            
            }            
        } catch (JiraException $e) {
            $this->setError("Error Occured! " . $e->getMessage());
        }
    }

    public function getInfoFromIssues($output = false)
    {
        $chunkNumber = 10;
        $object = $this;
        // Trata os Outros Dados dos Usuários                                                                                                                                                    
        Issue::chunk(
            $chunkNumber, function ($issues) use ($output, $object, $chunkNumber) {                                                                                                                               
                foreach ($issues as $issue) {                                                                                                                                                          
                    if ($output) {                                                                                                                                                                  
                        $output->returnOutput()->progressAdvance($chunkNumber);                                                                                                                                 
                    }
                    // $object->issueTimeTracking($issue->key_name); // @todo Retirar Depois
                    // $object->issueWorklog($issue->key_name);
                    $object->comment($issue->key_name);
                    $object->getIssueRemoteLink($issue->key_name);
                }
            }
        );
    }

    public function getIssuesFromProject($project)
    {
        // $jql = 'status = Documentação ORDER BY created DESC';
        // $jql = 'project IN ('.$project->getSlug().')';
        $jql = 'project='.$project->getSlug();
        $paginate = $this->getPaginate(1);
        $result = $this->searchIssue($jql, $paginate);
        if (!empty($result->issues)) {
            foreach ($result->issues as $issue) {
                if (!$issueInstance = Issue::where(['key_name' => $issue->key])->first()) {       
                    $issueInstance = Issue::create(
                        [
                        'key_name' => $issue->key,
                        'url' => $issue->self,
                        // 'created_at' => $issue->created,
                        // 'updated_at' => $issue->updated
                        // 'sumary' => '', @todo fazer aqui 
                        ]
                    );
                    if (!empty($issue->fields)) {
                        $issueInstance->setField($issue->fields, $issue->key);
                    }
                }
            }
        }
    }

    public function searchIssue($jql = false, $paginate = false)
    {
        if (!$jql) {
            $jql = 'project not in (TEST)  and assignee = currentUser() and status in (Resolved, closed)';
        }

        // $jql = str_replace(" ", "%20", $jql);
        $jql = str_replace(" ", "+", $jql);
        $jql = str_replace(" ", "\\u002f", $jql);

        try {
            return (new IssueService($this->getConfig($this->_token)))->search($jql); //, $paginate);
            // return (new IssueService($this->getConfig($this->_token)))->search($jql);
        } catch (JiraException $e) {
            $this->setError('testSearch Failed : '.$e->getMessage());
        }
    }

    public function project($project)
    {
        Log::channel('sitec-finder')->info('Importando Projeto do Jira...');
        try {
            $proj = new ProjectService($this->getConfig($this->_token));
        
            $p = $proj->get($project->getSlug());
            
            var_dump($p);            
        } catch (JiraException $e) {
            $this->setError("Error Occured! " . $e->getMessage());
        }
    }

    public function issueTimeTracking($issueKey = 'TEST-961')
    {

        try {
            $issueService = new IssueService($this->getConfig($this->_token));
            
            // get issue's time tracking info
            $rets = $issueService->getTimeTracking($issueKey);
            Spent::registerSpentForIssue($rets, $this->_token->account->customize_url);

            
            // $timeTracking = new TimeTracking;

            // $timeTracking->setOriginalEstimate('3w 4d 6h');
            // $timeTracking->setRemainingEstimate('1w 2d 3h');
            
            // // add time tracking
            // $ret = $issueService->timeTracking($issueKey, $timeTracking);
            // var_dump($ret);
        } catch (JiraException $e) {
            $this->setError('testSearch Failed : '.$e->getMessage());
        }
    }

    public function issueWorklog($issueKey = 'TEST-961')
    {

        try {
            $issueService = new IssueService($this->getConfig($this->_token));
            
            // get issue's all worklog
            $worklogs = $issueService->getWorklog($issueKey)->getWorklogs();
            Spent::registerSpentForIssue($worklogs, $this->_token->account->customize_url);
            
            // // get worklog by id
            // $wlId = 12345;
            // $wl = $issueService->getWorklogById($issueKey, $wlId);
            // var_dump($wl);
            
        } catch (JiraException $e) {
            $this->setError('testSearch Failed : '.$e->getMessage());
        }
    }

    public function issueLinkType()
    {
        try {
            $ils = new IssueLinkService($this->getConfig($this->_token));
        
            $rets = $ils->getIssueLinkTypes();
            foreach($rets as $ret) {
                var_dump($ret);
                CodeIssueLink::firstOrCreate(
                    [
                    'name' => $ret->name
                    ]
                );
            }
            
        } catch (JiraException $e) {
            $this->setError("Error Occured! " . $e->getMessage());
        }
    }

    public function getIssueRemoteLink($issueKey = 'TEST-316')
    {
        try {
            $issueService = new IssueService($this->getConfig($this->_token));

            $rils = $issueService->getRemoteIssueLink($issueKey);
            foreach($rils as $ril) {
                var_dump($ril);
                CodeIssueLink::firstOrCreate(
                    [
                    'name' => $ril->name
                    ]
                );
            }
        } catch (JiraException $e) {
            $this->setError($e->getMessage());
        }
    }

    public function comment($issueKey = "TEST-879")
    {

        try {
            $issueService = new IssueService($this->getConfig($this->_token));
        
            $comments = $issueService->getComments($issueKey);
            Comment::registerComents(
                $comments,
                $issueKey,
                Issue::class,
                $this->_token->account->customize_url
            );
        
        
        } catch (JiraException $e) {
            $this->setError('get Comment Failed : '.$e->getMessage());
        }
    }

    public function getFieldInfo($issueKey = "TEST-879")
    {
        try {
            $issueService = new IssueService($this->getConfig($this->_token));
            
            $queryParam = [
                'fields' => [  // default: '*all'
                    'summary',
                    'comment',
                ],
                'expand' => [
                    'renderedFields',
                    'names',
                    'schema',
                    'transitions',
                    'operations',
                    'editmeta',
                    'changelog',
                ]
            ];
                    
            $issue = $issueService->get($issueKey, $queryParam);
            
            var_dump($issue->fields);    
        } catch (JiraException $e) {
            $this->setError("Error Occured! " . $e->getMessage());
        }
    }

    public function projectVersions($projInstance)
    {
        try {
            $proj = new ProjectService($this->getConfig($this->_token));
        
            $vers = $proj->getVersions($projInstance->getSlug());
        
            foreach ($vers as $v) {
                // $v is  JiraRestApi\Issue\Version
                if (!Release::where(
                    [
                        'name' => $v->name,
                        'code_project_id' => $projInstance->id
                    ]
                )->first()
                ) {
                    Release::create(
                        [
                        'name' => $v->name,
                        // 'start' => $v->startDate,
                        'release' => $v->releaseDate,
                        'code_project_id' => $projInstance->id,
                        'created_at' => $v->created,
                        'updated_at' => $v->updated
                        ]
                    );
                }
            }
        } catch (JiraException $e) {
            $this->setError("Error Occured! " . $e->getMessage());
        }
    }

    public function projectType()
    {
        try {
            $proj = new ProjectService($this->getConfig($this->_token));
        
            // get all project type
            $prjtyps = $proj->getProjectTypes();
        
            foreach ($prjtyps as $pt) {
                var_dump($pt);
            }
        
            // get specific project type.
            $pt = $proj->getProjectType('software');
            var_dump($pt);
        
        } catch (JiraException $e) {
            $this->setError("Error Occured! " . $e->getMessage());
        }
    }
}
