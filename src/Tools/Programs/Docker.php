<?php

namespace Fabrica\Task\External\Shell;

/**
 * Ln Criar Link Simbolico
 */

class Docker
{
    protected $path = false;

    protected $directory = false;
    
    public function isDirectory()
    {
        return $this->directory;
    }
    
    /**
     * Isto irá remover imagens não marcadas (com tag `<none>`), 
     * que são as folhas da árvore de imagens (não camadas intermediárias).
     *
     * @return string
     *
     * @psalm-return 'docker rmi $(docker images -q -f "dangling=true")'
     */
    public function forceRemoveImages($target): string
    {
        return 'docker rmi $(docker images -q -f "dangling=true")';
    }
    
    //Para remover todas as images acrescente a opção “-a” ou “–all”.
    public function move($target): string
    {
        return 'docker rmi $(docker images -q -a)';
    }
    
    //
    //  Para remover todas as images incluindo as que estão sendo utilizadas por containers acrescente a opção “-f” ou “–force” após o comando “rmi”.
    public function forceRemove($target): string
    {
        return 'docker rmi -f $(docker images -q -a)';
    }

    //Para remover apenas containers completos.
    public function completeRemove($target): string
    {
        return 'docker rm $(docker ps -q -f "status=exited")';
    }

    //Para remover todos os containers, incluindo os que estão rodando.
    public function forceRemoveAllCntaneirs($target): string
    {
        return 'docker rm -f $(docker ps -q -a)';
    }
}