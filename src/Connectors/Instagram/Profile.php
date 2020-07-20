<?php

namespace Integrations\Connectors\Instagram;

use Log;
use App\Models\User;
use Exception;
use Support\Utils\Debugger\ErrorHelper;

class Profile extends Instagram
{
    
    public function __construct()
    {
        
    }

    public static function getProfile($username)
    {
        try {
            $options  = array('http' => array('user_agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 12_3_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 Instagram 105.0.0.11.118 (iPhone11,8; iOS 12_3_1; en_US; en-US; scale=2.00; 828x1792; 165586599)'));
            $context  = stream_context_create($options);

            $html = file_get_contents('https://instagram.com/'.$username, false, $context);
            //Get user ID
            $subData = substr($html, strpos($html, 'window._sharedData'), strpos($html, '};'));
            $userID = strstr($subData, '"id":"');
            $userID = str_replace('"id":"', '', $userID);
            $userID = strstr($userID, '"', true);

            //Download user info
            $jsonData = file_get_contents('https://i.instagram.com/api/v1/users/'.$userID.'/info/', false, $context);
            $decodedInfo = json_decode($jsonData);

            $data = [];

            if (isset($decodedInfo->user->hd_profile_pic_url_info->url)) {
                $data['profilePic'] = $decodedInfo->user->hd_profile_pic_url_info->url;
            } else {
                $data['profilePic'] = $decodedInfo->user->profile_pic_url;
            }

            if (isset($decodedInfo->user->username)) {
                $data['username'] = $decodedInfo->user->username;
            } 

            if (isset($decodedInfo->user->follower_count)) {
                $data['follower'] = $decodedInfo->user->follower_count;
            } 

            if (isset($decodedInfo->user->following_count)) {
                $data['following'] = $decodedInfo->user->following_count;
            } 

            if (isset($decodedInfo->user->full_name)) {
                $data['full_name'] = $decodedInfo->user->full_name;
            } 

            if (isset($decodedInfo->user->is_private)) {
                $data['isPrivate'] = $decodedInfo->user->is_private;
            } 

            if (isset($decodedInfo->user->is_verified)) {
                $data['isVerified'] = $decodedInfo->user->is_verified;
            } 

            if (isset($decodedInfo->user->biography)) {
                $data['bio'] = $decodedInfo->user->biography;
            }
            
            return $data;
            
        } catch (\Exception $e) {
            ErrorHelper::registerAndReturnMessage($e);
        }
        return false;

    }

}
