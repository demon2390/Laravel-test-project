<?php

declare(strict_types=1);

namespace App\Models;

use App\Observers\ReportObserver;
use Carbon\CarbonInterface;
use Database\Factories\ReportFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $id
 * @property string $url
 * @property string $content_type
 * @property int $status_code
 * @property array<string,mixed>|null $data
 * @property Check $check
 * @property CarbonInterface $started_at
 * @property CarbonInterface $finished_at
 */
#[ObservedBy(classes: ReportObserver::class)]
final class Report extends Model
{
    /** @use HasFactory<ReportFactory> */
    use HasFactory;
    use HasUlids;

    /**
     * @var array<int,string>
     */
    protected $fillable = [
        'url',
        'content_type',
        'status_code',
        'data',
        'check_id',
        'started_at',
        'finished_at',
    ];

    /**
     * @return BelongsTo<Check, $this>
     */
    public function check(): BelongsTo
    {
        return $this->belongsTo(
            related: Check::class,
            foreignKey: 'check_id'
        );
    }

    /**
     * @return array<string,string>
     */
    protected function casts(): array
    {
        return [
            'status' => 'integer',
            'data' => 'json',
            'started_at' => 'datetime',
            'finished_at' => 'datetime',
        ];
    }
}
