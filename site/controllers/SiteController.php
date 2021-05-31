<?php

namespace site\controllers;

use site\components\JsonRpc;
use yii\httpclient\Client;
use Yii;
use yii\web\Controller;

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
                           ->setUrl('json-rpc')
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
