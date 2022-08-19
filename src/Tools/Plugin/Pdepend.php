<?php

namespace Integrations\Tools\Plugin;

use Integrations\Tools\Builder;
use Integrations\Tools\Config;
use Fabrica\Models\Infra\Ci\Build;
use Integrations\Tools\Plugin;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Pdepend Plugin - Allows Pdepend report
 *
 * @author Johan van der Heide <info@japaveh.nl>
 */
class Pdepend extends Plugin
{
    protected $args;

    /**
     * @var string
     */
    protected $buildDirectory;

    /**
     * @var string
     */
    protected $buildBranchDirectory;

    /**
     * @var string File where the summary.xml is stored
     */
    protected $summary;

    /**
     * @var string File where the chart.svg is stored
     */
    protected $chart;

    /**
     * @var string File where the pyramid.svg is stored
     */
    protected $pyramid;

    /**
     * @var string
     */
    protected $buildLocation;

    /**
     * @var string
     */
    protected $buildBranchLocation;

    /**
     * @return string
     */
    public static function pluginName()
    {
        return 'pdepend';
    }

    /**
     * {@inheritdoc}
     */
    public function __construct(Builder $builder, Build $build, array $options = [])
    {
        parent::__construct($builder, $build, $options);

        $this->summary   = 'summary.xml';
        $this->pyramid   = 'pyramid.svg';
        $this->chart     = 'chart.svg';

        $this->executable = $this->findBinary('pdepend');

        $this->buildDirectory       = $build->getBuildDirectory();
        $this->buildBranchDirectory = $build->getBuildBranchDirectory();

        $this->buildLocation       = PUBLIC_DIR . 'artifacts/pdepend/' . $this->buildDirectory;
        $this->buildBranchLocation = PUBLIC_DIR . 'artifacts/pdepend/' . $this->buildBranchDirectory;
    }

    /**
     * Runs Pdepend with the given criteria as arguments
     */
    public function execute()
    {
        $allowPublicArtifacts = (bool) Config::getInstance()->get(
            'php-censor.build.allow_public_artifacts',
            true
        );

        $fileSystem = new Filesystem();

        if (!$fileSystem->exists($this->buildLocation)) {
            $fileSystem->mkdir($this->buildLocation, (0777 & ~umask()));
        }

        if (!is_writable($this->buildLocation)) {
            throw new \Exception(
                sprintf(
                    'The location %s is not writable or does not exist.',
                    $this->buildLocation
                )
            );
        }

        $pdepend = $this->executable;
        $cmd     = 'cd "%s" && ' . $pdepend . ' --summary-xml="%s" --jdepend-chart="%s" --overview-pyramid="%s" %s "%s"';

        $ignore = '';
        if (count($this->ignore)) {
            $ignore = sprintf(' --ignore="%s"', implode(',', $this->ignore));
        }

        $success = $this->builder->executeCommand(
            $cmd,
            $this->builder->buildPath,
            $this->buildLocation . '/' . $this->summary,
            $this->buildLocation . '/' . $this->chart,
            $this->buildLocation . '/' . $this->pyramid,
            $ignore,
            $this->directory
        );

        if (!$allowPublicArtifacts) {
            $fileSystem->remove($this->buildLocation);
        }
        if ($allowPublicArtifacts && file_exists($this->buildLocation)) {
            $fileSystem->remove($this->buildBranchLocation);
            $fileSystem->mirror($this->buildLocation, $this->buildBranchLocation);
        }

        $config = $this->builder->getSystemConfig('php-censor');

        if ($allowPublicArtifacts && $success) {
            $this->builder->logSuccess(
                sprintf(
                    "\nPdepend successful build report.\nYou can use report for this build for inclusion in the readme.md file:\n%s,\n![Chart](%s \"Pdepend Chart\") and\n![Pyramid](%s \"Pdepend Pyramid\")\n\nOr report for last build in the branch:\n%s,\n![Chart](%s \"Pdepend Chart\") and\n![Pyramid](%s \"Pdepend Pyramid\")\n",
                    $config['url'] . '/artifacts/pdepend/' . $this->buildDirectory . '/' . $this->summary,
                    $config['url'] . '/artifacts/pdepend/' . $this->buildDirectory . '/' . $this->chart,
                    $config['url'] . '/artifacts/pdepend/' . $this->buildDirectory . '/' . $this->pyramid,
                    $config['url'] . '/artifacts/pdepend/' . $this->buildBranchDirectory . '/' . $this->summary,
                    $config['url'] . '/artifacts/pdepend/' . $this->buildBranchDirectory . '/' . $this->chart,
                    $config['url'] . '/artifacts/pdepend/' . $this->buildBranchDirectory . '/' . $this->pyramid
                )
            );
        }

        return $success;
    }
}
