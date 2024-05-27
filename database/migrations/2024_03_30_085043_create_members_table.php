<?php

declare(strict_types=1);

use App\Enums\PositionEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('memberable_id');
            $table->string('memberable_type');
            $table->string('user_id')->nullable();
            $table->string('board_id')->nullable();
            $table->string('committee_id')->nullable();
            $table->string('guest_id')->nullable();
            $table->string('position')->default(PositionEnum::Default->value);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
