<?php

namespace Integrations\Tools\Plugin;

use Integrations\Tools\Builder;
use Fabrica\Models\Infra\Ci\Build;
use Integrations\Tools\Plugin;

/**
 * Phing Plugin - Provides access to Phing functionality.
 *
 * @author Pavel Pavlov <ppavlov@alera.ru>
 */
class Phing extends Plugin
{
    protected $buildFile  = 'build.xml';
    protected $targets    = ['build'];
    protected $properties = [];
    protected $propertyFile;

    /**
     * @return string
     */
    public static function pluginName()
    {
        return 'phing';
    }

    /**
     * {@inheritdoc}
     */
    public function __construct(Builder $builder, Build $build, array $options = [])
    {
        parent::__construct($builder, $build, $options);

        /*
         * Sen name of a non default build file
         */
        if (isset($options['build_file'])) {
            $this->setBuildFile($options['build_file']);
        }

        if (isset($options['targets'])) {
            $this->setTargets($options['targets']);
        }

        if (isset($options['properties'])) {
            $this->setProperties($options['properties']);
        }

        if (isset($options['property_file'])) {
            $this->setPropertyFile($options['property_file']);
        }

        $this->executable = $this->findBinary('phing');
    }

    /**
     * Executes Phing and runs a specified targets
     */
    public function execute()
    {
        $phingExecutable = $this->executable;

        $cmd[] = $phingExecutable . ' -f ' . $this->getBuildFilePath();

        if ($this->getPropertyFile()) {
            $cmd[] = '-propertyfile ' . $this->getPropertyFile();
        }

        $cmd[] = $this->propertiesToString();

        $cmd[] = '-logger phing.listener.DefaultLogger';
        $cmd[] = $this->targetsToString();
        $cmd[] = '2>&1';

        return $this->builder->executeCommand(implode(' ', $cmd), $this->directory, $this->targets);
    }

    /**
     * @return array
     */
    public function getTargets()
    {
        return $this->targets;
    }

    /**
     * Converts an array of targets into a string.
     *
     * @return string
     */
    private function targetsToString()
    {
        return implode(' ', $this->targets);
    }

    /**
     * @param array|string $targets
     *
     * @return void
     */
    public function setTargets($targets): void
    {
        if (is_string($targets)) {
            $targets = [$targets];
        }

        $this->targets = $targets;
    }

    /**
     * @return string
     */
    public function getBuildFile()
    {
        return $this->buildFile;
    }

    /**
     * @param mixed $buildFile
     *
     * @return void
     *
     * @throws \Exception
     */
    public function setBuildFile($buildFile): void
    {
        if (!file_exists($this->directory . $buildFile)) {
            throw new \Exception('Specified build file does not exist.');
        }

        $this->buildFile = $buildFile;
    }

    /**
     * Get phing build file path.
     *
     * @return string
     */
    public function getBuildFilePath()
    {
        return $this->directory . $this->buildFile;
    }

    /**
     * @return mixed
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @return string
     */
    public function propertiesToString()
    {
        /**
         * fix the problem when execute phing out of the build dir
         *
         * @ticket 748
         */
        if (!isset($this->properties['project.basedir'])) {
            $this->properties['project.basedir'] = $this->getDirectory();
        }

        $propertiesString = [];

        foreach ($this->properties as $name => $value) {
            $propertiesString[] = '-D' . $name . '="' . $value . '"';
        }

        return implode(' ', $propertiesString);
    }

    /**
     * @param array|string $properties
     *
     * @return void
     */
    public function setProperties($properties): void
    {
        if (is_string($properties)) {
            $properties = [$properties];
        }

        $this->properties = $properties;
    }

    /**
     * @return string
     */
    public function getPropertyFile()
    {
        return $this->propertyFile;
    }

    /**
     * @param string $propertyFile
     *
     * @return void
     *
     * @throws \Exception
     */
    public function setPropertyFile($propertyFile): void
    {
        if (!file_exists($this->getDirectory() . '/' . $propertyFile)) {
            throw new \Exception('Specified property file does not exist.');
        }

        $this->propertyFile = $propertyFile;
    }
}
