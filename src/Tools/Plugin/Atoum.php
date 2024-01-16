<?php

namespace Integrations\Tools\Plugin;

use Integrations\Tools\Builder;
use Fabrica\Models\Infra\Ci\Build;
use Integrations\Tools\Plugin;

/**
 * Atoum plugin, runs Atoum tests within a project.
 */
class Atoum extends Plugin
{
    /**
     * @var string
     */
    protected $args;

    /**
     * @var string
     */
    protected $config;

    /**
     * @return string
     */
    public static function pluginName()
    {
        return 'atoum';
    }

    /**
     * {@inheritdoc}
     */
    public function __construct(Builder $builder, Build $build, array $options = [])
    {
        parent::__construct($builder, $build, $options);

        $this->executable = $this->findBinary('atoum');

        if (isset($options['args'])) {
            $this->args = $options['args'];
        }

        if (isset($options['config'])) {
            $this->config = $options['config'];
        }
    }

    /**
     * Run the Atoum plugin.
     *
     * @return bool
     */
    public function execute()
    {
        $cmd = $this->executable;

        if (null !== $this->args) {
            $cmd .= " {$this->args}";
        }

        if (null !== $this->config) {
            $cmd .= " -c '{$this->config}'";
        }

        $cmd .= " --directories '{$this->directory}'";

        $status = true;

        $this->builder->executeCommand($cmd);

        $output = $this->builder->getLastOutput();

        if (count(preg_grep("/Success \(/", $output)) == 0) {
            $status = false;
            $this->builder->log($output);
        }

        if (count($output) == 0) {
            $status = false;
            $this->builder->log('No tests have been performed.');
        }

        return $status;
    }
}
