<?php

namespace Integrations\Connectors\Tumblr;

use Log;
use App\Models\User;

use Integrations\Connectors\Connector;

class Tumblr extends Connector
{

    public static $ID = 20;

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
        $instagram = new \MetzWeb\Tumblr\Tumblr(
            array(
            'apiKey'      => 'YOUR_APP_KEY',
            'apiSecret'   => 'YOUR_APP_SECRET',
            'apiCallback' => 'YOUR_APP_CALLBACK'
            )
        );

          $token = 'USER_ACCESS_TOKEN';
          $instagram->setAccessToken($token);
          return $instagram;
    }

    public function getUsername()
    {
        return env('instagramusername');
    }

    public function getPassword()
    {
        return env('instagrampassword');
    }

    public function login()
    {
        $ig = new \TumblrAPI\Tumblr($this->debug, $this->truncatedDebug);
        try {
            $ig->login($this->getUsername(), $this->getPassword());
        } catch (\Exception $e) {
            echo 'Something went wrong: '.$e->getMessage()."\n";
            exit(0);
        }
        return $ig;
    }

    public function getNewDataForComponent($component)
    {

    }

}
