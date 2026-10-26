<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppointmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_lists_appointments(): void
    {
        $firstAppointment = $this->createAppointment();
        $this->createAppointment();

        $this->getJson('/api/appointments')
            ->assertOk()
            ->assertJsonCount(2)
            ->assertJsonFragment(['id' => $firstAppointment->id]);
    }

    public function test_it_creates_an_appointment(): void
    {
        $user = User::factory()->create();

        $this->postJson('/api/appointments', $this->appointmentData($user))
            ->assertCreated()
            ->assertJsonPath('name', 'Consultation');

        $this->assertDatabaseHas('appointments', [
            'name' => 'Consultation',
            'user_id' => $user->id,
        ]);
    }

    public function test_it_validates_appointment_creation(): void
    {
        $this->postJson('/api/appointments', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'name',
                'appointment_number',
                'appointment_time',
                'price',
                'phone_number',
                'user_id',
            ]);
    }

    public function test_it_shows_the_requested_appointment(): void
    {
        $appointment = $this->createAppointment(['name' => 'Requested']);

        $this->getJson("/api/appointments/{$appointment->id}")
            ->assertOk()
            ->assertJsonPath('id', $appointment->id)
            ->assertJsonPath('name', 'Requested')
            ->assertJsonPath('user', $appointment->user->name);
    }

    public function test_it_updates_an_appointment(): void
    {
        $appointment = $this->createAppointment();

        $this->patchJson("/api/appointments/{$appointment->id}", [
            'name' => 'Updated consultation',
        ])
            ->assertOk()
            ->assertJsonPath('name', 'Updated consultation');

        $this->assertDatabaseHas('appointments', [
            'id' => $appointment->id,
            'name' => 'Updated consultation',
        ]);
    }

    public function test_it_deletes_an_appointment(): void
    {
        $appointment = $this->createAppointment();

        $this->deleteJson("/api/appointments/{$appointment->id}")
            ->assertNoContent();

        $this->assertDatabaseMissing('appointments', ['id' => $appointment->id]);
    }

    private function appointmentData(User $user): array
    {
        return [
            'name' => 'Consultation',
            'appointment_number' => 'APT-100',
            'appointment_time' => '2026-11-01 10:00:00',
            'price' => 50,
            'phone_number' => '555-0100',
            'user_id' => $user->id,
        ];
    }

    private function createAppointment(array $overrides = []): Appointment
    {
        $user = User::factory()->create();

        return Appointment::create(array_merge($this->appointmentData($user), $overrides));
    }
}
