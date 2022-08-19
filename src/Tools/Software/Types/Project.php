<?php
/**
 * Rotinas de Inclusão de Dados
 */

namespace Integrations\Tools\Software;

use PhpOffice\PhpProject\PHPProject;

class Project
{
    public $file;
    public function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * @return string[]
     *
     * @psalm-return array{GanttProject: 'gan', MsProjectMPX: 'mpx'}
     */
    public function getWrites(): array
    {
        return array(
            'GanttProject' => 'gan',
            'MsProjectMPX' => 'mpx'
        );
    }

    public function reader(): void
    {
        // Create new PHPProject object
        echo date('H:i:s') . ' Create new PHPProject object'.EOL;
        
        $objReader = IOFactory::createReader('GanttProject');
        $objPHPProject = $objReader->load($this->file->getTmp());

        // Set properties
        echo date('H:i:s') . ' Get properties'.EOL;
        echo 'Creator > '.$objPHPProject->getProperties()->getCreator().EOL;
        echo 'LastModifiedBy > '.$objPHPProject->getProperties()->getLastModifiedBy().EOL;
        echo 'Title > '.$objPHPProject->getProperties()->getTitle().EOL;
        echo 'Subject > '.$objPHPProject->getProperties()->getSubject().EOL;
        echo 'Description > '.$objPHPProject->getProperties()->getDescription().EOL;
        echo EOL;
        // Add some data
        echo date('H:i:s') . ' Get some data'.EOL;
        echo 'StartDate > '.$objPHPProject->getInformations()->getStartDate().EOL;
        echo 'EndDate > '.$objPHPProject->getInformations()->getEndDate().EOL;
        echo EOL;
        // Ressources
        echo date('H:i:s') . ' Get ressources'.EOL;
        foreach ($objPHPProject->getAllResources() as $oResource){
            echo 'Resource : '.$oResource->getTitle().EOL;
        }
        echo EOL;
        // Tasks
        echo date('H:i:s') . ' Get tasks'.EOL;
        foreach ($objPHPProject->getAllTasks() as $oTask){
            echoTask($objPHPProject, $oTask);
        }
        // Echo done
        echo date('H:i:s') . ' Done reading file.'.EOL;
        if (!CLI) {
            include_once 'Sample_Footer.php';
        }
    }


    public function create(): void
    {
        
        // Create new PHPProject object
        echo date('H:i:s') . ' Create new PHPProject object'.EOL;
        $objPHPProject = new PHPProject();
        // Set properties
        echo date('H:i:s') . ' Set properties'.EOL;
        $objPHPProject->getProperties()->setCreator('Progi1984');
        $objPHPProject->getProperties()->setLastModifiedBy('Progi1984');
        $objPHPProject->getProperties()->setTitle('Office 2007 MPP Test Document');
        $objPHPProject->getProperties()->setSubject('Office 2007 MPP Document');
        $objPHPProject->getProperties()->setDescription('Test document for Office 2007 MPP, generated using PHPProject.');
        // Add some data
        echo date('H:i:s') . ' Add some data'.EOL;
        $objPHPProject->getInformations()->setStartDate('01-01-2012');
        $objPHPProject->getInformations()->setEndDate('31-12-2012');
        // Create a first resource
        $objRes1 = $objPHPProject->createResource();
        $objRes1->setTitle('Progi1984');
        // Create a second resource
        $objRes2 = $objPHPProject->createResource();
        $objRes2->setTitle('AnotherMan');
        $objTask1 = $objPHPProject->createTask();
        $objTask1->setName('Start of the project');
        $objTask1->setStartDate('02-01-2012');
        $objTask1->setEndDate('03-01-2012');
        $objTask1->setProgress(0.5);
        $objTask1->addResource($objRes1);
        echo 'Resources "Start of the project"'.EOL;
        foreach ($objTask1->getResources() as $oResource){
            echo ' > '.$oResource->getTitle().EOL;
        }
        $objTask2 = $objPHPProject->createTask();
        $objTask2->setName('Analysis');
        $objTask21 = $objTask2->createTask();
        $objTask21->setName('Analysis Code');
        $objTask21->setStartDate('03-01-2012');
        $objTask21->setEndDate('04-01-2012');
        $objTask21->setProgress(1);
        $objTask21->addResource($objRes2);
        $objTask21->addResource($objRes1);
        $objTask21->addResource($objRes1);
        echo 'Resources "Analysis Code"'.EOL;
        foreach ($objTask21->getResources() as $oResource){
            echo ' > '.$oResource->getTitle().EOL;;
        }
        $objTask22 = $objTask2->createTask();
        $objTask22->setName('Analysis Database');
        $objTask22->setStartDate('04-01-2012');
        $objTask22->setEndDate('06-01-2012');
        $objTask22->setProgress(0.3);
        
        // Save file
        echo write($objPHPProject, basename(__FILE__, '.php'), $writers);
    }
}
