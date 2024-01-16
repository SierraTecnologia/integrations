<?php

namespace Integrations\Tools\Plugin;

use Integrations\Tools\Builder;
use Fabrica\Models\Infra\Ci\Build;
use Integrations\Tools\Plugin;

/**
 * PHP Spec Plugin - Allows PHP Spec testing.
 *
 * @author Ricardo Sierra <ricardo@sierratecnologia.com>
 */
class PhpSpec extends Plugin
{
    /**
     * @return string
     */
    public static function pluginName()
    {
        return 'php_spec';
    }

    public function __construct(Builder $builder, Build $build, array $options = [])
    {
        parent::__construct($builder, $build, $options);

        $this->executable = $this->findBinary(['phpspec', 'phpspec.php']);
    }

    /**
     * Runs PHP Spec tests.
     */
    public function execute()
    {
        $phpspec = $this->executable;

        $success = $this->builder->executeCommand($phpspec . ' --format=junit --no-code-generation run');
        $output  = $this->builder->getLastOutput();

        /*
         * process xml output
         *
         * <testsuites time=FLOAT tests=INT failures=INT errors=INT>
         *   <testsuite name=STRING time=FLOAT tests=INT failures=INT errors=INT skipped=INT>
         *     <testcase name=STRING time=FLOAT classname=STRING status=STRING/>
         *   </testsuite>
         * </testsuites
         */

        $xml  = new \SimpleXMLElement($output);
        $attr = $xml->attributes();
        $data = [
            'time'     => (float) $attr['time'],
            'tests'    => (int) $attr['tests'],
            'failures' => (int) $attr['failures'],
            'errors'   => (int) $attr['errors'],
            // now all the tests
            'suites'   => [],
        ];

        /**
         * @var \SimpleXMLElement $group
         */
        foreach ($xml->xpath('testsuite') as $group) {
            $attr  = $group->attributes();
            $suite = [
                'name'     => (String) $attr['name'],
                'time'     => (float) $attr['time'],
                'tests'    => (int) $attr['tests'],
                'failures' => (int) $attr['failures'],
                'errors'   => (int) $attr['errors'],
                'skipped'  => (int) $attr['skipped'],
                // now the cases
                'cases'    => [],
            ];

            /**
             * @var \SimpleXMLElement $child
             */
            foreach ($group->xpath('testcase') as $child) {
                $attr = $child->attributes();
                $case = [
                    'name'      => (String) $attr['name'],
                    'classname' => (String) $attr['classname'],
                    'time'      => (float) $attr['time'],
                    'status'    => (String) $attr['status'],
                ];

                if ('failed' == $case['status']) {
                    $error = [];
                    /*
                     * ok, sad, we had an error
                     *
                     * there should be one - foreach makes this easier
                     */
                    foreach ($child->xpath('failure') as $failure) {
                        $attr             = $failure->attributes();
                        $error['type']    = (String) $attr['type'];
                        $error['message'] = (String) $attr['message'];
                    }

                    foreach ($child->xpath('system-err') as $systemError) {
                        $error['raw'] = (String) $systemError;
                    }

                    $case['error'] = $error;
                }

                $suite['cases'][] = $case;
            }

            $data['suites'][] = $suite;
        }

        $this->build->storeMeta((self::pluginName() . '-data'), $data);

        return $success;
    }
}
