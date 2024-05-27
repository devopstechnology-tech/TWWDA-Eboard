<?php

declare(strict_types=1);

use App\Enums\PublishEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('minutes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('meeting_id')->nullable();
            $table->string('board_id')->nullable();
            $table->string('committee_id')->nullable();
            $table->string('membership_id')->nullable();//author
            $table->string('status')->default(PublishEnum::Default->value);//published or unpublished
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('minutes');
    }
};
