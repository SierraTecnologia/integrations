<?php

namespace Integrations\Tools\Plugin;

use Integrations\Tools\Plugin;

/**
 * Environment variable plugin
 *
 * @author Steve Kamerman <stevekamerman@gmail.com>
 */
class Env extends Plugin
{
    /**
     * @return string
     */
    public static function pluginName()
    {
        return 'env';
    }

    /**
     * Adds the specified environment variables to the builder environment
     */
    public function execute()
    {
        $success = true;
        foreach ($this->options as $key => $value) {
            if (is_numeric($key)) {
                // This allows the developer to specify env vars like " - FOO=bar" or " - FOO: bar"
                $envVar = is_array($value)? key($value).'='.current($value): $value;
            } else {
                // This allows the standard syntax: "FOO: bar"
                $envVar = "$key=$value";
            }

            if (!putenv($this->builder->interpolate($envVar))) {
                $success = false;
                $this->builder->logFailure('Unable to set environment variable');
            }
        }
        return $success;
    }
}
