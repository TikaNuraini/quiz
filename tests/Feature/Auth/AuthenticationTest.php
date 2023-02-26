<?php

use App\Models\teachers;
use App\Providers\RouteServiceProvider;

test('login screen can be rendered', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('teacherss can authenticate using the login screen', function () {
    $teachers = teachers::factory()->create();

    $response = $this->post('/login', [
        'email' => $teachers->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(RouteServiceProvider::HOME);
});

test('teacherss can not authenticate with invalid password', function () {
    $teachers = teachers::factory()->create();

    $this->post('/login', [
        'email' => $teachers->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});
