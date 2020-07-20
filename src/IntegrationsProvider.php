<?php

namespace Integrations;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Integrations\Services\IntegrationsService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;

use Log;
use App;
use Config;
use Route;
use Illuminate\Routing\Router;

use Support\Traits\Providers\ConsoleTools;

use Integrations\Facades\Integrations as IntegrationsFacade;
use Illuminate\Contracts\Events\Dispatcher;


class IntegrationsProvider extends ServiceProvider
{
    use ConsoleTools;

    public static $aliasProviders = [
        'Integrations' => \Integrations\Facades\Integrations::class,
    ];

    public static $providers = [

        \Support\SupportProviderService::class,

        
    ];

    /**
     * Rotas do Menu
     */
    public static $menuItens = [

    ];

    /**
     * Alias the services in the boot.
     */
    public function boot()
    {
        
        // Register configs, migrations, etc
        $this->registerDirectories();

        // COloquei no register pq nao tava reconhecendo as rotas para o adminlte
        $this->app->booted(function () {
            $this->routes();
        });

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
         * Integrations; Routes
         */
        Route::group(
            [
                'namespace' => '\Integrations\Http\Controllers',
                'prefix' => \Illuminate\Support\Facades\Config::get('application.routes.main', ''),
                'as' => 'rica.',
                // 'middleware' => 'rica',
            ], function ($router) {
                include __DIR__.'/../routes/web.php';
            }
        );
    }

    /**
     * Register the services.
     */
    public function register()
    {
        $this->mergeConfigFrom($this->getPublishesPath('config/sitec/integrations.php'), 'sitec.integrations');
        

        $this->setProviders();
        // $this->routes();



        // Register Migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

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
            // Paths
            $this->getPublishesPath('config/sitec') => config_path('sitec'),
            ], ['config',  'sitec', 'sitec-config']
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
            $viewsPath => base_path('resources/views/vendor/integrations'),
            ], ['views',  'sitec', 'sitec-views']
        );

    }
    
    private function loadTranslations()
    {
        // Publish lanaguage files
        $this->publishes(
            [
            $this->getResourcesPath('lang') => resource_path('lang/vendor/integrations')
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
            'path' => storage_path('logs/sitec-integrations.log'),
            'level' => env('APP_LOG_LEVEL', 'debug'),
            ]
        );
    }

}
