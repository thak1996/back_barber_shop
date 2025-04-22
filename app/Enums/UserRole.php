<?php

declare(strict_types=1);

namespace App\Enums;

enum UserRole: string
{
    case USER = 'user';
    case SHOP = 'shop';
    case ADMIN = 'admin';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match ($this) {
            self::USER => 'Cliente',
            self::SHOP => 'Barbearia',
            self::ADMIN => 'Administrador',
        };
    }

    public function isShop(): bool
    {
        return $this === self::SHOP;
    }

    public function isUser(): bool
    {
        return $this === self::USER;
    }

    public function isAdmin(): bool
    {
        return $this === self::ADMIN;
    }
}
