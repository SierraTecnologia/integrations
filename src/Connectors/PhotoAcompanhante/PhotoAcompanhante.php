<?php

namespace Integrations\Connectors\PhotoAcompanhante;

use App\Models\Model;
use Log;
use App\Models\User;
use Integrations\Connectors\Connector;

class PhotoAcompanhante extends Integration
{
    public static $ID = 12;
    protected static $URL = 'https://www.photoacompanhantes.com/';

    protected static $PATHS_P1 = [
        'acompanhantes'
    ];
    protected static $PATHS_P2 = [
        'proximas_-22.976838199999997,-43.5036226,25',
        'rio-de-janeiro/capital/jacarepagua',
        'acompanhantes/rio-de-janeiro/capital/zona-norte'
    ];
    protected static $PATH_P3 = [
        'acompanhante-dengosa-com-local-aceito-cartoes-confira-id-tffpx'
    ];

    protected static $VIEW_EX = [
        'acompanhantes/rio-de-janeiro/capital/zona-norte/uma-linda-acompanhante-pertinho-de-voce-venha-se-satisfazer-de-verdade-id-2j3y2',
       ' acompanhantes/rio-de-janeiro/capital/jacarepagua/acompanhante-dengosa-com-local-aceito-cartoes-confira-id-tffpx'
    ];


    public function getConnection($organizer = false)
    {
        return \PhotoAcompanhante\Client::create('http://git.yourdomain.com')
        ->authenticate('your_gitlab_token_here', \PhotoAcompanhante\Client::AUTH_URL_TOKEN);

        // or for OAuth2 (see https://github.com/m4tthumphrey/php-gitlab-api/blob/master/lib/PhotoAcompanhante/HttpClient/Plugin/Authentication.php#L47)
        return \PhotoAcompanhante\Client::create('http://gitlab.yourdomain.com')
        ->authenticate('your_gitlab_token_here', \PhotoAcompanhante\Client::AUTH_OAUTH_TOKEN);
    }
}
