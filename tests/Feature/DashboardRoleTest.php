<?php

use App\Enums\AppointmentStatus;
use App\Enums\UserRole;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;

test('home page is accessible and displays services', function () {
    $service = Service::create([
        'name' => 'Knotless Braids Test',
        'slug' => 'knotless-braids-test',
        'category' => 'Modernas',
        'description' => 'Servicio a domicilio de prueba.',
        'price' => 50.00,
        'estimated_duration_minutes' => 180,
        'is_active' => true,
    ]);

    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('Mi Mundo Mis Trenzas');
    $response->assertSee('Knotless Braids Test');
    $response->assertSee('50.00');
});

test('guests are redirected to login when accessing dashboard', function () {
    $response = $this->get('/dashboard');

    $response->assertRedirect('/login');
});

test('client sees client dashboard with booking form', function () {
    $client = User::factory()->create([
        'role' => UserRole::Client,
    ]);

    $service = Service::create([
        'name' => 'Box Braids Clásicas',
        'slug' => 'box-braids-clasicas',
        'category' => 'Tradicionales',
        'description' => 'Trenzas clásicas.',
        'price' => 40.00,
        'estimated_duration_minutes' => 200,
        'is_active' => true,
    ]);

    $response = $this->actingAs($client)->get('/dashboard');

    $response->assertStatus(200);
    $response->assertSee('Mi Espacio de Citas');
    $response->assertSee('Agendar Cita a Domicilio');
    $response->assertSee('Box Braids Clásicas');
});

test('stylist sees stylist dashboard with itinerary', function () {
    $stylist = User::factory()->create([
        'role' => UserRole::Stylist,
    ]);

    $response = $this->actingAs($stylist)->get('/dashboard');

    $response->assertStatus(200);
    $response->assertSee('Panel de Estilista a Domicilio');
    $response->assertSee('Agenda de Citas a Domicilio Asignadas');
});

test('admin sees admin dashboard with management metrics and controls', function () {
    $admin = User::factory()->create([
        'role' => UserRole::Admin,
    ]);

    $response = $this->actingAs($admin)->get('/dashboard');

    $response->assertStatus(200);
    $response->assertSee('Panel Administrativo');
    $response->assertSee('Todas las Citas a Domicilio');
    $response->assertSee('Estilistas a Domicilio');
});

test('client can book an at-home appointment', function () {
    $client = User::factory()->create([
        'role' => UserRole::Client,
    ]);

    $service = Service::create([
        'name' => 'Twists Senegaleses',
        'slug' => 'twists-senegaleses',
        'category' => 'Twists',
        'description' => 'Servicio a domicilio.',
        'price' => 45.00,
        'estimated_duration_minutes' => 150,
        'is_active' => true,
    ]);

    $scheduledAt = now()->addDays(2)->format('Y-m-d H:i:s');

    $response = $this->actingAs($client)->post('/appointments', [
        'service_id' => $service->id,
        'scheduled_at' => $scheduledAt,
        'address' => 'Av. Principal, Edificio El Roble, Apto 5-A',
        'zone' => 'Zona Norte',
        'client_phone' => '+58 412 9998877',
        'hair_details' => 'Deseo tono castaño claro',
        'notes' => 'Timbre funciona',
    ]);

    $response->assertRedirect('/dashboard');
    $response->assertSessionHas('status');

    $this->assertDatabaseHas('appointments', [
        'client_id' => $client->id,
        'service_id' => $service->id,
        'address' => 'Av. Principal, Edificio El Roble, Apto 5-A',
        'status' => AppointmentStatus::Pending->value,
    ]);
});

test('admin can assign stylist and update appointment status', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $client = User::factory()->create(['role' => UserRole::Client]);
    $stylist = User::factory()->create(['role' => UserRole::Stylist]);

    $service = Service::create([
        'name' => 'Fulani Braids',
        'slug' => 'fulani-braids',
        'category' => 'Étnicas',
        'description' => 'Trenzas Fulani.',
        'price' => 50.00,
        'estimated_duration_minutes' => 180,
        'is_active' => true,
    ]);

    $appointment = Appointment::create([
        'appointment_code' => 'TRZ-TEST01',
        'client_id' => $client->id,
        'service_id' => $service->id,
        'scheduled_at' => now()->addDay(),
        'status' => AppointmentStatus::Pending,
        'total_price' => $service->price,
        'address' => 'Calle 10, Casa 25',
        'client_phone' => '+58 414 0001122',
    ]);

    $response = $this->actingAs($admin)->patch("/appointments/{$appointment->id}/admin", [
        'stylist_id' => $stylist->id,
        'status' => AppointmentStatus::Confirmed->value,
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('appointments', [
        'id' => $appointment->id,
        'stylist_id' => $stylist->id,
        'status' => AppointmentStatus::Confirmed->value,
    ]);
});
