<?php

namespace App\Enums;

class TokenRole
{
    /**
     * Normal for login.
     */
    public const NORMAL = 'normal';

    /**
     * Token roles.
     */
    public const ROLES = [
        'normal' => self::NORMAL,
    ];
}
