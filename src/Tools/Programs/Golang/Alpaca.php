<?php
/**
 * Api Libraries Powered And Created by Alpaca
 * 
 * https://github.com/pksunkara/alpaca
 */

class Alpaca
{
    protected $repositoryUrl = 'https://github.com/pksunkara/alpaca';

    /**
     * @return string[]
     *
     * @psalm-return array{0: '1.2'}
     */
    public function workInVersion(): array
    {
        return [
             '1.2'
        ];
    }

    public function installCommand(): string
    {
        return 'bash <(curl -s -S -L '.$this->repositoryUrl.')';
    }
}