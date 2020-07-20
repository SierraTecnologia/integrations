<?php

namespace Integrations\Connectors\Connector\Dropbox;

use Log;
use App\Models\User;

class Relation extends Dropbox
{
    
    public function __construct()
    {
        
    }

    public function follow($component)
    {
        $dropbox = $this->getConnection()->likeMedia();

        // set user's accesstoken (can be received after authentication)
        $dropbox->setAccessToken("2823787.9687902.21u77429n3r79o08233122306fa78902");

        // follow user (snoopdogg)
        $dropbox->modifyRelationship('follow', $component->getReference());

        // receive the list of users this user follows
        $follows = $dropbox->getUserFollows();

        // dump response object
        echo '<pre>';
        print_r($follows);
        echo '<pre>';

        
      
        $result = $this->getConnection()->likeMedia($component->getReference());
    }

    public function getAllFollows($component)
    {
        $dropbox = $this->getConnection()->likeMedia();

        // set user's accesstoken (can be received after authentication)
        $dropbox->setAccessToken("2823787.9687902.21u77429n3r79o08233122306fa78902");

        // receive the list of users this user follows
        $follows = $dropbox->getUserFollows();

        // dump response object
        echo '<pre>';
        print_r($follows);
        echo '<pre>';
    }

}
