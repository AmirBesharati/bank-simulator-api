<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\TransactionType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    public function definition()
    {
        $accountsId = Account::pluck('id')->toArray();
        $transactionTypes = TransactionType::all()->pluck('id')->toArray();
        return [
            'transaction_type_id' => $this->faker->randomElement($transactionTypes) ,
            'sender_account_id' => $this->faker->randomElement($accountsId) ,
            'receiver_account_id' => $this->faker->randomElement($accountsId) ,
            'amount' => $this->faker->numberBetween(1000 , 2000000) ,
            'reference_code' => $this->faker->randomNumber(9) ,
        ];
    }
}
