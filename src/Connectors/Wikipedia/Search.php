<?php

namespace Integrations\Connectors\Connector\Wikipedia;

use Log;
use App\Models\User;

class Search extends Wikipedia
{
    
    public function __construct()
    {
        
    }
    
    /**
     * Perform wiki search through MediaWiki action API.
     *
     * @param string $what The search string
     *
     * @return json object containing result if successful or
     *         error message & code if failed.
     */
    function wikiSearch($what)
    {
        // Format: https://en.wikipedia.org/w/api.php?action=query&format=json&prop=extracts&generator=search&utf8=1&exsentences=1&exlimit=max&exintro=1&explaintext=1&gsrnamespace=0&gsrlimit=10&gsrsearch=SEARCH-TEXT
        $url = 'http://en.wikipedia.org/w/api.php';            
        $url .= '?action=query&format=json&prop=extracts&generator=search';
        $url .= '&utf8=1&exsentences=1&exlimit=max&exintro=1&explaintext=1';
        $url .= '&gsrnamespace=0&gsrlimit=10&gsrsearch=' . urlencode($what);
        
        $options = array(
            CURLOPT_RETURNTRANSFER => true,   // return web page
            CURLOPT_HEADER         => false,  // don't return headers
            CURLOPT_FOLLOWLOCATION => true,   // follow redirects
            CURLOPT_USERAGENT      => $_SERVER['HTTP_USER_AGENT'], // name of client
            CURLOPT_SSL_VERIFYPEER => false,
        ); 
        $ch = curl_init($url);
        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        if ($response === false) {
            throw new Exception('Curl error: ' . curl_error($ch));
        }
        curl_close($ch);
        return $response;
    }

}
