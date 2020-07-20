<?php

namespace Integrations\Connectors\Googledrive;

use Log;
use App\Models\User;

class Relation extends Googledrive
{
    
    public function __construct()
    {
        
    }

    public function follow($component)
    {
        $instagram = $this->getConnection()->likeMedia();

        // set user's accesstoken (can be received after authentication)
        $instagram->setAccessToken("2823787.9687902.21u77429n3r79o08233122306fa78902");

        // follow user (snoopdogg)
        $instagram->modifyRelationship('follow', $component->getReference());

        // receive the list of users this user follows
        $follows = $instagram->getUserFollows();

        // dump response object
        echo '<pre>';
        print_r($follows);
        echo '<pre>';

        
      
        $result = $this->getConnection()->likeMedia($component->getReference());
    }

    public function getAllFollows($component)
    {
        $instagram = $this->getConnection()->likeMedia();

        // set user's accesstoken (can be received after authentication)
        $instagram->setAccessToken("2823787.9687902.21u77429n3r79o08233122306fa78902");

        // receive the list of users this user follows
        $follows = $instagram->getUserFollows();

        // dump response object
        echo '<pre>';
        print_r($follows);
        echo '<pre>';
    }

}
