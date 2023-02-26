<?php

use App\Models\teachers;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;

test('email verification screen can be rendered', function () {
    $teachers = teachers::factory()->create([
        'email_verified_at' => null,
    ]);

    $response = $this->actingAs($teachers)->get('/verify-email');

    $response->assertStatus(200);
});

test('email can be verified', function () {
    $teachers = teachers::factory()->create([
        'email_verified_at' => null,
    ]);

    Event::fake();

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $teachers->id, 'hash' => sha1($teachers->email)]
    );

    $response = $this->actingAs($teachers)->get($verificationUrl);

    Event::assertDispatched(Verified::class);
    expect($teachers->fresh()->hasVerifiedEmail())->toBeTrue();
    $response->assertRedirect(RouteServiceProvider::HOME.'?verified=1');
});

test('email is not verified with invalid hash', function () {
    $teachers = teachers::factory()->create([
        'email_verified_at' => null,
    ]);

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $teachers->id, 'hash' => sha1('wrong-email')]
    );

    $this->actingAs($teachers)->get($verificationUrl);

    expect($teachers->fresh()->hasVerifiedEmail())->toBeFalse();
});
