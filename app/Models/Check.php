<?php

namespace App\Models;

use Carbon\CarbonInterface;
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
 * @property string $path
 * @property string $method
 * @property string $user_id
 * @property null|object $body
 * @property null|array $headers
 * @property null|array $parameters
 * @property null|string $credential_id
 * @property string $service_id
 * @property null|CarbonInterface $created_at
 * @property null|CarbonInterface $updated_at
 * @property null|Credential $credential
 * @property Service $service
 * @property Collection<Report> $report
 */
class Check extends Model
{
    use HasFactory;
    use HasUlids;
    use SoftDeletes;

    /** @var class-string<Model> */
    protected string $model = Check::class;

    /** @var array<int,string> */
    protected $fillable = [
        'name',
        'path',
        'method',
        'body',
        'headers',
        'parameters',
        'credential_id',
        'service_id',
    ];

    /** @return BelongsTo<Credential> */
    public function credential(): BelongsTo
    {
        return $this->belongsTo(
            related: Credential::class,
            foreignKey: 'credential_id'
        );
    }

    /** @return BelongsTo<Service> */
    public function service(): BelongsTo
    {
        return $this->belongsTo(
            related: Service::class,
            foreignKey: 'service_id'
        );
    }

    /** @return HasMany<Report> */
    public function reports(): HasMany
    {
        return $this->hasMany(
            related: Report::class,
            foreignKey: 'check_id'
        );
    }

    /** @return array<string,string|class-string> */
    protected function casts(): array
    {
        return [
            'body'       => 'json',
            'headers'    => 'array',
            'parameters' => 'array',
        ];
    }
}
