<?php

namespace Integrations\Tools\Docker;

use Integrations\Tools\Bash;

/**
 * Docker Class
 *
 * @class Mysql
 */
class Docker
{

    protected $local = false;

    public function __construct($bash = false)
    {
        $this->local = $bash;
        if (!$this->local) {
            $this->local = new Bash();
        }
    }

    /**
     * # This script is meant for quick & easy install via:
     * #   $ curl -fsSL https://get.docker.com -o get-docker.sh
     * #   $ sh get-docker.sh
     * #
     * # For test builds (ie. release candidates):
     * #   $ curl -fsSL https://test.docker.com -o test-docker.sh
     * #   $ sh test-docker.sh
     * #
     * # NOTE: Make sure to verify the contents of the script
     * #       you downloaded matches the contents of install.sh
     * #       located at https://github.com/docker/docker-install
     * #       before executing.
     * #
     * # Git commit from https://github.com/docker/docker-install when
     * # the script was uploaded (Should only be modified by upload job):
     * SCRIPT_COMMIT_SHA=2f4ae48
     *
     * @return void
     */
    public function install(): void
    {
        $this->local->exec(
            'curl -fsSL https://get.docker.com -o get-docker.sh'.' && '.
            'sh get-docker.sh && rm sh get-docker.sh'
        );
    }

    public function installNow($bash = false)
    {
        return (new self($bash))->install();
    }
}
