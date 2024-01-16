<?php

namespace Integrations\Tools;

use JJG\Ping as PingLib;

use Fabrica\Models\Infra\Computer;

/**
 * Ping Class
 * geerlingguy/ping
 *
 * @class Ping
 */
class Ping
{

    protected $host = false;

    public function __construct($host)
    {
        $this->host = $host;
    }

    public function getHost()
    {
        if (is_string($this->host)) {
            return $this->host;
        }
        return $this->host->host;
    }

    public function exec($ttl = 128, $timeOut = 60)
    {

        $ping = new PingLib($this->getHost());
        $ping->setTtl($ttl);
        $ping->setTimeout($timeOut);
        $latency = $ping->ping();
        if ($latency === false) {
            Log::notice('Servidor fora do ar: '.$this->getHost());
            return false;
        }

        Log::info('Servidor Online com Latencia: '.$latency);

        return $latency;
    }
}
