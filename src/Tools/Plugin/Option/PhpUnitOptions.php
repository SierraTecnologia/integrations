<?php

namespace Integrations\Tools\Plugin\Option;

use Integrations\Tools\Builder;
use Integrations\Tools\Config;

/**
 * Class PhpUnitOptions validates and parse the option for the PhpUnitV2 plugin
 *
 * @author Pablo Tejada <pablo@ptejada.com>
 */
class PhpUnitOptions
{
    /**
     * @var array
     */
    protected $options;

    /**
     * @var string
     */
    protected $location;

    /**
     * @var array
     */
    protected $arguments = [];

    /**
     * @param array  $options
     * @param string $location
     */
    public function __construct($options, $location)
    {
        $this->options  = $options;
        $this->location = $location;
    }

    /**
     * Remove a command argument
     *
     * @param $argumentName
     *
     * @return $this
     */
    public function removeArgument($argumentName)
    {
        unset($this->arguments[$argumentName]);
        return $this;
    }

    /**
     * Combine all the argument into a string for the phpunit command
     *
     * @return string
     */
    public function buildArgumentString()
    {
        $argumentString = '';
        foreach ($this->getCommandArguments() as $argumentName => $argumentValues) {
            $prefix = $argumentName[0] == '-' ? '' : '--';

            if (!is_array($argumentValues)) {
                $argumentValues = [$argumentValues];
            }

            foreach ($argumentValues as $argValue) {
                $postfix = ' ';
                if (!empty($argValue)) {
                    $postfix = ' "' . $argValue . '" ';
                }
                $argumentString .= $prefix . $argumentName . $postfix;
            }
        }

        return $argumentString;
    }

    /**
     * Get all the command arguments
     *
     * @return string[]
     */
    public function getCommandArguments()
    {
        /*
         * Return the full list of arguments
         */
        return $this->parseArguments()->arguments;
    }

    /**
     * Parse the arguments from the config options
     *
     * @return $this
     */
    private function parseArguments()
    {
        if (empty($this->arguments)) {
            /*
             * Parse the arguments from the YML options file
             */
            if (isset($this->options['args'])) {
                $rawArgs = $this->options['args'];
                if (is_array($rawArgs)) {
                    $this->arguments = $rawArgs;
                } else {
                    /*
                     * Try to parse old arguments in a single string
                     */
                    preg_match_all('@--([a-z\-]+)([\s=]+)?[\'"]?((?!--)[-\w/.,\\\]+)?[\'"]?@', (string)$rawArgs, $argsMatch);

                    if (!empty($argsMatch) && sizeof($argsMatch) > 2) {
                        foreach ($argsMatch[1] as $index => $argName) {
                            $this->addArgument($argName, $argsMatch[3][$index]);
                        }
                    }
                }
            }

            /*
             * Handles command aliases outside of the args option
             */
            if (isset($this->options['coverage']) && $this->options['coverage']) {
                $allowPublicArtifacts = (bool)Config::getInstance()->get(
                    'php-censor.build.allow_public_artifacts',
                    true
                );

                if ($allowPublicArtifacts) {
                    $this->addArgument('coverage-html', $this->location);
                }
                $this->addArgument('coverage-text');
            }

            /*
             * Handles command aliases outside of the args option
             */
            if (isset($this->options['config'])) {
                $this->addArgument('configuration', $this->options['config']);
            }
        }

        return $this;
    }

    /**
     * Add an argument to the collection
     * Note: adding argument before parsing the options will prevent the other options from been parsed.
     *
     * @param string $argumentName
     * @param string $argumentValue
     *
     * @return void
     */
    public function addArgument($argumentName, $argumentValue = null): void
    {
        if (isset($this->arguments[$argumentName])) {
            if (!is_array($this->arguments[$argumentName])) {
                // Convert existing argument values into an array
                $this->arguments[$argumentName] = [$this->arguments[$argumentName]];
            }

            // Appends the new argument to the list
            $this->arguments[$argumentName][] = $argumentValue;
        } else {
            // Adds new argument
            $this->arguments[$argumentName] = $argumentValue;
        }
    }

    /**
     * Get the list of directory to run phpunit in
     *
     * @param Builder $builder
     *
     * @return string[] List of directories
     */
    public function getDirectories(Builder $builder)
    {
        /**
 * @deprecated Option "directory" is deprecated and will be deleted in version 2.0. Use the option "directories" instead. 
*/
        if (!empty($this->options['directory']) && empty($this->options['directories'])) {
            $builder->logWarning(
                '[DEPRECATED] Option "path" is deprecated and will be deleted in version 2.0. Use the option "directory" instead.'
            );

            $this->options['directories'] = $this->options['directory'];
        }

        $directories = $this->getOption('directories');

        if (is_string($directories)) {
            $directories = [$directories];
        } else {
            if (is_null($directories)) {
                $directories = [];
            }
        }

        return is_array($directories) ? $directories : [$directories];
    }

    /**
     * Get an option if defined
     *
     * @param $optionName
     * @param string $optionName
     *
     * @return string[]|string|null
     */
    public function getOption(string $optionName)
    {
        if (isset($this->options[$optionName])) {
            return $this->options[$optionName];
        }

        return null;
    }

    /**
     * Get the directory to execute the command from
     *
     * @return mixed|null
     */
    public function getRunFrom()
    {
        return $this->getOption('run_from');
    }

    /**
     * Ge the directory name where tests file reside
     *
     * @return null|string|string[]
     *
     * @psalm-return array<string>|null|string
     */
    public function getTestsPath()
    {
        return $this->getOption('path');
    }

    /**
     * Get the PHPUnit configuration from the options, or the optional path
     *
     * @param string $altPath
     *
     * @return string[] path of files
     */
    public function getConfigFiles($altPath = null)
    {
        $configFiles = $this->getArgument('configuration');
        if (empty($configFiles) && $altPath) {
            $configFile = self::findConfigFile($altPath);
            if ($configFile) {
                $configFiles[] = $configFile;
            }
        }

        return $configFiles;
    }

    /**
     * Get options for a given argument
     *
     * @param $argumentName
     * @param string $argumentName
     *
     * @return array
     */
    public function getArgument(string $argumentName): array
    {
        $this->parseArguments();

        if (isset($this->arguments[$argumentName])) {
            return is_array(
                $this->arguments[$argumentName]
            ) ? $this->arguments[$argumentName] : [$this->arguments[$argumentName]];
        }

        return [];
    }

    /**
     * Find a PHPUnit configuration file in a directory
     *
     * @param string $buildPath The path to configuration file
     *
     * @return null|string
     */
    public static function findConfigFile($buildPath)
    {
        $files = [
            'phpunit.xml',
            'phpunit.mysql.xml',
            'phpunit.pgsql.xml',
            'phpunit.xml.dist',
            'tests/phpunit.xml',
            'tests/phpunit.xml.dist',
        ];

        foreach ($files as $file) {
            if (file_exists($buildPath . $file)) {
                return $file;
            }
        }

        return null;
    }
}
