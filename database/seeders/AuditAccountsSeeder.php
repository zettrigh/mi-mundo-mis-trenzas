<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AuditAccountsSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Contraseña compartida por las cuentas de auditoría y pruebas.
     * Cambiar aquí modifica las tres cuentas a la vez.
     */
    private const SHARED_PASSWORD = 'password';

    /**
     * Crea las cuentas dedicadas de auditoría y pruebas, una por cada rol
     * del sistema, con la misma contraseña hasheada individualmente.
     */
    public function run(): void
    {
        $auditAccounts = [
            [
                'name' => 'Auditor Administrador',
                'email' => 'auditor.admin@mimundotrenzas.com',
                'role' => UserRole::Admin,
                'phone' => '+58 414 0000001',
                'address' => 'Cuenta de auditoría - Acceso completo al sistema',
                'bio' => 'Cuenta de auditoría y pruebas con rol de Administradora (acceso completo).',
            ],
            [
                'name' => 'Auditor Estilista',
                'email' => 'auditor.estilista@mimundotrenzas.com',
                'role' => UserRole::Stylist,
                'phone' => '+58 424 0000002',
                'address' => 'Cuenta de auditoría - Cobertura a domicilio',
                'bio' => 'Cuenta de auditoría y pruebas con rol de Estilista a Domicilio.',
            ],
            [
                'name' => 'Auditor Cliente',
                'email' => 'auditor.cliente@mimundotrenzas.com',
                'role' => UserRole::Client,
                'phone' => '+58 412 0000003',
                'address' => 'Cuenta de auditoría - Cliente de prueba',
                'bio' => 'Cuenta de auditoría y pruebas con rol de Cliente.',
            ],
        ];

        foreach ($auditAccounts as $auditAccount) {
            $auditUser = User::firstOrCreate(
                ['email' => $auditAccount['email']],
                [
                    'name' => $auditAccount['name'],
                    'password' => Hash::make(self::SHARED_PASSWORD),
                    'role' => $auditAccount['role'],
                    'phone' => $auditAccount['phone'],
                    'address' => $auditAccount['address'],
                    'bio' => $auditAccount['bio'],
                    'is_active' => true,
                ]
            );

            // El modelo declara email_verified_at fuera del fillable
            // (#[Fillable] en User), por lo que la verificación se aplica
            // por fuerza explícita para que las cuentas puedan acceder
            // al panel sin esperar un correo.
            if (is_null($auditUser->email_verified_at)) {
                $auditUser->forceFill(['email_verified_at' => now()])->save();
            }
        }
    }
}
