<?php

use App\Models\teachers;

test('confirm password screen can be rendered', function () {
    $teachers = teachers::factory()->create();

    $response = $this->actingAs($teachers)->get('/confirm-password');

    $response->assertStatus(200);
});

test('password can be confirmed', function () {
    $teachers = teachers::factory()->create();

    $response = $this->actingAs($teachers)->post('/confirm-password', [
        'password' => 'password',
    ]);

    $response->assertRedirect();
    $response->assertSessionHasNoErrors();
});

test('password is not confirmed with invalid password', function () {
    $teachers = teachers::factory()->create();

    $response = $this->actingAs($teachers)->post('/confirm-password', [
        'password' => 'wrong-password',
    ]);

    $response->assertSessionHasErrors();
});
