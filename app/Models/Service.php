<?php

declare(strict_types = 1);

namespace App\Models;

use App\Observers\ServiceObserver;
use Carbon\CarbonInterface;
use Database\Factories\ServiceFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
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
 * @property string $url
 * @property string $user_id
 * @property null|CarbonInterface $created_at
 * @property null|CarbonInterface $updated_at
 * @property User $user
 * @property Collection<int,Check> $checks
 */
#[ObservedBy(classes: ServiceObserver::class)]
class Service extends Model
{
    /** @use HasFactory<ServiceFactory> */
    use HasFactory;
    use HasUlids;
    use SoftDeletes;

    /** @var array<int,string> */
    protected $fillable = [
        'name',
        'url',
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
            foreignKey: 'service_id',
        );
    }
}
