<?php

namespace Tests\Feature\Http\Controllers\Api\V1;

use App\Models\User;
use Faker\Generator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationControllerTest extends TestCase
{
    use RefreshDatabase;

    private function login_data()
    {
        return [
            'email' => 'amirbesharati59@gmail.com' ,
            'password' => '12345@#Amir' ,
        ];
    }

    private function register_data()
    {
        return [
            'email' => 'amirbesharati59@gmail.com' ,
            'name' => 'amir' ,
            'password' => '12345@#Amir' ,
            'password_confirmation' => '12345@#Amir'
        ];
    }

    /** @test */
    public function a_user_can_register()
    {
        $response = $this->json('POST' , route('api.v1.auth.register') , $this->register_data());

        $users = User::all();

        $this->assertCount(1 , $users);

        $response->assertOk();
    }

    /** @test */
    public function a_email_is_required_to_register()
    {
        $response = $this->json('POST' , route('api.v1.auth.register') , array_merge($this->register_data() , ['email' => '']));
        $response->assertUnprocessable();
    }

    /** @test */
    public function a_name_is_required_to_register()
    {
        $response = $this->json('POST' , route('api.v1.auth.register') , array_merge($this->register_data() , ['name' => '']));
        $response->assertUnprocessable();
    }

    /** @test */
    public function a_password_is_required_to_register()
    {
        $response = $this->json('POST' , route('api.v1.auth.register') , array_merge($this->register_data() , ['password' => '']));
        $response->assertUnprocessable();
    }

    /** @test */
    public function a_password_confirmation_is_required_to_register()
    {
        $response = $this->json('POST' , route('api.v1.auth.register') , array_merge($this->register_data() , ['password_confirmation' => '']));
        $response->assertUnprocessable();
    }

    /** @test */
    public function a_user_can_login()
    {
        //register user
        $this->json('POST' , route('api.v1.auth.register') , $this->register_data());

        //login user
        $response = $this->json('POST' , route('api.v1.auth.login') , $this->login_data());

        $response->assertOk();


        $this->assertArrayHasKey('token' , $response->json()['data']);
    }

    /** @test */
    public function a_email_is_required_to_login()
    {
        $response = $this->json('POST' , route('api.v1.auth.login') , array_merge($this->register_data() , ['email' => '']));
        $response->assertUnprocessable();
    }

    /** @test */
    public function a_password_is_required_to_login()
    {
        $response = $this->json('POST' , route('api.v1.auth.login') , array_merge($this->register_data() , ['password' => '']));
        $response->assertUnprocessable();
    }


}
