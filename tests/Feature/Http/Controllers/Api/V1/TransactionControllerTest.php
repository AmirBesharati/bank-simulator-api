<?php

namespace Tests\Feature\Http\Controllers\Api\V1;

use App\Events\AccountCreatedEvent;
use App\Models\Account;
use App\Models\Transaction;
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
            'account_number' => '102030',
            'amount' => 100,
            'note' => 'test'
        ];
    }

    /** @test */
    public function create_external_transaction()
    {
        //create 2 user
        $users = User::factory(2)->create();

        //get 2 user of created users
        $firstUser = $users->first();
        $secondUser = $users->last();


        //create account for first user
        event(new AccountCreatedEvent(Account::factory()->create([
            'user_id' => $firstUser,
        ])));


        event(new AccountCreatedEvent(Account::factory()->create([
            'user_id' => $secondUser,
        ])));


        //check account is created or not
        $this->assertTrue($firstUser->accounts()->count() == 1);
        $this->assertTrue($secondUser->accounts()->count() == 1);


        $this->actingAs($firstUser);


        $response = $this->post(route('api.v1.account.transaction.create', ['accountId' => $firstUser->accounts()->first()->id]),
            array_merge($this->transaction_data(), [
                'account_number' => $secondUser->accounts()->first()->number,
            ]));


        //check transaction sender and receiver
        $this->assertEquals($firstUser->accounts()->first()->id, Transaction::all()->last()->sender_account_id);
        $this->assertEquals($secondUser->accounts()->first()->id, Transaction::all()->last()->receiver_account_id);

        //check transaction type equals to external
        $this->assertEquals(Transaction::all()->last()->transaction_type_id, config('enums.transaction_types.EXTERNAL.id'));


        //check balance of accounts
        $balanceOfSender = $firstUser->accounts()->first()->accountType->start_balance - $this->transaction_data()['amount'];
        $balanceOfReceiver = $secondUser->accounts()->first()->accountType->start_balance + $this->transaction_data()['amount'];

        $this->assertEquals($balanceOfSender , $firstUser->accounts()->first()->balance);
        $this->assertEquals($balanceOfReceiver , $secondUser->accounts()->first()->balance);


        $response->assertStatus(200);
    }

    /** @test */
    public function create_internal_transaction()
    {
        //create 2 user
        $user = User::factory()->create();


        //create account for user
        event(new AccountCreatedEvent($account2 = Account::factory()->create([
            'user_id' => $user->id,
        ])));
        event(new AccountCreatedEvent($account1 = Account::factory()->create([
            'user_id' => $user->id,
        ])));


        //check account is created or not
        $this->assertTrue($user->accounts()->count() == 2);


        $this->actingAs($user);


        $response = $this->post(route('api.v1.account.transaction.create', ['accountId' => $account1->id]), array_merge($this->transaction_data(), [
            'account_number' => $account2->number,
        ]));


        //check transaction sender and receiver
        $this->assertEquals($account1->id, Transaction::all()->last()->sender_account_id);
        $this->assertEquals($account2->id, Transaction::all()->last()->receiver_account_id);

        //check transaction type equals to external
        $this->assertEquals(Transaction::all()->last()->transaction_type_id, config('enums.transaction_types.INTERNAL.id'));

        $response->assertStatus(200);
    }

    /** @test */
    public function a_user_should_be_authenticated()
    {

        //create 2 user
        $user = User::factory()->create();

        event(new AccountCreatedEvent($account = Account::factory()->create([
            'user_id' => $user->id,
        ])));

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-type' => 'application/json'
        ])->post(route('api.v1.account.transaction.create', ['accountId' => $account->id]),
            array_merge($this->transaction_data()));

        $response->assertUnauthorized();
    }

    /** @test */
    public function a_account_number_is_required_to_create_transaction()
    {
        //create 2 user
        $user = User::factory()->create();

        event(new AccountCreatedEvent($account = Account::factory()->create([
            'user_id' => $user->id,
        ])));

        $this->actingAs($user);

        $response = $this->post(route('api.v1.account.transaction.create', ['accountId' => $account->id]),
            array_merge($this->transaction_data(), ['account_number' => null]));

        $response->assertUnprocessable();
        $this->assertArrayHasKey('account_number', $response->json()['errors']);
    }

    /** @test */
    public function a_amount_is_required_to_create_transaction()
    {
        //create 2 user
        $user = User::factory()->create();

        event(new AccountCreatedEvent($account = Account::factory()->create([
            'user_id' => $user->id,
        ])));

        $this->actingAs($user);

        $response = $this->post(route('api.v1.account.transaction.create', ['accountId' => $account->id]),
            array_merge($this->transaction_data(), ['amount' => null])
        );


        $response->assertUnprocessable();
        $this->assertArrayHasKey('amount', $response->json()['errors']);
    }

    /** @test */
    public function a_sender_account_must_not_equals_to_receiver_account()
    {
        //create 2 user
        $user = User::factory()->create();


        //create account for user
        event(new AccountCreatedEvent($account1 = Account::factory()->create([
            'user_id' => $user->id,
        ])));


        //check account is created or not
        $this->assertTrue($user->accounts()->count() == 1);


        $this->actingAs($user);

        $response = $this->post(route('api.v1.account.transaction.create', ['accountId' => $account1->id]), array_merge($this->transaction_data(), [
            'account_number' => $account1->number,
        ]));

        $response->assertStatus(400);
    }

    /** @test */
    public function a_sender_account_should_have_enough_balance_to_do_transaction()
    {
        //create 2 user
        $users = User::factory(2)->create();


        //get 2 user of created users
        $firstUser = $users->first();
        $secondUser = $users->last();


        //create account for first user
        event(new AccountCreatedEvent(Account::factory()->create([
            'user_id' => $firstUser,
        ])));


        event(new AccountCreatedEvent(Account::factory()->create([
            'user_id' => $secondUser,
        ])));


        //check account is created or not
        $this->assertTrue($firstUser->accounts()->count() == 1);
        $this->assertTrue($secondUser->accounts()->count() == 1);


        $this->actingAs($firstUser);


        $response = $this->post(route('api.v1.account.transaction.create', ['accountId' => $firstUser->accounts()->first()->id]), array_merge($this->transaction_data(), [
            'account_number' => $secondUser->accounts()->first()->number,
            'amount' => $firstUser->accounts()->first()->balance + 10000,
        ]));


        $response->assertStatus(400);
    }

}
