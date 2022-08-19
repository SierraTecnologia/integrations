<?php

namespace Integrations\Tools\Plugin;

use PDO;
use Integrations\Tools\Builder;
use Fabrica\Models\Infra\Ci\Build;
use Integrations\Tools\Plugin;

/**
 * PgSQL Plugin - Provides access to a PgSQL database.
 *
 * @author Ricardo Sierra <ricardo@sierratecnologia.com>
 */
class Pgsql extends Plugin
{
    /**
     * @var string
     */
    protected $host;

    /**
     * @var string
     */
    protected $user;

    /**
     * @var string
     */
    protected $pass;

    /**
     * @return string
     */
    public static function pluginName()
    {
        return 'pgsql';
    }

    /**
     * {@inheritdoc}
     */
    public function __construct(Builder $builder, Build $build, array $options = [])
    {
        parent::__construct($builder, $build, $options);

        $buildSettings = $this->builder->getConfig('build_settings');

        if (isset($buildSettings['pgsql'])) {
            $sql = $buildSettings['pgsql'];
            $this->host = $sql['host'];
            $this->user = $sql['user'];
            $this->pass = $sql['pass'];
        }
    }

    /**
     * Connects to PgSQL and runs a specified set of queries.
     *
     * @return bool
     */
    public function execute()
    {
        try {
            $opts = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
            $pdo  = new PDO('pgsql:host=' . $this->host, $this->user, $this->pass, $opts);

            foreach ($this->options as $query) {
                $pdo->query($this->builder->interpolate($query));
            }
        } catch (\Exception $ex) {
            $this->builder->logFailure($ex->getMessage());
            return false;
        }
        return true;
    }
}
