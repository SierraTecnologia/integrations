<?php

namespace Integrations\Connectors\Connector\Instagram;

use Log;
use App\Models\User;

class Comment extends Instagram
{
    
    public function __construct()
    {
        
    }

    public function getPosts()
    {

    }

    public function getLikes()
    {

    }

    public function getRelations()
    {
        $this->getFollows();
    }

    protected function getFollows()
    {

    }

    protected function getComments()
    {

    }

}
