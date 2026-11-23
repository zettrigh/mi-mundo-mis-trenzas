<?php

use App\Models\User;

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
    $response->assertSee('Cédula de Identidad');
    $response->assertSee('name="cedula"', false);
    $response->assertSee('pattern="[0-9]+"', false);
});

test('new users can register with valid fields and numeric cedula', function () {
    $response = $this->post('/register', [
        'name' => 'Valeria Morales',
        'cedula' => '24567890',
        'email' => 'valeria@example.com',
        'phone' => '+58 412 1234567',
        'address' => 'Av. Principal, Edif. Aurora, Apto 3-B',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));

    $this->assertDatabaseHas('users', [
        'email' => 'valeria@example.com',
        'cedula' => '24567890',
        'phone' => '+58 412 1234567',
    ]);
});

test('registration fails without cedula', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'cedula' => '',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertSessionHasErrors('cedula');
    $this->assertGuest();
});

test('registration fails with non-numeric cedula', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'cedula' => 'V-12345678',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertSessionHasErrors([
        'cedula' => 'La cédula de identidad solo debe contener números.',
    ]);
    $this->assertGuest();
});

test('registration fails with duplicate cedula', function () {
    User::factory()->create([
        'cedula' => '99999999',
    ]);

    $response = $this->post('/register', [
        'name' => 'Otro Usuario',
        'cedula' => '99999999',
        'email' => 'otro@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertSessionHasErrors('cedula');
    $this->assertGuest();
});

test('registration fails when name contains invalid characters', function () {
    $response = $this->post('/register', [
        'name' => 'Valeria123 <script>',
        'cedula' => '12345678',
        'email' => 'invalido@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertSessionHasErrors([
        'name' => 'El nombre completo solo debe contener letras, espacios y guiones.',
    ]);
    $this->assertGuest();
});

test('registration fails when phone contains invalid characters', function () {
    $response = $this->post('/register', [
        'name' => 'Valeria Morales',
        'cedula' => '12345678',
        'email' => 'telefono.malo@example.com',
        'phone' => '0412-TELEFONO-ABC',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertSessionHasErrors([
        'phone' => 'El teléfono solo debe contener números y signos válidos (+, -, espacios o paréntesis).',
    ]);
    $this->assertGuest();
});

test('registration fails when address contains invalid characters', function () {
    $response = $this->post('/register', [
        'name' => 'Valeria Morales',
        'cedula' => '12345678',
        'email' => 'direccion.mala@example.com',
        'address' => 'Av. Principal <script>alert("hack")</script>',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertSessionHasErrors([
        'address' => 'La dirección solo debe contener letras, números y caracteres habituales de dirección (., #, -, /, º, °).',
    ]);
    $this->assertGuest();
});

test('cedula is hidden from user serialization and not exposed on frontend views', function () {
    $user = User::factory()->create([
        'cedula' => '88888888',
    ]);

    // Model serialization check
    expect($user->toArray())->not->toHaveKey('cedula');
    expect(json_encode($user))->not->toContain('88888888');

    // Dashboard check
    $dashboardResponse = $this->actingAs($user)->get('/dashboard');
    $dashboardResponse->assertStatus(200);
    $dashboardResponse->assertDontSee('88888888');
    $dashboardResponse->assertDontSee('Cédula');

    // Profile check
    $profileResponse = $this->actingAs($user)->get('/profile');
    $profileResponse->assertStatus(200);
    $profileResponse->assertDontSee('88888888');
    $profileResponse->assertDontSee('Cédula');
});
