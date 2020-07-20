<?php

namespace Integrations\Connectors\Sentry;

use Illuminate\Database\Eloquent\Model;
use Log;
use App\Models\User;
use Integrations\Connectors\Connector;

class Sentry extends Connector
{
    public static $ID = 16;
    public $url = 'sentry.io';

    protected function getConnection($token = false)
    {
        return $this;
    }

    public function getProjects()
    {
        //HTTP/1.1
        //Authorization: Bearer <token>
        return $this->get($this->url.'/api/0/projects/');
        /**
 * Resposta
         * [
         *  {
         *      "avatar": {
         *      "avatarType": "letter_avatar", 
         *      "avatarUuid": null
         *      }, 
         *      "color": "#bf6e3f", 
         *      "dateCreated": "2018-11-06T21:20:08.064Z", 
         *      "features": [
         *      "servicehooks", 
         *      "sample-events", 
         *      "data-forwarding", 
         *      "rate-limits", 
         *      "minidump"
         *      ], 
         *      "firstEvent": null, 
         *      "hasAccess": true, 
         *      "id": "4", 
         *      "isBookmarked": false, 
         *      "isInternal": false, 
         *      "isMember": true, 
         *      "isPublic": false, 
         *      "name": "The Spoiled Yoghurt", 
         *      "organization": {
         *      "avatar": {
         *          "avatarType": "letter_avatar", 
         *          "avatarUuid": null
         *      }, 
         *      "dateCreated": "2018-11-06T21:19:55.101Z", 
         *      "id": "2", 
         *      "isEarlyAdopter": false, 
         *      "name": "The Interstellar Jurisdiction", 
         *      "require2FA": false, 
         *      "slug": "the-interstellar-jurisdiction", 
         *      "status": {
         *          "id": "active", 
         *          "name": "active"
         *      }
         *      }, 
         *      "platform": null, 
         *      "slug": "the-spoiled-yoghurt", 
         *      "status": "active"
         *  }, 
         *  {
         *      "avatar": {
         *      "avatarType": "letter_avatar", 
         *      "avatarUuid": null
         *      }, 
         *      "color": "#bf5b3f", 
         *      "dateCreated": "2018-11-06T21:19:58.536Z", 
         *      "features": [
         *      "releases", 
         *      "sample-events", 
         *      "minidump", 
         *      "servicehooks", 
         *      "rate-limits", 
         *      "data-forwarding"
         *      ], 
         *      "firstEvent": null, 
         *      "hasAccess": true, 
         *      "id": "3", 
         *      "isBookmarked": false, 
         *      "isInternal": false, 
         *      "isMember": true, 
         *      "isPublic": false, 
         *      "name": "Prime Mover", 
         *      "organization": {
         *      "avatar": {
         *          "avatarType": "letter_avatar", 
         *          "avatarUuid": null
         *      }, 
         *      "dateCreated": "2018-11-06T21:19:55.101Z", 
         *      "id": "2", 
         *      "isEarlyAdopter": false, 
         *      "name": "The Interstellar Jurisdiction", 
         *      "require2FA": false, 
         *      "slug": "the-interstellar-jurisdiction", 
         *      "status": {
         *          "id": "active", 
         *          "name": "active"
         *      }
         *      }, 
         *      "platform": null, 
         *      "slug": "prime-mover", 
         *      "status": "active"
         *  }, 
         */
    }
}
