<?php

namespace Tests\Feature\Http\Controllers\Api\V1;

use App\Models\Account;
use App\Models\AccountType;
use App\Models\User;
use App\Repositories\Contracts\AccountRepositoryInterface;
use Faker\Generator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Mockery;
use Tests\TestCase;

class AccountControllerTest extends TestCase
{
    use RefreshDatabase;


    private function account_data()
    {
        return [
            'account_type_id' => AccountType::all()->random()->id,
            'name' => 'test',
            'balance' => null ,
        ];
    }

    /** @test */
    public function deny_unauthenticated_to_create_account()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-type' => 'application/json'
        ])->post(route('api.v1.account.create', [
            'account_type_id' => AccountType::all()->random()->id,
            'name' => 'test',
            'balance' => null
        ]));

        $response->assertStatus(401);
    }

    /** @test */
    public function a_user_can_create_account()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->post(route('api.v1.account.create', $this->account_data()));

        $response->assertOk();

        $this->assertArrayHasKey('account', $response->json()['data']);
    }

    /** @test */
    public function a_name_is_required_to_create_account()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->post(route('api.v1.account.create', array_merge($this->account_data(), ['name' => null])));

        $response->assertUnprocessable();
    }

    /** @test */
    public function a_account_type_id_is_required_to_create_account()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->post(route('api.v1.account.create', array_merge($this->account_data(), ['account_type_id' => null])));

        $response->assertUnprocessable();
    }

    /** @test */
    public function avoid_create_account_with_not_existence_account_type_id()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->post(route('api.v1.account.create', array_merge($this->account_data(), ['account_type_id' => 1000])));

        $response->assertUnprocessable();
    }

    /** @test */
    public function a_balance_should_be_unsigned()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->post(route('api.v1.account.create', array_merge($this->account_data() , ['balance' => -100 ])));

        $response->assertUnprocessable();
    }

    /** @test */
    public function a_balance_can_be_double()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->post(route('api.v1.account.create', array_merge($this->account_data() , ['balance' => 1.5 ])));

        $this->assertArrayHasKey('account', $response->json()['data']);
    }

    /** @test */
    public function a_balance_must_equals_to_account_type_starting_balance()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->post(route('api.v1.account.create', array_merge($this->account_data() , ['balance' => null ])));

        $this->assertArrayHasKey('account', $response->json()['data']);

        $account = Account::first();

        $this->assertEquals($account->balance , $account->accountType->start_balance);
    }
}
