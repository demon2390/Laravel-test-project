<?php

declare(strict_types = 1);

namespace App\Enums;

enum CredentialType: string
{
    case Bearer_auth = 'Bearer-Auth';
    case Basic_auth = 'Basic-Auth';
    case Digest_auth = 'Digest-Auth';
}
