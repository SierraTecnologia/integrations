<?php
/*
 * c-wikigame
 * github.com/01mu
 */
class wikigame
{
    private $agent;
    private $context;
    private $conn;
    public function wikigame()
    {
        $this->agent = 'github.com/01mu/c-wikigame';
        $ctx = array("http" => array("header" => $this->agent));
        $this->context = stream_context_create($ctx);
    }
    public function get_popular()
    {
        $http = 'Wikipedia:Multiyear_ranking_of_most_viewed_pages';
        $sql = 'INSERT INTO popular (article) VALUES (?)';
        $article_str = $this->get_quotes_string($http);
        $end = strlen($article_str);
        $start = strpos($article_str, '==Countries==');
        $article_str = substr($article_str, $start, $end);
        $links = $this->get_links($article_str);
        foreach($links as $thing)
        {
            if(strpos($thing, ':') == 0) {
                print("'" . $thing . "' inserted.\n");
                $link = $this->clean_popular_link($thing);
                $stmt = $this->conn->prepare($sql);
                $stmt->execute(array($link));
            }
        }
    }
    public function create_table()
    {
        $query = 'SHOW TABLES LIKE "popular"';
        $result = $this->conn->query($query)->fetchAll();
        $exists = count($result);
        if(!$exists) {
            printf("Table 'popular' created.\n");
            $sql = "CREATE TABLE popular (
                id INT(8) AUTO_INCREMENT PRIMARY KEY,
                article VARCHAR(255) NOT NULL
                )";
            $this->conn->exec($sql);
        }
    }
    public function conn($server, $user, $pw, $db)
    {
        try
        {
            $conn = new PDO("mysql:host=$server;dbname=$db", $user, $pw);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e)
        {
            echo "Error: " . $e->getMessage();
        }
        $this->conn = $conn;
    }
    public function check($limit, $article, $goal)
    {
        if(!isset($limit) || !isset($article) || !isset($goal)) {
            show_error('bad');
        }
        if($limit <= 0 || $limit > 50) {
            show_error('bad');
        }
        $article = $this->get_quotes_string($article);
        if($this->check_redirect($article)) {
            $article = $this->get_redirect_link($article);
            $article = $this->get_quotes_string($article);
        }
        if($article === 'err_page_missing') {
            $this->show_error('err_page_missing');
        }
        $links = $this->get_links($article);
        $final = $this->get_final_links($links, $limit);
        if(count($final) == 0) {
            $this->show_error('err_page_missing');
        }
        if(!in_array($goal, $links)) {
            echo json_encode($final, JSON_UNESCAPED_UNICODE);
        }
        else
        {
            echo json_encode(['found_article']);
        }
    }
    public function get_start($limit, $type, $specific)
    {
        $articles = array();
        $a_links = array();
        if(!isset($type) || !isset($limit)) {
            $this->show_error('bad');
            return;
        }
        if($limit <= 0 || $limit > 50) {
            $this->show_error('bad');
            return;
        }
        switch($type)
        {
        case 'rand_pop':
            $article_goal = $this->get_random_popular();
            $article_goal = str_replace(" ", "_", $article_goal);
            break;
        case 'rand':
            $article_goal = $this->get_redirect();
            $article_goal = str_replace("_", " ", $article_goal);
            break;
        case 'specific':
            $article_goal = $specific;
            $rep = str_replace(" ", "_", $specific);
            $article_goal_link = 'https://en.wikipedia.org/wiki/' . $rep;
            break;
        default:
            $this->show_error('bad');
            return;
        }
        $start = $this->get_redirect();
        $article_start = str_replace("_", " ", $start);
        $link_start = 'https://en.wikipedia.org/wiki/' . $start;
        $link_goal = 'https://en.wikipedia.org/wiki/' . $article_goal;
        $article_str = $this->get_quotes_string($start);
        $links = $this->get_links($article_str);
        $final = $this->get_final_links($links, $limit);
        $articles[] = $article_start;
        $articles[] = $article_goal;
        $a_links[] = $link_start;
        $a_links[] = $link_goal;
        $json[] = $articles;
        $json[] = $a_links;
        if(!in_array($start, $links)) {
            $json[] = $final;
        }
        else
        {
            $json[] = ['found_article'];
        }
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
    }
    private function get_links($article_str)
    {
        $links = array();
        $link_start_idx;
        $link_end_idx;
        $link_size;
        $link_set = false;
        $size = strlen($article_str) - 1;
        $index = 0;
        while($index != $size)
        {
            $fidx = $article_str[$index];
            $sidx = $article_str[$index + 1];
            if($fidx == '[' && $sidx == '[') {
                $link_start_idx = $index + 2;
                $link_set = true;
            }
            if($fidx == ']' && $sidx == ']' && $link_set == true) {
                $link_end_idx = $index;
                $link_size = $link_end_idx - $link_start_idx;
                $found_link = substr($article_str, $link_start_idx, $link_size);
                if(!$this->bad_link_check($found_link) 
                    && !in_array($found_link, $links)
                ) {
                    $links[] = $found_link;
                }
                $link_set = false;
            }
            $index++;
        }
        return $links;
    }
    private function bad_link_check($found_link)
    {
        $bad = [':', 'http', '\\', '<', '#'];
        $is_bad = false;
        foreach($bad as $check)
        {
            if(strpos($found_link, $check) !== false) {
                $is_bad = true;
                break;
            }
        }
        return $is_bad;
    }
    private function fix_link($link)
    {
        if(strpos($link, "|") !== false) {
            $line = strpos($link, "|");
            $link = substr($link, 0, $line);
        }
        return $link;
    }
    private function fix_h($link)
    {
        if(strpos($link, "#") !== false) {
            $line = strpos($link, "#");
            $link = substr($link, 0, $line);
        }
        return $link;
    }
    private function get_quotes_string($redirect)
    {
        $quotes;
        $redirect = str_replace(" ", "_", $redirect);
        $redirect = $this->fix_h($redirect);
        $url = 'https://en.wikipedia.org/w/api.php?action=query' .
            '&titles=' . $redirect . '&prop=revisions&rvprop=content' .
            '&format=json&formatversion=2';
        $data = file_get_contents($url, false, $this->context);
        $wiki = json_decode($data, true);
        if(isset($wiki['query']['pages'][0]['missing'])) {
            $quotes = 'err_page_missing';
        }
        else
        {
            $quotes = $wiki['query']['pages'][0]['revisions'][0]['content'];
        }
        return $quotes;
    }
    private function get_redirect_url($url)
    {
        $r = array('http' => array('method' => 'HEAD'));
        stream_context_set_default($r);
        $headers = get_headers($url, 1);
        if($headers !== false && isset($headers['Location'])) {
            return $headers['Location'];
        }
        return false;
    }
    private function get_redirect()
    {
        $wiki_rand = 'https://en.wikipedia.org/wiki/Special:Random';
        $replace = 'https://en.wikipedia.org/wiki/';
        $url = $this->get_redirect_url($wiki_rand);
        return str_replace($replace, '', $url);
    }
    private function check_redirect($article)
    {
        $redirect = false;
        if(strpos($article, "#REDIRECT") !== false) {
            $redirect = true;
        }
        return $redirect;
    }
    public function get_redirect_link($article)
    {
        $ret;
        if(count($this->get_links($article)) == 0) {
            $ret = 'no_links';
        }
        else
        {
            $ret = $this->get_links($article)[0];
        }
        return $ret;
    }
    private function get_final_links($links, $limit)
    {
        $final = array();
        $rands = array();
        $link_count = count($links);
        if($link_count > $limit) {
            for($i = 0; $i < $limit; $i++)
            {
                $rand_val = rand(0, $link_count - 1);
                if(!in_array($rand_val, $rands)) {
                    $rands[] = $rand_val;
                }
            }
        }
        else
        {
            for($i = 0; $i < count($links); $i++)
            {
                $rands[] = $i;
            }
        }
        for($i = 0; $i < count($rands); $i++)
        {
            $r = $rands[$i];
            $link = $links[$r];
            $link = $this->fix_link($link);
            $link = trim($link);
            $final[] = $link;
        }
        return $final;
    }
    private function clean_popular_link($link)
    {
        if($link[0] == ':') {
            $link = str_replace(':', '', $link);
        }
        $link = $this->fix_link($link);
        $link = trim($link);
        return $link;
    }
    private function get_random_popular()
    {
        $sql = 'SELECT article FROM popular ORDER BY RAND() LIMIT 1, 1';
        $stmt = $this->conn->query($sql);
        while($row = $stmt->fetch())
        {
            $article = $row['article'];
        }
        return $article;
    }
    private function show_error($notice)
    {
        echo json_encode([$notice]);
    }
}