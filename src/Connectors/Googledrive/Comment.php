<?php

namespace Integrations\Connectors\Connector\Googledrive;

use Log;
use App\Models\User;

class Comment extends Googledrive
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
