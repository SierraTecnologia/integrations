<?php

namespace Integrations\Connectors\Gitlab;

use Illuminate\Database\Eloquent\Model;
use Log;
use App\Models\User;
use Integrations\Connectors\Connector;

class Gitlab extends Integration
{
    public static $ID = 4;
    protected function getConnection($token = false)
    {
        $url = 'http://gitlab.com/';
        if (!empty($token->account->customize_url)) {
            $url = $token->account->customize_url;
        }

        // return \Gitlab\Client::create($url)
        // ->authenticate($token->token, \Gitlab\Client::AUTH_URL_TOKEN);

        // or for OAuth2 (see https://github.com/m4tthumphrey/php-gitlab-api/blob/master/lib/Gitlab/HttpClient/Plugin/Authentication.php#L47)
        return \Gitlab\Client::create($url)
        ->authenticate($token->token, \Gitlab\Client::AUTH_OAUTH_TOKEN);
    }
}
