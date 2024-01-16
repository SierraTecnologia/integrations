<?php

namespace Integrations\Tools\Plugin;

use Integrations\Tools\Builder;
use Fabrica\Models\Infra\Ci\Build;
use Integrations\Tools\Plugin;

/**
 * Clean build removes Composer related files and allows users to clean up their build directory.
 * Useful as a precursor to copy_build.
 *
 * @author Ricardo Sierra <ricardo@sierratecnologia.com>
 */
class CleanBuild extends Plugin
{
    protected $remove;

    /**
     * @return string
     */
    public static function pluginName()
    {
        return 'clean_build';
    }

    /**
     * {@inheritdoc}
     */
    public function __construct(Builder $builder, Build $build, array $options = [])
    {
        parent::__construct($builder, $build, $options);

        $this->remove = isset($options['remove']) && is_array($options['remove']) ? $options['remove'] : [];
    }

    /**
     * Executes Composer and runs a specified command (e.g. install / update)
     */
    public function execute()
    {
        $cmd = 'rm -Rf "%s"';

        $this->builder->executeCommand($cmd, $this->builder->buildPath . 'composer.phar');
        $this->builder->executeCommand($cmd, $this->builder->buildPath . 'composer.lock');

        $success = true;

        foreach ($this->remove as $file) {
            $ok = $this->builder->executeCommand($cmd, $this->builder->buildPath . $file);

            if (!$ok) {
                $success = false;
            }
        }

        return $success;
    }
}
