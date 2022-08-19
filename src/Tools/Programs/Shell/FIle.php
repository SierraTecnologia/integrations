<?php

namespace Fabrica\Task\External\Shell;

/**
 * Ln Criar Link Simbolico
 */

class File
{
    protected $path = false;

    protected $directory = false;
    
    public function isDirectory()
    {
        return $this->directory;
    }
    
    public function link($target): string
    {
        return 'ln -s '.$this->path.' '.$target;
    }
    
    public function move($target): string
    {
        return 'mv '.$this->path.' '.$target;
    }
    
    public function copy($target): string
    {
        $options = '';

        if ($this->isDirectory()) {
            $options = ' -r';
        }

        return 'cp '.$this->path.' '.$target.$options;
    }
}