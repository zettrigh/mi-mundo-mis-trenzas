<?php

namespace App\Enums;

enum AppointmentStatus: string
{
    case Pending = 'pending';
    case Confirmed = 'confirmed';
    case InProgress = 'in_progress';
    case Completed = 'completed';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pendiente',
            self::Confirmed => 'Confirmada',
            self::InProgress => 'En Camino / En Proceso',
            self::Completed => 'Completada',
            self::Cancelled => 'Cancelada',
        };
    }

    public function badgeClasses(): string
    {
        return match ($this) {
            self::Pending => 'bg-amber-100 text-amber-800 border-amber-300',
            self::Confirmed => 'bg-blue-100 text-blue-800 border-blue-300',
            self::InProgress => 'bg-purple-100 text-purple-800 border-purple-300',
            self::Completed => 'bg-emerald-100 text-emerald-800 border-emerald-300',
            self::Cancelled => 'bg-rose-100 text-rose-800 border-rose-300',
        };
    }
}
