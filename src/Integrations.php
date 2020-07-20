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
use Muleta\Packagist\Traits\PackageVersionTrait;
use Crypto;

class Integrations
{
    use PackageVersionTrait;
    protected $filesystem;
    protected $packageName = TransmissorProvider::pathVendor;

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
}
