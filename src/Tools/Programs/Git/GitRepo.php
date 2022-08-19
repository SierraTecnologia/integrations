<?php

namespace Integrations\Tools\Programs\Git;

use DateTime;
use Pedreiro\Exceptions\Exception;
use Pedreiro\Exceptions\RuntimeException;

/**
 * Git Repository Interface Class
 *
 * This class enables the creating, reading, and manipulation
 * of a git repository
 *
 * @class GitRepo
 */
class GitRepo
{

    protected $bare = false;
    protected $envopts = array();

    /**
     * @var string
     */
    private $repositoryPath = null;

    /**
     * Create a new git repository
     *
     * Accepts a creation path, and, optionally, a source path
     *
     * @access public
     *
     * @param string  repository path
     * @param string  directory to source
     * @param string  reference path
     * @param false $remote_source
     *
     * @return GitRepo
     */
    public static function &create_new($repositoryPath, $source = null, bool $remote_source = false, $reference = null)
    {
        if (is_dir($repositoryPath) && file_exists($repositoryPath."/.git")) {
            throw new Exception('"'.$repositoryPath.'" is already a git repository');
        } else {
            $repo = new self($repositoryPath, true, false);
            if (is_string($source)) {
                if ($remote_source) {
                    if (isset($reference)) {
                        if (!is_dir($reference) || !is_dir($reference.'/.git')) {
                               throw new Exception('"'.$reference.'" is not a git repository. Cannot use as reference.');
                        } else if (strlen($reference)) {
                            $reference = realpath($reference);
                            $reference = "--reference $reference";
                        }
                    }
                    $repo->clone_remote($source, $reference);
                } else {
                    $repo->clone_from($source);
                }
            } else {
                $repo->run('init');
            }
            return $repo;
        }
    }

    /**
     * Constructor
     *
     * Accepts a repository path
     *
     * @access public
     * @param  string  repository path
     * @param  bool    create if not exists?
     * @return void
     */
    public function __construct($repositoryPath = null, $create_new = false, $_init = true)
    {
        if (is_string($repositoryPath)) {
            $this->set_repositoryPath($repositoryPath, $create_new, $_init);
        }
    }

    /**
     * Set the repository's path
     *
     * Accepts the repository path
     *
     * @access public
     * @param  string  repository path
     * @param  bool    create if not exists?
     * @param  bool    initialize new Git repo if not exists?
     * @return void
     */
    public function set_repositoryPath(string $repositoryPath, $create_new = false, $_init = true)
    {
        if (is_string($repositoryPath)) {
            if ($new_path = realpath($repositoryPath)) {
                $repositoryPath = $new_path;
                if (is_dir($repositoryPath)) {
                    // Is this a work tree?
                    if (file_exists($repositoryPath."/.git")) {
                        $this->repositoryPath = $repositoryPath;
                        $this->bare = false;
                          // Is this a bare repo?
                    } else if (is_file($repositoryPath."/config")) {
                        $parse_ini = parse_ini_file($repositoryPath."/config");
                        if ($parse_ini['bare']) {
                               $this->repositoryPath = $repositoryPath;
                               $this->bare = true;
                        }
                    } else {
                        if ($create_new) {
                            $this->repositoryPath = $repositoryPath;
                            if ($_init) {
                                $this->run('init');
                            }
                        } else {
                            throw new Exception('"'.$repositoryPath.'" is not a git repository');
                        }
                    }
                } else {
                    throw new Exception('"'.$repositoryPath.'" is not a directory');
                }
            } else {
                if ($create_new) {
                    if ($parent = realpath(dirname($repositoryPath))) {
                        mkdir($repositoryPath);
                        $this->repositoryPath = $repositoryPath;
                        if ($_init) { $this->run('init');
                        }
                    } else {
                        throw new Exception('cannot create repository in non-existent directory');
                    }
                } else {
                    throw new Exception('"'.$repositoryPath.'" does not exist');
                }
            }
        }
    }
    
    /**
     * Get the path to the git repo directory (eg. the ".git" directory)
     * 
     * @access public
     * @return string
     */
    public function gitDirectoryPath()
    {
        return $this->git_directory_path();
    }
    
    /**
     * Get the path to the git repo directory (eg. the ".git" directory)
     * 
     * @access public
     * @return string
     */
    public function git_directory_path()
    {

        if ($this->bare) {
            return $this->repositoryPath;
        } else if (is_dir($this->repositoryPath."/.git")) {
            return $this->repositoryPath."/.git";
        } else if (is_file($this->repositoryPath."/.git")) {
            $git_file = file_get_contents($this->repositoryPath."/.git");
            if(mb_ereg("^gitdir: (.+)$", $git_file, $matches)) {
                if($matches[1]) {
                    $rel_git_path = $matches[1];
                    return $this->repositoryPath."/".$rel_git_path;
                }
            }
        }
        throw new Exception('could not find git dir for '.$this->repositoryPath.'.');
    }

    /**
     * Tests if git is installed
     *
     * @access public
     * @return bool
     */
    public function test_git()
    {
        $descriptorspec = array(
        1 => array('pipe', 'w'),
        2 => array('pipe', 'w'),
        );
        $pipes = array();
        $resource = proc_open(Git::get_bin(), $descriptorspec, $pipes);

        $stdout = stream_get_contents($pipes[1]);
        $stderr = stream_get_contents($pipes[2]);
        foreach ($pipes as $pipe) {
            fclose($pipe);
        }

        $status = trim(proc_close($resource));
        return ($status != 127);
    }

    /**
     * Run a command in the git repository
     *
     * Accepts a shell command to run
     *
     * @access protected
     * @param  string  command to run
     * @return string
     */
    protected function run_command(string $command)
    {
        $descriptorspec = array(
        1 => array('pipe', 'w'),
        2 => array('pipe', 'w'),
        );
        $pipes = array();
        /* Depending on the value of variables_order, $_ENV may be empty.
        * In that case, we have to explicitly set the new variables with
        * putenv, and call proc_open with env=null to inherit the reset
        * of the system.
        *
        * This is kind of crappy because we cannot easily restore just those
        * variables afterwards.
        *
        * If $_ENV is not empty, then we can just copy it and be done with it.
        */
        if(count($_ENV) === 0) {
            $env = null;
            foreach($this->envopts as $k => $v) {
                putenv(sprintf("%s=%s", $k, $v));
            }
        } else {
            $env = array_merge($_ENV, $this->envopts);
        }
        $cwd = $this->repositoryPath;
        $resource = proc_open($command, $descriptorspec, $pipes, $cwd, $env);

        $stdout = stream_get_contents($pipes[1]);
        $stderr = stream_get_contents($pipes[2]);
        foreach ($pipes as $pipe) {
            fclose($pipe);
        }

        $status = trim(proc_close($resource));
        if ($status) { throw new Exception($stderr . "\n" . $stdout); //Not all errors are printed to stderr, so include std out as well.
        }

        return $stdout;
    }

    /**
     * Run a git command in the git repository
     *
     * Accepts a git command to run
     *
     * @access public
     * @param  string  command to run
     * @return string
     */
    public function run(string $command)
    {
        return $this->run_command(Git::get_bin()." ".$command);
    }

    /**
     * Runs a 'git status' call
     *
     * Accept a convert to HTML bool
     *
     * @access public
     * @param  bool  return string with <br />
     * @return string
     */
    public function status($html = false)
    {
        $msg = $this->run("status");
        if ($html == true) {
            $msg = str_replace("\n", "<br />", $msg);
        }
        return $msg;
    }

    /**
     * Runs a `git add` call
     *
     * Accepts a list of files to add
     *
     * @access public
     * @param  mixed   files to add
     * @return string
     */
    public function add($files = "*")
    {
        if (is_array($files)) {
            $files = '"'.implode('" "', $files).'"';
        }
        return $this->run("add $files -v");
    }

    /**
     * Runs a `git rm` call
     *
     * Accepts a list of files to remove
     *
     * @access public
     * @param  mixed    files to remove
     * @param  Boolean  use the --cached flag?
     * @return string
     */
    public function rm($files = "*", $cached = false)
    {
        if (is_array($files)) {
            $files = '"'.implode('" "', $files).'"';
        }
        return $this->run("rm ".($cached ? '--cached ' : '').$files);
    }


    /**
     * Runs a `git commit` call
     *
     * Accepts a commit message string
     *
     * @access public
     * @param  string  commit message
     * @param  boolean  should all files be committed automatically (-a flag)
     * @return string
     */
    public function commit($message = "", $commit_all = true)
    {
        $flags = $commit_all ? '-av' : '-v';
        return $this->run("commit ".$flags." -m ".escapeshellarg($message));
    }

    /**
     * Runs a `git clone` call to clone the current repository
     * into a different directory
     *
     * Accepts a target directory
     *
     * @access public
     * @param  string  target directory
     * @return string
     */
    public function clone_to($target)
    {
        return $this->run("clone --local ".$this->repositoryPath." $target");
    }

    /**
     * Runs a `git clone` call to clone a different repository
     * into the current repository
     *
     * Accepts a source directory
     *
     * @access public
     * @param  string  source directory
     * @return string
     */
    public function clone_from(string $source)
    {
        return $this->run("clone --local $source ".$this->repositoryPath);
    }

    /**
     * Runs a `git clone` call to clone a remote repository
     * into the current repository
     *
     * Accepts a source url
     *
     * @access public
     * @param  string  source url
     * @param  string  reference path
     * @return string
     */
    public function clone_remote(string $source, $reference)
    {
        return $this->run("clone $reference $source ".$this->repositoryPath);
    }

    /**
     * Runs a `git clean` call
     *
     * Accepts a remove directories flag
     *
     * @access public
     * @param  bool    delete directories?
     * @param  bool    force clean?
     * @return string
     */
    public function clean($dirs = false, $force = false)
    {
        return $this->run("clean".(($force) ? " -f" : "").(($dirs) ? " -d" : ""));
    }

    /**
     * Runs a `git branch` call
     *
     * Accepts a name for the branch
     *
     * @access public
     * @param  string  branch name
     * @return string
     */
    public function create_branch($branch)
    {
        return $this->run("branch " . escapeshellarg($branch));
    }

    /**
     * Runs a `git branch -[d|D]` call
     *
     * Accepts a name for the branch
     *
     * @access public
     * @param  string  branch name
     * @return string
     */
    public function delete_branch($branch, $force = false)
    {
        return $this->run("branch ".(($force) ? '-D' : '-d')." $branch");
    }

    
    /**
     * Runs a `git branch` call
     *
     * @access public
     * @param  bool    keep asterisk mark on active branch
     * @return array
     */
    public function listBranches($keep_asterisk = false)
    {
        return $this->list_branches($keep_asterisk);
    }
    /**
     * Runs a `git branch` call
     *
     * @access public
     * @param  bool    keep asterisk mark on active branch
     * @return array
     */
    public function list_branches(bool $keep_asterisk = false)
    {
        $branchArray = explode("\n", $this->run("branch"));
        foreach($branchArray as $i => &$branch) {
            $branch = trim($branch);
            if (! $keep_asterisk) {
                $branch = str_replace("* ", "", $branch);
            }
            if ($branch == "") {
                unset($branchArray[$i]);
            }
        }
        return $branchArray;
    }

    /**
     * Lists remote branches (using `git branch -r`).
     *
     * Also strips out the HEAD reference (e.g. "origin/HEAD -> origin/master").
     *
     * @access public
     * @return array
     */
    public function list_remote_branches()
    {
        $branchArray = explode("\n", $this->run("branch -r"));
        foreach($branchArray as $i => &$branch) {
            $branch = trim($branch);
            if ($branch == "" || strpos($branch, 'HEAD -> ') !== false) {
                unset($branchArray[$i]);
            }
        }
        return $branchArray;
    }

    /**
     * Returns name of active branch
     *
     * @access public
     * @param  bool    keep asterisk mark on branch name
     * @return string
     */
    public function active_branch($keep_asterisk = false)
    {
        $branchArray = $this->list_branches(true);
        $active_branch = preg_grep("/^\*/", $branchArray);
        reset($active_branch);
        if ($keep_asterisk) {
            return current($active_branch);
        } else {
            return str_replace("* ", "", current($active_branch));
        }
    }

    /**
     * Runs a `git checkout` call
     *
     * Accepts a name for the branch
     *
     * @access public
     * @param  string  branch name
     * @return string
     */
    public function checkout($branch)
    {
        return $this->run("checkout " . escapeshellarg($branch));
    }


    /**
     * Runs a `git merge` call
     *
     * Accepts a name for the branch to be merged
     *
     * @access public
     * @param  string $branch
     * @return string
     */
    public function merge($branch)
    {
        return $this->run("merge " . escapeshellarg($branch) . " --no-ff");
    }


    /**
     * Runs a git fetch on the current branch
     *
     * @access public
     * @return string
     */
    public function fetch()
    {
        return $this->run("fetch");
    }

    /**
     * Add a new tag on the current position
     *
     * Accepts the name for the tag and the message
     *
     * @param  string $tag
     * @param  string $message
     * @return string
     */
    public function add_tag($tag, $message = null)
    {
        if (is_null($message)) {
            $message = $tag;
        }
        return $this->run("tag -a $tag -m " . escapeshellarg($message));
    }

    /**
     * List all the available repository tags.
     *
     * Optionally, accept a shell wildcard pattern and return only tags matching it.
     *
     * @access public
     * @param  string $pattern Shell wildcard pattern to match tags against.
     * @return array                Available repository tags.
     */
    public function list_tags($pattern = null)
    {
        $tagArray = explode("\n", $this->run("tag -l $pattern"));
        foreach ($tagArray as $i => &$tag) {
            $tag = trim($tag);
            if (empty($tag)) {
                unset($tagArray[$i]);
            }
        }

        return $tagArray;
    }

    /**
     * Push specific branch (or all branches) to a remote
     *
     * Accepts the name of the remote and local branch.
     * If omitted, the command will be "git push", and therefore will take 
     * on the behavior of your "push.defualt" configuration setting.
     *
     * @param  string $remote
     * @param  string $branch
     * @return string
     */
    public function push($remote = "", $branch = "")
    {
                //--tags removed since this was preventing branches from being pushed (only tags were)
        return $this->run("push $remote $branch");
    }

    /**
     * Pull specific branch from remote
     *
     * Accepts the name of the remote and local branch.
     * If omitted, the command will be "git pull", and therefore will take on the
     * behavior as-configured in your clone / environment.
     *
     * @param  string $remote
     * @param  string $branch
     * @return string
     */
    public function pull($remote = "", $branch = "")
    {
        return $this->run("pull $remote $branch");
    }

    /**
     * List log entries.
     *
     * @param  strgin $format
     * @return string
     */
    public function log($format = null, $fulldiff=false, $filepath=null, $follow=false)
    {
        $diff = "";
        
        if ($fulldiff) {
            $diff = "--full-diff -p ";
        }

        if ($follow) {
            // Can't use full-diff with follow
            $diff = "--follow -- ";
        }
    
        if ($format === null) {
            return $this->run('log ' . $diff . $filepath);
        } else {
            return $this->run('log --pretty=format:"' . $format . '" ' . $diff .$filepath);
        }
    }

    /**
     * Sets the project description.
     *
     * @param string $new
     *
     * @return void
     */
    public function set_description($new): void
    {
        $path = $this->git_directory_path();
        file_put_contents($path."/description", $new);
    }

    /**
     * Gets the project description.
     *
     * @return string
     */
    public function get_description()
    {
        $path = $this->git_directory_path();
        return file_get_contents($path."/description");
    }

    /**
     * Sets custom environment options for calling Git
     *
     * @param string key
     * @param string value
     *
     * @return void
     */
    public function setenv($key, $value): void
    {
        $this->envopts[$key] = $value;
    }

    /**
     * @param string $revision
     *
     * @return void
     */
    public function checkoutForce($revision): void
    {
        $this->execute(
            'checkout --force --quiet ' . $revision
        );
    }

    /**
     * @return string
     */
    public function getCurrentBranch()
    {
        $output = $this->execute('symbolic-ref --short HEAD');

        return $output[0];
    }

    /**
     * @param  string $from
     * @param  string $to
     * @return string
     */
    public function getDiff($from, $to)
    {
        $output = $this->execute(
            'diff --no-ext-diff ' . $from . ' ' . $to
        );

        return implode("\n", $output);
    }

    /**
     * @return array
     */
    public function getRevisions()
    {
        $output = $this->execute(
            'log --no-merges --date-order --reverse --format=medium'
        );

        $numLines  = count($output);
        $revisions = array();

        for ($i = 0; $i < $numLines; $i++) {
            $tmp = explode(' ', $output[$i]);

            if ($tmp[0] == 'commit') {
                $sha1 = $tmp[1];
            } elseif ($tmp[0] == 'Author:') {
                $author = implode(' ', array_slice($tmp, 1));
            } elseif ($tmp[0] == 'Date:' && isset($author) && isset($sha1)) {
                $revisions[] = array(
                  'author'  => $author,
                'date'    => DateTime::createFromFormat(
                    'D M j H:i:s Y O',
                    implode(' ', array_slice($tmp, 3))
                ),
                  'sha1'    => $sha1,
                  'message' => isset($output[$i+2]) ? trim($output[$i+2]) : ''
                );

                unset($author);
                unset($sha1);
            }
        }

        return $revisions;
    }

    /**
     * @return bool
     */
    public function isWorkingCopyClean()
    {
        $output = $this->execute('status');

        return $output[count($output)-1] == 'nothing to commit, working directory clean' ||
               $output[count($output)-1] == 'nothing to commit, working tree clean';
    }

    /**
     * @param string $command
     *
     * @return array
     *
     * @throws RuntimeException
     */
    protected function execute($command): array
    {
        $command = 'cd ' . escapeshellarg($this->repositoryPath) . '; git ' . $command . ' 2>&1';
 
        if (DIRECTORY_SEPARATOR == '/') {
            $command = 'LC_ALL=en_US.UTF-8 ' . $command;
        }

        exec($command, $output, $returnValue);

        if ($returnValue !== 0) {
            throw new RuntimeException(implode("\r\n", $output). ' -> '.$this->repositoryPath);
        }

        return $output;
    }
}