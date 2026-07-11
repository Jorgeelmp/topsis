<?php

namespace App\Enums;

enum RolesEnum: string
{
    case CLIENT = 'client';
    case PROFESSIONAL = 'professional';
    case ADMIN = 'admin';

    public function label(): string
    {
        return match($this) {
            self::CLIENT => 'Cliente',
            self::PROFESSIONAL => 'Profissional',
            self::ADMIN => 'Administrador',
        };
    }
}
