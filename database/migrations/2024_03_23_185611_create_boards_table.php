<?php

declare(strict_types=1);

use App\Enums\StatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('boards', function (Blueprint $table) {
            // $table->id();
            $table->uuid('id')->primary();
            $table->string('name')->nullable();
            $table->longText('description')->nullable();
            $table->string('icon')->nullable();
            $table->string('cover')->nullable();
            $table->string('status')->default(StatusEnum::Active->value);
            $table->string('owner_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boards');
    }
};