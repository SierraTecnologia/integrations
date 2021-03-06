<?php

namespace Integrations\Connectors\Wikipedia;

use Log;
use App\Models\User;

use Integrations\Connectors\Connector;

class Wikipedia extends Connector
{

    public static $ID = 22;

    public $debug = true;
    public $truncatedDebug = false;
    
    public function __construct()
    {
        
    }

    protected function getConnection($token = false)
    {
        return $this->login();
    }

    public function getToken()
    {
        // $wikipedia = new \MetzWeb\Wikipedia\Wikipedia(array(
        //     'apiKey'      => 'YOUR_APP_KEY',
        //     'apiSecret'   => 'YOUR_APP_SECRET',
        //     'apiCallback' => 'YOUR_APP_CALLBACK'
        //   ));

        //   $token = 'USER_ACCESS_TOKEN';
        //   $wikipedia->setAccessToken($token);
        //   return $wikipedia;
    }

    public function handle()
    {

        /* ⣠⣾⣿⣿⣷⣄ Simple PHP Wiki Info Box ⣠⣾⣿⣿⣷⣄ */
        /* https://github.com/gaffling/PHP-Wiki-API */
        // Get the Parameter from the URL
        if (isset($_GET['language']) ) {
            $language = $_GET['language']; 
        } else {
            $language = 'de';
        }
        if (isset($_GET['userAgent']) ) {
            $userAgent = $_GET['userAgent'];
        } else {
            $userAgent = 'WikiBot/1.0 (+http://'.$_SERVER['SERVER_NAME'].'/)';
        }
        if (isset($_GET['betterResults'])  
            and ($_GET['betterResults'] == 'false' or $_GET['betterResults'] == 0) 
        ) {
            $betterResults = false;
        } else {
            $betterResults = true;
        }
        if (isset($_GET['proxy']) ) {
            $proxy = $_GET['proxy'];
        } else {
            $proxy = null;
        }
        if (isset($_GET['imageProxy'])  
            and ($_GET['imageProxy'] == 'false' or $_GET['imageProxy']== 0) 
        ) {
            $imageProxy = false;
        } else {
            $imageProxy = true;
        }
        if (isset($_GET['DEBUG']) ) {
            $DEBUG = $_GET['DEBUG'];
        } else {
            $DEBUG = null;
        }
        // Set the Parameter
        $options = array(
            'language'      => $language,
            'userAgent'     => $userAgent,
            'betterResults' => $betterResults,
            'proxy'         => $proxy,
            'imageProxy'    => $imageProxy,
            'DEBUG'         => $DEBUG,
        );
        // Include the Wikipedia API Class
        include_once __DIR__.'/wiki2api.php';
        // Start the Wikipedia API Class
        $wiki = new wiki($options);
        // Output the API Response
        echo $wiki->api($_GET['q']);
        // Print the Script Runtime in DEBUG Mode
        if (isset($DEBUG) ) { 
            echo "<pre>\n\n\tRuntime: ".number_format((microtime(true)-$_SERVER['REQUEST_TIME_FLOAT']), 3);
        }
    }

    public function getNewDataForComponent($component)
    {

    }

}
