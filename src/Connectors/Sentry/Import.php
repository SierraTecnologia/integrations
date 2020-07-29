<?php

namespace Integrations\Connectors\Sentry;

use Log;


class Import extends Sentry
{
    public function handle()
    {
        var_dump($this->getProjects());
        return true;
    }

}
