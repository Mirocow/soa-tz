<?php

namespace console\seeder\tables;

use antonyz89\seeder\TableSeeder;
use console\seeder\DatabaseSeeder;
use common\models\User;
use common\models\BalanceHistory;

/**
 * Handles the creation of seeder `balance_history`.
 */
class BalanceHistoryTableSeeder extends TableSeeder
{
    /**
     * {@inheritdoc}
     */
    function run()
    {
        $users = User::find()->all();

        $balance = [];

        $now = date('Y-m-d', strtotime(date('Y-m-d') . ' - 20 day'));

        loop(function ($i) use ($users, &$balance, &$now) {
            $userId = $this->faker->randomElement($users)->id;
            $now = date('Y-m-d', strtotime($now . ' + 1 day'));
            while (($value = $this->faker->numberBetween(-100, 100)) != 0){
                break;
            }
            if(!isset($balance[$userId])){
                $balance[$userId] = 0;
            }
            $balance[$userId] += $value;
            $this->insert(BalanceHistory::tableName(), [
                'user_id' => $userId,
				'value' => $value,
				'balance' => $balance[$userId],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }, DatabaseSeeder::BALANCE_HISTORY_COUNT);
    }
}
