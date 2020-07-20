<?php

namespace Integrations\Connectors\Tumblr;

use Log;
use App\Models\User;

class Relation extends Tumblr
{
    
    public function __construct()
    {
        
    }

    public function follow($component)
    {
        $tumblr = $this->getConnection()->likeMedia();

        // set user's accesstoken (can be received after authentication)
        $tumblr->setAccessToken("2823787.9687902.21u77429n3r79o08233122306fa78902");

        // follow user (snoopdogg)
        $tumblr->modifyRelationship('follow', $component->getReference());

        // receive the list of users this user follows
        $follows = $tumblr->getUserFollows();

        // dump response object
        echo '<pre>';
        print_r($follows);
        echo '<pre>';

        
      
        $result = $this->getConnection()->likeMedia($component->getReference());
    }

    public function getAllFollows($component)
    {
        $tumblr = $this->getConnection()->likeMedia();

        // set user's accesstoken (can be received after authentication)
        $tumblr->setAccessToken("2823787.9687902.21u77429n3r79o08233122306fa78902");

        // receive the list of users this user follows
        $follows = $tumblr->getUserFollows();

        // dump response object
        echo '<pre>';
        print_r($follows);
        echo '<pre>';
    }

}
