<?php

namespace Integrations\Connectors\SenhorVerdugo;

use Log;
use App\Models\Project as ProjectModel;
use SenhorVerdugoRestApi\Project\ProjectService;
use SenhorVerdugoRestApi\SenhorVerdugoException;

class Delete extends SenhorVerdugo
{
    public function watchFromIssue()
    {
        $issueKey = 'TEST-961';

        try {
            $issueService = new IssueService();
            
            // watcher's id
            $watcher = 'lesstif';
            
            $issueService->removeWatcher($issueKey, $watcher);
            
        } catch (SenhorVerdugoException $e) {
            $this->assertTrue(false, 'add watcher Failed : '.$e->getMessage());
        }
    }

    public function comment()
    {
        $issueKey = "TEST-879";

        try {
            $commentId = 12345;

            $issueService = new IssueService();

            $ret = $issueService->deleteComment($issueKey, $commentId);

        } catch (SenhorVerdugoException $e) {
            $this->assertTrue(false, 'Delete comment Failed : '.$e->getMessage());
        }

    }

    public function issue()
    {

        $issueKey = "TEST-879";

        try {
            $issueService = new IssueService();

            $ret = $issueService->deleteIssue($issueKey);
            // if you want to delete issues with sub-tasks
            //$ret = $issueService->deleteIssue($issueKey, array('deleteSubtasks' => 'true'));

            var_dump($ret);
        } catch (SenhorVerdugoException $e) {
            $this->assertTrue(false, "Change Assignee Failed : " . $e->getMessage());
        }
    }

    public function project(ProjectModel $project)
    {
        try {
            $proj = new ProjectService();
        
            $pj = $proj->deleteProject('EX');
           
            var_dump($pj);
        } catch (SenhorVerdugoException $e) {
            print("Error Occured! " . $e->getMessage());
        }
    }
}
