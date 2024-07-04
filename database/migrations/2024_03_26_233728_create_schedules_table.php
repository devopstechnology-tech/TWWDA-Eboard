<?php

declare(strict_types=1);

use App\Enums\HeldEnum;
use App\Enums\CloseEnum;
use App\Enums\StatusEnum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('date')->nullable();
            $table->string('start_time')->nullable();
            $table->string('end_time')->nullable();
            $table->string('meeting_id')->nullable();
            $table->string('closestatus')->default(CloseEnum::Default->value);
            $table->string('status')->default(StatusEnum::Inactive->value);
            $table->string('heldstatus')->default(HeldEnum::Default->value);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
