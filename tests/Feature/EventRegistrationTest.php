<?php

namespace Tests\Feature;

use App\Models\EventModel;
use App\Models\EventRegistration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventRegistrationTest extends TestCase
{
    use RefreshDatabase;

    private function event(array $attributes = []): EventModel
    {
        return EventModel::create(array_merge([
            'name' => 'Festival Test',
            'slug' => 'festival-test-'.uniqid(),
            'description' => 'Event test',
            'start_date' => now()->addDay(),
            'end_date' => now()->addDays(2),
            'location' => 'Tanjungpinang',
            'is_registration_open' => true,
            'max_participants' => 10,
            'status' => 'upcoming',
        ], $attributes));
    }

    public function test_authenticated_user_can_register_once(): void
    {
        $user = User::create(['name' => 'Event Buyer', 'email' => 'event-buyer@example.test', 'password' => 'password', 'role' => 'buyer']);
        $event = $this->event();

        $response = $this->actingAs($user)->post(route('events.register', $event->id), [
            'name' => 'Event Buyer',
            'phone' => '08123456789',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('event_registrations', ['event_id' => $event->id, 'user_id' => $user->id, 'status' => 'pending']);

        $this->actingAs($user)->post(route('events.register', $event->id), [
            'name' => 'Event Buyer',
            'phone' => '08123456789',
        ])->assertSessionHas('error', 'Anda sudah terdaftar pada event ini.');

        $this->assertSame(1, EventRegistration::where('event_id', $event->id)->count());
    }

    public function test_guest_cannot_register_event(): void
    {
        $event = $this->event();

        $this->post(route('events.register', $event->id), [
            'name' => 'Guest',
            'phone' => '08123456789',
        ])->assertRedirect(route('login'));
    }

    public function test_registration_closed_event_is_rejected(): void
    {
        $user = User::create(['name' => 'Closed Event', 'email' => 'closed-event@example.test', 'password' => 'password', 'role' => 'buyer']);
        $event = $this->event(['is_registration_open' => false]);

        $this->actingAs($user)->post(route('events.register', $event->id), [
            'name' => 'Closed Event',
            'phone' => '08123456789',
        ])->assertSessionHas('error', 'Pendaftaran event ditutup.');

        $this->assertDatabaseCount('event_registrations', 0);
    }
}
