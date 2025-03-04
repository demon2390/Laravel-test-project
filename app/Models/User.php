<?php

namespace App\Models;

//use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\CarbonInterface;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property null|CarbonInterface $email_verified_at
 * @property null|CarbonInterface $created_at
 * @property null|CarbonInterface $updated_at
 * @property Collection<int,Service> $services
 * @property Collection<int,Credential> $credentials
 */
class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<UserFactory> */
    use HasFactory;
    use Notifiable;
    use HasUlids;
    use SoftDeletes;

    /** @var array<int,string> */
    protected $fillable = [
        'name',
        'email',
        'password',
        'remember_token',
        'email_verified_at',
    ];

    /** @var array<int,string> */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /** @return HasMany<Service, $this> */
    public function services(): HasMany
    {
        return $this->hasMany(
            related: Service::class,
            foreignKey: 'user_id',
        );
    }

    /** @return HasMany<Credential, $this> */
    public function credentials(): HasMany
    {
        return $this->hasMany(
            related: Credential::class,
            foreignKey: 'user_id',
        );
    }

    /** @return array<string,string> */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }
}
