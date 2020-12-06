<?php

namespace Integrations\Connectors\ExactSales;

use Illuminate\Database\Eloquent\Model;
use Log;
use App\Models\User;
use Integrations\Connectors\Connector;

class ExactSales extends Connector
{
    public static $ID = 33;
    protected function getConnection($token = false)
    {
        $token = 'xxxxxxxxxxxxxxxxxxxxxxxxxxx';
        return new Pipedrive($token);
    }

    // private $config;
	// private $curl;
	// private $token;
	// private $apiUrl = "api.spotter.exactsales.com.br/api/v2";
	// private $apiProcotol = "https://";

	// public function __construct($token)
	// {
	// 	$this->curl = new Curl();
	// 	$this->token = $token;
	// }

	// public function inserirLead($parameters, $validar_duplicidade = 1, $addcampospersonalizados = 0)
	// {
	// 	$this->curl->setOpt(CURLOPT_RETURNTRANSFER, TRUE);
	// 	$this->curl->setOpt(CURLOPT_HEADER, FALSE);
	// 	$this->curl->setOpt(CURLOPT_HTTPHEADER, array(
	// 			"Content-Type: application/json",
  	// 			"token_exact: ".$this->token
	// 		)
	// 	);
	// 	$url = $this->apiProcotol.$this->apiUrl."/leads?validar_duplicidade=".$validar_duplicidade."&addcampospersonalizados=".$addcampospersonalizados;
	// 	$this->curl->post($url, json_encode($parameters));
	// 	if ($this->curl->error)
    //         return $this->treatError();
    //     else
    //         return $this->treatSuccess($this->curl->response);
        
	// }

	// private function treatSuccess($response)
	// {
	// 	$response = json_decode($response, true);
	// 	return $response;
	// }

	// private function treatError()
    // {
    //     $message = array();
    //     $message['error'] = true;
    //     $message['error_code'] = $this->curl->error_code;
    //     $message['error_message'] = $this->curl->error_message;
    //     return json_encode($message);
    // }
}
