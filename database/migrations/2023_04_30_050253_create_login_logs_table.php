<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('login_logs', function (Blueprint $table) {
            // $table->id();
            $table->uuid('id')->primary();
            $table->string('ip_address')->nullable();
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
            $table->string('browser')->nullable();
            $table->string('device')->nullable();
            $table->string('version')->nullable();
            $table->string('os')->nullable();
            $table->string('isRobot')->nullable();
            $table->string('languages')->nullable();
            $table->text('other')->nullable();
            $table->string('login_loggable_type')->nullable();
            $table->string('login_loggable_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['created_at', 'deleted_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('login_logs');
    }
};