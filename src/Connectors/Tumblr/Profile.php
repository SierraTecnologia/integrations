<?php

namespace Integrations\Connectors\Tumblr;

use Log;
use App\Models\User;

class Profile extends Tumblr
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
