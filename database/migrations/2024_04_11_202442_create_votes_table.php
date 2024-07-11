<?php

declare(strict_types=1);

use App\Enums\VoteEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('option_id')->nullable();
            $table->string('poll_id')->nullable();
            $table->string('assginee_poll_id')->nullable();
            $table->string('date')->nullable();
            $table->string('status')->default(VoteEnum::Default->value);//signed or unsigned
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};
