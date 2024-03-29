<?php

namespace Integrations;

use App;
use Config;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Integrations\Facades\Integrations as IntegrationsFacade;
use Integrations\Services\IntegrationsService;

use Log;

use Muleta\Traits\Providers\ConsoleTools;
use Route;

class IntegrationsProvider extends ServiceProvider
{
    use ConsoleTools;

    public $packageName = 'integrations';
    const pathVendor = 'sierratecnologia/integrations';

    public static $aliasProviders = [
        'Integrations' => \Integrations\Facades\Integrations::class,
    ];

    public static $providers = [

        // \Support\SupportProviderService::class,

        
    ];

    /**
     * Rotas do Menu
     */
    public static $menuItens = [
        // 'Config|425' => [
            [
                'text' => 'Integrações',
                'icon' => 'fas fa-fw fa-search',
                'icon_color' => "blue",
                'label_color' => "success",
                'section'     => 'admin',
                'feature' => 'integrations',
                'order' => 2200,
                'level'       => 2, // 0 (Public), 1, 2 (Admin) , 3 (Root)
            ],
            'Integrações' => [
                [
                    'text'        => 'Tokens',
                    'route'       => 'admin.integrations.tokens.index',
                    'icon'        => 'fas fa-fw fa-search',
                    'icon_color'  => 'blue',
                    'label_color' => 'success',
                    'section'     => 'admin',
                    'feature' => 'integrations',
                    'order' => 2250,
                    'level'       => 2, // 0 (Public), 1, 2 (Admin) , 3 (Root)
                    // 'access' => \Porteiro\Models\Role::$ADMIN
                ],
            ],
        // ],
    ];

    /**
     * Alias the services in the boot.
     */
    public function boot()
    {
        
        // Register configs, migrations, etc
        $this->registerDirectories();

        // COloquei no register pq nao tava reconhecendo as rotas para o adminlte
        $this->app->booted(
            function () {
                $this->routes();
            }
        );

        $this->loadLogger();
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        /**
         * Transmissor; Routes
         */
        $this->loadRoutesForRiCa(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'routes');
        // Route::group(
        //     [
        //         'namespace' => '\Integrations\Http\Controllers',
        //         'prefix' => \Illuminate\Support\Facades\Config::get('application.routes.main', ''),
        //         'as' => 'rica.',
        //         // 'middleware' => 'rica',
        //     ], function ($router) {
        //         include __DIR__.'/../routes/web.php';
        //     }
        // );
    }


    /**
     * Register the services.
     */
    public function register()
    {
        // Register Configs
        $this->mergeConfigFrom(
            $this->getPublishesPath('config'.DIRECTORY_SEPARATOR.'integrations.php'),
            'integrations'
        );
        $this->mergeConfigFrom(
            $this->getPublishesPath('config'.DIRECTORY_SEPARATOR.'services.php'),
            'services'
        );
        

        $this->setProviders();
        // $this->routes();



        // Register Migrations
        $this->loadMigrationsFrom(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'database'.DIRECTORY_SEPARATOR.'migrations');

        $this->app->singleton(
            'integrations', function () {
                return new Integrations();
            }
        );
        
        /*
        |--------------------------------------------------------------------------
        | Register the Utilities
        |--------------------------------------------------------------------------
        */
        /**
         * Singleton Integrations;
         */
        $this->app->singleton(
            IntegrationsService::class, function ($app) {
                Log::channel('sitec-integrations')->info('Singleton Integrations;');
                return new IntegrationsService(\Illuminate\Support\Facades\Config::get('sitec.integrations'));
            }
        );

        // Register commands
        $this->registerCommandFolders(
            [
            base_path('vendor/sierratecnologia/integrations/src/Console/Commands') => '\Integrations\Console\Commands',
            ]
        );

        // /**
        //  * Helpers
        //  */
        // Aqui noa funciona
        // if (!function_exists('integrations_asset')) {
        //     function integrations_asset($path, $secure = null)
        //     {
        //         return route('rica.integrations.assets').'?path='.urlencode($path);
        //     }
        // }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'integrations',
        ];
    }

    /**
     * Register configs, migrations, etc
     *
     * @return void
     */
    public function registerDirectories()
    {
        // Publish config files
        $this->publishes(
            [
                $this->getPublishesPath('config'.DIRECTORY_SEPARATOR.'integrations.php') => config_path('integrations.php'),
                $this->getPublishesPath('config'.DIRECTORY_SEPARATOR.'services.php') => config_path('services.php'),
            ], ['config',  'sitec', 'sitec-config', 'integrations', 'integrations-config']
        );

        // // Publish integrations css and js to public directory
        // $this->publishes([
        //     $this->getDistPath('integrations') => public_path('assets/integrations')
        // ], ['public',  'sitec', 'sitec-public']);

        $this->loadViews();
        $this->loadTranslations();
    }

    private function loadViews()
    {
        // View namespace
        $viewsPath = $this->getResourcesPath('views');
        $this->loadViewsFrom($viewsPath, 'integrations');
        $this->publishes(
            [
            $viewsPath => base_path('resources'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'integrations'),
            ], ['views',  'sitec', 'sitec-views']
        );
    }
    
    private function loadTranslations()
    {
        // Publish lanaguage files
        $this->publishes(
            [
            $this->getResourcesPath('lang') => resource_path('lang'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'integrations')
            ], ['lang',  'sitec', 'sitec-lang', 'translations']
        );

        // Load translations
        $this->loadTranslationsFrom($this->getResourcesPath('lang'), 'integrations');
    }


    /**
     *
     */
    private function loadLogger()
    {
        Config::set(
            'logging.channels.sitec-integrations', [
            'driver' => 'single',
            'path' => storage_path('logs'.DIRECTORY_SEPARATOR.'sitec-integrations.log'),
            'level' => env('APP_LOG_LEVEL', 'debug'),
            ]
        );
    }
}
