<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->ulid('id')->primary();

            $table->string('name');
            $table->string('url');

            $table
                ->foreignUlid('user_id')
                ->index()
                ->constrained('users')
                ->cascadeOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement('CREATE UNIQUE INDEX url_user_id_deleted_at ON services (url, user_id, deleted_at) WHERE deleted_at IS NOT NULL');
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
