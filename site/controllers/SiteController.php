<?php

namespace site\controllers;

use http\Client\Request;
use site\components\JsonRpc;
use site\components\RpcJsonRequest;
use yii\base\BaseObject;
use yii\httpclient\Client;
use common\models\LoginForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class SiteController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $jsonRpc = new JsonRpc([
            ['method' => 'balance.user-balance', 'params' => ['user_id' => 1], 'id' => 1],
            ['method' => 'balance.history', 'params' => ['limit' => 50], 'id' => 2],
        ]);

        /** @var Client $client */
        $client = Yii::$app->get('api');
        $response = $client->createRequest()
                           ->setUrl('api')
                           ->addHeaders(['content-type' => 'application/json'])
                           ->setContent($jsonRpc->getRequest())
                           ->send();

        if (!$response->isOk) {
            throw new \Exception('Unable response.');
        }

        $jsonRpc->setResponse($response);

        $balance = $jsonRpc->getResultByMethod('balance.user-balance');
        $history = $jsonRpc->getResultByMethod('balance.history');

        return $this->render('index', [
            'userId' => $balance['user_id'],
            'balance' => $balance['balance'],
            'history' => $history['items'],
            'historyLimit' => $history['limit'],
        ]);
    }

}
