<?php

namespace Integrations\Connectors\Connector\Tumblr;

use Log;
use App\Models\User;

class Like extends Tumblr
{
    
    public function __construct()
    {
        
    }

    public function likeOtherComponent($component)
    {
        $result = $this->getConnection()->likeMedia($component->getReference());
        if ($result->meta->code === 200) {
            echo 'Success! The image was added to your likes.';
        } else {
            echo 'Something went wrong :(';
        }
    }


}
