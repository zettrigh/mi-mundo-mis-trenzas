<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case Stylist = 'stylist';
    case Client = 'client';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Administradora',
            self::Stylist => 'Estilista a Domicilio',
            self::Client => 'Cliente',
        };
    }
}
