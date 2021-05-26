<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = 'Balance';
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Баланс пользователя: <?= $userId?></p>

    <div class="row">
        <div class="col-lg-5">
            Баланс: <?= $balance?>
        </div>
    </div>

    <br>

    <div class="row">
        <p>Последние <?= $historyLimit?> платежей</p>

        <div class="col-lg-5">
            <?= var_dump($history)?>
        </div>
    </div>
</div>