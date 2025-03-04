<?php

declare(strict_types=1);

namespace App\Enums;

enum CacheKeys: string
{
    case USER_SERVICES = 'user_services';
    case SERVICE = 'service';
}
