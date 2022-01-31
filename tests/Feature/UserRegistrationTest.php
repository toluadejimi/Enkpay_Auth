<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can register user with right parameters', function () {
    $attributes = User::factory()->raw();
    $response = $this->postJson(route('auth.register'), $attributes);
    $response->assertStatus(201)->assertJson(['message' => 'Account created']);
    $this->assertDatabaseHas('users', Arr::only($attributes, ['last_name', 'first_name']));
});

it('does not register without a first_name field', function () {
    $attributes = Arr::except(User::factory()->raw(), ['first_name']);

    $response = $this->postJson(route('auth.register'), $attributes);
    $response->assertStatus(422);
});

it('does not register without a last_name field', function () {
    $attributes = Arr::except(User::factory()->raw(), ['last_name']);

    $response = $this->postJson(route('auth.register'), $attributes);
    $response->assertStatus(422);
});

it('does not register without a password field', function () {
    $attributes = Arr::except(User::factory()->raw(), ['password']);

    $response = $this->postJson(route('auth.register'), $attributes);
    $response->assertStatus(422);
});

it('does not register without a password confirmation field', function () {
    $attributes = Arr::except(User::factory()->raw(), ['password_confirmation']);

    $response = $this->postJson(route('auth.register'), $attributes);
    $response->assertStatus(422);
});
