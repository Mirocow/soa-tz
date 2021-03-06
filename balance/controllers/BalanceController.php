<?php

namespace balance\controllers;

use common\models\BalanceHistory;
use common\models\User;
use georgique\yii2\jsonrpc\exceptions\JsonRpcException;
use sizeg\jwt\JwtHttpBearerAuth;
use yii\filters\Cors;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class BalanceController extends Controller
{
    // Disable CSRF validation for JSON-RPC POST requests
    public $enableCsrfValidation = false;

    /**
     * Получить текущий баланс пользователя
     *
     * @return int[]
     */
    public function actionUserBalance()
    {
        $request = $this->request->getBodyParams();

        if(empty($request['user_id'])){
            throw new JsonRpcException();
        }

        if (($user = User::findOne($request['user_id'])) === null) {
            throw new NotFoundHttpException('The requested stream does not exist.');
        }

        return [
            'user_id' => $user->id,
            'balance' => $user->getBalance(),
        ];
    }

    /**
     * Получить историю платежных операций
     *
     * @return int[]
     */
    public function actionHistory()
    {
        $request = $this->request->getBodyParams();

        $limit = $request['limit'] ?? 50;

        $history = BalanceHistory::find()->orderBy(['id' => SORT_DESC])->limit($limit)->all();

        return [
            'items' => $history,
            'limit' => $limit,
        ];
    }

}
