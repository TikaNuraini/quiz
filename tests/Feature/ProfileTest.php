<?php

namespace Tests\Feature;

use App\Models\teachers;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_is_displayed(): void
    {
        $teachers = teachers::factory()->create();

        $response = $this
            ->actingAs($teachers)
            ->get('/profile');

        $response->assertOk();
    }

    public function test_profile_information_can_be_updated(): void
    {
        $teachers = teachers::factory()->create();

        $response = $this
            ->actingAs($teachers)
            ->patch('/profile', [
                'name' => 'Test teachers',
                'email' => 'test@example.com',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $teachers->refresh();

        $this->assertSame('Test teachers', $teachers->name);
        $this->assertSame('test@example.com', $teachers->email);
        $this->assertNull($teachers->email_verified_at);
    }

    public function test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged(): void
    {
        $teachers = teachers::factory()->create();

        $response = $this
            ->actingAs($teachers)
            ->patch('/profile', [
                'name' => 'Test teachers',
                'email' => $teachers->email,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $this->assertNotNull($teachers->refresh()->email_verified_at);
    }

    public function test_teachers_can_delete_their_account(): void
    {
        $teachers = teachers::factory()->create();

        $response = $this
            ->actingAs($teachers)
            ->delete('/profile', [
                'password' => 'password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/');

        $this->assertGuest();
        $this->assertNull($teachers->fresh());
    }

    public function test_correct_password_must_be_provided_to_delete_account(): void
    {
        $teachers = teachers::factory()->create();

        $response = $this
            ->actingAs($teachers)
            ->from('/profile')
            ->delete('/profile', [
                'password' => 'wrong-password',
            ]);

        $response
            ->assertSessionHasErrors('password')
            ->assertRedirect('/profile');

        $this->assertNotNull($teachers->fresh());
    }
}
