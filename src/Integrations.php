<?php

namespace Integrations;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use View;
use Config;
use Request;
use Session;
use ReflectionClass;

use Crypto;

class Integrations
{
    protected $version;
    protected $filesystem;

    /**
     * The current locale, cached in memory
     *
     * @var string
     */
    private $locale;

    public function __construct()
    {
        $this->filesystem = app(Filesystem::class);

        $this->findVersion();
    }

    public function getVersion()
    {
        return $this->version;
    }

    protected function findVersion()
    {
        if (!is_null($this->version)) {
            return;
        }

        if ($this->filesystem->exists(base_path('composer.lock'))) {
            // Get the composer.lock file
            $file = json_decode(
                $this->filesystem->get(base_path('composer.lock'))
            );

            // Loop through all the packages and get the version of integrations
            foreach ($file->packages as $package) {
                if ($package->name == 'sierratecnologia/integrations') {
                    $this->version = $package->version;
                    break;
                }
            }
        }
    }
}
