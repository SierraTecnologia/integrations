<?php

namespace Integrations\Connectors\Tumblr;

use Log;
use App\Models\User;

class Post extends Tumblr
{
    
    public function __construct()
    {
        
    }

    public function send($component, $text = 'Hello word')
    {
        try {
            // The most basic upload command, if you're sure that your photo file is
            // valid on Tumblr (that it fits all requirements), is the following:
            // $ig->timeline->uploadPhoto($photoFilename, ['caption' => $text]);
            // However, if you want to guarantee that the file is valid (correct format,
            // width, height and aspect ratio), then you can run it through our
            // automatic photo processing class. It is pretty fast, and only does any
            // work when the input file is invalid, so you may want to always use it.
            // You have nothing to worry about, since the class uses temporary files if
            // the input needs processing, and it never overwrites your original file.
            //
            // Also note that it has lots of options, so read its class documentation!
            $photo = new \TumblrAPI\Media\Photo\TumblrPhoto($component->getTarget());
            $this->getConnection()->timeline->uploadPhoto($photo->getFile(), ['caption' => $text]);
        } catch (\Exception $e) {
            echo 'Something went wrong: '.$e->getMessage()."\n";
        }
    }

    public function getAll()
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
