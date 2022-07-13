<?php

namespace Tests\Unit;

use App\Models\Account;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_have_multiple_account()
    {
        $user = User::factory()->create();

        Account::factory(10)->create();

        $this->assertTrue($user->accounts()->count() == 10);
    }
}
