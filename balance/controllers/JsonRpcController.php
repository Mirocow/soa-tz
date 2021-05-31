<?php

namespace balance\controllers;

use \georgique\yii2\jsonrpc\Controller;

class JsonRpcController extends Controller
{
    // Disable CSRF validation for JSON-RPC POST requests
    public $enableCsrfValidation = false;

    /**
     * @var int $paramsPassMethod Defines method to pass params to the target action.
     */
    public $paramsPassMethod = self::JSON_RPC_PARAMS_PASS_BODY;

    public $noAuthActions = [];

}
