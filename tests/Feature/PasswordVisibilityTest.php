<?php

use App\Models\User;

test('login ofrece el botón para mostrar la contraseña', function () {
    $response = $this->get('/login');

    $response->assertOk();
    $response->assertSee('aria-label="Mostrar contraseña"', false);
    $response->assertSeeHtml('type="password"');
});

test('registro ofrece el botón en los dos campos de contraseña', function () {
    $response = $this->get('/register');

    $response->assertOk();
    $response->assertSeeHtmlInOrder([
        'aria-label="Mostrar contraseña"',
        'aria-label="Mostrar contraseña"',
    ]);
});

test('restablecer contraseña ofrece el botón en los dos campos', function () {
    $response = $this->get('/reset-password/token-de-prueba');

    $response->assertOk();
    $response->assertSeeHtmlInOrder([
        'aria-label="Mostrar contraseña"',
        'aria-label="Mostrar contraseña"',
    ]);
});

test('confirmar contraseña ofrece el botón', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/confirm-password');

    $response->assertOk();
    $response->assertSee('aria-label="Mostrar contraseña"', false);
});

test('el perfil ofrece el botón en sus tres campos de contraseña', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/profile');

    $response->assertOk();
    $response->assertSeeHtmlInOrder([
        'aria-label="Mostrar contraseña"',
        'aria-label="Mostrar contraseña"',
        'aria-label="Mostrar contraseña"',
    ]);
});
