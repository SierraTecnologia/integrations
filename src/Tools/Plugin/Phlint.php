<?php

namespace Integrations\Tools\Plugin;

use Integrations\Tools;
use Integrations\Tools\Builder;
use Fabrica\Models\Infra\Ci\Build;
use Fabrica\Models\Infra\Ci\BuildError;
use Integrations\Tools\Plugin;

/**
 * Phlint is a tool with an aim to help maintain quality of php code by analyzing code and pointing out potential code
 * issues. It focuses on how the code works rather than how the code looks. Phlint is designed from the start to do
 * deep semantic analysis rather than doing only shallow or stylistic analysis.
 * https://gitlab.com/phlint/phlint
 */
class Phlint extends Plugin
{
    /**
     * @var int 
     */
    protected $allowedErrors = 0;

    /**
     * @param Builder $builder
     * @param Build   $build
     * @param array   $options
     *
     * @throws \Exception
     */
    public function __construct(Builder $builder, Build $build, array $options = [])
    {
        parent::__construct($builder, $build, $options);

        $this->executable = $this->findBinary('phlint');

        if (\array_key_exists('allowed_errors', $options) && \is_int($options['allowed_errors'])) {
            $this->allowedErrors = $options['allowed_errors'];
        }
    }

    /**
     * @return bool
     */
    public function execute()
    {
        $this->builder->executeCommand(
            'cd "%s" && %s analyze --no-interaction --no-ansi',
            $this->builder->buildPath,
            $this->executable
        );

        // Define that the plugin succeed
        $success = true;

        $errors = $this->processReport($this->builder->getLastOutput());

        if (0 < \count($errors)) {
            if (-1 !== $this->allowedErrors && \count($errors) > $this->allowedErrors) {
                $success = false;
            }

            foreach ($errors as $error) {
                $this->build->reportError(
                    $this->builder,
                    self::pluginName(),
                    $error['message'],
                    BuildError::SEVERITY_HIGH,
                    $error['file'],
                    $error['line_from']
                );
            }
        }

        return $success;
    }

    /**
     * @return string
     */
    public static function pluginName()
    {
        return 'phlint';
    }

    /**
     * @param  string $output
     * @return array
     */
    protected function processReport($output)
    {
        $data = \explode(\chr(226), \preg_replace('#\\x1b[[][^A-Za-z\n]*[A-Za-z]#', '', \trim($output)));
        \array_pop($data);
        \array_shift($data);

        $errors = [];

        if (0 < \count($data)) {
            foreach ($data as $error) {
                $error   = \explode(PHP_EOL, $error);
                $header  = \substr(\trim(\array_shift($error)), 3);
                $file    = \strstr(\substr(\strstr($header, 'in '), 3), ':', true);
                $line    = \substr(\strrchr($header, ':'), 1);
                $message = \ltrim($error[0]) . PHP_EOL . \ltrim($error[1]);

                $errors[] = [
                    'message'   => $message,
                    'file'      => $file,
                    'line_from' => $line
                ];
            }
        }

        return $errors;
    }
}
