<?php

use App\Enums\AppointmentStatus;
use App\Enums\UserRole;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use Carbon\CarbonInterface;

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
    $response->assertSeeInOrder([
        'Citas Totales',
        'Pendientes',
        'Canceladas',
        'Ganancias',
    ]);
});

test('admin dashboard cards show weekly revenue in usd and bolivares resetting on monday', function () {
    config()->set('services.bcv.usd_rate', 60.00);

    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $client = User::factory()->create(['role' => UserRole::Client]);
    $stylist = User::factory()->create(['role' => UserRole::Stylist]);
    $service = Service::create([
        'name' => 'Knotless Braids Express',
        'slug' => 'knotless-braids-express',
        'category' => 'Modernas',
        'description' => 'Trenzas Knotless express a domicilio.',
        'price' => 50.00,
        'estimated_duration_minutes' => 180,
        'is_active' => true,
    ]);

    $startOfWeek = now()->startOfWeek(CarbonInterface::MONDAY);

    // Cita completada en la semana en curso (lunes a domingo) -> debe sumarse
    Appointment::create([
        'appointment_code' => 'TRZ-CURRWK',
        'client_id' => $client->id,
        'stylist_id' => $stylist->id,
        'service_id' => $service->id,
        'scheduled_at' => $startOfWeek->copy()->addHours(10),
        'status' => AppointmentStatus::Completed,
        'total_price' => 50.00,
        'address' => 'Zona Este',
        'client_phone' => '+58 412 1111111',
        'completed_at' => $startOfWeek->copy()->addHours(12),
    ]);

    // Cita completada en la semana previa (antes del lunes 00:00) -> NO debe sumarse
    Appointment::create([
        'appointment_code' => 'TRZ-PREVWK',
        'client_id' => $client->id,
        'stylist_id' => $stylist->id,
        'service_id' => $service->id,
        'scheduled_at' => $startOfWeek->copy()->subDays(2),
        'status' => AppointmentStatus::Completed,
        'total_price' => 70.00,
        'address' => 'Zona Oeste',
        'client_phone' => '+58 412 2222222',
        'completed_at' => $startOfWeek->copy()->subDays(2),
    ]);

    // Cita cancelada
    Appointment::create([
        'appointment_code' => 'TRZ-CANCEL',
        'client_id' => $client->id,
        'stylist_id' => null,
        'service_id' => $service->id,
        'scheduled_at' => $startOfWeek->copy()->addDays(2),
        'status' => AppointmentStatus::Cancelled,
        'total_price' => 50.00,
        'address' => 'Zona Norte',
        'client_phone' => '+58 412 3333333',
        'cancellation_reason' => 'Cliente reprogramó',
    ]);

    // Cita pendiente
    Appointment::create([
        'appointment_code' => 'TRZ-PENDING',
        'client_id' => $client->id,
        'stylist_id' => null,
        'service_id' => $service->id,
        'scheduled_at' => $startOfWeek->copy()->addDays(3),
        'status' => AppointmentStatus::Pending,
        'total_price' => 50.00,
        'address' => 'Zona Centro',
        'client_phone' => '+58 412 4444444',
    ]);

    $response = $this->actingAs($admin)->get('/dashboard');

    $response->assertStatus(200);

    // Valida orden exacto de los 4 cards
    $response->assertSeeInOrder([
        'Citas Totales',
        'Pendientes',
        'Canceladas',
        'Ganancias',
    ]);

    // Valida ganancias semanales en USD ($50.00) y en Bs. (50 * 60 = 3.000,00)
    $response->assertSee('$50.00');
    $response->assertSee('3.000,00');
    $response->assertSee('Resetea lunes 00:00');
    $response->assertSee('Tasa: 60,00 Bs/$');
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

test('booking appointment rejects corrupt or sql injection inputs with regex', function () {
    $client = User::factory()->create(['role' => UserRole::Client]);
    $service = Service::create([
        'name' => 'Box Braids Clásicas',
        'slug' => 'box-braids-clasicas',
        'category' => 'Tradicionales',
        'description' => 'Servicio a domicilio.',
        'price' => 45.00,
        'estimated_duration_minutes' => 180,
        'is_active' => true,
    ]);

    $response = $this->actingAs($client)->post('/appointments', [
        'service_id' => $service->id,
        'scheduled_at' => now()->addDays(2)->format('Y-m-d H:i:s'),
        'address' => "Av. Principal'; DROP TABLE appointments; -- <script>",
        'zone' => 'Zona <script>alert(1)</script>',
        'client_phone' => '0412-HACK-SQL',
        'hair_details' => 'SELECT * FROM users WHERE admin = 1; <script>',
        'notes' => 'DELETE FROM services; <script>',
    ]);

    $response->assertSessionHasErrors(['address', 'zone', 'client_phone', 'hair_details', 'notes']);
});

test('cancelling appointment and reviews reject corrupt inputs with regex', function () {
    $client = User::factory()->create(['role' => UserRole::Client]);
    $service = Service::create([
        'name' => 'Trenzas Fulani',
        'slug' => 'trenzas-fulani',
        'category' => 'Étnicas',
        'description' => 'Servicio a domicilio.',
        'price' => 50.00,
        'estimated_duration_minutes' => 180,
        'is_active' => true,
    ]);

    $appointment = Appointment::create([
        'appointment_code' => 'TRZ-RVW01',
        'client_id' => $client->id,
        'service_id' => $service->id,
        'scheduled_at' => now()->addDay(),
        'status' => AppointmentStatus::Pending,
        'total_price' => $service->price,
        'address' => 'Av. San Martín, Edif. Centro, Apto 1',
        'client_phone' => '+58 412 1234567',
    ]);

    // Prueba cancelación con caracteres corruptos / inyección
    $cancelResponse = $this->actingAs($client)->patch("/appointments/{$appointment->id}/cancel", [
        'cancellation_reason' => "Motivo corrupto <script>alert('xss')</script> ; DROP TABLE;",
    ]);
    $cancelResponse->assertSessionHasErrors('cancellation_reason');

    // Cambiar estado a completada para probar reseña
    $appointment->update(['status' => AppointmentStatus::Completed]);

    // Prueba reseña con rating no entero o comentario con inyección
    $reviewResponse = $this->actingAs($client)->post("/appointments/{$appointment->id}/reviews", [
        'rating' => '5; DROP TABLE;',
        'comment' => "Excelente servicio <script>malicioso();</script> ' OR 1=1;",
    ]);
    $reviewResponse->assertSessionHasErrors(['rating', 'comment']);
});
