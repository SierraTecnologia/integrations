<?php
/**
 * Acessar o Google Suite em Python
 * 
 * https://github.com/jay0lee/GAM/tree/master/src
 */

class Gam
{
    protected $repositoryUrl = 'https://git.io/install-gam';

    public function installCommand(): string
    {
        return 'bash <(curl -s -S -L '.$this->repositoryUrl.')';
    }
}