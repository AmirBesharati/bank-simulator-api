<?php

namespace Database\Factories;

use App\Models\AccountType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $users = User::pluck('id')->toArray();
        $accountType = AccountType::all()->random();

        return [
            'user_id' => $this->faker->randomElement($users) ,
            'account_type_id' => $accountType->id ,
            'name' => $this->faker->name ,
            'balance' => $accountType->start_balance ,
            'number' => $this->faker->unique(true)->numberBetween(100000000, 999999999) ,
        ];
    }
}
