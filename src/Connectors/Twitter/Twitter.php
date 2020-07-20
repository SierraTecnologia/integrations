<?php

/**
 * https://github.com/laravel-notification-channels/twitter
 */

namespace Integrations\Connectors\Connector\Twitter;

use Log;
use App\Models\User;
use Abraham\TwitterOAuth\TwitterOAuth;

use Integrations\Connectors\Connector\Integration;

class Twitter extends Integration
{

    public static $ID = 21;

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
        $instagram = new \MetzWeb\Twitter\Twitter(
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

    public function config($component)
    {

        define('CONSUMER_KEY', 'insert_your_consumer_key_here');
        define('CONSUMER_SECRET', 'insert_your_consumer_secret_here');
        define('ACCESS_TOKEN', 'insert_your_access_token_here');
        define('ACCESS_TOKEN_SECRET', 'insert_your_access_token_secret_here');
        $twitter = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
        $twitter->host = "https://api.twitter.com/1.1/";
        $search = $twitter->get('search', array('q' => 'search key word', 'rpp' => 15));
        $twitter->host = "https://api.twitter.com/1.1/";
        foreach($search->results as $tweet) {
            $status = 'RT @'.$tweet->from_user.' '.$tweet->text;
            if(strlen($status) > 140) { $status = substr($status, 0, 139);
            }
            $twitter->post('statuses/update', array('status' => $status));
        }
        
    }

    public function callbackFunction()
    {
        if (isset($_REQUEST['oauth_verifier'], $_REQUEST['oauth_token']) && $_REQUEST['oauth_token'] == $_SESSION['oauth_token']) {
            $request_token = [];
            $request_token['oauth_token'] = $_SESSION['oauth_token'];
            $request_token['oauth_token_secret'] = $_SESSION['oauth_token_secret'];
            $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $request_token['oauth_token'], $request_token['oauth_token_secret']);
            $access_token = $connection->oauth("oauth/access_token", array("oauth_verifier" => $_REQUEST['oauth_verifier']));
            $_SESSION['access_token'] = $access_token;
            // redirect user back to index page
            header('Location: ./');
        }
    }

}
