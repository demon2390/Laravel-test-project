<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

/**
 * @property string $id
 * @property string $name
 * @property string $path
 * @property string $method
 * @property string $user_id
 * @property string $body
 * @property Collection $headers
 * @property Collection $parameters
 * @property string $credential_id
 * @property string $service_id
 * @property null|CarbonInterface $created_at
 * @property null|CarbonInterface $updated_at
 * @property Credential $credential
 * @property Service $service
 */
class Check extends Model
{
    use HasFactory;
    use HasUlids;

    /** @var class-string<Model> */
    protected $model = Check::class;

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

    /** @return array<string,string|class-string> */
    protected function casts(): array
    {
        return [
            'body'       => 'json',
            'headers'    => AsCollection::class,
            'parameters' => AsCollection::class,
        ];
    }
}
