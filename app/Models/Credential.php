<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Database\Factories\CredentialFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $id
 * @property string $name
 * @property array<string,mixed> $metadata
 * @property string $user_id
 * @property null|CarbonInterface $created_at
 * @property null|CarbonInterface $updated_at
 * @property User $user
 * @property Collection<int,Check> $checks
 */
class Credential extends Model
{
    /** @use HasFactory<CredentialFactory> */
    use HasFactory;
    use HasUlids;
    use SoftDeletes;

    /** @var array<int,string> */
    protected $fillable = [
        'name',
        'metadata',
        'user_id',
    ];

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(
            related: User::class,
            foreignKey: 'user_id',
        );
    }

    /** @return HasMany<Check, $this> */
    public function checks(): HasMany
    {
        return $this->hasMany(
            related: Check::class,
            foreignKey: 'credential_id',
        );
    }

    /** @return array<string,string|class-string> */
    protected function casts(): array
    {
        return [
            'metadata' => 'encrypted:json',
        ];
    }
}
