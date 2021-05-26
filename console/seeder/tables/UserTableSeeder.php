<?php

namespace console\seeder\tables;

use antonyz89\seeder\TableSeeder;
use console\seeder\DatabaseSeeder;
use common\models\User;

/**
 * Handles the creation of seeder `{{%user}}`.
 */
class UserTableSeeder extends TableSeeder
{
    /**
     * {@inheritdoc}
     */
    function run()
    {
        
        loop(function ($i) {
            $this->insert(User::tableName(), [
                'username' => $this->faker->text,
				'auth_key' => $this->faker->password(32),
				'password_hash' => $this->faker->sha256,
				'password_reset_token' => $this->faker->text,
				'email' => $this->faker->email,
				'verification_token' => $this->faker->text,
				'status' => $this->faker->numberBetween(0, 10),
				'created_at' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
				'updated_at' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            ]);
        }, DatabaseSeeder::USER_COUNT);
    }
}
