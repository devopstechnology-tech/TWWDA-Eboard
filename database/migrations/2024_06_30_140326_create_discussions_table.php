<?php

use App\Enums\CloseEnum;
use App\Enums\ArchiveEnum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('discussions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('topic')->nullable();
            $table->longText('description')->nullable();
            $table->string('closestatus')->default(CloseEnum::Default->value);
            $table->string('archivestatus')->default(ArchiveEnum::Default->value);
            $table->string('user_id')->nullable(); // User who created the discussion
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discussions');
    }
};
