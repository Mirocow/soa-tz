<?php

namespace site\components;

use yii\base\InvalidConfigException;
use yii\httpclient\Response;

/**
 * Class JsonRpc
 *
 * @package site\components
 */
class JsonRpc
{
    public $version = '2.0';

    protected $requests = [];

    protected $responses = [];

    public function __construct($requests)
    {
        foreach ($requests as $count => $request){
            if(empty($request['method'])){
                throw new InvalidConfigException();
            }
            //$count = $request['id'] ?? $count;
            $request['jsonrpc'] = $this->version;
            $this->requests[$count] = (object) $request;
        }
    }

    /**
     * @param Response $response
     */
    public function setResponse(Response $response)
    {
        $items = $response->getData();
        foreach ($items as $count => $item){
            if(isset($item['result'])){
                $this->responses[$count] = (object) [
                    'method' => $this->requests[$count]->method,
                    'result' => $item['result'],
                ];
            }
        }
    }

    /**
     * @param $method
     *
     * @return array
     */
    public function getResultByMethod($method)
    {
        $responses = [];
        foreach ($this->responses as $response){
            if($response->method == $method) {
                $responses[] = $response->result;
            }
        }

        return count($responses) == 1? reset($responses): $responses;
    }

    /**
     * @return false|string
     */
    public function getRequest ()
    {
        return json_encode($this->requests);
    }
}