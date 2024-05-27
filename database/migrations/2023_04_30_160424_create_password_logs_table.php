<?php

declare(strict_types=1);

use App\Enums\ChangePasswordEnum;
use App\Enums\StatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('password_logs', function (Blueprint $table) {
            // $table->id();
            $table->uuid('id')->primary();
            $table->string('password');
            $table->string('start_date');
            $table->string('end_date')->nullable();
            $table->string('change_reason')->default(ChangePasswordEnum::New->value);
            $table->string('status')->default(StatusEnum::Active->value);
            $table->morphs('password_loggable');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['created_at', 'start_date', 'deleted_at']);

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('password_logs');
    }
};
