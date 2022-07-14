<?php

namespace Tests\Feature\Http\Controllers\Api\V1;

use App\Models\Account;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransactionControllerTest extends TestCase
{
    use RefreshDatabase;

    public function transaction_data()
    {
        return [
            'account_number' => '102030' ,
            'amount' => 100 ,
            'note' => 'test'
        ];
    }

    /** @test */
    public function create_external_transaction()
    {
        $this->withoutExceptionHandling();

        //create 2 user
        $users = User::factory(2)->create();

        //get 2 user of created users
        $firstUser = $users->first();
        $secondUser = $users->last();


        //create account for first user
        Account::factory()->create([
            'user_id' => $firstUser ,
        ]);

        //create account for second user
        Account::factory()->create([
            'user_id' => $secondUser ,
        ]);


        //check account is created or not
        $this->assertTrue($firstUser->accounts()->count() == 1);
        $this->assertTrue($secondUser->accounts()->count() == 1);


        $this->actingAs($firstUser);


        $response = $this->post(route('api.v1.account.transaction.create' , ['accountId' => $firstUser->accounts()->first()->id]) ,  array_merge($this->transaction_data() , [
            'account_number' => $secondUser->accounts()->first()->number ,
        ]));

        //check transaction


        $response->assertStatus(200);
    }

    public function a_destination_account_should_exists()
    {
        //create 2 user
        $user = User::factory()->create();

        //create account for first user
        Account::factory()->create([
            'user_id' => $user ,
        ]);

        $response = $this->post(route('api.v1.account.transaction.create') , $this->transaction_data());

        $response->assertUnprocessable();
    }

}
