<?php
/**
 * Rotinas de Inclusão de Dados
 */

namespace Integrations\Tools\Software;


/**
 * Header file
*/
use PhpOffice\PhpProject\Autoloader;
use PhpOffice\PhpProject\IOFactory;

error_reporting(E_ALL);
define('CLI', (PHP_SAPI == 'cli') ? true : false);
define('EOL', CLI ? PHP_EOL : '<br />');
define('SCRIPT_FILENAME', basename($_SERVER['SCRIPT_FILENAME'], '.php'));
define('IS_INDEX', SCRIPT_FILENAME == 'index');

require_once __DIR__ . '/../src/PhpProject/Autoloader.php';
Autoloader::register();

class FilePrograms
{
    public function __construct($file)
    {
        
    }

    /**
     * @return (bool|string)[][]
     *
     * @psalm-return array{php: array{0: 'PHP 5.3.0', 1: bool}, xml: array{0: 'PHP extension XML', 1: bool}, zip: array{0: 'PHP extension ZipArchive (optional)', 1: bool}, xmlw: array{0: 'PHP extension XMLWriter (optional)', 1: bool}}
     */
    public function getRequirements(): array
    {
        return array(
        'php'   => array('PHP 5.3.0', version_compare(phpversion(), '5.3.0', '>=')),
        'xml'   => array('PHP extension XML', extension_loaded('xml')),
        'zip'   => array('PHP extension ZipArchive (optional)', extension_loaded('zip')),
        'xmlw'  => array('PHP extension XMLWriter (optional)', extension_loaded('xmlwriter')),
        );
    }

    /**
     * @return array[]
     *
     * @psalm-return array<list<mixed>>
     */
    public function getExtension($extension): array
    {
        $returnWrites = [];
        $types = $this->getTypes;
        foreach($types as $type) {
            $writes = (new $type)->getWrites($class, $type);
            foreach ($writes as $writerNameClass=>$extensionWriterClass)
            {
                if ($extensionWriterClass==$extension) {
                    if (!isset($returnWrites[$type])) {
                        $returnWrites[$type] = [];
                    }
                    $returnWrites[$type][] = $writerNameClass;
                }
            }
        }
        return $returnWrites;
    }

    /**
     * @return string[]
     *
     * @psalm-return array{0: Types\Project::class}
     */
    public function getTypes(): array
    {
        return [
        Types\Project::class
        ];
    }

    public function run(): void
    {
        $this->header();
        $this->getRequirements();
        if (!CLI) {
            ?>
        <div class="jumbotron">
        <p>Welcome to PHPProject, a library written in pure PHP that provides a set of classes to write to and read from different document file formats, i.e. GanttProject (.gan) and MS Project (.mpx).</p>
        <p>&nbsp;</p>
        <p>
            <a class="btn btn-lg btn-primary" href="https://github.com/PHPOffice/PHPProject" role="button"><i class="fa fa-github fa-lg" title="GitHub"></i>  Fork us on Github!</a>
            <a class="btn btn-lg btn-primary" href="http://phpproject.readthedocs.org/en/develop/" role="button"><i class="fa fa-book fa-lg" title="Docs"></i>  Read the Docs</a>
        </p>
        </div>
            <?php
        }
        if (!CLI) {
            echo "<h3>Requirement check:</h3>";
            echo "<ul>";
            foreach ($requirements as $key => $value) {
                list($label, $result) = $value;
                $status = $result ? 'passed' : 'failed';
                echo "<li>{$label} ... <span class='{$status}'>{$status}</span></li>";
            }
            echo "</ul>";
            include_once 'Sample_Footer.php';
        } else {
            echo 'Requirement check:' . PHP_EOL;
            foreach ($requirements as $key => $value) {
                list($label, $result) = $value;
                $status = $result ? '32m passed' : '31m failed';
                echo "{$label} ... \033[{$status}\033[0m" . PHP_EOL;
            }
        }


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

    /**
     * @return void
     */
    public function header()
    {

        // Set writers
        $writers = $this->getWrites();

        // Return to the caller script when runs by CLI
        if (CLI) {
            return;
        }

        // Set titles and names
        $pageHeading = str_replace('_', ' ', SCRIPT_FILENAME);
        $pageTitle = IS_INDEX ? 'Welcome to ' : "{$pageHeading} - ";
        $pageTitle .= 'PHPProject';
        $pageHeading = IS_INDEX ? '' : "<h1>{$pageHeading}</h1>";

        // Populate samples
        $files = '';
        if ($handle = opendir('.')) {
            while (false !== ($file = readdir($handle))) {
                if (preg_match('/^Sample_\d+_/', $file)) {
                    $name = str_replace('_', ' ', preg_replace('/(Sample_|\.php)/', '', $file));
                    $files .= "<li><a href='{$file}'>{$name}</a></li>";
                }
            }
            closedir($handle);
        }

        ?>
        <title><?php echo $pageTitle; ?></title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
        <link rel="stylesheet" href="bootstrap/css/font-awesome.min.css" />
        <link rel="stylesheet" href="bootstrap/css/phppowerpoint.css" />
        </head>
        <body>
        <div class="container">
        <div class="navbar navbar-default" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="./">PHPProject</a>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li class="dropdown active">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-code fa-lg"></i>&nbsp;Samples<strong class="caret"></strong></a>
                            <ul class="dropdown-menu"><?php echo $files; ?></ul>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="https://github.com/PHPOffice/PHPProject"><i class="fa fa-github fa-lg" title="GitHub"></i>&nbsp;</a></li>
                        <li><a href="http://phpproject.readthedocs.org/en/develop/"><i class="fa fa-book fa-lg" title="Docs"></i>&nbsp;</a></li>
                        <li><a href="http://twitter.com/PHPOffice"><i class="fa fa-twitter fa-lg" title="Twitter"></i>&nbsp;</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <?php echo $pageHeading; ?>
        <?php
    }

    /**
     * Write documents
     *
     * @param \PhpOffice\PhpWord\PhpWord $phpWord
     * @param string                     $filename
     * @param array                      $writers
     *
     * @return string
     */
    function write($phpPowerPoint, $filename, $writers): string
    {
        $result = '';
        
        // Write documents
        foreach ($writers as $writer => $extension) {
            $result .= date('H:i:s') . " Write to {$writer} format";
            if (!is_null($extension)) {
                $xmlWriter = IOFactory::createWriter($phpPowerPoint, $writer);
                $xmlWriter->save(__DIR__ . DIRECTORY_SEPARATOR."{$filename}.{$extension}");
                rename(__DIR__ . "/{$filename}.{$extension}", __DIR__ . "/results/{$filename}.{$extension}");
            } else {
                $result .= ' ... NOT DONE!';
            }
            $result .= EOL;
        }

        $result .= getEndingNotes($writers);

        return $result;
    }

    /**
     * Get ending notes
     *
     * @param array $writers
     *
     * @return string
     */
    function getEndingNotes($writers): string
    {
        $result = '';

        // Do not show execution time for index
        if (!IS_INDEX) {
            $result .= date('H:i:s') . " Done writing file(s)" . EOL;
            $result .= date('H:i:s') . " Peak memory usage: " . (memory_get_peak_usage(true) / 1024 / 1024) . " MB" . EOL;
        }

        // Return
        if (CLI) {
            $result .= 'The results are stored in the "results" subdirectory.' . EOL;
        } else {
            if (!IS_INDEX) {
                $types = array_values($writers);
                $result .= '<p>&nbsp;</p>';
                $result .= '<p>Results: ';
                foreach ($types as $type) {
                    if (!is_null($type)) {
                        $resultFile = 'results/' . SCRIPT_FILENAME . '.' . $type;
                        if (file_exists($resultFile)) {
                            $result .= "<a href='{$resultFile}' class='btn btn-primary'>{$type}</a> ";
                        }
                    }
                }
                $result .= '</p>';
            }
        }

        return $result;
    }

    function echoTask($oPHPProject, $oTask, $level = 0): void
    {
        echo '<strong>'.str_repeat('>', 2 * $level).' Task : '.$oTask->getName().'</strong>'.EOL;
        echo ' '.str_repeat('>', 2 * ($level + 1)).' Duration : '.$oTask->getDuration().EOL;
        echo ' '.str_repeat('>', 2 * ($level + 1)).' StartDate : '.date('Y-m-d', $oTask->getStartDate()).EOL;
        echo ' '.str_repeat('>', 2 * ($level + 1)).' Progress : '.$oTask->getProgress().EOL;
        echo ' '.str_repeat('>', 2 * ($level + 1)).' Resources : '.EOL;
        $oTaskResources = $oTask->getResources();
        if(!empty($oTaskResources)) {
            foreach ($oTaskResources as $oResource){
                echo ' '.str_repeat('>', 2 * ($level + 2)).' Resource : '.$oResource->getTitle().EOL;
            }
        }
        echo EOL;
        $level++;
        if($oTask->getTaskCount() > 0) {
            foreach ($oTask->getTasks() as $oSubTask){
                echoTask($oPHPProject, $oSubTask, $level);
            }
        }
        $level--;
    }
}
