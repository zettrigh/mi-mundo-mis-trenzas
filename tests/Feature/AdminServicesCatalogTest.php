<?php

use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;

beforeEach(function () {
    $this->admin = User::factory()->admin()->create();
});

/**
 * Siembra doce servicios "Trenza X" con created_at escalonado:
 * Trenza Doce es el más reciente y Trenza Uno el más antiguo.
 */
function sembrarCatalogoDeDoce(): void
{
    $nombres = ['Trenza Uno', 'Trenza Dos', 'Trenza Tres', 'Trenza Cuatro', 'Trenza Cinco', 'Trenza Seis', 'Trenza Siete', 'Trenza Ocho', 'Trenza Nueve', 'Trenza Diez', 'Trenza Once', 'Trenza Doce'];

    Service::factory()
        ->count(12)
        ->sequence(fn (Sequence $sequence) => [
            'name' => $nombres[$sequence->index],
            'created_at' => now()->subMinutes(12 - $sequence->index),
        ])
        ->create();
}

test('el catálogo pagina de a seis y ordena por lo más reciente por defecto', function () {
    sembrarCatalogoDeDoce();

    $response = $this->actingAs($this->admin)->get('/dashboard');

    $response->assertOk();
    $response->assertSee('Catálogo de Servicios de Trenzado (12)');
    $response->assertSeeInOrder(['Trenza Doce', 'Trenza Once', 'Trenza Diez', 'Trenza Nueve', 'Trenza Ocho', 'Trenza Siete']);
    $response->assertDontSee('Trenza Uno');
    $response->assertDontSee('Trenza Seis');
});

test('la segunda página muestra los seis servicios más antiguos', function () {
    sembrarCatalogoDeDoce();

    $response = $this->actingAs($this->admin)->get('/dashboard?page=2');

    $response->assertOk();
    $response->assertSeeInOrder(['Trenza Seis', 'Trenza Cinco', 'Trenza Cuatro', 'Trenza Tres', 'Trenza Dos', 'Trenza Uno']);
    $response->assertDontSee('Trenza Doce');
});

test('ordena el catálogo por precio en ambas direcciones conservando el orden al paginar', function () {
    $nombres = ['Trenza Uno', 'Trenza Dos', 'Trenza Tres', 'Trenza Cuatro', 'Trenza Cinco', 'Trenza Seis', 'Trenza Siete', 'Trenza Ocho', 'Trenza Nueve', 'Trenza Diez', 'Trenza Once', 'Trenza Doce'];

    Service::factory()
        ->count(12)
        ->sequence(fn (Sequence $sequence) => [
            'name' => $nombres[$sequence->index],
            'price' => ($sequence->index + 1) * 10,
        ])
        ->create();

    $ascendente = $this->actingAs($this->admin)->get('/dashboard?orden=precio&direccion=asc');

    $ascendente->assertOk();
    $ascendente->assertSeeInOrder(['Trenza Uno', 'Trenza Dos', 'Trenza Tres', 'Trenza Cuatro', 'Trenza Cinco', 'Trenza Seis']);
    $ascendente->assertDontSee('Trenza Doce');

    $descendente = $this->actingAs($this->admin)->get('/dashboard?orden=precio&direccion=desc');

    $descendente->assertOk();
    $descendente->assertSeeInOrder(['Trenza Doce', 'Trenza Once', 'Trenza Diez', 'Trenza Nueve', 'Trenza Ocho', 'Trenza Siete']);
    $descendente->assertDontSee('Trenza Uno');

    // withQueryString(): la paginación conserva orden y dirección elegidos.
    $segundaPagina = $this->actingAs($this->admin)->get('/dashboard?page=2&orden=precio&direccion=desc');

    $segundaPagina->assertOk();
    $segundaPagina->assertSeeInOrder(['Trenza Seis', 'Trenza Cinco', 'Trenza Cuatro', 'Trenza Tres', 'Trenza Dos', 'Trenza Uno']);
});

test('ordena el catálogo por nombre alfabéticamente en ambas direcciones', function () {
    Service::factory()->create(['name' => 'Knotless Braids']);
    Service::factory()->create(['name' => 'Box Braids']);
    Service::factory()->create(['name' => 'Fulani Braids']);
    Service::factory()->create(['name' => 'Cornrows']);

    $ascendente = $this->actingAs($this->admin)->get('/dashboard?orden=nombre&direccion=asc');

    $ascendente->assertOk();
    $ascendente->assertSeeInOrder(['Box Braids', 'Cornrows', 'Fulani Braids', 'Knotless Braids']);

    $descendente = $this->actingAs($this->admin)->get('/dashboard?orden=nombre&direccion=desc');

    $descendente->assertOk();
    $descendente->assertSeeInOrder(['Knotless Braids', 'Fulani Braids', 'Cornrows', 'Box Braids']);
});

test('filtra el catálogo por estado activos e inactivos', function () {
    Service::factory()->create(['name' => 'Knotless Activo']);
    Service::factory()->create(['name' => 'Cornrows Activo']);
    Service::factory()->inactive()->create(['name' => 'Fulani Inactivo']);
    Service::factory()->inactive()->create(['name' => 'Box Braids Inactivo']);

    $activos = $this->actingAs($this->admin)->get('/dashboard?estado=activos');

    $activos->assertOk();
    $activos->assertSee('Catálogo de Servicios de Trenzado (2)');
    $activos->assertSee('Knotless Activo');
    $activos->assertSee('Cornrows Activo');
    $activos->assertDontSee('Fulani Inactivo');
    $activos->assertDontSee('Box Braids Inactivo');

    $inactivos = $this->actingAs($this->admin)->get('/dashboard?estado=inactivos');

    $inactivos->assertOk();
    $inactivos->assertSee('Catálogo de Servicios de Trenzado (2)');
    $inactivos->assertSee('Fulani Inactivo');
    $inactivos->assertSee('Box Braids Inactivo');
    $inactivos->assertDontSee('Knotless Activo');
    $inactivos->assertDontSee('Cornrows Activo');

    $todos = $this->actingAs($this->admin)->get('/dashboard?estado=todos');

    $todos->assertOk();
    $todos->assertSee('Catálogo de Servicios de Trenzado (4)');
    $todos->assertSee('Knotless Activo');
    $todos->assertSee('Fulani Inactivo');
});

test('los parámetros inválidos caen al orden y filtro por defecto', function () {
    Service::factory()->create(['name' => 'Trenza Alfa']);
    Service::factory()->inactive()->create(['name' => 'Trenza Beta']);
    Service::factory()->create(['name' => 'Trenza Gamma']);

    $response = $this->actingAs($this->admin)->get('/dashboard?orden=inyeccion&direccion=lateral&estado=invisibles');

    $response->assertOk();
    $response->assertSee('Catálogo de Servicios de Trenzado (3)');
    $response->assertSeeInOrder(['Trenza Gamma', 'Trenza Beta', 'Trenza Alfa']);
    $response->assertSee('value="reciente" selected', false);
});
