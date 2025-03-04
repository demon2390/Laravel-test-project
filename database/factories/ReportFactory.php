<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Check;
use App\Models\Report;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;

final class ReportFactory extends Factory
{
    /**
     * @var class-string<Model>
     */
    protected $model = Report::class;

    /**
     * @return array<string,mixed>
     */
    public function definition(): array
    {
        $randArray = [
            'header_size' => 212,
            'request_size' => 162,
            'filetime' => -1,
            'ssl_verify_result' => 0,
            'redirect_count' => 0,
            'total_time' => 0.451934,
            'namelookup_time' => 0.002497,
            'connect_time' => 0.003871,
            'pretransfer_time' => 0.228562,
            'size_upload' => 0.0,
            'size_download' => 1589.0,
            'speed_download' => 3516.0,
            'speed_upload' => 0.0,
            'download_content_length' => 1589.0,
            'upload_content_length' => 0.0,
            'starttransfer_time' => 0.451486,
            'redirect_time' => 0.0,
            'redirect_url' => '',
            'primary_ip' => '142.250.185.238',
            'certinfo' => [],
            'primary_port' => 443,
            'local_ip' => '172.19.0.3',
            'local_port' => 49856,
            'http_version' => 2,
            'protocol' => 2,
            'ssl_verifyresult' => 0,
            'scheme' => 'HTTPS',
            'appconnect_time_us' => 228491,
            'connect_time_us' => 3871,
            'namelookup_time_us' => 2497,
            'pretransfer_time_us' => 228562,
            'redirect_time_us' => 0,
            'starttransfer_time_us' => 451486,
            'total_time_us' => 451934,
            'effective_method' => 'GET',
            'capath' => '/etc/ssl/certs',
            'cainfo' => '/etc/ssl/certs/ca-certificates.crt',
            'appconnect_time' => 0.228491,
        ];

        return [
            'url' => $this->faker->url(),
            'content_type' => $this->faker->mimeType(),
            'http_code' => $this->faker->boolean(80) ? Response::HTTP_OK : Response::HTTP_INTERNAL_SERVER_ERROR,
            'data' => $randArray,
            'check_id' => Check::factory(),
            'started_at' => $start = Carbon::parse($this->faker->dateTimeThisMonth()),
            'finished_at' => $start->addSeconds($this->faker->numberBetween(0, 5)),
        ];
    }
}
