<?php

namespace App\Enums;

enum UserRole: string
{
    case SUPER_ADMIN = 'SuperAdmin';
    case ADMIN = 'Admin';
    case STAFF = 'Staff';

    public function label(): string
    {
        return match ($this) {
            self::SUPER_ADMIN => 'Super Admin',
            self::ADMIN => 'Admin',
            self::STAFF => 'Staff',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::SUPER_ADMIN => 'danger',
            self::ADMIN => 'warning',
            self::STAFF => 'info',
        };
    }
}
