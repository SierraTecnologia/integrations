<?php

namespace Integrations\Connectors;

use Illuminate\Database\Eloquent\Model;
use Log;
use App\Models\User;

use Integrations\Models\Token;

use Integrations\Connectors\Github\Github;
use Integrations\Connectors\Amazon\Amazon;
use Integrations\Connectors\Gitlab\Gitlab;
use Integrations\Connectors\Jira\Jira;
use Integrations\Connectors\Novare\Novare;
use Integrations\Connectors\Pipedrive\Pipedrive;
use Integrations\Connectors\Sentry\Sentry;
use Integrations\Connectors\Testlink\Testlink;
use Integrations\Connectors\Zoho\Zoho;
use Support\Components\Coders\Parser\ParseClass;
use Support\Utils\Debugger\ErrorHelper;
use Integrations\Models\Integration as IntegrationModel;
use ReflectionGenerator;
use Exception;
use Support\Utils\Extratores\ClasserExtractor;

class Connector
{

    protected $_connection = null;

    protected $_token = null;

    private $error = null;

    private $errorCode = null;

    public function __construct($token = false)
    {
        $this->_token = $token;
        $this->_connection = $this->getConnection($this->_token);
    }

    /**
     * Recupera connecção com a integração
     */
    public static function getPrimary()
    {
        return static::$ID;
    }

    /**
     * Recupera connecção com a integração
     */
    protected function getConnection($token = false)
    {
        return $this;
    }

    public function setError($errorMessage, $code = 0)
    {
        $this->error = $errorMessage;
        $this->errorCode = $code;

        
        var_dump($errorMessage);
        throw new \Exception($errorMessage);
    }

    public function getError()
    {
        return $this->error;
    }

    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * Recupera dados em cima de um get de uma api
     */
    public function get($path)
    {
        // @todo Fazer resultar um object em cia de um path
        $url = $this->url.$path;
        $result = [];
        return $result;
    }

    /**
     * Recupera dados em cima de um get de uma api
     */
    public static function getCodeForPrimaryKey()
    {
        $integration = IntegrationModel::createIfNotExistAndReturn(
            [
            'id' => static::$ID,
            'name' => ClasserExtractor::getClassName(static::class),
            'code' => static::class,
            ]
        );
        return $integration->id;
    }
    
    public static function registerAll()
    {
        $realPath = __DIR__.'/';
        
        collect(scandir($realPath))
            ->each(
                function ($item) use ($realPath) {
                    if (in_array($item, ['.', '..'])) { return;
                    }
                    if (is_dir($realPath . $item)) {
                        $modelName = __NAMESPACE__.'\\'.$item.'\\'.$item;
                   
                        IntegrationModel::createIfNotExistAndReturn(
                            [
                            'id' =>  call_user_func(array($modelName, 'getPrimary')),
                            'name' => ClasserExtractor::getClassName($modelName),
                            'code' => $modelName,
                            ]
                        );
                    }

                    if (is_file($realPath . $item) && $item!=='Connector.php') {
                        Log::channel('sitec-integrations')->warning(
                            ErrorHelper::tratarMensagem(
                                'Não deveria ter arquivo nessa pasta: '.$realPath . $item
                            )
                        );

                        try {
                            throw new Exception('Não deveria ter arquivo nessa pasta: '.$realPath . $item);
                        } catch(Exception $e) {
                            dd($e->getTrace(), $e->getMessage(), 'Deu Ruim Integrations');
                        }
                    
                    }
                }
            );
    }

}
