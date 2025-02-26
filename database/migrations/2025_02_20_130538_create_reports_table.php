<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\Response;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->ulid('id')->primary();

            $table->string('url');
            $table->string('content_type');
            $table->unsignedInteger('http_code')->default(Response::HTTP_OK);
            $table->json('data')->nullable();

            $table
                ->foreignUlid('check_id')
                ->index()
                ->constrained('checks')
                ->cascadeOnDelete();

            $table->timestamp('started_at');
            $table->timestamp('finished_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
